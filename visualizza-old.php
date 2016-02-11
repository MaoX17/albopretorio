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


/******** Serve per l'escape di potenziali caratteri non corretti *******************/
foreach ($_POST as $key => $value) {
	$_POST[$key] = $db->escapeSimple($_POST[$key]);
}

$oggi = date("Y-m-d");

//albi per pagina
$limit_per_page = 50;
$page = (isset($_GET['page']))?$_GET['page']:1;
//uso paginate x impaginazione

$albi = AlbiQuery::create()
		->filterByDtPubblicazAl(array("max" => $oggi))
		->filterByDaValidare('S',\Propel\Runtime\ActiveQuery\Criteria::NOT_EQUAL)
		->orderByIdAlbo('desc')
		->paginate($page, $limit_per_page);


?>

<div class="container">
	<div class="row">
		<div class="hidden">
			<h2><?=$titolo_pagina?></h2>
		</div>
		<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
			<h3>Atti gi&agrave; pubblicati</h3>
		</div>
	</div>


	<!-- dispositivi mobili -->
	<div class="row">
		<div class="col-xs-12 col-sm-12 hidden-lg hidden-md">

			<?php

			foreach ($albi as $albo) {

				$area = AreeQuery::create()
						->findPk($albo->getIdArea());

				$tipo = TipiQuery::create()
						->findPk($albo->getIdTipo());

				$files_number = FilesQuery::create()
						->filterByIdAlbo($albo->getIdAlbo())
						->count();

//if ($files_number > 0) {
				$files = FilesQuery::create()
						->filterByIdAlbo($albo->getIdAlbo())
						->find();

				?>


				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">
							<strong>Oggetto:</strong>
							<? if (isset($albo) && is_object($albo)) {
								?>
								<?= $albo->getOggetto() ?>
								<a title="apri il dettaglio"  href="<?= $percorso_relativo . 'visualizza-dettagli.php?id_albo=' . $albo->getIdAlbo() ?>">
									<span class="fa fa-download"></span>
								</a>
								<?php
							}
							?>
						</h3>
					</div>
					<div class="panel-body">
						<p>
							<small><?=(isset($albo) && is_object($albo)  ? "Note: " . $albo->getNote() : " ") ?></small>
						</p>
						<ul>
							<li>
								<strong>Nr. Reg: </strong>
								<a title="apri il dettaglio" href="<?=$percorso_relativo.'visualizza-dettagli.php?id_albo='.$albo->getIdAlbo()?>">
									<?=$albo->getIdAlbo()?>
									<span class="fa fa-download"></span>
								</a>
							</li>
							<li>
								<strong>Nr. Atto: </strong>
								<?=$albo->getNrAtto()?>
							</li>
							<li>
								<strong>Tipo Atto: </strong>
								<?=$tipo->getTipo()?>
							</li>
							<li>
								<strong>Data Atto: </strong>
								<?=(is_object($albo->getDtAtto())?$albo->getDtAtto()->format("d.m.Y"):"N.D.")?>
							</li>
							<li>
								<strong>Data di Pubblicazione - Dal: </strong>
								<?=$albo->getDtPubblicazDal()->format("d.m.Y")?>
								<strong>Al: </strong>
								<?=$albo->getDtPubblicazAl()->format("d.m.Y")?>
							</li>
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
	<!-- dispositivi PC -->
	<div class="row">
		<div class="col-lg-12 col-md-12 hidden-xs hidden-sm">

			<table class="table table-bordered table-striped table-responsive">
				<thead>
				<tr>
					<th rowspan="2">Num. Reg.</th>
					<th rowspan="2">Num. Atto</th>
					<th rowspan="2">Tipo</th>
					<th rowspan="2">Data</th>
					<th rowspan="2">Oggetto</th>
					<th colspan="2" class="text-center">In Pubblicazione</th>
				</tr>
				<tr>
					<th>Dal</th>
					<th>Al</th>
				</tr>
				</thead>
				<tbody>

				<?php

				$albi = AlbiQuery::create()
						->filterByDtPubblicazAl(array("max" => $oggi))
						->filterByDaValidare('S',\Propel\Runtime\ActiveQuery\Criteria::NOT_EQUAL)
						->orderByIdAlbo('desc')
						->paginate($page, $limit_per_page);

				foreach ($albi as $albo) {

					$area = AreeQuery::create()
							->findPk($albo->getIdArea());

					$tipo = TipiQuery::create()
							->findPk($albo->getIdTipo());

					$files_number = FilesQuery::create()
							->filterByIdAlbo($albo->getIdAlbo())
							->count();

					//if ($files_number > 0) {
					$files = FilesQuery::create()
							->filterByIdAlbo($albo->getIdAlbo())
							->find();

					echo '<tr>';
					echo '<td><a title="apri il dettaglio" href="'.$percorso_relativo.'visualizza-dettagli.php?id_albo='.$albo->getIdAlbo().'">'.$albo->getIdAlbo().'<span class="fa fa-download"></span></a></td>';
					echo '<td>'.$albo->getNrAtto().'</td>';
					echo "<td>".((is_object($tipo))?$tipo->getTipo():" ")."</td>";
					echo "<td>".($albo->getDtAtto() == "" ? "N.D." : $albo->getDtAtto()->format("d.m.y"))."</td>";
					echo "<td><p>".$albo->getOggetto()."</p></td>";
					echo "<td>".$albo->getDtPubblicazDal()->format('d.m.y')."</td>";
					echo "<td>".$albo->getDtPubblicazAl()->format('d.m.y')."</td>";
					echo "</tr>\n";


				}

				?>


				</tbody>

			</table>

		</div>

	</div>


	<div class="row">
		<?php // PropelModelPager offers a convenient API to display pagination controls ?>
		<?php if($albi->haveToPaginate()): ?>
			<div class="pagination">
				<ul class='pagination'>
					<li>
						<a href="#"><?php echo $albi->getPage() ?> di <?php echo $albi->getLastPage() ?></a>
					</li>
					<?php
					if ($albi->getPage() == 1) {
						echo '<li class="disabled"><a href = "#">&laquo;</a></li>';
					}
					else {
						echo '<li><a href = "'.$_SERVER['PHP_SELF'].'?page='.($albi->getPage() - 1).'">&laquo;</a></li>';
					}
					?>



					<?php
					if ($albi->getPage() == $albi->getLastPage()) {
						echo '<li class="disabled"><a href = "#">&raquo;</a></li>';
					}
					else {
						echo '<li><a href = "'.$_SERVER['PHP_SELF'].'?page='.($albi->getPage() + 1).'">&raquo;</a></li>';
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
//include($percorso_relativo."grafica/body_foot_bootstrap.php");
include($percorso_relativo."grafica/body_foot_bootstrap_agid.php");
?>
