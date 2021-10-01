<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
/*CARGA DE ARCHIVOS*/
include_once('../../../librerias/php/thumb.php');
require('../Usuario.class.php');
$Ousuario=new Usuario;
$mensaje="";
$validacion=true;

if (isset($_POST['idusuario'])){
	$idusuario=htmlentities(trim($_POST['idusuario']));
	//$idusuario=mysql_real_escape_string($idusuario);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idusuario no es correcto</p>";
}

if (isset($_POST['contrasena'])){
	$contrasena1=htmlentities(trim($_POST['contrasena']));
	$contrasena1=md5($contrasena1);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo contrase&ntilde;a no es correcto</p>";
}

if (isset($_POST['contrasena2'])){
	$contrasena2=htmlentities(trim($_POST['contrasena2']));
	$contrasena2=md5($contrasena2);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo contrase&ntilde;a no es correcto</p>";
}


	
if($validacion){
	$resultado=$Ousuario->modificarContrasena($contrasena1,$contrasena2,$idusuario);
	if($resultado=="exito"){
		$mensaje="exito@Operaci&oacute;n exitosa@El registro ha sido guardado";
	}
	if($resultado=="usuarioExiste"){
		$mensaje="fracaso@Operaci&oacute;n fallida@El campo usuario ya existe en la base de datos";
	}
	if($resultado=="fracaso"){
		$mensaje="fracaso@Operaci&oacute;n fallida@Ha ocurrido un problema en la base de datos [001]";
	}
	if($resultado=="denegado"){
		$mensaje="aviso@Acceso denegado@Su cuenta no cuenta con los privilegios para poder realizar esta tarea";
	}
	if($resultado=="errorCoincidencia"){
		$mensaje="aviso@No es posible cambiar la contrase&ntilde;a@Su contrase&ntilde;a actual es incorrecta";
	}
}else{
	$mensaje="fracaso@Operaci&oacute;n fallida@ $mensaje";
}

echo utf8_encode($mensaje);

?>