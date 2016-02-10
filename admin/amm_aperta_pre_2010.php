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

setlocale(LC_MONETARY, 'it_IT');

//Prelevo un id_albo libero partendo da "000000000"
$amm_aperta= AmmApertaQuery::create()
		->filterByIdAlbo(array("min" => 0, "max" => 201000000))
		->orderByIdAlbo('desc')
		->findOne();

$id_temporaneo = $amm_aperta->getIdAlbo();

$amm_aperta = new AmmAperta();
$amm_aperta->setIdAlbo($id_temporaneo + 1);

?>

<div class="container">

	<div class="row">
		<div class="hidden">
			<h2><?=$titolo_pagina?></h2>
		</div>
		<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
			<h3>Inserisci un atto precedente al 01.01.2010</h3>
		</div>
	</div>

	<?php
	/******** Serve per l'escape di potenziali caratteri non corretti *******************/
	foreach ($_POST as $key => $value) {
		$_POST[$key] = $db->escapeSimple($_POST[$key]);
	}

	?>

<?
//TODO: aggiungere tabella e dati di un atto non ufficiale ma con qualche dato di riferimento per gli atti precedenti al 2010 oppure mandare un collegamento ai dati non ufficiali pre-2010 (http://determine.prvprato1/determine/)
?>

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
								<input required value="<?=$amm_aperta->getPiva()?>" name="piva" type="text" class="form-control" id="C_piva" />
							</div>
						</div>
						<div class="form-group">
							<label for="C_resp_proc" class="col-sm-2 control-label">Responsabile Procedimento:</label>
							<div class="col-sm-10">
								<input required value="<?=$amm_aperta->getRespProc()?>" name="resp_proc" type="text" class="form-control" id="C_resp_proc" />
							</div>
						</div>
						<div class="form-group">
							<label for="C_norma" class="col-sm-2 control-label">Norma:</label>
							<div class="col-sm-10">
								<input required value="<?=$amm_aperta->getNorma()?>" name="norma" type="text" class="form-control" id="C_norma" />
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
									<span class="input-group-addon">
										<span class="fa fa-euro"></span></span>
									<input required value="<?=$amm_aperta->getImporto()?>" name="importo" type="number" placeholder="100,10" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control" id="C_importo" />
								</div>
								<span class="help-inline alert alert-block"><span class="fa fa-info-circle"></span>
									Inserire l'importo. Se non presente inserire il numero zero.</span>
							</div>
						</div>
						<div class="form-group">
							<label for="C_pubblicato" class="col-sm-2 control-label">Pubblicato (S/N):</label>
							<div class="col-sm-10">
								<input required value="<?=$amm_aperta->getPubblicato()?>" name="pubblicato" type="text" class="form-control" id="C_pubblicato" />
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


