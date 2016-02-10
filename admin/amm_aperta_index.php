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

$titolo_pagina = "Amministrazione Aperta - Provincia di Prato";

// ####### OLD ##########
require_once ("class/Db.php");
$factory=DbAbstractionFactory::getFactory($cfg->getValue('AstrazioneDB'));
$factory->setDsn($cfg->getValue('DSN'));
$db=$factory->createInstance();
require_once $percorso_relativo.'class/Albo.php';
require_once $percorso_relativo.'class/Area.php';
require_once $percorso_relativo.'class/Tipo.php';
require_once $percorso_relativo.'class/Tipo_determina.php';
require_once $percorso_relativo.'class/Tipo_trasp.php';

// ####### OLD ##########

?>

<div class="container">
	<div class="row">
		<div class="hidden">
			<h2><?=$titolo_pagina?></h2>
		</div>
		<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
			<h3>Amministrazione Aperta- Sez. Admin</h3>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12">
			<ul>

	            <li><a href="<?=$percorso_relativo?>amm_aperta_visualizza.php">Visualizzazione Pubblica</a></li>
				<li><a href="<?=$percorso_relativo?>admin/amm_aperta_cerca_modifica.php">Nuovo Inserimento o Modifica</a></li>
				<!-- <li><a href="<?=$percorso_relativo?>admin/amm_aperta_da_trattare.php">Inserisci un nuovo atto SUCCESSIVO al 01/01/2010</a></li>
				<li><a href="<?=$percorso_relativo?>admin/amm_aperta_pre_2010.php">Inserisci atto precedenti al 01/01/2010</a></li>
				<li><a href="<?=$percorso_relativo?>admin/amm_aperta_pre_2010_modifica.php">MODIFICA atto precedente al 01/01/2010</a></li>
				<li><a href="<?=$percorso_relativo?>admin/amm_aperta_pubb.php">Controlla e modifica atti pubblicati</a></li>
				<li><a href="<?=$percorso_relativo?>admin/amm_aperta_spubb.php">Controlla e modifica atti NON pubblicati</a></li> -->


			</ul>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12">
			<ul>

				<li><a href="<?=$percorso_relativo?>admin/amm_aperta_errori.php">Possibili errori</a></li>
				<li><a href="<?=$percorso_relativo?>admin/amm_aperta_errori2.php">Possibili errori 2</a></li>

			</ul>
		</div>
	</div>


</div>


<?
include($percorso_relativo."grafica/body_foot_bootstrap_agid.php");
?>
