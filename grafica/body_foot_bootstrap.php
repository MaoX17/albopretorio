
<!-- <footer class="panel-footer"> -->

	<div class="panel-footer">
    	<p>Software realizzato dal CED della Provincia di Prato rilasciato sotto licenza <a href="http://www.gnu.org/licenses/gpl.txt">GNU/GPL</a></p>
   		<!-- <p>&copy; Maurizio Proietti 2015 - 	<a href="http://blog.maurizio.proietti.name">Credits</a> </p> -->
	</div>
<!-- </footer> -->

<?php include_once($percorso_relativo."include/google_analytics.php") ?>

<script src="<?=$percorso_relativo?>libs/js/jquery/jquery.min.js" type="text/javascript"></script>
<script src="<?=$percorso_relativo?>libs/js/jquery/jquery-migrate.min.js" type="text/javascript"></script>

<script type="text/javascript" src="<?=$percorso_relativo?>libs/js/bootstrap/js/bootstrap.min.js"></script>

<script type="text/javascript" src="<?=$percorso_relativo?>libs/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="<?=$percorso_relativo?>libs/js/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.it.js"></script>

<script type="text/javascript">

	jQuery.validator.setDefaults ({
		// debug: true,
		success: "valid"
	});

</script>

<script type='text/javascript'>
	$(document).ready(function(){
		$(".cancella").click(function(){
			if (!confirm("Sei sicuro di voler eseguire la cancellazione? L'OPERAZIONE È IRREVERSIBILE.?")){
				return false;
			}
		});
	});
</script>


<!--
<script type="text/javascript">
    jQuery.validator.setDefaults({
        //	debug: true,
        success: "valid"
    });;
</script>
-->


<script type="text/javascript">

	$(".form_datetime").datetimepicker({
		format: "yyyy-mm-dd",
		pickerPosition: "bottom-right",
		todayBtn: true,
		autoclose: true,
		pickDate: true,
		pickTime: false,
		language: "it",
		minView: 2
	});

</script>

</body>
</html>
