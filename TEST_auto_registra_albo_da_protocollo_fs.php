#!/usr/bin/php

	<?php
	/*
	 * Questo script parte dal presupposto che i file siano già su FS
	 */
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

	//NOTE: lo_export non serve più perchè i file sono su FS

	$sql2 = "SELECT DISTINCT
			registrazione.id_registrazione AS Num_Reg,
			'Determinazione Dirigenziale' AS Tipo,
			registrazione.numero_protocollo AS Num_Atto,
			registrazione.data_immissione AS Data,
			registrazione.history_id,
			registrazione.spesa_trasp,
			registrazione.act_type_trasp,
			registrazione.type AS TipoDetermina,
			oggetto.oggetto,
			'Provincia di Prato' AS Autorita_Emanante,
			ent_area.denominazione AS AreaRiferimento,
			ent_persona.nome || ' ' || ent_persona.cognome AS Responsabile_Area,
			documento_info.titolo,
			documento_info.nome_file,
			documento_info.kind_id,
			documento_info.id_documento,
			-- documenti.file,
			-- lo_export( documenti.file, '/var/albo_data/file_atti/' || documento_info.nome_file ),
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
			-- INNER JOIN documenti ON registrazione_documento.id_documento = documenti.id_doc
			-- INNER JOIN documento_info ON documenti.id_doc = documento_info.id_documento
			INNER JOIN documento_info ON registrazione_documento.id_documento = documento_info.id_documento

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
			-- Attenzione - serve x prendere l'ultimo diriggente associato
			-- AND ent_persona.latest_version = true
			AND registrazione.annullato = false
			-- solo i pubblici
			--AND documento_info.kind_id = 0
			-- solo i pdf
			-- AND documento_info.editable = 'N'
			-- Necessario x evitare le copertine
			AND documento_info.titolo != 'Copertina'
			-- solo il principale
			--AND documento_info.titolo='Atto confezionato'
			--AND registrazione_documento.principale='t'
			-- imposta data
			-- con/senza impegno/liquidazione: registrazione.data_registrazione = 'AAAA-MM-GG'
			-- AND (registrazione.data_registrazione = '2011-07-26')
			-- AND (registrazione.data_registrazione = '".date('Y-m-d')."')
			AND (date(doc_sign.event_time) = '".date('Y-m-d')."')
			-- AND (date(doc_sign.event_time) = '2015-02-10')
			-- 481958 è il primo atto su FS
			AND (registrazione.history_id > 481958)
			-- AND (date(doc_sign.event_time) = '2011-01-11')
			ORDER BY num_atto ASC, tipologia DESC;";

	echo $sql2;
	exit;
	$rs2 = $db2->query($sql2);
	$nr_atti_esportati = $rs2->numRows();

	error_log("Numero righe = ".$nr_atti_esportati);

	$mail_message = "Atti importati nel Albo Pretorio FS = ".$nr_atti_esportati;
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

			//primo atto che inserisco nel db mysql perchè il principale è il primo SEMPRE
			//quindi qui creo nel db l'oggetto ALBO
			if (($row2['tipologia'] == "principale") AND ($row2['num_atto'] != $nr_atto)){

				$nr_atto = $row2['num_atto'];

				error_log("Elaboro atto nr = ".$nr_atto);

				$ARRAY_obj_files = array();
				$i = 0;
				//Unici tipi possibili x gli "Atti Confezionati" = "principale" sono .pdf
				$estensione_destinazione = ".pdf";

				// OK: da modificare in base al progetto per la migrazione su FS
				$cartella_dest = $prefix."files_albo_nfs/";
				//$cartella_dest = $prefix."files/";
				//$cartella_dest = "/var/www/html/albopretorio/migrazione/data/file_atti/";

				// il 3 sta a significare Determina Dirigenziale (v. Tipi)
				// tipologia distingue se � il file principale o un allegato
				// se kind_id == 0 allora il documento NON � riservato
				if ($row2['kind_id'] == 0) {
					//imposto variabili x il percorso del file

					$history_migliaia = substr($row2['history_id'], 0, -3);
					$history_id = $row2['history_id'];
					$id_documento = $row2['id_documento'];

					//TODO: se è sempre PDF perche cerco estenzione?????
					/*
					$nome_file = $row2['nome_file'];
					$ext = pathinfo($nome_file, PATHINFO_EXTENSION);
					if ($ext == "p7m") {
						$ext = cerca_ext_p7m($nome_file);
					}
					*/

					// il nome finale (da registrare nel db è:
					// $history_migliaia / $history_id / $id_documento . $ext

					//$nome_file_dest_finale = $history_migliaia."/".$history_id."/".$id_documento.".".$ext;
					$nome_file_dest_finale = $history_migliaia."/".$history_id."/".$id_documento.$estensione_destinazione;
					//$directory_dest_finale = $cartella_dest.$history_migliaia."/".$history_id."/";
					//$percorso_dest_finale = $cartella_dest.$nome_file_dest_finale;

					//NOOOOOOO esiste già i file sono già OK su FS
					//NOOOOOOO esiste già i file sono già OK su FS
					//creo la directory di destinazione collegando la directory di destinazione generale
					// con quella specifica dell'atto che sto trattando e assegno i permessi



				}
				else {
					$nome_file_dest_finale = 'riservato.pdf';
					$percorso_dest_finale = $cartella_dest.$nome_file_dest_finale;
				}

				$ARRAY_obj_files[$i] = new File($nome_file_dest_finale, "n");
				//$ARRAY_obj_files[$i] = new File($percorso_dest_finale);
				$i++;

				$albo = new Albo();
				$tipo = new Tipo();
				$area = new Area();

				$tipo_determina = new Tipo_determina();
				$tipo_trasp = new Tipo_Trasp();

				//TODO: Start verifica che sia ok - modifica effettuata il 2015-07-06
				//$tipo_determina->setId_tipo_determina("NULL");
				//$tipo_determina->setTipo_determina("NULL");
				$tipo_determina->setId_tipo_determina($row2['tipodetermina']);
				$tipo_determina->setTipoDetFromIdTipoDet();
				//TODO: End verifica che sia ok - modifica effettuata il 2015-07-06

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

				$albo->setNr_atto($row2['num_atto']);
				$albo->setDt_atto($row2['data']);
				$tipo->setId_tipo("3");
				$tipo->setTipo($tipo->getTipoFromIdTipo($tipo->getId_tipo()));
				$albo->setTipo($tipo);

				//Se vero albo non esiste
				$albo->setARRAY_files($ARRAY_obj_files);

				//$albo->setDt_pubblicaz_dal(date('Y-m-d',strtotime($row2['data'])));
				$albo->setDt_pubblicaz_dal(date('Y-m-d'));
				//$albo->setDt_pubblicaz_al(date('Y-m-d', strtotime("+15 days", strtotime($row2['data']))));
				$albo->setDt_pubblicaz_al(date('Y-m-d', strtotime("+15 days", strtotime(date('Y-m-d')))));
				//error_log(date('Y-m-d',strtotime($row2['data'])));
				//error_log(date('Y-m-d', strtotime("+15 days", strtotime($row2['data']))));
				$albo->setOggetto(mysql_real_escape_string($row2['oggetto']));
				$albo->setAutorita_emanante($row2['autorita_emanante']);
				$albo->setDa_validare("N");

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
					echo "<p><strong>Attenzione!</strong> Errore di ambiguita
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
			//se il file non e' il principale ma e' un allegato....
			//eseguo un AGGIORNA sul db dell'oggetto ALBO
			//se kind_id è diverso da 0 il documento è RISERVATO quindi non pubblico l'allegato
			elseif (($row2['num_atto'] == $nr_atto) AND ($row2['kind_id'] == 0)) {

				// OK: da modificare in base al progetto per la migrazione su FS
				//$cartella_dest = $prefix."files/";
				$cartella_dest = $prefix."files_albo_nfs/";
				//$cartella_dest = "/var/www/html/albopretorio/migrazione/data/file_atti/";


				// il 3 sta a significare Determina Dirigenziale (v. Tipi)
				// tipologia distingue se � il file principale o un allegato
				// se kind_id == 0 allora il documento NON � riservato

				//imposto variabili x il percorso del file
				$history_migliaia = substr($row2['history_id'], 0, -3);
				$history_id = $row2['history_id'];
				$id_documento = $row2['id_documento'];
				$nome_file = $row2['nome_file'];
				/*
				$ext = pathinfo($nome_file, PATHINFO_EXTENSION);
				if ($ext == "p7m") {
					$ext = cerca_ext_p7m($nome_file);
				}
				*/

				$ext_tmp = "";
				$parts = pathinfo($row2['nome_file']);
				while ($parts['extension'] == 'p7m') {
					//$ext_tmp = ".".$parts['extension'];
					//e' SEMPRE p7m
					$ext_tmp = ".p7m";
					//in questa ver di php $parts['filename'] non esiste
					//$parts = pathinfo($parts['filename']);
					$file_name_tmp = str_replace(".p7m", "", $row2['nome_file']);
					$parts = pathinfo($file_name_tmp);

				}
				$ext = $parts['extension'] .$ext_tmp;

				// se non inizia con un punto (.) lo metto io
				if ($ext{0} <> ".") {
					$ext = ".".$ext;
				}
				error_log("EXTENSIONE = ".$ext);



				// il nome finale (da registrare nel db è:
				// $history_migliaia + $history_id + $id_documento + $ext
				$nome_file_dest_finale = $history_migliaia."/".$history_id."/".$id_documento.$ext;
				$percorso_dest_finale = $cartella_dest.$nome_file_dest_finale;

				$ARRAY_obj_files[$i] = new File($nome_file_dest_finale, "n");
				//$ARRAY_obj_files[$i] = new File($percorso_dest_finale);
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


	?>

