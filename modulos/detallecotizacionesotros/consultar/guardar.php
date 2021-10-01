<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
require('../Detallecotizacionotro.class.php');
$Odetallecotizacionotros=new Detallecotizacionotro;
$mensaje="";
$validacion=true;



if (isset($_POST['campo'])){
	$campo=htmlentities(trim($_POST['campo']));
	//$nombre=mysql_real_escape_string($nombre);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo campo no es correcto</p>";
}


if (isset($_POST['valor'])){
	$valor=htmlentities(trim($_POST['valor']));
	//$valor=mysql_real_escape_string($valor);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo valor no es correcto</p>";
}

if (isset($_POST['iddetallecotizacionotros'])){
	$iddetallecotizacionotros=htmlentities(trim($_POST['iddetallecotizacionotros']));
	//$idprecio=mysql_real_escape_string($idprecio);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo iddetallecotizacionotros no es correcto</p>";
}

if (isset($_POST['idmodeloimpuestos'])){
	$idmodeloimpuestos=htmlentities(trim($_POST['idmodeloimpuestos']));
	//$idprecio=mysql_real_escape_string($idprecio);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idmodeloimpuestos no es correcto</p>";
}

if (isset($_POST['cantidad'])){
	$cantidad=htmlentities(trim($_POST['cantidad']));
	//$valor=mysql_real_escape_string($valor);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo cantidad no es correcto</p>";
}


if($validacion){
	$resultado=$Odetallecotizacionotros->actualizarDato($campo,$valor,$iddetallecotizacionotros,$idmodeloimpuestos,$cantidad);
	$resultado=explode("@",$resultado);
	if($resultado[0]=="exito"){
		
		$mensaje="exito@Operaci&oacute;n exitosa@El registro ha sido guardado@".$resultado[1]."@".$resultado[2];
	}
	if($resultado[0]=="nombreExiste"){
		$mensaje="fracaso@Operaci&oacute;n fallida@El campo nombre ya existe en la base de datos";
	}
	if($resultado[0]=="fracaso"){
		$mensaje="fracaso@Operaci&oacute;n fallida@Ha ocurrido un problema en la base de datos [001]";
	}
	if($resultado[0]=="denegado"){
		$mensaje="aviso@Acceso denegado@Su cuenta no cuenta con los privilegios para poder realizar esta tarea";
	}
}else{
	$mensaje="fracaso@Operaci&oacute;n fallida@ $mensaje";
}

echo utf8_encode($mensaje);

?>