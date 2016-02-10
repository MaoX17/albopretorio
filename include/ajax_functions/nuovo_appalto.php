<!-- * Maurizio Proietti - http://blog.maurizio.proietti.name -->
<?php
/**
 * Created by PhpStorm.
 * User: Maurizio Proietti - http://blog.maurizio.proietti.name
 * Date: 30/12/2014
 * Time: 09:38
 */


$percorso_relativo = "../../";
require ($percorso_relativo."include.inc.php");

//include('manutenzione_on.php');

/*
 * Config e chiamo DB *******************************
 */
require_once ($percorso_relativo."class/ConfigSingleton.php");
$cfg = SingletonConfiguration::getInstance ();
require_once ($percorso_relativo."class/Db.php");
$factory=DbAbstractionFactory::getFactory($cfg->getValue('AstrazioneDB'));
$factory->setDsn($cfg->getValue('DSN'));
$db=$factory->createInstance();
//**************
$factory2=DbAbstractionFactory::getFactory($cfg->getValue('AstrazioneDB2'));
$factory2->setDsn($cfg->getValue('DSN2'));
$db2=$factory2->createInstance();
//********************************************************

//TODO: Se passo la var id_bando in GET allora sono in modifica
if (isset($_GET['id_bando'])) {
	$bando = BandiQuery::create()->findPk($_GET['id_bando']);
	//Controllo se esiste e creo
	$determina_a_contrarre = $bando->getDetermine();
}
else {
	$bando = new Bandi();
	$determina_a_contrarre = new Determine();
}



$titolo_pagina = "Nuovo Appalto - Provincia di Prato";

include($percorso_relativo."grafica/head_bootstrap.php");
include($percorso_relativo."grafica/body_head_bootstrap.php");

?>

<div class="container">

<div class="row row-offcanvas row-offcanvas-right">

<div class="col-xs-12 col-sm-12">

<form class="form-horizontal"  role="form" action="./nuovo_appalto2.php" method="post">
<label for="name">Scegli la Determina a contrarre: </label>
<div class="form-group">
	<label for="anno_determina" class="col-sm-3 control-label"> Anno Atto </label>
	<div class="col-sm-9">

		<input class="form-control" type="text" name="anno_determina" id="anno_determina" value="<?=date('Y')?>">
		<input class="form-control" type="hidden" name="id_determina" id="id_determina" >

	</div>
</div>
<div class="form-group">
	<label for="determina_id" class="col-sm-3 control-label"> Num. Atto </label>
	<div class="col-sm-9">
		<input class="form-control dropdown-toggle" type="text" name="nr_determina" id="nr_determina" onkeyup="autocomplet()" autocomplete="off">
		<ul class="dropdown-menu" id="determina_list_id"></ul>
	</div>
</div>

<label for="name">Dati del bando: </label>

<div class="form-group">
	<label for="oggetto" class="col-sm-3 control-label">Oggetto</label>
	<div class="col-sm-9">
		<input class="form-control" type="text" name="oggetto" required value="<?=$bando->getOggetto()?>">
	</div>
</div>
<div class="form-group">
	<label for="procedura" class="col-sm-3 control-label">Procedura di aggiudicazione</label>
	<div class="col-sm-9">
		<select class="form-control" name="procedura" id="procedura">
			<option value=""></option>
			<?

			$procedure = ProceduresQuery::create()->find();
			// $authors contains a collection of Author objects
			// one object for every row of the author table
			foreach($procedure as $procedura) {

				echo '<option value="'.$procedura->getIdProcedura().'">'.$procedura->getProcedura().'</option>'."\n";
			}
			//echo (option_procedure());
			?>
		</select>
	</div>
</div>
<!--
<div class="form-group">
	<label for="lettera_invito" class="col-sm-3 control-label">Lettera di invito</label>
	<div class="col-sm-9">
		<input class="form-control" type="text" name="lettera_invito" id="lettera_invito" placeholder="serve nel appalto?????" value="">
	</div>
</div>
-->
<div class="form-group">
	<label for="procedura_comunitaria" class="col-sm-3 control-label">Procedura comunitaria</label>
	<div class="col-sm-9">
		<input id="procedura_comunitaria" name="procedura_comunitaria" type="checkbox">
	</div>
</div>


