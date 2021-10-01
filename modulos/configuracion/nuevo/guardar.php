<?php 
include ("../../seguridad/comprobar_login.php");
require('../Configuracion.class.php');
$Oconfiguracion=new Configuracion;
$mensaje="";
$validacion=true;

if (isset($_POST['cabeceraimpresion'])){
	$cabeceraimpresion=htmlentities(trim($_POST['cabeceraimpresion']));
	$cabeceraimpresion=trim($cabeceraimpresion);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo cabeceraimpresion no es correcto</p>";
}

if (isset($_POST['pieimpresion'])){
	$pieimpresion=htmlentities(trim($_POST['pieimpresion']));
	$pieimpresion=trim($pieimpresion);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo pieimpresion no es correcto</p>";
}

if (isset($_POST['separadorimpresion'])){
	$separadorimpresion=htmlentities(trim($_POST['separadorimpresion']));
	$separadorimpresion=trim($separadorimpresion);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo separadorimpresion no es correcto</p>";
}
if (isset($_POST['descripcioncompletaimpresion'])){
	$descripcioncompletaimpresion=htmlentities(trim($_POST['descripcioncompletaimpresion']));
	$descripcioncompletaimpresion=trim($descripcioncompletaimpresion);
}else{
	$descripcioncompletaimpresion='no';
}
	
if($validacion){
	$resultado=$Oconfiguracion->guardar($cabeceraimpresion,$pieimpresion,$separadorimpresion,$descripcioncompletaimpresion);
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