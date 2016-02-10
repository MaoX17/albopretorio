<?php

$percorso_relativo = "../";
require ($percorso_relativo."include.inc.php");


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


//$keyword = '%'.$_POST['keyword'].'%';
$keyword = $_POST['keyword'].'%';
$anno = $_POST['anno'].'-%';
$sql = "SELECT
 		id_albo,
		 nr_atto,
		 SUBSTRING(oggetto,1,100) as oggetto
		 FROM albi WHERE dt_atto LIKE '".$anno."' AND nr_atto LIKE '".$keyword."' ORDER BY id_albo ASC LIMIT 0, 17;";



$rs2 = $db2->query($sql);



while ($row2 = $rs2->fetchRow(MDB2_FETCHMODE_ASSOC)) {
	// put in bold the written text
	$atto = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', $row2['nr_atto']." - ".$row2['oggetto']);
	$atto = stripslashes($atto);
	$atto_txt = stripslashes($row2['nr_atto']." - ".$row2['oggetto']);
	// add new option
	$id_atto = $row2['id_albo'];
	echo '<li onclick="set_item(\''.str_replace("'", "\'", $atto_txt).'\', '.$id_atto.')"><a href="#">'.$atto.'</a></li>';
}


?>