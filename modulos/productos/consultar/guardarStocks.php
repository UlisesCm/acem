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

if (isset($_POST['idreferencia'])){
	$idreferencia=htmlentities(trim($_POST['idreferencia']));
	//$idreferencia=mysql_real_escape_string($idreferencia);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idreferencia no es correcto</p>";
}

if (isset($_POST['tablareferencia'])){
	$tablareferencia=htmlentities(trim($_POST['tablareferencia']));
	//$tipo=mysql_real_escape_string($tipo);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo tablareferencia no es correcto</p>";
}

if (isset($_POST['periodoinicio'])){
	$periodoinicio=htmlentities(trim($_POST['periodoinicio']));
	//$periodoinicio=mysql_real_escape_string($periodoinicio);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo periodoinicio no es correcto</p>";
}

if (isset($_POST['periodofin'])){
	$periodofin=htmlentities(trim($_POST['periodofin']));
	//$epa=mysql_real_escape_string($epa);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo periodofin no es correcto</p>";
}

if (isset($_POST['stockminimo'])){
	$stockminimo=htmlentities(trim($_POST['stockminimo']));
	//$stockminimo=mysql_real_escape_string($stockminimo);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo stockminimo no es correcto</p>";
}

if (isset($_POST['stockmaximo'])){
	$stockmaximo=htmlentities(trim($_POST['stockmaximo']));
	//$stockmaximo=mysql_real_escape_string($stockmaximo);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo stockmaximo no es correcto</p>";
}


if (isset($_POST['idstock'])){
	$idstock=htmlentities(trim($_POST['idstock']));
	//$stockmaximo=mysql_real_escape_string($stockmaximo);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idstock no es correcto</p>";
}


if($validacion){
	$resultado=$Oproducto->actualizarStock($periodoinicio,$periodofin,$stockminimo,$stockmaximo,$idreferencia,$tablareferencia,$idproducto,$idstock);
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