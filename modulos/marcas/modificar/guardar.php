<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
require('../Marca.class.php');
$Omarca=new Marca;
$mensaje="";
$validacion=true;

if (isset($_POST['idmarca'])){
	$idmarca=htmlentities(trim($_POST['idmarca']));
	//$idmarca=mysql_real_escape_string($idmarca);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idmarca no es correcto</p>";
}

if (isset($_POST['nombre'])){
	$nombre=htmlentities(trim($_POST['nombre']));
	//$nombre=mysql_real_escape_string($nombre);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo nombre no es correcto</p>";
}

if (isset($_POST['prefijocodigo'])){
	$prefijocodigo=htmlentities(trim($_POST['prefijocodigo']));
	//$prefijocodigo=mysql_real_escape_string($prefijocodigo);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo prefijocodigo no es correcto</p>";
}

if (isset($_POST['estatus'])){
	$estatus=htmlentities(trim($_POST['estatus']));
	//$estatus=mysql_real_escape_string($estatus);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo estatus no es correcto</p>";
}
if($validacion){
	$resultado=$Omarca->actualizar($nombre,$prefijocodigo,$estatus, $idmarca);
	if($resultado=="exito"){
		
		$mensaje="exito@Operaci&oacute;n exitosa@El registro ha sido guardado";
	}
	if($resultado=="nombreExiste"){
		$mensaje="fracaso@Operaci&oacute;n fallida@El campo nombre ya existe en la base de datos";
	}
	if($resultado=="prefijocodigoExiste"){
		$mensaje="fracaso@Operaci&oacute;n fallida@El campo prefijocodigo ya existe en la base de datos";
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