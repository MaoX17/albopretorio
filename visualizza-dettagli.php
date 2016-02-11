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
$prefix_albo_files = $cfg->getValue('prefix_albo_files');
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
require_once $percorso_relativo.'class/File.php';
require_once $percorso_relativo.'class/Rubrica.php';

// ####### OLD ##########

if (($_GET['id_albo']) == "") {
	$id_albo = "201500001";
}
else {
	$id_albo = $_GET['id_albo'];
}

$albo_dettaglio = AlbiQuery::create()
		->findPk($id_albo);

$area = AreeQuery::create()
		->findPk($albo_dettaglio->getIdArea());

$tipo = TipiQuery::create()
		->findPk($albo_dettaglio->getIdTipo());

$files_number = FilesQuery::create()
		->filterByIdAlbo($albo_dettaglio->getIdAlbo())
		->count();

$files = FilesQuery::create()
		->filterByIdAlbo($albo_dettaglio->getIdAlbo())
		->find();

$tipo_trasp = TipiTraspQuery::create()
		->findPk($albo_dettaglio->getIdTipoTrasp());

$rubrica = new Rubrica();
$rubrica->getUtenteConripulituraDati($area->getResponsabile());

setlocale(LC_MONETARY, 'it_IT');

?>

	<div class="container">

		<div class="row">

			<div class="col-xs-12 col-sm-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h2 class="panel-title">Atto Nr. <strong><?=(($albo_dettaglio->getNrAtto()!=0)?$albo_dettaglio->getNrAtto():"N.D.")?></strong>
						del <strong><?=(is_object($albo_dettaglio->getDtAtto())?$albo_dettaglio->getDtAtto()->format("d.m.Y"):"N.D.")?></strong>
						</h2>
					</div>
					<div class="panel-body">
						<p><strong>Oggetto: </strong> <?=$albo_dettaglio->getOggetto()?></p>
						<p>
							<small><?=(isset($albo_dettaglio) && is_object($albo_dettaglio)  ? "<strong>Note:</strong> " . $albo_dettaglio->getNote() : " ") ?></small>
						</p>

						<ul>
							<li>
								<strong>Num. Reg: </strong>
								<?=$albo_dettaglio->getIdAlbo()?>
							</li>
							<li>
								<strong>Tipo Atto: </strong>
								<?=$tipo->getTipo()?>
							</li>
							<li>
								<strong>Autorit&agrave emanante: </strong>
								<?=$albo_dettaglio->getAutoritaEmanante()?>
							</li>
							<li>
								<strong>Area di riferimento: </strong>
								<?=$area->getArea()?>
							</li>
							<li>
								<strong>Responsabile di Area: </strong>
								<?php
								if ($rubrica->getCognome() != "") {
									?>
									<a href="http://rubrica.provincia.prato.it/index.php?servizio=%25&cognome=<?=$rubrica->getCognome()?>#risultati">
										<?=$area->getResponsabile()?>
										<span class="fa fa-phone"></span>
									</a>
									<?php
								}
								else {
									?>
									<?=$area->getResponsabile()?>
									<?
								}
								?>
							</li>
							<li>
								<strong>Pubblicazione dal: </strong>
								<?=$albo_dettaglio->getDtPubblicazDal()->format("d.m.y")?>
							</li>
							<li>
								<strong>Pubblicazione al: </strong>
								<?=$albo_dettaglio->getDtPubblicazAl()->format("d.m.y")?>
							</li>
							<li>
								<strong>Tipologia: </strong>
								<?=(is_object($tipo_trasp)?$tipo_trasp->getTipoTrasp():"")?>
							</li>
							<li>
								<strong>Spesa Prevista: </strong>
								<?=money_format('%.2n', $albo_dettaglio->getSpesaPrevista())?>
							</li>
							<li>
								<strong>Files e Allegati: </strong>
								<ul>
									<?php
									//$finfo = finfo_open(FILEINFO_MIME, "/usr/share/misc/magic"); // return mime type ala mimetype extension

									$i = 0;
									foreach ($files as $file_albo) {
										$i++;
										if (($file_albo->getFromBlob() == "s") OR ($file_albo->getFromBlob() == "")) {
											$link = $prefix_albo_files."/files/".$file_albo->getFile();
										}
										else {
											$link = $prefix_albo_files."/files_albo_nfs/".$file_albo->getFile();
										}

										$path_parts = pathinfo($link);
										$extension = $path_parts['extension'];

										?>

										<li>
											<a href="<?=$link?>"><span class="fa fa-paperclip"></span> File nr. <?=$i?></a> - Tipo <strong><?=$extension?></strong>
										</li>
										<?php
									}
									//finfo_close($finfo);
									?>
								</ul>
							</li>
						</ul>


						<!-- Note: inizio barra social share -->
						<div class="row">
							<a class="btn btn-social-icon btn-google" href="https://plus.google.com/share?url=http://<?=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']?>" title="Share on Google+" target="_blank">
								<span class="fa fa-google"></span>
							</a>

							<a class="btn btn-social-icon btn-facebook" href="https://www.facebook.com/sharer/sharer.php?u=http://<?=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']?>" title="Share on Facebook" target="_blank">
								<span class="fa fa-facebook"></span>
							</a>

							<a class="btn btn-social-icon btn-twitter" href="http://twitter.com/home?status=http://<?=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']?>" title="Share on Twitter" target="_blank" >
								<span class="fa fa-twitter"></span>
							</a>

							<a class="btn btn-social-icon btn-linkedin" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=http://<?=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']?>" title="Share on LinkedIn" target="_blank" >
								<span class="fa fa-linkedin"></span>
							</a>

						</div>
						<!-- Note: fine barra social share -->


					</div>

					<div class="panel-footer">
						<p>
							I file vengono pubblicati in vari formati.
							Per la consultazione dei documenti in formato P7M (firmati digitalmente) &egrave; necessario
							disporre di un apposito software;
							raggiungendo il seguente link
							(<a href="http://www.digitpa.gov.it/firme-elettroniche/software-di-verifica-della-firma-digitale">http://www.digitpa.gov.it/firme-elettroniche/software-di-verifica-della-firma-digitale</a>)
							si possono scaricare liberamente i software utili.';
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
<?
//include($percorso_relativo."grafica/body_foot_bootstrap.php");
include($percorso_relativo."grafica/body_foot_bootstrap_agid.php");
?>
