<?php 
include ("../../seguridad/comprobar_login.php");
require('../Detallecotizacionproducto.class.php');
$Odetallecotizacionproducto=new Detallecotizacionproducto;
$mensaje="";
$validacion=true;

if (isset($_POST['subfolio'])){
	$subfolio=htmlentities(trim($_POST['subfolio']));
	//$subfolio=mysql_real_escape_string($subfolio);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo subfolio no es correcto</p>";
}

if (isset($_POST['idproducto'])){
	$idproducto=htmlentities(trim($_POST['idproducto']));
	//$idproducto=mysql_real_escape_string($idproducto);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idproducto no es correcto</p>";
}

if (isset($_POST['cantidad'])){
	$cantidad=htmlentities(trim($_POST['cantidad']));
	//$cantidad=mysql_real_escape_string($cantidad);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo cantidad no es correcto</p>";
}

if (isset($_POST['costo'])){
	$costo=htmlentities(trim($_POST['costo']));
	//$costo=mysql_real_escape_string($costo);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo costo no es correcto</p>";
}

if (isset($_POST['precio'])){
	$precio=htmlentities(trim($_POST['precio']));
	//$precio=mysql_real_escape_string($precio);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo precio no es correcto</p>";
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

if (isset($_POST['utilidad'])){
	$utilidad=htmlentities(trim($_POST['utilidad']));
	//$utilidad=mysql_real_escape_string($utilidad);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo utilidad no es correcto</p>";
}

if (isset($_POST['idcotizacionproducto'])){
	$idcotizacionproducto=htmlentities(trim($_POST['idcotizacionproducto']));
	//$idcotizacionproducto=mysql_real_escape_string($idcotizacionproducto);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idcotizacionproducto no es correcto</p>";
}

if (isset($_POST['pesounitario'])){
	$pesounitario=htmlentities(trim($_POST['pesounitario']));
	//$pesounitario=mysql_real_escape_string($pesounitario);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo pesounitario no es correcto</p>";
}

if (isset($_POST['cantidadentregada'])){
	$cantidadentregada=htmlentities(trim($_POST['cantidadentregada']));
	//$cantidadentregada=mysql_real_escape_string($cantidadentregada);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo cantidadentregada no es correcto</p>";
}
if($validacion){
	$resultado=$Odetallecotizacionproducto->guardar($subfolio,$idproducto,$cantidad,$costo,$precio,$subtotal,$impuestos,$total,$utilidad,$idcotizacionproducto,$pesounitario,$cantidadentregada);
	if($resultado=="exito"){
		
		$mensaje="exito@Operaci&oacute;n exitosa@El registro ha sido guardado";
	}
	if($resultado=="iddetallecotizacionExiste"){
		$mensaje="fracaso@Operaci&oacute;n fallida@El campo iddetallecotizacion ya existe en la base de datos";
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