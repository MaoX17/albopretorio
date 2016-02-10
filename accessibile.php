<?php
/**
 * Created by Maurizio Proietti
 * User: mproietti
 * Date: 31/10/13
 * Time: 14.15
 */
?>

<!doctype html>
<!--[if lt IE 7]>      <html class="lt-ie9 lt-ie8 lt-ie7" lang="it"> <![endif]-->
<!--[if IE 7]>         <html class="lt-ie9 lt-ie8" lang="it"> <![endif]-->
<!--[if IE 8]>         <html class="lt-ie9" lang="it"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="it"> <!--<![endif]-->
<head>
    <base href="./">
    <!--[if IE]>
    <script type="text/javascript">
        // Fix for IE ignoring relative base tags.
        // See http://stackoverflow.com/questions/3926197/html-base-tag-and-local-folder-path-with-internet-explorer
        (function() {
            var baseTag = document.getElementsByTagName('base')[0];
            baseTag.href = baseTag.href;
        })();
    </script>
    <![endif]-->
    <meta charset="utf-8" />
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <!-- La seguente stringa è necessaria x jquery su IE8 sennò da errore -->
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="description" content="Albo Pretorio - Provincia di Prato
Nell'attuare la normativa in materia di pubblicita' legale online (art. 32, L 69/2009 e s.m.i.),
si avvisa che verranno pubblicati a questo Albo Pretorio i file di atti e provvedimenti prodotti a
partire dal 1 gennaio 2011; pertanto dei documenti prodotti fino al 31/12/2010 saranno pubblicati online i
soli estremi di pubblicazione all'Albo senza il relativo file, mentre verranno affissi presso i locali della
Provincia i testi su supporto cartaceo." />
<meta name="keywords" content="Albo, Pretorio, Provincia, Prato, Maurizio, Proietti" />
<meta name="author" content="Maurizio Proietti - http://blog.maurizio.proietti.name" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<meta name="google-site-verification" content="3j3wprrUgFGqPPfXYAwK8tXQhMf0YsLrYsWIO01QVKc" />

<link rel="apple-touch-icon" href="/>grafica/images/apple-touch-icon.png" />
<!--
	Titillium web font
   *********************
   Esclusivamente per il sito delle linee guida vengono importati tutti gli stili del web font;
   si consiglia di rivedere il seguente link limitando le famiglie del font utilizzate nel sito.
 -->
<link href='//fonts.googleapis.com/css?family=Titillium+Web:400,200,200italic,300italic,300,400italic,600,600italic,700,700italic,900' rel='stylesheet' type='text/css' />
    <title> Albo Pretorio - Provincia di Prato </title>
</head>


<?php
/**
 * Created by Maurizio Proietti
 * User: mproietti
 * Date: 31/10/13
 * Time: 14.14
 */
?>

<body>

<!--[if lt IE 8]>
<p class="browserupgrade">Versioni di Explorer inferiori alla 8 non sono supportate.
    Puoi effettuare un <a href="http://browsehappy.com/"> aggiornamento del browser </a> per visualizzare correttamente il sito.</p>
<![endif]-->


<a class="navbar-brand" href="http://<?=$_SERVER['SERVER_NAME']?>">
    <h1 class="navbar-brand">Albo Pretorio - Provincia di Prato</h1>
</a>

<?php
ini_set('include_path',ini_get('include_path').":".realpath(dirname(__FILE__)));
ini_set('include_path',ini_get('include_path').":".realpath(dirname(__FILE__))."/pear:/usr/share/pear");

include $_GET['pagina_accessibile'];

?>