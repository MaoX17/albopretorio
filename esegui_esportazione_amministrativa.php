<?php
/**
 * Created by Maurizio Proietti
 * User: maurizio.proietti@gmail.com
 */
?>

<?php

$percorso_relativo = "./";

include ($percorso_relativo."include.inc.php");

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
//********************************************************

require_once $percorso_relativo.'class/Albo.php';
require_once $percorso_relativo.'class/Area.php';
require_once $percorso_relativo.'class/Tipo.php';
require_once $percorso_relativo.'class/Tipo_determina.php';
require_once $percorso_relativo.'class/Tipo_trasp.php';

$titolo_pagina = "Visualizzazione Albo Pretorio - Provincia di Prato";

include($percorso_relativo."grafica/head_jquery.php");
include($percorso_relativo."grafica/body_head_jquery.php");


/******** Serve per l'escape di potenziali caratteri non corretti *******************/
foreach ($_POST as $key => $value) {
        $_POST[$key] = $db->escapeSimple($_POST[$key]);
        if ($_POST[$key] == "") { $_POST[$key] = "%"; }
}

//print_r($_POST);

$oggi = dt_oggi();

if (isset($_GET["page"])) {
	$page = $_GET["page"];
}
else {
	$page =1;
}

$start_from = ($page - 1) * 100;
$num_risultati_per_pag = 100;

//------------------------------------------------------
if ($_POST['tipo'] == 3) {
	$tipo_determina = $_POST['tipo_determina'];
}
else {
	$tipo_determina = "%";
}
//------------------------------------------------------

