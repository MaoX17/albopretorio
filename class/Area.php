<?php

class Area {
	
	protected $id_area;
	protected $responsabile;
	protected $area;
	

	/**
	 * @param $area the $area to set
	 */
	public function setArea($area) {
		$this->area = $area;
	}

	/**
	 * @param $responsabile the $responsabile to set
	 */
	public function setResponsabile($responsabile) {
		$this->responsabile = $responsabile;
	}

	/**
	 * @param $id_area the $id_area to set
	 */
	public function setId_area($id_area) {
		$this->id_area = $id_area;
	}

	/**
	 * @return the $area
	 */
	public function getArea() {
		return $this->area;
	}

	/**
	 * @return the $responsabile
	 */
	public function getResponsabile() {
		return $this->responsabile;
	}

	/**
	 * @return the $id_area
	 */
	public function getId_area() {
		return $this->id_area;
	}
	
	
/*
 *  Altre funzioni
 */

	public function getAreaFromIdArea($id_Area) {
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
		
		$sql = "SELECT area
				FROM aree
				WHERE id_area=".$id_Area.";";
		$rs = $db->query($sql);
		$row = $rs->fetchRow(DB_FETCHMODE_ORDERED);
		return $row[0];
	}
	
	
	public function getRespFromIdArea($id_Area) {
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
		
		$sql = "SELECT responsabile
				FROM aree
				WHERE id_area=".$id_Area.";";
		$rs = $db->query($sql);
		$row = $rs->fetchRow(DB_FETCHMODE_ORDERED);
		return $row[0];
	}
	

	public function setAreaFromIdArea($id_Area) {
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
		
		$sql = "SELECT area
				FROM aree
				WHERE id_area=".$id_Area.";";
		$rs = $db->query($sql);
		$row = $rs->fetchRow(DB_FETCHMODE_ORDERED);
		$this->setArea($row[0]);
	}
	
	
	public function setRespFromIdArea($id_Area) {
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
		
		$sql = "SELECT responsabile
				FROM aree
				WHERE id_area=".$id_Area.";";
		$rs = $db->query($sql);
		$row = $rs->fetchRow(DB_FETCHMODE_ORDERED);
		$this->setResponsabile($row[0]);
	}
	
	
	
	
	
	
	/**
    * XXX: problema di compatibilità nella reflection fra php 5.1.x e php 5.2.x
    */
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
/*              $s      .= "
        <tr>
                <td>$name:</td>
                <td>" . $name . "</td>
        </tr>
        \n";
*/
        if ($this->$name != "") {

                        $s .= "
                <tr>
                        <td>$name:</td>
                        <td>";
                        if (is_array($this->$name)) {
                                                foreach ($this->$name as $key1=>$value1) {
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
