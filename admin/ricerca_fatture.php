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
require_once $percorso_relativo.'class/Albo.php';
require_once $percorso_relativo.'class/Area.php';
require_once $percorso_relativo.'class/Tipo.php';
require_once $percorso_relativo.'class/Tipo_determina.php';
require_once $percorso_relativo.'class/Tipo_trasp.php';

// ####### OLD ##########

$titolo_pagina = "Ricerca Fatture - Provincia di Prato";

$albo = new Albo();
$tipo = new Tipo();
$area = new Area();
$tipo_determina = new Tipo_determina();
$tipo_trasp = new Tipo_Trasp();

$albo->setTipo($tipo);
$albo->setArea($area);
$albo->setTipo_determina($tipo_determina);
$albo->setTipo_trasp($tipo_trasp);

?>


<div class="container">

	<div class="row">

		<!-- Colonna centrale-SX -->
		<div class="col-xs-12 col-sm-10">

			<h2><?=$titolo_pagina ?></h2>

		</div>
		<!-- /Colonna centrale-SX -->
	</div><!--/row-->

	<form name='myForm' id='myForm' action="/admin/ricerca_fatture2.php" method="post">

	<div class="row">
		<div class="col-xs-12 col-sm-10">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Scegli i campi di ricerca</h3>
				</div>
				<div class="panel-body">

					<table>
					<tr>
						<th><label for="C_mittente">Mittente</label>: </th>
						<td>
							<input type="text" name="mittente" id="C_mittente" alt="mittente"  />
						</td>
					</tr>
					<tr>
						<th><label for="C_mittente">ID SDI</label>: </th>
						<td>
							<input type="text" name="id_sdi" id="C_id_sdi" alt="id_sdi"  />
						</td>
					</tr>

						</table>
						<br/>

					<input class="btn btn-primary" name="ok" type="submit" value="Esegui Ricerca ->" />
					<!-- <input class="btn btn-warning" name="ok" type="submit" value="Genera Excel ->" /> -->
				</div>
			</div>
		</div>
	</div>

	</form>

</div>

<?
include($percorso_relativo."grafica/body_foot_bootstrap.php");
?>

