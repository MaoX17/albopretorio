<?php
$percorso_relativo = '../';
require_once ($percorso_relativo."include.inc.php");
$percorso_relativo = '../';

/*
 * Config e chiamo DB *******************************
 */
require_once ($percorso_relativo.'class/ConfigSingleton.php');
$cfg = SingletonConfiguration::getInstance ();
require_once ($percorso_relativo."class/Db.php");
$factory=DbAbstractionFactory::getFactory($cfg->getValue('AstrazioneDB'));
$factory->setDsn($cfg->getValue('DSN'));
$db=$factory->createInstance();

$factory3=DbAbstractionFactory::getFactory($cfg->getValue('AstrazioneDB3'));
$factory3->setDsn($cfg->getValue('DSN3'));
$db3=$factory3->createInstance();
//********************************************************

$titolo_pagina = "Risultati Ricerca";

require_once ($percorso_relativo."grafica/head.php");
require_once ($percorso_relativo."grafica/body_head.php");

require_once $percorso_relativo.'class/Albo.php';
require_once $percorso_relativo.'class/Area.php';
require_once $percorso_relativo.'class/Tipo.php';

?>
Numeri degli atti da importare dal 2010 (Determine) 
<br></br>
<form name="MyForm" action="valida_albo_2010_01.php" method="post">

<?

for ($i=0;$i<=99;$i++) {
	if (($i % 10) == 0) {
		echo "<br>";
	}
	else {
		echo " - ";
	} 
		
	echo '<input type="text" name="num_atto['.$i.']" size="4" >'."\n";
	
} 

?>

<br></br>
<input type="submit" value="OK">

</form>



<?
include($percorso_relativo."grafica/body_foot.php");
?>

