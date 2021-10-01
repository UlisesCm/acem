<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
require('../Categoria.class.php');
$Ocategoria=new Categoria;
$mensaje="";
$validacion=true;

if (isset($_POST['idcategoria'])){
	$idcategoria=htmlentities(trim($_POST['idcategoria']));
	//$idcategoria=mysql_real_escape_string($idcategoria);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idcategoria no es correcto</p>";
}

if (isset($_POST['codigo'])){
	$codigo=htmlentities(trim($_POST['codigo']));
	//$codigo=mysql_real_escape_string($codigo);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo codigo no es correcto</p>";
}

if (isset($_POST['nombre'])){
	$nombre=htmlentities(trim($_POST['nombre']));
	//$nombre=mysql_real_escape_string($nombre);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo nombre no es correcto</p>";
}

if (isset($_POST['estatus'])){
	$estatus=htmlentities(trim($_POST['estatus']));
	//$estatus=mysql_real_escape_string($estatus);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo estatus no es correcto</p>";
}
if($validacion){
	$resultado=$Ocategoria->actualizar($codigo,$nombre,$estatus, $idcategoria);
	if($resultado=="exito"){
		
		$mensaje="exito@Operaci&oacute;n exitosa@El registro ha sido guardado";
	}
	if($resultado=="codigoExiste"){
		$mensaje="fracaso@Operaci&oacute;n fallida@El campo codigo ya existe en la base de datos";
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