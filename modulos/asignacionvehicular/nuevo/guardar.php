<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
require('../Asignacionvehicular.class.php');
$Oasignacionvehicular=new Asignacionvehicular;
$mensaje="";
$validacion=true;

if (isset($_POST['fecha'])){
	$fecha=htmlentities(trim($_POST['fecha']));
	//$fecha=mysql_real_escape_string($fecha);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo fecha no es correcto</p>";
}

if (isset($_POST['idempleado'])){
	$idempleado=htmlentities(trim($_POST['idempleado']));
	//$idempleado=mysql_real_escape_string($idempleado);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idempleado no es correcto</p>";
}

if (isset($_POST['idvehiculo'])){
	$idvehiculo=htmlentities(trim($_POST['idvehiculo']));
	//$idvehiculo=mysql_real_escape_string($idvehiculo);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idvehiculo no es correcto</p>";
}

if (isset($_POST['observaciones'])){
	$observaciones=htmlentities(trim($_POST['observaciones']));
	//$observaciones=mysql_real_escape_string($observaciones);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo observaciones no es correcto</p>";
}
if($validacion){
	$resultado=$Oasignacionvehicular->guardar($fecha,$idempleado,$idvehiculo,$observaciones);
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