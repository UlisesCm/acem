<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
require('recuperarValores.php');
require('../../productos/Producto.class.php');
$Oproducto=new Producto;


$mensaje="";
$validacion=true;




if (isset($_POST['fecha'])){
	$fecha=htmlentities(trim($_POST['fecha']));
	$fecha=trim($fecha);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo fecha no es correcto</p>";
}

if (isset($_POST['hora'])){
	$hora=htmlentities(trim($_POST['hora']));
	$hora=trim($hora);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo hora no es correcto</p>";
}

if (isset($_POST['formapago'])){
	$formapago=htmlentities(trim($_POST['formapago']));
	$formapago=trim($formapago);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo de metodo de pago no es correcto</p>";
}

if (isset($_POST['moneda'])){
	$moneda=htmlentities(trim($_POST['moneda']));
	$moneda=trim($moneda);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo de moneda no es correcto</p>";
}

if (isset($_POST['tipocambio'])){
	$tipocambio=htmlentities(trim($_POST['tipocambio']));
	$tipocambio=trim($tipocambio);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo tipo de cambio no es correcto</p>";
}

if (isset($_POST['serie'])){
	$serie=htmlentities(trim($_POST['serie']));
	$serie=trim($serie);
	
}else{
	$validacion=false;
}

if (isset($_POST['folio'])){
	$folio=htmlentities(trim($_POST['folio']));
	$folio=trim($folio);
	
}else{
	$validacion=false;
}


if (isset($_POST['total'])){
	$total=htmlentities(trim($_POST['total']));
	$total=trim($total);
	if ($total<=0){
		$validacion=false;
		$mensaje=$mensaje."<p>Imposible realizar la venta con las cantidades expuestas</p>";
	}
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo total no es correcto</p>";
}

if (isset($_POST['idcliente'])){
	$idcliente=htmlentities(trim($_POST['idcliente']));
	$idcliente=trim($idcliente);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idcliente no es correcto</p>";
}


if (isset($_POST['idempleado'])){
	$idempleado=htmlentities(trim($_POST['idempleado']));
	$idempleado=trim($idempleado);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idempleado no es correcto</p>";
}

if (isset($_POST['idalmacen'])){
	$idalmacen=htmlentities(trim($_POST['idalmacen']));
	$idalmacen=trim($idalmacen);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idalmacen no es correcto</p>";
}



if (isset($_POST['listaSalida']) && $_POST['listaSalida']!=""){
	$lista=trim($_POST['listaSalida']);
	$lista= substr($lista, 0, -3);
	$lista=explode(":::",$lista);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>Es necesario que ingrese al menos un concepto en la lista</p>";
}

if (isset($_POST['plazo'])){
	$plazo=htmlentities(trim($_POST['plazo']));
	$plazo=trim($plazo);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo plazo no es correcto</p>";
}

if (isset($_POST['diacobro'])){
	$diacobro=htmlentities(trim($_POST['diacobro']));
	$diacobro=trim($diacobro);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo Dia de cobro no es correcto</p>";
}

if (isset($_POST['frecuenciapago'])){
	$frecuenciapago=htmlentities(trim($_POST['frecuenciapago']));
	$frecuenciapago=trim($frecuenciapago);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo frecuencia de pago no es correcto</p>";
}

if (isset($_POST['tipocomprobante'])){
	$tipocomprobante=htmlentities(trim($_POST['tipocomprobante']));
	$tipocomprobante=trim($tipocomprobante);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo frecuencia de pago no es correcto</p>";
}
							
$facturada="no";

$dias=0;
if ($plazo=="15 DIAS"){
	$dias=15;
}
if ($plazo=="1 MES"){
	$dias=30;
}
if ($plazo=="2 MESES"){
	$dias=60;
}
if ($plazo=="3 MESES"){
	$dias=90;
}
if ($plazo=="4 MESES"){
	$dias=120;
}

$fechaplazo=$fecha;
$fechaplazo = date('Y-m-d', strtotime("$fechaplazo + $dias day"));

if ($formapago!="CREDITO"){
	$plazo="NO APLICA";
	$diacobro="NO APLICA";
	$frecuenciapago="NO APLICA";
	$fechaplazo=$fecha;
}else{
	$estado="Pendiente";
}


if ($saldoafavor!=0){
	$saldoactual=$Oventa->obtenerCampo("clientes","saldofavor","idcliente",$idcliente);
	if ($saldoactual < $saldoafavor){
		$validacion=false;
		$mensaje=$mensaje."<p>El saldo a favor del cliente es insuficiente para realizar la venta</p>";
	}
}


$archivoFactura="";
$archivoNota="";
$diferencia=0;
$fechaLiquidacion="0000-00-00";

