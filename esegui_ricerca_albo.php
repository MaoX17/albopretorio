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

//albi per pagina
$limit_per_page = 50;
$page = (isset($_GET['page']))?$_GET['page']:1;

//NOTE: per far funzionare il pagination con le ricerche
//NOTE: Occorre sostituire array_diff con array_diff_assoc
$ARRAY_GET_DIFF = array("page" => $page);
$_GET = array_diff_assoc($_GET, $ARRAY_GET_DIFF);

/******** Serve per l'escape di potenziali caratteri non corretti *******************/
foreach ($_GET as $key => $value) {
//        $_GET[$key] = $db->escapeSimple($_GET[$key]);
        if ($_GET[$key] == "") { $_GET[$key] = "%"; }
}

//------------------------------------------------------



if ($_GET['tipo'] != '%') {
	$tipo_atto = TipiQuery::create()
			->findPk($_GET['tipo']);
	$id_tipo_atto = $tipo_atto->getIdTipo();

}
else {
	$id_tipo_atto = '%';
}

/*
if (is_object($tipo_atto) && ($tipo_atto->getTipo() == 'Determinazione Dirigenziale')) {
	if ($_GET['tipo_determina'] != '%') {
		$tipo_determina = TipiDeterminaQuery::create()
				->findPk($_GET['tipo_determina']);
		$id_tipo_det = $tipo_determina->getIdTipoDetermina();
	}
	else {
		$id_tipo_det = '%';
	}
}
else {
	$id_tipo_det = '%';
}
*/

if ($_GET['area'] != '%') {
	$area = AreeQuery::create()
			->findPk($_GET['area']);
	$idarea = $area->getIdArea();
}
else {
	$idarea = '%';
}

if ($_GET['dt_pubbl_dal'] == '%') {
	$_GET['dt_pubbl_dal'] = '';
}

if ($_GET['dt_pubbl_al'] == '%') {
	$_GET['dt_pubbl_al'] = '9999-12-12';
}

if ($_GET['dt_atto_dal'] == '%') {
	$_GET['dt_atto_dal'] = '';
}

if ($_GET['dt_atto_al'] == '%') {
	$_GET['dt_atto_al'] = '9999-12-12';
}


