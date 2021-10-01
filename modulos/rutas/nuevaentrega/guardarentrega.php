<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
require('../Cotizacionproducto.class.php');
$Ocotizacionproducto=new Cotizacionproducto;

$mensaje="";
$validacion=true;

	
if (isset($_POST['idcotizacionproducto'])){
	$idcotizacionproducto=htmlentities(trim($_POST['idcotizacionproducto']));
	//$idgirocomercial=mysql_real_escape_string($idgirocomercial);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idcotizacionproducto no es correcto</p>";
}
	
if (isset($_POST['observacionesentrega'])){
	$observacionesentrega=htmlentities(trim($_POST['observacionesentrega']));
	//$idgirocomercial=mysql_real_escape_string($idgirocomercial);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo observacionesentrega no es correcto</p>";
}

if($validacion){
	//Guardar cotización de productos
	$resultado=$Ocotizacionproducto->actualizarentrega($idcotizacionproducto,$observacionesentrega);
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