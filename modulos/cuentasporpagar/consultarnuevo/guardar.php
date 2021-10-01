<?php 
include ("../../seguridad/comprobar_login.php");
require('../Gasto.class.php');
$Ogasto=new Gasto;
$mensaje="";
$validacion=true;

if (isset($_POST['listaSalida']) && $_POST['listaSalida']!=""){
	$listaSalida=trim($_POST['listaSalida']);
	$listaSalida= substr($listaSalida, 0, -3);
	$listaSalida=explode(":::",$listaSalida);
}else{
	$listaSalida ="0";//no guardar nada
}

if (isset($_POST['listaSalidaGastos']) && $_POST['listaSalidaGastos']!=""){
	$listaSalidaGastos=trim($_POST['listaSalidaGastos']);
	$listaSalidaGastos= substr($listaSalidaGastos, 0, -3);
	$listaSalidaGastos=explode(":::",$listaSalidaGastos);
}else{
	$listaSalidaGastos ="0";//no guardar nada
}

if($listaSalida=="0" && $listaSalidaGastos=="0"){
	$validacion=false;
	$mensaje=$mensaje."<p>Es necesario que seleccione al menos un pago</p>";
}

if($validacion){
	$resultado=$Ogasto->actualizar($listaSalida,$listaSalidaGastos);
	if($resultado=="exito"){
		
		$mensaje="exito@Operaci&oacute;n exitosa@El registro ha sido guardado";
	}
	if($resultado=="fracaso"){
		$mensaje="fracaso@Operaci&oacute;n fallida@Ha ocurrido un problema en la base de datos [001]";
	}
	if($resultado=="denegado"){
		$mensaje="aviso@Acceso denegado@Su cuenta no cuenta con los privilegios para poder realizar esta tarea";
	}
}else{
	$mensaje="fracaso@Operaci&oacute;n fallida@ $mensaje";
}

echo utf8_encode($mensaje);

?>