//------------------------------- ESEGUO RICERCA A VIDEO -------------------------
if ($_POST['ok'] == "Esegui Ricerca ->") {

?>



	<div style="width:100%" class="footable-container">

	<br/>

	Filtra i risultati della pagina corrente: <input id="filter" type="text" />
	<br/><br/>

	<table data-filter="#filter" class="footable" data-page-size="5" border="1">
	<thead>
	<tr>
	<th data-class="expand"  data-sort-initial="descending">Num. Reg</th>
	<th data-hide="phone,tablet">Tipo</th>
	<th>Num. Atto</th>
	<th>Data</th>
	<th>Oggetto</th>
	<th data-hide="phone,tablet">Autorit&agrave emanante</th>
	<th data-hide="phone,tablet">Area di riferimento</th>
	<th data-hide="phone,tablet">Responsabile di Area</th>
	<th data-hide="phone,tablet">In pubblicazione dal</th>
	<th data-hide="phone,tablet">In pubblicazione al</th>
	<th data-hide="phone,tablet">Note</th>
	<!-- <th>Documento</th>  -->
	</tr>

	</thead>
	<tbody>

	<?php


	//trovo numero totale dei record
	$sql =
	"SELECT count(albi.id_albo) as tot
	FROM
			albi
			Inner Join aree ON albi.id_area = aree.id_area
			Inner Join tipi ON albi.id_tipo = tipi.id_tipo
			LEFT Join tipi_determina ON albi.id_tipo_determina = tipi_determina.id_tipo_determina

	WHERE
			albi.oggetto LIKE '%".$_POST['oggetto']."%' AND
			albi.autorita_emanante LIKE '%".$_POST['autorita']."%'";

			$_POST['dt_pubbl_dal']=="%" ? $sql.="" : $sql.=" AND albi.dt_pubblicaz_dal >= '".$_POST['dt_pubbl_dal']."' ";
			$_POST['dt_pubbl_al']=="%" ? $sql.="" : $sql.=" AND albi.dt_pubblicaz_al <= '".$_POST['dt_pubbl_al']."' ";
			//$_POST['dt_atto']=="%" ? $sql.="" : $sql.=" AND albi.dt_atto='".$_POST['dt_atto']."' ";
			$_POST['dt_atto_dal']=="%" ? $sql.="" : $sql.=" AND albi.dt_atto >= '".$_POST['dt_atto_dal']."' ";
			$_POST['dt_atto_al']=="%" ? $sql.="" : $sql.=" AND albi.dt_atto <= '".$_POST['dt_atto_al']."' ";

			$_POST['numero']=="%" ? $sql.="" : $sql.=" AND albi.nr_atto=".$_POST['numero']." ";
			$_POST['area']=="%" ? $sql.="" : $sql.=" AND aree.id_area=".$_POST['area']." ";
			$_POST['tipo']=="%" ? $sql.="" : $sql.=" AND tipi.id_tipo=".$_POST['tipo']." ";
	$tipo_determina =="%" ? $sql.="" : $sql.=" AND tipi_determina.id_tipo_determina=".$tipo_determina." ";

			$sql.=";";

			//echo $sql;

	$rs = $db->query($sql);
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
		}
		else {
			$result = TRUE;
			$tot = $row2['tot'];
		}
	}

	//$tot = round(($tot/100),0);
	$tot = ceil($tot/100);





	//ESEGUO SELECT
	$sql =
			"SELECT
			albi.id_albo,
			albi.id_tipo,
			albi.dt_pubblicaz_dal,
			albi.dt_pubblicaz_al,
			albi.dt_atto,
			albi.nr_atto,
			albi.oggetto,
			albi.note,
			albi.autorita_emanante,
			albi.id_area,
			aree.id_area,
			aree.responsabile,
			aree.area,
			tipi.id_tipo,
			tipi.tipo
			FROM
			albi
			Inner Join aree ON albi.id_area = aree.id_area
			Inner Join tipi ON albi.id_tipo = tipi.id_tipo
			LEFT Join tipi_determina ON albi.id_tipo_determina = tipi_determina.id_tipo_determina
			WHERE

			albi.oggetto LIKE '%".$_POST['oggetto']."%' AND
			albi.autorita_emanante LIKE '%".$_POST['autorita']."%'";

			$_POST['dt_pubbl_dal']=="%" ? $sql.="" : $sql.=" AND albi.dt_pubblicaz_dal >= '".$_POST['dt_pubbl_dal']."' ";
			$_POST['dt_pubbl_al']=="%" ? $sql.="" : $sql.=" AND albi.dt_pubblicaz_al <= '".$_POST['dt_pubbl_al']."' ";
			//$_POST['dt_atto']=="%" ? $sql.="" : $sql.=" AND albi.dt_atto='".$_POST['dt_atto']."' ";

			$_POST['dt_atto_dal']=="%" ? $sql.="" : $sql.=" AND albi.dt_atto >= '".$_POST['dt_atto_dal']."' ";
			$_POST['dt_atto_al']=="%" ? $sql.="" : $sql.=" AND albi.dt_atto <= '".$_POST['dt_atto_al']."' ";

			$_POST['numero']=="%" ? $sql.="" : $sql.=" AND albi.nr_atto=".$_POST['numero']." ";
			$_POST['area']=="%" ? $sql.="" : $sql.=" AND aree.id_area=".$_POST['area']." ";
			$_POST['tipo']=="%" ? $sql.="" : $sql.=" AND tipi.id_tipo=".$_POST['tipo']." ";
	$tipo_determina =="%" ? $sql.="" : $sql.=" AND tipi_determina.id_tipo_determina=".$tipo_determina." ";

			$sql.=" ORDER BY albi.id_albo DESC
			limit ".$start_from.", ".$num_risultati_per_pag.";";

		echo $sql;


	$rs = $db->query($sql);
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
			throw new Exception('Errore nella select per la visualizzazione degli albi pretori nel DB');
			die($rs->getMessage());
		}
		else {
			// Visualizzo il risultato in tabella
					$result = TRUE;

			$i = 0;
			$tmp = new Albo();
			$tmp2 = new Albo();
			$tmp2 = $tmp->caricaDalDB2($row2['id_albo']);

	//if ($tmp2<> "") {
			if (is_object($tmp2) && is_array($tmp2->getARRAY_files())) {
				foreach ($tmp2->getARRAY_files() as $fileobj) {
					$i++;
				}
			}


			echo "<tr>";

			if ($i > 0) {
				echo '<td><a href="../../visualizza-dettagli.php?id_albo='.$row2['id_albo']."\" target=\"_blank\" >".$row2['id_albo']."<br><img src=\"./grafica/images/allegato.png\"/></a></td>";
				//echo '<td><a href="../../visualizza-dettagli.php?id_albo='.$row2['id_albo']."\"><br><img src=\"./grafica/images/allegato.png\"/></a></td>";
			}
			else {
				echo '<td>'.$row2['id_albo'].'</td>';
			}

			// Visualizzo il risultato in tabella

			echo "<td>".$row2['tipo']."</td>";
			echo "<td>".$row2['nr_atto']."</td>";
			echo "<td>".$row2['dt_atto']."</td>";
			echo "<td>".$row2['oggetto']."</td>";
			echo "<td>".$row2['autorita_emanante']."</td>";
			echo ($row2['area'] == " ") ? "<td>&nbsp;</td>" : "<td>".$row2['area']."</td>";
			echo ($row2['responsabile'] == " ") ? "<td>&nbsp;</td>" : "<td>".$row2['responsabile']."</td>";

			echo "<td>".$row2['dt_pubblicaz_dal']."</td>";
			echo "<td>".$row2['dt_pubblicaz_al']."</td>";
			echo "<td>".$row2['note']."</td>";
	//		echo "<td style='text-align: center;'><a href='http://albopretorio.provincia.prato.it/files/".$row2['file']."' > <img src='".$percorso_relativo."grafica/images/pdf.gif'></a></td>";
			echo "</tr>\n";
		}
	}
	?>

	 </tbody>
		  <tfoot class="footable-pagination">
			<tr>
			  <td colspan="11">
			  Schermata:
				<ul id="pagination" class="footable-nav"></ul>
			  </td>
			</tr>


	<tr>
	<td colspan="11">
	Pagina:
	<ul id="pagination" class="footable-nav2">
	<?php

	$classe_li = "footable-page2";
	$classe_li_selected = "footable-page2 footable-page-current";

	for ($i = 1; $i <= $tot; $i++) {
		if ($i == $page) {
			echo '<li class="'.$classe_li_selected.'">';
		}
		else {
			echo '<li class="'.$classe_li.'">';
		}

		echo '<a href="./visualizza.php?page='.$i.'" data-page="'.$i.'">'.$i.'</a>';
		echo "</li>";
	}


	?>
	</ul>
	</td>
	</tr>
		  </tfoot>

	</table>
		</div>

