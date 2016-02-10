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



$albo = new Albo();
$tipo = new Tipo();
$area = new Area();
$tipo_determina = new Tipo_determina();
$tipo_trasp = new Tipo_Trasp();

$albo->setTipo($tipo);
$albo->setArea($area);
$albo->setTipo_determina($tipo_determina);
$albo->setTipo_trasp($tipo_trasp);

?>


<div class="container">

        <div class="row">
                <div class="hidden">
                        <h2><?=$titolo_pagina?></h2>
                </div>
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                        <h3>Ricerca e modifica un atto</h3>
                </div>
        </div>



        <div class="row">
                <div class="col-xs-12 col-sm-12">
                        <div class="panel panel-primary">
                                <div class="panel-heading">
                                        <h3 class="panel-title">Scegli i campi di ricerca</h3>
                                </div>
                                <div class="panel-body">
                                        <form class="form-horizontal" name='myForm' id='myForm' action="admin/esegui_ricerca_albo.php" method="get">
                                                <div class="form-group">
                                                        <label for="C_tipo" class="col-sm-2 control-label">Tipo di atto:</label>
                                                        <div class="col-sm-10">
                                                                <select class="form-control" name="tipo" id="C_tipo" onchange="controlla_abilita_tipo_det()">
                                                                        <option selected="selected" value="%">Qualsiasi</option>
                                                                        <?php
                                                                        $tipi = TipiQuery::create()
                                                                            ->find();
                                                                        foreach ($tipi as $tipo) {
                                                                                ?>
                                                                                <option value="<?=$tipo->getIdTipo()?>"><?=$tipo->getTipo()?></option>
                                                                                <?php
                                                                        }
                                                                        ?>
                                                                </select>
                                                        </div>
                                                </div>
                                                <!--
                                                NOTE: tolgo questa sezione perchè fa casino nella ricerca
                                                <div class="form-group">
                                                        <label for="C_tipo" class="col-sm-2 control-label">Tipo determina:</label>
                                                        <div class="col-sm-10">
                                                                <select class="form-control" name="tipo_determina" id="C_tipo_determina" disabled>
                                                                        <option selected="selected" value="%">Qualsiasi</option>
                                                                        <?php
                                                                        $tipi_determina = TipiDeterminaQuery::create()
                                                                            ->find();
                                                                        foreach ($tipi_determina as $tipo_determina) {
                                                                                ?>
                                                                                <option label="<?=$tipo_determina->getTipoDetermina()?>" value="<?=$tipo_determina->getIdTipoDetermina()?>"><?=$tipo_determina->getTipoDetermina()?></option>
                                                                                <?php
                                                                        }
                                                                        ?>
                                                                </select>
                                                        </div>
                                                </div>
												-->
                                                <div class="form-group">
                                                        <label for="C_tipo_trasp" class="col-sm-2 control-label">Tipo dell'atto per la trasparenza:</label>
                                                        <div class="col-sm-10">
                                                                <select class="form-control" name="tipo_trasp" id="C_tipo_trasp" >
                                                                        <option selected="selected" value="%">Qualsiasi</option>
                                                                        <?php
                                                                        $tipi_trap = TipiTraspQuery::create()
                                                                            ->find();
                                                                        foreach ($tipi_trap as $tipo_trasp) {
                                                                                ?>
                                                                                <option label="<?=$tipo_trasp->getTipoTrasp()?>" value="<?=$tipo_trasp->getIdTipoTrasp()?>"><?=$tipo_trasp->getTipoTrasp()?></option>
                                                                                <?php
                                                                        }
                                                                        ?>
                                                                </select>
                                                        </div>
                                                </div>

                                                <div class="form-group">
                                                        <label for="C_numero" class="col-sm-2 control-label">Nr. Atto:</label>
                                                        <div class="col-sm-10">
                                                                <input class="form-control" type="text" name="numero" id="C_numero"  />
                                                        </div>
                                                </div>
                                                <div class="form-group">
                                                        <label for="C_dt_atto_dal" class="col-sm-2 control-label">Data Atto DAL (aaaa-mm-gg):</label>
                                                        <div class="col-sm-10">
                                                                <div id="dt_atto_dal" class="input-group date">
                                                                        <input class="form-control" type="text" id="C_dt_atto_dal" name="dt_atto_dal" readonly  />
                                                                        <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                                </div>
                                                        </div>
                                                </div>

                                                <div class="form-group">
                                                        <label for="C_dt_atto_al" class="col-sm-2 control-label">Data Atto AL (aaaa-mm-gg):</label>
                                                        <div class="col-sm-10">
                                                                <div id="dt_atto_al" class="input-group date">
                                                                        <input class="form-control" type="text" id="C_dt_atto_al" name="dt_atto_al" readonly  />
                                                                        <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                                </div>
                                                        </div>
                                                </div>
                                                <div class="form-group">
                                                        <label for="C_oggetto" class="col-sm-2 control-label">Oggetto:</label>
                                                        <div class="col-sm-10">
                                                                <input class="form-control" type="text" name="oggetto" id="C_oggetto"   />
                                                        </div>
                                                </div>
                                                <div class="form-group">
                                                        <label for="C_autorita" class="col-sm-2 control-label">Autorit&agrave; emanante:</label>
                                                        <div class="col-sm-10">
                                                                <input class="form-control" type="text" name="autorita" id="C_autorita"   size="30" maxlength="250"  />
                                                        </div>
                                                </div>
                                                <div class="form-group">
                                                        <label for="C_area" class="col-sm-2 control-label">Area di riferimento:</label>
                                                        <div class="col-sm-10">
                                                                <select class="form-control" name="area" id="C_area">
                                                                        <option value="%">Qualsiasi</option>
                                                                        <?php
                                                                        $aree = AreeQuery::create()
                                                                            ->orderByAttivo('desc')
                                                                            ->find();
                                                                        foreach ($aree as $area) {
                                                                                if ($area->getAttivo() == "N") {
                                                                                        ?>
                                                                                        <option value="<?=$area->getIdArea()?>"> INATTIVA - <?=$area->getArea()?> - <?=$area->getResponsabile()?></option>
                                                                                        <?php
                                                                                }
                                                                                else {
                                                                                        ?>
                                                                                        <option value="<?=$area->getIdArea()?>"> <?=$area->getArea()?> - <?=$area->getResponsabile()?></option>
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
                                                                        <input class="form-control" type="text" id="C_dt_pubbl_dal" name="dt_pubbl_dal"  readonly />
                                                                        <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                                </div>
                                                        </div>
                                                </div>
                                                <div class="form-group">
                                                        <label for="C_dt_pubbl_al" class="col-sm-2 control-label">Data Pubblicaz. AL (aaaa-mm-gg):</label>
                                                        <div class="col-sm-10">
                                                                <div id="dt_pubbl_al" class="input-group date">
                                                                        <input class="form-control" type="text" id="C_dt_pubbl_al" name="dt_pubbl_al" readonly />
                                                                        <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                                </div>
                                                        </div>
                                                </div>

                                                <div class="form-group">
                                                        <div class="col-sm-offset-2 col-sm-10">
                                                                <input class="btn btn-primary" name="ok" type="submit" value="Esegui Ricerca ->" />
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

