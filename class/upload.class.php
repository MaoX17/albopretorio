<?
///////////////////////////////////////
//multi-files upload class
//author:paul.ren 
//e-mail:rsr_cn@yahoo.com.cn
//website:www.yawill.com
//create:2004-6-22 09:56
//modify:
////////////////////////////////////////

class ClsUpload{
	var $max_upload_size = "20000000";	//max upload file byte (20M)
	//var $max_upload_size = "1048576";	//max upload file byte (1M)
	var $_FILES = "";			//post files
	var $overwrite = "1";		//is over write
	var $mode = 0777;			//upload file mode
	var $results = array();		//uploaded files results
	var $file_type_ok = array("application/pdf", "application/pkcs7-mime", "application/x-pkcs7-mime");  //file type accettato x upload
	var $path_class = "class/"; 	//percorso assoluto delle classi
	var $path_class_pdfconcat = "class/pdfConcat.php";
	var $path_pie_pagina = "../files/piepagina_x_albo.pdf";
	var $filename_pie_pagina = "piepagina_x_albo.pdf";
	
	var $error  = "";
	
	function ClsUpload(){
		global $_FILES;
		$this->_FILES = $_FILES;
	}

	function controllaPresenzaFiles($field){
		// controllo che i file sia/siano inseriti
		$result = false;
		$field_names = $this->_FILES[$field]['name'];
		// variabili indice
		$i=0;
		$ok = 0;
		//Se ho uploadato PIU files
		if(is_array($field_names)){	
			while(list($key,$file_name)=each($field_names)){
				if(!$file_name) continue;
				$i++; 
			}
			// se ho almeno 1 file
			if ($i > 0) {
				$result = true;
			}
			
		}
		//altrimenti se ho uploadato SOLO un file
		else {
			$formato_type = $this->_FILES[$field]['type'];
			if ($formato_type != ""){
				$result = true;
			}
		}
		return $result;
	}
	
	
	function controllaFormato($field){
		// controllo che il file sia in formato PDF e ritorno true se tutto ok
		$result = false;
		$field_names = $this->_FILES[$field]['name'];
		// variabili indice
		$i=0;
		$ok = 0;
		//Se ho uploadato PIU files
		if(is_array($field_names)){
			
			while(list($key,$file_name)=each($field_names)){
				if(!$file_name) continue;
				$i++;
				$formato_type = $this->_FILES[$field]['type'][$key];
				if (in_array($formato_type, $this->file_type_ok)) {
				//if ($formato_type == $this->file_type_ok){
					$ok++; 
				}
			}
			// se tutti i file hanno formato PDF o P7M
			
			if ($i == $ok) {
				$result = true;
			}
			else {
				die("Errore - Formato file non valido, è permesso solo il formato pdf e p7m");
			}
		}
		//altrimenti se ho uploadato SOLO un file
		else {
			$formato_type = $this->_FILES[$field]['type'];
			if (in_array(strtolower($formato_type), $this->file_type_ok)) {
			//if (strtolower($formato_type) == $this->file_type_ok){
				$result = true;
			}
			else {
				die("Errore - Formato file non valido, è permesso solo il formato pdf e p7m");
			}
		}
		return $result;
	}

	
	function salva_e_concatena($field,$dir,$filename_finale){
		
		$field_names = $this->_FILES[$field]['name'];
		
		//ATTENZIONE AL PERCORSO DELLA CLASSE
		require_once ($this->path_class_pdfconcat);
		$pdf =& new concat_pdf();
		$res = array();
		$i = 0;
		
		if(is_array($field_names)){
			
			while(list($key,$file_name)=each($field_names)){
				if(!$file_name) continue;
				$tmp_file = $this->_FILES[$field]['tmp_name'][$key];
				$file_name = strtolower($file_name);
				$file_name = $i.".pdf";
				$file_size = $this->_FILES[$field]['size'][$key];
				if($file_size>0 && $file_size<=$this->max_upload_size){
					$isok = $this->uploadfile($tmp_file,"$dir/$file_name");
				}else if($file_size>$this->max_upload_size){
					$this->error .= "$file_name:file size exceeds max file size: $this->max_upload_size<br>";
				}else $this->error .= "$file_name:File size is 0 bytes<br>";
				if($isok) $this->results[] = array($file_name=>"$dir/$file_name");
				if($isok) array_push($res, "$dir/$file_name");
				
				$i++;
			}
			
		}
		//Altrimenti se ho uploadato 1 FILE...
		else {
			$tmp_file = $this->_FILES[$field]['tmp_name'];
			$file_name = strtolower($file_name);
			$file_name = $i.".pdf";
			$file_size = $this->_FILES[$field]['size'];
			if($file_size>0 && $file_size<=$this->max_upload_size){
				$isok = $this->uploadfile($tmp_file,"$dir/$file_name");
			}
			else if($file_size>$this->max_upload_size){
				$this->error .= "$file_name:file size exceeds max file size: $this->max_upload_size<br>";
			}
			else $this->error .= "$file_name:File size is 0 bytes<br>";
			if($isok) $this->results[] = array($file_name=>"$dir/$file_name");
			if($isok) array_push($res, "$dir/$file_name");
				
				$i++;
				
		}
		
		//copio piepagina in concatena/
		@copy($this->path_pie_pagina,"$dir/$this->filename_pie_pagina") or $this->error .= "unable to upload $srcfile to $dstfile<br>";
		array_push($res, "$dir/$this->filename_pie_pagina");
				
		// Concateno tutto e rinomino

		$pdf->setFiles($res);
		$pdf->concat();
		//$pdf->Output("../files/concatena/out.pdf", "F");
		$pdf->Output($filename_finale, "F");
		
		foreach ($res as &$value) {
    		@unlink($value);
		}
		
		
		return $isok;
	}


