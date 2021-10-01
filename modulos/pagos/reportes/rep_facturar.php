<?php 
include ("../../seguridad/comprobar_login.php");
/////PERMISOS////////////////
if (!isset($_SESSION['permisos']['pagos']['acceso'])){
	echo $_SESSION['msgsinacceso'];
	exit;
}
/////FIN  DE PERMISOS////////
include ("../../../librerias/php/variasfunciones.php");
require('../Pago.class.php');
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

if (isset($_REQUEST['formapago'])){
	$formapago=htmlentities(trim($_REQUEST['formapago']));
	$formapago=trim($formapago);	
}else{
	$formapago="";
}

if (isset($_REQUEST['diacobro'])){
	$diacobro=htmlentities(trim($_REQUEST['diacobro']));
	$diacobro=trim($diacobro);	
}else{
	$diacobro="";
}

if (isset($_REQUEST['domicilio'])){
	$domicilio=htmlentities(trim($_REQUEST['domicilio']));
	$domicilio=trim($domicilio);	
}else{
	$domicilio="";
}

if (isset($_REQUEST['rfccliente'])){
	$rfccliente=htmlentities(trim($_REQUEST['rfccliente']));
	$rfccliente=trim($rfccliente);
	if($rfccliente==""){
		$validacion=false;
		$mensaje.="Es necesario que proporcione el RFC del cliente";
	}
}else{
	$validacion=false;
	$rfccliente="";
}

if (isset($_REQUEST['estadopago'])){
	$estadopago=htmlentities(trim($_REQUEST['estadopago']));
	$estadopago=trim($estadopago);	
}else{
	$estadopago="";
}

$facturada="si";

$_SESSION['DATOSPAGO']="";
$_SESSION['FACTURASMADRE']="";
$_SESSION['TIPOCOMPROBANTE']="pago";

if($validacion){

	//CODIGO DE PAGINACION (REQUIERE: "variasfunciones.php")
	$inicial = $pg * $cantidadamostrar;
	$Opago=new Pago;
	$resultado=$Opago->mostrarA($campoOrden, $orden, 0, 50000000, $busqueda, $papelera, $idalmacen, $idcliente, $ticket, $tipo, $filtrarfecha, $fechainicio, $fechafin, $formapago, $diacobro, $facturada, $domicilio, "", $estadopago, $rfccliente, "si");
	
	
	
	$filasTotales=$resultado[1];
	$where=$resultado[2];
	$resultado=$resultado[0];
	
	$resultado2=$Opago->consultaLibre("SELECT 
	SUM(pagos.monto) AS montopago, 
	facturacion.foliofiscal,
	facturacion.foliointerno,
	facturacion.moneda,
	facturacion.tipocambio,
	facturacion.montototal,
	facturacion.montopagado, 
	facturacion.numparcialidad
	FROM pagos
	INNER JOIN ventas ON pagos.idventa=ventas.idventa
	INNER JOIN facturacion ON facturacion.foliofiscal=ventas.foliofiscal
	$where GROUP BY facturacion.foliofiscal");

	$cadena="";
	$return_arr = array();
	while ($filas2=mysqli_fetch_array($resultado2)) { 	
		$descripcion["uuidfactura"] = html_entity_decode($filas2['foliofiscal']);
		$descripcion["foliointerno"] = html_entity_decode($filas2['foliointerno']);
		
		$descripcion["moneda"] = html_entity_decode($filas2['moneda']);
		$descripcion["tipocambio"] = html_entity_decode($filas2['tipocambio']);
		$descripcion["metodopago"] = "PPD";
		$descripcion["numparcialidad"] = html_entity_decode($filas2['numparcialidad']);
		$descripcion["saldoanterior"] = html_entity_decode($filas2['montototal']-$filas2['montopago']);
		$descripcion["montopagado"] = html_entity_decode($filas2['montopago']);
		$descripcion["saldoinsoluto"] = html_entity_decode($descripcion["saldoanterior"]-$filas2['montopago']);
		
		array_push($return_arr,$descripcion);
	}//Fin de while si es tabla 
	

	if ($resultado=="denegado"){
		$_SESSION['DATOSPAGO']=$_SESSION['DATOSPAGO'].",";
		$_SESSION['TIPOCOMPROBANTE']=$_SESSION['TIPOCOMPROBANTE'];
		$_SESSION['FACTURASMADRE']=$_SESSION['FACTURASMADRE'].",";
	}
	// MOSTRAR LOS REGISTROS SEGUN EL RESULTADO DE LA CONSULTA
	
		$cadena="";
	
		while ($filas=mysqli_fetch_array($resultado)) { 	
			$cadena=$cadena.$filas['idpago'].",";
		}//Fin de while si es tabla 
		$cadena=substr($cadena, 0, -1);
		$_SESSION['DATOSPAGO']=$cadena;
		$_SESSION['FACTURASMADRE']=$return_arr;
		$_SESSION['RFCCLIENTEPAGO']=$rfccliente;
		$var_persona=$Opago->obtenerCliente($rfccliente);
		$idpersona=$var_persona[0];
		$nombrepersona=$var_persona[1];
		$_SESSION['NOMBRECLIENTEPAGO']=$nombrepersona;
		if ($idcliente==""){
			$idcliente=$idpersona;
		}
		$_SESSION['IDCLIENTEPAGO']=$idcliente;
		$_SESSION['FECHAPAGO']=$fechainicio;
		$_SESSION['VECES']=0;
		
		if ($formapago=="EFECTIVO"){
			$formapago="01";
		}
		if ($formapago=="TARJETA DE DEBITO"){
			$formapago="28";
		}
		if ($formapago=="TARJETA DE CREDITO"){
			$formapago="04";
		}
		if ($formapago=="CHEQUE"){
			$formapago="02";
		}
		if ($formapago=="TRANSFERENCIA"){
			$formapago="03";
		}
		if ($formapago=="SALDO A FAVOR"){
			$formapago="06";
		}
		$_SESSION['FORMAPAGO']=$formapago;
		//echo $cadena;
		header("Location: ../../facturacion/nuevo/nuevoPago.php");
	
	//FIN DEL CODIGO DE PAGINACION
	if(mysqli_num_rows($resultado)==0){
		$_SESSION['DATOSPAGO']="";
		$_SESSION['TIPOCOMPROBANTE']="pago";
		$_SESSION['FACTURASMADRE']="";
	}
}else{
	$mensaje="fracaso@Operaci&oacute;n fallida@Ha ocurrido un problema en la base de datos [001]";
	echo utf8_encode($mensaje);
}
?>

    