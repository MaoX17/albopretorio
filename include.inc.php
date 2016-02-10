<?
//Configurazione da Singleton
require_once('class/ConfigSingleton.php');
$cfg = SingletonConfiguration::getInstance();

//necessaria x definire correttam la locazione delle immagini
//$percorso_relativo="";

//imposto in path include a runtime 
ini_set('include_path',ini_get('include_path').":".realpath(dirname(__FILE__)));
ini_set('include_path',ini_get('include_path').":".realpath(dirname(__FILE__))."/pear:/usr/share/pear");

$titolo_pagina = $cfg->getValue('titolo_applicazione');
$titolo_pagina = $cfg->getValue('titolo_applicazione');

setlocale(LC_MONETARY, 'it_IT');


function add_or_change_parameter($parameter, $value)
{
	$params = array();
	$output = "?";
	$firstRun = true;
	foreach($_GET as $key=>$val)
	{
		if($key != $parameter)
		{
			if(!$firstRun)
			{
				$output .= "&";
			}
			else
			{
				$firstRun = false;
			}
			$output .= $key."=".urlencode($val);
		}
	}
	if(!$firstRun)
		$output .= "&";
	$output .= $parameter."=".urlencode($value);

	$url_get = htmlentities($output);

	$ARRAY_POST = $_POST;

	$response = http_post_fields($output, $ARRAY_POST);
	return $response;
}


function dt_oggi()
{
    return date("Y-m-d"); 
}

function venti_giorni_fa()
{
	return date("Y-m-d", strtotime( '-20 days' ));
}

function dt_formato_standard($data_dal_db)
{
	return (substr($data_dal_db,8,2)."/".substr($data_dal_db,5,2)."/".substr($data_dal_db,0,4));
}


function session_restart()
{
    if (session_name()=='') {
        // Session not started yet
        session_start();
    }
    else {
        // Session was started, so destroy
        session_destroy();

        // But we do want a session started for the next request
        session_start();
        session_regenerate_id();

        // PHP < 4.3.3, since it does not put
        setcookie(session_name(), session_id());
    }
}



function cerca_ext_p7m($nomefile)
{
	$scrivi = FALSE;
	//echo "elaboro in function ".$nomefile."<br>";
	$ARRAY_Nome = explode(".", $nomefile);
	$ARRAY_conta_occorrenze = array_count_values($ARRAY_Nome);
//	print_r($ARRAY_conta_occorrenze)."<br>";
//	print_r($ARRAY_Nome);


	$nr_p7m = $ARRAY_conta_occorrenze['p7m'];
	if ($nr_p7m > 1) {
		//$scrivi = TRUE;
	}
	//if ($scrivi == TRUE)	echo "nr p7m = ".$nr_p7m."<br>";

	while ($nr_p7m > 0) {
	//	if ($scrivi == TRUE)	echo "pre-pop : ";
	//	if ($scrivi == TRUE)	print_r($ARRAY_Nome);
		$ex_ext = array_pop($ARRAY_Nome);
	//	if ($scrivi == TRUE)	echo "post-pop : ";
	//	if ($scrivi == TRUE)	print_r($ARRAY_Nome);
		$nr_p7m--;
	}
	$len = count($ARRAY_Nome);
	//if ($scrivi == TRUE)	echo "XXX".$ARRAY_Nome[($len-1)]."<br>";
	//array_key_exists("primo", $un_array)
	//if ($scrivi == TRUE)	print_r($ARRAY_Nome);
	//if ($scrivi == TRUE)	echo $len."<br>";
	//if ($scrivi == TRUE)	echo $ARRAY_Nome[$len-1]."<br>";
	switch ($ARRAY_Nome[$len-1]) {
		case "bmp":
			$ext = ".bmp.p7m";
			break;
		case "doc":
			$ext = ".doc.p7m";
			break;
		case "docx":
			$ext = ".docx.p7m";
			break;
		case "htm":
			$ext = ".htm.p7m";
			break;
		case "html":
			$ext = ".htm.p7m";
			break;
		case "jpg":
			$ext = ".jpg.p7m";
			break;
		case "mht":
			$ext = ".mht.p7m";
			break;
		case "msg":
			$ext = ".msg.p7m";
			break;
		case "ods":
			$ext = ".ods.p7m";
			break;
		case "odt":
			$ext = ".odt.p7m";
			break;
		case "pdf":
			$ext = ".pdf.p7m";
			break;
		case "rtf":
			$ext = ".rtf.p7m";
			break;
		case "txt":
			$ext = ".txt.p7m";
			break;
		case "xls":
			$ext = ".xls.p7m";
			break;
		case "xlsx":
			$ext = ".xlsx.p7m";
			break;
		case "xlt":
			$ext = ".xls.p7m";
			break;
		case "xml":
			$ext = ".xlm.p7m";
			break;
		case "xps":
			$ext = ".xps.p7m";
			break;
		case "zip":
			$ext = ".zip.p7m";
			break;
		default:
			$ext = ".p7m";
	}

	return $ext;
}






/*
 * Eseguo le funzioni necessarie in ogni file:
 */
session_start();


?>