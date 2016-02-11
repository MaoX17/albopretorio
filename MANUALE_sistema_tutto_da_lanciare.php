#!/usr/bin/php
<?php
//error_reporting(E_ERROR | E_PARSE);
//error_reporting(E_ALL ^E_WARNING);  

$percorso_relativo = "./";
$prefix = "/var/www/vhosts/albopretorio/";
$len_prefix = strlen($prefix);
include ($percorso_relativo."include.inc.php");

//$mail_to      = 'mproietti@provincia.prato.it';
$mail_to      = 'admin_albo@provincia.prato.it';
$mail_subject = 'Albo Pretorio - Notifiche - SistemaTutto';
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
 		date(doc_sign.event_time) AS DataPubblicazione,
 		registrazione.data_immissione AS DataAtto,
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
		
		 AND (date(doc_sign.event_time) like '2016-%')
		-- AND (date(doc_sign.event_time) = '".date('Y-m-d')."')
		ORDER BY num_atto ASC;";


$rs2 = $db2->query($sql2); 
//$nr_atti_esportati = $rs2->numRows();
error_log("NUMERO = ".$rs2->numRows());

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
		$albo->setDt_atto($row2['dataatto']);
		
		$mancate_registrazioni = $albo->verificaEsistenzaPerAlbo();
		$multiple_registrazioni = $albo->verificaEsistenzaMultiplaPerAlbo();
//		$presentimaerrate = $albo->verificaEsistenzaErrataPerAlbo();
		
		if ($mancate_registrazioni == TRUE) {
			$ARRAY_Errori[$i] = $row2['num_atto'];
			$ARRAY_Date_Err[$i] = $row2['datapubblicazione'];
			$ARRAY_Date_atti[$i] = $row2['dataatto'];
			$i++;
		}
		else {
			//Albi presenti da ricontrollare e aggiornare (eventualmente)
			//Non li aggiorno più - ho commentato l'aggiornamento perchè mi sputtana la data di pubblicazione_dal
			//e la data di pubblicazione_al
			$ARRAY_Update[$i] = $row2['num_atto'];
			$ARRAY_Update_Datepub[$i] = $row2['datapubblicazione'];
			$ARRAY_Update_Date_atti[$i] = $row2['dataatto'];
			$i++;

		}
		if ($multiple_registrazioni == TRUE) {
			$ARRAY_Errori_Multi[$j] = $row2['num_atto'];
			$ARRAY_Date_Err_Multi[$j] = $row2['datapubblicazione'];
			$ARRAY_Date_atti_Multi[$j] = $row2['dataatto'];
			$j++;
		}
/*		if ($presentimaerrate == TRUE) {
			$ARRAY_Correggi[$i] = $row2['num_atto'];
			$ARRAY_Correggi_Date[$i] = $row2['dataatto'];
			$ARRAY_Correggi_id[$i] = $albo->getErrorIdFromDtNr();
			$i++;
		}
*/
	}
}

//error_log("ErroriTrovatiDallaVerifica = ".$i);


//Atti che mancano
foreach ($ARRAY_Errori as $key => $value) {
	$mail_message_2 .= "Risoluzione ins nr. ".$value." del ".$ARRAY_Date_atti[$key]." Con dt Pubblicazione del ".$ARRAY_Date_Err[$key]."\n";
	$output .= shell_exec ('/usr/bin/php /var/www/vhosts/albopretorio/MANUALE_sistema_tutto_background.php '.$value.' '.$ARRAY_Date_Err[$key]);
}

//Non li aggiorno più - ho commentato l'aggiornamento perchè mi sputtana la data di pubblicazione_dal
//e la data di pubblicazione_al

//foreach ($ARRAY_Update as $key => $value) {
//	$mail_message_2 .= "Aggiorno atto nr. ".$value." del ".$ARRAY_Update_Date_atti[$key]." Con dt Pubblicazione del ".$ARRAY_Update_Datepub[$key]."\n";
//	$output .= shell_exec ('/usr/bin/php /var/www/vhosts/albopretorio/MANUALE_aggiorna_tutto_background.php '.$value.' '.$ARRAY_Update_Datepub[$key]);
//}

foreach ($ARRAY_Errori_Multi as $key => $value) {
	$mail_message_3 .= "Controlla e risolvi manualmente i seguenti errori: nr. ".$value." del ".$ARRAY_Date_Err[$key]."\n";
}
/*
foreach ($ARRAY_Correggi as $key => $value) {
	$mail_message_4 .= "Aggiorno nr. ".$value." del ".$ARRAY_Correggi_Date[$key]." con id = ".$ARRAY_Correggi_id[$key]."\n";
	echo "Aggiorno nr. ".$value." del ".$ARRAY_Correggi_Date[$key]." con id = ".$ARRAY_Correggi_id[$key]."\n";
	$albo = new Albo();
	$tipo = new Tipo();
	$albo->caricaDalDB($ARRAY_Correggi_id[$key]);
	print_r($albo);
	$albo->setDt_atto($ARRAY_Correggi_Date[$key]);
	//$albo->aggiornaSoloAlboNelDB();
	//$albo->serializzaNelDB();
	//$output .= shell_exec ('/usr/bin/php /var/www/vhosts/albopretorio/MANUALE_sistema_tutto_background2.php '.$value.' '.$ARRAY_Correggi_Date[$key]);
//$output .= shell_exec ('/usr/bin/php /var/www/vhosts/albopretorio/MANUALE_sistema_tutto_background.php '.$value.' '.$ARRAY_Date_Err[$key]);
}
*/

$mail_message = "ErroriTrovatiDallaVerifica nel Albo Pretorio e provati a risolvere= ".$i."\n
Registrazioni Multiple trovate = ".$j."\n
Numeri di protocollo non presenti ma inseriti: \n".$mail_message_2."\n
Numeri di protocollo MULTIPLI: \n".$mail_message_3."\n
Numeri di protocollo IN ESAME: \n".$mail_message_4;

error_log($output);
error_log($mail_message);

mail($mail_to, $mail_subject, $mail_message, $mail_headers);



?>
