#!/usr/bin/php

<?php

/**
 * Created by PhpStorm.
 * User: mproietti
 * Date: 01/10/14
 * Time: 13.39
 */
//phpinfo();


/**
 * File definitivo per la migrazione del DB del protocollo su FS
 * 09/01/2015
 */

$percorso_relativo = "./";
include ($percorso_relativo."include.inc.php");

/**
 * la destinazione dei file deve essere montata su nfs in modo che sia condivisa fra applicazi
 * del protocollo e albo pretorio quindi deve andara sulla macchina DB (24)
 */
//$destinazione_files = "/data/file_atti/";

//Metto una dir di TEST
// TODO: Attenzione!!! questa dir deve essere quella del DB e quella connessa in NFS sul www!!!
//$destinazione_files = "/var/www/html/albopretorio//migrazione/data/file_atti/";
$destinazione_files_locale = "/var/www/html/albopretorio//migrazione/data/file_atti/";
$destinazione_files_db = "/var/albo_data/file_atti/";

//assegno i permessi - quindi il comando deve essere lanciato da linea di comando con privilegi di root
system("/bin/chmod -R 777 ".$destinazione_files_locale);

//non ricordo perchè ho settato questa directory quindi la setto altrove
//$prefix = "/var/www/migrazione/";
//$prefix = "/var/www/html/albopretorio/migrazione/";
//$len_prefix = strlen($prefix);

$mail_to      = 'mproietti@provincia.prato.it';
$mail_subject = 'Migrazione';
$mail_subject_error = 'Migrazione - ERRORI';

$mail_headers = 'From: webmaster@provincia.prato.it' . "\r\n" .
	'Reply-To: webmaster@provincia.prato.it' . "\r\n" .
	'X-Mailer: PHP/' . phpversion();


/*
 * Config e chiamo DB *******************************
 */
require_once ($percorso_relativo.'class/ConfigSingleton.php');
$cfg = SingletonConfiguration::getInstance ();
require_once ($percorso_relativo."class/Db.php");
//$factory=DbAbstractionFactory::getFactory($cfg->getValue('AstrazioneDB'));
//$factory->setDsn($cfg->getValue('DSN'));
//$db=$factory->createInstance();

$factory2=DbAbstractionFactory::getFactory($cfg->getValue('AstrazioneDB2'));
$factory2->setDsn($cfg->getValue('DSN2'));
$db2=$factory2->createInstance();
//********************************************************

echo $cfg->getValue('AstrazioneDB2');
echo $cfg->getValue('DSN2');

require_once './class/Albo.php';
require_once './class/Area.php';
require_once './class/Tipo.php';
require_once './class/File.php';
require_once './class/Tipo_determina.php';
require_once './class/Tipo_trasp.php';

$sql2 = "SELECT
 		registrazione.history_id as hd,
		documento_info.id_documento as iddoc,
		documento_info.content_type as ct,
		documento_info.nome_file as nf,
		documenti.file as blob_id,
		documenti.kind as kind,
		documenti.size as size
		FROM registrazione
		INNER JOIN registrazione_documento ON registrazione.id_registrazione = registrazione_documento.id_registrazione
		INNER JOIN documenti ON registrazione_documento.id_documento = documenti.id_doc
		INNER JOIN documento_info ON documenti.id_doc = documento_info.id_documento
		WHERE documento_info.tipo_documento='MIME'
		ORDER BY hd
		-- LIMIT 400000 OFFSET 48000
		LIMIT 1000 OFFSET 0;";

$rs2 = $db2->query($sql2);
$nr_file_da_trattare = $rs2->numRows();
$nr_fatti = 0;
echo "Da trattare: ".$nr_file_da_trattare."<br>";

//formato csv del log warning x loggare i file con estensione <> content type
$log_warning = "history_id; iddoc; content_type; nome_file; ext_by_ct; ct_by_nomefile \n";

