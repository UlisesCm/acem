<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
require('../Facturacion.class.php');
$Ofacturacion=new Facturacion;
$mensaje="";
$validacion=true;

if (isset($_POST['idfactura'])){
	$idfactura=htmlentities(trim($_POST['idfactura']));
	//$idfactura=mysql_real_escape_string($idfactura);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idfactura no es correcto</p>";
}

if (isset($_POST['foliointerno'])){
	$foliointerno=htmlentities(trim($_POST['foliointerno']));
	//$foliointerno=mysql_real_escape_string($foliointerno);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo foliointerno no es correcto</p>";
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

if (isset($_POST['clasificacion'])){
	$clasificacion=htmlentities(trim($_POST['clasificacion']));
	//$clasificacion=mysql_real_escape_string($clasificacion);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo clasificacion no es correcto</p>";
}

if (isset($_POST['emisor'])){
	$emisor=htmlentities(trim($_POST['emisor']));
	//$emisor=mysql_real_escape_string($emisor);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo emisor no es correcto</p>";
}

if (isset($_POST['rfcemisor'])){
	$rfcemisor=htmlentities(trim($_POST['rfcemisor']));
	//$rfcemisor=mysql_real_escape_string($rfcemisor);
		if(!validarRFC($rfcemisor)){
			$validacion=false;
			$mensaje=$mensaje."<p>El campo rfcemisor no es correcto. Verifique el RFC</p>";
		}
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo rfcemisor no es correcto</p>";
}

if (isset($_POST['receptor'])){
	$receptor=htmlentities(trim($_POST['receptor']));
	//$receptor=mysql_real_escape_string($receptor);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo receptor no es correcto</p>";
}

if (isset($_POST['rfcreceptor'])){
	$rfcreceptor=htmlentities(trim($_POST['rfcreceptor']));
	//$rfcreceptor=mysql_real_escape_string($rfcreceptor);
		if(!validarRFC($rfcreceptor)){
			$validacion=false;
			$mensaje=$mensaje."<p>El campo rfcreceptor no es correcto. Verifique el RFC</p>";
		}
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo rfcreceptor no es correcto</p>";
}

if (isset($_POST['montototal'])){
	$montototal=htmlentities(trim($_POST['montototal']));
	//$montototal=mysql_real_escape_string($montototal);
		if(!validarDecimal($montototal)){
			$validacion=false;
			$mensaje=$mensaje."<p>Verifique que el campo montototal sea num&eacute;rico</p>";
		}
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo montototal no es correcto</p>";
}

if (isset($_POST['montopagado'])){
	$montopagado=htmlentities(trim($_POST['montopagado']));
	//$montopagado=mysql_real_escape_string($montopagado);
		if(!validarDecimal($montopagado)){
			$validacion=false;
			$mensaje=$mensaje."<p>Verifique que el campo montopagado sea num&eacute;rico</p>";
		}
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo montopagado no es correcto</p>";
}

if (isset($_POST['estado'])){
	$estado=htmlentities(trim($_POST['estado']));
	//$estado=mysql_real_escape_string($estado);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo estado no es correcto</p>";
}

if (isset($_POST['fechapago'])){
	$fechapago=htmlentities(trim($_POST['fechapago']));
	//$fechapago=mysql_real_escape_string($fechapago);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo fechapago no es correcto</p>";
}

if (isset($_POST['formapago'])){
	$formapago=htmlentities(trim($_POST['formapago']));
	//$formapago=mysql_real_escape_string($formapago);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo formapago no es correcto</p>";
}

if (isset($_POST['cuenta'])){
	$cuenta=htmlentities(trim($_POST['cuenta']));
	//$cuenta=mysql_real_escape_string($cuenta);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo cuenta no es correcto</p>";
}

if (isset($_POST['foliofiscal'])){
	$foliofiscal=htmlentities(trim($_POST['foliofiscal']));
	//$foliofiscal=mysql_real_escape_string($foliofiscal);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo foliofiscal no es correcto</p>";
}

if (isset($_POST['observaciones'])){
	$observaciones=htmlentities(trim($_POST['observaciones']));
	//$observaciones=mysql_real_escape_string($observaciones);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo observaciones no es correcto</p>";
}

if (isset($_POST['relaciones'])){
	$relaciones=htmlentities(trim($_POST['relaciones']));
	//$relaciones=mysql_real_escape_string($relaciones);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo relaciones no es correcto</p>";
}

if (isset($_POST['archivo'])){
	$archivo=htmlentities(trim($_POST['archivo']));
	//$archivo=mysql_real_escape_string($archivo);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo archivo no es correcto</p>";
}

if (isset($_POST['estatus'])){
	$estatus=htmlentities(trim($_POST['estatus']));
	//$estatus=mysql_real_escape_string($estatus);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo estatus no es correcto</p>";
}
if($validacion){
	$resultado=$Ofacturacion->actualizar($foliointerno,$fecha,$tipo,$clasificacion,$emisor,$rfcemisor,$receptor,$rfcreceptor,$montototal,$montopagado,$estado,$fechapago,$formapago,$cuenta,$foliofiscal,$observaciones,$relaciones,$archivo,$estatus, $idfactura);
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