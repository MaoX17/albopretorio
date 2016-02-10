<?php
/**
 * Created by Maurizio Proietti
 * User: mproietti
 * Date: 31/10/14
 * Time: 14.15
 */
?>

<?php

$percorso_relativo = "../../";
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
//$factory3=DbAbstractionFactory::getFactory($cfg->getValue('AstrazioneDB3'));
//$factory3->setDsn($cfg->getValue('DSN3'));
//$db3=$factory3->createInstance();
//********************************************************




//$keyword = '%'.$_POST['keyword'].'%';
$keyword = $_POST['keyword'].'%';
$ident = $_POST['ident'];

/*
 * TODO: aggiungi distinzione fra nostro ente (e interroghi PADOC) e ente esterno (e interroghi la tabella locale)
 */
//$sql = "SELECT * FROM Servizi_Ente WHERE Servizio LIKE '".$keyword."' ORDER BY id_Servizi_Ente ASC LIMIT 0, 17;";
$sql = "Select
                                e1.nome as nom,
                                e1.cognome as cogn,
                                ind.indirizzo_telematicosmtp as email,
                                e2.tel,
                                e2.parent,
                                e2.denominazione,
                                --e2.tipo_unita_organizzativa as att,
                                --e2.tel,
                                e3.denominazione as de3,
                                e3.id_entita as id_servizio,
                                e4.denominazione as de4,
                                e1.id_entita as id
                                --ps.*
                                FROM
                                entita as e1
                                INNER JOIN positions as ps on e1.id_entita = ps.id_entita
                                INNER JOIN indirizzo_telematicosmtp as ind on e1.id_entita = ind.id_entita
                                INNER JOIN entita as e2 ON e2.id_entita = ps.position
                                INNER JOIN entita as e3 ON e3.id_entita = e2.parent
                                INNER JOIN entita as e4 ON e4.id_entita = e3.parent
                                where e1.cognome <> ''
                                AND (e2.tipo_unita_organizzativa = 'Attiva' OR e2.tipo_unita_organizzativa ISNULL OR e2.tipo_unita_organizzativa = '')
                                AND e2.tel <> ''

                                AND lower(e1.cognome) LIKE lower('".$keyword."%')
                                --AND e3.id_entita LIKE '".$_GET['servizio']."%'
                                --AND e1.id_entita = ".$_GET['id']."
                                --AND e3.id_entita = ".$_GET['id_servizio']."

                                ORDER BY cogn,nom";



$rs = $db2->query($sql);


while ($row = $rs->fetchRow(MDB2_FETCHMODE_ASSOC)) {
// put in bold the written text
//$responsabile = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', $row['cogn']." ".$row['nom']." - ".$row['de3']);
$responsabile = str_replace($_POST['keyword'], $_POST['keyword'], $row['cogn']." ".$row['nom']);
$id_responsabile = $row['id'] ;
$id_servizio_responsabile = $row['id_servizio'];
$id_servizio = $row['id_servizi_ente'];
echo '<button type="button" class="list-group-item" onclick="set_item_responsabile(\''.$ident.'\',\''.str_replace("'", "\'", $responsabile).'\', '.$id_responsabile.','.$id_servizio_responsabile.')">'.$responsabile.'</button>';

}


?>