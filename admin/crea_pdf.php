<?php
include ("include.inc.php");

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

$percorso_relativo = "./";

//prende il tipo corretto xche ho un class-loader in include
$impianto = unserialize($_SESSION['impianto']);

require_once 'class/Anagrafica.php';
require_once 'class/Istanza.php';
require_once 'class/Indirizzo.php';
require_once 'class/Pt_Cartografico.php';

$istanza = unserialize($_SESSION['istanza']);
//$istanza = new Istanza();

// load alternative config file
require_once($percorso_relativo.'class/tcpdf/config/tcpdf_config_mao.php');
define("K_TCPDF_EXTERNAL_CONFIG", TRUE);

require_once($percorso_relativo.'class/tcpdf/config/lang/ita.php');
require_once($percorso_relativo.'class/tcpdf/tcpdf.php');



// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false); 

// set document information
/*$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 001');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
*/

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 8));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', 8));


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
//$pdf->SetFont('times', 'BI', 10);
$pdf->SetFont('times', '', 10);

// add a page
$pdf->AddPage();

/*
 * setVisibility() allows to restrict the rendering of some 
 * elements to screen or printout. This can be useful, for 
 * instance, to put a background image or color that will 
 * show on screen but won't print.
 */
    
$pdf->setVisibility('all');

$pdf->Write(6, "Al sindaco del comune di ".$istanza->getUbicazione_impianto()->getComune()."\n","",0,"R");

$pdf->Write(6, "Comunicazione installazione impianto ".$istanza->getImpianto()->getTipo_impianto()."\n","",0,"C");
$pdf->Write(6, "\n","",0,"C");

$testo = "Il sottoscritto __".stripslashes($istanza->getRichiedente()->getCognome())." ".stripslashes($istanza->getRichiedente()->getNome()); 
$testo .=	"__ nato a __".stripslashes($istanza->getRichiedente()->getComune_nascita());
$testo .= "__ (_".$istanza->getRichiedente()->getProvincia_nascita()."_) "; 
$testo .=	" il __".$istanza->getRichiedente()->getDt_nascita_formato_standard(); 
$testo .= "__ \n residente in __".stripslashes($istanza->getRichiedente()->getResidenza()->getComune());
$testo .= "__ (_".$istanza->getRichiedente()->getResidenza()->getProvincia()."_) "; 
$testo .= " via/piazza __".stripslashes($istanza->getRichiedente()->getResidenza()->getIndirizzo()); 
$testo .= "__  Cap __".$istanza->getRichiedente()->getResidenza()->getCap();
$testo .= "__ \n Codice Fiscale __".strtoupper($istanza->getRichiedente()->getCf_piva());
$testo .= "__ tel. __".$istanza->getRichiedente()->getTel();
$testo .= "__ cell. __".$istanza->getRichiedente()->getCell();
$testo .= "__ \n email __".$istanza->getRichiedente()->getEmail(); 
$testo .= "__ \n Nr iscrizione CCIAA __".$istanza->getRichiedente()->getCciaa();
$testo .= "__ legale rappresentante __".stripslashes($istanza->getRichiedente()->getQualita_di())."__"; 

$pdf->Write(5, $testo);

$pdf->Write(5, "\n","",0,"C");
$pdf->Write(6, "COMUNICA \n","",0,"C");
$pdf->Write(5, "\n","",0,"C");



$testo = "l'intenzione di voler effettuare l'installazione di un impianto ".$istanza->getImpianto()->getTipo_impianto()." 
sull'immobile sito in __".$istanza->getUbicazione_impianto()->getComune()."__ (PO), ";
$testo .= " via _".stripslashes($istanza->getUbicazione_impianto()->getIndirizzo())."_ \n";
$testo .= "catastalmente identificato dal foglio _".$istanza->getUbicazione_impianto()->getNr_foglio_catasto()."_ particella_".$istanza->getUbicazione_impianto()->getParticella_catasto()."_ 
subalterno _".$istanza->getUbicazione_impianto()->getSubalterno_catasto()."_ a tal fine";
 
$pdf->Write(5, $testo);

$pdf->Write(5, "\n","",0,"C");
$pdf->Write(6, "DICHIARA CHE \n","",0,"C");
$pdf->Write(5, "\n","",0,"C");



$testo = "";
if ($istanza->getImpianto()->getArt_17_c1_LR39_05() == 1) {
	$testo .= " - L'impianto RICADE nei casi previsti dall’art. 17 c.1 LR 39/05; \n";
}
else {
	$testo .= " - L'impianto NON RICADE nei casi previsti dall’art. 17 c.1 LR 39/05; \n";
}

