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


$titolo_pagina = "Modifica - Amministrazione Aperta";

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



if ($_GET['dt_atto_dal'] == '%') {
	$_GET['dt_atto_dal'] = '';
}
if ($_GET['dt_atto_al'] == '%') {
	$_GET['dt_atto_al'] = '9999-12-12';
}



//amm_aperta.id_albo IS NULL


//------------------------------- ESEGUO RICERCA A VIDEO -------------------------

//NOTE:: OTTIMO ESEMPIO DI RICERCA CON COSTRUZIONE DI QUERY - PROPEL
	$amm_aperte = AmmApertaQuery::create()
			->where('amm_aperta.ragionesociale LIKE ?','%'.$_GET['testo'].'%')
			->_or()
			->where('amm_aperta.piva LIKE ?','%'.$_GET['testo'].'%')
			->_or()
			->where('amm_aperta.norma LIKE ?','%'.$_GET['testo'].'%')
			->_or()
			->where('amm_aperta.modalita LIKE ?','%'.$_GET['testo'].'%')
			->orderByIdAmmAperta('desc')
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
									<span class="fa fa-download"></span> Atto nr. <?=$albo->getNrAtto()?> del <?=$albo->getDtAtto()->format("d.m.y")?></a>
								<?php
							}
							else {
								?>
								<a href="/admin/amm_aperta_modifica.php?id_albo=<?=$amm_aperta->getIdAlbo()?>">
									<?=$amm_aperta->getNorma()?>
									<span class="fa fa-download"></span></a>

								<?php
							}
							?>
								</td>
								<td><?=(is_object($amm_aperta->getDtPubblicazione())?$amm_aperta->getDtPubblicazione()->format("d.m.y"):"ND")?></td>
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

			<p>
				<a class="btn btn-danger btn-xs" href="/admin/amm_aperta_pre_2010.php">
					ATTENZIONE!! Se l'atto che cerchi non &egrave; in elenco ed &egrave; un atto precedente al 01/01/2010 clicca qui per proseguire la registrazione.
				</a>
			</p>


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
							echo '<li><a href = "'.$_SERVER['PHP_SELF'].'?page='.($amm_aperte->getPage() - 1).'&'.http_build_query($_GET).'">&laquo;</a></li>';
						}
						?>


						<?php
						if ($amm_aperte->getPage() == $amm_aperte->getLastPage()) {
							echo '<li class="disabled"><a href = "#">&raquo;</a></li>';
						}
						else {
							echo '<li><a href = "'.$_SERVER['PHP_SELF'].'?page='.($amm_aperte->getPage() + 1).'&'.http_build_query($_GET).'">&raquo;</a></li>';
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
