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
	$mensaje=$mensaje."<p>Es necesario que ingrese al menos una factura a la lista</p>";
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
	
	### 2. ASIGNACIÓN DE VALORES A VARIABLES ###################################################
    $SendaPEMS  = "../../../empresas/".$_SESSION["empresa"]."/certificados/";   // 2.1 Directorio en donde se encuentran los archivos *.cer.pem y *.key.pem.
	
	if(!is_dir($rutaEmpresa."facturas/")){ 
		mkdir($rutaEmpresa."facturas/", 0777);
	}
	$anoCarpeta=date("Y");
	$mesCarpeta=date("M");
	if(!is_dir($rutaEmpresa."facturas/".$anoCarpeta."/")){ 
		mkdir($rutaEmpresa."facturas/".$anoCarpeta."/", 0777);
	}
	if(!is_dir($rutaEmpresa."facturas/".$anoCarpeta."/".$mesCarpeta."/")){ 
		mkdir($rutaEmpresa."facturas/".$anoCarpeta."/".$mesCarpeta."/", 0777);
	}
	if(!is_dir($rutaEmpresa."facturas/".$anoCarpeta."/".$mesCarpeta."/")){ 
		mkdir($rutaEmpresa."facturas/".$anoCarpeta."/".$mesCarpeta."/", 0777);
	}
	$rutaEmpresa=$rutaEmpresa."facturas/".$anoCarpeta."/".$mesCarpeta."/";
	$rutaEmpresaTrunca="facturas/".$anoCarpeta."/".$mesCarpeta."/";
	
	$nombreArchivo= $rfcReceptor.date("Ymd").date("His");
	
	$SendaCFDI =$rutaEmpresa;
	
	
	
	
    $SendaGRAFS = "../../../empresas/facturacion/imagenes/";  // 2.3 Directorio en donde se almacenan los archivos .jpg (logo de la empresa) y .png (códigos bidimensionales).
    $SendaXSD   = "archs_xsd/";   // 2.4 Directorio en donde se almacenan los archivos .xsd (esquemas de validación, especificaciones de campos del Anexo 20 del SAT);
    
    
    // 2.5 Datos de acceso del usuario (proporcionados por www.finkok.com) modo de integración (para pruebas) o producción.
	if($_SESSION['empresa']=="facturacion" or $_SESSION['empresa']=="modula"){
    	$username = "controlescolarenlinea@gmail.com";
    	$password = "CtrlEsc@26"; 
		$urlFinkok="https://demo-facturacion.finkok.com/servicios/soap/stamp.wsdl";
	}else{
		$username = 'kenzzo.ba@gmail.com';
		$password = 'KENzzo1!';
		$urlFinkok = "https://facturacion.finkok.com/servicios/soap/stamp.wsdl";
	}
	
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

	### 11. CREACIÓN Y ALMACENAMIENTO DEL ARCHIVO .XML (CFDI) ANTES DE SER TIMBRADO ###################
    
    #== 11.1 Creación de la variable de tipo DOM, aquí se conforma el XML a timbrar posteriormente.
    $xml = new DOMdocument('1.0', 'UTF-8'); 
    $root = $xml->createElement("cfdi:Comprobante");
    $root = $xml->appendChild($root); 
    
    $cadena_original='||';
    $noatt=  array();
    
   #== 11.2 Se crea e inserta el primer nodo donde se declaran los namespaces ======
     cargaAtt($root, array("xsi:schemaLocation"=>"http://www.sat.gob.mx/cfd/3",
            "xmlns:cfdi"=>"http://www.sat.gob.mx/cfd/3",
            "xmlns:xsi"=>"http://www.w3.org/2001/XMLSchema-instance",
			"xsi:schemaLocation"=>"http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv33.xsd http://www.sat.gob.mx/Pagos http://www.sat.gob.mx/sitio_internet/cfd/Pagos/Pagos10.xsd",
			"xmlns:pago10"=>"http://www.sat.gob.mx/Pagos"
        )
    );
    
    #== 11.3 Rutina de integración de nodos =========================================
    cargaAtt($root, array(
             "Version"=>"3.3", 
             "Serie"=>$fact_serie,
             "Folio"=>$fact_folio,
             "Fecha"=>date("Y-m-d")."T".date("H:i:s"),
             "NoCertificado"=>$noCertificado,
             "SubTotal"=>"0",
             "Moneda"=>"XXX",
             "Total"=>"0",
             "TipoDeComprobante"=>"P",
             "LugarExpedicion"=>$LugarExpedicion
          )
       );
	   

    
