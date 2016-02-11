<?php

use Base\Albi as BaseAlbi;

/**
 * Skeleton subclass for representing a row from the 'albi' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Albi extends BaseAlbi
{

	public function preInsert(ConnectionInterface $con = null)
	{
		//TODO: Controllare che con un nuovo inserimento manuale tutto fili liscio
		/*
	 	* Config e chiamo DB *******************************
	 	*/
		require_once ('/class/ConfigSingleton.php');
		$cfg = SingletonConfiguration::getInstance ();
		require_once ("/class/Db.php");
		$factory=DbAbstractionFactory::getFactory($cfg->getValue('AstrazioneDB'));
		$factory->setDsn($cfg->getValue('DSN'));
		$db=$factory->createInstance();
		//********************************************************

		/*
		 * ----------------- Sezione aggiornamento nuovo anno ----------------------
		 */
		$sql = "SHOW TABLE STATUS LIKE 'albi';";
		$rs = $db->query($sql);
		$row = $rs->fetchRow(DB_FETCHMODE_ASSOC);
		//echo "ID = ".$row['Auto_increment']."<br>";
		$id_next = $row['Auto_increment'];
		$dt_id_next = substr($id_next, 0, 4);
		$dt_anno_corrente = date("Y");
		if ($dt_anno_corrente > $dt_id_next) {
			//Ho cambiato anno
			//$newid = 201400001;
			$newid = $dt_anno_corrente."00001";
			$sql = "ALTER TABLE albi AUTO_INCREMENT = ".$newid.";";
			$rs = $db->query($sql);
			if( DB::isError($rs) ) {
				echo "<p><strong>Attenzione!</strong>Si e' verificato un errore durante
				l'esecuzione della query \"$sql\".";
				return false;
				throw new Exception('Errore di aggiornamento anno nuovo');

				//die($rs->getMessage());
			}
		}

		/*
		 * ----------------- FINE Sezione aggiornamento nuovo anno ----------------------
		 */

		return true;
	}
}
