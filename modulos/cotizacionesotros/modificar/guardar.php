<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
require('../Cotizacionotro.class.php');
$Ocotizacionotro=new Cotizacionotro;
$mensaje="";
$validacion=true;

if (isset($_POST['idcotizacionesotros'])){
	$idcotizacionesotros=htmlentities(trim($_POST['idcotizacionesotros']));
	//$idcotizacionesotros=mysql_real_escape_string($idcotizacionesotros);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idcotizacionesotros no es correcto</p>";
}

if (isset($_POST['serie'])){
	$serie=htmlentities(trim($_POST['serie']));
	//$serie=mysql_real_escape_string($serie);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo serie no es correcto</p>";
}

if (isset($_POST['folio'])){
	$folio=htmlentities(trim($_POST['folio']));
	//$folio=mysql_real_escape_string($folio);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo folio no es correcto</p>";
}

if (isset($_POST['fecha'])){
	$fecha=htmlentities(trim($_POST['fecha']));
	//$fecha=mysql_real_escape_string($fecha);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo fecha no es correcto</p>";
}

if (isset($_POST['tipo'])){
	$tipo=htmlentities(trim($_POST['tipo']));
	//$tipo=mysql_real_escape_string($tipo);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo tipo no es correcto</p>";
}

if (isset($_POST['monto'])){
	$monto=htmlentities(trim($_POST['monto']));
	//$monto=mysql_real_escape_string($monto);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo monto no es correcto</p>";
}

if (isset($_POST['idcliente'])){
	$idcliente=htmlentities(trim($_POST['idcliente']));
	//$idcliente=mysql_real_escape_string($idcliente);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idcliente no es correcto</p>";
}

if (isset($_POST['idsucursal'])){
	$idsucursal=htmlentities(trim($_POST['idsucursal']));
	//$idsucursal=mysql_real_escape_string($idsucursal);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idsucursal no es correcto</p>";
}

if (isset($_POST['idempleado'])){
	$idempleado=htmlentities(trim($_POST['idempleado']));
	//$idempleado=mysql_real_escape_string($idempleado);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idempleado no es correcto</p>";
}

if (isset($_POST['observaciones'])){
	$observaciones=htmlentities(trim($_POST['observaciones']));
	//$observaciones=mysql_real_escape_string($observaciones);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo observaciones no es correcto</p>";
}

if (isset($_POST['estatus'])){
	$estatus=htmlentities(trim($_POST['estatus']));
	//$estatus=mysql_real_escape_string($estatus);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo estatus no es correcto</p>";
}
if($validacion){
	$resultado=$Ocotizacionotro->actualizar($serie,$folio,$fecha,$tipo,$monto,$idcliente,$idsucursal,$idempleado,$observaciones,$estatus, $idcotizacionesotros);
	if($resultado=="exito"){
		
		$mensaje="exito@Operaci&oacute;n exitosa@El registro ha sido guardado";
	}
	if($resultado=="idcotizacionesotrosExiste"){
		$mensaje="fracaso@Operaci&oacute;n fallida@El campo idcotizacionesotros ya existe en la base de datos";
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