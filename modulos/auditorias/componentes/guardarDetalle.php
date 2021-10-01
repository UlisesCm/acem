<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
require('../Auditoria.class.php');
$Oauditoria=new Auditoria;
$mensaje="";
$validacion=true;



if (isset($_POST['iddetalleauditoria'])){
	$iddetalleauditoria=htmlentities(trim($_POST['iddetalleauditoria']));
	//$nombre=mysql_real_escape_string($nombre);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El iddetalleauditoria iddetalleauditoria no es correcto</p>";
}


if (isset($_POST['conteo'])){
	$conteo=htmlentities(trim($_POST['conteo']));
	//$conteo=mysql_real_escape_string($conteo);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El iddetalleauditoria conteo no es correcto</p>";
}


if($validacion){
	$resultado=$Oauditoria->actualizarDato($iddetalleauditoria,$conteo);
	if($resultado=="exito"){
		$mensaje="exito@Operaci&oacute;n exitosa@El registro ha sido guardado";
	}
	if($resultado=="nombreExiste"){
		$mensaje="fracaso@Operaci&oacute;n fallida@El iddetalleauditoria nombre ya existe en la base de datos";
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