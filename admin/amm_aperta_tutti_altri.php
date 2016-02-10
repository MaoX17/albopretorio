<?php
include ("../include.inc.php");

$percorso_relativo = "../";

/*
 * Config e chiamo DB *******************************
 */
require_once ($percorso_relativo.'class/ConfigSingleton.php');
$cfg = SingletonConfiguration::getInstance ();
require_once ($percorso_relativo."class/Db.php");
$factory=DbAbstractionFactory::getFactory($cfg->getValue('AstrazioneDB'));
$factory->setDsn($cfg->getValue('DSN'));
$db=$factory->createInstance();
//********************************************************




require_once $percorso_relativo.'class/Albo.php';
require_once $percorso_relativo.'class/Area.php';
require_once $percorso_relativo.'class/Tipo.php';


$titolo_pagina = "Atti da trattare - Visualizzazione Amminitrazione Aperta - Provincia di Prato";

include($percorso_relativo."grafica/amm_aperta_head.php");
include($percorso_relativo."grafica/amm_aperta_body_head.php");


/******** Serve per l'escape di potenziali caratteri non corretti *******************/
foreach ($_POST as $key => $value) {
        $_POST[$key] = $db->escapeSimple($_POST[$key]);
}

$oggi = dt_oggi();
		
?>

<!-- Intestazione tabella -->
<br/>

<table border="1">
<tr>
<th>Num. Reg</th>
<th>Tipo</th>
<th>Num. Atto</th>
<th>Data</th>
<th>Oggetto</th>
<th>Autorit&agrave emanante</th>
<th>Area di riferimento</th>
<th>Responsabile di Area</th>
<th>In pubblicazione dal</th>
<th>In pubblicazione al</th>
<th>Note</th>
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
		LEFT JOIN amm_aperta ON albi.id_albo = amm_aperta.id_albo
		WHERE
		amm_aperta.id_albo IS NULL 
		  
   		AND ((albi.da_validare != 'S') OR (albi.da_validare IS NULL))
   		AND (tipi.id_tipo = 3)
   		   		
   		ORDER BY albi.id_albo DESC;";
	//AND albi.dt_atto >= '".venti_giorni_fa()."'
	
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
		//die($rs->getMessage());
  	}
	else {
		$result = TRUE;
/*		
		$tmp = new Albo();
		$tmp2 = new Albo();
		$tmp2 = $tmp->caricaDalDB2($row['id_albo']);
*/
		echo "<tr>";
		
		echo '<td><a href="./amm_aperta_modifica.php?id_albo='.$row['id_albo'].'">'.$row['id_albo']."</a></td>";
				
		// Visualizzo il risultato in tabella
		
		echo "<td>".$row['tipo']."</td>";
		echo "<td>".$row['nr_atto']."</td>";
		echo "<td>".$row['dt_atto']."</td>";
		echo "<td>".$row['oggetto']."</td>";
		echo "<td>".$row['autorita_emanante']."</td>";
		echo ($row['area'] == " ") ? "<td>&nbsp;</td>" : "<td>".$row['area']."</td>";
		echo ($row['responsabile'] == " ") ? "<td>&nbsp;</td>" : "<td>".$row['responsabile']."</td>";
		
		echo "<td>".$row['dt_pubblicaz_dal']."</td>";
		echo "<td>".$row['dt_pubblicaz_al']."</td>";
		echo "<td>".$row['note']."</td>";

		echo "</tr>\n";
	}
}
 


?>

</table>

 
<?
include($percorso_relativo."grafica/body_foot.php");
?>
