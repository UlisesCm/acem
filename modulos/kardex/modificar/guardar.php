<?php 
include ("../../seguridad/comprobar_login.php");
require('../Kardex.class.php');
$Okardex=new Kardex;
$mensaje="";
$validacion=true;

if (isset($_POST['idkardex'])){
	$idkardex=htmlentities(trim($_POST['idkardex']));
	//$idkardex=mysql_real_escape_string($idkardex);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idkardex no es correcto</p>";
}

if (isset($_POST['idproducto'])){
	$idproducto=htmlentities(trim($_POST['idproducto']));
	//$idproducto=mysql_real_escape_string($idproducto);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idproducto no es correcto</p>";
}

if (isset($_POST['fechamovimiento'])){
	$fechamovimiento=htmlentities(trim($_POST['fechamovimiento']));
	//$fechamovimiento=mysql_real_escape_string($fechamovimiento);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo fechamovimiento no es correcto</p>";
}

if (isset($_POST['descripcion'])){
	$descripcion=htmlentities(trim($_POST['descripcion']));
	//$descripcion=mysql_real_escape_string($descripcion);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo descripcion no es correcto</p>";
}

if (isset($_POST['observaciones'])){
	$observaciones=htmlentities(trim($_POST['observaciones']));
	//$observaciones=mysql_real_escape_string($observaciones);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo observaciones no es correcto</p>";
}

if (isset($_POST['entrada'])){
	$entrada=htmlentities(trim($_POST['entrada']));
	//$entrada=mysql_real_escape_string($entrada);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo entrada no es correcto</p>";
}

if (isset($_POST['salida'])){
	$salida=htmlentities(trim($_POST['salida']));
	//$salida=mysql_real_escape_string($salida);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo salida no es correcto</p>";
}

if (isset($_POST['existencia'])){
	$existencia=htmlentities(trim($_POST['existencia']));
	//$existencia=mysql_real_escape_string($existencia);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo existencia no es correcto</p>";
}

if (isset($_POST['costounitario'])){
	$costounitario=htmlentities(trim($_POST['costounitario']));
	//$costounitario=mysql_real_escape_string($costounitario);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo costounitario no es correcto</p>";
}

if (isset($_POST['promedio'])){
	$promedio=htmlentities(trim($_POST['promedio']));
	//$promedio=mysql_real_escape_string($promedio);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo promedio no es correcto</p>";
}

if (isset($_POST['debe'])){
	$debe=htmlentities(trim($_POST['debe']));
	//$debe=mysql_real_escape_string($debe);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo debe no es correcto</p>";
}

if (isset($_POST['haber'])){
	$haber=htmlentities(trim($_POST['haber']));
	//$haber=mysql_real_escape_string($haber);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo haber no es correcto</p>";
}

if (isset($_POST['saldo'])){
	$saldo=htmlentities(trim($_POST['saldo']));
	//$saldo=mysql_real_escape_string($saldo);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo saldo no es correcto</p>";
}

if (isset($_POST['idalmacen'])){
	$idalmacen=htmlentities(trim($_POST['idalmacen']));
	//$idalmacen=mysql_real_escape_string($idalmacen);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idalmacen no es correcto</p>";
}

if (isset($_POST['idmovimiento'])){
	$idmovimiento=htmlentities(trim($_POST['idmovimiento']));
	//$idmovimiento=mysql_real_escape_string($idmovimiento);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idmovimiento no es correcto</p>";
}

if (isset($_POST['idreferencia'])){
	$idreferencia=htmlentities(trim($_POST['idreferencia']));
	//$idreferencia=mysql_real_escape_string($idreferencia);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idreferencia no es correcto</p>";
}

if (isset($_POST['estatus'])){
	$estatus=htmlentities(trim($_POST['estatus']));
	//$estatus=mysql_real_escape_string($estatus);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo estatus no es correcto</p>";
}
if($validacion){
	$resultado=$Okardex->actualizar($idproducto,$fechamovimiento,$descripcion,$observaciones,$entrada,$salida,$existencia,$costounitario,$promedio,$debe,$haber,$saldo,$idalmacen,$idmovimiento,$idreferencia,$estatus, $idkardex);
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