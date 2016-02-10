<?php

class Albo {
	
	protected $id_albo;
	protected $tipo; // Campo tipo collegato a altra tabella
	protected $tipo_determina; // definito se si tratta di una determina
	protected $tipo_trasp; // definito da oggi in poi x la trasparenza
	protected $dt_pubblicaz_dal;
	protected $dt_pubblicaz_al;
	protected $dt_atto;
	protected $nr_atto;
	protected $oggetto;
	protected $autorita_emanante;
	protected $spesa_prevista;
	protected $area; //Campi area/resp collegati ad altra tabella
	protected $ARRAY_files; //array di oggetti di tipo file
	protected $da_validare;
	protected $note;
	
	
		
	
	
	/**
	 * @return the $note
	 */
	public function getNote() {
		return $this->note;
	}

	/**
	 * @param field_type $note
	 */
	public function setNote($note) {
		$this->note = $note;
	}

	/**
	 * @return the $tipo_determina
	 */
	public function getTipo_determina() {
		return $this->tipo_determina;
	}

	/**
	 * @return the $tipo_trasp
	 */
	public function getTipo_trasp() {
		return $this->tipo_trasp;
	}

	/**
	 * @return the $spesa_prevista
	 */
	public function getSpesa_prevista() {
		return $this->spesa_prevista;
	}

	/**
	 * @param field_type $tipo_determina
	 */
	public function setTipo_determina($tipo_determina) {
		$this->tipo_determina = $tipo_determina;
	}

	/**
	 * @param field_type $tipo_trasp
	 */
	public function setTipo_trasp($tipo_trasp) {
		$this->tipo_trasp = $tipo_trasp;
	}

	/**
	 * @param field_type $spesa_prevista
	 */
	public function setSpesa_prevista($spesa_prevista) {
		$this->spesa_prevista = $spesa_prevista;
	}

	/**
	 * @param $file the $file to set
	 */
	public function setARRAY_files($file) {
		$this->ARRAY_files = $file;
	}
	/**
	 * @return the $ARRAY_files
	 */
	public function getARRAY_files() {
		return $this->ARRAY_files;
	}

	/**
	 * @param $da_validare the $da_validare to set
	 */
	public function setDa_validare($da_validare) {
		$this->da_validare = $da_validare;
	}

	/**
	 * @return the $da_validare
	 */
	public function getDa_validare() {
		return $this->da_validare;
	}


	/**
	 * @param $area the $area to set
	 */
	public function setArea($area) {
		$this->area = $area;
	}

	/**
	 * @param $autorita_emanante the $autorita_emanante to set
	 */
	public function setAutorita_emanante($autorita_emanante) {
		$this->autorita_emanante = $autorita_emanante;
	}

	/**
	 * @param $oggetto the $oggetto to set
	 */
	public function setOggetto($oggetto) {
		$this->oggetto = $oggetto;
	}

	/**
	 * @param $nr_atto the $nr_atto to set
	 */
	public function setNr_atto($nr_atto) {
		$this->nr_atto = $nr_atto;
	}

	/**
	 * @param $dt_atto the $dt_atto to set
	 */
	public function setDt_atto($dt_atto) {
		$this->dt_atto = $dt_atto;
	}

	/**
	 * @param $dt_pubblicaz_al the $dt_pubblicaz_al to set
	 */
	public function setDt_pubblicaz_al($dt_pubblicaz_al) {
		$this->dt_pubblicaz_al = $dt_pubblicaz_al;
	}

	/**
	 * @param $dt_pubblicaz_dal the $dt_pubblicaz_dal to set
	 */
	public function setDt_pubblicaz_dal($dt_pubblicaz_dal) {
		$this->dt_pubblicaz_dal = $dt_pubblicaz_dal;
	}

	/**
	 * @param $tipo the $tipo to set
	 */
	public function setTipo($tipo) {
		$this->tipo = $tipo;
	}

	/**
	 * @param $id_albo the $id_albo to set
	 */
	public function setId_albo($id_albo) {
		$this->id_albo = $id_albo;
	}

