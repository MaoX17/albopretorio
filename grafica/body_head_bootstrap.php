<?php
/**

 * Created by Maurizio Proietti

 * User: maurizio.proietti@gmail.com

 */
?>
<!--
/**
 * Created by Maurizio Proietti
 * User: maurizio.proietti@gmail.com
 */
-->
<body>

<!-- <nav class="navbar navbar-default" role="navigation"> -->
<div class="navbar navbar-default">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <!-- <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> -->
        <button type="button" class="navbar-toggle">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
      	<a class="navbar-brand" href="http://<?=$_SERVER['SERVER_NAME']?>">
			<img alt="Brand" src="/grafica/images/stemma-bar2.gif" height="30" />
		</a>


    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">


		<ul class="nav navbar-nav">
			<li><a href="<?=$percorso_relativo?>index.php" class="list-group-item">Home</a></li>

<!--			<li><a href="<?= $percorso_relativo ?>supporto.php" class="list-group-item">Supporto</a></li> -->

        </ul>
		<ul class="nav navbar-nav navbar-right">
			<li><a href="<?=$percorso_relativo?>admin/index.php" class="list-group-item">Sez. Admin</a></li>
			<!--			<li><a href="<?= $percorso_relativo ?>supporto.php" class="list-group-item">Supporto</a></li> -->

		</ul>
    </div><!-- /.navbar-collapse -->
<!-- </nav> -->
</div>