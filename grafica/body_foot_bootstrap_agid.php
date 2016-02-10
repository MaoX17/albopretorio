<?
//NOTE: questo serve per non caricare nulla se la pagina è richiesta in modo super accessibile
if ($_SERVER['SCRIPT_NAME'] != "/accessibile.php") {
	?>
	<footer class="panel-footer">
		<p class="has-warning">Si consiglia l'utilizzo di questo sistema con la versione aggiornata di
			<a href="http://www.mozilla.org/it/firefox/new/" class="btn-xs btn-info" target="_blank">Firefox</a>
			o
			<a href="https://www.google.com/intl/it/chrome/browser/" class="btn-xs btn-info" target="_blank">Chrome</a>
		</p>

		<p>In caso di problemi o domande inviare una mail a
			<a class="btn-xs btn-info" href="mailto:<?= urlencode('webmaster@provincia.prato.it') ?>">webmaster@provincia.prato.it</a>
		</p>

		<p>Software rilasciato sotto licenza GNU/GPL</p>

		<p>&copy; Provincia di Prato <a href="http://blog.maurizio.proietti.name">2015</a></p>
	</footer>

	<?php //include_once($percorso_relativo."include/google_analytics.php") ?>

	<script type="text/javascript" src="<?= $percorso_relativo ?>libs/js/jquery/jquery.min.js"></script>
	<script type="text/javascript" src="<?= $percorso_relativo ?>libs/js/jquery/jquery-migrate.min.js"></script>
	<script type="text/javascript" src="<?= $percorso_relativo ?>libs/js/jquery-ui/jquery-ui.min.js"></script>

	<script type="text/javascript"
			src="<?= $percorso_relativo ?>libs/js/agid-bootstrap/dist/js/bootstrap.min.js"></script>

	<script type="text/javascript"
			src="<?= $percorso_relativo ?>libs/js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script type="text/javascript"
			src="<?= $percorso_relativo ?>libs/js/bootstrap-datepicker/js/locales/bootstrap-datepicker.it.js"></script>

	<script type="text/javascript" src="<?= $percorso_relativo ?>include/jscript.js"></script>
	<script type="text/javascript"
			src="<?= $percorso_relativo ?>include/ajax_functions/script_autocomplete.js"></script>


	<script type="text/javascript">

		$('#dt_atto').datepicker({
			format: "yyyy-mm-dd",
			todayBtn: "linked",
			language: "it",
			autoclose: true,
			todayHighlight: true
		});

		$('#dt_atto_dal').datepicker({
			format: "yyyy-mm-dd",
			todayBtn: "linked",
			language: "it",
			autoclose: true,
			todayHighlight: true
		});

		$('#dt_atto_al').datepicker({
			format: "yyyy-mm-dd",
			todayBtn: "linked",
			language: "it",
			autoclose: true,
			todayHighlight: true
		});

		$('#dt_pubbl_dal').datepicker({
			format: "yyyy-mm-dd",
			todayBtn: "linked",
			language: "it",
			autoclose: true,
			todayHighlight: true
		});

		$('#dt_pubbl_al').datepicker({
			format: "yyyy-mm-dd",
			todayBtn: "linked",
			language: "it",
			autoclose: true,
			todayHighlight: true
		});


	</script>

	<?
//NOTE: FINE - questo serve per non caricare nulla se la pagina è richiesta in modo super accessibile
}



?>


</body>
</html>
