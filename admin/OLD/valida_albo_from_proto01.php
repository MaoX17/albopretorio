<?php
include ("../include.inc.php");

/*
 * Config e chiamo DB *******************************
 */
require_once ('../class/ConfigSingleton.php');
$cfg = SingletonConfiguration::getInstance ();
require_once ("../class/Db.php");
$factory=DbAbstractionFactory::getFactory($cfg->getValue('AstrazioneDB'));
$factory->setDsn($cfg->getValue('DSN'));
$db=$factory->createInstance();
//********************************************************

$percorso_relativo = "../";

//prende il tipo corretto xche ho un class-loader in include
//$impianto = unserialize($_SESSION['impianto']);

$titolo_pagina = "Risultati Ricerca";

include($percorso_relativo."grafica/head.php");
include($percorso_relativo."grafica/body_head.php");


/******** Serve per l'escape di potenziali caratteri non corretti *******************/
foreach ($_POST as $key => $value) {
        $_POST[$key] = $db->escapeSimple($_POST[$key]);
        if ($_POST[$key] == "") { $_POST[$key] = "%"; }
}
?>


<!-- Intestazione tabella -->
<br/>

<table border="1">
<tr>
<th>Num. Reg.</th>
<th>Tipo</th>
<th>Nr.</th>
<th>Data</th>
<th>Oggetto</th>
<th>Autorit&agrave emanante</th>
<th>Area di riferimento</th>
<th>Responsabile di Area</th>
<th>Pubblicata Dal</th>
<th>Pubblicata Al</th>
<!-- <th>Documento</th>  -->
</tr>

<?php 
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
		albi.autorita_emanante,
		albi.id_area,
		albi.file,
		aree.id_area,
		aree.responsabile,
		aree.area,
		tipi.id_tipo,
		tipi.tipo
		FROM
		albi
		Inner Join aree ON albi.id_area = aree.id_area
		Inner Join tipi ON albi.id_tipo = tipi.id_tipo
		WHERE
 		albi.da_validare = 'S' 
		ORDER BY albi.id_albo ASC;";

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
		echo "<tr>";
		echo "<td><a href='valida_albo_from_proto02.php?id_albo=".$row['id_albo']."'>".$row['id_albo']."</a></td>";
		echo "<td>".$row['tipo']."</td>";
		echo "<td>".$row['nr_atto']."</td>";
		echo "<td>".$row['dt_atto']."</td>";
		echo "<td>".$row['oggetto']."</td>";
		echo "<td>".$row['autorita_emanante']."</td>";
		echo "<td>".$row['area']."</td>";
		echo "<td>".$row['responsabile']."</td>";
		echo "<td>".$row['dt_pubblicaz_dal']."</td>";
		echo "<td>".$row['dt_pubblicaz_al']."</td>";
//		echo "<td style='text-align: center;'><a href='http://albopretorio.provincia.prato.it/files/".$row['file']."' > <img src='".$percorso_relativo."grafica/images/pdf.gif'></a></td>";
		echo "</tr>";
	}
}
?>

</table>


<?
include($percorso_relativo."grafica/body_foot.php");
?>
