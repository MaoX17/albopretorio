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

require_once $percorso_relativo.'class/Rubrica.php';

$titolo_pagina = "Visualizzazione - Amministrazione Aperta - Provincia di Prato";

$oggi = date("Y-m-d");
setlocale(LC_MONETARY, 'it_IT');

//albi per pagina
$limit_per_page = 50;
$page = (isset($_GET['page']))?$_GET['page']:1;
//uso paginate x impaginazione
//filterByPublishedAt(array("min" => $searchDate." 00:00:00", "max" => $searchDate." 23:59:59"))

$amm_aperte = AmmApertaQuery::create()
		->filterByPubblicato("S")
		->orderByIdAmmAperta('desc')
		->paginate($page, $limit_per_page);

?>

<div class="container">
	<div class="row">
		<div class="hidden">
			<h2><?=$titolo_pagina?></h2>
		</div>
		<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
			<h3>Amministrazione Aperta</h3>
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
						</div>
						<div class="panel-body">
							<ul>
								<li><strong>Nr. Registro: </strong>
									<?php
									if (is_object($albo)) {
										?>
										<a title="apri il dettaglio" href="<?=$percorso_relativo?>visualizza-dettagli.php?id_albo=<?=$albo->getIdAlbo()?>">
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
								<li><strong>Area di riferimento: </strong><?=(is_object($area)?$area->getArea():" ")?></li>
								<li><strong>Responsabile di Area: </strong>
									<?
									if (is_object($area)) {
										$rubrica = new Rubrica();
										$rubrica->getUtenteConripulituraDati($area->getResponsabile());
										if ($rubrica->getCognome() != "") {
											?>
											<a href="http://rubrica.provincia.prato.it/index.php?servizio=%25&cognome=<?=$rubrica->getCognome()?>#risultati">
												<?=$area->getResponsabile()?>
												<span class="fa fa-phone"></span>
											</a>
											<?
										}
										else {
											echo $area->getResponsabile();
										}
									}
									else {
										echo " ";
									}
									?>
								</li>
								<li><strong>Data di pubblicazione: </strong><?=(is_object($amm_aperta->getDtPubblicazione())?$amm_aperta->getDtPubblicazione()->format("d.m.y"):"ND")?></li>
								<li><strong>Ragione Sociale: </strong><?=$amm_aperta->getRagionesociale()?></li>
								<li><strong>Partita IVA/Cod. Fiscale: </strong><?=$amm_aperta->getPiva()?></li>
								<li><strong>Responsabile del Procedimento: </strong>
									<?php
									$rubrica = new Rubrica();
									//I nuovi inserimenti avranno valorizzato resp_proc_idrubrica
									if (($amm_aperta->getRespProcIdrubrica() != "") OR ($amm_aperta->getRespProcIdrubrica() != 0)) {
										$rubrica->setIdUtente($amm_aperta->getRespProcIdrubrica());
										$rubrica->getNomeCognomefromID($amm_aperta->getRespProcIdrubrica());
									}
									else {
										$rubrica->getUtenteConripulituraDati($amm_aperta->getRespProc());
									}

									if ($rubrica->getCognome() != "") {
									?>
										<a href="http://rubrica.provincia.prato.it/index.php?servizio=%25&cognome=<?=$rubrica->getCognome()?>#risultati">
											<?=$amm_aperta->getRespProc()?>
											<span class="fa fa-phone"></span>
										</a>
									<?php
									}
									else {
									?>
										<?=$amm_aperta->getRespProc()?>
									<?
									}
									?>
								</li>
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

<?
//NOTE: questo serve per non caricare nulla se la pagina è richiesta in modo super accessibile
if ($_SERVER['SCRIPT_NAME'] != "/accessibile.php") {
?>

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
						<a title="apri il dettaglio" href="<?=$percorso_relativo?>visualizza-dettagli.php?id_albo=<?=$albo->getIdAlbo()?>">
							<span class="fa fa-download"></span> Atto nr. <?=$albo->getNrAtto()?> del <?=$albo->getDtAtto()->format("d.m.y")?></a>
						<?php
						}
						else {
						?>
						<?=$amm_aperta->getNorma()?>
						<?php
						}
						?>
					</td>
					<td><?=(is_object($amm_aperta->getDtPubblicazione())?$amm_aperta->getDtPubblicazione()->format("d.m.y"):"ND")?></td>
					<td><?=$amm_aperta->getRagionesociale()?></td>
					<td><?=$amm_aperta->getPiva()?></td>

					<?php
					$rubrica = new Rubrica();
					//I nuovi inserimenti avranno valorizzato resp_proc_idrubrica
					if (($amm_aperta->getRespProcIdrubrica() != "") OR ($amm_aperta->getRespProcIdrubrica() != 0)) {
						$rubrica->setIdUtente($amm_aperta->getRespProcIdrubrica());
						$rubrica->getNomeCognomefromID($amm_aperta->getRespProcIdrubrica());
					}
					else {
						$rubrica->getUtenteConripulituraDati($amm_aperta->getRespProc());
					}

					?>

					<td>
						<?php
						if ($rubrica->getCognome() != "") {
						?>
							<a href="http://rubrica.provincia.prato.it/index.php?servizio=%25&cognome=<?=$rubrica->getCognome()?>#risultati">
								<?=$amm_aperta->getRespProc()?>
								<span class="fa fa-phone"></span>
							</a>
						<?php
						}
						else {
							?>
							<?=$amm_aperta->getRespProc()?>
						<?
						}
						?>
					</td>



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

<?
//NOTE: FINE - questo serve per non caricare nulla se la pagina è richiesta in modo super accessibile
}
?>


</div>

<?
include($percorso_relativo."grafica/body_foot_bootstrap_agid.php");
?>
