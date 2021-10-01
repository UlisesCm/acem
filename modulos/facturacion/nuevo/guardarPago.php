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
	//if($_SESSION['empresa']=="facturacion" or $_SESSION['empresa']=="modula" or $_SESSION['empresa']=="modulalite"){
    	//$username = "controlescolarenlinea@gmail.com";
    	//$password = "CtrlEsc@26"; 
		//$urlFinkok="https://demo-facturacion.finkok.com/servicios/soap/stamp.wsdl";
	//}else{
		$username = 'kenzzo.ba@gmail.com';
		$password = 'KENzzo1!';
		$urlFinkok = "https://facturacion.finkok.com/servicios/soap/stamp.wsdl";
	//}
	
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
	//echo $cadena_original;

    #== 11.7 Proceso para obtener el sello digital del archivo .pem.key ========
    $keyid = openssl_get_privatekey(file_get_contents($SendaPEMS.$file_key));
    openssl_sign($cadena_original, $crypttext, $keyid, OPENSSL_ALGO_SHA256);
    openssl_free_key($keyid);
    

    #== 11.8 Se convierte la cadena digital a Base 64 ==========================
    $sello = base64_encode($crypttext);  
	 
      
    
    #== 11.9 Proceso para extraer el certificado del sello digital ============
    $file = $SendaPEMS.$file_cer;      // Ruta al archivo
    $datos = file($file);
    $certificado = ""; 
    $carga=false;  
    for ($i=0; $i<sizeof($datos); $i++){
        if (strstr($datos[$i],"END CERTIFICATE")) $carga=false;
        if ($carga) $certificado .= trim($datos[$i]);

        if (strstr($datos[$i],"BEGIN CERTIFICATE")) $carga=true;
    }    
    
    #== 11.10 Se continua con la integración de nodos ===========================   
    $root->setAttribute("Sello",$sello);
    $root->setAttribute("Certificado",$certificado);   # Certificado.
    
    
    #== Fin de la integración de nodos =========================================
	
    
    
    $NomArchCFDI = $SendaCFDI.$nombreArchivo.".xml"; 
    
    
    #=== 11.12 Se guarda el archivo .XML antes de ser timbrado =======================
    $cfdi = $xml->saveXML();
    $xml->formatOutput = true;             
	$xml->save($NomArchCFDI); // Guarda el archivo .XML (sin timbrar) en el directorio predeterminado. QUITAR CUANDO NO HAGA FALTA ARMANDO ARMANDO ARMANDO ARMANDO
    unset($xml);
    
    #=== 11.13 Se dan permisos de escritura al archivo .xml. =========================
//    chmod($NomArchCFDI, 0777); 
    
    
##### FIN DE LA CREACIÓN DEL ARCHIVO .XML ANTES DE SER TIMBRADO ####################################################   
    
    
### 12. PROCESO DE TIMBRADO ######################################################## 
    
    #== 12.1 Se crea una variable de tipo DOM y se le carga el CFDI =================================
    $xml2 = new DOMDocument();
    $xml2->loadXML($cfdi); 

    
    #== 12.2 Convirtiendo el contenido del CFDI a BASE 64 ======================
    $xml_cfdi_base64 = base64_encode($cfdi);

    
    #== 12.3 Datos de acceso al servidor de pruebas ============================
    $process  = curl_init($urlFinkok);     
    
    #== 12.4 Datos de acceso al servidor de producción =========================
    # $process = curl_init('https://facturacion.finkok.com/servicios/soap/stamp.wsdl');    
    
    
#== 12.5 Creando el SOAP de envío ==============================================
    
$cfdixml = <<<XML
<SOAP-ENV:Envelope xmlns:ns0="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:ns1="http://facturacion.finkok.com/stamp"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/">
    <SOAP-ENV:Header/>
    <ns0:Body>
        <ns1:stamp>
            <ns1:xml>$xml_cfdi_base64</ns1:xml>
            <ns1:username>$username</ns1:username>
            <ns1:password>$password</ns1:password>
        </ns1:stamp>
    </ns0:Body>
</SOAP-ENV:Envelope>
XML;
  
    #== 12.6 Proceso para guardar los datos que se envían al servidor en un archivo .XML ========================
    $NomArchSoap = $SendaCFDI."DatosEnvio_".$NoFac.".xml";

        #== 12.6.1 Si el archivo ya se encuentra se elimina ===========================
        if (file_exists ($NomArchSoap)==true){
            unlink($NomArchSoap);
        }
    
        #== 12.6.2 Se crea el archivo .XML con el SOAP ================================
