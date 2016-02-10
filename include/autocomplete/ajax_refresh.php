<?php
// PDO connect *********
function connect() {
    return new PDO('mysql:host=192.168.0.20;dbname=albopretorio', 'user_db', 'pass_db_pass', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
}

$pdo = connect();
//$keyword = '%'.$_POST['keyword'].'%';
$keyword = $_POST['keyword'].'%';
$sql = "SELECT * FROM albi WHERE nr_atto LIKE (:keyword) ORDER BY id_albo ASC LIMIT 0, 10";
$query = $pdo->prepare($sql);
$query->bindParam(':keyword', $keyword, PDO::PARAM_STR);
$query->execute();
$list = $query->fetchAll();
foreach ($list as $rs) {
	// put in bold the written text
	$country_name = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', $rs['nr_atto']." - ".$rs['oggetto']);
	// add new option
    echo '<li onclick="set_item(\''.str_replace("'", "\'", $rs['nr_atto']).'\')">'.$country_name.'</li>';
}
?>