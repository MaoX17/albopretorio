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
		<div class="hidden">
			<h2><?=$titolo_pagina?></h2>
		</div>
		<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
			<h3>Modifica Dati - Ammninistrazione Aperta</h3>
		</div>
	</div>



	<div class="row">
		<div class="col-xs-12 col-sm-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Ricerca atto per Amministrazione Aperta</h3>
				</div>
				<div class="panel-body">
					<form class="form-horizontal" name='myForm' id='myForm' action="/admin/amm_aperta_cerca_modifica2.php" method="get">
						<div class="form-group">
							<label for="C_numero" class="col-sm-2 control-label">Nr. Atto:</label>
							<div class="col-sm-10">
								<input class="form-control" type="text" name="numero" id="C_numero"  />
							</div>
						</div>
						<div class="form-group">
							<label for="C_dt_atto_dal" class="col-sm-2 control-label">Data Atto DAL (aaaa-mm-gg):</label>
							<div class="col-sm-10">
								<div id="dt_atto_dal" class="input-group date">
									<input class="form-control" type="text" id="C_dt_atto_dal" name="dt_atto_dal" readonly  />
									<span class="input-group-addon"><span class="fa fa-calendar"></span></span>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="C_dt_atto_al" class="col-sm-2 control-label">Data Atto AL (aaaa-mm-gg):</label>
							<div class="col-sm-10">
								<div id="dt_atto_al" class="input-group date">
									<input class="form-control" type="text" id="C_dt_atto_al" name="dt_atto_al" readonly  />
									<span class="input-group-addon"><span class="fa fa-calendar"></span></span>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="C_oggetto" class="col-sm-2 control-label">Oggetto:</label>
							<div class="col-sm-10">
								<input class="form-control" type="text" name="oggetto" id="C_oggetto"   />
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<input class="btn btn-primary" name="ok" type="submit" value="Esegui Ricerca ->" />
							</div>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>
</div>


<?
include($percorso_relativo."grafica/body_foot_bootstrap_agid.php");
?>

