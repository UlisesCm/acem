<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
require('../Cuentasbancarias.class.php');
$Ocuentasbancarias=new Cuentasbancarias;
$mensaje="";
$validacion=true;

if (isset($_POST['cuenta'])){
	$cuenta=htmlentities(trim($_POST['cuenta']));
	//$cuenta=mysql_real_escape_string($cuenta);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo cuenta no es correcto</p>";
}

if (isset($_POST['banco'])){
	$banco=htmlentities(trim($_POST['banco']));
	//$banco=mysql_real_escape_string($banco);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo banco no es correcto</p>";
}

if (isset($_POST['saldo'])){
	$saldo=htmlentities(trim($_POST['saldo']));
	//$saldo=mysql_real_escape_string($saldo);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo saldo no es correcto</p>";
}

if (isset($_POST['estatus'])){
	$estatus=htmlentities(trim($_POST['estatus']));
	//$estatus=mysql_real_escape_string($estatus);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo estatus no es correcto</p>";
}
if($validacion){
	$resultado=$Ocuentasbancarias->guardar($cuenta,$banco,$saldo,$estatus);
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