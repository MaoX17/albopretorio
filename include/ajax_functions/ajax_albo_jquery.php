<?php

$percorso_relativo = "../";
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


// prevent direct access
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	$user_error = 'Access denied - not an AJAX request...';
	trigger_error($user_error, E_USER_ERROR);
	error_log($user_error);
}

// get what user typed in autocomplete input SI CHIAMA SEMPRE GET-term
$term = trim($_GET['term']);
$anno = $_GET['anno'];

//Array di ritorno
$a_json = array();
$a_json_row = array();

//escludo alcuni risultati
$a_json_invalid = array(array("id" => "#", "value" => $term, "label" => "Only letters and digits are permitted..."));
$json_invalid = json_encode($a_json_invalid);

// replace multiple spaces with one
$term = preg_replace('/\s+/', ' ', $term);

// SECURITY HOLE ***************************************************************
// allow space, any unicode letter and digit, underscore and dash
if(preg_match("/[^\040\pL\pN_-]/u", $term)) {
	print $json_invalid;
	exit;
}
// *****************************************************************************

//inserimento con spazi
$parts = explode(' ', $term);
$p = count($parts);



$i = 0;
$sql = "SELECT id_albo, nr_atto, oggetto FROM albi WHERE dt_atto LIKE '".$_GET['anno']."%' AND nr_atto LIKE '".mysql_real_escape_string($parts[$i])."%' ORDER BY id_albo ASC LIMIT 0, 17;";

$rs2 = $db2->query($sql);

//var_dump($rs2);

//ATTENZIONE i campi label e value sono OBBLIGATORI!!!!!
while ($row2 = $rs2->fetchRow(MDB2_FETCHMODE_ASSOC)) {
	$a_json_row["id"] = $row2['id_albo'];
	$a_json_row["value"] = $row2['nr_atto'];
	$a_json_row["label"] = $anno." - ".$row2['nr_atto']."-".$row2['oggetto'];
	array_push($a_json, $a_json_row);


}

// highlight search results
//$a_json = apply_highlight($a_json, $parts);

$json = json_encode($a_json);


print $json;



?>