<!-- http://www7.prvprato1/rubrica_ldap/visualizza_singolo.php?id=430&id_servizio=405 -->
<div class="form-group">
	<label for="resp_procedimento" class="col-sm-3 control-label">Responsabile Procedimento</label>
	<div class="col-sm-9">
		<input class="form-control" type="text" name="resp_procedimento" id="resp_procedimento" onkeyup="autocomplet_responsabile(this)" autocomplete="off">
		<input class="form-control hidden" type="text" name="resp_procedimento_id" id="resp_procedimento_id">
		<input class="form-control hidden" type="text" name="resp_procedimento_id_servizio" id="resp_procedimento_id_servizio">
		<br>
		<ul class="dropdown-menu" id="responsabile_list_id"></ul>
	</div>
</div>

<div class="form-group">
	<label for="uffici_riferimento0" class="col-sm-3 control-label">Uffici di Riferimento</label>
	<div class="col-sm-9 ui-widget">
		<input class="form-control" type="text" id="uffici_riferimento0" name="uffici_riferimento[]" onfocus="autocomplet_uffici(this)" autocomplete="off">
		<input class="form-control hidden" type="text" id="uffici_riferimento0_hide" name="uffici_riferimento_hide[]">
	</div>
	<label for="uffici_riferimento0_nota" class="col-sm-3 control-label">Nota ufficio di Riferimento</label>
	<div class="col-sm-9 ui-widget">
		<input class="form-control" type="text" id="uffici_riferimento0_nota" name="uffici_riferimento_nota[]"  autocomplete="off">
	</div>

	<div id="uffici_riferimento" class="col-sm-9 col-sm-offset-3">
		<a href="#uffici_riferimento0_hide" id="add_ufficio" class="btn-xs btn-info"><span>Aggiungi altro ufficio</span></a>
		<br>
		<ul class="dropdown-menu" id="uffici_list_id"></ul>
	</div>
</div>

<br>

<div class="form-group">
	<label for="dt_pubblicazione" class="col-sm-3 control-label">Data Pubblicazione</label>
	<div class="col-sm-9">
		<input class="form-control" type="date" name="dt_pubblicazione" value="<?=date("Y-m-d")?>">
	</div>
</div>
<div class="form-group">
	<label for="ora_pubblicazione" class="col-sm-3 control-label">Ora Pubblicazione</label>
	<div class="col-sm-9">
		<input class="form-control" type="time" name="ora_pubblicazione" value="<?=date("H:i")?>">
	</div>
</div>
<div class="form-group">
	<label for="nota_pubblicazione" class="col-sm-3 control-label">Nota per Pubblicazione</label>
	<div class="col-sm-9">
		<input class="form-control" type="text" name="nota_pubblicazione">
	</div>
</div>

<div class="form-group">
	<label for="dt_scadenza" class="col-sm-3 control-label">Data scadenza</label>
	<div class="col-sm-9">
		<input class="form-control" type="date" name="dt_scadenza" >
	</div>
</div>
<div class="form-group">
	<label for="ora_scadenza" class="col-sm-3 control-label">Ora scadenza</label>
	<div class="col-sm-9">
		<input class="form-control" type="time" name="ora_scadenza" >
	</div>
</div>
<div class="form-group">
	<label for="nota_scadenza" class="col-sm-3 control-label">Nota per scadenza</label>
	<div class="col-sm-9">
		<input class="form-control" type="text" name="nota_scadenza">
	</div>
</div>

<br>

<div class="form-group">
	<label for="nr_lotti" class="col-sm-3 control-label">Nr. Lotti complessivi</label>
	<div class="col-sm-9">
		<select class="form-control" name="nr_lotti" id="nr_lotti">
			<? for ($i=1; $i<=21;$i++) {
				?>
				<option value="<?=$i?>"><?=$i?></option>
			<?
			}
			?>
		</select>


	</div>
</div>


<div class="form-group">
	<div class="col-sm-9 col-sm-offset-3">

		<input type="submit" class="btn btn-info" value="Avanti ->">
	</div>
</div>

</form>

</div>

</div><!--/row-->
<br><br>

</div><!--/.container-->


note link albo:
http://albopretorio.provincia.prato.it/visualizza-dettagli.php?id_albo=201400123


<?
include($percorso_relativo."grafica/body_foot_bootstrap.php");
?>

