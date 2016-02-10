<?php

class Amm_aperta {
	
	protected $id_amm_aperta;
	protected $id_albo;
	protected $ragionesociale;
	protected $piva;
	protected $resp_proc;
	protected $norma;
	protected $modalita;
	protected $importo;
	protected $pubblicato;
	protected $dt_pubblicazione;
	
	
		

	
	
	
	
	/**
	 * @return the $id_amm_aperta
	 */
	public function getId_amm_aperta() {
		return $this->id_amm_aperta;
	}

	/**
	 * @return the $id_albo
	 */
	public function getId_albo() {
		return $this->id_albo;
	}

	/**
	 * @return the $ragionesociale
	 */
	public function getRagionesociale() {
		return $this->ragionesociale;
	}

	/**
	 * @return the $piva
	 */
	public function getPiva() {
		return $this->piva;
	}

	/**
	 * @return the $resp_proc
	 */
	public function getResp_proc() {
		return $this->resp_proc;
	}

	/**
	 * @return the $norma
	 */
	public function getNorma() {
		return $this->norma;
	}

	/**
	 * @return the $modalita
	 */
	public function getModalita() {
		return $this->modalita;
	}

	/**
	 * @return the $importo
	 */
	public function getImporto() {
		return $this->importo;
	}

	/**
	 * @return the $pubblicato
	 */
	public function getPubblicato() {
		return $this->pubblicato;
	}

	/**
	 * @param field_type $id_amm_aperta
	 */
	public function setId_amm_aperta($id_amm_aperta) {
		$this->id_amm_aperta = $id_amm_aperta;
	}

	/**
	 * @param field_type $id_albo
	 */
	public function setId_albo($id_albo) {
		$this->id_albo = $id_albo;
	}

	/**
	 * @param field_type $ragionesociale
	 */
	public function setRagionesociale($ragionesociale) {
		$this->ragionesociale = $ragionesociale;
	}

	/**
	 * @param field_type $piva
	 */
	public function setPiva($piva) {
		$this->piva = $piva;
	}

	/**
	 * @param field_type $resp_proc
	 */
	public function setResp_proc($resp_proc) {
		$this->resp_proc = $resp_proc;
	}

	/**
	 * @param field_type $norma
	 */
	public function setNorma($norma) {
		$this->norma = $norma;
	}

	/**
	 * @param field_type $modalita
	 */
	public function setModalita($modalita) {
		$this->modalita = $modalita;
	}

	/**
	 * @param field_type $importo
	 */
	public function setImporto($importo) {
		$this->importo = $importo;
	}

	/**
	 * @param field_type $pubblicato
	 */
	public function setPubblicato($pubblicato) {
		$this->pubblicato = $pubblicato;
	}

		
	/**
	 * @return the $dt_pubblicazione
	 */
	public function getDt_pubblicazione() {
		return $this->dt_pubblicazione;
	}

	/**
	 * @param field_type $dt_pubblicazione
	 */
	public function setDt_pubblicazione($dt_pubblicazione) {
		$this->dt_pubblicazione = $dt_pubblicazione;
	}

	/****************************************************************************
	 * 
	 */

	
	/**
	 * 
	 */
	function __construct() {
		
	}

	/**
	 * @return unknown
	 */
	public function getDt_formato_standard($data_dal_db) {
		// da 2009-12-30 a 30/12/2009
		return (substr($data_dal_db,8,2)."/".substr($data_dal_db,5,2)."/".substr($data_dal_db,0,4));
	}
	
	//Inutile è lo stesso formato del DB
	public function getDt_formato_js($data) {
		if ($data <> "")
			return (substr($data,0,4)."-".substr($data,5,2)."-".substr($data,6,2));
		else
			return ""; 
	}
	
	public function getIdTipo_from_IdAlbo_DalDB($id_albo) {
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
		
		$sql = "SELECT id_tipo from albi WHERE id_albo = ".$id_albo.";";
		$rs = $db->query($sql);
		$row = $rs->fetchRow(DB_FETCHMODE_ORDERED);
		return $row[0]; 
	}

	
	public function getFilename_from_IdAlbo_DalDB($id_albo) {
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
		
		$sql = "SELECT file from albi WHERE id_albo = ".$id_albo.";";
		$rs = $db->query($sql);
		$row = $rs->fetchRow(DB_FETCHMODE_ORDERED);
		return $row[0]; 
	}
	
	
	public function getIdArea_from_IdAlbo_DalDB($id_albo) {
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
		
		$sql = "SELECT id_area from albi WHERE id_albo = ".$id_albo.";";
		$rs = $db->query($sql);
		$row = $rs->fetchRow(DB_FETCHMODE_ORDERED);
		return $row[0]; 
	}
	

	public function trova_id_albo_vuoto_pre_2010 () {
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
		
		$sql = "SELECT id_albo from amm_aperta WHERE id_albo < 201000000 ORDER BY id_albo DESC LIMIT 1;";
		$rs = $db->query($sql);
		error_log($sql);
		$row = $rs->fetchRow(DB_FETCHMODE_ORDERED);
		
		if ($row[0] == "") {
			return "0";
		}
		else {
			return ($row[0]+1);
		}
		
		
	}
	
