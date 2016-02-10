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

//recupero dati albo...
$albo = AlbiQuery::create()
	->findPk($_GET['id_albo']);

$tipo_atto = TipiQuery::create()
	->findPk($albo->getIdTipo());


$area = AreeQuery::create()
		->findPk($albo->getIdArea());


if ($albo->getIdTipoTrasp() != null) {
	$tipo_trasp = TipiTraspQuery::create()
			->findPk($albo->getIdTipoTrasp());
}

if ($albo->getIdTipoDetermina() != null) {
	$tipo_determina = TipiDeterminaQuery::create()
		->findPk($albo->getIdTipoTrasp());
}


$files_albo = FilesQuery::create()
 	->filterByIdAlbo($albo->getIdAlbo())
	->find();


?>

<div class="container">

	<div class="row">
		<div class="hidden">
			<h2><?=$titolo_pagina?></h2>
		</div>
		<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
			<h3>Modifica i dati</h3>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12 col-sm-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Inserimento Dati</h3>
				</div>
				<div class="panel-body">
					<form class="form-horizontal" name='myForm' id='myForm' action="/admin/aggiorna_albo.php" method="post" enctype="multipart/form-data">

						<input type="hidden" name="id_albo" value="<?=$albo->getIdAlbo()?>">

						<div class="form-group">
							<label for="C_tipo" class="col-sm-2 control-label">Tipo di atto:</label>
							<div class="col-sm-10">
								<select class="form-control" required name="tipo" id="C_tipo" onchange="controlla_abilita_tipo_det()">
									<option value="">Selezionare il tipo di atto</option>
									<?php
									$tipi_tmp = TipiQuery::create()
											->find();
									foreach ($tipi_tmp as $tipo_tmp) {
										if ($tipo_tmp->getIdTipo() == $tipo_atto->getIdTipo())
											$selected = ' selected="selected" ';
										else
											$selected = ' ';
										?>
										<option <?=$selected?> value="<?=$tipo_tmp->getIdTipo()?>"><?=$tipo_tmp->getTipo()?></option>
										<?php
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="C_tipo" class="col-sm-2 control-label">Tipo determina:</label>
							<div class="col-sm-10">
								<select class="form-control" name="tipo_determina" id="C_tipo_determina" disabled>
									<option value="">Selezionare il tipo di determina</option>
									<?php
									$tipi_determina_tmp = TipiDeterminaQuery::create()
											->find();
									foreach ($tipi_determina_tmp as $tipo_determina_tmp) {
										if ((isset($tipo_determina)) && (is_object($tipo_determina)) && ($tipo_determina_tmp->getIdTipoDetermina() == $tipo_determina->getIdTipoDetermina()))
											$selected = ' selected="selected" ';
										else
											$selected = ' ';
										?>
										<option <?=$selected?> label="<?=$tipo_determina_tmp->getTipoDetermina()?>" value="<?=$tipo_determina_tmp->getIdTipoDetermina()?>"><?=$tipo_determina_tmp->getTipoDetermina()?></option>
										<?php
									}
									?>
								</select>
								<span class="help-inline alert alert-block"><span class="fa fa-info-circle"></span> Selezionabile solo se si è scelto come Tipo Atto la Determina Dirigenziale. Altrimenti ignorare il campo.</span>
							</div>

						</div>

						<div class="form-group">
							<label for="C_tipo_trasp" class="col-sm-2 control-label">Tipo dell'atto per la trasparenza:</label>
							<div class="col-sm-10">
								<select required class="form-control" name="tipo_trasp" id="C_tipo_trasp" >

									<?php
									$tipi_trasp_tmp = TipiTraspQuery::create()
											->find();
									foreach ($tipi_trasp_tmp as $tipo_trasp_tmp) {
										if ((isset($tipo_trasp)) && (is_object($tipo_trasp)) && ($tipo_trasp_tmp->getIdTipoTrasp() == $tipo_trasp->getIdTipoTrasp()))
											$selected = ' selected="selected" ';
										else
											$selected = ' ';
										?>
										<option <?=$selected?> label="<?=$tipo_trasp_tmp->getTipoTrasp()?>" value="<?=$tipo_trasp_tmp->getIdTipoTrasp()?>"><?=$tipo_trasp_tmp->getTipoTrasp()?></option>
										<?php
									}
									?>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label for="C_spesa_prevista" class="col-sm-2 control-label">Spesa Prevista:</label>
							<div class="col-sm-10">
								<div class="input-group">
									<span class="input-group-addon">
										<span class="fa fa-euro"></span></span>
									<input required name="spesa_prevista" type="number" value="<?=$albo->getSpesaPrevista()?>" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control" id="C_spesa_prevista" />


								</div>
								<span class="help-inline alert alert-block"><span class="fa fa-info-circle"></span> Inserire la spesa prevista. Se non presente inserisci il numero zero.</span>
							</div>
						</div>


						<div class="form-group">
							<label for="C_numero" class="col-sm-2 control-label">Nr. Atto:</label>
							<div class="col-sm-10">
								<input class="form-control" type="number" name="numero" id="C_numero" value="<?=$albo->getNrAtto()?>" />
							</div>
						</div>
						<div class="form-group">
							<label for="C_dt_atto" class="col-sm-2 control-label">Data Atto (aaaa-mm-gg):</label>
							<div class="col-sm-10">
								<div id="dt_atto" class="input-group date">
									<input class="form-control" type="text" id="C_dt_atto_dal" name="dt_atto" value="<?=(is_object($albo->getDtAtto())?$albo->getDtAtto()->format("Y-m-d"):"")?>"/>
									<span class="input-group-addon"><span class="fa fa-calendar"></span></span>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="C_oggetto" class="col-sm-2 control-label">Oggetto:</label>
							<div class="col-sm-10">
								<input required class="form-control" type="text" name="oggetto" id="C_oggetto" value="<?=$albo->getOggetto()?>"/>
							</div>
						</div>

						<div class="form-group">
							<label for="C_autorita" class="col-sm-2 control-label">Autorit&agrave; emanante:</label>
							<div class="col-sm-10">
								<input value="<?=$albo->getAutoritaEmanante()?>" required class="form-control" type="text" name="autorita" id="C_autorita" />
							</div>
						</div>
						<div class="form-group">
							<label for="C_area" class="col-sm-2 control-label">Area di riferimento:</label>
							<div class="col-sm-10">
								<select required class="form-control" name="area" id="C_area">
									<option value="">Selezionare l'area</option>
									<?php
									$aree_tmp = AreeQuery::create()
											->orderByAttivo('desc')
											->find();
									foreach ($aree_tmp as $area_tmp) {
										if ($area_tmp->getIdArea() == $area->getIdArea())
											$selected = ' selected="selected" ';
										else
											$selected = ' ';
										if ($area_tmp->getAttivo() == "N") {
											?>
											<option <?=$selected?> value="<?=$area_tmp->getIdArea()?>"> INATTIVA - <?=$area_tmp->getArea()?> - <?=$area_tmp->getResponsabile()?></option>
											<?php
										}
										else {
											?>
											<option <?=$selected?> value="<?=$area_tmp->getIdArea()?>"> <?=$area_tmp->getArea()?> - <?=$area_tmp->getResponsabile()?></option>
											<?php
										}
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="C_dt_pubbl_dal" class="col-sm-2 control-label">Data Pubblicaz. DAL (aaaa-mm-gg):</label>
							<div class="col-sm-10">
								<div id="dt_pubbl_dal" class="input-group date">
									<input value="<?=$albo->getDtPubblicazDal()->format("Y-m-d")?>" required class="form-control" type="text" id="C_dt_pubbl_dal" name="dt_pubbl_dal"   />
									<span class="input-group-addon"><span class="fa fa-calendar"></span></span>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="C_piu_15" class="col-sm-2 control-label">Aggiungi 15 Giorni</label>
							<div class="col-sm-10">
								<input type="button" class="btn btn-default" id="C_piu_15" name="piu_15" value="+15gg" onclick="javascript:aggiungi_15(dt_pubbl_dal,dt_pubbl_al)"/>
							</div>
						</div>
						<div class="form-group">
							<label for="C_piu_30" class="col-sm-2 control-label">Aggiungi 30 Giorni</label>
							<div class="col-sm-10">
								<input type="button" class="btn btn-default" id="C_piu_30" name="piu_30" value="+30gg" onclick="javascript:aggiungi_30(dt_pubbl_dal,dt_pubbl_al)"/>
							</div>
						</div>

						<div class="form-group">
							<label for="C_dt_pubbl_al" class="col-sm-2 control-label">Data Pubblicaz. AL (aaaa-mm-gg):</label>
							<div class="col-sm-10">
								<div id="dt_pubbl_al" class="input-group date">
									<input value="<?=$albo->getDtPubblicazAl()->format("Y-m-d")?>" required class="form-control" type="text" id="C_dt_pubbl_al" name="dt_pubbl_al"  />
									<span class="input-group-addon"><span class="fa fa-calendar"></span></span>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="C_note" class="col-sm-2 control-label">Note:</label>
							<div class="col-sm-10">
								<input value="<?=$albo->getNote()?>" class="form-control" type="text" name="note" id="C_note" />
							</div>
						</div>


						<?php
						//File già presenti da selezionare per eliminarli
						//NOTE: se getfromBlob = s il file è inserito dal programma dei flussi documentali
						foreach ($files_albo as $file_albo) {
							if ($file_albo->getFromBlob() == 's') {
								$cartella_files = "/files/";
								$disabled = ' ';
							}
							else {
								$cartella_files = "/files_nfs/";
								$disabled = ' disabled ';
							}

						?>
							<div>
								<div class="col-sm-10 col-sm-offset-2">
									<input <?=$disabled?> type="checkbox" name="delfile_<?=$file_albo->getIdFiles()?>">
									Elimina il File: <a target="_blank" href="<?=$cartella_files.$file_albo->getFile()?>"> <?=$file_albo->getFile()?></a>
								</div>
							</div>
						<?php
						}
						?>

						<?php
						for ($i=0;$i<=10;$i++) {
							?>
							<div class="form-group">
								<label for="upload_file_<?=$i?>" class="col-sm-2 control-label">Inserisci File <?=$i?></label>
								<div class="col-sm-10">
									<input type="file" class="form-control" name="upload_file[]" id="upload_file_<?=$i?>" >
								</div>
							</div>
							<?
						}
						?>



						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<input class="btn btn-primary" name="ok" type="submit" value="Esegui le modifiche all'Albo ->" />
							</div>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>
</div>


<?
include($percorso_relativo."grafica/body_foot_bootstrap_agid.php");
?>

