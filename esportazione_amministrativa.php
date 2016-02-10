<?php
/**
 * Created by Maurizio Proietti
 * User: maurizio.proietti@gmail.com
 */
?>
<?php

$percorso_relativo = "./";
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

?>


<div class="container">

	<div class="row">
		<div class="hidden">
			<h2><?=$titolo_pagina?></h2>
		</div>
		<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
			<h3>Esportazione Dati</h3>
		</div>
	</div>

	<form name='myForm' id='myForm' action="esegui_esportazione_amministrativa.php" method="post">

	<div class="row">
		<div class="col-xs-12 col-sm-10">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Scegli i campi di ricerca</h3>
				</div>
				<div class="panel-body">

				<table>
				<tr>
					<th><label for="dt_atto_dal">Data Atto DAL (aaaa-mm-gg)</label>: </th>
					<td>
						<div id="dt_atto_dal" class="input-group date">
							<input class="form-control" type="text"  name="dt_atto_dal" readonly alt="data atto dal" >
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
						</div>

					</td>
				</tr>
				<tr>
					<th><label for="dt_atto_al">Data Atto AL (aaaa-mm-gg)</label>: </th>
					<td>
						<div id="dt_atto_al" class="input-group date">
							<input class="form-control" type="text" name="dt_atto_al" readonly alt="data atto al" />
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
						</div>

					</td>
				</tr>

				</table>
				<br/>


					<!--<input class="btn btn-primary" name="ok" type="submit" value="Esegui Ricerca ->" /> -->
					<input class="btn btn-warning" name="ok" type="submit" value="Genera Excel ->" />
				</div>
			</div>
		</div>
	</div>

	</form>

</div>

<?
include($percorso_relativo."grafica/body_foot_bootstrap_agid.php");
?>

