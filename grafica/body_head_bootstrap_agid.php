<?php
/**
 * Created by Maurizio Proietti
 * User: mproietti
 * Date: 31/10/13
 * Time: 14.14
 */
?>

<body>


<?

include_once("include/google_analytics.php");

//NOTE: questo serve per non caricare nulla se la pagina è richiesta in modo super accessibile
if ($_SERVER['SCRIPT_NAME'] != "/accessibile.php") {
?>

<!--[if lt IE 8]>
<p class="browserupgrade">Versioni di Explorer inferiori alla 8 non sono supportate.
	Puoi effettuare un <a href="http://browsehappy.com/"> aggiornamento del browser </a> per visualizzare correttamente il sito.</p>
<![endif]-->

<!-- cookie -->
<div id="banner_cookie">
	<div id="banner_interno">
		<div id="banner_sx">
			Questo sito utilizza cookies tecnici e di terze parti per funzionalit&agrave; quali la condivisione sui <em>social network</em> e/o la visualizzazione
			di media.
			Se non acconsenti all'utilizzo dei cookie di terze parti, alcune di queste funzionalit&agrave; potrebbero essere non disponibili.
			Per maggiori informazioni consulta la <a target="_blank" href="http://www.provincia.prato.it/privacy_cookie.html">privacy policy</a>
		</div>
		<div id="banner_dx">
			Acconsenti all'utilizzo di cookie di terze parti?
			<br />
			<br />
			<a href='javascript:void(0);' onclick='CookieOk();'><strong>Si, acconsento</strong></a>
			<a href='javascript:void(0);' onclick='CookieKo();'><strong>No, non acconsento</strong></a>
		</div>
	</div>
</div>

<script type="text/javascript" src="http://www.provincia.prato.it/cookie.js"></script>
<!-- /cookie -->

<!-- NOTE: Inizio della navbar dell'ente -->

<div class="container-fluid">
	<header class="navbar navbar-default hidden-print" id="navbar">
		<div class="container"> <!-- togli fluid -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
					<span class="sr-only">Barra di navigazione</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="http://<?=$_SERVER['HTTP_HOST']?>">
					<img alt="Logo dell'ente" class="navbar" src="/grafica/images/logo_prv_trasp.gif" style="margin-top: 0px; height:65px;">
				</a>
			</div>


			<div class="collapse navbar-collapse" id="navbar-collapse">
				<ul class="nav navbar-nav">
					<li>
						<a class="navbar-brand" href="http://<?=$_SERVER['HTTP_HOST']?>">
							<h1 class="navbar-brand"><?=$titolo_pagina?></h1>
						</a>
					</li>
				</ul>

				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Menu<strong class="caret"></strong></a>
						<ul class="dropdown-menu">
							<li><a href="<?=$percorso_relativo?>visualizza.php" class="list-group-item">Visualizza gli atti in pubblicazione</a></li>
							<li><a href="<?=$percorso_relativo?>visualizza-old.php" class="list-group-item">Visualizza gli atti già pubblicati</a></li>
							<li><a href="<?=$percorso_relativo?>ricerca_albo.php" class="list-group-item">Ricerca gli atti</a></li>
							<li><a href="<?=$percorso_relativo?>amm_aperta_visualizza.php" class="list-group-item">Amministrazione Aperta</a></li>

						</ul>
					</li>

					<?
					//Eseguo il controllo dell'ip sorgente
					$IP = $_SERVER['REMOTE_ADDR'];
					$IP_TRUNK = substr($IP, 0, 7);
					if (($IP_TRUNK == "172.21.") OR ($IP_TRUNK == "172.22." )) {
						/*
						 * TODO: Spostare login e tutto il necessario x la sez. amministrativa nella cartelle admin
						 */
						//echo '<a href="'.$percorso_relativo.'admin/" class="list-group-item">Admin</a>';
						?>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Sez. Admin<strong class="caret"></strong></a>
							<ul class="dropdown-menu">
								<li><a href="<?=$percorso_relativo?>admin/crea_albo.php" class="list-group-item">Inserisci un nuovo atto</a></li>
								<li><a href="<?=$percorso_relativo?>admin/ricerca_albo_admin.php" class="list-group-item">Ricerca e Modifica un atto</a></li>
								<li><a href="esportazione_amministrativa.php" class="list-group-item">Esportazione dati</a></li>
								<li><a href="<?=$percorso_relativo?>admin/amm_aperta_index.php" class="list-group-item">Amministrazione Aperta</a></li>
								<li><a href="<?=$percorso_relativo?>admin/ricerca_fatture.php" class="list-group-item">Ricerca Fatture elettroniche</a></li>
							</ul>
						</li>
						<?
					}
					?>
					<li class="dropdown">
						<a title="Visualizza questa pagina in modo Iper Accessibile" target="_blank"
						   href="<?=$percorso_relativo?>accessibile.php?pagina_accessibile=.<?=$_SERVER['SCRIPT_NAME']?>&<?=http_build_query($_GET)?>"
						   class="dropdown-toggle">
							IperAccessibile
						</a>
					</li>

					<li class="dropdown">
						<a href="<?=$percorso_relativo?>contact.php" class="dropdown-toggle">Credits</a>
					</li>
				</ul>
			</div>
		</div>
	</header>
</div>

<!-- NOTE: Fine della navbar dell'ente -->

	<?
//NOTE: FINE - questo serve per non caricare nulla se la pagina è richiesta in modo super accessibile
}

?>