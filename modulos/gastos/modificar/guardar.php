<?php 
include ("../../seguridad/comprobar_login.php");
require('../Gasto.class.php');
$Ogasto=new Gasto;
$mensaje="";
$validacion=true;

if (isset($_POST['idgasto'])){
	$idgasto=htmlentities(trim($_POST['idgasto']));
	//$idgasto=mysql_real_escape_string($idgasto);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idgasto no es correcto</p>";
}

if (isset($_POST['idcuentaprincipal'])){
	$idcuentaprincipal=htmlentities(trim($_POST['idcuentaprincipal']));
	//$idcuentaprincipal=mysql_real_escape_string($idcuentaprincipal);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idcuentaprincipal no es correcto</p>";
}

if (isset($_POST['idcuentasecundaria'])){
	$idcuentasecundaria=htmlentities(trim($_POST['idcuentasecundaria']));
	//$idcuentasecundaria=mysql_real_escape_string($idcuentasecundaria);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idcuentasecundaria no es correcto</p>";
}

if (isset($_POST['descripcion'])){
	$descripcion=htmlentities(trim($_POST['descripcion']));
	//$descripcion=mysql_real_escape_string($descripcion);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo descripcion no es correcto</p>";
}

if (isset($_POST['idproveedor'])){
	$idproveedor=htmlentities(trim($_POST['idproveedor']));
	//$idproveedor=mysql_real_escape_string($idproveedor);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idproveedor no es correcto</p>";
}

if (isset($_POST['factura'])){
	$factura=htmlentities(trim($_POST['factura']));
	//$factura=mysql_real_escape_string($factura);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo factura no es correcto</p>";
}

if (isset($_POST['idmodeloimpuestos'])){
	$idmodeloimpuestos=htmlentities(trim($_POST['idmodeloimpuestos']));
	//$idmodeloimpuestos=mysql_real_escape_string($idmodeloimpuestos);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idmodeloimpuestos no es correcto</p>";
}

if (isset($_POST['subtotal'])){
	$subtotal=htmlentities(trim($_POST['subtotal']));
	//$subtotal=mysql_real_escape_string($subtotal);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo subtotal no es correcto</p>";
}

if (isset($_POST['impuestos'])){
	$impuestos=htmlentities(trim($_POST['impuestos']));
	//$impuestos=mysql_real_escape_string($impuestos);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo impuestos no es correcto</p>";
}

if (isset($_POST['total'])){
	$total=htmlentities(trim($_POST['total']));
	//$total=mysql_real_escape_string($total);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo total no es correcto</p>";
}

if (isset($_POST['idretiro'])){
	$idretiro=htmlentities(trim($_POST['idretiro']));
	//$idretiro=mysql_real_escape_string($idretiro);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idretiro no es correcto</p>";
}

if (isset($_POST['estatus'])){
	$estatus=htmlentities(trim($_POST['estatus']));
	//$estatus=mysql_real_escape_string($estatus);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo estatus no es correcto</p>";
}
if($validacion){
	$resultado=$Ogasto->actualizar($idcuentaprincipal,$idcuentasecundaria,$descripcion,$idproveedor,$factura,$idmodeloimpuestos,$subtotal,$impuestos,$total,$idretiro,$estatus, $idgasto);
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