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


//albi per pagina
$limit_per_page = 50;
$page = (isset($_GET['page']))?$_GET['page']:1;
//per far funzionare il pagination
$ARRAY_GET_DIFF = array("page" => $page);
$_GET = array_diff($_GET, $ARRAY_GET_DIFF);

/******** Serve per l'escape di potenziali caratteri non corretti *******************/
foreach ($_GET as $key => $value) {
//	$_GET[$key] = $db->escapeSimple($_GET[$key]);
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
			->filterByIdTipo($id_tipo_atto,Propel\Runtime\ActiveQuery\Criteria::LIKE)
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

		<div class="row">

			<div class="col-xs-12 col-sm-12">

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
					foreach ($albi as $albo) {
						$tipo = TipiQuery::create()
								->findPk($albo->getIdTipo());

						echo '<tr>';

						//NOTE: Permetto la modifica solo agli atti inseriti manualmente!!!
						if ($albo->getManuale() == 's') {
							echo '<td><a href="'.$percorso_relativo.'admin/modifica_albo.php?id_albo='.$albo->getIdAlbo().'">'.$albo->getNrAtto().'<span class="fa fa-download"></span></a></td>';
						}
						else {
							echo '<td>
								<a data-toggle="modal"
								data-whatever="'.$albo->getIdAlbo().'"
								data-target="#myModal"
								title="Non Modificabile - Inserito dal Protocollo">'.$albo->getNrAtto().'<span class="fa fa-remove"></span></a></td>';


						}

						// Visualizzo il risultato in tabella

						echo "<td>".$tipo->getTipo()."</td>";
						echo "<td>".($albo->getDtAtto() == "" ? "N.D." : $albo->getDtAtto()->format("d.m.Y"))."</td>";
						echo "<td><p>".$albo->getOggetto()."</p></td>";
						echo "<td>".$albo->getNote()."</td>";

						echo "</tr>\n";


					}

					?>


					</tbody>
				</table>
			</div>



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
	</div>
<?
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
include($percorso_relativo."grafica/body_foot_bootstrap_agid.php");
?>

<?
}
// --------- FINE ricerca su excel -------------------
?>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Avviso informativo...</h4>
			</div>
			<div class="modal-body">
				Attenzione! Atto non modificabile perchè inserito automaticamente dal Protocollo informatico dell'ente.
				Questo atto può essere solo ANNULLATO. </br>

			</div>
			<div class="modal-footer">

			</div>
		</div>
	</div>
</div>

<script type="application/javascript">

	$('#myModal').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget); // Button that triggered the modal
		var recipient = button.data('whatever'); // Extract info from data-* attributes
		// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
		// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
		var modal = $(this);
		//modal.find('.modal-title').text('New message to ' + recipient)
		modal.find('.modal-body input').val(recipient);
		modal.find('.modal-footer').html('<a href="/admin/annulla_atto.php?id_albo='+recipient+'" type="button" class="btn btn-warning">Annulla Atto</a>' +
				'<button type="button" class="btn btn-default" data-dismiss="modal">Chiudi senza annullare</button>');
		//modal.find('.modal-footer').append.html('<br><br>');
	})

</script>

</body>
</html>