//        $fp = fopen($NomArchSoap,"a");
//        fwrite($fp, $cfdixml);
//        fclose($fp);     
//        chmod($NomArchSoap, 0777);
    
       

    #== 12.8 Se envía el contenido del SOAP al servidor del PAC =====================
    curl_setopt($process, CURLOPT_HTTPHEADER, array('Content-Type: text/xml',' charset=utf-8'));
    curl_setopt($process, CURLOPT_POSTFIELDS, $cfdixml);  
    curl_setopt($process, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($process, CURLOPT_POST, true);
    curl_setopt($process, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($process, CURLOPT_SSL_VERIFYHOST, false);
    $RespServ = curl_exec($process);
         

    curl_close($process);    
    
## FIN DEL PROCESO DE TIMBRADO #################################################
    
    
    
    
## 13. PROCESOS POSTERIORES AL TIMBRADO ########################################
    
    #== 13.1 Se asigna la respuesta del servidor a una variable de tipo DOM ====
    $VarXML = new DOMDocument();
    $VarXML->loadXML($RespServ);

    #== 13.2 Se graba la respuesta del servidor a un archivo .xml
//    $VarXML->save($SendaCFDI."RespServ_Factura_".$NoFac.".xml");
//    chmod($SendaCFDI."RespServ_Factura_".$NoFac.".xml", 0777);


    #== 13.3 Se asigna el contenido del tag "xml" a una variable ===============
    $RespServ = $VarXML->getElementsByTagName('xml');


    #== 13.4 Se obtiene el valor del nodo ======================================
    foreach($RespServ as $Nodo){
        $valor_del_nodo = $Nodo->nodeValue; 
    }

        
        #== Si el nodo contiene datos se realizan los siguientes procesos ======
        if($valor_del_nodo != ""){

            // unlink($SendaCFDI."xlst_".$NoFac.".xml"); <-- Puede ser descomentado para eliminar el archivo .XML sin timbrar.


            #=== 13.6 Guardando el CFDI en archivo .XML  ============================

            $NomArchXML = $nombreArchivo.".xml";
            $NomArchPDF = "CFDI-33_Factura_".$NoFac.".pdf";

            $xmlt = new DOMDocument();
            $xmlt->loadXML($valor_del_nodo);
            $xmlt->save($SendaCFDI.$NomArchXML); 
            chmod($SendaCFDI.$NomArchXML, 0777);
            
                #== 13.6.1 Convertir archivo .XML a UTF-8 (OPCIONAL).
                $file_name = $SendaCFDI.$NomArchXML;
                $f = file_get_contents($file_name);
                $f = iconv("WINDOWS-1252", "UTF-8", $f);
                file_put_contents($file_name, "\xEF\xBB\xBF".$f);
                

            #== 13.7 Procesos para extraer datos del Timbre Fiscal del CFDI =========
            $docXML = new DOMDocument();
            $docXML->load($SendaCFDI.$NomArchXML);
            $comprobante = $docXML->getElementsByTagName("TimbreFiscalDigital");

            #== 13.8 Se obtienen contenidos de los atributos y se asignan a variables para ser mostrados =======
            foreach($comprobante as $timFis){
                    $version_timbre = $timFis->getAttribute('Version');
                    $sello_SAT      = $timFis->getAttribute('SelloSAT');
                    $cert_SAT       = $timFis->getAttribute('NoCertificadoSAT'); 
                    $sello_CFD      = $timFis->getAttribute('SelloCFD'); 
                    $tim_fecha      = $timFis->getAttribute('FechaTimbrado'); 
                    $tim_uuid       = $timFis->getAttribute('UUID'); 
					
					$foliointerno=$serie."-".$folio;
					$fechaAlta=date("Y-m-d");
					$fechaPago=date("Y-m-d");
					
					$metodoDePago="PPD";
					$clasificacion="CREDITO";
					$montoPagado=$total;
					$estadoCFDI="PENDIENTE";
					/////////////////* MODULO DE FACTURACION INTEGRADO
					if (isset($_SESSION['DATOSPAGO']) && $_SESSION['DATOSPAGO'] !="") {
						$idsrelacionadas=$_SESSION["DATOSPAGO"];
					}else{
						$idsrelacionadas="";
					}
					/////////////////* FIN MODULO DE FACTURACION INTEGRADO
					
					if($Ofactura->guardar($foliointerno,$fechaAlta,$tipocomprobante,$clasificacion,$razonsocialEmisor,$rfcEmisor,$razonsocialReceptor,$rfcReceptor,$total,$montoPagado,"PAGADO",$fechaPago,$formapago,"",$tim_uuid,$observaciones,$comprobantesRelacionados,$rutaEmpresaTrunca.$nombreArchivo, $moneda, $tipocambio,"1",$idsrelacionadas,"activo")){
						
						/////////////////* MODULO DE FACTURACION INTEGRADO
						if (isset($_SESSION['DATOSPAGO']) && $_SESSION['DATOSPAGO'] !="") {
							$Ofactura->consultaLibre("UPDATE pagos SET estadopago='CON REP', uuidpago='$tim_uuid' WHERE idpago IN ($idsrelacionadas)");
						}
						$pagosRelacionados=explode(",",$idsrelacionadas);
						foreach ($pagosRelacionados as $clave => $valor) {
							$resPago=$Ofactura->consultaLibre("SELECT ventas.foliofiscal AS uuidfac FROM pagos INNER JOIN ventas ON ventas.idventa=pagos.idventa WHERE pagos.idpago='$valor'");
							if ($resPago){
								$extractor = mysqli_fetch_array($resPago);
								$uuidfac=$extractor["uuidfac"];
							}else{
								$uuidfac="";
							}
							$Ofactura->consultaLibre("UPDATE pagos SET uuidfactura='$uuidfac' WHERE idpago='$valor'");
						}
						/////////////////* FIN MODULO DE FACTURACION INTEGRADO
						
						$mensaje="exito@Factura generada@La factura ha sido timbrada con &eacute;xito. @".$rutaEmpresaTrunca.$nombreArchivo."@$rfcReceptor@$razonsocialReceptor";
						$resres="";
						$resres2="";
						//CREAR LAS RELACIONES EN LAS BASE DE DATOS
						//RELACIONES DE DOCUMENTOS RELACIONADOS
						if($tiporelacion!=""){
							for ($i=0; $i<count($arregloUUID); $i++){
								$resres=$Ofactura->guardarRelacion($tim_uuid, $arregloUUID[$i], $tiporelacion, $tipocomprobante);
							}
						}
						//RELACIONES DE PAGOS Y ACTUALIZACIÓN DE DATOS
						for ($i=0; $i<count($arregloIDUUID); $i++){
							$resres2=$Ofactura->guardarRelacion($tim_uuid, $arregloIDUUID[$i], "pago", $tipocomprobante);
							$importepagado=$arregloImportePagado[$i];
							$fecha_pago=$fecha;
							$foliofiscal=$arregloIDUUID[$i];
							$saldoanterior=$arregloSaldoAnterior[$i];
							if ($importepagado>=$saldoanterior){
								$estatusPago="PAGADO";
							}else{
								$estatusPago="PENDIENTE";
							}
							$Ofactura->consultaLibre("UPDATE facturacion SET montopagado=montopagado+$importepagado, numparcialidad=numparcialidad+1, fechapago='$fecha_pago', estado='$estatusPago' WHERE foliofiscal='$foliofiscal'");
						}
							
						if($resres=="fracaso"){
							$mensaje="exito@Factura generada@La factura ha sido timbrada con &eacute;xito pero NO SE GUARDARON LAS RELACIONES @".$rutaEmpresaTrunca.$nombreArchivo."@$rfcReceptor@$razonsocialReceptor";
						}
					}
					$Ofactura->avanzarFolio($codigopostal);
            }
             
            
            #== 13.9 Se crea el archivo .PNG con codigo bidimensional =================================
            $filename = "Qr/Img_".$tim_uuid.".png";
            $CadImpTot = ProcesImpTot($total);
            $Cadena = "?re=".$rfcEmisor."&rr=".$rfcReceptor."&tt=".$CadImpTot."&id=".$tim_uuid;
            QRcode::png($Cadena, $filename, 'H', 3, 2);    
            chmod($filename, 0777); 
			//Creamos el archivo PDF
			include("crearPDFpago.php");
			unlink($filename);   
          
        }else{
            
            #== 13.11 En caso de error de timbrado se muestran los detalles al usuario.
            
            $codigoError = $VarXML->getElementsByTagName('CodigoError');

            foreach($codigoError as $NodoStatus){
                $valorNod = $NodoStatus->nodeValue; 
            }   
			
			$mensajeError = $VarXML->getElementsByTagName('MensajeIncidencia');

            foreach($mensajeError as $NodoStatus2){
                $valorNod2 = $NodoStatus2->nodeValue; 
            }  
			$mensaje="El PAC ha reportado un problema: (".$valorNod.")</br>".$valorNod2;
			$mensaje="fracaso@Operaci&oacute;n fallida@ $mensaje";
        }
		echo $mensaje;
        
##### FIN DE PROCEDIMIENTOS ####################################################      


        
    
    
### 14. FUNCIONES DEL MÓDULO #########################################################
        
    # 14.1 Función que integra los nodos al archivo .XML y forma la "Cadena original".
    
	
}else{
	$mensaje="fracaso@Operaci&oacute;n fallida@ $mensaje";
	echo $mensaje;
}
?>