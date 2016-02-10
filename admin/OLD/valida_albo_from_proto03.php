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

$titolo_pagina = "Registrazione Atto";


/******** Serve per l'escape di potenziali caratteri non corretti *******************/
foreach ($_POST as $key => $value) {
        $_POST[$key] = $db->escapeSimple($_POST[$key]);
}

include($percorso_relativo."grafica/head.php");
include($percorso_relativo."grafica/body_head.php");



require_once "../class/upload.class.php";

require_once '../class/Albo.php';
require_once '../class/Area.php';
require_once '../class/Tipo.php';


$albo = new Albo();
$tipo = new Tipo();
$area = new Area();

$tipo->setId_tipo($_POST['tipo']);
$tipo->setTipo($tipo->getTipoFromIdTipo($tipo->getId_tipo()));

$area->setId_area($_POST['area']);
$area->setArea($area->getAreaFromIdArea($area->getId_area()));
$area->setResponsabile($area->getRespFromIdArea($area->getId_area()));

$albo->setId_albo($_POST['id_albo']);

$albo->setArea($area);
$albo->setTipo($tipo);
$albo->setNr_atto($_POST['numero']);
$albo->setDt_atto($_POST['dt_atto']);
$albo->setOggetto($_POST['oggetto']);
$albo->setAutorita_emanante($_POST['autorita']);
$albo->setDt_pubblicaz_dal($_POST['dt_pubbl_dal']);
$albo->setDt_pubblicaz_al($_POST['dt_pubbl_al']);
$albo->setDa_validare('N');

$filename = $albo->getFilename_from_IdAlbo_DalDB($_POST['id_albo']);


$cartella_dest = $percorso_relativo."files/";
$nome_file_dest_finale = $_POST['dt_atto']."-".$_POST['numero']."-".$_POST['tipo'].".pdf";
$percorso_dest_finale = $cartella_dest.$nome_file_dest_finale;


$upload = new ClsUpload();
if ($upload->controllaFormato("documento")==FALSE) die("Errore - Formato file non valido, è permesso solo il formato pdf");
if ($upload->controllaPresenzaFiles("documento") == TRUE){
	//cancella originale, salva e concatena, aggiorna nel db il nome
	$upload->elimina($cartella_dest.$filename);
	$result = $upload->salva_e_concatena("documento",$cartella_dest."concatena",$percorso_dest_finale);	
}
//altrimenti rinomina sul filesystem e rinomina sul db
else {
	$upload->rinomina($cartella_dest.$filename,$cartella_dest.$nome_file_dest_finale);
}

echo "Controllo presenza = ".$upload->controllaPresenzaFiles("documento");

if ($result) {
	echo "Upload terminato con successo:<br>";
}

$albo->setFile($nome_file_dest_finale);

$risultato = $albo->aggiornaNelDB();

if ($risultato==FALSE) {
	die("Errore nella registrazione del documento sul DB");
}


?>

<br/><br/>
<a href="http://albopretorio.provincia.prato.it/admin/crea_albo.php">Inserisci un nuovo atto.</a> <br/>
<a href="http://albopretorio.provincia.prato.it">Torna alla Home dell'Albo Pretorio.</a><br/>
<br/>

<?
include($percorso_relativo."grafica/body_foot.php");
?>
