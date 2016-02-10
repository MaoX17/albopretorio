#!/usr/bin/php
<?php
$percorso_relativo = "./";
$prefix = "/var/www/vhosts/albopretorio/";
$len_prefix = strlen($prefix);
include ($percorso_relativo."include.inc.php");

//$mail_to      = 'mproietti@provincia.prato.it';
$mail_to      = 'admin_albo@provincia.prato.it';
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
require_once './class/Tipo.php';


$sql2 = "SELECT DISTINCT
 		registrazione.id_registrazione AS Num_Reg, 
 		'Determinazione Dirigenziale' AS Tipo,
 		registrazione.numero_protocollo AS Num_Atto, 
 		registrazione.data_immissione AS Data,
		registrazione.history_id
		
		FROM
		registrazione 
		-- eventi (per liquidazioni)
		LEFT JOIN eventspaflow doc_sign ON registrazione.history_id = doc_sign.history_id 
		-- LEFT JOIN eventspaflow chief_check ON registrazione.history_id = chief_check.history_id
		WHERE
		registrazione.modificato = 'f'
		AND registrazione.ambito = 'determination_approved' 
		AND (
		-- con impegno o liquidazioni
		(type IN (4, 6, 7, 23, 24, 25) AND doc_sign.event_kind = 'accounting_certificate_sign' ) 
		OR 
		-- senza impegno
		(type IN (8, 9, 10) AND doc_sign.event_kind = 'document_sign' )
		)
		AND registrazione.aoo = 'AOOPPO'
		AND registrazione.annullato = false
		
		-- AND (date(doc_sign.event_time) like '2014-%')
		-- AND (date(doc_sign.event_time) = '".date('Y-m-d')."')
		AND (date(doc_sign.event_time) like '".date('Y')."-%')
		ORDER BY num_atto ASC;";


$rs2 = $db2->query($sql2); 
//$nr_atti_esportati = $rs2->numRows();

$i = 0;
$j = 0;
$ARRAY_Errori = array();
$ARRAY_Date_Err = array();
$ARRAY_Errori_Multi = array();
$ARRAY_Date_Err_Multi = array();
$mail_message_2 = "";

while ($row2 = $rs2->fetchRow(DB_FETCHMODE_ASSOC)) {
	if (DB::isError($row2)) {
		error_log("Attenzione ERRORE di importazione nel Albo Pretorio. \n 
						Problema nell'esecuzione della seguente query:\n 
						".$sql2);
    	$mail_message = "Attenzione ERRORE di importazione nel Albo Pretorio. \n 
						Problema nell'esecuzione della seguente query:\n 
						".$sql2;
    	
		mail($mail_to, $mail_subject_error, $mail_message, $mail_headers); 
		throw new Exception('Errore nella select per la visualizzazione degli albi pretori nel DB'); 
		die($rs2->getMessage());
  	}
	else {
		
		$albo = new Albo();
		$tipo = new Tipo();
			
		$albo->setNr_atto($row2['num_atto']);
		$albo->setDt_atto($row2['data']);
		
		$mancate_registrazioni = $albo->verificaEsistenzaPerAlbo();
		$multiple_registrazioni = $albo->verificaEsistenzaMultiplaPerAlbo();
		
		if ($mancate_registrazioni == TRUE) {
			$ARRAY_Errori[$i] = $row2['num_atto'];
			$ARRAY_Date_Err[$i] = $row2['data'];
			$i++;
		}
		if ($multiple_registrazioni == TRUE) {
			$ARRAY_Errori_Multi[$j] = $row2['num_atto'];
			$ARRAY_Date_Err_Multi[$j] = $row2['data'];
			$j++;
		}		
	}			
}

error_log("ErroriTrovatiDallaVerifica = ".$i);



foreach ($ARRAY_Errori as $key => $value) {
	$mail_message_2 .= $value." del ".$ARRAY_Date_Err[$key]."\n";
}

foreach ($ARRAY_Errori_Multi as $key => $value) {
	$mail_message_3 .= $value." del ".$ARRAY_Date_Err[$key]."\n";
}

$mail_message = "ErroriTrovatiDallaVerifica nel Albo Pretorio = ".$i."\n
Registrazioni Multiple trovate = ".$j."\n
Numeri di protocollo non inseriti: \n".$mail_message_2."\n
Numeri di protocollo MULTIPLI: \n".$mail_message_3;

error_log($mail_message);

mail($mail_to, $mail_subject, $mail_message, $mail_headers);



?>