	/**
	 * @return the $file
	 */
	public function get_ARRAY_files() {
		return $this->ARRAY_files;
	}

	/**
	 * @return the $area
	 */
	public function getArea() {
		return $this->area;
	}

	/**
	 * @return the $autorita_emanante
	 */
	public function getAutorita_emanante() {
		return $this->autorita_emanante;
	}

	/**
	 * @return the $oggetto
	 */
	public function getOggetto() {
		return $this->oggetto;
	}

	/**
	 * @return the $nr_atto
	 */
	public function getNr_atto() {
		return $this->nr_atto;
	}

	/**
	 * @return the $dt_atto
	 */
	public function getDt_atto() {
		return $this->dt_atto;
	}

	/**
	 * @return the $dt_pubblicaz_al
	 */
	public function getDt_pubblicaz_al() {
		return $this->dt_pubblicaz_al;
	}

	/**
	 * @return the $dt_pubblicaz_dal
	 */
	public function getDt_pubblicaz_dal() {
		return $this->dt_pubblicaz_dal;
	}

	/**
	 * @return the $tipo
	 */
	public function getTipo() {
		return $this->tipo;
	}

	/**
	 * @return the $id_albo
	 */
	public function getId_albo() {
		return $this->id_albo;
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
	
	//Inutile � lo stesso formato del DB
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

	public function getIdTipo_determina_from_IdAlbo_DalDB($id_albo) {
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
	
		$sql = "SELECT id_tipo_determina from albi WHERE id_albo = ".$id_albo.";";
		$rs = $db->query($sql);
		$row = $rs->fetchRow(DB_FETCHMODE_ORDERED);
		return $row[0];
	}
	
	public function getIdTipo_trasp_from_IdAlbo_DalDB($id_albo) {
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
	
		$sql = "SELECT id_tipo_trasp from albi WHERE id_albo = ".$id_albo.";";
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
				$result = FALSE;
				throw new Exception('Errore nel inserimento di un nuovo albo pretorio nel DB');
				//die($rs->getMessage());
			}
		}

		/*
		 * ----------------- FINE Sezione aggiornamento nuovo anno ----------------------
		 */

		$result = ""; 
		
		//ESEGUO INSERIMENTO -- INSERT 
		$sql = 
			"INSERT INTO albi SET
			id_albo='".$this->getId_albo()."', 
           	id_tipo='".$this->getTipo()->getId_tipo()."',
           	id_tipo_determina='".$this->getTipo_determina()->getId_tipo_determina()."',
           	id_tipo_trasp='".$this->getTipo_trasp()->getId_tipo_trasp()."',
           	dt_pubblicaz_dal='".$this->getDt_pubblicaz_dal()."',
           	dt_pubblicaz_al='".$this->getDt_pubblicaz_al()."',
           	dt_atto='".$this->getDt_atto()."', 
           	nr_atto='".$this->getNr_atto()."', 
           	oggetto='".$this->getOggetto()."',
           	spesa_prevista='".$this->getSpesa_prevista()."',
           	autorita_emanante='".$this->getAutorita_emanante()."',
           	da_validare='".$this->getDa_validare()."',
           	id_area='".$this->getArea()->getId_area()."';";
//           	,file='".$this->get_ARRAY_files()."';";
		
		error_log($sql);
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
		
		
		$sql = "SELECT LAST_INSERT_ID() FROM albi";
		$rs = $db->query($sql);
		$row = $rs->fetchRow(DB_FETCHMODE_ORDERED);
		$this->setId_albo($row[0]);
		
		$objFiles = new File();
		if (is_array($this->get_ARRAY_files())) {
			foreach ($this->getARRAY_files() as $objFiles) {
				$objFiles->setId_albo($this->getId_albo());
				$res = $objFiles->creaNelDB();
				$result = $result AND $res;
			}
		}
		
		
		
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
		
