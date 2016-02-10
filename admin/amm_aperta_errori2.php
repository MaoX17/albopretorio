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

$titolo_pagina = "Visualizzazione - Amministrazione Aperta - Provincia di Prato";

$oggi = date("Y-m-d");
setlocale(LC_MONETARY, 'it_IT');

$limit_per_page = 50;
$page = (isset($_GET['page']))?$_GET['page']:1;

//NOTE: Cerco gli atti pubblicati con importo minore di 1000 euri
$amm_aperte = AmmApertaQuery::create()
		->filterByImporto(array("min" => 0, "max" => 500))
		->orderByIdAmmAperta('desc')
		->paginate($page, $limit_per_page);

?>

<div class="container">
	<div class="row">
		<div class="hidden">
			<h2><?=$titolo_pagina?></h2>
		</div>
		<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
			<h3>Errori da risolvere</h3>
		</div>
	</div>

		<!-- Per dispositivi con piccolo schermo -->
		<div class="row">
			<div class="col-xs-12 hidden-lg hidden-md">

				<?php
				foreach ($amm_aperte as $amm_aperta) {

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
							<p>

							</p>
						</div>
						<div class="panel-body">
							<p></p>
							<ul>
								<li><strong>Nr. Registro: </strong>
									<?php
									if (is_object($albo)) {
										?>
										<a href="/admin/amm_aperta_modifica.php?id_albo=<?=$albo->getIdAlbo()?>">
											<?=$albo->getNrAtto()?><span class="glyphicon glyphicon-download-alt"></span></a>
										<?php
									}
									else {
										?>
										<a href="/admin/amm_aperta_modifica.php?id_albo=<?=$amm_aperta->getIdAlbo()?>">
											<?=$amm_aperta->getIdAlbo()?>
											<span class="glyphicon glyphicon-download-alt"></span></a>
										<?php
									}
									?>
								</li>

								<li><strong>Nr. Atto: </strong><?=(is_object($albo)?$albo->getNrAtto():" ")?></li>
								<li><strong>Data Atto: </strong><?=(is_object($albo)?$albo->getDtAtto()->format("d.m.y"): " ")?></li>
								<li><strong>Area di riferimento: </strong><?=(isset($area) && is_object($area)?$area->getArea():" ")?></li>
								<li><strong>Responsabile di Area: </strong><?=(isset($area) && is_object($area)?$area->getResponsabile():" ")?></li>
								<li><strong>Data di pubblicazione: </strong><?=(is_object($amm_aperta->getDtPubblicazione())?$amm_aperta->getDtPubblicazione()->format("d.m.y"):" ")?></li>
								<li><strong>Ragione Sociale: </strong><?=$amm_aperta->getRagionesociale()?></li>
								<li><strong>Partita IVA/Cod. Fiscale: </strong><?=$amm_aperta->getPiva()?></li>
								<li><strong>Responsabile del Procedimento: </strong><?=$amm_aperta->getRespProc()?></li>
								<li><strong>Norma o Titolo: </strong><?=$amm_aperta->getNorma()?></li>
								<li><strong>Modalit&agrave;: </strong><?=$amm_aperta->getModalita()?></li>
								<li><strong>Importo: </strong><?=money_format('%.2n', $amm_aperta->getImporto())?></li>

							</ul>
						</div>
					</div>
					<?php
				}
				?>
			</div>
		</div>

<div class="row">
		<!-- Per dispositivi con grande schermo -->
		<div class="col-sm-12 hidden-xs hidden-sm">

			<table class="table table-bordered table-striped table-responsive">
				<thead>
				<tr>
					<th>Titolo</th>
					<th>Data Pubblicazione</th>
					<th>Ragione Sociale Beneficiario</th>
					<th>Partita IVA Beneficiario</th>
					<th>Responsabile Procedimento</th>
					<th>Norma o Titolo</th>
					<th>Modalit&agrave;</th>
					<th>Importo</th>
				</tr>
				</thead>
				<tbody>

				<?php
				foreach ($amm_aperte as $amm_aperta) {

					$albo = AlbiQuery::create()
							->findPk($amm_aperta->getIdAlbo());

					if (is_object($albo)) {
						$area = AreeQuery::create()
								->findPk($albo->getIdArea());

						$tipo = TipiQuery::create()
								->findPk($albo->getIdTipo());
					}
					?>

					<tr>
						<td>
							<?php
							if (is_object($albo)) {
								?>
								<a href="/admin/amm_aperta_modifica.php?id_albo=<?=$albo->getIdAlbo()?>">
									<span class="glyphicon glyphicon-download-alt"></span> Atto nr. <?=$albo->getNrAtto()?> del <?=$albo->getDtAtto()->format("d.m.y")?></a>
								<?php
							}
							else {
								?>
								<a href="/admin/amm_aperta_modifica.php?id_albo=<?=$amm_aperta->getIdAlbo()?>">
									<?=$amm_aperta->getNorma()?>
									<span class="glyphicon glyphicon-download-alt"></span></a>

								<?php
							}
							?>
						</td>
						<td><?=(is_object($amm_aperta->getDtPubblicazione())?$amm_aperta->getDtPubblicazione()->format("d.m.y"):$amm_aperta->getDtPubblicazione())?></td>
						<td><?=$amm_aperta->getRagionesociale()?></td>
						<td><?=$amm_aperta->getPiva()?></td>
						<td><?=$amm_aperta->getRespProc()?></td>
						<td><?=$amm_aperta->getNorma()?></td>
						<td><?=$amm_aperta->getModalita()?></td>
						<td><?=money_format('%.2n', $amm_aperta->getImporto())?></td>
					</tr>

					<?php
				}
				?>


				</tbody>

			</table>

		</div>
	</div>







	<div class="row">
		<?php // PropelModelPager offers a convenient API to display pagination controls ?>
		<?php if($amm_aperte->haveToPaginate()): ?>
			<div class="pagination">
				<ul class='pagination'>
					<li>
						<a href="#"><?php echo $amm_aperte->getPage() ?> di <?php echo $amm_aperte->getLastPage() ?></a>
					</li>
					<?php
					if ($amm_aperte->getPage() == 1) {
						echo '<li class="disabled"><a href = "#">&laquo;</a></li>';
					}
					else {
						echo '<li><a href = "'.$_SERVER['PHP_SELF'].'?page='.($amm_aperte->getPage() - 1).'">&laquo;</a></li>';
					}
					?>



					<?php
					if ($amm_aperte->getPage() == $amm_aperte->getLastPage()) {
						echo '<li class="disabled"><a href = "#">&raquo;</a></li>';
					}
					else {
						echo '<li><a href = "'.$_SERVER['PHP_SELF'].'?page='.($amm_aperte->getPage() + 1).'">&raquo;</a></li>';
					}
					?>

				</ul>

			</div>


		<?php endif; ?>

	</div>
</div>

<?
include($percorso_relativo."grafica/body_foot_bootstrap_agid.php");
?>