if ($istanza->getImpianto()->getArt_11_c3_Dlgs115_08() == 1) {
	$testo .= " - L'impianto RICADE nei casi previsti dall’art. 11 c.3 DLgs 115/08; \n";
}
else {
	$testo .= " - L'impianto NON RICADE nei casi previsti dall’art. 11 c.3 DLgs 115/08; \n";
}

if ($istanza->getImpianto()->getNecessarie_autorizzazioni_specifiche() == 1) {
	$testo .= " - L'impianto NECESSITA di autorizzazioni specifiche \n 	(ambientale, paesaggistica, di tutela del patrimonio storico-artistico, della salute o della pubblica incolumita', \n 	per vincolo idrogeologico, ecc.) \n";
}
else {
	$testo .= " - L'impianto NON NECESSITA di autorizzazioni specifiche \n 	(ambientale, paesaggistica, di tutela del patrimonio storico-artistico, della salute o della pubblica incolumita', \n 	per vincolo idrogeologico, ecc.) \n";
}

$testo .= "\n Le caratteristiche tecniche dell'impianto sono le seguenti:\n";


if ($istanza->getImpianto()->getTipo_impianto() == "Fotovoltaico") {
	$testo .= " - Potenza di picco: _".$istanza->getImpianto()->getPotenza_picco()."_ kWp\n";
	$testo .= " - Numero moduli fv: _".$istanza->getImpianto()->getNr_moduli_fv()."_ \n";
	
}
else if ($istanza->getImpianto()->getTipo_impianto() == "Solare Termico") {
	$testo .= " - Potenza: _".$istanza->getImpianto()->getPotenza()."_ kW\n";
}

$testo .= " - Superficie impianto: _".$istanza->getImpianto()->getSuperficie_impianto()."_ mq \n";
$testo .= " - Esposizione impianto: _".$istanza->getImpianto()->getEsposizione_impianto()."_ \n";



if ($istanza->getImpianto()->getTipo_impianto() == "Fotovoltaico") {	
}
else if ($istanza->getImpianto()->getTipo_impianto() == "Solare Termico") {
	$testo .= "\n L'impianto e' un:  \n";
	switch ($istanza->getImpianto()->getCaratteristiche_impianto()) {
    case 1:
        $testo .= "Impianto a servizio di Azienda operante nel SETTORE FLOROVIVAISTICO \n";
        break;
    case 2:
        $testo .= "Impianto a con produzione di acqua calda sanitaria \n";
        break;
    case 3:
        $testo .= "Impianto a con produzione di acqua calda sanitaria ed integrazione impianto riscaldamento \n";
        break;
    case 4:
        $testo .= "Impianto con serbatoio solidale con il pannello (serbatoio in vista sulla copertura) \n";
        break;
	case 5:
        $testo .= "Impianto con serbatoio indipendente dal pannello (serbatoio all’interno dell'edificio) \n";
        break;	
	
	}
}



$testo .= "\nRicade nella seguente tipologia di installazione:  \n";

switch ($istanza->getImpianto()->getTipologia_installazione()) {
	case 1:
		$testo .= "Impianto installato su tetto piano e/o terrazza \n";
		break;
	case 2:
		$testo .= "Impianto installato su tetti, coperture, facciate, balaustre o parapetti \n";
		break;
	case 3:
		$testo .= "Impianto installato su elementi di arredo urbano quali pensiline, pergole, ecc.  \n";
		break;
	case 4:
		$testo .= "Impianto installato a terra \n";
		break;
		
}


$testo .= "\nL'impianto, secondo le definizioni di cui al DM 19.02.07 risulta essere: \n";

switch ($istanza->getImpianto()->getTipologia_installazione()) {
	case 1:
		$testo .= "Impianto fotovoltaico NON INTEGRATO \n";
		break;
	case 2:
		$testo .= "Impianto fotovoltaico PARZIALMENTE  INTEGRATO \n";
		break;
	case 3:
		$testo .= "Impianto fotovoltaico CON INTEGRAZIONE ARCHITETTONICA \n";
		break;
}



$pdf->Write(5, $testo);

$pdf->Write(5, "\n","",0,"C");

$pdf->SetFont('times', '', 8);

$testo = "Il sottoscritto si impegna al rispetto delle normative riguardanti le prescrizioni minime di sicurezza e di salute nell'esecuzione delle opere e per le successive eventuali manutenzioni.
E', infine, consapevole che, ai sensi del D.M. 22.01.08 n. 37, entro 30 giorni dalla conclusione dei lavori, dovra' depositare, presso questo Settore, la dichiarazione di conformita' dell'impianto (in duplice copia).";

$pdf->Write(3, $testo);

