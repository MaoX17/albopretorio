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


$tipo = TipiQuery::create()
		->findPk($_GET['tipo']);

$tipo_trasp = TipiTraspQuery::create()
		->findPk($_GET['tipo_trasp']);


$oggi = date("Y-m-d");

//albi per pagina
$limit_per_page = 50;
$page = (isset($_GET['page']))?$_GET['page']:1;
//uso paginate x impaginazione

?>

<div class="container">
	<div class="row">
		<div class="hidden">
			<h2><?=$titolo_pagina?></h2>
		</div>
		<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
			<h3><?=$tipo->getTipo()?> - <?=$tipo_trasp->getTipoTrasp()?></h3>
		</div>
	</div>

	<!-- dispositivi mobili -->
	<div class="row">
		<div class="col-xs-12 col-sm-12 hidden-lg hidden-md">

			<?php

			$albi = AlbiQuery::create()
					->filterByIdTipo($tipo->getIdTipo())
					->filterByIdTipoTrasp($tipo_trasp->getIdTipoTrasp())
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
								<strong>Nr. Atto: </strong>
								<a title="apri il dettaglio"  href="<?=$percorso_relativo.'visualizza-dettagli.php?id_albo='.$albo->getIdAlbo()?>">
									<?=$albo->getNrAtto()?>
									<span class="fa fa-download"></span>
								</a>
							</li>
							<li>
								<strong>Tipo Atto: </strong>
								<?=$tipo->getTipo()?>
							</li>
							<li>
								<strong>Data Atto: </strong>
								<?=$albo->getDtAtto()->format("d.m.Y")?>
							</li>

						</ul>

					</div>
				</div>

				<?php
			}
			?>

		</div>
	</div>


<div class="row">
	<div class="col-lg-12 col-md-12 hidden-xs hidden-sm">

			<table class="table table-bordered table-striped table-responsive">
				<thead>
				<tr>
					<th>Num. Atto</th>
					<th>Tipo</th>
					<th>Data</th>
					<th>Oggetto</th>
					<th>Note</th>
				</tr>
				</thead>
				<tbody>

				<?php


				$albi = AlbiQuery::create()
						->filterByIdTipo($tipo->getIdTipo())
						->filterByIdTipoTrasp($tipo_trasp->getIdTipoTrasp())
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

					$files = FilesQuery::create()
							->filterByIdAlbo($albo->getIdAlbo())
							->find();

					echo '<tr>';
					echo '<td><a title="apri il dettaglio" href="'.$percorso_relativo.'visualizza-dettagli.php?id_albo='.$albo->getIdAlbo().'">'.$albo->getNrAtto().'<span class="fa fa-download"></span></a></td>';

					echo "<td>".(is_object($tipo)?$tipo->getTipo():"")."</td>";
					echo "<td>".($albo->getDtAtto() == "" ? "N.D." : $albo->getDtAtto()->format("d.m.y"))."</td>";
					echo "<td><p>".$albo->getOggetto()."</p></td>";
					echo "<td>".$albo->getNote()."</td>";

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
						echo '<li><a href = "'.$_SERVER['PHP_SELF'].'?page='.($albi->getPage() - 1).'&tipo_trasp='.$tipo_trasp->getIdTipoTrasp().'&tipo='.$tipo->getIdTipo().'">&laquo;</a></li>';
					}
					?>

					<?php
					if ($albi->getPage() == $albi->getLastPage()) {
						echo '<li class="disabled"><a href = "#">&raquo;</a></li>';
					}
					else {

						echo '<li><a href = "'.$_SERVER['PHP_SELF'].'?page='.($albi->getPage() + 1).'&tipo_trasp='.$tipo_trasp->getIdTipoTrasp().'&tipo='.$tipo->getIdTipo().'">&raquo;</a></li>';
					}
					?>

				</ul>
				<p>
					albi dal nr. <?php echo $albi->getFirstIndex() ?> al nr. <?php echo $albi->getLastIndex() ?>
					<br/>
					albi totali: <?php echo $albi->getNbResults() ?>
				</p>
			</div>


		<?php endif; ?>







	</div>
</div>
<?
//include($percorso_relativo."grafica/body_foot_bootstrap.php");
include($percorso_relativo."grafica/body_foot_bootstrap_agid.php");
?>
