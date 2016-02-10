<?php
// PDO connect *********
/*
function connect() {
    return new PDO('mysql:host=localhost;dbname=autocomplet', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
}

$pdo = connect();
$keyword = '%'.$_POST['keyword'].'%';
$sql = "SELECT * FROM country WHERE country_name LIKE (:keyword) ORDER BY country_id ASC LIMIT 0, 10";
$query = $pdo->prepare($sql);
$query->bindParam(':keyword', $keyword, PDO::PARAM_STR);
$query->execute();
$list = $query->fetchAll();
foreach ($list as $rs) {
	// put in bold the written text
	$country_name = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', $rs['country_name']);
	// add new option
    echo '<li onclick="set_item(\''.str_replace("'", "\'", $rs['country_name']).'\')">'.$country_name.'</li>';
}
*/

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


//$keyword = '%'.$_POST['keyword'].'%';
$keyword = $_POST['keyword'].'%';
$anno = $_POST['anno'].'-%';
$sql = "SELECT * FROM albi WHERE dt_atto LIKE '".$anno."' AND nr_atto LIKE '".$keyword."' ORDER BY id_albo ASC LIMIT 0, 17;";


$rs2 = $db2->query($sql);

//var_dump($rs2);

while ($row2 = $rs2->fetchRow(MDB2_FETCHMODE_ASSOC)) {
	// put in bold the written text
	$atto = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', $row2['nr_atto']." - ".$row2['oggetto']);
	// add new option
	$id_atto = $row2['id_albo'];
	echo '<li onclick="set_item(\''.str_replace("'", "\'", $row2['nr_atto']).'\', '.$id_atto.')"><a href="#">'.$atto.'</a></li>';
}

/*
$list = $rs2->fetchAll(MDB2_FETCHMODE_ASSOC);
foreach ($list as $result) {
	// put in bold the written text
	$atto = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', $result['nr_atto']);
	// add new option
	echo '<li onclick="set_item(\''.str_replace("'", "\'", $result['nr_atto']).'\')">'.$atto.'</li>';
}
*/

?>