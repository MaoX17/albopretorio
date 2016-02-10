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
//il seguente codice serve solo per i validatori on-line (css xhtml accessibilità)
//($_POST["tipo_impianto"] == "") ? ($_POST["tipo_impianto"]="Solare Termico") : ($_POST["tipo_impianto"]=$_POST["tipo_impianto"]);

$titolo_pagina = "Inserimento nuovo Documento";

include($percorso_relativo."grafica/head.php");
include($percorso_relativo."grafica/body_head.php");


require_once '../class/Albo.php';
require_once '../class/Area.php';
require_once '../class/Tipo.php';

$area = new Area();
$area->setId_area($_POST['area']);
$area->setAreaFromIdArea($_POST['area']);
$area->setRespFromIdArea($_POST['area']);

$tipo = new Tipo();
$tipo->setId_tipo("3");
$tipo->setTipo($tipo->getTipoFromIdTipo($tipo->getId_tipo()));



foreach ($_POST['myCheck'] as $key => $value) {
    //echo "Hai selezionato la checkbox: $key con valore: $value<br />";
	$albo = new Albo();

	$id_albo = $value;
	$albo->caricaDalDB_2010($id_albo);
	
	$albo->setDt_pubblicaz_dal(date('Y-m-d'));
	$albo->setDt_pubblicaz_al(date('Y-m-d', strtotime("+15 days", strtotime(date('Y-m-d')))));

		
    $albo->setTipo($tipo);
	$albo->setArea($area);
	
	$albo->setDa_validare('N');

	$albo->aggiornaNelDB();
	$albo->serializzaNelDB();
	
	echo $albo;
} 


?>

<div class="titolo_pagina">
<h3>
<?=$titolo_pagina ?>
</h3>
</div>

<br></br>
<a href="valida_albo_2010_00.php">Torna all'inserimento numeri</a>
<br></br>
<a href="valida_albo_2010_02.php">Torna alla validazione e inserimento aree</a>
<br></br>

<?
include($percorso_relativo."grafica/body_foot.php");
?>

