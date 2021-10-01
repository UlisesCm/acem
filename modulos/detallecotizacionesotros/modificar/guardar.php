<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
require('../Detallecotizacionotro.class.php');
$Odetallecotizacionotro=new Detallecotizacionotro;
$mensaje="";
$validacion=true;

if (isset($_POST['iddetallecotizacionotros'])){
	$iddetallecotizacionotros=htmlentities(trim($_POST['iddetallecotizacionotros']));
	//$iddetallecotizacionotros=mysql_real_escape_string($iddetallecotizacionotros);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo iddetallecotizacionotros no es correcto</p>";
}

if (isset($_POST['idcliente'])){
	$idcliente=htmlentities(trim($_POST['idcliente']));
	//$idcliente=mysql_real_escape_string($idcliente);
			if(trim($idcliente)==""){
				$validacion=false;
				$mensaje=$mensaje."<p>Verifique que el campo idcliente sea v&aacute;lido y exista en la base de datos</p>";
			}
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idcliente no es correcto</p>";
}

if (isset($_POST['fecha'])){
	$fecha=htmlentities(trim($_POST['fecha']));
	//$fecha=mysql_real_escape_string($fecha);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo fecha no es correcto</p>";
}

if (isset($_POST['cantidad'])){
	$cantidad=htmlentities(trim($_POST['cantidad']));
	//$cantidad=mysql_real_escape_string($cantidad);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo cantidad no es correcto</p>";
}

if (isset($_POST['concepto'])){
	$concepto=htmlentities(trim($_POST['concepto']));
	//$concepto=mysql_real_escape_string($concepto);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo concepto no es correcto</p>";
}

if (isset($_POST['unidad'])){
	$unidad=htmlentities(trim($_POST['unidad']));
	//$unidad=mysql_real_escape_string($unidad);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo unidad no es correcto</p>";
}

if (isset($_POST['numeroservicio'])){
	$numeroservicio=htmlentities(trim($_POST['numeroservicio']));
	//$numeroservicio=mysql_real_escape_string($numeroservicio);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo numeroservicio no es correcto</p>";
}

if (isset($_POST['totalservicios'])){
	$totalservicios=htmlentities(trim($_POST['totalservicios']));
	//$totalservicios=mysql_real_escape_string($totalservicios);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo totalservicios no es correcto</p>";
}

if (isset($_POST['idcotizacionotros'])){
	$idcotizacionotros=htmlentities(trim($_POST['idcotizacionotros']));
	//$idcotizacionotros=mysql_real_escape_string($idcotizacionotros);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idcotizacionotros no es correcto</p>";
}

if (isset($_POST['precio'])){
	$precio=htmlentities(trim($_POST['precio']));
	//$precio=mysql_real_escape_string($precio);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo precio no es correcto</p>";
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

if (isset($_POST['idmodeloimpuestos'])){
	$idmodeloimpuestos=htmlentities(trim($_POST['idmodeloimpuestos']));
	//$idmodeloimpuestos=mysql_real_escape_string($idmodeloimpuestos);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idmodeloimpuestos no es correcto</p>";
}

if (isset($_POST['estadopago'])){
	$estadopago=htmlentities(trim($_POST['estadopago']));
	//$estadopago=mysql_real_escape_string($estadopago);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo estadopago no es correcto</p>";
}

if (isset($_POST['estadofacturacion'])){
	$estadofacturacion=htmlentities(trim($_POST['estadofacturacion']));
	//$estadofacturacion=mysql_real_escape_string($estadofacturacion);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo estadofacturacion no es correcto</p>";
}

if (isset($_POST['factura'])){
	$factura=htmlentities(trim($_POST['factura']));
	//$factura=mysql_real_escape_string($factura);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo factura no es correcto</p>";
}

if (isset($_POST['estatus'])){
	$estatus=htmlentities(trim($_POST['estatus']));
	//$estatus=mysql_real_escape_string($estatus);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo estatus no es correcto</p>";
}
if($validacion){
	$resultado=$Odetallecotizacionotro->actualizar($idcliente,$fecha,$cantidad,$concepto,$unidad,$numeroservicio,$totalservicios,$idcotizacionotros,$precio,$impuestos,$total,$idmodeloimpuestos,$estadopago,$estadofacturacion,$factura,$estatus, $iddetallecotizacionotros);
	if($resultado=="exito"){
		
		$mensaje="exito@Operaci&oacute;n exitosa@El registro ha sido guardado";
	}
	if($resultado=="iddetallecotizacionotrosExiste"){
		$mensaje="fracaso@Operaci&oacute;n fallida@El campo iddetallecotizacionotros ya existe en la base de datos";
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