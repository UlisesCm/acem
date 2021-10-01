<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
require('../Listaprecios.class.php');
$Olistaprecios=new Listaprecios;
$mensaje="";
$validacion=true;
sleep(2);

if (isset($_POST['idfamilia'])){
	$idfamilia=htmlentities(trim($_POST['idfamilia']));
	//$idfamilia=mysql_real_escape_string($idfamilia);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idfamilia no es correcto</p>";
}

if (isset($_POST['porcentaje'])){
	$porcentaje=htmlentities(trim($_POST['porcentaje']));
	//$porcentaje=mysql_real_escape_string($porcentaje);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo porcentaje no es correcto</p>";
}

if (isset($_POST['idlista'])){
	$idlista=htmlentities(trim($_POST['idlista']));
	//$idlista=mysql_real_escape_string($idlista);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idlista no es correcto</p>";
}


if($validacion){
	$resultado=$Olistaprecios->actualizarPrecios($idfamilia,$porcentaje, $idlista);
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