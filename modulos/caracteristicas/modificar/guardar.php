<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
require('../Caracteristica.class.php');
$Ocaracteristica=new Caracteristica;
$mensaje="";
$validacion=true;

if (isset($_POST['idcaracteristica'])){
	$idcaracteristica=htmlentities(trim($_POST['idcaracteristica']));
	//$idcaracteristica=mysql_real_escape_string($idcaracteristica);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idcaracteristica no es correcto</p>";
}

if (isset($_POST['caracteristica'])){
	$caracteristica=htmlentities(trim($_POST['caracteristica']));
	//$caracteristica=mysql_real_escape_string($caracteristica);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo caracteristica no es correcto</p>";
}

if (isset($_POST['valor'])){
	$valor=htmlentities(trim($_POST['valor']));
	//$valor=mysql_real_escape_string($valor);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo valor no es correcto</p>";
}
if($validacion){
	$resultado=$Ocaracteristica->actualizar($caracteristica,$valor, $idcaracteristica);
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