//------------------------------- ESEGUO RICERCA A VIDEO -------------------------
if ($_GET['ok'] == "Esegui Ricerca ->") {

	$albi = AlbiQuery::create()
		//  NOTE: posso scrivere direttamente in forma LIKE perchè è un campo testo
		//	->filterByOggetto('%'.$_GET['oggetto'].'%',Propel\Runtime\ActiveQuery\Criteria::LIKE)
			->filterByOggetto('%'.$_GET['oggetto'].'%')
			->filterByAutoritaEmanante('%'.$_GET['autorita'].'%',Propel\Runtime\ActiveQuery\Criteria::LIKE)
			->filterByDtPubblicazDal(array('min' => $_GET['dt_pubbl_dal']))
			->filterByDtPubblicazAl(array('max' => $_GET['dt_pubbl_al']))
			->filterByDtAtto(array('min' => $_GET['dt_atto_dal'],'max' => $_GET['dt_atto_al']))
			->filterByIdArea($idarea,Propel\Runtime\ActiveQuery\Criteria::LIKE)
			->filterByIdTipo('%'.$id_tipo_atto,Propel\Runtime\ActiveQuery\Criteria::LIKE)
			->filterByNrAtto('%'.$_GET['numero'].'%',Propel\Runtime\ActiveQuery\Criteria::LIKE)
			->orderByIdAlbo('desc')
			->paginate($page, $limit_per_page);

?>

<div class="container">
	<div class="row">
		<div class="hidden">
			<h2><?=$titolo_pagina?></h2>
		</div>
		<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
			<h3>Atti trovati</h3>
		</div>
	</div>

	<!-- Per dispositivi con piccolo schermo -->
	<div class="row">
		<div class="col-xs-12 hidden-lg hidden-md">
			<?php

			foreach ($albi as $albo) {
				$tipo = TipiQuery::create()
					->findPk($albo->getIdTipo());


			?>
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">
							<strong>Oggetto:</strong>
							<? if (isset($albo) && is_object($albo)) {
								?>
								<?= $albo->getOggetto() ?>
								<a title="apri il dettaglio" href="<?= $percorso_relativo . 'visualizza-dettagli.php?id_albo=' . $albo->getIdAlbo() ?>">
									<span class="fa fa-download"></span>
								</a>
								<?php
							}
							?>
						</h3>
					</div>
					<div class="panel-body">
						<p>
							<small><?=(isset($albo) && is_object($albo)  ? "Note: <ins>" . $albo->getNote() ."</ins>" : " ") ?></small>
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
								<?=(is_object($albo->getDtPubblicazDal())?$albo->getDtPubblicazDal()->format("d.m.Y"):"N.D.")?>
								<strong>Al: </strong>
								<?=(is_object($albo->getDtPubblicazAl())?$albo->getDtPubblicazAl()->format("d.m.Y"):"N.D.")?>
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
	<!-- Per dispositivi con grande schermo -->
	<div class="row">
		<div class="col-sm-12 hidden-xs hidden-sm">
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
	foreach ($albi as $albo) {
		$tipo = TipiQuery::create()
				->findPk($albo->getIdTipo());

		echo '<tr>';
		echo '<td><a title="apri il dettaglio" href="'.$percorso_relativo.'visualizza-dettagli.php?id_albo='.$albo->getIdAlbo().'">'.$albo->getIdAlbo().'<span class="fa fa-download"></span></a></td>';
		echo '<td>'.$albo->getNrAtto().'</td>';
		echo "<td>".((is_object($tipo))?$tipo->getTipo():" ")."</td>";
		echo "<td>".($albo->getDtAtto() == "" ? "N.D." : $albo->getDtAtto()->format("d.m.y"))."</td>";
		echo "<td><p>".$albo->getOggetto()."</p></td>";
		echo "<td>".(is_object($albo->getDtPubblicazDal())?$albo->getDtPubblicazDal()->format('d.m.y'):"N.D.")."</td>";
		echo "<td>".(is_object($albo->getDtPubblicazAl())?$albo->getDtPubblicazAl()->format('d.m.y'):"N.D.")."</td>";
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
						//NOTE: http_build_query serve per far funzionare il pagination su una pagina di ricerca
						echo '<li><a href = "'.$_SERVER['PHP_SELF'].'?page='.($albi->getPage() - 1).'&'.http_build_query($_GET).'">&laquo;</a></li>';
					}
					?>
					<?php
					if ($albi->getPage() == $albi->getLastPage()) {
						echo '<li class="disabled"><a href = "#">&raquo;</a></li>';
					}
					else {
						echo '<li><a href = "'.$_SERVER['PHP_SELF'].'?page='.($albi->getPage() + 1).'&'.http_build_query($_GET).'">&raquo;</a></li>';
					}
					?>

				</ul>
				<p>
					albi dal nr. <?php echo $albi->getFirstIndex() ?> al nr. <?php echo $albi->getLastIndex() ?>
					--
					albi totali: <?php echo $albi->getNbResults() ?>
				</p>
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



<?
}
// ------------------------- FINE RICERCA A VIDEO ------------------
// --------- Inizio ricerca su excel -------------------
elseif ($_GET['ok'] == "Genera Excel ->") {


	$albi = AlbiQuery::create()
			->filterByOggetto('%'.$_GET['oggetto'].'%',Propel\Runtime\ActiveQuery\Criteria::LIKE)
			->filterByAutoritaEmanante('%'.$_GET['autorita'].'%',Propel\Runtime\ActiveQuery\Criteria::LIKE)
			->filterByDtPubblicazDal(array('min' => $_GET['dt_pubbl_dal']))
			->filterByDtPubblicazAl(array('max' => $_GET['dt_pubbl_al']))
			->filterByDtAtto(array('min' => $_GET['dt_atto_dal'],'max' => $_GET['dt_atto_al']))
			->filterByIdArea($idarea,Propel\Runtime\ActiveQuery\Criteria::LIKE)
			->filterByIdTipo($id_tipo_atto,Propel\Runtime\ActiveQuery\Criteria::LIKE)
			->filterByIdTipoDetermina($id_tipo_det,Propel\Runtime\ActiveQuery\Criteria::LIKE)
			->filterByNrAtto('%'.$_GET['numero'].'%',Propel\Runtime\ActiveQuery\Criteria::LIKE)
			->orderByIdAlbo('desc')
			->find();

	//indice file csv
	$ARRAY_result = array();
	$z = 1;
	$fp = fopen('file.csv', 'w');
	$ARRAY_label = array("id", "num.Reg", "tipo", "num Atto", "data Atto","oggetto", "area","responsabile","note");
	fputcsv($fp, $ARRAY_label);

	foreach ($albi as $albo) {

			$i = 0;

		$tipo = TipiQuery::create()
				->findPk($albo->getIdTipo());

		$area = AreeQuery::create()
				->findPk($albo->getIdArea());

			$ARRAY_result[0] = $z;
			$ARRAY_result[1] = $albo->getIdAlbo();
			$ARRAY_result[2] = $tipo->getTipo();
			$ARRAY_result[3] = $albo->getNrAtto();
			$ARRAY_result[4] = $albo->getDtAtto()->format("d.m.Y");
			$ARRAY_result[5] = $albo->getOggetto();
			$ARRAY_result[6] = $area->getArea();
			$ARRAY_result[7] = $area->getResponsabile();
			$ARRAY_result[8] = $albo->getNote();


		$z++;
		fputcsv($fp, $ARRAY_result);
	}


	fclose($fp);
?>

<div class="container">
	<div class="row">
		<div class="col-xs-12 col-sm-12">
			<h1><?=$titolo_pagina?></h1>
		</div>

		<div class="col-xs-12 col-sm-12">
			<!-- <a href="file.csv" class="btn btn-primary" type="application/octet-stream">scarica</a> -->
			<a href="download_risultato_ricerca.php" class="btn btn-primary">Scarica il risultato della ricerca</a>
		</div>
	</div>
</div>

<?
}
// --------- FINE ricerca su excel -------------------
?>



</body>
</html>
