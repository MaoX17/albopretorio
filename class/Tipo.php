<?php

class Tipo {
	
	protected $id_tipo;
	protected $tipo;
	

	
	/**
	 * @return the $id_tipo
	 */
	public function getId_tipo() {
		return $this->id_tipo;
	}

	/**
	 * @return the $tipo
	 */
	public function getTipo() {
		return $this->tipo;
	}

	/**
	 * @param $id_tipo the $id_tipo to set
	 */
	public function setId_tipo($id_tipo) {
		$this->id_tipo = $id_tipo;
	}

	/**
	 * @param $tipo the $tipo to set
	 */
	public function setTipo($tipo) {
		$this->tipo = $tipo;
	}
	
	
/*
 *  Altre funzioni
 */
	public function getTipoFromIdTipo($id_Tipo) {
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

		$sql = "SELECT tipi.tipo
				FROM tipi
				WHERE id_tipo=".$id_Tipo.";";
		$rs = $db->query($sql);
		$row = $rs->fetchRow(DB_FETCHMODE_ORDERED);
		
		return $row[0];
	}

	public function setTipoFromIdTipo($id_Tipo) {
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

		$sql = "SELECT tipi.tipo
				FROM tipi
				WHERE id_tipo=".$id_Tipo.";";
		$rs = $db->query($sql);
		$row = $rs->fetchRow(DB_FETCHMODE_ORDERED);

		$this->setTipo($row[0]);
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