<?
}
// ------------------------- FINE RICERCA A VIDEO ------------------
// --------- Inizio ricerca su excel -------------------
elseif ($_POST['ok'] == "Genera Excel ->") {



	$sql =
		"SELECT
row_number() over (partition by ent_area.denominazione order by registrazione.numero_protocollo) as Numero,
registrazione.numero_protocollo AS N_Atto,
registrazione.data_immissione AS Data,
replace(oggetto.oggetto,'\r\n',' ') as Oggetto,
ent_area.denominazione AS Area_Riferimento,
ent_persona.nome || ' ' || ent_persona.cognome AS Responsabile_Area

FROM
(registrazione INNER JOIN oggetto ON registrazione.id_oggetto = oggetto.id_oggetto
INNER JOIN referer ON registrazione.id_registrazione = referer.registration_id
INNER JOIN entitapaflow AS ent_carica ON referer.referer_id = ent_carica.id_entita
INNER JOIN positionspaflow ON ent_carica.id_entita = positionspaflow.position
INNER JOIN entitapaflow AS ent_persona ON positionspaflow.id_entita = ent_persona.id_entita
INNER JOIN entitapaflow AS ent_area ON ent_carica.parent = ent_area.id_entita
)


WHERE
referer.role_id = 6
AND registrazione.modificato = 'f'
AND registrazione.annullato = 'f'
AND registrazione.ambito = 'determination_approved'
AND type = 7
AND registrazione.aoo = 'AOOPPO'
AND ent_persona.latest_version = 't'
AND ent_area.latest_version = true
AND registrazione.annullato = 'f'
AND registrazione.data_immissione >= '".$_POST['dt_atto_dal']."'
AND registrazione.data_immissione <= '".$_POST['dt_atto_al']."' ";



	//echo $sql;


	$rs2 = $db2->query($sql);
	if (DB::isError($rs2)) {
		echo "<p><strong>Attenzione!</strong>Si e' verificato un errore durante
				l'esecuzione della query <br> \"$sql\".";
		throw new Exception('Errore nella select per la visualizzazione degli albi pretori nel DB');
		die($rs2->getMessage());
	}

	//indice file csv
	$ARRAY_result = array();
	$z = 1;
	$fp = fopen('file.csv', 'w');
	$ARRAY_label = array("Numero", "num Atto", "data Atto","oggetto", "area riferimento","responsabile");
	fputcsv($fp, $ARRAY_label);

	while ($row2 = $rs2->fetchRow(DB_FETCHMODE_ASSOC)) {
		if (DB::isError($row2)) {
			echo "<p><strong>Attenzione!</strong>Si e' verificato un errore durante
				l'esecuzione della query \"$sql\".";
			throw new Exception('Errore nella select per la visualizzazione degli albi pretori nel DB');
			die($rs2->getMessage());
		}
		else {
			// Visualizzo il risultato in tabella
			$result = TRUE;

			$ARRAY_result[0] = $row2['numero'];
			$ARRAY_result[1] = $row2['n_atto'];
			$ARRAY_result[2] = $row2['data'];
			$ARRAY_result[3] = $row2['oggetto'];
			$ARRAY_result[4] = $row2['area_riferimento'];
			$ARRAY_result[5] = $row2['responsabile_area'];


		}
		$z++;
		fputcsv($fp, $ARRAY_result);
	}


	fclose($fp);
?>

	<!-- <a href="file.csv" class="btn btn-primary" type="application/octet-stream">scarica</a> -->
	<a href="download_risultato_ricerca.php" class="btn btn-primary">Scarica il risultato della ricerca</a>

<?
}
// --------- FINE ricerca su excel -------------------
?>



</body>
</html>