//    $emisor = $xml->createElement("cfdi:CfdiRelacionados");
//    $emisor = $root->appendChild($emisor);
//    cargaAtt($emisor, array("TipoRelacion"=>"01"));
//    
//    $CfdiRel = $xml->createElement("cfdi:CfdiRelacionado");
//    $CfdiRel = $emisor->appendChild($CfdiRel);
//    cargaAtt($CfdiRel, array("UUID"=>"A39DA66B-52CA-49E3-879B-5C05185B0EF7"));    

    
	if($tiporelacion!=""){
		$CDFIrelacionados = $xml->createElement("cfdi:CfdiRelacionados");
		$CDFIrelacionados = $root->appendChild($CDFIrelacionados);
		cargaAtt($CDFIrelacionados, array("TipoRelacion"=>$tiporelacion));
		
		for ($i=0; $i<count($arregloUUID); $i++){
			$CfdiRelacionado = $xml->createElement("cfdi:CfdiRelacionado");
			$CfdiRelacionado = $CDFIrelacionados->appendChild($CfdiRelacionado);
			cargaAtt($CfdiRelacionado, array("UUID"=>$arregloUUID[$i]));
		}
	}
						
    
    $emisor = $xml->createElement("cfdi:Emisor");
    $emisor = $root->appendChild($emisor);
    cargaAtt($emisor, array("Rfc"=>$emisor_rfc,
                            "Nombre"=>$emisor_rs,
                            "RegimenFiscal"=>$regimenEmisor
                             )
                        );
    
    
    $receptor = $xml->createElement("cfdi:Receptor");
    $receptor = $root->appendChild($receptor);
    cargaAtt($receptor, array("Rfc"=>$receptor_rfc,"Nombre"=>$receptor_rs));
	//En caso de que el receptor sea extranjero entonces se agregan atributos especiales
	if($receptor_rfc=="XEXX010101000"){ 
		cargaAtt($receptor, array("ResidenciaFiscal"=>$paisReceptor,"NumRegIdTrib"=>$numeroExtranjero));
	}
	cargaAtt($receptor, array("UsoCFDI"=>"P01"));
	
    
    
    #== 11.4 Recopilación de datos de artículos e integración de sus respectivos nodos =

   	$conceptos = $xml->createElement("cfdi:Conceptos");
    $conceptos = $root->appendChild($conceptos);
    
        $concepto = $xml->createElement("cfdi:Concepto");
        $concepto = $conceptos->appendChild($concepto);
        cargaAtt($concepto, array(
               "ClaveProdServ"=>$ConcepVenta_ClaveProdServ,
               "Cantidad"=>$ConcepVenta_Cantidad,
               "ClaveUnidad"=>$ConcepVenta_ClaveUnidad,
               "Descripcion"=>$ConcepVenta_Descripcion,
               "ValorUnitario"=>number_format($ConcepVenta_ValorUnitario,0,'.',''),
               "Importe"=>number_format($ConcepVenta_Importe,0,'.','')
            )
        );
	
	
    // 11.4 COMPLEMENTO PARA RECEPCIÓN DE PAGOS =========================================
    
    $complemento = $xml->createElement("cfdi:Complemento");
    $complemento = $root->appendChild($complemento);
    
    
    $pagos = $xml->createElement("pago10:Pagos");
    $pagos = $complemento->appendChild($pagos);
    cargaAtt($pagos, array(
            "Version"=>"1.0"
        )
    );
    
    $pago = $xml->createElement("pago10:Pago");
    $pago = $pagos->appendChild($pago);
    cargaAtt($pago, array(
            "FechaPago"=>$fechaPago,
            "FormaDePagoP"=>$formapago,
            "MonedaP"=>$moneda
        )
    );
	if ($moneda!="MXN"){
		cargaAtt($pago, array("TipoCambioP"=>$tipocambio));
	}
	
	cargaAtt($pago, array("Monto"=>number_format($totalPago,2,'.','')));
	
	if ($numoperacion!=""){
		cargaAtt($pago, array("NumOperacion"=>$numoperacion));
	}
	
	if ($rfcemisorordenante!=""){
		cargaAtt($pago, array("RfcEmisorCtaOrd"=>$rfcemisorordenante));
	}
	if ($bancoordenante!=""){
		cargaAtt($pago, array("NomBancoOrdExt"=>$bancoordenante));
	}
	if ($cuentaordenante!=""){
		cargaAtt($pago, array("CtaOrdenante"=>$cuentaordenante));
	}
	if ($rfcemisorbeneficiario!=""){
		cargaAtt($pago, array("RfcEmisorCtaBen"=>$rfcemisorbeneficiario));
	}
	if ($cuentabeneficiario!=""){
		cargaAtt($pago, array("CtaBeneficiario"=>$cuentabeneficiario));
	}
	
	
	if ($tipocadena!=""){
		cargaAtt($pago, array("TipoCadPago"=>$tipocadena));
		
	}
	if ($certificadopago!=""){
		cargaAtt($pago, array("CertPago"=>$certificadopago));
	}
	if ($cadenapago!=""){
		cargaAtt($pago, array("CadPago"=>$cadenapago));
	}
	if ($sellopago!=""){
		cargaAtt($pago, array("SelloPago"=>$sellopago));
	}
	
	
	
	
	$arregloIDUUID=descomponerArreglo(9,0,$lista);
	$arregloFolio=descomponerArreglo(9,1,$lista);
	$arregloMoneda=descomponerArreglo(9,2,$lista);
	$arregloTipoCambio=descomponerArreglo(9,3,$lista);
	$arregloMetodoPago=descomponerArreglo(9,4,$lista);
	$arregloNumParcialidad=descomponerArreglo(9,5,$lista);
	$arregloSaldoAnterior=descomponerArreglo(9,6,$lista);
	$arregloImportePagado=descomponerArreglo(9,7,$lista);
	$arregloSaldoInsoluto=descomponerArreglo(9,8,$lista);
	
	foreach ($arregloIDUUID as $clave => $valor) {
		$DesFolio=explode("-",$arregloFolio[$clave]);
		$Aserie=$DesFolio[0];
		$Afolio=$DesFolio[1];
		$docRel = $xml->createElement("pago10:DoctoRelacionado");
        $docRel = $pago->appendChild($docRel);
        cargaAtt($docRel, array(
               "IdDocumento"=>$arregloIDUUID[$clave],
			   "Serie"=>$Aserie,
               "Folio"=>$Afolio,
               "MonedaDR"=>$arregloMoneda[$clave],
               "MetodoDePagoDR"=>$arregloMetodoPago[$clave],
               "NumParcialidad"=>$arregloNumParcialidad[$clave],
               "ImpSaldoAnt"=>number_format($arregloSaldoAnterior[$clave],2,'.',''),
               "ImpPagado"=>number_format($arregloImportePagado[$clave],2,'.',''),
               "ImpSaldoInsoluto"=>number_format($arregloSaldoInsoluto[$clave],2,'.','')
            )
        );
		
		if($arregloMoneda[$clave]!=$moneda){
			 cargaAtt($docRel, array(
               "TipoCambioDR"=>$arregloTipoCambio[$clave]));
		}
	
	}
	
	
	
    
//==============================================================================

    #== 11.6 Termina de conformarse la "Cadena original" con doble ||
    $cadena_original .= "|";
	echo $cadena_original;

    
### 14. FUNCIONES DEL MÓDULO #########################################################
        
    # 14.1 Función que integra los nodos al archivo .XML y forma la "Cadena original".
    
	
}else{
	$mensaje="fracaso@Operaci&oacute;n fallida@ $mensaje";
	echo $mensaje;
}
?>