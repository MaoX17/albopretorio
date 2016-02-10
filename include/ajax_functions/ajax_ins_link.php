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
$link = $_POST['link'];
$name = $_POST['name'];
$tipo= $_POST['tipo'];
$id_bando= $_POST['id_bando'];
//$keyword = $_POST['keyword'].'%';
//$ident = $_POST['ident'];

/*
 * TODO: aggiungi distinzione fra nostro ente (e interroghi PADOC) e ente esterno (e interroghi la tabella locale)
 */

$sql = "INSERT INTO
		`Documenti`
		(`name`, `size`, `type`, `url`, `tipo_documento`, `bandi_id_bando`)
		VALUES
		('".$name."', '0', 'link', '".$link."', '".$tipo."', '".$id_bando."')";


$rs = $db->query($sql);
if( MDB2::isError($rs) ) {
	echo "<p class='text-danger'><strong>Attenzione!</strong>Si e' verificato un errore durante
		l'esecuzione della query \"$sql\".</p>";
	//$result = FALSE;
	throw new Exception('Errore nel inserimento di un nuovo Ditta (anagrafica) nel DB');
	//die($rs->getMessage());
}
else {
	echo "<p class='text-success'><strong>Inserito!</strong> - <a href='$link'>$name</a> </p>";
}

?>