	//funzione ripresa da salva_e_concatena a cui ho tolto la parte di concatenzazione
	//quindi fa l'upload di + di 1 file
	function uploadfiles($field,$dir,$filename_finale){
		
		$field_names = $this->_FILES[$field]['name'];
		
		//ATTENZIONE AL PERCORSO DELLA CLASSE
		require_once ($this->path_class_pdfconcat);
		$pdf =& new concat_pdf();
		$res = array();
		$i = 0;
		
		if(is_array($field_names)){
			
			while(list($key,$file_name)=each($field_names)){
				if(!$file_name) continue;
				$tmp_file = $this->_FILES[$field]['tmp_name'][$key];
				$file_name = strtolower($file_name);
				$ext = substr(strrchr($file_name, '.'), 1);
				$file_name = $filename_finale."-".$i.".".$ext;
				$file_size = $this->_FILES[$field]['size'][$key];
				if($file_size>0 && $file_size<=$this->max_upload_size){
					$isok = $this->uploadfile($tmp_file,"$dir/$file_name");
				}else if($file_size>$this->max_upload_size){
					$this->error .= "$file_name:file size exceeds max file size: $this->max_upload_size<br>";
				}else $this->error .= "$file_name:File size is 0 bytes<br>";
				if($isok) $this->results[] = array($file_name=>"$dir/$file_name");
				if($isok) array_push($res, "$file_name");
				
				$i++;
			}
			
		}
		//Altrimenti se ho uploadato 1 FILE...
		else {
			$tmp_file = $this->_FILES[$field]['tmp_name'];
			$file_name = strtolower($file_name);
			$file_name = $filename_finale."-".$i.".pdf";
			$file_size = $this->_FILES[$field]['size'];
			if($file_size>0 && $file_size<=$this->max_upload_size){
				$isok = $this->uploadfile($tmp_file,"$dir/$file_name");
			}
			else if($file_size>$this->max_upload_size){
				$this->error .= "$file_name:file size exceeds max file size: $this->max_upload_size<br>";
			}
			else $this->error .= "$file_name:File size is 0 bytes<br>";
			if($isok) $this->results[] = array($file_name=>"$dir/$file_name");
			if($isok) array_push($res, "$dir/$file_name");
				
				$i++;
				
		}
		
		foreach ($res as &$value) {
    		@unlink($value);
		}
		
		
		return $res;
	}
	
	
	function uploadfile($srcfile,$dstfile){
		if(is_file($dstfile)){
			if($this->overwrite){
				@unlink($dstfile) or $this->error .= "unable to overwrite $dstfile<br>";
			}else return 1;
		}
		//@copy($srcfile,$dstfile) or $this->error .= "unable to upload $srcfile to $dstfile<br>";
		move_uploaded_file($srcfile,$dstfile) or $this->error .= "unable to upload $srcfile to $dstfile<br>";
		$isok = @chmod($dstfile,$this->mode) or $this->error .= is_file($dstfile)."change permissions for:$dstfile<br>";
		return $isok;
	}
	
	function rinomina($srcfile,$dstfile){
		if(is_file($dstfile)){
			if($this->overwrite){
				@unlink($dstfile) or $this->error .= "unable to overwrite $dstfile<br>";
			}else return 1;
		}
		if(is_file($srcfile)){
			@rename($srcfile,$dstfile) or $this->error .= "unable to overwrite $dstfile<br>";
		}
		$isok = @chmod($dstfile,$this->mode) or $this->error .= is_file($dstfile)."change permissions for:$dstfile<br>";
		return $isok;
	}	

	function elimina($file){
		if(is_file($file)){
			if($this->overwrite){
				@unlink($file) or $this->error .= "unable to overwrite $dstfile<br>";
			}else return 1;
		}
		return 0;
	}	
	
	
	
	function p($data){
		echo "<pre>";
		//print_r($data);
		echo "</pre>";
	}
}

?>