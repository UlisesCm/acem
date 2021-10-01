<?php 
include ("../../seguridad/comprobar_login.php");
require('../Bitacoracontrol.class.php');
$Obitacoracontrol=new Bitacoracontrol;
$mensaje="";
$validacion=true;

if (isset($_POST['fecha'])){
	$fecha=htmlentities(trim($_POST['fecha']));
	//$fecha=mysql_real_escape_string($fecha);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo fecha no es correcto</p>";
}

if (isset($_POST['hora'])){
	$hora=htmlentities(trim($_POST['hora']));
	//$hora=mysql_real_escape_string($hora);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo hora no es correcto</p>";
}

if (isset($_POST['idusuario'])){
	$idusuario=htmlentities(trim($_POST['idusuario']));
	//$idusuario=mysql_real_escape_string($idusuario);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idusuario no es correcto</p>";
}

if (isset($_POST['modulo'])){
	$modulo=htmlentities(trim($_POST['modulo']));
	//$modulo=mysql_real_escape_string($modulo);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo modulo no es correcto</p>";
}

if (isset($_POST['accion'])){
	$accion=htmlentities(trim($_POST['accion']));
	//$accion=mysql_real_escape_string($accion);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo accion no es correcto</p>";
}

if (isset($_POST['descripcion'])){
	$descripcion=htmlentities(trim($_POST['descripcion']));
	//$descripcion=mysql_real_escape_string($descripcion);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo descripcion no es correcto</p>";
}

if (isset($_POST['idregistro'])){
	$idregistro=htmlentities(trim($_POST['idregistro']));
	//$idregistro=mysql_real_escape_string($idregistro);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idregistro no es correcto</p>";
}

if (isset($_POST['tabla'])){
	$tabla=htmlentities(trim($_POST['tabla']));
	//$tabla=mysql_real_escape_string($tabla);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo tabla no es correcto</p>";
}
if($validacion){
	$resultado=$Obitacoracontrol->guardar($fecha,$hora,$idusuario,$modulo,$accion,$descripcion,$idregistro,$tabla);
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