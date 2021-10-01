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

if (isset($_POST['TotalCantidadDevuelta'])){
	$TotalCantidadDevuelta=htmlentities(trim($_POST['TotalCantidadDevuelta']));
	if($TotalCantidadDevuelta==0){
		$validacion=false;
		$mensaje=$mensaje."<p>Es necesario que capture al menos una devolucion</p>";
	}
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo TotalCantidadDevuelta no es correcto</p>";
}

if (isset($_POST['estadoentrega'])){
	$estadoentrega=htmlentities(trim($_POST['estadoentrega']));
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo estadoentrega no es correcto</p>";
}

if (isset($_POST['lista']) && $_POST['lista']!=""){
	$lista=trim($_POST['lista']);
	$lista= substr($lista, 0, -3);
	$lista=explode(":::",$lista);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>Es necesario que capture al menos una devolucion</p>";
}


if($validacion){
	//Guardar cotización de productos
	$resultado=$Ocotizacionproducto->autorizaDevolucion($idcotizacionproducto,$lista,$estadoentrega);
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