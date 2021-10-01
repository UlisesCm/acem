<?php 
include ("../../seguridad/comprobar_login.php");
/*CARGA DE ARCHIVOS*/
include_once('../../../librerias/php/thumb.php');
require('../Compra.class.php');
$Ocompra=new Compra;
$mensaje="";
$validacion=true;

if (isset($_POST['idcompra'])){
	$idcompra=htmlentities(trim($_POST['idcompra']));
	//$idcompra=mysql_real_escape_string($idcompra);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idcompra no es correcto</p>";
}

if (isset($_POST['fecha'])){
	$fecha=htmlentities(trim($_POST['fecha']));
	//$fecha=mysql_real_escape_string($fecha);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo fecha no es correcto</p>";
}

if (isset($_POST['idempleado'])){
	$idempleado=htmlentities(trim($_POST['idempleado']));
	//$idempleado=mysql_real_escape_string($idempleado);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idempleado no es correcto</p>";
}

if (isset($_POST['comentarios'])){
	$comentarios=htmlentities(trim($_POST['comentarios']));
	//$comentarios=mysql_real_escape_string($comentarios);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo comentarios no es correcto</p>";
}

if (isset($_POST['estado'])){
	$estado=htmlentities(trim($_POST['estado']));
	//$estado=mysql_real_escape_string($estado);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo estado no es correcto</p>";
}

if (isset($_POST['monto'])){
	$monto=htmlentities(trim($_POST['monto']));
	//$monto=mysql_real_escape_string($monto);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo monto no es correcto</p>";
}

if (isset($_POST['idsucursal'])){
	$idsucursal=htmlentities(trim($_POST['idsucursal']));
	//$idsucursal=mysql_real_escape_string($idsucursal);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idsucursal no es correcto</p>";
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
	$facturaEliminacion=trim($_POST['facturaEliminacion']);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo factura no es correcto</p>";
}	
	/*CARGAR ARCHIVO*/
if (isset($_FILES['facturaI']['name'])){
	$facturatemporal=$_FILES['facturaI']['tmp_name'];
	$facturanombre=$_FILES['facturaI']['name'];
	$extencionfactura=pathinfo($_FILES['facturaI']['name'], PATHINFO_EXTENSION);
	if($facturatemporal==""){
		$factura=$factura;
	}else{
		$factura=basename($_FILES['facturaI']['name'],".".$extencionfactura)."_".generarClave(5).".".$extencionfactura;
	}
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo factura no es correcto</p>";
}
if($validacion){
	$resultado=$Ocompra->actualizar($fecha,$idempleado,$comentarios,$estado,$monto,$idsucursal,$idproveedor,$factura, $idcompra);
	if($resultado=="exito"){
		/*CARGAR ARCHIVOS*/
		$mensajeArchivo="";
		
		if($facturatemporal!=""){
			//Elimina la imagen antigua para actualizarla y que no ocupe espacio
			unlink("../archivosSubidos/compras/".$facturaEliminacion);
			$estadoArchivo=cargarArchivo($facturanombre,$extencionfactura, $facturatemporal, $factura,"pdf,xml","compras",0,0,"archivo","center");
			if ($estadoArchivo=="exito"){
				$mensajeArchivo="";
			}else if ($estadoArchivo=="extencionInvalida"){
				$mensajeArchivo=$mensajeArchivo."| La extenci&oacute;n: ".$extencionfactura. " del archivo, no es v&aacute;lida. ";
			}else{
				$mensajeArchivo=$mensajeArchivo."| No se pudo guardar el archivo (".$extencionfoto."). ";
			}
		}
		$mensaje="exito@Operaci&oacute;n exitosa@El registro ha sido guardado";
		$mensaje=$mensaje.$mensajeArchivo;
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