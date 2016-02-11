#!/usr/bin/php

<?php
$percorso_relativo = "./";
$prefix = "/var/www/vhosts/albopretorio/";

$len_prefix = strlen($prefix);
include ($percorso_relativo."include.inc.php");

$mail_to      = 'mproietti@provincia.prato.it';
$mail_subject = 'Albo Pretorio - Notifiche';
$mail_subject_error = 'Albo Pretorio - ERRORI';

$mail_headers = 'From: webmaster@provincia.prato.it' . "\r\n" .
    'Reply-To: webmaster@provincia.prato.it' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();


/*
 * Config e chiamo DB *******************************
 */
require_once ($percorso_relativo.'class/ConfigSingleton.php');
$cfg = SingletonConfiguration::getInstance ();
require_once ($percorso_relativo."class/Db.php");
$factory=DbAbstractionFactory::getFactory($cfg->getValue('AstrazioneDB'));
$factory->setDsn($cfg->getValue('DSN'));
$db=$factory->createInstance();

$factory2=DbAbstractionFactory::getFactory($cfg->getValue('AstrazioneDB2'));
$factory2->setDsn($cfg->getValue('DSN2'));
$db2=$factory2->createInstance();
//********************************************************

require_once './class/Albo.php';
require_once './class/Area.php';
require_once './class/Tipo.php';
require_once './class/File.php';
require_once './class/Tipo_determina.php';
require_once './class/Tipo_trasp.php';

$sql2 = "SELECT
			albi.id_albo, albi.nr_atto
			FROM
			albi
			WHERE
			albi.id_tipo = 3
			AND YEAR(albi.dt_atto) = '".substr($argv[2],0,4)."'
			AND albi.dt_atto <> '".$argv[2]."'
		AND
		albi.nr_atto = ".$argv[1].";";


//error_log($sql2);
$rs2 = $db2->query($sql2); 
$nr_atti_esportati = $rs2->numRows();

error_log("Numero righe = ".$nr_atti_esportati);

