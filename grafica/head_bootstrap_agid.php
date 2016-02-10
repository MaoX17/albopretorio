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

    <?
    //NOTE: questo serve per non caricare nulla se la pagina è richiesta in modo super accessibile
    if ($_SERVER['SCRIPT_NAME'] != "/accessibile.php") {
    ?>


    <base href="<?=$percorso_relativo?>">
    <!--[if IE]><script type="text/javascript">
        // Fix for IE ignoring relative base tags.
        // See http://stackoverflow.com/questions/3926197/html-base-tag-and-local-folder-path-with-internet-explorer
        (function() {
            var baseTag = document.getElementsByTagName('base')[0];
            baseTag.href = baseTag.href;
        })();
    </script><![endif]-->
    <meta charset="utf-8" />
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <!-- La seguente stringa è necessaria x jquery su IE8 sennò da errore -->
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="description" content="Albo Pretorio - Provincia di Prato
Attuazione della normativa in materia di pubblicita' legale (art. 32, L 69/2009 e s.m.i.).
Verranno pubblicati a questo Albo Pretorio i file di atti e provvedimenti prodotti a
partire dal 1 gennaio 2011; pertanto dei documenti prodotti fino al 31/12/2010 saranno pubblicati online i
soli estremi di pubblicazione all'Albo senza il relativo file, mentre verranno affissi presso i locali della
Provincia i testi su supporto cartaceo." />
<meta name="keywords" content="Albo, Pretorio, Provincia, Prato, delibere, atti, pubblicazione, Maurizio, Proietti" />
<meta name="author" content="Maurizio Proietti - http://blog.maurizio.proietti.name" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<meta name="google-site-verification" content="3j3wprrUgFGqPPfXYAwK8tXQhMf0YsLrYsWIO01QVKc" />

<?php include 'http://include.provincia.prato.it/include/schema_microdata.php'; ?>

<link rel="apple-touch-icon" href="http://include.provincia.prato.it/grafica/images/apple-touch-icon.png" />
<!--
	Titillium web font
   *********************
   Esclusivamente per il sito delle linee guida vengono importati tutti gli stili del web font;
   si consiglia di rivedere il seguente link limitando le famiglie del font utilizzate nel sito.
 -->
<link href='//fonts.googleapis.com/css?family=Titillium+Web:400,200,200italic,300italic,300,400italic,600,600italic,700,700italic,900' rel='stylesheet' type='text/css' />

<!-- Bootstrap core CSS -->
<link href="http://include.provincia.prato.it/libs/js/agid-bootstrap/dist/css/agid.css" rel="stylesheet" />

<!-- Bootstrap components-->
<link href="http://include.provincia.prato.it/libs/js/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css" rel="stylesheet" />
<link href="http://include.provincia.prato.it/libs/js/font-awesome/css/font-awesome.min.css" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script type="text/javascript" src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script type="text/javascript" src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


<!-- cookie -->
<link rel="stylesheet" media="screen" href="http://www.provincia.prato.it/cookie.css" type="text/css" />
<!-- /cookie -->


    <title> <?=$titolo_pagina ?> </title>

    <!-- NOTE: Inizio della navbar dell'ente -->
    <style>
        .navbar .brand {
            max-height: 50px;
            overflow: visible;
            padding-top: 0;
            padding-bottom: 0;
        }
        .navbar a.navbar-brand {
            padding: 0px 15px 0px;
        }

        h1.navbar-brand {
            font-size: 23px;
            margin-top: 0px;
            margin-bottom: 0px;
        }

        .container-fluid {
            padding-bottom: 0px;
        }

        .panel-primary .panel-heading a:visited {
            color: white;
        }

    </style>
    <!-- NOTE: Fine della navbar dell'ente -->


    <!-- NOTE: INIZIO modifiche per la social share bar -->
    <!-- social bar -->
        <link rel="stylesheet" media="screen" href="http://include.provincia.prato.it/grafica/share/bootstrap-social.css" type="text/css" />
        <!-- social bar -->

        <style>
            a.btn-social-icon:visited {
                color: white;
            }
        </style>
        <!-- NOTE: FINE modifiche per la social share bar -->


<?
//NOTE: FINE - questo serve per non caricare nulla se la pagina è richiesta in modo super accessibile
	}
?>


</head>

