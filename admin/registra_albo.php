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
require_once ($percorso_relativo.'class/ConfigSingleton.php');
$cfg = SingletonConfiguration::getInstance ();
//$user_db = $cfg->getValue('UserDB');
$titolo_pagina = $cfg->getValue('titolo_applicazione');
//include($percorso_relativo."grafica/head_bootstrap.php");
//include($percorso_relativo."grafica/body_head_bootstrap.php");
include($percorso_relativo."grafica/head_bootstrap_agid.php");
include($percorso_relativo."grafica/body_head_bootstrap_agid.php");

// ####### OLD ##########
require_once ($percorso_relativo."class/Db.php");
$factory=DbAbstractionFactory::getFactory($cfg->getValue('AstrazioneDB'));
$factory->setDsn($cfg->getValue('DSN'));
$db=$factory->createInstance();
require_once $percorso_relativo.'class/Albo.php';
require_once $percorso_relativo.'class/Area.php';
require_once $percorso_relativo.'class/Tipo.php';
require_once $percorso_relativo.'class/Tipo_determina.php';
require_once $percorso_relativo.'class/Tipo_trasp.php';

// ####### OLD ##########

?>

<div class="container">

	<div class="row">
		<div class="col-xs-12 col-sm-10">
			<h1><?=$titolo_pagina?></h1>
		</div>
	</div>






<?php
/******** Serve per l'escape di potenziali caratteri non corretti *******************/
//foreach ($_POST as $key => $value) {
//        $_POST[$key] = $db->escapeSimple($_POST[$key]);
//}


/*********** Tipi e Albo ****/
$tipo_atto = TipiQuery::create()
		->findPk($_POST['tipo']);

//var_dump($tipo_atto);

$tipo_trasp = TipiTraspQuery::create()
		->findPk($_POST['tipo_trasp']);

//var_dump($tipo_trasp);

$area = AreeQuery::create()
		->findPk($_POST['area']);

//var_dump($area);

$albo = AlbiQuery::create()
		->filterByNrAtto($_POST['numero'])
		->filterByDtAtto($_POST['dt_atto'])
		->filterBySpesaPrevista($_POST['spesa_prevista'])
		->filterByAutoritaEmanante($_POST['autorita'])
		->filterByOggetto($_POST['oggetto'])
		->filterByDtPubblicazDal($_POST['dt_pubbl_dal'])
		->filterByDtPubblicazAl($_POST['dt_pubbl_al'])
		->filterByNote($_POST['note'])
		->filterByIdArea($area->getIdArea())
		->filterByIdTipo($tipo_atto->getIdTipo())
		->filterByIdTipoTrasp($tipo_trasp->getTipoTrasp())
		->findOneOrCreate();


//NOTE: controllo nuovo anno - Realizzato in propel/class/albi.php

$albo->setDaValidare('N');
$albo->setManuale('s');

if ((isset($_POST['tipo_determina'])) AND ($_POST['tipo_determina'] != "")) {
	$tipo_determina = TipiDeterminaQuery::create()
			->findPk($_POST['tipo_determina']);
	$albo->setIdTipoDetermina($tipo_determina->getTipoDetermina());
}

$albo->save();
?>

	<div class="row">
		<div class="col-xs-12 col-sm-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Riepilogo dati inseriti</h3>
				</div>
				<div class="panel-body">
					<p><strong>Oggetto:</strong> <?=$albo->getOggetto()?></p>
				</div>

				<!-- Table -->
				<table class="table">
					<thead>
					<tr>
						<th>Numero: </th>
						<th>Data: </th>
						<th>Tipologia: </th>
						<th>Note: </th>
						<th>Files: </th>
					</tr>
					</thead>
					<tbody>
					<tr>
						<td><?=$albo->getNrAtto()?></td>
						<td><?=$albo->getDtAtto()->format("d.m.Y")?></td>
						<td><?=$tipo_atto->getTipo()?></td>
						<td><?=$albo->getNote()?></td>
						<td>
							<ul>


				<?php
/**************** FILES ****************/

//Cartella di destinazione x i file inseriti manualmente
$cartella_dest_full = realpath($percorso_relativo."files");

$uploadHandler = new Sirius\Upload\Handler($cartella_dest_full);

$uploadHandler->addRule(Sirius\Upload\Handler::RULE_EXTENSION, array('allowed' => array('pdf', 'p7m', 'pdf.p7m')));
$uploadHandler->setPrefix($_POST['dt_atto'] . "-" . $_POST['numero'] . "-" . $_POST['tipo'] . "-" . uniqid()."_");

$result = false;
$result = $uploadHandler->process($_FILES['upload_file']); // ex: subdirectory/my_headshot.png

if ($result) {
	foreach ($result as $key => $file) {
		//Se $file->__get('error') è 4 -> file assente
		//Se $file->__get('error') 0 -> tutto ok
		if (($file->isValid()) && ($file->__get('error') == 0)) {
			//Confermo l'upload
			$file->confirm();
			//Inserisco upload in DB
			$file_in_albo = new Files();
			$file_in_albo->setIdAlbo($albo->getIdAlbo());
			//NOTA: questo serve per distinguere gli atti pubblicatio a mano o importati dai flussi
			//con 's' -> pubblicati a mano (cartella files)
			//altriemtni importati dai flussi (cartella files_albo_nfs)
			// (nb. serve a distinguere in quale cartella cercare i file)
			$file_in_albo->setFromBlob('s');
			$file_in_albo->setFile($file->name);
			$file_in_albo->save();
			echo "<li>".$file_in_albo->getFile()."</li>";
		}
		elseif ($file->__get('error') == 0) {
			echo "<li class='text-danger'> ERROR: ";
			echo $file->name. " - ";
			echo implode('<br>', $file->getMessages())."</li>";
		}
	}
}
?>
							</ul>
						</td>
					</tr>

					</tbody>
				</table>
			</div>

<br/><br/>
<a class="btn btn-default" href="./admin/crea_albo.php">Inserisci un nuovo atto</a>
<br/>



		</div>
	</div>
</div>


<?
include($percorso_relativo."grafica/body_foot_bootstrap_agid.php");
?>

