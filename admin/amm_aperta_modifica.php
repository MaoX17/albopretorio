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


$albo = AlbiQuery::create()
	->findPk($_GET['id_albo']);

$amm_aperta = AmmApertaQuery::create()
	->filterByIdAlbo($_GET['id_albo'])
	->findOneOrCreate();

?>

<div class="container">

	<div class="row">
		<div class="col-xs-12 col-sm-10">
			<h1><?=$titolo_pagina?></h1>
		</div>
	</div>

	<?php
	/******** Serve per l'escape di potenziali caratteri non corretti *******************/
	foreach ($_POST as $key => $value) {
		$_POST[$key] = $db->escapeSimple($_POST[$key]);
	}

?>



	<div class="row">
		<div class="col-xs-12">
			<?php
			if (isset($albo) && is_object($albo)) {
				$area = AreeQuery::create()
					->findPk($albo->getIdArea());
				$tipo = TipiQuery::create()
					->findPk($albo->getIdTipo());
			}
			?>
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title"><strong>Oggetto:</strong> <?=(isset($albo) && is_object($albo)?$albo->getOggetto(): " ")?></h3>
						<?php
						if (isset($albo) && is_object($albo)) {
							if ($albo->getNote() != "") {
								?>
								<small>
									NOTE: <?=$albo->getNote()?>
								</small>
								<?php
							}
						}
						?>


					</div>
					<div class="panel-body">
						<p></p>
						<ul>
							<li><strong>Nr. Atto: </strong><?=(isset($albo) && is_object($albo)?$albo->getNrAtto():" ")?></li>
							<li><strong>Data Atto: </strong><?=(isset($albo) && is_object($albo)?$albo->getDtAtto()->format("d.m.y"): " ")?></li>
							<li><strong>Area di riferimento: </strong><?=(isset($area) && is_object($area)?$area->getArea():" ")?></li>
							<li><strong>Responsabile di Area: </strong><?=(isset($area) && is_object($area)?$area->getResponsabile():" ")?></li>
							<li><strong>In pubblicazione: </strong>
								dal <?=(isset($albo) && is_object($albo)?$albo->getDtPubblicazDal()->format("d.m.y"):" ")?>
								al <?=(isset($albo) && is_object($albo)?$albo->getDtPubblicazAl()->format("d.m.y"):" ")?>
							</li>
							<li><strong>Autorit&agrave; emanante: </strong><?=(isset($albo) && is_object($albo)?$albo->getAutoritaEmanante():" ")?></li>

						</ul>
					</div>
				</div>
		</div>
	</div>




	<div class="row">
		<div class="col-xs-12 col-sm-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Inserimento Dati per Amministrazione Aperta</h3>
				</div>
				<div class="panel-body">
					<form class="form-horizontal" name='myForm' id='myForm' action="/admin/amm_aperta_modifica2.php" method="post" enctype="multipart/form-data">

						<input type="hidden" name="id_albo" value="<?=$amm_aperta->getIdAlbo()?>" />

						<div class="form-group">
							<label for="C_ragionesociale" class="col-sm-2 control-label">Ragione Sociale Beneficiario:</label>
							<div class="col-sm-10">
								<input required value="<?=$amm_aperta->getRagionesociale()?>" name="ragionesociale" type="text" class="form-control" id="C_ragionesociale" />
							</div>
						</div>
						<div class="form-group">
							<label for="C_piva" class="col-sm-2 control-label">Partita IVA o CF Beneficiario:</label>
							<div class="col-sm-10">
								<textarea required name="piva" class="form-control" id="C_piva"><?=$amm_aperta->getPiva()?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="resp_proc" class="col-sm-2 control-label">Responsabile Procedimento:</label>
							<div class="col-sm-10">
								<input onkeyup="autocomplet_responsabile(this)" autocomplete="off" required value="<?=$amm_aperta->getRespProc()?>" name="resp_proc" type="text" class="form-control" id="resp_proc" />
								<input class="form-control hidden" type="text" name="resp_proc_id" id="resp_proc_id">
								<input class="form-control hidden" type="text" name="resp_proc_id_servizio" id="resp_proc_id_servizio">
								<div class="list-group" id="responsabile_list_id">
								</div>


							</div>
						</div>
						<div class="form-group">
							<label for="C_norma" class="col-sm-2 control-label">Norma:</label>
							<div class="col-sm-10">
								<textarea required name="norma" class="form-control" id="C_norma"><?=$amm_aperta->getNorma()?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="C_modalita" class="col-sm-2 control-label">Modalit&agrave;:</label>
							<div class="col-sm-10">
								<input required value="<?=$amm_aperta->getModalita()?>" name="modalita" type="text" class="form-control" id="C_modalita" />
							</div>
						</div>
						<div class="form-group">
							<label for="C_importo" class="col-sm-2 control-label">Importo:</label>
							<div class="col-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><span class="fa fa-euro"></span></span>
									<input required value="<?=$amm_aperta->getImporto()?>" name="importo" type="number" placeholder="100,10" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control" id="C_importo" />
								</div>
								<span class="help-inline alert alert-block"><span class="fa fa-info-circle"></span>
									Inserire l'importo. Se non presente inserire il numero zero.</span>
							</div>
						</div>


						<div class="form-group">
							<label for="C_pubblicato" class="col-sm-2 control-label">Pubblicato (S/N):</label>
							<div class="col-sm-10">
								<select name="pubblicato" class="form-control" id="C_pubblicato" required>
									<option value="S" <?=($amm_aperta->getPubblicato()=="S"?" selected ": "")?> >S</option>
									<option value="N" <?=($amm_aperta->getPubblicato()=="N"?" selected ": "")?> >N</option>
								</select>
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<input class="btn btn-primary" name="ok" type="submit" value="Procedi" />
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