		//Metto prima la creazione dei file in modo che quando arrivo al serialize
		//l'oggetto file contiene il corretto id del db.
		//$objFiles = new File();
		foreach ($this->getARRAY_files() as $objFiles) {
			$objFiles->setId_albo($this->getId_albo());
			$res = $objFiles->CreaNelDB();
			$result = ($result && $res);
		}
	
		
		//ESEGUO UPDATE 
		$sql = 
			"UPDATE albi SET
			id_albo='".$this->getId_albo()."',
           	id_tipo='".$this->getTipo()->getId_tipo()."',
           	id_tipo_determina='".$this->getTipo_determina()->getId_tipo_determina()."',
           	id_tipo_trasp='".$this->getTipo_trasp()->getId_tipo_trasp()."',
           	spesa_prevista='".$this->getSpesa_prevista()."',
           	dt_pubblicaz_dal='".$this->getDt_pubblicaz_dal()."',
           	dt_pubblicaz_al='".$this->getDt_pubblicaz_al()."',
           	dt_atto='".$this->getDt_atto()."', 
           	nr_atto='".$this->getNr_atto()."',
           	oggetto='".mysql_real_escape_string($this->getOggetto())."',
           	autorita_emanante='".mysql_real_escape_string($this->getAutorita_emanante())."',
           	id_area='".$this->getArea()->getId_area()."',
           	serialize='".mysql_real_escape_string(serialize($this))."',
           	note='".$this->getNote()."',
           	da_validare='".$this->getDa_validare()."'
           	WHERE 
            id_albo=".$this->getId_albo().";";

		//error_log("############### AGGIORNA ALBO ######## \n");
		//error_log($sql);
		//error_log("############### / AGGIORNA ALBO ######## \n");

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

