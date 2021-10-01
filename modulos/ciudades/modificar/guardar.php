<?php 
include ("../../seguridad/comprobar_login.php");
require('../Ciudad.class.php');
$Ociudad=new Ciudad;
$mensaje="";
$validacion=true;

if (isset($_POST['idciudad'])){
	$idciudad=htmlentities(trim($_POST['idciudad']));
	//$idciudad=mysql_real_escape_string($idciudad);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idciudad no es correcto</p>";
}

if (isset($_POST['nombre'])){
	$nombre=htmlentities(trim($_POST['nombre']));
	//$nombre=mysql_real_escape_string($nombre);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo nombre no es correcto</p>";
}

if (isset($_POST['idestado'])){
	$idestado=htmlentities(trim($_POST['idestado']));
	//$idestado=mysql_real_escape_string($idestado);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idestado no es correcto</p>";
}
if($validacion){
	$resultado=$Ociudad->actualizar($nombre,$idestado, $idciudad);
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