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
require_once ($percorso_relativo.'class/ConfigSingleton.php');
$cfg = SingletonConfiguration::getInstance ();
//$user_db = $cfg->getValue('UserDB');
$titolo_pagina = $cfg->getValue('titolo_applicazione');
//include($percorso_relativo."grafica/head_bootstrap.php");
//include($percorso_relativo."grafica/body_head_bootstrap.php");
include($percorso_relativo."grafica/head_bootstrap_agid.php");
include($percorso_relativo."grafica/body_head_bootstrap_agid.php");

// ####### OLD ##########
require_once ($percorso_relativo."class/Db.php");
$factory=DbAbstractionFactory::getFactory($cfg->getValue('AstrazioneDB'));
$factory->setDsn($cfg->getValue('DSN'));
$db=$factory->createInstance();
require_once $percorso_relativo.'class/Albo.php';
require_once $percorso_relativo.'class/Area.php';
require_once $percorso_relativo.'class/Tipo.php';
require_once $percorso_relativo.'class/Tipo_determina.php';
require_once $percorso_relativo.'class/Tipo_trasp.php';

// ####### OLD ##########

//recupero dati albo...
$albo = AlbiQuery::create()
	->findPk($_GET['id_albo']);

$tipo_atto = TipiQuery::create()
	->findPk($albo->getIdTipo());


$area = AreeQuery::create()
		->findPk($albo->getIdArea());


if ($albo->getIdTipoTrasp() != null) {
	$tipo_trasp = TipiTraspQuery::create()
			->findPk($albo->getIdTipoTrasp());
}

if ($albo->getIdTipoDetermina() != null) {
	$tipo_determina = TipiDeterminaQuery::create()
		->findPk($albo->getIdTipoTrasp());
}


$files_albo = FilesQuery::create()
 	->filterByIdAlbo($albo->getIdAlbo())
	->find();


?>

<div class="container">

	<div class="row">
		<div class="hidden">
			<h2><?=$titolo_pagina?></h2>
		</div>
		<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
			<h3>Modifica i dati</h3>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12 col-sm-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Inserimento Dati</h3>
				</div>
				<div class="panel-body">
					<form class="form-horizontal" name='myForm' id='myForm' action="/admin/annulla_atto2.php" method="post" enctype="multipart/form-data">

						<input type="hidden" name="id_albo" value="<?=$albo->getIdAlbo()?>">

						<div class="form-group">
							<label for="C_oggetto" class="col-sm-2 control-label">Oggetto:</label>
							<div class="col-sm-10">
								<input required class="form-control"
									   type="text" name="oggetto" id="C_oggetto"
									   value="ATTO ANNULLATO - <?=$albo->getOggetto()?> - ATTO ANNULLATO"/>
							</div>
						</div>

						<div class="form-group">
							<label for="C_note" class="col-sm-2 control-label">Note:</label>
							<div class="col-sm-10">
								<input value="<?=$albo->getNote()?>" class="form-control" type="text" name="note" id="C_note" />
							</div>
						</div>

						<?php
						//File già presenti da selezionare per eliminarli
						foreach ($files_albo as $file_albo) {
							if ($file_albo->getFromBlob() == 's') {
								$cartella_files = "/files/";
								//$disabled = ' ';
							}
							else {
								$cartella_files = "/files_nfs/";
								//$disabled = ' disabled ';
							}

							?>
							<div>
								<div class="col-sm-10 col-sm-offset-2">
									<input type="checkbox" name="delfile_<?=$file_albo->getIdFiles()?>">
									Elimina il File: <a target="_blank" href="<?=$cartella_files.$file_albo->getFile()?>"> <?=$file_albo->getFile()?></a>
								</div>
							</div>
							<?php
						}
						?>

						<?php
						for ($i=0;$i<=10;$i++) {
							?>
							<div class="form-group">
								<label for="upload_file_<?=$i?>" class="col-sm-2 control-label">Inserisci File <?=$i?></label>
								<div class="col-sm-10">
									<input type="file" class="form-control" name="upload_file[]" id="upload_file_<?=$i?>" >
								</div>
							</div>
							<?
						}
						?>


						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<input class="btn btn-primary" name="ok" type="submit" value="Esegui le modifiche all'Albo ->" />
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

