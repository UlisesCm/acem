<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
require('../Cuentasecundaria.class.php');
$Ocuentasecundaria=new Cuentasecundaria;
$mensaje="";
$validacion=true;

if (isset($_POST['idcuentasecundaria'])){
	$idcuentasecundaria=htmlentities(trim($_POST['idcuentasecundaria']));
	//$idcuentasecundaria=mysql_real_escape_string($idcuentasecundaria);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idcuentasecundaria no es correcto</p>";
}

if (isset($_POST['nombre'])){
	$nombre=htmlentities(trim($_POST['nombre']));
	//$nombre=mysql_real_escape_string($nombre);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo nombre no es correcto</p>";
}

if (isset($_POST['idcuentaprincipal'])){
	$idcuentaprincipal=htmlentities(trim($_POST['idcuentaprincipal']));
	//$idcuentaprincipal=mysql_real_escape_string($idcuentaprincipal);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idcuentaprincipal no es correcto</p>";
}

if (isset($_POST['estatus'])){
	$estatus=htmlentities(trim($_POST['estatus']));
	//$estatus=mysql_real_escape_string($estatus);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo estatus no es correcto</p>";
}
if($validacion){
	$resultado=$Ocuentasecundaria->actualizar($nombre,$idcuentaprincipal,$estatus, $idcuentasecundaria);
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