if($validacion){
	### 2. ASIGNACIÓN DE VALORES A VARIABLES ###################################################
    $SendaPEMS  = "../../../../modula/empresa/archs_pem/";   // 2.1 Directorio en donde se encuentran los archivos *.cer.pem y *.key.pem.
    $SendaCFDI  = "archs_cfdi/";  // 2.2 Directorio en donde se almacenarán los archivos *.xml (CFDIs).
    $SendaGRAFS = "archs_graf/";  // 2.3 Directorio en donde se almacenan los archivos .jpg (logo de la empresa) y .png (códigos bidimensionales).
    $SendaXSD   = "archs_xsd/";   // 2.4 Directorio en donde se almacenan los archivos .xsd (esquemas de validación, especificaciones de campos del Anexo 20 del SAT);
    
    
    // 2.5 Datos de acceso del usuario (proporcionados por www.finkok.com) modo de integración (para pruebas) o producción.
    $username = "controlescolarenlinea@gmail.com";
    $password = "CtrlEsc@26"; 
	
	### 3. DEFINICIÓN DE VARIABLES INICIALES ##########################################
    $noCertificado = $numero_csd;  // 3.1 Número de certificado.
    $file_cer      = $cer_csd;  // 3.2 Nombre del archivo .cer.pem 
    $file_key      = $key_csd;  // 3.3 Nombre del archivo .cer.key
	
	### 4. DATOS GENERALES DE LA FACTURA ##############################################
    $fact_serie        = $serie;                             // 4.1 Número de serie.
    $fact_folio        = $folio;             // 4.2 Número de folio (para efectos de demostración se asigna de manera aleatoria).
    $NoFac             = $fact_serie.$fact_folio;         // 4.3 Serie de la factura concatenado con el número de folio.
    $fact_tipcompr     = $tipocomprobante;                             // 4.4 Tipo de comprobante.
    $tasa_iva          = 16;                              // 4.5 Tasa del impuesto IVA.
    $subTotal          = 0;                               // 4.6 Subtotal, suma de los importes antes de descuentos e impuestos (se calculan mas abajo). 
    $descuento         = number_format(0,2,'.','');       // 4.7 Descuento (se calculan mas abajo).
    $IVA               = number_format(536,2,'.','');     // 4.8 IVA, suma de los impuestos (se calculan mas abajo).
    $total             = 0;                               // 4.9 Total, Subtotal - Descuentos + Impuestos (se calculan mas abajo). 
    $fecha_fact        = date("Y-m-d")."T".date("H:i:s"); // 4.10 Fecha y hora de facturación.
    $NumCtaPago        = "6473";                          // 4.11 Número de cuenta (sólo últimos 4 dígitos, opcional).
    $condicionesDePago = "CONDICIONES";                   // 4.12 Condiciones de pago.
    $formaDePago       = $formaDePago;                            // 4.13 Forma de pago.
    $metodoDePago      = $metodoDePago;                           // 4.14 Clave del método de pago. Consultar catálogos de métodos de pago del SAT.
    $TipoCambio        = $tipocambio;                               // 4.15 Tipo de cambio de la moneda.
    $LugarExpedicion   = $idalmacen;                         // 4.16 Lugar de expedición (código postal).
    $moneda            = $moneda;                           // 4.17 Moneda
    $totalImpuestosRetenidos   = 0;                       // 4.18 Total de impuestos retenidos (se calculan mas abajo).
    $totalImpuestosTrasladados = 0;                       // 4.19 Total de impuestos trasladados (se calculan mas abajo).
	
	
	### 6. ARRAYS QUE CONTIENEN LOS ARTICULOS QUE FORMAN PARTE DE LA VENTA #####################
	$Array_ClaveProdServ =crearArray($arregloIdproducto, "idcategoria", "categorias","codigo","extra");
	$arregloIdproducto=array("2401615261687", "2451612464507", "3341613193869", "3341620150989");
	$Array_Cantidad=array(1, 1, 1, 2);
	$Array_ValorUnitario=array(1000, 2000, 3000, 4000);
	$Array_Descuento=array(0, 0, 0, 0);
	$Array_ClaveUnidad=crearArray($arregloIdproducto, "idunidad", "unidades","codigo","extra");
	$Array_NoIdentificacion=crearArray($arregloIdproducto, "codigo", "","","simple");
	$Array_Descripcion=crearArray($arregloIdproducto, "nombre", "","","simple");
	$Array_Unidad=crearArray($arregloIdproducto, "idunidad", "unidades","nombre","extra");
	$Array_Importe=calcularImporteArray($arregloCantidad,$arregloPrecio);
    
	
	### 9. DATOS GENERALES DEL EMISOR #################################################  
    
    $emisor_rs     = "ENVACES Y EMPAQUES INTERNACIONALES";
    $emisor_rfc    = "ACO560518KW7";
    $emisor_regfis = "REGIMEN GENERAL DE PERSONAS MORALES";    
        
    
	### 10. DATOS GENERALES DEL RECEPTOR (CLIENTE) #####################################
    
    $RFC_Recep = "AAD990814BP7";
    $receptor_rfc = $RFC_Recep;
    $receptor_rs  = "ASOCIACION DE AGRICULTORES";
	
	
function descomponerArreglo($elementosPorVuelta,$elementoSeleccionado, $arreglo){
	$totalElementos= count($arreglo);
	if ($totalElementos!=1){
		$con=0;
		$totalVueltas=$totalElementos/$elementosPorVuelta;
		while($con<$totalVueltas){
			$array[$con]= $arreglo[$elementoSeleccionado];
			$elementoSeleccionado=$elementoSeleccionado+$elementosPorVuelta;
			$con++;
		}
		return $array;
	}else{
		return $arreglo;
	}
}

function crearArray($arreglo, $campo, $tablaExtra, $campoExtra, $tipoFuncion){
	$Objeto=new Producto;
	$nuevoArray=array();
	foreach ($arreglo as $clave => $valor) {
		if ($tipoFuncion=="simple"){
			$codigo=$Objeto->obtenerCampo( $campo, $valor);
			array_push($nuevoArray, $codigo);
		}else{
			$codigo=$Objeto->obtenerCampoExtraordinario($campo,$valor,$tablaExtra,$campoExtra);
			array_push($nuevoArray, $codigo);
		}
	}
	return $nuevoArray;
}

function calcularImporteArray($array1,$array2){
	$nuevoArray=array();
	foreach ($array1 as $clave => $valor) {
		$importe=$array1[$clave]*$array2[$clave];
		echo $importe."</br>";
		array_push($nuevoArray, $importe);
	}
	return $nuevoArray;
}
	
	
	
	
	
	
}else{
	$mensaje="fracaso@Operaci&oacute;n fallida@ $mensaje";
}

echo utf8_encode($mensaje);
?>