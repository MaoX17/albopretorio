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

//var_dump($_POST);

$albo = AlbiQuery::create()
		->findPk($_POST['id_albo']);

$amm_aperta = AmmApertaQuery::create()
		->filterByIdAlbo($_POST['id_albo'])
		->findOneOrCreate();

if ($amm_aperta->getPubblicato() == "") {
	$amm_aperta->setPubblicato("N");
}

if (($amm_aperta->getPubblicato() == "N") AND (($amm_aperta->getDtPubblicazione() == "") OR (($amm_aperta->getDtPubblicazione() == "0000-00-00")))) {
	$oggi = new DateTime('now');
	$amm_aperta->setDtPubblicazione($oggi);
}


//$amm_aperta->setIdAlbo($albo->getIdAlbo());
$amm_aperta->setRagionesociale($_POST['ragionesociale']);
$amm_aperta->setPiva(preg_replace("/^'|[^A-Za-z0-9@\/.\s-]|'$/", '', $_POST['piva']));
//$amm_aperta->setPiva($_POST['piva']);
$amm_aperta->setRespProc($_POST['resp_proc']);
$amm_aperta->setRespProcIdrubrica($_POST['resp_proc_id']);
//NOTE: questo serve per ripulire il testo da eventuali caratteri speciali
$amm_aperta->setNorma(preg_replace("/^'|[^A-Za-z0-9@\/.\s-]|'$/", '', $_POST['norma']));
//$amm_aperta->setNorma($_POST['norma']);
$amm_aperta->setModalita(preg_replace("/^'|[^A-Za-z0-9@\/.\s-]|'$/", '', $_POST['modalita']));
//$amm_aperta->setModalita($_POST['modalita']);
$amm_aperta->setImporto($_POST['importo']);
$amm_aperta->setPubblicato(strtoupper($_POST['pubblicato']));

//NOTE: eliminato commento
$amm_aperta->save();
//var_dump($amm_aperta);


?>


<div class="container">
	<div class="row">
		<div class="col-xs-12 col-sm-12">
			<h1><?=$titolo_pagina?></h1>
			<h2>Riepilogo Dati inseriti</h2>
		</div>
	</div>

		<div class="row">
			<div class="col-xs-12">

				<?php
					$albo = AlbiQuery::create()
							->findPk($amm_aperta->getIdAlbo());

					if (is_object($albo)) {
						$area = AreeQuery::create()
								->findPk($albo->getIdArea());

						$tipo = TipiQuery::create()
								->findPk($albo->getIdTipo());
					}
					?>

					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title"><strong>Oggetto:</strong> <?=(is_object($albo)?$albo->getOggetto(): " ")?></h3>
							<small>
								<?php
								if (is_object($albo)) {
									if ($albo->getNote() != "") {
										?>
										NOTE: <?= $albo->getNote() ?>
										<?php
									}
								}
								?>
							</small>
						</div>
						<div class="panel-body">
							<p></p>
							<ul>
								<li><strong>Nr. Registro: </strong>
									<?php
									if (is_object($albo)) {
										?>
										<a href="<?=$percorso_relativo?>visualizza-dettagli.php?id_albo=<?=$albo->getIdAlbo()?>">
											<?=$albo->getNrAtto()?><span class="fa fa-download"></span></a>
										<?php
									}
									else {
										?>
										<?=$amm_aperta->getIdAlbo()?>
										<?php
									}
									?>
								</li>

								<li><strong>Nr. Atto: </strong><?=(is_object($albo)?$albo->getNrAtto():" ")?></li>
								<li><strong>Data Atto: </strong><?=(is_object($albo)?$albo->getDtAtto()->format("d.m.y"): " ")?></li>
								<li><strong>Area di riferimento: </strong><?=(isset($area) && is_object($area)?$area->getArea():" ")?></li>
								<li><strong>Responsabile di Area: </strong><?=(isset($area) && is_object($area)?$area->getResponsabile():" ")?></li>
								<li><strong>Data di pubblicazione: </strong><?=$amm_aperta->getDtPubblicazione()->format("d.m.y")?></li>
								<li><strong>Ragione Sociale: </strong><?=$amm_aperta->getRagionesociale()?></li>
								<li><strong>Partita IVA/Cod. Fiscale: </strong><?=$amm_aperta->getPiva()?></li>
								<li><strong>Responsabile del Procedimento: </strong><?=$amm_aperta->getRespProc()?></li>
								<li><strong>Norma o Titolo: </strong><?=$amm_aperta->getNorma()?></li>
								<li><strong>Modalit&agrave;: </strong><?=$amm_aperta->getModalita()?></li>
								<li><strong>Importo: </strong><?=money_format('%.2n', $amm_aperta->getImporto())?></li>
								<li><strong>Pubblicato: </strong><?=$amm_aperta->getPubblicato()?></li>

							</ul>
						</div>
					</div>
			</div>
			<a href="/" class="btn btn-default">Torna all'albo pretorio</a>
		</div>
</div>



<?
include($percorso_relativo."grafica/body_foot_bootstrap_agid.php");
?>
