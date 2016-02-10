<?
//upload multi-files
require "../class/upload.class.php";
if($_POST[Submit]){
	$upload = new ClsUpload();
	$upload->mult_save("file","../files/concatena");
	$upload->p($upload);
	
	echo "<a href=/files/concatena/out.pdf> SALVAMI </a></br>";
	echo "<a href=index.php> Torna al programma </a>";
	exit(0);
}




?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"  />
<title>upload file</title>
</head>
<body bgcolor="#E5E5E5" text="#000000" link="#006699" vlink="#5493B4">
<form name="form1" method="post" enctype="multipart/form-data" >
Carica i file PDF in ordine. </br>
<input name="file[]" type="file" ><br/>
<input name="file[]" type="file" ><br/>
<input name="file[]" type="file" ><br/>
<input name="file[]" type="file" ><br/>
<input name="file[]" type="file" ><br/>
<input name="file[]" type="file" ><br/>

 
<input type="submit" name="Submit" value="Submit">
</form>
</body>
</html>