<?php
ini_set('memory_limit','800M');
ini_set('max_execution_time', 360);
ini_set('post_max_size', '30M');
ini_set('upload_max_filesize', '64M');

require('../Listaprecios.class.php');
$Olistaprecios=new Listaprecios;
$mensaje="";
$validacion=true;
$idlistaprecios=$_POST['idlista'];

if (isset($_POST['btnSubmit'])) {
    $uploadfile = $_FILES["uploadImage"]["tmp_name"];
    $folderRuta = "subidas/";
    
    if (! is_writable($folderRuta) || ! is_dir($folderRuta)) {
        echo "error";
        exit();
    }
    if (move_uploaded_file($_FILES["uploadImage"]["tmp_name"], $folderRuta . $_FILES["uploadImage"]["name"])) {
        //echo '<img src="' . $folderRuta . "" . $_FILES["uploadImage"]["name"] . '">';
		$resultadoImportacion=$Olistaprecios->importarArchivo($folderRuta.$_FILES["uploadImage"]["name"],$idlistaprecios);
		if($resultadoImportacion==true){
			echo "exito";
		}else{
			echo "error";
		}
        exit();
    }
}
?>