while ($row2 = $rs2->fetchRow(DB_FETCHMODE_ASSOC)) {
	if (DB::isError($row2)) {
		$mail_message = "Attenzione ERRORE di migrazione su FS. \n
							Problema nell'esecuzione della seguente query:\n
							".$sql2;
		mail($mail_to, $mail_subject_error, $mail_message, $mail_headers);
		throw new Exception('Errore nella select per la di migrazione su FS');
		die($rs2->getMessage());
	}
	else {
		//se kind = 0 può essere un documento qualsiasi di qualsiasi formato
		if ($row2['kind'] == 0) {

			//trovo il formato del file controllando PRIMA il nome file, se ho una estensione valida
			//altrimenti controllo il content type
			//inoltre DEVO loggare il riferimento ai file il cui nome file è diverso dal content type corretto

			//eseguo il controllo sull'estensione del nome_file
			//devo usare questa tecnica perchè potrei avere estensioni doppie
			echo "NF = ".$row2['nf']."\n";
			$ext_tmp = "";
			$parts = pathinfo($row2['nf']);
			while ($parts['extension'] == 'p7m') {
				$ext_tmp = ".".$parts['extension'];
				$parts = pathinfo($parts['filename']);
			}
			$ext2 = $parts['extension'] .$ext_tmp;
			// se non inizia con un punto (.) lo metto io
			if ($ext2{0} <> ".") {
				$ext2 = ".".$ext2;
			}


			//$ext2 = ".".pathinfo($row2['nf'], PATHINFO_EXTENSION);
			//$ext2 = ".".$ext2;
			echo $ext2."\n";

			//eseguo il controllo sul content type
			switch ($row2['ct']) {
				case "image/bmp":
					$ext = '.bmp';
					break;
				case "application/msword":
					$ext = '.doc';
					break;
				case "application/vnd.openxmlformats-officedocument.wordprocessingml.document":
					$ext = '.docx';
					break;
				case "text/html":
					$ext = '.htm';
					break;
				case "image/jpeg":
					$ext = '.jpg';
					break;
				case "message/rfc822":
					$ext = '.mht';
					break;
				case "application/x-msg":
					$ext = '.msg';
					break;
				case "application/vnd.oasis.opendocument.spreadsheet":
					$ext = '.ods';
					break;
				case "application/vnd.oasis.opendocument.text":
					$ext = '.odt';
					break;
				case "application/pkcs7-mime":
					$ext = cerca_ext_p7m($row2['nf']);
					break;
				case "application/pdf":
					$ext = '.pdf';
					break;
				case "application/rtf":
					$ext = '.rtf';
					break;
				case "text/plain":
					$ext = '.txt';
					break;
				case "application/vnd.ms-excel":
					$ext = '.xls';
					break;
				case "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet":
					$ext = '.xlsx';
					break;
				case "application/xml":
					$ext = '.xml';
					break;
				case "application/vnd.ms-xpsdocument":
					$ext = '.xps';
					break;
				case "application/zip":
					$ext = '.zip';
					break;
				default:
					echo "NO EXTENSION!!!";
					error_log("NO EXTENSION!!!");
			}

			/**
			 *TODO: ATTENZIONE se il content type fosse application/pkcs7 (errato perchè la forma corretta è
			 *application/pkcs7-mime) e il nome file fosse vuoto succede un CASINO!
			 *Occorre modificare il db del protocollo PRIMA di eseguire questo script
			 */



			//se il controllo sul nome file è diverso da quello del content type devo loggare il risultato
			if (($ext <> $ext2) AND ($ext2 <> ".")) {
				//eseguo il log
				$log_warning = $log_warning.$row2['hd'].";".$row2['iddoc'].";".$row2['ct'].";".$row2['nf'].";".$ext.";".$ext2.";"."\n";
				//se diverse (e il nome file è presente) vince l'estensione del nome_file
				$ext = $ext2;
			}
			//se il nome_file è vuoto loggo il risultato
			if ($row2['nf'] == "") {
				//eseguo il log
				$log_warning = $log_warning.$row2['hd'].";".$row2['iddoc'].";".$row2['ct'].";".$row2['nf'].";".$ext.";".$ext2.";"."\n";
			}


			//hd = history_id
			// il percorso finale (da registrare nel db è:
			// $history_migliaia / $history_id / $id_documento . $ext
			$history_migliaia = substr($row2['hd'], 0, -3);
			$history = $row2['hd'];
			$directory = $history_migliaia."/".$history."/";

			//commentato - fa la stessa cosa ma meno descrittiva
			//$directory = substr($row2['hd'], 0, -3);
			//$directory.= "/".$row2['hd']."/";

			//creo la directory di destinazione collegando la directory di destinazione generale
			// con quella specifica dell'atto che sto trattando e assegno i permessi
			if (!is_dir($destinazione_files_locale.$directory)) {
				mkdir($destinazione_files_locale.$directory, 0777, true);
				system("/bin/chmod -R 777 ".$destinazione_files_locale.$directory);
			}

			//è il percorso relativo con il nome file e l'estensione
			$nome_file_completo = $directory.$row2['iddoc'].$ext;

			//è il percorso COMPLETO e il corretto nome file e estensione
			$nome_file_finale_locale = $destinazione_files_locale.$nome_file_completo;
			$nome_file_finale_db = $destinazione_files_db.$nome_file_completo;

			//se il file non esiste lo estraggo
			if (!file_exists ( $nome_file_finale_locale )) {

				$sql3 = "SELECT lo_export(".$row2['blob_id'].", '".$nome_file_finale_db."')
					FROM documenti
					WHERE
					documenti.id_doc = ".$row2['iddoc']."
					AND
					documenti.kind = 0;";
				//error_log($sql3."<br>\n");
				//echo $sql3;

				$rs3 = $db2->query($sql3);



				if (DB::isError($row3)) {
					echo "Attenzione ERRORE di lo_export estrazione del file dal DB. \n
								Problema nell'esecuzione della seguente query:\n
								".$sql3;
					//mail($mail_to, $mail_subject_error, $mail_message, $mail_headers);
					throw new Exception('Errore lo_export estrazione del file dal DB');
					die($rs3->getMessage());
				}

				$row3 = $rs3->fetchRow(DB_FETCHMODE_ASSOC);

				//The 1 returned by lo_export() indicates a successful export.
				if ($row3['lo_export'] <> 1) {
					echo "Attenzione ERRORE nella funzione lo_export. \n
								Problema nell'esecuzione della seguente query:\n
								".$sql3;
					//mail($mail_to, $mail_subject_error, $mail_message, $mail_headers);
					throw new Exception('Errore funzione lo_export');
					die($rs3->getMessage());
				}
			}
			else {
				//controllo sulla dimensione del file se esiste
				if (filesize($nome_file_finale_locale) == 0) {
					echo "Attenzione - dimensione errata su file ".$nome_file_finale_locale. "\n";
					echo filesize($nome_file_finale_locale)." - ".$row2['size']."\n";

				}
			}
		}
		//kind = 1 - sono tutti file ODT e devono terminare con _1.odt
		else {
			$history_migliaia = substr($row2['hd'], 0, -3);
			$history = $row2['hd'];
			$directory = $history_migliaia."/".$history."/";

			//creo la directory di destinazione collegando la directory di destinazione generale
			// con quella specifica dell'atto che sto trattando e assegno i permessi
			if (!is_dir($destinazione_files_locale.$directory)) {
				mkdir($destinazione_files_locale.$directory, 0777, true);
				system("/bin/chmod -R 777 ".$destinazione_files_locale.$directory);
			}

			//è il percorso relativo con il nome file e l'estensione
			$nome_file_completo = $directory.$row2['iddoc']."_1.odt";

			//è il percorso COMPLETO e il corretto nome file e estensione
			$nome_file_finale_locale = $destinazione_files_locale.$nome_file_completo;
			$nome_file_finale_db = $destinazione_files_db.$nome_file_completo;


			if (!file_exists ( $nome_file_finale_locale )) {
				$sql3 = "SELECT lo_export(".$row2['blob_id'].", '".$nome_file_finale_db."')
					FROM documenti
					WHERE
					documenti.id_doc = ".$row2['iddoc']."
					AND
					documenti.kind = 1;";


				$rs3 = $db2->query($sql3);
				$row3 = $rs3->fetchRow(DB_FETCHMODE_ASSOC);
				if (DB::isError($row3)) {
					echo "Attenzione ERRORE di lo_export estrazione del file dal DB kind 1. \n
								Problema nell'esecuzione della seguente query:\n
								".$sql3;
					//mail($mail_to, $mail_subject_error, $mail_message, $mail_headers);
					throw new Exception('Errore lo_export estrazione del file dal DB');
					die($rs3->getMessage());
				}
				//The 1 returned by lo_export() indicates a successful export.
				if ($row3['lo_export'] <> 1) {
					echo "Attenzione ERRORE nella funzione lo_export. kind 1. \n
								Problema nell'esecuzione della seguente query:\n
								".$sql3;
					//mail($mail_to, $mail_subject_error, $mail_message, $mail_headers);
					throw new Exception('Errore funzione lo_export');
					die($rs3->getMessage());
				}

			}
			else {
				//controllo sulla dimensione del file se esiste
				if (filesize($nome_file_finale_locale) == 0) {
					echo "Attenzione - dimensione errata su file ".$nome_file_finale_locale. "\n";
					echo filesize($nome_file_finale_locale)." - ".$row2['size']."\n";

				}
			}
		}
	}

	$nr_fatti++;
	if (($nr_fatti % 1000) == 0) {
		echo date("H:i:s")."  -->  ";
		echo "FATTI = ".$nr_fatti."\n";
	}
	
}

echo "FATTI = ".$nr_fatti."\n";

$myfile = fopen($destinazione_files_locale."log.csv", "w") or die("Unable to open file!");
fwrite($myfile, $log_warning);
fclose($myfile);
//echo $log_warning;

?>

