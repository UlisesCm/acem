<?php 
include ("../../seguridad/comprobar_login.php");
require('../Precios.class.php');
$Oprecios=new Precios;
$mensaje="";
$validacion=true;

if (isset($_POST['idlistaprecios'])){
	$idlistaprecios=htmlentities(trim($_POST['idlistaprecios']));
	//$idlistaprecios=mysql_real_escape_string($idlistaprecios);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idlistaprecios no es correcto</p>";
}

if (isset($_POST['idreferencia'])){
	$idreferencia=htmlentities(trim($_POST['idreferencia']));
	//$idreferencia=mysql_real_escape_string($idreferencia);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idreferencia no es correcto</p>";
}

if (isset($_POST['descripcion'])){
	$descripcion=htmlentities(trim($_POST['descripcion']));
	//$descripcion=mysql_real_escape_string($descripcion);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo descripcion no es correcto</p>";
}

if (isset($_POST['preciopublico'])){
	$preciopublico=htmlentities(trim($_POST['preciopublico']));
	//$preciopublico=mysql_real_escape_string($preciopublico);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo preciopublico no es correcto</p>";
}

if (isset($_POST['comisiongeneral'])){
	$comisiongeneral=htmlentities(trim($_POST['comisiongeneral']));
	//$comisiongeneral=mysql_real_escape_string($comisiongeneral);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo comisiongeneral no es correcto</p>";
}

if (isset($_POST['comisionreferenciado'])){
	$comisionreferenciado=htmlentities(trim($_POST['comisionreferenciado']));
	//$comisionreferenciado=mysql_real_escape_string($comisionreferenciado);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo comisionreferenciado no es correcto</p>";
}

if (isset($_POST['comisionmaster'])){
	$comisionmaster=htmlentities(trim($_POST['comisionmaster']));
	//$comisionmaster=mysql_real_escape_string($comisionmaster);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo comisionmaster no es correcto</p>";
}

if (isset($_POST['precioproveedor'])){
	$precioproveedor=htmlentities(trim($_POST['precioproveedor']));
	//$precioproveedor=mysql_real_escape_string($precioproveedor);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo precioproveedor no es correcto</p>";
}
if($validacion){
	$resultado=$Oprecios->guardar($idlistaprecios,$idreferencia,$descripcion,$preciopublico,$comisiongeneral,$comisionreferenciado,$comisionmaster,$precioproveedor);
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