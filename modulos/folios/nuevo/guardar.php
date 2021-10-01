<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
require('../Folio.class.php');
$Ofolio=new Folio;
$mensaje="";
$validacion=true;

if (isset($_POST['serie'])){
	$serie=htmlentities(trim($_POST['serie']));
	//$serie=mysql_real_escape_string($serie);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo serie no es correcto</p>";
}

if (isset($_POST['folioactual'])){
	$folioactual=htmlentities(trim($_POST['folioactual']));
	//$folioactual=mysql_real_escape_string($folioactual);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo folioactual no es correcto</p>";
}

if (isset($_POST['asignacion'])){
	$asignacion=htmlentities(trim($_POST['asignacion']));
	//$asignacion=mysql_real_escape_string($asignacion);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo asignacion no es correcto</p>";
}

if (isset($_POST['idsucursal'])){
	$idsucursal=htmlentities(trim($_POST['idsucursal']));
	//$idsucursal=mysql_real_escape_string($idsucursal);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idsucursal no es correcto</p>";
}

if (isset($_POST['estatus'])){
	$estatus=htmlentities(trim($_POST['estatus']));
	//$estatus=mysql_real_escape_string($estatus);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo estatus no es correcto</p>";
}
if($validacion){
	$resultado=$Ofolio->guardar($serie,$folioactual,$asignacion,$idsucursal,$estatus);
	if($resultado=="exito"){
		
		$mensaje="exito@Operaci&oacute;n exitosa@El registro ha sido guardado";
	}
	if($resultado=="asignacionExiste"){
		$mensaje="fracaso@Operaci&oacute;n fallida@El campo asignacion ya existe en la base de datos";
	}
	if($resultado=="idsucursalExiste"){
		$mensaje="fracaso@Operaci&oacute;n fallida@El campo idsucursal ya existe en la base de datos";
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