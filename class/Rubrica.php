<?php

class Rubrica
{

	protected $nome;
	protected $cognome;
	protected $id_utente;
	protected $id_servizio;
	protected $error;

	/**
	 * @return mixed
	 */
	public function getError()
	{
		return $this->error;
	}

	/**
	 * @param mixed $error
	 */
	public function setError($error)
	{
		$this->error = $error;
	}


	/**
	 * @return mixed
	 */
	public function getNome()
	{
		return $this->nome;
	}

	/**
	 * @param mixed $nome
	 */
	public function setNome($nome)
	{
		$this->nome = $nome;
	}

	/**
	 * @return mixed
	 */
	public function getCognome()
	{
		return $this->cognome;
	}

	/**
	 * @param mixed $cognome
	 */
	public function setCognome($cognome)
	{
		$this->cognome = $cognome;
	}

	/**
	 * @return mixed
	 */
	public function getIdUtente()
	{
		return $this->id_utente;
	}

	/**
	 * @param mixed $id_utente
	 */
	public function setIdUtente($id_utente)
	{
		$this->id_utente = $id_utente;
	}

	/**
	 * @return mixed
	 */
	public function getIdServizio()
	{
		return $this->id_servizio;
	}

	/**
	 * @param mixed $id_servizio
	 */
	public function setIdServizio($id_servizio)
	{
		$this->id_servizio = $id_servizio;
	}






	/****************************************************************************
	 *
	 */


	public function getNomeCognomefromID($id_utente)
	{
		/*
		 * Config e chiamo DB *******************************
		 */
		require_once("class/ConfigSingleton.php");
		$cfg = SingletonConfiguration::getInstance();
		require_once("class/Db.php");
		$factory = DbAbstractionFactory::getFactory($cfg->getValue('AstrazioneDB'));
		$factory->setDsn($cfg->getValue('DSN'));
		$db = $factory->createInstance();
		//**************
		$factory2 = DbAbstractionFactory::getFactory($cfg->getValue('AstrazioneDB2'));
		$factory2->setDsn($cfg->getValue('DSN2'));
		$db2 = $factory2->createInstance();
		//********************************************************

		$sql = "Select
		e1.nome as nom,
        e1.cognome as cogn,
        ind.indirizzo_telematicosmtp as email,
        e2.tel,
        e2.parent,
        e2.denominazione,
        e3.denominazione as de3,
        e3.id_entita as id_servizio,
        e4.denominazione as de4,
        e1.id_entita as id
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
		-- AND lower(e1.cognome) LIKE lower('" . $keyword . "%')
        --AND e3.id_entita LIKE '" . $_GET['servizio'] . "%'
        AND e1.id_entita = " . $id_utente . "
        --AND e3.id_entita = " . $_GET['id_servizio'] . "
		ORDER BY cogn,nom";

		$rs = $db2->query($sql);
		$row = $rs->fetchRow(MDB2_FETCHMODE_ASSOC);
		$this->setCognome($row['cogn']);
		$this->setNome($row['nom']);
		$this->setIdUtente($id_utente);
		$this->setIdServizio($row['id_servizio']);
		$this->setError(0);

	}

	public function getIDfromCognome($cognome) {
		/*
		 * Config e chiamo DB *******************************
		 */
		require_once ("class/ConfigSingleton.php");
		$cfg = SingletonConfiguration::getInstance ();
		require_once ("class/Db.php");
		$factory=DbAbstractionFactory::getFactory($cfg->getValue('AstrazioneDB'));
		$factory->setDsn($cfg->getValue('DSN'));
		$db=$factory->createInstance();
		//**************
		$factory2=DbAbstractionFactory::getFactory($cfg->getValue('AstrazioneDB2'));
		$factory2->setDsn($cfg->getValue('DSN2'));
		$db2=$factory2->createInstance();
		//********************************************************

		$sql = "Select
		e1.nome as nom,
        e1.cognome as cogn,
        ind.indirizzo_telematicosmtp as email,
        e2.tel,
        e2.parent,
        e2.denominazione,
        e3.denominazione as de3,
        e3.id_entita as id_servizio,
        e4.denominazione as de4,
        e1.id_entita as id
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
		AND lower(e1.cognome) LIKE lower('%".$cognome."%')
        --AND e3.id_entita LIKE '".$_GET['servizio']."%'
        -- AND e1.id_entita = ".$id_utente."
        --AND e3.id_entita = ".$_GET['id_servizio']."
		ORDER BY cogn,nom";

		$rs = $db2->query($sql);

		if ($rs->numRows() >=2) {
			$this->setError("Risultati multipli. Inserire il cognome completo.");
		}
		else {
			$row = $rs->fetchRow(MDB2_FETCHMODE_ASSOC);
			$this->setCognome($row['cogn']);
			$this->setNome($row['nom']);
			$this->setIdUtente($row['id']);
			$this->setIdServizio($row['id_servizio']);
			$this->setError(0);
		}


	}


