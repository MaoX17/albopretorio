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
?>

<div class="container">

	<div class="row">
		<div class="col-xs-12 col-sm-10">
			<h1><?=$titolo_pagina?></h1>
		</div>
	</div>


	<?php
$albo = AlbiQuery::create()
		->findPk($_POST['id_albo']);
$albo->setOggetto($_POST['oggetto']);
$albo->setNote($_POST['note']);

$albo->save();


	//NOTE: Costruisco l'array dei file da eliminare (quelli selezionati)
	//NOTE: inserito solo qui -- se il file proviene dai flussi documentali toglie solo il collegamento nell'albo
	$ARRAY_id_file_del = array();

	foreach ($_POST as $key => $value) {
		$tmp_id_file = explode("_", $key);
		if ($tmp_id_file[0] == 'delfile') {
			array_push($ARRAY_id_file_del,($tmp_id_file[1]));
		}
	}

	//NOTE: ESeguo Eliminazione file
	$cartella_dest = realpath($percorso_relativo."files/");
	foreach ($ARRAY_id_file_del as $id_file_da_eliminare) {
		//echo "YYY: ".$id_file_da_eliminare;
		$file_tmp = FilesQuery::create()
				->findPk($id_file_da_eliminare);
		//NOTE: se getfromBlob = s il file è inserito dal programma dei flussi documentali
		if ($file_tmp->getFromBlob() == 's') {
			//NOTE: elimino solo il record dal DB
			$file_tmp->delete();
		}
		else {
			//NOTE: elimino il file dal filesystem
			@unlink($cartella_dest."/".$file_tmp->getFile());
			$file_tmp->delete();
		}

	}

?>

<div class="row">
		<div class="col-xs-12 col-sm-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Riepilogo dati modificati</h3>
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
		<td><?=(is_object($albo->getDtAtto())?$albo->getDtAtto()->format("d.m.Y"):"N.D.")?></td>
		<td><?=$tipo_atto->getTipo()?></td>
		<td><?=$albo->getNote()?></td>


		<?php
		/**************** FILES ****************/

		//print_r($_FILES['upload_file']);

		//NOTE: Cartella di destinazione x i file inseriti manualmente
		$cartella_dest_full = realpath($percorso_relativo."files");

		$uploadHandler = new Sirius\Upload\Handler($cartella_dest_full);


		$uploadHandler->addRule(Sirius\Upload\Handler::RULE_EXTENSION, array('allowed' => array('pdf', 'p7m', 'pdf.p7m')));
		//$uploadHandler->addRule(Sirius\Upload\Handler::RULE_SIZE, array('size' => '20M'));
		$uploadHandler->setPrefix($_POST['dt_atto'] . "-" . $_POST['numero'] . "-" . $_POST['tipo'] . "-" . uniqid()."_");

		//$result = false;
		$result = $uploadHandler->process($_FILES['upload_file']); // ex: subdirectory/my_headshot.png
		//print_r($result);

		if ($result) {
			foreach ($result as $key => $file) {
				//NOTE: Se $file->__get('error') è 4 -> file assente
				//NOTE:Se $file->__get('error') 0 -> tutto ok o altri errori
				if (($file->isValid()) && ($file->__get('error') == 0)) {
					//Confermo l'upload
					$file->confirm();
					//print_r($file);
					//Inserisco upload in DB
					$file_in_albo = new Files();
					$file_in_albo->setIdAlbo($albo->getIdAlbo());

					//NOTE: questo serve per distinguere gli atti pubblicatio a mano o importati dai flussi
					//con 's' -> pubblicati a mano (cartella files)
					//altriemtni importati dai flussi (cartella files_albo_nfs)
					// (nb. serve a distinguere in quale cartella cercare i file)
					$file_in_albo->setFromBlob('s');
					$file_in_albo->setFile($file->name);
					$file_in_albo->save();
					//print_r($file_in_albo);
				}
				elseif ($file->__get('error') == 0) {
					echo "<td><ul>";
					echo "<li class='text-danger'> ERROR: ";
					echo $file->name. " - ";
					echo implode('<br>', $file->getMessages())."</li>";
					echo "</ul></td>";
				}
			}
		}

		?>

		<td>
			<ul>
				<?php

				$tutti_file = FilesQuery::create()
					->filterByIdAlbo($albo->getIdAlbo())
					->find();
				foreach ($tutti_file as $singolo_file) {
					echo "<li>".$singolo_file->getFile()."</li>";
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

