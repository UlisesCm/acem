<?php 
include ("../../seguridad/comprobar_login.php");
$tipoempresa=$_SESSION["tipoempresa"];
include("../../../librerias/php/qrlib/qrlib.php");
include("../componentes/numerosaletras.php");
include("../../../librerias/php/validaciones.php");
require("../../productos$tipoempresa/Producto.class.php");
require('../Facturacion.class.php');
date_default_timezone_set("America/Mexico_City");
$Oproducto=new Producto;
$Ofactura=new Facturacion;

$rutaEmpresa="../../../empresas/".$_SESSION["empresa"]."/";

$mensaje="";
$validacion=true;

if (isset($_POST['idcliente'])){
	$idcliente=htmlentities(trim($_POST['idcliente']));
	$idcliente=trim($idcliente);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idcliente no es correcto</p>";
}


if (isset($_POST['fecha'])){ //Validado FechaPago
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

if (isset($_POST['total'])){
	$totalPago=htmlentities(trim($_POST['total']));
	$totalPago=trim($totalPago);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo de metodo de pago no es correcto</p>";
}

if (isset($_POST['metodopago'])){
	$metodopago=htmlentities(trim($_POST['metodopago']));
	$metodopago=trim($metodopago);
	
}else{
	//$validacion=false;
	//$mensaje=$mensaje."<p>El campo de metodo de pago no es correcto</p>";
	$metodopago="PUE";
}

if (isset($_POST['moneda'])){
	$DECIMALES=2;
	$moneda=htmlentities(trim($_POST['moneda']));
	$moneda=trim($moneda);
	if ($moneda=="MXN"){
		$DECIMALES=2;
	}
	if ($moneda=="USD"){
		$DECIMALES=2;
	}
	if ($moneda=="USN"){
		$DECIMALES=2;
	}
	if ($moneda=="EUR"){
		$DECIMALES=2;
	}
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo de moneda no es correcto</p>";
}

if (isset($_POST['tipocambio'])){
	$tipocambio=htmlentities(trim($_POST['tipocambio']));
	$tipocambio=trim($tipocambio);
	
}else{
	$tipocambio=1;
}

if (isset($_POST['serie'])){ //Validado
	$serie=htmlentities(trim($_POST['serie']));
	$serie=trim($serie);
	
}else{
	$validacion=false;
}

if (isset($_POST['folio'])){ //Validado
	$folio=htmlentities(trim($_POST['folio']));
	$folio=trim($folio);
	
}else{
	$validacion=false;
}

if (isset($_POST['tipocomprobante'])){
	$tipocomprobante=htmlentities(trim($_POST['tipocomprobante']));
	$tipocomprobante=trim($tipocomprobante);
	
}else{
	$tipocomprobante="E";
}

if (isset($_POST['uso'])){
	$uso=htmlentities(trim($_POST['uso']));
	$uso=trim($uso);
	
}else{
	$validacion=false;
}

if (isset($_POST['total'])){
	$total=htmlentities(trim($_POST['total']));
	$total=trim($total);
	
}else{
	$validacion=false;
}


if (isset($_POST['observaciones'])){
	$observaciones=htmlentities(trim($_POST['observaciones']));
	$observaciones=trim($observaciones);
	
}else{
	$validacion=false;
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

if (isset($_POST['codigopostal'])){
	$codigopostal=htmlentities(trim($_POST['codigopostal']));
	$codigopostal=trim($codigopostal);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo CP no es correcto</p>";
}


if (isset($_POST['rfcemisorordenante'])){
	$rfcemisorordenante=htmlentities(trim($_POST['rfcemisorordenante']));
	$rfcemisorordenante=trim($rfcemisorordenante);
	$bancoordenante="";

	if ($rfcemisorordenante=="XEXX01010100"){
		$bancoordenante=htmlentities(trim($_POST['bancoordenante']));
		$bancoordenante=trim($bancoordenante);
		if ($bancoordenante==""){
			$validacion=false;
			$mensaje=$mensaje."<p>El campo Nombre del Banco Ordenante es obligatorio. Ingrese el nombre del banco extranjero en el apartado de configuraci&oacute;n</p>";
		}
	}else{
		$bancoordenante="";
	}
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo RFC Emisor Ordenante no es correcto</p>";
}

if (isset($_POST['cuentaordenante'])){
	$cuentaordenante=htmlentities(trim($_POST['cuentaordenante']));
	$cuentaordenante=trim($cuentaordenante);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo Cuenta Ordenante no es correcto</p>";
}

if (isset($_POST['rfcemisorbeneficiario'])){
	$rfcemisorbeneficiario=htmlentities(trim($_POST['rfcemisorbeneficiario']));
	$rfcemisorbeneficiario=trim($rfcemisorbeneficiario);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo RFC Emisor Beneficiario no es correcto</p>";
}

if (isset($_POST['cuentabeneficiario'])){
	$cuentabeneficiario=htmlentities(trim($_POST['cuentabeneficiario']));
	$cuentabeneficiario=trim($cuentabeneficiario);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo Cuenta Beneficiario no es correcto</p>";
}

if (isset($_POST['numoperacion'])){
	$numoperacion=htmlentities(trim($_POST['numoperacion']));
	$numoperacion=trim($numoperacion);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo N&uacute;mero de operaci&oacute;n no es correcto</p>";
}

if (isset($_POST['tipocadena'])){
	$tipocadena=htmlentities(trim($_POST['tipocadena']));
	$tipocadena=trim($tipocadena);
	$certificadopago="";
	$cadenapago="";
	$sellopago="";
	if ($tipocadena!=""){
		$certificadopago=htmlentities(trim($_POST['certificadopago']));
		$cadenapago=htmlentities(trim($_POST['cadenapago']));	
		$sellopago=htmlentities(trim($_POST['sellopago']));
		if ($certificadopago=="" or $cadenapago=="" or $sellopago==""){
			$validacion=false;
			$mensaje=$mensaje."<p>Debe llenar correctamente los campos del SPEI (Certificado del pago, Cadena del pago y el Sello del pago)</p>";
		}
	}
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo Tipo Cadena no es correcto</p>";
}



if (isset($_POST['eshotel'])){
	$hayish=htmlentities(trim($_POST['eshotel']));
	$hayish=trim($hayish);
	if($hayish==1){
		$tasaish=$_POST['tasaish'];
	}
	
}else{
	$hayish="0";
	$ish=0;
	$tasaish=0;
}

if (isset($_POST['impuestocedular'])){
	$hayimpuestocedular=htmlentities(trim($_POST['impuestocedular']));
	$hayimpuestocedular=trim($hayimpuestocedular);
	if($hayimpuestocedular=="si"){
		$tasaimpuestocedular=$_POST['tasaimpuestocedular'];
	}
	$impCedular=0;
}else{
	$hayimpuestocedular="no";
	$impCedular=0;
	$tasaimpuestocedular=0;
}

if (isset($_POST['listaSalida']) && $_POST['listaSalida']!=""){
	$lista=trim($_POST['listaSalida']);
	$lista= substr($lista, 0, -3);
	$lista=explode(":::",$lista);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>Es necesario que ingrese al menos un concepto en la lista</p>";
}



if (isset($_POST['listaSalida2']) && $_POST['listaSalida2']!=""){
	$lista2=trim($_POST['listaSalida2']);
	$lista2= substr($lista2, 0, -3);
	$lista2=explode(":::",$lista2);
	
	if (isset($_POST['tiporelacion'])){
		$tiporelacion=htmlentities(trim($_POST['tiporelacion']));
		$tiporelacion=trim($tiporelacion);
		
	}else{
		$validacion=false;
		$mensaje=$mensaje."<p>El campo tipo de relacion no es correcto</p>";
	}
}else{
	$tiporelacion="";
}


							
$facturada="no";



$archivoFactura="";
$archivoNota="";
$diferencia=0;
$fechaLiquidacion="0000-00-00";

if($validacion){
	### 1. RECIBIMOS LOS DATOS DEL EMISOR
	require('recuperarValoresEmisor.php');
	require('recuperarValoresReceptor.php');
	
	
	### 3. DEFINICIÓN DE VARIABLES INICIALES ##########################################
    $noCertificado = $numero_csd;  // 3.1 Número de certificado.
    $file_cer      = $cer_csd;  // 3.2 Nombre del archivo .cer.pem 
    $file_key      = $key_csd;  // 3.3 Nombre del archivo .cer.key
	
	### 4. DATOS GENERALES DE LA FACTURA ##############################################
    $fact_serie        = $serie;                             // 4.1 Número de serie.
    $fact_folio        = $folio;             // 4.2 Número de folio (para efectos de demostración se asigna de manera aleatoria).
    $NoFac             = $fact_serie.$fact_folio;         // 4.3 Serie de la factura concatenado con el número de folio.
    $fecha_fact        = date("Y-m-d")."T".date("H:i:s"); // 4.10 Fecha y hora de facturación.
    $TipoCambio        = $tipocambio;                               // 4.15 Tipo de cambio de la moneda.
    $LugarExpedicion   = $codigopostal;                         // 4.16 Lugar de expedición (código postal).
	$tiporelacion=$tiporelacion;
	$comprobantesRelacionados="";
	
	$fechaPago=$fecha."T".date("H:i:s");
	                    
	
	
	### 6. VARIABLES QUE CONTIENEN EL CONCEPTO DE VENTA ############################
    
    $ConcepVenta_ClaveProdServ = '84111506'; // 6.1 
    $ConcepVenta_Cantidad      = '1';        // 6.2 
    $ConcepVenta_ClaveUnidad   = 'ACT';      // 6.3 
    $ConcepVenta_Descripcion   = 'Pago';     // 6.4 
    $ConcepVenta_ValorUnitario = '0';        // 6.5 
    $ConcepVenta_Importe       = '0';        // 6.6 
	
	### 6. ARRAYS QUE CONTIENEN LOS DOCUMENTOS RELACIONADOS #####################
	if($tiporelacion!=""){
		$arregloUUID=descomponerArreglo(1,0,$lista2);
		$comprobantesRelacionados="";
		for ($i=0; $i<count($arregloUUID); $i++){
			$comprobantesRelacionados=$comprobantesRelacionados." (".$arregloUUID[$i].")";
		}
	}
    
	
	### 9. DATOS GENERALES DEL EMISOR ################################################# 
    $emisor_rs     = $razonsocialEmisor;
    $emisor_rfc    = $rfcEmisor;
    $emisor_regfis = $regimenEmisor;
	
        
    
	### 10. DATOS GENERALES DEL RECEPTOR (CLIENTE) #####################################

    $RFC_Recep = $rfcReceptor;
    $receptor_rfc = $RFC_Recep;
    $receptor_rs  = $razonsocialReceptor;
 
	$version_timbre = "3.3";
	$sello_SAT      = "Sello SAT";
	$cert_SAT       = "Certificado SAT"; 
	$sello_CFD      = "CELLO CDF"; 
	$tim_fecha      = ""; 
	$tim_uuid       = ""; 
					
	$foliointerno=$serie."-".$folio;
	$fechaAlta=date("Y-m-d");
	$fechaPago=date("Y-m-d");
					
	
	$metodoDePago="PPD";
		
	$relaciones="";
            
	$filename="../componentes/qr.png";
	include("plantillaPago.php");     
	echo $mensaje;
        
##### FIN DE PROCEDIMIENTOS ####################################################      
}else{
	$mensaje="fracaso@Operaci&oacute;n fallida@ $mensaje";
	echo $mensaje;
}
?>