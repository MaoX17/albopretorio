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



$sql2 = "SELECT DISTINCT
	 registrazione.id_registrazione AS Num_Reg, 
	 'Determinazione Dirigenziale' AS Tipo,
	 registrazione.numero_protocollo AS Num_Atto, 
	 registrazione.data_registrazione AS Data,
	 registrazione.history_id,
	 oggetto.oggetto,
	 'Provincia di Prato' AS Autorita_Emanante,
	 ent_area.denominazione AS AreaRiferimento, 
	 ent_persona.nome || ' ' || ent_persona.cognome AS Responsabile_Area,
	 documento_info.titolo,
	 documento_info.nome_file,
	 documenti.file,
	 --lo_export( documenti.file, '/opt/protocollo/files_albo/' || documento_info.nome_file ),
	 CASE WHEN documento_info.titolo='Atto confezionato' THEN 'principale'
		ELSE 'allegato'
	 END as tipologia
FROM
	 (registrazione INNER JOIN oggetto ON registrazione.id_oggetto = oggetto.id_oggetto
	 INNER JOIN referer ON registrazione.id_registrazione = referer.registration_id
	 INNER JOIN entitapaflow AS ent_carica ON referer.referer_id = ent_carica.id_entita
	 INNER JOIN positions ON ent_carica.etichetta = positions.position
	 INNER JOIN entitapaflow AS ent_persona ON positions.id_entita = ent_persona.id_entita
	 INNER JOIN entitapaflow AS ent_area ON ent_carica.parent = ent_area.id_entita
	 -- documenti
	 INNER JOIN registrazione_documento ON registrazione.id_registrazione = registrazione_documento.id_registrazione
	 INNER JOIN documenti ON registrazione_documento.id_documento = documenti.id_doc
	 INNER JOIN documento_info ON documenti.id_doc = documento_info.id_documento 
	 )
	 -- eventi (per liquidazioni)
	 LEFT JOIN eventspaflow doc_sign ON registrazione.history_id = doc_sign.history_id 
	 LEFT JOIN eventspaflow chief_check ON registrazione.history_id = chief_check.history_id
WHERE
	 referer.role_id = 6
	 AND registrazione.modificato = 'f'
	 AND registrazione.ambito = 'determination_approved' 
	 AND (
		 -- con impegno
		 (type IN (4, 6, 7)) 
		 OR 
		 -- senza impegno
		 (type IN (8, 9, 10) AND doc_sign.event_kind = 'document_sign' )
		 OR
		 -- liquidazioni
		 (type IN (23, 24, 25) AND doc_sign.event_kind = 'document_sign' 
				       AND chief_check.event_kind = 'accounting_chief_check' 
				       AND doc_sign.event_time > chief_check.event_time
				       AND doc_sign.charge_id = chief_check.charge_id) 
	 )
	 AND registrazione.aoo = 'AOOPPO'
	 AND ent_persona.latest_version = true
	 AND registrazione.annullato = false
	 -- solo i pubblici
	 AND documento_info.kind_id = 0
	 -- solo i pdf
	 AND documenti.kind = 0
	 -- Necessario x evitare le copertine
	 AND documento_info.titolo != 'Copertina'
	 -- solo il principale
	 --AND documento_info.titolo='Atto confezionato'
	 --AND registrazione_documento.principale='t'
	 -- imposta data
		 -- con/senza impegno:	registrazione.data_registrazione = 'AAAA-MM-GG'
		 -- di liquidazione: 	doc_sign.event_time LIKE 'AAAA-MM-GG%'
	 AND 	((type NOT IN (23, 24, 25) AND registrazione.data_registrazione = '2011-04-08') OR 
		(type IN (23, 24, 25) AND doc_sign.event_time LIKE '2011-04-08%'))
ORDER BY num_atto ASC, tipologia DESC;";



$rs2 = $db2->query($sql2); 
//scrivo la query nei log
error_log($sql2);