	public function aggiornaSoloAlboNelDB() {

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

		//Metto prima la creazione dei file in modo che quando arrivo al serialize
		//l'oggetto file contiene il corretto id del db.
		//$objFiles = new File();

		//ESEGUO UPDATE
		$sql =
			"UPDATE albi SET
			id_albo=".$this->getId_albo().",
           	spesa_prevista=".$this->getSpesa_prevista().",
           	dt_pubblicaz_dal='".$this->getDt_pubblicaz_dal()."',
           	dt_pubblicaz_al='".$this->getDt_pubblicaz_al()."',
           	dt_atto='".$this->getDt_atto()."',
           	nr_atto=".$this->getNr_atto().",
           	oggetto='".mysql_real_escape_string($this->getOggetto())."',
           	autorita_emanante='".mysql_real_escape_string($this->getAutorita_emanante())."',
           	note='".$this->getNote()."',
           	da_validare='".$this->getDa_validare()."'
           	WHERE
            id_albo=".$this->getId_albo().";";

		error_log($sql);

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



	public function aggiornaSoloTipoDeterminaNelDB($id_tipo_determina) {

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

		//Metto prima la creazione dei file in modo che quando arrivo al serialize
		//l'oggetto file contiene il corretto id del db.
		//$objFiles = new File();

		//ESEGUO UPDATE
		$sql =
			"UPDATE albi SET
			id_tipo_determina=".$id_tipo_determina."
           	WHERE
            id_albo=".$this->getId_albo().";";

		//error_log($sql);

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





	public function CancellaTuttiFileDalDB() {
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
		//ESEGUO DELETE  
		$sql = 
			"DELETE from files 
			WHERE
			id_albo='".$this->getId_albo()."'";
		$rs = $db->query($sql); 
		if( DB::isError($rs) ) { 
			echo "<p><strong>Attenzione!</strong>Si e' verificato un errore durante
				l'esecuzione della query \"$sql\"."; 
			$result = FALSE;
			throw new Exception('Errore nel cancellamento di file nel DB'); 
			//die($rs->getMessage());
		} 
		else {
			$result = TRUE; 
		}
		return $result;	
	}
	

	public function serializzaNelDB() { 

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
		//serialize='".mysql_real_escape_string(serialize($this))."'
		$tmp = serialize($this);
		$tmp2 = addslashes($tmp);
		//error_log($tmp2);
		$sql = 
			"UPDATE albi SET
           	serialize='".mysql_real_escape_string(serialize($this))."'
           	WHERE 
            id_albo=".$this->getId_albo().";";
		//serialize='".mysql_escape_string(serialize($this))."',
		//serialize='".serialize($this)."'
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

public function setARRAYFilesDalDB($id_albo) {
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
	$sql = "SELECT * FROM files WHERE id_albo = ".$id_albo.";";

	$rs = $db->query($sql);
	if (DB::isError($rs)) {
		echo "<p><strong>Attenzione!</strong>Si e' verificato un errore durante
				l'esecuzione della query <br> \"$sql\".";
		throw new Exception('Errore nella select per la visualizzazione degli albi pretori nel DB');
		die($rs->getMessage());
	}

	$ARRAY_files = array();
	$i = 0;

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
			$ARRAY_files[$i] = new File($row['file']);
			$ARRAY_files[$i]->setId_file($row['id_files']);
			$ARRAY_files[$i]->setId_albo($id_albo);
			$i++;
		}
	}
	$this->setARRAY_files($ARRAY_files);
}
	
	
	public function caricaDalDB($id_albo) { 
		
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
		albi.id_tipo_determina,
		albi.id_tipo_trasp,
		albi.spesa_prevista,
		albi.dt_pubblicaz_dal,
		albi.dt_pubblicaz_al,
		albi.dt_atto,
		albi.nr_atto,
		albi.oggetto,
		albi.autorita_emanante,
		albi.id_area,
		albi.serialize,
		albi.note,
		albi.da_validare,
		aree.responsabile,
		aree.area,
		tipi.tipo,
		tipi_determina.tipo_determina,
		tipi_trasp.tipo_trasp
		FROM
		albi
		Inner Join aree ON albi.id_area = aree.id_area
		Inner Join tipi ON albi.id_tipo = tipi.id_tipo
		LEFT JOIN tipi_determina ON albi.id_tipo_determina = tipi_determina.id_tipo_determina
		LEFT JOIN tipi_trasp ON albi.id_tipo_trasp = tipi_trasp.id_tipo_trasp
		WHERE
		albi.id_albo = ".$id_albo.";";
	
		
		
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
			$this->setId_albo($id_albo);
			$this->setNr_atto($row['nr_atto']);
			$this->setDt_atto($row['dt_atto']);
			$this->setOggetto($row['oggetto']);
			$this->setAutorita_emanante($row['autorita_emanante']);
			$this->setDt_pubblicaz_dal($row['dt_pubblicaz_dal']);
			$this->setDt_pubblicaz_al($row['dt_pubblicaz_al']);
			$this->setARRAY_files($row['file']);
			$this->setDa_validare($row['da_validare']);
			$this->setNote($row['note']);
		}
	}
	return $result; 

	}


	public function caricaTuttoDalDB($id_albo) {

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
			albi.id_tipo_determina,
			albi.id_tipo_trasp,
			albi.spesa_prevista,
			albi.dt_pubblicaz_dal,
			albi.dt_pubblicaz_al,
			albi.dt_atto,
			albi.nr_atto,
			albi.oggetto,
			albi.autorita_emanante,
			albi.id_area,
			albi.serialize,
			albi.note,
			albi.da_validare,
			aree.responsabile,
			aree.area,
			tipi.tipo,
			tipi_determina.tipo_determina,
			tipi_trasp.tipo_trasp
			FROM
			albi
			Inner Join aree ON albi.id_area = aree.id_area
			Inner Join tipi ON albi.id_tipo = tipi.id_tipo
			LEFT JOIN tipi_determina ON albi.id_tipo_determina = tipi_determina.id_tipo_determina
			LEFT JOIN tipi_trasp ON albi.id_tipo_trasp = tipi_trasp.id_tipo_trasp
			WHERE
			albi.id_albo = ".$id_albo.";";



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
				$this->setId_albo($id_albo);
				$this->setNr_atto($row['nr_atto']);
				$this->setDt_atto($row['dt_atto']);
				$this->setOggetto($row['oggetto']);
				$this->setAutorita_emanante($row['autorita_emanante']);
				$this->setSpesa_prevista($row['spesa_prevista']);
				$this->setDt_pubblicaz_dal($row['dt_pubblicaz_dal']);
				$this->setDt_pubblicaz_al($row['dt_pubblicaz_al']);
				$this->setARRAY_files($row['file']);
				$this->setDa_validare($row['da_validare']);
				$this->setNote($row['note']);

				$tipo = new Tipo();
				$tipo->setId_tipo($row['id_tipo']);
				$tipo->setTipoFromIdTipo($row['id_tipo']);
				$this->setTipo($tipo);

				$tipo_determina = new Tipo_determina();
				$tipo_determina->setId_tipo_determina(NULL);
				$tipo_determina->setTipo_determina(NULL);
				$this->setTipo_determina($tipo_determina);

				$tipo_trasp = new Tipo_Trasp();
				$tipo_trasp->setId_tipo_trasp($row['id_tipo_trasp']);
				$tipo_trasp->setTipoTraspFromIdTipoTrasp($row['id_tipo_trasp']);
				$this->setTipo_trasp($tipo_trasp);

				$area = new Area();
				$area->setId_area($row['id_area']);
				$area->setAreaFromIdArea($row['id_area']);
				$area->setRespFromIdArea($row['id_area']);
				$this->setArea($area);

				$this->setARRAYFilesDalDB($this->getId_albo());


			}
		}
		return $result;

	}



	public function caricaDalDB_rpc($id_albo) {

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
			albi.id_tipo_determina,
			albi.id_tipo_trasp,
			albi.spesa_prevista,
			albi.dt_pubblicaz_dal,
			albi.dt_pubblicaz_al,
			albi.dt_atto,
			albi.nr_atto,
			albi.oggetto,
			albi.autorita_emanante,
			albi.id_area,
			albi.serialize,
			albi.note,
			albi.da_validare,
			aree.responsabile,
			aree.area,
			tipi.tipo,
			tipi_determina.tipo_determina,
			tipi_trasp.tipo_trasp
			FROM
			albi
			Inner Join aree ON albi.id_area = aree.id_area
			Inner Join tipi ON albi.id_tipo = tipi.id_tipo
			LEFT JOIN tipi_determina ON albi.id_tipo_determina = tipi_determina.id_tipo_determina
			LEFT JOIN tipi_trasp ON albi.id_tipo_trasp = tipi_trasp.id_tipo_trasp
			WHERE
			albi.id_albo = ".$id_albo.";";



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
				$this->setNr_atto($row['nr_atto']);
				$this->setDt_atto($row['dt_atto']);
				$this->setOggetto($row['oggetto']);
				$this->setAutorita_emanante($row['autorita_emanante']);
				$this->setDt_pubblicaz_dal($row['dt_pubblicaz_dal']);
				$this->setDt_pubblicaz_al($row['dt_pubblicaz_al']);
				$this->setARRAY_files($row['file']);
				$this->setDa_validare($row['da_validare']);
				$this->setNote($row['note']);
			}
		}
		$aa = serialize($this);

		return $aa;

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
		albi.serialize
		FROM
		albi
		WHERE
		albi.id_albo = ".$id_albo.";";
	
	$rs = $db->query($sql); 
	if (DB::isError($rs)) {
    	echo "<p><strong>Attenzione!</strong>Si e' verificato un errore durante
			l'esecuzione della query <br> \"$sql\"."; 
		throw new Exception('Errore nella select per la visualizzazione degli albi pretori nel DB'.$sql);
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
			//$result = TRUE;
			// Carico l'oggetto
			$result = unserialize($row['serialize']);
			if (! is_object($result)) {
				$result = FALSE;
			}
		}
	}
	return $result; 

	}






	public function caricaMinimalDalDB($id_albo) {

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
		albi.id_tipo_determina,
		albi.id_tipo_trasp,
		albi.spesa_prevista,
		albi.dt_pubblicaz_dal,
		albi.dt_pubblicaz_al,
		albi.dt_atto,
		albi.nr_atto,
		albi.oggetto,
		albi.autorita_emanante,
		albi.id_area,
		albi.serialize,
		albi.note,
		albi.da_validare
		FROM
		albi
		WHERE
		albi.id_albo = ".$id_albo.";";



		$rs = $db->query($sql);
		if (DB::isError($rs)) {
			echo "<p><strong>Attenzione!</strong>Si e' verificato un errore durante
			l'esecuzione della query <br> \"$sql\".";
			throw new Exception('Errore nella select per la visualizzazione degli albi pretori nel DB');
			die($rs->getMessage());
		}

		$result = false;

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
				$this->setId_albo($id_albo);
				$this->setNr_atto($row['nr_atto']);
				$this->setDt_atto($row['dt_atto']);
				$this->setOggetto($row['oggetto']);
			}
		}
		return $result;

	}


	public function getIdFromDtNr() {

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
			albi.id_albo, albi.nr_atto
			FROM
			albi
			WHERE
			albi.id_tipo = 3
			AND albi.dt_atto = '".$this->getDt_atto()."'
			AND albi.nr_atto = ".$this->getNr_atto().";";

		$rs = $db->query($sql);
		$risultato = $rs->numRows();

		error_log(" #nr. ".$this->getNr_atto()." #dt ".$this->getDt_atto()." #- NR RISULTATI GET ID = ".$risultato."\n");

		if ($risultato == 0) {
			$result = FALSE;
		}
		else {

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
					$result = $row['id_albo'];
				}
			}
		}
		error_log(" ##### ----- ID = ".$result."\n");
		return $result;

	}

	public function getIdFromYrNr() {

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
			albi.id_albo, albi.nr_atto
			FROM
			albi
			WHERE
			albi.id_tipo = 3
			AND YEAR(albi.dt_atto) = YEAR('".$this->getDt_atto()."')
			AND albi.nr_atto = ".$this->getNr_atto().";";

		$rs = $db->query($sql);
		$risultato = $rs->numRows();



		if ($risultato == 0) {
			//error_log($sql);
			//error_log(" #nr. ".$this->getNr_atto()." #dt ".$this->getDt_atto()." #- NR RISULTATI GET ID = ".$risultato."\n");
			$result = FALSE;
		}
		elseif ($risultato > 1) {
			//error_log($sql);
			error_log("TROPPI - #nr. ".$this->getNr_atto()." #dt ".$this->getDt_atto()." #- NR RISULTATI GET ID = ".$risultato."\n");
			$result = FALSE;
		}
		else {

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
					$result = $row['id_albo'];
				}
			}
		}
		//error_log(" ##### ----- ID = ".$result."\n");
		return $result;

	}


	public function getErrorIdFromDtNr() {

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
			albi.id_albo, albi.nr_atto
			FROM
			albi
			WHERE
			albi.id_tipo = 3
			AND YEAR(albi.dt_atto) = '".substr($this->getDt_atto(),0,4)."'
			AND albi.dt_atto <> '".$this->getDt_atto()."'
			AND albi.nr_atto = ".$this->getNr_atto().";";

		$rs = $db->query($sql);
		$risultato = $rs->numRows();

		//error_log("RISULTATO = ".$risultato."\n");

		if ($risultato == 0) {
			$result = FALSE;
		}
		else {

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
							$result = $row['id_albo'];
						}
					}
				}
		return $result;

	}


	public function verificaEsistenzaErrataPerAlbo() {

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
			albi.id_albo, albi.nr_atto
			FROM
			albi
			WHERE
			albi.id_tipo = 3
			AND YEAR(albi.dt_atto) = '".substr($this->getDt_atto(),0,4)."'
			AND albi.dt_atto <> '".$this->getDt_atto()."'
		AND
		albi.nr_atto = ".$this->getNr_atto().";";

		$rs = $db->query($sql);
		$risultato = $rs->numRows();

		//error_log("RISULTATO = ".$risultato."\n");

		if ($risultato == 0) {
			$result = FALSE;
		}
		else {
			$result = TRUE;
		}

		return $result;

	}

	
	public function verificaEsistenzaPerAlbo() {
	
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
		albi.id_albo, albi.nr_atto
		FROM
		albi
		WHERE
		albi.id_tipo = 3 
		AND
		albi.dt_atto = '".$this->getDt_atto()."'
		AND
		albi.nr_atto = ".$this->getNr_atto().";";
	
		$rs = $db->query($sql);
		$risultato = $rs->numRows();
		
		//error_log("RISULTATO = ".$risultato."\n");

		if ($risultato == 0) {
			$result = TRUE;
		}
		else {
			$result = FALSE;
		}
		
		return $result;
	
		}
	
	
	public function verificaEsistenzaMultiplaPerAlbo() {
		/*
		 * Questa funzione controlla se per errore e' stato registrato piu' volte lo stesso albo
		 * Se registrato + volte restituisce TRUE
		*/
	
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
		albi.id_albo, albi.nr_atto
		FROM
		albi
		WHERE
		albi.id_tipo = 3 
		AND
		albi.dt_atto = '".$this->getDt_atto()."'
		AND
		albi.nr_atto = ".$this->getNr_atto().";";

//error_log($sql);
	
		$rs = $db->query($sql);
		$risultato = $rs->numRows();
		
		//error_log("RISULTATO = ".$risultato."\n");

		if ($risultato > 1) {
			$result = TRUE;
		}
		else {
			$result = FALSE;
		}
		
		return $result;
	
		}
	
	

	public function caricaDalDB_2010($id_albo) { 
		
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
		tipi.tipo
		FROM
		albi
		Inner Join tipi ON albi.id_tipo = tipi.id_tipo
		WHERE
		albi.id_albo = ".$id_albo.";";
	
		
		
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
			$this->setNr_atto($row['nr_atto']);
			$this->setDt_atto($row['dt_atto']);
			$this->setOggetto($row['oggetto']);
			$this->setAutorita_emanante($row['autorita_emanante']);
			$this->setDt_pubblicaz_dal($row['dt_pubblicaz_dal']);
			$this->setDt_pubblicaz_al($row['dt_pubblicaz_al']);
			$this->setARRAY_files($row['file']);
			$this->setDa_validare($row['da_validare']);
		}
	}
	return $result; 

	}
	
	
	
	
	
	    public function creaNelDB_TMP() { 
		
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
			"INSERT INTO albi_tmp SET
			id_albo='".$this->getId_albo()."', 
           	id_tipo='".$this->getTipo()->getId_tipo()."', 
           	id_tipo_determina='".$this->getTipo_determina()->getId_tipo_determina()."',
           	id_tipo_trasp='".$this->getTipo_trasp()->getId_tipo_trasp()."',
           	spesa_prevista='".$this->getSpesa_prevista()."',
           	dt_pubblicaz_dal='".$this->getDt_pubblicaz_dal()."',
           	dt_pubblicaz_al='".$this->getDt_pubblicaz_al()."',
           	dt_atto='".$this->getDt_atto()."', 
           	nr_atto='".$this->getNr_atto()."', 
           	oggetto='".$this->getOggetto()."',
           	autorita_emanante='".$this->getAutorita_emanante()."',
           	id_area='".$this->getArea()->getId_area()."',
           	file='".$this->get_ARRAY_files()."';";
		
		
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
		
		//setto il corretto id_anagrafica all'oggetto in base al risultato dell'insert
		$sql = "SELECT LAST_INSERT_ID() FROM albi";
		$rs = $db->query($sql);
		$row = $rs->fetchRow(DB_FETCHMODE_ORDERED);
		$this->setId_albo($row[0]);
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
