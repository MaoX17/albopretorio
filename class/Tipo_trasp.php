<?php

class Tipo_Trasp {
	
	protected $id_tipo_trasp;
	protected $tipo_trasp;
	

	
	/**
	 * @return the $id_tipo
	 */
	public function getId_tipo_trasp() {
		return $this->id_tipo_trasp;
	}

	/**
	 * @return the $tipo
	 */
	public function getTipo_trasp() {
		return $this->tipo_trasp;
	}

	/**
	 * @param id_tipo_traspo the $id_tipo to set
	 */
	public function setId_tipo_trasp($id_tipo_trasp) {
		$this->id_tipo_trasp = $id_tipo_trasp;
	}

	/**
	 * @param tipo_traspo the $tipo to set
	 */
	public function setTipo_trasp($tipo_trasp) {
		$this->tipo_trasp = $tipo_trasp;
	}
	
	
/*
 *  Altre funzioni
 */
	public function getTipoTraspFromIdTipoTrasp($id_Tipo_trasp) {
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

		$sql = "SELECT tipi_trasp.tipo_trasp
				FROM tipi_trasp
				WHERE id_tipo_trasp=".$id_Tipo_trasp.";";
		$rs = $db->query($sql);
		$row = $rs->fetchRow(DB_FETCHMODE_ORDERED);
		
		return $row[0];
	}


	public function setTipoTraspFromIdTipoTrasp($id_Tipo_trasp) {
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

		$sql = "SELECT tipi_trasp.tipo_trasp
				FROM tipi_trasp
				WHERE id_tipo_trasp=".$id_Tipo_trasp.";";
		$rs = $db->query($sql);
		$row = $rs->fetchRow(DB_FETCHMODE_ORDERED);

		$this->setTipo_trasp($row[0]);
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
