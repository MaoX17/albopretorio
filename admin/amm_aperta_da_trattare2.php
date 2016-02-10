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


//NOTE: per far funzionare il pagination occorre la GET perchè altrimenti perde il riferimento ai parametri di ricerca quando cambio pagina
$ARRAY_GET_DIFF = array("page" => $page);
$_GET = array_diff_assoc($_GET, $ARRAY_GET_DIFF);



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

if (isset($tipo_atto) && is_object($tipo_atto) && ($tipo_atto->getTipo() == 'Determinazione Dirigenziale')) {
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



//amm_aperta.id_albo IS NULL


//------------------------------- ESEGUO RICERCA A VIDEO -------------------------

	$amm_aperte = AmmApertaQuery::create()
			->find();
	$ARRAY_id_albi_amm_aperte = array();
	foreach ($amm_aperte as $amm_aperta) {
		array_push($ARRAY_id_albi_amm_aperte,$amm_aperta->getIdAlbo());
	}

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
			->filterByDaValidare('N')
			->filterByIdAlbo($ARRAY_id_albi_amm_aperte,Propel\Runtime\ActiveQuery\Criteria::NOT_IN)
			->orderByIdAlbo('desc')
			->paginate($page, $limit_per_page);

	?>

	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-12">
				<h1><?=$titolo_pagina?></h1>
			</div>

			<div class="col-xs-12 col-sm-12">

				<table class="table table-bordered table-striped table-responsive">
					<thead>
					<tr>
						<th>Num. Atto</th>
						<th>Tipo</th>
						<!-- <th>Num. Atto</th> -->
						<th>Data</th>
						<th>Oggetto</th>

					</tr>
					</thead>
					<tbody>

					<?php
					foreach ($albi as $albo) {
						$tipo = TipiQuery::create()
								->findPk($albo->getIdTipo());

						echo '<tr>';

						echo '<td><a title="Procedi con l\'inserimento" href="/admin/amm_aperta_modifica.php?id_albo='.$albo->getIdAlbo().'"><span class="fa fa-arrow-right"></span>'.$albo->getIdAlbo()."</a></td>";
						// Visualizzo il risultato in tabella

						echo "<td>".$tipo->getTipo()."</td>";
						echo "<td>".($albo->getDtAtto() == "" ? "N.D." : $albo->getDtAtto()->format("d.m.Y"))."</td>";
						echo "<td><p>".$albo->getOggetto()."</p></td>";


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



<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Avviso informativo...</h4>
			</div>
			<div class="modal-body">
				Attenzione! Atto non modificabile perchè inserito automaticamente dal Protocollo informatico dell'ente.
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>



</body>
</html>
