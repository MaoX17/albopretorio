<?php

class Tipo_determina {
	
	protected $id_tipo_determina;
	protected $tipo_determina;
	

	
	/**
	 * @return the $id_tipo_determina
	 */
	public function getId_tipo_determina() {
		return $this->id_tipo_determina;
	}

	/**
	 * @return the $tipo_determina
	 */
	public function getTipo_determina() {
		return $this->tipo_determina;
	}

	/**
	 * @param id_tipo_determina the $id_tipo to set
	 */
	public function setId_tipo_determina($id_tipo_determina) {
		$this->id_tipo_determina = $id_tipo_determina;
	}

	/**
	 * @param tipo_determinao the $tipo to set
	 */
	public function setTipo_determina($tipo_determina) {
		$this->tipo_determina = $tipo_determina;
	}
	
	
/*
 *  Altre funzioni
 */

	public function setTipoDetFromIdTipoDet() {
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

		$sql = "SELECT tipi_determina.tipo_determina
				FROM tipi_determina
				WHERE id_tipo_determina=".$this->getId_tipo_determina().";";
		$rs = $db->query($sql);
		$row = $rs->fetchRow(DB_FETCHMODE_ORDERED);

		$this->setTipo_determina($row[0]);
		return $row[0];
	}




	public function getTipoDetFromIdTipoDet($id_Tipo_determina) {
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

		$sql = "SELECT tipi_determina.tipo_determina
				FROM tipi_determina
				WHERE id_tipo_determina=".$id_Tipo_determina.";";
		$rs = $db->query($sql);
		$row = $rs->fetchRow(DB_FETCHMODE_ORDERED);
		
		return $row[0];
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
