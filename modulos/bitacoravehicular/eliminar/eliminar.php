<?php 
include ("../../seguridad/comprobar_login.php");
require('../Bitacoravehicular.class.php');

$Obitacoravehicular=new Bitacoravehicular;
$mensaje="";

if (isset($_REQUEST['ids']) && $_REQUEST['ids'] !="") {
	if($_REQUEST['ids']!="undefined"){
		if(is_array($_REQUEST['ids'])){
			$ids = implode(',', ($_REQUEST['ids']));
		}else{
			$ids=$_REQUEST['ids'];
		}	
		if($resultado=$Obitacoravehicular->eliminar($ids, "falsa")){
			if ($resultado=="denegado"){
				$mensaje="aviso@Acceso denegado@Su cuenta no cuenta con los privilegios para poder realizar esta tarea";
			}else{
				$mensaje="exito@Operaci&oacute;n exitosa@Los registos han sido eliminados";
			}
		}else{
			$mensaje="fracaso@Operaci&oacute;n fallida@Ha ocurrido un problema en la base de datos [001]";
		}
		
	}else{
		$mensaje="fracaso@Operaci&oacute;n fallida@Ha ocurrido un problema la transmisión de datos[002]";
	}
}else{
	$mensaje="aviso@Operaci&oacute;n fallida@No se ha seleccionado ning&uacute;n registro";
}

echo utf8_encode($mensaje);
?>