	public function getIDfromCognomeNome($cognome, $nome) {
		/*
		 * Config e chiamo DB *******************************
		 */
		require_once ("class/ConfigSingleton.php");
		$cfg = SingletonConfiguration::getInstance ();
		require_once ("class/Db.php");
		$factory=DbAbstractionFactory::getFactory($cfg->getValue('AstrazioneDB'));
		$factory->setDsn($cfg->getValue('DSN'));
		$db=$factory->createInstance();
		//**************
		$factory2=DbAbstractionFactory::getFactory($cfg->getValue('AstrazioneDB2'));
		$factory2->setDsn($cfg->getValue('DSN2'));
		$db2=$factory2->createInstance();
		//********************************************************

		$sql = "Select
		e1.nome as nom,
        e1.cognome as cogn,
        ind.indirizzo_telematicosmtp as email,
        e2.tel,
        e2.parent,
        e2.denominazione,
        e3.denominazione as de3,
        e3.id_entita as id_servizio,
        e4.denominazione as de4,
        e1.id_entita as id
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
		AND lower(e1.cognome) LIKE lower('%".$cognome."%')
		AND lower(e1.nome) LIKE lower('%".$nome."%')
        --AND e3.id_entita LIKE '".$_GET['servizio']."%'
        -- AND e1.id_entita = ".$id_utente."
        --AND e3.id_entita = ".$_GET['id_servizio']."
		ORDER BY cogn,nom";

		$rs = $db2->query($sql);

		if ($rs->numRows() >=2) {
			$this->setError("Risultati multipli. Inserire il cognome completo.");
		}
		else {
			$row = $rs->fetchRow(MDB2_FETCHMODE_ASSOC);
			$this->setCognome($row['cogn']);
			$this->setNome($row['nom']);
			$this->setIdUtente($row['id']);
			$this->setIdServizio($row['id_servizio']);
			$this->setError(0);
		}


	}



	public function getUtenteConripulituraDati($cognome_nome) {
		/*
		 * Config e chiamo DB *******************************
		 */
		require_once ("class/ConfigSingleton.php");
		$cfg = SingletonConfiguration::getInstance ();
		require_once ("class/Db.php");
		$factory=DbAbstractionFactory::getFactory($cfg->getValue('AstrazioneDB'));
		$factory->setDsn($cfg->getValue('DSN'));
		$db=$factory->createInstance();
		//**************
		$factory2=DbAbstractionFactory::getFactory($cfg->getValue('AstrazioneDB2'));
		$factory2->setDsn($cfg->getValue('DSN2'));
		$db2=$factory2->createInstance();
		//********************************************************

		$ARRAY_replace = array(
				'Dott.' => '',
				'Dott.ssa' => '',
				'D.ssa' => '',
				'Dott.' => '',
				'Ing.' => '',
				'Dott' => '',
				'Ing' => ''
		);

		$cognome_possibile = strtr($cognome_nome, $ARRAY_replace);
		//echo "cogn_poss".$cognome_possibile;
		$ARRAY_Cognomi_possibili = explode(" ", $cognome_possibile);

		foreach ($ARRAY_Cognomi_possibili as $cognome) {
			//echo "COGN: ".$cognome;


//NOTE: Controlla se OK - ho sostituito la query
/*
		$sql = "Select
			e1.nome as nom,
			e1.cognome as cogn,
			ind.indirizzo_telematicosmtp as email,
			e2.tel,
			e2.parent,
			e2.denominazione,
			e3.denominazione as de3,
			e3.id_entita as id_servizio,
			e4.denominazione as de4,
			e1.id_entita as id
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
			AND lower(e1.cognome) LIKE lower('%".$cognome."%')
			ORDER BY cogn,nom";
			echo $sql;
*/
			$sql = "Select
				e1.nome as nom, e1.cognome as cogn,
				e1.id_entita as id
				FROM entita as e1 INNER JOIN positions as ps on e1.id_entita = ps.id_entita
				INNER JOIN indirizzo_telematicosmtp as ind on e1.id_entita = ind.id_entita
				INNER JOIN entita as e2 ON e2.id_entita = ps.position
				INNER JOIN entita as e3 ON e3.id_entita = e2.parent
				INNER JOIN entita as e4 ON e4.id_entita = e3.parent
				where e1.cognome <> '' AND (e2.tipo_unita_organizzativa = 'Attiva' OR e2.tipo_unita_organizzativa ISNULL
				OR e2.tipo_unita_organizzativa = '') AND e2.tel <> ''
				AND lower(e1.cognome) LIKE lower('%".$cognome."%')
				GROUP BY cogn,nom,id";

			$rs = $db2->query($sql);

			if ($rs->numRows() >=2) {
				$this->setError("Risultati multipli. Inserire il cognome completo.");
			}
			elseif ($rs->numRows() == 0) {
				$this->setError("Nessun risultato.");
			}
			else {
				$row = $rs->fetchRow(MDB2_FETCHMODE_ASSOC);
				$this->setCognome($row['cogn']);
				$this->setNome($row['nom']);
				$this->setIdUtente($row['id']);
				$this->setIdServizio($row['id_servizio']);
				$this->setError(0);
			}

		}

		//echo $this->getCognome();
		//echo $this->getIdUtente();

		if ($this->getIdUtente() != "") {
			$this->setError(0);
		}


	}



}

?>
