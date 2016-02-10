<?php
class File {

	protected $id_file;
	protected $id_albo;
	protected $file; //percorso e nome file
	protected $tipo;
	protected $from_blob;

	/**
	 * @return mixed
	 */
	public function getFromBlob()
	{
		return $this->from_blob;
	}

	/**
	 * @param mixed $from_blob
	 */
	public function setFromBlob($from_blob)
	{
		$this->from_blob = $from_blob;
	}




	/**
	 * @return the $id_file
	 */
	public function getId_file() {
		return $this->id_file;
	}
	/**
	 * @param $id_albo the $id_albo to set
	 */
	public function setId_albo($id_albo) {
		$this->id_albo = $id_albo;
	}

	/**
	 * @return the $id_albo
	 */
	public function getId_albo() {
		return $this->id_albo;
	}


	/**
	 * @return the $file
	 */
	public function getFile() {
		return $this->file;
	}

	/**
	 * @return the $tipo
	 */
	public function getTipo() {
		return $this->tipo;
	}

	/**
	 * @param $id_file the $id_file to set
	 */
	public function setId_file($id_file) {
		$this->id_file = $id_file;
	}

	/**
	 * @param $file the $file to set
	 */
	public function setFile($file) {
		$this->file = $file;
	}

	/**
	 * @param $tipo the $tipo to set
	 */
	public function setTipo($tipo) {
		$this->tipo = $tipo;
	}
	// tipo file (estensione)


	public function __construct($percorso_file, $from_blob) {
		$this->setFile($percorso_file);
		if ($from_blob <> "") {
			$this->setFromBlob($from_blob);
		}
		else {
			$this->setFromBlob("s");
		}
	}


	public function creaNelDB() {

		/*
		 * Config e chiamo DB *******************************
		 */
		require_once ('class/ConfigSingleton.php');
		$cfg = SingletonConfiguration::getInstance ();
		require_once ("class/Db.php");
		$factory=DbAbstractionFactory::getFactory($cfg->getValue('AstrazioneDB'));
		$factory->setDsn($cfg->getValue('DSN'));
		$db=$factory->createInstance();
		//********************************************************

		$result = "";

		//ESEGUO INSERIMENTO -- INSERT
		/*
		 * XXX: ATTENZIONE HO FATTO UNA MODIFICA QUI... NON SO COSA PUO FARE!!!!
		 * Per ora sembra tutto ok
		 */
		//	id_files='".$this->getId_file()."', 
		$sql =
			"INSERT INTO files SET
		
			id_albo='".$this->getId_albo()."',
			from_blob='".$this->getFromBlob()."',
           	file='".$this->getFile()."';";
		//tipo='".$this->getTipo()."',

		$rs = $db->query($sql);
		if( DB::isError($rs) ) {
			echo "<p><strong>Attenzione!</strong>Si e' verificato un errore durante
				l'esecuzione della query \"$sql\".";
			$result = FALSE;
			throw new Exception('Errore nel inserimento di un nuovo albo pretorio nel DB'.$sql."  XXXXX");
			//die($rs->getMessage());
		}
		else {
			$result = TRUE;
		}

		//setto il corretto id_anagrafica all'oggetto in base al risultato dell'insert
		$sql = "SELECT LAST_INSERT_ID() FROM files";
		$rs = $db->query($sql);
		$row = $rs->fetchRow(DB_FETCHMODE_ORDERED);
		$this->setId_file($row[0]);
		return $result;
	}


	public function aggiornaNelDB() {

		/*
		 * Config e chiamo DB *******************************
		 */
		require_once ('class/ConfigSingleton.php');
		$cfg = SingletonConfiguration::getInstance ();
		require_once ("class/Db.php");
		$factory=DbAbstractionFactory::getFactory($cfg->getValue('AstrazioneDB'));
		$factory->setDsn($cfg->getValue('DSN'));
		$db=$factory->createInstance();
		//********************************************************

		$result = "";

		//ESEGUO UPDATE 
		$sql =
			"UPDATE files SET
			id_files=".$this->getId_file().",
			id_albo=".$this->getId_albo().",  
           	tipo=".$this->getTipo().",
           	from_blob=".$this->getFromBlob().",
           	file='".$this->getFile()."'
           	WHERE 
            id_files=".$this->getId_file().";";

		$rs = $db->query($sql);
		if( DB::isError($rs) ) {
			echo "<p><strong>Attenzione!</strong>Si e' verificato un errore durante
				l'esecuzione della query \"$sql\".";
			$result = FALSE;
			throw new Exception('Errore nel inserimento di un nuovo albo pretorio nel DB');
			//die($rs->getMessage());
		}
		else {
			$result = TRUE;
		}
		return $result;
	}





	public function caricaDalDB($id_file) {

		/*
		 * Config e chiamo DB *******************************
		 */
		require_once ('class/ConfigSingleton.php');
		$cfg = SingletonConfiguration::getInstance ();
		require_once ("class/Db.php");
		$factory=DbAbstractionFactory::getFactory($cfg->getValue('AstrazioneDB'));
		$factory->setDsn($cfg->getValue('DSN'));
		$db=$factory->createInstance();
		//********************************************************

		$result = "";

		//ESEGUO SELECT
		$sql =
			"SELECT
		files.id_files,
		files.id_albo,
		files.tipo,
		files.from_blob,
		files.file
		FROM
		files
		WHERE
		files.id_files = ".$id_file.";";

		$rs = $db->query($sql);
		if (DB::isError($rs)) {
			echo "<p><strong>Attenzione!</strong>Si e' verificato un errore durante
			l'esecuzione della query <br> \"$sql\".";
			throw new Exception('Errore nella select per la visualizzazione degli albi pretori nel DB');
			die($rs->getMessage());
		}

		while ($row = $rs->fetchRow(DB_FETCHMODE_ASSOC)) {
			if (DB::isError($row)) {
				echo "<p><strong>Attenzione!</strong>Si e' verificato un errore durante
				l'esecuzione della query \"$sql\".";
				$result = FALSE;
				throw new Exception('Errore nella select per la visualizzazione degli albi pretori nel DB');
				die($rs->getMessage());
				//die($rs->getMessage());
			}
			else {
				$result = TRUE;
				// Carico l'oggetto
				$this->setId_file($row['id_files']);
				$this->setId_albo($row['id_albo']);
				$this->setTipo($row['tipo']);
				$this->setFromBlob($row['from_blob']);
				$this->setFile($row['file']);
			}
		}
		return $result;

	}




	public function __tostring() {
		$s = "";
		$s .= "
<table border=1>
        \n";
		$s .= "
        <tr>
                <td colspan=2>
                <hr>
                </td>
        </tr>
        \n";
		foreach (get_class_vars(get_class($this)) as $name => $value) {
			$s .= " \n";

			if ($this->$name != "") {
				$s .= "
                <tr>
                        <td>$name:</td>
                    <td>";
				if (is_array($this->$name)) {
					foreach ($this->$name as $key1=>$value1) {
						if (is_object($value1)) {
							$s .= $value1->__tostring();
						}
						else
							$s .= $value1;
					}
				}
				else
					$s .= $this->$name;
				$s .= "</td>
                </tr>
                \n";
			}
		}
		$s .= "
        <tr>
                <td colspan=2>
                <hr>
                </td>
        </tr>
        \n";
		$s .= "
</table>
\n";

		return $s;
	}











}
	