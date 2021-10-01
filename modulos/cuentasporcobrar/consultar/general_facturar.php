<?php 
include ("../../seguridad/comprobar_login.php");
/////PERMISOS////////////////
if (!isset($_SESSION['permisos']['ventas']['acceso'])){
	echo $_SESSION['msgsinacceso'];
	exit;
}
/////FIN  DE PERMISOS////////
include ("../../../librerias/php/variasfunciones.php");
require('../../cuentasporcobrar/CuentaPorCobrar.class.php');
$validacion=true;
$mensaje="";

if (isset($_REQUEST['tipoVista']) && $_REQUEST['tipoVista'] !="") {
	if($_REQUEST['tipoVista']!="undefined"){
		$tipoVista = htmlentities($_REQUEST['tipoVista']);
	}else{
		$tipoVista="tabla";
	}
}else{
	$tipoVista="tabla";
}

if (isset($_REQUEST['papelera']) && $_REQUEST['papelera'] =="si") {
		$papelera=false; // Cambiar a true en caso de que se requiera trabajar con la papelera
}else{
	$papelera=false;
}
if (isset($_REQUEST['campoOrden']) && $_REQUEST['campoOrden'] !="") {
	if($_REQUEST['campoOrden']!="undefined"){
		$campoOrden = htmlentities($_REQUEST['campoOrden']);
	}else{
		$campoOrden="idventa";
	}
}else{
	$campoOrden="idventa";
}

if (isset($_REQUEST['orden']) && $_REQUEST['orden'] !="") {
	if($_REQUEST['orden']!="undefined"){
		$orden = htmlentities($_REQUEST['orden']);
	}else{
		$orden="DESC";
	}
}else{
	$orden="DESC";
}

if (isset($_REQUEST['cantidadamostrar']) && $_REQUEST['cantidadamostrar'] !="") {
	if($_REQUEST['cantidadamostrar']!="undefined"){
		$cantidadamostrar = htmlentities($_REQUEST['cantidadamostrar']);
	}else{
		$cantidadamostrar="20";
	}
}else{
	$cantidadamostrar="20";
}

if (isset($_REQUEST['paginacion']) && $_REQUEST['paginacion'] !="") {
$pg = htmlentities($_REQUEST['paginacion']);
}

if (isset($_REQUEST['busqueda']) && $_REQUEST['busqueda'] !="") {
$busqueda = htmlentities($_REQUEST['busqueda']);
$busqueda=trim($busqueda);
}else{
	$busqueda ="";
}


if (isset($_REQUEST['idalmacen'])){
	$idalmacen=htmlentities(trim($_REQUEST['idalmacen']));
	$idalmacen=trim($idalmacen);	
}else{
	$idalmacen="TODOS";
}

if (isset($_REQUEST['idcliente'])){
	$idcliente=htmlentities(trim($_REQUEST['idcliente']));
	$idcliente=trim($idcliente);	
}else{
	$idcliente="TODOS";
	$validacion=false;
	$mensaje=$mensaje."<p>El campo de transferencia no es correcto</p>";
}

if (isset($_REQUEST['ticket'])){
	$ticket=htmlentities(trim($_REQUEST['ticket']));
	$ticket=trim($ticket);	
}else{
	$ticket="";
}

if (isset($_REQUEST['tipo'])){
	$tipo=htmlentities(trim($_REQUEST['tipo']));
	$tipo=trim($tipo);	
}else{
	$tipo="";
}

if (isset($_REQUEST['filtrarfecha'])){
	$filtrarfecha=htmlentities(trim($_REQUEST['filtrarfecha']));
	$filtrarfecha=trim($filtrarfecha);	
}else{
	$filtrarfecha="";
}

if (isset($_REQUEST['fechainicio'])){
	$fechainicio=htmlentities(trim($_REQUEST['fechainicio']));
	$fechainicio=trim($fechainicio);	
}else{
	$fechainicio="";
}

if (isset($_REQUEST['fechafin'])){
	$fechafin=htmlentities(trim($_REQUEST['fechafin']));
	$fechafin=trim($fechafin);	
}else{
	$fechafin="";
}

if (isset($_REQUEST['diacobro'])){
	$diacobro=htmlentities(trim($_REQUEST['diacobro']));
	$diacobro=trim($diacobro);	
}else{
	$diacobro="";
}

if (isset($_REQUEST['rfccliente'])){
	$rfccliente=htmlentities(trim($_REQUEST['rfccliente']));
	$rfccliente=trim($rfccliente);	
}else{
	$rfccliente="";
}

$facturada="si";

$_SESSION['DATOSFACTURA']="";
$_SESSION['TIPOCOMPROBANTE']="egreso";

if($validacion){

	//CODIGO DE PAGINACION (REQUIERE: "variasfunciones.php")
	$inicial = $pg * $cantidadamostrar;
	$Oventa=new Venta;
	$resultado=$Oventa->mostrarA($campoOrden, $orden, 0, 500000000, $busqueda, $papelera, $idalmacen, $idcliente, $ticket, $tipo, $filtrarfecha, $fechainicio, 		$fechafin, "CREDITO","CREDITO","",true,$diacobro,$facturada, $rfccliente, "todos");
	
	if ($resultado=="denegado"){
		$_SESSION['DATOSFACTURA']=$_SESSION['DATOSFACTURA'].",";
		$_SESSION['TIPOCOMPROBANTE']=$_SESSION['TIPOCOMPROBANTE'];
	}
	// MOSTRAR LOS REGISTROS SEGUN EL RESULTADO DE LA CONSULTA
	
		$cadena="";
	
		while ($filas=mysqli_fetch_array($resultado)) { 	
			$cadena=$cadena.$filas['idventa'].",";
		}//Fin de while si es tabla 
		$cadena=substr($cadena, 0, -1);
		$_SESSION['DATOSFACTURA']=$cadena;
		header("Location: ../../facturacion/nuevo/nuevo.php");
	
	//FIN DEL CODIGO DE PAGINACION
	if(mysqli_num_rows($resultado)==0){
		$_SESSION['DATOSFACTURA']="";
	$_SESSION['TIPOCOMPROBANTE']="ingreso";
	}
}else{
	$mensaje="fracaso@Operaci&oacute;n fallida@Ha ocurrido un problema en la base de datos [001]";
	echo utf8_encode($mensaje);
}
?>

    