<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
require('../Listaprecios.class.php');
$Olistaprecios=new Listaprecios;
$mensaje="";
$validacion=true;

if (isset($_POST['idlistaprecios'])){
	$idlistaprecios=htmlentities(trim($_POST['idlistaprecios']));
	//$idlistaprecios=mysql_real_escape_string($idlistaprecios);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idlistaprecios no es correcto</p>";
}


if($validacion){
	$resultado=$Olistaprecios->sincronizar($idlistaprecios);
	if($resultado=="exito"){
		$mensaje="exito@Operaci&oacute;n exitosa@El registro ha sido guardado";
	}
	if($resultado=="nombreExiste"){
		$mensaje="fracaso@Operaci&oacute;n fallida@El campo nombre ya existe en la base de datos";
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