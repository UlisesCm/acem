<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
/*CARGA DE ARCHIVOS*/
include_once('../../../librerias/php/thumb.php');
require('../Producto.class.php');
$Oproducto=new Producto;
$mensaje="";
$validacion=true;

if (isset($_POST['idproducto'])){
	$idproducto=htmlentities(trim($_POST['idproducto']));
	//$idproducto=mysql_real_escape_string($idproducto);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idproducto no es correcto</p>";
}

if (isset($_POST['idsucursal'])){
	$idsucursal=htmlentities(trim($_POST['idsucursal']));
	//$idsucursal=mysql_real_escape_string($idsucursal);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idsucursal no es correcto</p>";
}



if($validacion){
	$resultado=$Oproducto->actualizarStock("INDEFINIDO","INDEFINIDO","0","0",$idsucursal,"sucursales",$idproducto,0);
	$resultado=explode("@",$resultado);
	if($resultado[0]=="exito"){
		$mensaje="exito";
	}
	if($resultado[0]=="fracaso"){
		$mensaje="fracaso";
	}
	if($resultado[0]=="denegado"){
		$mensaje="aviso@Acceso denegado@Su cuenta no cuenta con los privilegios para poder realizar esta tarea";
	}
}else{
	$mensaje="fracaso@Operaci&oacute;n fallida@ $mensaje";
}

echo utf8_encode($mensaje);
?>