	public function verificaNelDB($id_albo) {
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
	
		$sql = "SELECT id_amm_aperta from amm_aperta WHERE id_albo = ".$id_albo.";";
		$rs = $db->query($sql);
		error_log($sql);
		$row = $rs->fetchRow(DB_FETCHMODE_ORDERED);
		
		if ($row[0] == "") {
			return false;
		}
		else { 
			return $row[0];
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
		$sql = 
			"INSERT INTO amm_aperta SET
			id_amm_aperta='".$this->getId_amm_aperta()."',
			id_albo='".$this->getId_albo()."', 
           	ragionesociale='".$this->getRagionesociale()."', 
           	piva='".$this->getPiva()."',
           	resp_proc='".$this->getResp_proc()."',
           	norma='".$this->getNorma()."', 
           	modalita='".$this->getModalita()."', 
           	importo='".$this->getImporto()."',
           	dt_pubblicazione='".$this->getDt_pubblicazione()."',
           	pubblicato='".$this->getPubblicato()."';";

		
		//echo $sql;
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
		
		
		$sql = "SELECT LAST_INSERT_ID() FROM amm_aperta";
		$rs = $db->query($sql);
		$row = $rs->fetchRow(DB_FETCHMODE_ORDERED);
		$this->setId_amm_aperta($row[0]);
				
		
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
			"UPDATE amm_aperta SET
			id_amm_aperta='".$this->getId_amm_aperta()."',
			id_albo='".$this->getId_albo()."', 
           	ragionesociale='".$this->getRagionesociale()."', 
           	piva='".$this->getPiva()."',
           	resp_proc='".$this->getResp_proc()."',
           	norma='".$this->getNorma()."', 
           	modalita='".$this->getModalita()."', 
           	importo='".$this->getImporto()."',
           	dt_pubblicazione='".$this->getDt_pubblicazione()."',
           	pubblicato='".$this->getPubblicato()."'
           	WHERE 
            id_amm_aperta=".$this->getId_amm_aperta().";";
		
		//echo $sql;
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
	
	
	
	public function caricaDalDB($id_amm_aperta) { 
		
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
		albi.id_albo,
		albi.id_tipo,
		albi.dt_pubblicaz_dal,
		albi.dt_pubblicaz_al,
		albi.dt_atto,
		albi.nr_atto,
		albi.oggetto,
		albi.autorita_emanante,
		albi.id_area,
		albi.serialize,
		albi.da_validare,
		aree.responsabile,
		aree.area,
		tipi.tipo,
		amm_aperta.ragionesociale,
		amm_aperta.piva,
		amm_aperta.resp_proc,
		amm_aperta.norma,
		amm_aperta.modalita,
		amm_aperta.importo,
		amm_aperta.dt_pubblicazione,
		amm_aperta.pubblicato
		FROM
		albi
		Inner Join aree ON albi.id_area = aree.id_area
		Inner Join tipi ON albi.id_tipo = tipi.id_tipo
		RIGHT JOIN amm_aperta ON albi.id_albo = amm_aperta.id_albo
		WHERE
		amm_aperta.id_amm_aperta = ".$id_amm_aperta.";";
	
		
		
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
			$this->setId_albo($row['id_albo']);
			$this->setRagionesociale($row['ragionesociale']);
			$this->setPiva($row['piva']);
			$this->setResp_proc($row['resp_proc']);
			$this->setNorma($row['norma']);
			$this->setModalita($row['modalita']);
			$this->setImporto($row['importo']);
			$this->setDt_pubblicazione($row['dt_pubblicazione']);
			$this->setPubblicato($row['pubblicato']);
		}
	}
	return $result; 

	}
	

	
	
	public function caricaDalDB2($id_albo) { 
		
		
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
		albi.id_albo,
		albi.id_tipo,
		albi.dt_pubblicaz_dal,
		albi.dt_pubblicaz_al,
		albi.dt_atto,
		albi.nr_atto,
		albi.oggetto,
		albi.autorita_emanante,
		albi.id_area,
		albi.serialize,
		albi.da_validare,
		aree.responsabile,
		aree.area,
		tipi.tipo,
		amm_aperta.ragionesociale,
		amm_aperta.piva,
		amm_aperta.resp_proc,
		amm_aperta.norma,
		amm_aperta.modalita,
		amm_aperta.importo,
		amm_aperta.dt_pubblicazione,
		amm_aperta.pubblicato
		FROM
		albi
		Inner Join aree ON albi.id_area = aree.id_area
		Inner Join tipi ON albi.id_tipo = tipi.id_tipo
		RIGHT JOIN amm_aperta ON albi.id_albo = amm_aperta.id_albo
		WHERE
		amm_aperta.id_albo = ".$id_albo.";";
	
		
		
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
			$this->setId_albo($row['id_albo']);
			$this->setRagionesociale($row['ragionesociale']);
			$this->setPiva($row['piva']);
			$this->setResp_proc($row['resp_proc']);
			$this->setNorma($row['norma']);
			$this->setModalita($row['modalita']);
			$this->setImporto($row['importo']);
			$this->setDt_pubblicazione($row['dt_pubblicazione']);
			$this->setPubblicato($row['pubblicato']);
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

	

?>
