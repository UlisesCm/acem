<?php 
include ("../../seguridad/comprobar_login.php");
require('../Retiro.class.php');
$Oretiro=new Retiro;
$mensaje="";
$validacion=true;

if (isset($_POST['idretiro'])){
	$idretiro=htmlentities(trim($_POST['idretiro']));
	//$idretiro=mysql_real_escape_string($idretiro);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idretiro no es correcto</p>";
}

if (isset($_POST['fecha'])){
	$fecha=htmlentities(trim($_POST['fecha']));
	//$fecha=mysql_real_escape_string($fecha);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo fecha no es correcto</p>";
}

if (isset($_POST['descripcion'])){
	$descripcion=htmlentities(trim($_POST['descripcion']));
	//$descripcion=mysql_real_escape_string($descripcion);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo descripcion no es correcto</p>";
}

if (isset($_POST['monto'])){
	$monto=htmlentities(trim($_POST['monto']));
	//$monto=mysql_real_escape_string($monto);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo monto no es correcto</p>";
}

if (isset($_POST['cheque'])){
	$cheque=htmlentities(trim($_POST['cheque']));
	//$cheque=mysql_real_escape_string($cheque);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo cheque no es correcto</p>";
}

if (isset($_POST['idcuenta'])){
	$idcuenta=htmlentities(trim($_POST['idcuenta']));
	//$idcuenta=mysql_real_escape_string($idcuenta);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idcuenta no es correcto</p>";
}

if (isset($_POST['estatus'])){
	$estatus=htmlentities(trim($_POST['estatus']));
	//$estatus=mysql_real_escape_string($estatus);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo estatus no es correcto</p>";
}
if($validacion){
	$resultado=$Oretiro->actualizar($fecha,$descripcion,$monto,$cheque,$idcuenta,$estatus, $idretiro);
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