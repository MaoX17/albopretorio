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

$sql2 = "SELECT DISTINCT
 		registrazione.id_registrazione AS Num_Reg,
 		'Determinazione Dirigenziale' AS Tipo,
 		registrazione.numero_protocollo AS Num_Atto,
 		registrazione.data_immissione AS Data,
		registrazione.history_id,
		registrazione.spesa_trasp,
		registrazione.act_type_trasp,
		oggetto.oggetto,
		'Provincia di Prato' AS Autorita_Emanante,
		ent_area.denominazione AS AreaRiferimento,
		ent_persona.nome || ' ' || ent_persona.cognome AS Responsabile_Area,
		documento_info.titolo,
		documento_info.nome_file,
		documento_info.kind_id,
		documenti.file,
	--	lo_export( documenti.file, '/opt/protocollo/files_albo/' || documento_info.nome_file ),
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
		-- LEFT JOIN eventspaflow chief_check ON registrazione.history_id = chief_check.history_id
		WHERE
		referer.role_id = 6
		AND registrazione.modificato = 'f'
		AND registrazione.ambito = 'determination_approved'
		AND (
		-- con impegno o liquidazioni
		(type IN (4, 6, 7, 23, 24, 25) AND doc_sign.event_kind = 'accounting_certificate_sign' )
		OR
		-- senza impegno
		(type IN (8, 9, 10) AND doc_sign.event_kind = 'document_sign' )
		)
		AND registrazione.aoo = 'AOOPPO'
		AND ent_persona.latest_version = true
		AND registrazione.annullato = false
		-- solo i pubblici
		--AND documento_info.kind_id = 0
		-- solo i pdf
		AND documenti.kind = 0
		-- Necessario x evitare le copertine
		AND documento_info.titolo != 'Copertina'
		-- solo il principale
		--AND documento_info.titolo='Atto confezionato'
		--AND registrazione_documento.principale='t'
		-- imposta data
		-- con/senza impegno/liquidazione: registrazione.data_registrazione = 'AAAA-MM-GG'
		-- AND (registrazione.data_registrazione = '2011-07-26')
		-- AND (registrazione.data_registrazione = '".date('Y-m-d')."')
		AND (date(doc_sign.event_time) = '2014-01-08')
		ORDER BY num_atto ASC, tipologia DESC;";


$rs2 = $db2->query($sql2);
$nr_atti_esportati = $rs2->numRows();

error_log("Numero righe = ".$nr_atti_esportati);

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
			$ARRAY_obj_files = array();
			$i = 0;
			//Unici tipi possibili x gli "Atti Confezionati" = "principale" sono .pdf
			$estensione_destinazione = ".pdf";

			$cartella_dest = $prefix."files/";
			// il 3 sta a significare Determina Dirigenziale (v. Tipi)
			// tipologia distingue se � il file principale o un allegato
			// se kind_id == 0 allora il documento NON � riservato
/*			if ($row2['kind_id'] == 0) {
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
*/
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
			$importo_spesa_prevista_trasp = $row2['spesa_trasp'];
			$idtipo_trasp = $row2['act_type_trasp'];

			$tipo_trasp->setId_tipo_trasp($idtipo_trasp);
//$tipo_trasp->setTipo_trasp("NULL");
			$tipo_trasp->setTipo_trasp($tipo_trasp->getTipoTraspFromIdTipoTrasp($idtipo_trasp));
			$albo->setSpesa_prevista($importo_spesa_prevista_trasp);


			$albo->setTipo_determina($tipo_determina);
			$albo->setTipo_trasp($tipo_trasp);


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
	 (RIGHT(aree.area, (LENGTH(aree.area) - 6)))  LIKE '%".substr($row2['areariferimento'], 6)."%'
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

					error_log(var_dump($albo));

				//	$risultato = $albo->creaNelDB();

					if ($risultato==FALSE) {
						//die("Errore nella registrazione del documento sul DB");
					}
					else {
						//	echo $albo;
						//$albo->serializzaNelDB();
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
			//$albo->CancellaTuttiFileDalDB();

			//echo "AGGiorno albo sul db e (prima) inserisco i file nel db!!";

			//$risultato = $albo->aggiornaNelDB();

			if ($risultato==FALSE) {
				//die("Errore nella registrazione del documento sul DB");
			}
			else {
			//	$albo->serializzaNelDB();
			}

		}
	}
}

?>