$nr_atti_esportati = $rs2->numRows();
//scrivo il nr di righe estratte nei log
error_log($nr_atti_esportati);

$mail_message = "Atti importati nel Albo Pretorio = ".$nr_atti_esportati;
mail($mail_to, $mail_subject, $mail_message, $mail_headers);


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
			error_log("Nr ATTO = ".$nr_atto);
			$ARRAY_obj_files = array();
			$i = 0;		
			//Unici tipi possibili x gli "Atti Confezionati" = "principale" sono .pdf
			$estensione_destinazione = ".pdf";
			
			$cartella_dest = $prefix."files/";
			// il 3 sta a significare Determina Dirigenziale (v. Tipi)
			// tipologia distingue se � il file principale o un allegato
			$nome_file_dest_finale = $row2['data']."-".$row2['num_atto']."-3-".$row2['tipologia'].$estensione_destinazione;
			$percorso_dest_finale = $cartella_dest.$nome_file_dest_finale;
			
			
			
			$albo = new Albo();
			$tipo = new Tipo();
			$area = new Area();
			
			
			$albo->setDt_atto($row2['data']);
			$albo->setDt_pubblicaz_dal(date('Y-m-d'));
			$albo->setDt_pubblicaz_al(date('Y-m-d', strtotime("+15 days", strtotime(date('Y-m-d')))));
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
			
			//scrivo query associazione aree
			error_log($sql);
			
			$rs = $db->query($sql); 
			$nr_aree_corrispondenti = $rs->numRows();
			
			if ($nr_aree_corrispondenti <> 1) {
				error_log("Attenzione! Errore di ambiguit� 
					per la verifica dell'area corrispondente.
					Si e' verificato un errore durante
						l'esecuzione della query".$sql);
				echo "<p><strong>Attenzione!</strong> Errore di ambiguit� 
					per la verifica dell'area corrispondente.
					Si e' verificato un errore durante
						l'esecuzione della query <br> \"$sql\"."; 
					throw new Exception('Errore nella select per la visualizzazione degli albi pretori nel DB'); 
					die($rs->getMessage());
			}
			if (DB::isError($rs)) {
					error_log("Attenzione! Si e' verificato un errore durante
						l'esecuzione della query ".$sql);
			    	echo "<p><strong>Attenzione!</strong>Si e' verificato un errore durante
						l'esecuzione della query <br> \"$sql\"."; 
					throw new Exception('Errore nella select per la visualizzazione degli albi pretori nel DB'); 
					die($rs->getMessage());
			}
			
			while ($row = $rs->fetchRow(DB_FETCHMODE_ASSOC)) {
				if (DB::isError($row)) {
					error_log("Attenzione! Si e' verificato un errore durante
						l'esecuzione della query ".$sql);
			    	echo "<p><strong>Attenzione!</strong>Si e' verificato un errore durante
						l'esecuzione della query \"$sql\"."; 
					$result = FALSE;
					throw new Exception('Errore nella select per la visualizzazione degli albi pretori nel DB'); 
					die($rs->getMessage());
					//die($rs->getMessage());
			  	}
				else {
					
	
					$area->setId_area($row['id_area']);
					error_log("ID AREA = ".$row['id_area']);
					$area->setArea($area->getAreaFromIdArea($area->getId_area()));
					$area->setResponsabile($area->getRespFromIdArea($area->getId_area()));
	
					$albo->setArea($area);
					
					error_log("AREA = ".$area->getArea());
//TODO: RIMETTERE					
//					$risultato = $albo->creaNelDB();
					
				}
			}
		}
		//se il file non � il principale ma � un allegato....
		elseif ($row2['num_atto'] == $nr_atto) {
			

			$i++;
			
			$albo->setARRAY_files($ARRAY_obj_files);
			
//			$albo->CancellaTuttiFileDalDB();
			
			//echo "AGGiorno albo sul db e (prima) inserisco i file nel db!!";
//			$risultato = $albo->aggiornaNelDB();
	
		}				
	}
}

?>
