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
//**************
$factory3=DbAbstractionFactory::getFactory($cfg->getValue('AstrazioneDB3'));
$factory3->setDsn($cfg->getValue('DSN3'));
$db3=$factory3->createInstance();
//********************************************************


//$keyword = '%'.$_POST['keyword'].'%';
$keyword = $_POST['keyword'].'%';
$ident = $_POST['ident'];

/*
 * TODO: aggiungi distinzione fra nostro ente (e interroghi PADOC) e ente esterno (e interroghi la tabella locale)
 */
//$sql = "SELECT * FROM Servizi_Ente WHERE Servizio LIKE '".$keyword."' ORDER BY id_Servizi_Ente ASC LIMIT 0, 17;";
$sql = "select
	distinct (e2.denominazione) as servizio,
	'Provincia di Prato' as ente,
    e2.id_entita as id_servizi_ente
    FROM
    entita as e1
    INNER JOIN entita as e2 ON e2.id_entita = e1.parent
    INNER JOIN entita as e3 ON e3.id_entita = e2.parent
	where
    e1.tipo = 'carica'
    AND e2.tipo = 'unita_organizzativa'
    and e2.parent > 35
    and lower(e2.denominazione) LIKE '".$keyword."'
    order by servizio";


$rs = $db3->query($sql);


while ($row = $rs->fetchRow(MDB2_FETCHMODE_ASSOC)) {
	// put in bold the written text
	$servizio = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', $row['servizio']." - ".substr($row['ente'],0,130));
	$id_servizio = $row['id_servizi_ente'];
	echo '<li onclick="set_item_uffici(\''.$ident.'\',\''.str_replace("'", "\'", substr($row['servizio']." - ".$row['ente'],0,140)).'\', '.$id_servizio.')"><a href="#uffici_riferimento0_hide">'.$servizio.'</a></li>';
}


?>