$testo = "\nData: _________________________";
$pdf->Write(6, $testo);

$pdf->Write(6, "Firma: _______________________________","",0,"R");

$pdf->Write(6, "\n","",0,"C");
$pdf->Write(6, "\n","",0,"C");

$testo = "Il sottoscritto ".$istanza->getRichiedente()->getCognome()." ".$istanza->getRichiedente()->getNome()." dichiara inoltre che al termine dei lavori si impegna, tramite la ditta installatrice, a validare la presente comunicazione sul sito web della Provincia di Prato all'indirizzo http://energia.provincia.prato.it utilizzando il seguente codice identificativo personale presente nella seconda pagina del modulo.";

$pdf->Write(3, $testo);

$testo = "\nData: _________________________";
$pdf->Write(6, $testo);

$pdf->Write(6, "Firma: _______________________________","",0,"R");

//$pdf->Write(6, "\n","",0,"C");


// set visibility only for screen
//$pdf->setVisibility('screen');

$pdf->AddPage();

$testo = "NOTE PER L'UTENTE:
La predisposizione del presente modulo ha lo scopo di facilitare il cittadino, fornendogli un modello che contenga tutte le informazioni atte a descrivere gli impianti ad energia rinnovabile che intende istallare, come richiesto dalla legislazione vigente.
Tale facilitazione si coniuga con l'esigenza di creare un archivio unico degli impianti ad energia rinnovabile di tutta la provincia, ottemperando in tal senso a quanto richiesto dalla Regione Toscana; per questo si rende necessaria la compilazione della comunicazione libera anche nel caso in cui si debba procedere all'installazione di impianti ad energia rinnovabile tramite Denuncia d'Inizio Attività o altri atti autorizzativi, alla cui Fine Lavori va sempre allegata.
Onde evitare di archiviare impianti non realizzati, falsando i dati complessivi, si chiede al cittadino di validare la comunicazione, o meglio di farla validare alla Ditta esecutrice.

Di seguito le istruzioni:
La compilazione del modello  di 'Comunicazione Libera' dovra' essere effettuata sul sito della Provincia all'indirizzo http://energia.provincia.prato.it ; una volta compilato, il modulo dovra' essere stampato e firmato e consegnato all'ufficio comunale di competenza (vedi indirizzario sotto riportato), con le seguenti modalita':
1)  prima dell'inizio dei lavori in tutti i casi in cui la legge prevede la sola Comunicazione Libera;  
2)  al termine dei lavori in caso di DIA, Autorizzazione Unica o altro atto autorizzativo.

In entrambi i casi, al termine dei lavori, l'installatore dovra' validare la comunicazione precedentemente compilata dal richiedente (utilizzando il codice impianto ottenuto durante la prima compilazione dei dati) confermando o variando le  'caratteristiche tecniche dell'impianto' realizzato.

Nel caso in cui l'impianto dovesse subire modifiche significative ai fini dell'iter autorizzativo si dovra' procedere con una nuova compilazione del modello (nuovo codice impianto) e successivo invio all'ufficio comunale di competenza. La validazione da parte della ditta installatrice consentira' l'archiviazione nel database della Provincia dei dati relativi all'impianto 'come costruito'

Per validare la presente comunicazione sul sito web della Provincia di Prato all'indirizzo http://energia.provincia.prato.it occorre utilizzare il seguente codice identificativo personale: ".$istanza->getCod_validazione()."


INDIRIZZARIO UFFICI COMUNALI

COMUNE DI PRATO
            Servizio Gestione Attività Edilizia
            Via  Arcivescovo Martini,  60

COMUNE DI VAIANO
            Area 1 – Pianificazione e Gestione del Territorio
            Piazza del Comune, 4

COMUNE DI VERNIO
            Ufficio Tecnico
            Piazza del Comune, 20
            San Quirico di Vernio

COMUNE DI POGGIO A CAIANO
            Ufficio Tecnico
            Via Cancellieri, 4

COMUNE DI CARMIGNANO
            Ufficio Ambiente e Ufficio Urbanistica
            Piazza Matteotti, 1

COMUNE DI CANTAGALLO
            Ufficio Tecnico
            Via Giuseppe Verdi, 24

COMUNE DI MONTEMURLO
            Ufficio Tecnico
            Via A. Toscanini";


$pdf->Write(3, $testo);


// set visibility only for print
/*
$pdf->setVisibility('print');
$pdf->Write(6, "This line is for printout.\n");
*/

// restore visibility
$pdf->setVisibility('all');


// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('ProvinciaDiPrato.pdf', 'I');

//============================================================+
// END OF FILE                                                 
//============================================================+

?>