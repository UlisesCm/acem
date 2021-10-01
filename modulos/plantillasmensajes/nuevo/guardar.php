<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
require('../Plantillamensaje.class.php');
$Oplantillamensaje=new Plantillamensaje;
$mensaje="";
$validacion=true;

if (isset($_POST['titulo'])){
	$titulo=htmlentities(trim($_POST['titulo']));
	//$titulo=mysql_real_escape_string($titulo);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo titulo no es correcto</p>";
}

if (isset($_POST['asunto'])){
	$asunto=htmlentities(trim($_POST['asunto']));
	//$asunto=mysql_real_escape_string($asunto);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo asunto no es correcto</p>";
}

if (isset($_POST['mensaje'])){
	$mensaje=htmlentities(trim($_POST['mensaje']));
	//$mensaje=mysql_real_escape_string($mensaje);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo mensaje no es correcto</p>";
}
if($validacion){
	$resultado=$Oplantillamensaje->guardar($titulo,$asunto,$mensaje);
	if($resultado=="exito"){
		
		$mensaje="exito@Operaci&oacute;n exitosa@El registro ha sido guardado";
	}
	if($resultado=="tituloExiste"){
		$mensaje="fracaso@Operaci&oacute;n fallida@El campo titulo ya existe en la base de datos";
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