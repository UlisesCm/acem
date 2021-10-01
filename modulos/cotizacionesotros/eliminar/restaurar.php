<?php 
include ("../../seguridad/comprobar_login.php");
require('../Cotizacionotro.class.php');

$Ocotizacionotro=new Cotizacionotro;
$mensaje="";

if (isset($_REQUEST['ids']) && $_REQUEST['ids'] !="") {
	if($_REQUEST['ids']!="undefined"){
		if(is_array($_REQUEST['ids'])){
			$ids = implode(',', ($_REQUEST['ids']));
		}else{
			$ids=$_REQUEST['ids'];
		}	
		if($resultado=$Ocotizacionotro->cambiarEstatus($ids, "activo")){
			if ($resultado=="denegado"){
				$mensaje="aviso@Acceso denegado@Su cuenta no cuenta con los privilegios para poder realizar esta tarea";
			}else{
				$mensaje="exito@Operaci&oacute;n exitosa@Los registros han sido restaurados";
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