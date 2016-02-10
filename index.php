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

include($percorso_relativo . "grafica/head_bootstrap_agid.php");
include($percorso_relativo . "grafica/body_head_bootstrap_agid.php");


// ####### OLD ##########
require_once ("class/Db.php");
$factory=DbAbstractionFactory::getFactory($cfg->getValue('AstrazioneDB'));
$factory->setDsn($cfg->getValue('DSN'));
$db=$factory->createInstance();
// ####### OLD ##########

//session_restart();

?>

<div class="container container-fluid">

	<div class="row">

		<!-- Colonna centrale-SX -->
		<div class="col-xs-12 col-sm-12">
			<h2>Albo Pretorio della Provincia di Prato</h2>
			<p>Nell'attuare la normativa in materia di pubblicita' legale online
				(art. 32, L 69/2009 e s.m.i.),
				si avvisa che verranno pubblicati a questo Albo Pretorio i
				file di atti e provvedimenti prodotti a partire dal
				1 gennaio 2011; pertanto dei documenti prodotti fino al 31/12/2010
				saranno pubblicati online i soli estremi di pubblicazione
				all'Albo senza il relativo file, mentre verranno affissi presso
				i locali della Provincia i testi su supporto cartaceo.</p>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6 col-xs-12">
			<div class="hidden-xs hidden-sm">
				<a accesskey="2" tabindex="2" href="visualizza.php" class="btn btn-success" role="button">Atti in pubblicazione</a>
			</div>
			<div class="visible-sm visible-xs">
				<a accesskey="2" tabindex="2" href="visualizza.php" class="btn btn-success" role="button">Atti in pubblicazione</a>
			</div>
		</div>
		<div class="col-md-6 col-xs-12">
			<div class="hidden-xs hidden-sm">
				<a accesskey="3" tabindex="3" href="visualizza-old.php" class="btn btn-danger">Atti pubblicati</a>
			</div>
			<div class="visible-sm visible-xs">
				<a accesskey="3" tabindex="3" href="visualizza-old.php" class="btn btn-danger">Atti pubblicati</a>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6 col-xs-12">
			<div class="hidden-xs hidden-sm">
				<a accesskey="4" tabindex="4" href="ricerca_albo.php" class="btn btn-primary">Ricerca gli atti</a>
			</div>
			<div class="visible-sm visible-xs">
				<a accesskey="4" tabindex="4" href="ricerca_albo.php" class="btn btn-primary">Ricerca gli atti</a>
			</div>
		</div>
		<div class="col-md-6 col-xs-12">
			<div class="hidden-xs hidden-sm">
				<a accesskey="5" tabindex="5" href="amm_aperta_visualizza.php" class="btn btn-default">Amministrazione Aperta</a>
			</div>
			<div class="visible-sm visible-xs">
				<a accesskey="5" tabindex="5" href="amm_aperta_visualizza.php" class="btn btn-default">Amministrazione Aperta</a>
			</div>
		</div>
	</div>


	<!-- Note: inizio barra social share -->
	<div class="row">
		<a class="btn btn-social-icon btn-google" href="https://plus.google.com/share?url=http://<?=$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']?>" title="Share on Google+" target="_blank">
			<span class="fa fa-google"></span>
		</a>

		<a class="btn btn-social-icon btn-facebook" href="https://www.facebook.com/sharer/sharer.php?u=http://<?=$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']?>" title="Share on Facebook" target="_blank">
			<span class="fa fa-facebook"></span>
		</a>

		<a class="btn btn-social-icon btn-twitter" href="http://twitter.com/home?status=http://<?=$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']?>" title="Share on Twitter" target="_blank" >
			<span class="fa fa-twitter"></span>
		</a>

		<a class="btn btn-social-icon btn-linkedin" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=http://<?=$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']?>" title="Share on LinkedIn" target="_blank" >
			<span class="fa fa-linkedin"></span>
		</a>

	</div>
	<!-- Note: fine barra social share -->

	<!-- Per fare uno spazio -->
	<div class="row">&nbsp;</div>


	<div class="row">
		<div class="col-xs-12 col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Sezione Trasparenza - Delibere di Consiglio</h3>
				</div>
				<div class="panel-body">
					<ul>
						<li><a accesskey="6" tabindex="6" href="visualizza_trasparenza.php?tipo_trasp=3&amp;tipo=1">Delibere di Consiglio - Autorizzazione o concessione</a>
							<?php
							$nr = AlbiQuery::create()
									->filterByIdTipo(1)
									->filterByIdTipoTrasp(3)
									->filterByDaValidare('S',\Propel\Runtime\ActiveQuery\Criteria::NOT_EQUAL)
									->count();
							?>
							<span class="badge"><?=$nr?></span>
						</li>
						<li><a accesskey="7" tabindex="7"  href="visualizza_trasparenza.php?tipo_trasp=4&amp;tipo=1">Delibere di Consiglio - scelta del contraente per l'affidamento di lavori, forniture e servizi</a>
							<?php
							$nr = AlbiQuery::create()
									->filterByIdTipo(1)
									->filterByIdTipoTrasp(4)
									->filterByDaValidare('S',\Propel\Runtime\ActiveQuery\Criteria::NOT_EQUAL)
									->count();
							?>
							<span class="badge"><?=$nr?></span>
						</li>
						<li><a  accesskey="8" tabindex="8" href="visualizza_trasparenza.php?tipo_trasp=5&amp;tipo=1">Delibere di Consiglio - concorsi e prove selettive per l'assunzione del personale e progressioni di carriera</a>
							<?php
							$nr = AlbiQuery::create()
									->filterByIdTipo(1)
									->filterByIdTipoTrasp(5)
									->filterByDaValidare('S',\Propel\Runtime\ActiveQuery\Criteria::NOT_EQUAL)
									->count();
							?>
							<span class="badge"><?=$nr?></span>
						</li>
						<li><a accesskey="9" tabindex="9"  href="visualizza_trasparenza.php?tipo_trasp=6&amp;tipo=1">Delibere di Consiglio - accordi stipulati dall'amministrazione con soggetti privati o con altre amministrazioni pubbliche</a>
							<?php
							$nr = AlbiQuery::create()
									->filterByIdTipo(1)
									->filterByIdTipoTrasp(6)
									->filterByDaValidare('S',\Propel\Runtime\ActiveQuery\Criteria::NOT_EQUAL)
									->count();
							?>
							<span class="badge"><?=$nr?></span>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12 col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Sezione Trasparenza - Delibere di Giunta</h3>
				</div>
				<div class="panel-body">
					<ul>
						<li><a tabindex="10" href="visualizza_trasparenza.php?tipo_trasp=3&amp;tipo=2">Delibere di Giunta - Autorizzazione o concessione</a>
							<?php
							$nr = AlbiQuery::create()
									->filterByIdTipo(2)
									->filterByIdTipoTrasp(3)
									->filterByDaValidare('S',\Propel\Runtime\ActiveQuery\Criteria::NOT_EQUAL)
									->count();
							?>
							<span class="badge"><?=$nr?></span>
						</li>
						<li><a  tabindex="11" href="visualizza_trasparenza.php?tipo_trasp=4&amp;tipo=2">Delibere di Giunta - scelta del contraente per l'affidamento di lavori, forniture e servizi</a>
							<?php
							$nr = AlbiQuery::create()
									->filterByIdTipo(2)
									->filterByIdTipoTrasp(4)
									->filterByDaValidare('S',\Propel\Runtime\ActiveQuery\Criteria::NOT_EQUAL)
									->count();
							?>
							<span class="badge"><?=$nr?></span>
						</li>
						<li><a  tabindex="12" href="visualizza_trasparenza.php?tipo_trasp=5&amp;tipo=2">Delibere di Giunta - concorsi e prove selettive per l'assunzione del personale e progressioni di carriera</a>
							<?php
							$nr = AlbiQuery::create()
									->filterByIdTipo(2)
									->filterByIdTipoTrasp(5)
									->filterByDaValidare('S',\Propel\Runtime\ActiveQuery\Criteria::NOT_EQUAL)
									->count();
							?>
							<span class="badge"><?=$nr?></span>
						</li>
						<li><a tabindex="13"  href="visualizza_trasparenza.php?tipo_trasp=6&amp;tipo=2">Delibere di Giunta - accordi stipulati dall'amministrazione con soggetti privati o con altre amministrazioni pubbliche</a>
							<?php
							$nr = AlbiQuery::create()
									->filterByIdTipo(2)
									->filterByIdTipoTrasp(6)
									->filterByDaValidare('S',\Propel\Runtime\ActiveQuery\Criteria::NOT_EQUAL)
									->count();
							?>
							<span class="badge"><?=$nr?></span>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12 col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Sezione Trasparenza - Determinazioni Dirigenziali</h3>
				</div>
				<div class="panel-body">
					<ul>
						<li><a tabindex="14"  href="visualizza_trasparenza.php?tipo_trasp=3&amp;tipo=3">Determinazioni Dirigenziali - Autorizzazione o concessione</a>
							<?php
							$nr = AlbiQuery::create()
									->filterByIdTipo(3)
									->filterByIdTipoTrasp(3)
									->filterByDaValidare('S',\Propel\Runtime\ActiveQuery\Criteria::NOT_EQUAL)
									->count();
							?>
							<span class="badge"><?=$nr?></span>
						</li>
						<li><a tabindex="15"  href="visualizza_trasparenza.php?tipo_trasp=4&amp;tipo=3">Determinazioni Dirigenziali - scelta del contraente per l'affidamento di lavori, forniture e servizi</a>
							<?php
							$nr = AlbiQuery::create()
									->filterByIdTipo(3)
									->filterByIdTipoTrasp(4)
									->filterByDaValidare('S',\Propel\Runtime\ActiveQuery\Criteria::NOT_EQUAL)
									->count();
							?>
							<span class="badge"><?=$nr?></span>
						</li>
						<li><a tabindex="16" href="visualizza_trasparenza.php?tipo_trasp=5&amp;tipo=3">Determinazioni Dirigenziali - concorsi e prove selettive per l'assunzione del personale e progressioni di carriera</a>
						<?php
						$nr = AlbiQuery::create()
								->filterByIdTipo(3)
								->filterByIdTipoTrasp(5)
								->filterByDaValidare('S',\Propel\Runtime\ActiveQuery\Criteria::NOT_EQUAL)
								->count();
						?>
						<span class="badge"><?=$nr?></span>
						</li>

						<li><a tabindex="17"  href="visualizza_trasparenza.php?tipo_trasp=6&amp;tipo=3">Determinazioni Dirigenziali - accordi stipulati dall'amministrazione con soggetti privati o con altre amministrazioni pubbliche</a>
							<?php
							$nr = AlbiQuery::create()
									->filterByIdTipo(3)
									->filterByIdTipoTrasp(6)
									->filterByDaValidare('S',\Propel\Runtime\ActiveQuery\Criteria::NOT_EQUAL)
									->count();
							?>
						<span class="badge"><?=$nr?></span>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>

</div><!--/.container-->


<?
//include($percorso_relativo."grafica/body_foot_bootstrap.php");
include($percorso_relativo."grafica/body_foot_bootstrap_agid.php");
?>