if ($nr_atti_esportati > 0) {



$nr_atto = 0;

while ($row2 = $rs2->fetchRow(DB_FETCHMODE_ASSOC)) {
	if (DB::isError($row2)) {
    	$mail_message = "Attenzione ERRORE di importazione nel Albo Pretorio. \n 
						Problema nell'esecuzione della seguente query:\n 
						".$sql2;
		mail($mail_to, $mail_subject_error, $mail_message, $mail_headers); 
		throw new Exception('Errore nella select per la visualizzazione degli albi pretori nel DB'); 
		die($rs2->getMessage());
  	}
	else {
		
		if (($row2['tipologia'] == "principale") AND ($row2['num_atto'] != $nr_atto)){
			
			$nr_atto = $row2['num_atto'];
			$ARRAY_obj_files = array();
			$i = 0;		
			//Unici tipi possibili x gli "Atti Confezionati" = "principale" sono .pdf
			$estensione_destinazione = ".pdf";
			
			$cartella_dest = $prefix."files/";
			// il 3 sta a significare Determina Dirigenziale (v. Tipi)
			// tipologia distingue se � il file principale o un allegato
			// se kind_id == 0 allora il documento NON � riservato
			if ($row2['kind_id'] == 0) {
				$nome_file_dest_finale = $row2['data']."-".$row2['num_atto']."-3-".$row2['tipologia'].$estensione_destinazione;
				$percorso_dest_finale = $cartella_dest.$nome_file_dest_finale;
				
				if (!copy("/var/www/vhosts/albopretorio/files_albo_nfs/".$row2['nome_file'], $percorso_dest_finale)) {
					$mail_message = "Fallita la copia del file /var/www/vhosts/albopretorio/files_albo_nfs/".$row2['nome_file']." -> ".$percorso_dest_finale;
					mail($mail_to, $mail_subject, $mail_message, $mail_headers);
					error_log("Fallita la copia del file /var/www/vhosts/albopretorio/files_albo_nfs/".$row2['nome_file']." -> ".$percorso_dest_finale);
				}
				//sposto il file
				//rename("/var/www/vhosts/albopretorio/files_albo_nfs/".$row2['nome_file'], $percorso_dest_finale);
			}
			else {
				$nome_file_dest_finale = 'riservato.pdf';
				$percorso_dest_finale = $cartella_dest.$nome_file_dest_finale;
			}
			
			$ARRAY_obj_files[$i] = new File(substr($percorso_dest_finale, 34));
			//$ARRAY_obj_files[$i] = new File($percorso_dest_finale); 
			$i++;
			
			$albo = new Albo();
			$tipo = new Tipo();
			$area = new Area();

$tipo_determina = new Tipo_determina();
$tipo_trasp = new Tipo_Trasp();

$tipo_determina->setId_tipo_determina("NULL");
$tipo_determina->setTipo_determina("NULL");

//$tipo_trasp->setId_tipo_trasp("0");
//$tipo_trasp->setTipo_trasp($tipo_trasp->getTipoTraspFromIdTipoTrasp($tipo_trasp->getId_tipo_trasp()));
$tipo_trasp->setId_tipo_trasp("NULL");
$tipo_trasp->setTipo_trasp("NULL");

$albo->setTipo_determina($tipo_determina);
$albo->setTipo_trasp($tipo_trasp);
$albo->setSpesa_prevista("NULL");

			
			$albo->setARRAY_files($ARRAY_obj_files);
			
			$albo->setDt_atto($row2['data']);
			//$albo->setDt_pubblicaz_dal(date('Y-m-d',strtotime($row2['data'])));
			$albo->setDt_pubblicaz_dal(date('Y-m-d'));
			//$albo->setDt_pubblicaz_al(date('Y-m-d', strtotime("+15 days", strtotime($row2['data']))));
			$albo->setDt_pubblicaz_al(date('Y-m-d', strtotime("+15 days", strtotime(date('Y-m-d')))));
			//error_log(date('Y-m-d',strtotime($row2['data'])));
			//error_log(date('Y-m-d', strtotime("+15 days", strtotime($row2['data']))));
			$albo->setNr_atto($row2['num_atto']);
			$albo->setOggetto(mysql_real_escape_string($row2['oggetto']));
			$albo->setAutorita_emanante($row2['autorita_emanante']);
			$albo->setDa_validare("N");
			
			$tipo->setId_tipo("3");
			$tipo->setTipo($tipo->getTipoFromIdTipo($tipo->getId_tipo()));
			$albo->setTipo($tipo);
			
			//Query x associare le aree corrette
			$sql = "SELECT *
					from aree
					where 
	 (RIGHT(aree.area, (LENGTH(aree.area) - 6)))  LIKE '%".mysql_real_escape_string(substr($row2['areariferimento'], 6))."%'
					AND
					aree.attivo ='S'";
			
			$rs = $db->query($sql); 
			$nr_aree_corrispondenti = $rs->numRows();
			
			if ($nr_aree_corrispondenti <> 1) {
				echo "<p><strong>Attenzione!</strong> Errore di ambiguit� 
					per la verifica dell'area corrispondente.
					Si e' verificato un errore durante
						l'esecuzione della query <br> \"$sql\"."; 
					throw new Exception('Errore nella select per la visualizzazione degli albi pretori nel DB'); 
					die($rs->getMessage());
			}
			if (DB::isError($rs)) {
			    	echo "<p><strong>Attenzione!</strong>Si e' verificato un errore durante
						l'esecuzione della query <br> \"$sql\"."; 
					throw new Exception('Errore nella select per la visualizzazione degli albi pretori nel DB'); 
					die($rs->getMessage());
			}
			
			while ($row = $rs->fetchRow(DB_FETCHMODE_ASSOC)) {
				if (DB::isError($row)) {
			    	echo "<p><strong>Attenzione!</strong>Si e' verificato un errore durante
						l'esecuzione della query \"$sql\"."; 
					$result = FALSE;
					throw new Exception('Errore nella select per la visualizzazione degli albi pretori nel DB'); 
					die($rs->getMessage());
					//die($rs->getMessage());
			  	}
				else {
					
	
					$area->setId_area($row['id_area']);
					$area->setArea($area->getAreaFromIdArea($area->getId_area()));
					$area->setResponsabile($area->getRespFromIdArea($area->getId_area()));
	
					$albo->setArea($area);
					
					echo "CREA!!";
					 		
					$risultato = $albo->creaNelDB();
					if ($risultato==FALSE) {
						die("Errore nella registrazione del documento sul DB");
					}
					else {
					//	echo $albo;
					$albo->serializzaNelDB();
					}
					 
				}
			}
			
		}
		//se il file non � il principale ma � un allegato....
		elseif (($row2['num_atto'] == $nr_atto) AND ($row2['kind_id'] == 0)) {
			
			//Tutti i tipi sono possibili!
			$cartella_dest = $prefix."files/";
			// il 3 sta a significare Determina Dirigenziale (v. Tipi)
			$filename = strtolower($row2['nome_file']);
			$filename = preg_replace("/[^a-z0-9s.]/", "_", $filename);
			//error_log($filename);
			$nome_file_dest_finale = $row2['data']."-".$row2['num_atto']."-3-".$row2['tipologia']."-".$filename;
			$percorso_dest_finale = $cartella_dest.$nome_file_dest_finale;
			
			if (!copy("/var/www/vhosts/albopretorio/files_albo_nfs/".$row2['nome_file'], $percorso_dest_finale)) {
					$mail_message = "Fallita la copia del file /var/www/vhosts/albopretorio/files_albo_nfs/".$row2['nome_file']." -> ".$percorso_dest_finale;
					mail($mail_to, $mail_subject, $mail_message, $mail_headers);
					error_log("Fallita la copia del file /var/www/vhosts/albopretorio/files_albo_nfs/".$row2['nome_file']." -> ".$percorso_dest_finale);
			}
			
			$ARRAY_obj_files[$i] = new File(substr($percorso_dest_finale, 34));

			$i++;
			
			$albo->setARRAY_files($ARRAY_obj_files);
			
			//echo "cancello tutti i file";
			$albo->CancellaTuttiFileDalDB();
			
			//echo "AGGiorno albo sul db e (prima) inserisco i file nel db!!";
		
			$risultato = $albo->aggiornaNelDB();
	
			if ($risultato==FALSE) {
				die("Errore nella registrazione del documento sul DB");
			}
			else {
				$albo->serializzaNelDB();
			}
			
		}			
	}
}


}
else {
error_log("Atto nr.".$argv[1]." del ".$argv[2]." NOn importabile xche formato da 0 RIGHE!!!\n\n");
}

?>
