<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
require('../Cotizacionproducto.class.php');
$Ocotizacionproducto=new Cotizacionproducto;

$mensaje="";
$validacion=true;

	
if (isset($_POST['idruta'])){
	$idruta=htmlentities(trim($_POST['idruta']));
	//$idgirocomercial=mysql_real_escape_string($idgirocomercial);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idruta no es correcto</p>";
}

if (isset($_POST['autorizacion'])){
	$autorizacion=htmlentities(trim($_POST['autorizacion']));
	if($autorizacion =="AUTORIZADA"){
		$validacion=false;
		$mensaje=$mensaje."<p>La ruta ya fue autorizada por salidas, no se permite cancelar</p>";
	}
}

if($validacion){
	//Guardar cotización de productos
	$resultado=$Ocotizacionproducto->cancelarRuta($idruta);
	if($resultado=="exito"){
		
		$mensaje="exito@Operaci&oacute;n exitosa@El registro ha sido guardado";
	}
	if($resultado=="idcotizacionproductoExiste"){
		$mensaje="fracaso@Operaci&oacute;n fallida@El campo idcotizacionproducto ya existe en la base de datos";
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