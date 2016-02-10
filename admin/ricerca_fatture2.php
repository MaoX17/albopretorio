<?php
/**
 * Created by Maurizio Proietti
 * User: maurizio.proietti@gmail.com
 */
?>
<?php

$percorso_relativo = "../";
require ($percorso_relativo."include.inc.php");
// setup the autoloading
require_once ($percorso_relativo.'vendor/autoload.php');
//require_once 'vendor/autoload.php';
// setup Propel
require_once ($percorso_relativo.'propel/config.php');
require_once ('class/ConfigSingleton.php');
$cfg = SingletonConfiguration::getInstance ();
//$user_db = $cfg->getValue('UserDB');
$titolo_pagina = $cfg->getValue('titolo_applicazione');
//include($percorso_relativo."grafica/head_bootstrap.php");
//include($percorso_relativo."grafica/body_head_bootstrap.php");
include($percorso_relativo."grafica/head_bootstrap_agid.php");
include($percorso_relativo."grafica/body_head_bootstrap_agid.php");

// ####### OLD ##########
require_once ("class/Db.php");
$factory=DbAbstractionFactory::getFactory($cfg->getValue('AstrazioneDB'));
$factory->setDsn($cfg->getValue('DSN'));
$db=$factory->createInstance();
$factory2=DbAbstractionFactory::getFactory($cfg->getValue('AstrazioneDB2'));
$factory2->setDsn($cfg->getValue('DSN2'));
$db2=$factory2->createInstance();
require_once $percorso_relativo.'class/Albo.php';
require_once $percorso_relativo.'class/Area.php';
require_once $percorso_relativo.'class/Tipo.php';
require_once $percorso_relativo.'class/Tipo_determina.php';
require_once $percorso_relativo.'class/Tipo_trasp.php';

// ####### OLD ##########

$titolo_pagina = "Ricerca Fatture - Provincia di Prato";



//------------------------------- ESEGUO RICERCA A VIDEO -------------------------
if ($_POST['ok'] == "Esegui Ricerca ->") {

?>

<body>
<a href="/admin/ricerca_fatture.php" class="btn btn-success"><- Esegui nuova ricerca</a> <br>

	<div style="width:100%" class="footable-container">

		<br/>

	<br/>

	<table data-filter="#filter" class="footable" data-page-size="150" border="1">
	<thead>
	<tr>
	<th data-class="expand"  data-sort-initial="descending">Ditta</th>
	<th data-hide="phone,tablet">CF / P.IVA</th>
	<th>Descrizione</th>
	<th>Stato</th>
	<th>Anno</th>
	<th data-hide="phone,tablet">Numero</th>
	<th data-hide="phone,tablet">SDI</th>
	<th data-hide="phone,tablet">Importo</th>
	<th data-hide="phone,tablet">Nr. Protocollo</th>
	<th data-hide="phone,tablet">Anno Protocollo</th>
	</tr>

	</thead>
	<tbody>

	<?php


	//trovo numero totale dei record
	$sql2 = "select pg_ebill_incoming_aooppo.sender as ditta,
pg_ebill_incoming_aooppo.sender_taxcode as piva,
description as descrizione,

      CASE WHEN status=1 THEN 'ACCETTATO'
            WHEN status=-1 THEN 'RESPINTO'
            ELSE 'IN ATTESA'
       END as stato,
bill_year as anno,
bill_number as numero,
id_sdi as sdi,
pg_ebill_repertory_aooppo.total_import as importo,
pg_ebill_repertory_aooppo.registration_number as nr_proto,
pg_ebill_repertory_aooppo.registration_year as anno_proto

from pg_ebill_incoming_aooppo

left join pg_ebill_repertory_aooppo on pg_ebill_incoming_aooppo.registration_id = pg_ebill_repertory_aooppo.registration_id

where
(upper(pg_ebill_incoming_aooppo.sender) like upper('%".$_POST['mittente']."%'))
AND
(id_sdi like ('%".$_POST['id_sdi']."%'))";

			//echo $sql2;

	$rs2 = $db2->query($sql2);
	if (DB::isError($rs2)) {
		echo "<p><strong>Attenzione!</strong>Si e' verificato un errore durante
		l'esecuzione della query <br> \"$sql2\".";
		throw new Exception('Errore nella select per la visualizzazione degli albi pretori nel DB');
		die($rs2->getMessage());
	}

	while ($row2 = $rs2->fetchRow(DB_FETCHMODE_ASSOC)) {
		if (DB::isError($row2)) {
			echo "<p><strong>Attenzione!</strong>Si e' verificato un errore durante
			l'esecuzione della query \"$sql2\".";
			$result = FALSE;
			throw new Exception('Errore nella select per la visualizzazione degli albi pretori nel DB');
			die($rs2->getMessage());
		}
		else {

			echo "<tr>";
				echo '<td>'.$row2['ditta'].'</td>';
				echo '<td>'.$row2['piva'].'</td>';
				echo '<td>'.$row2['descrizione'].'</td>';
				echo '<td>'.$row2['stato'].'</td>';
				echo '<td>'.$row2['anno'].'</td>';
				echo '<td>'.$row2['numero'].'</td>';
				echo '<td>'.$row2['sdi'].'</td>';
			// Italian national format with 2 decimals`
			setlocale(LC_MONETARY, 'it_IT');

				echo '<td>'.money_format('%.2n', $row2['importo']).'</td>';
				echo '<td>'.$row2['nr_proto'].'</td>';
				echo '<td>'.$row2['anno_proto'].'</td>';
			echo "</tr>\n";
		}
	}
	?>

	 </tbody>
	</table>
		</div>

<?
}
// ------------------------- FINE RICERCA A VIDEO ------------------
?>

<div class="row">&nbsp;</div>

<?
include($percorso_relativo."grafica/body_foot_bootstrap_agid.php");
?>
