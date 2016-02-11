<?

$percorso_relativo = "./";
include ($percorso_relativo."include.inc.php");
/*
 * Config e chiamo DB *******************************
 */
require_once ($percorso_relativo."class/ConfigSingleton.php");
$cfg = SingletonConfiguration::getInstance ();
require_once ($percorso_relativo."class/Db.php");
$factory=DbAbstractionFactory::getFactory($cfg->getValue('AstrazioneDB'));
$factory->setDsn($cfg->getValue('DSN'));
$db=$factory->createInstance();
//********************************************************

require_once $percorso_relativo.'class/Ditta.php';
require_once $percorso_relativo.'class/Categoria.php';

//$idDitta_get = $_GET['idDitta'];

require_once 'XML/RPC/Server.php';
//Declare the functions, etc.
function ricevitore($params) {
    $obj = new risposta;
    return $obj->ricevitore($params);
}

class risposta {
    function ricevitore($params) {
    	$percorso_relativo = "./";
    	//Estraggo il codice univoco della Protocollazione
        $param = $params->getParam(0);
        $codice_univoco = $param->scalarval();
        error_log("CODICE UNIVOCO = ".$codice_univoco);
        
        //Estraggo l'XML base64 codificato
        $param = $params->getParam(1);
        $xml_base64 = $param->scalarval();
        error_log("BASE64 = ".$xml_base64);
        
        //Estraggo l'XML base64 codificato (altro metodo)
        //$xml = $param->scalarval();
        //error_log("BASE64 DUE = ".$xml);

        //Decodifico l'XML
	    $xml = base64_decode($xml_base64);
        error_log("XML DECODIFICATO = ".$xml);
        
        //OGGETTO XML_RPC_Response????
	    //$param = $params->getParam(2);
        //error_log("PRINTO ROBA VARIA = ".$param->value());
        
        
        //Genero un array dalla risposta XML
        $arr = xml2array($xml); 
        
        //error_log("nr = ".$arr[ConfermaRicezione][ConfermaRicezione][NumeroRegistrazione]);
        error_log("nr2 = ".$arr['ConfermaRicezione']['Identificatore']['NumeroRegistrazione']);
        error_log("cod = ".$arr['ConfermaRicezione']['MessaggioRicevuto']['Identificatore']['NumeroRegistrazione']);
        
        $codice_univoco2 = $arr['ConfermaRicezione']['MessaggioRicevuto']['Identificatore']['NumeroRegistrazione'];
        $nr_protocollo = $arr['ConfermaRicezione']['Identificatore']['NumeroRegistrazione'];
        
        if (($codice_univoco == $codice_univoco2) AND ($codice_univoco2 != "")){
        	$idDitta = substr($codice_univoco, 4);
        	//$idDitta = $idDitta_get;
        	$ditta = new Ditta();
        	$ditta->caricaDalDB($idDitta);
        	$ditta->setProt($nr_protocollo);
            //aggiunta data protocollo il 08/11/2013------------------
            if ($ditta->getProt() == "") {
                $ditta->setDtProt("");
            }
            elseif ($ditta->getDtProt() == "") {
                $ditta->setDtProt(date('Ymd'));
            }
            //---------------------------------------------------------------
        	$ditta->aggiornaNelDB();
        	$ditta->SerializzaNelDB();
        	
        	
        	
        	require_once $percorso_relativo.'class/tcpdf/config/lang/ita.php';
			require_once $percorso_relativo.'class/tcpdf/tcpdf.php';
			
			// create new PDF document
			$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			
			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Maurizio Proietti');
			$pdf->SetTitle('TEST');
			$pdf->SetSubject('TCPDF Tutorial');
			$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
			
			// set default header data
			$pdf->SetHeaderData("../../../grafica/images/logo_prv_small2.jpg", "10", "Registrazione all'elenco delle ditte della Provincia di Prato", "Eseguita in data ".date("d/m/Y"));
			
			// set header and footer fonts
			$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			
			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
			
			//set margins
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			
			//set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			
			//set image scale factor
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
			
			//set some language-dependent strings
			$pdf->setLanguageArray($l);
			
			// ---------------------------------------------------------
			
			// set font
			$pdf->SetFont('courier', '', 10);
			
			// add a page
			$pdf->AddPage();
			
			// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
			// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
			
			// create some HTML content
			
			$html = "Ragione Sociale = ".$ditta->getRagioneSociale()."\n";
			$html .= "Forma Societaria = ".$ditta->getFormaSocietaria()."\n";
			$html .= "Partita IVA / C.F. = ".$ditta->getCf_piva()."\n";
			$html .= "Comune = ".recuperaNomeComune($ditta->getComune())."\n";
			$html .= "Provincia = ".recuperaNomeProvincia($ditta->getProvincia())."\n";
			$html .= "CAP = ".$ditta->getCap()."\n";
			$html .= "Indirizzo = ".$ditta->getIndirizzo()."\n";
			$html .= "Telefono = ".$ditta->getTel1()."\n";
			$html .= "Telefono 2 = ".$ditta->getTel2()."\n";
			$html .= "Fax = ".$ditta->getFax()."\n";
			$html .= "Cellulare = ".$ditta->getCell()."\n";
			$html .= "Email = ".$ditta->getEmail()."\n";
			$html .= "Protocollato con nr. = ".$ditta->getProt()."\n";
			
			setlocale(LC_MONETARY, 'it_IT');
			
			foreach ($ditta->getARRAY_Categorie() as $key => $cat) {
				$html .= "#######################################################################\n";
				$html .= "Categoria = ".$cat->getCategoria()."\n";
				$html .= "Classe = ".$cat->getClassifica()."\n";
			}
			
			// output the HTML content
			//$pdf->writeHTML($html, true, false, true, false, '');
			//$tbl = $ditta->__tostring();
			//$html = $ditta->__tostring();
			//$pdf->writeHTML($tbl, true, false, false, false, '');
			// output the HTML content
			//$pdf->writeHTML($html, true, 0, true, 0);
			$pdf->Write($h=0, $html, $link='', $fill=0, $align='L', $ln=true, $stretch=0, $firstline=false, $firstblock=false, $maxh=0);
			
			// reset pointer to the last page
			$pdf->lastPage();
			
			// ---------------------------------------------------------
			
			//Close and output PDF document
			//$pdf->Output('example_021.pdf', 'I');
			$pdf->Output('Protocollato'.$ditta->getIdDitta().'.pdf', 'F');
			
			
			
			//require("/fpd/fpdf.php");
			//$pdf = new FPDF();
			// email stuff (change data below)
			$to = $ditta->getEmail();
			//$to = "webmaster@provincia.prato.it";
			$from = "webmaster@provincia.prato.it";
			$subject = "Avvenuta registrazione - albo ditte della Provincia di Prato";
			$message = "<p>Conferma avvenuta registrazione all'albo delle ditte della Provincia di Prato.</p>";
			// a random hash will be necessary to send mixed content
			$separator = md5(time());
			// carriage return type (we use a PHP end of line constant)
			$eol = PHP_EOL;
			// attachment name
			$filename = 'Protocollato'.$ditta->getIdDitta().'.pdf';
			// encode data (puts attachment in proper format)
			$pdfdoc = $pdf->Output("", "S");
			$attachment = chunk_split(base64_encode($pdfdoc));
			// main header (multipart mandatory)
			$headers = "From: ".$from.$eol;
			$headers .= "MIME-Version: 1.0".$eol;
			$headers .= "Content-Type: multipart/mixed; boundary=\"".$separator."\"".$eol.$eol;
			$headers .= "Content-Transfer-Encoding: 7bit".$eol;
			$headers .= "This is a MIME encoded message.".$eol.$eol;
			// message
			$headers .= "--".$separator.$eol;
			$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"".$eol;
			$headers .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
			$headers .= $message.$eol.$eol;
			// attachment
			$headers .= "--".$separator.$eol;
			$headers .= "Content-Type: application/octet-stream; name=\"".$filename."\"".$eol;
			$headers .= "Content-Transfer-Encoding: base64".$eol;
			$headers .= "Content-Disposition: attachment".$eol.$eol;
			$headers .= $attachment.$eol.$eol;
			$headers .= "--".$separator."--";
			// send message
			mail($to, $subject, "", $headers);
//mail("mproietti@provincia.prato.it", $subject, "", $headers);
			
			//============================================================+
			// END OF FILE                                                
			//============================================================+
			//echo $html;
			        	
        	
        	
        }
        
        
        //mail("mproietti@provincia.prato.it", "TEST-WEBSERVICES", $xml);
        
        return new XML_RPC_Response(new XML_RPC_Value("0:Accepted", "string"));
    }
}

//Establish the dispatch map and XML_RPC server instance.
$server = new XML_RPC_Server(
    array(
        'ricevitore' => array(
            'function' => 'ricevitore'
        ),
    )
);
?>