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

$titolo_pagina = "Risultati Ricerca";

include($percorso_relativo."grafica/head.php");
include($percorso_relativo."grafica/body_head.php");

?>

<form name="MyForm" action="valida_albo_2010_03.php" method="post">

<!-- seleziona area -->
<br/>
<fieldset>
 	<legend>Area....</legend>
		<select name="area" >

<?php 
$sql = 
		"SELECT * FROM aree
		ORDER BY area ASC;";

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
		// Visualizzo il risultato 
	   	echo '<option value="'.$row['id_area'].'">'.$row['area'].' - '.$row['responsabile'].'</option>';
	}
}

?>
   		</select>
</fieldset>


<!-- Intestazione tabella -->
<br/>

<fieldset>
	<legend>Linguaggi conosciuti</legend><br>

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
		<th>Seleziona</th>
	</tr>

<?php 
//ESEGUO SELECT 
$sql = 
		"SELECT * FROM albi
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
$i = 0;
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
		//echo "<td><a href='valida_albo_from_proto02.php?id_albo=".$row['id_albo']."'>".$row['id_albo']."</a></td>";
		echo "<td>".$row['id_albo']."</a></td>";
		echo "<td>".$row['tipo']."</td>";
		echo "<td>".$row['nr_atto']."</td>";
		echo "<td>".$row['dt_atto']."</td>";
		echo "<td>".$row['oggetto']."</td>";
		echo "<td>".$row['autorita_emanante']."</td>";
		echo "<td>".$row['area']."</td>";
		echo "<td>".$row['responsabile']."</td>";
		echo "<td>".$row['dt_pubblicaz_dal']."</td>";
		echo "<td>".$row['dt_pubblicaz_al']."</td>";
		echo "<td>".'<input type="checkbox" name="myCheck['.$i.']" value="'.$row['id_albo'].'"/> </td>';
		echo "</tr>";
		$i++;
	}
}
?>

</table>

</fieldset>

<br>

<input type="submit" value="ok">

</form>

<?
include($percorso_relativo."grafica/body_foot.php");
?>
