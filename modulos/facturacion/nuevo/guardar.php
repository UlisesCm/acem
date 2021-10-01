<?php 
include ("../../seguridad/comprobar_login.php");
include("../../../librerias/php/qrlib/qrlib.php");
include("../componentes/numerosaletras.php");
include("../../../librerias/php/validaciones.php");
require("../../productos/Producto.class.php");
require('../Facturacion.class.php');
date_default_timezone_set("America/Mexico_City");
$Oproducto=new Producto;
$Ofactura=new Facturacion;

$rutaEmpresa="../../../empresas/".$_SESSION["empresa"]."/";

$mensaje="";
$validacion=true;

if (isset($_POST['idtemporal'])){
	$idtemporal=htmlentities(trim($_POST['idtemporal']));
	$idtemporal=trim($idtemporal);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idtemporal no es correcto</p>";
}

if (isset($_POST['idcliente'])){
	$idcliente=htmlentities(trim($_POST['idcliente']));
	$idcliente=trim($idcliente);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idcliente no es correcto</p>";
}


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


if (isset($_POST['condiciones'])){
	$condiciones=htmlentities(trim($_POST['condiciones']));
	$condiciones=trim($condiciones);
	
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

if (isset($_POST['idsucursal'])){
	$idsucursal=htmlentities(trim($_POST['idsucursal']));
	$idsucursal=trim($idsucursal);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idsucursal no es correcto</p>";
}

if (isset($_POST['codigopostal'])){
	$codigopostal=htmlentities(trim($_POST['codigopostal']));
	$codigopostal=trim($codigopostal);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo CP no es correcto</p>";
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
    	$username = 'kenzzo.ba@gmail.com';
		$password = 'KENzzo1!'; 
		//https://demo-facturacion.finkok.com/servicios/soap/cancel.wsdl
		$urlFinkok="https://demo-facturacion.finkok.com/servicios/soap/stamp.wsdl";
	//}else{
		//$username = 'kenzzo.ba@gmail.com';
		//$password = 'KENzzo1!';
		//$urlFinkok = "https://facturacion.finkok.com/servicios/soap/stamp.wsdl";
	//}
	
	
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
    $condicionesDePago = $condiciones;                   // 4.12 Condiciones de pago.
    $formaDePago       = $formapago;                            // 4.13 Forma de pago.
    $metodoDePago      = $metodopago;                           // 4.14 Clave del método de pago. Consultar catálogos de métodos de pago del SAT.
    $TipoCambio        = $tipocambio;                               // 4.15 Tipo de cambio de la moneda.
    $LugarExpedicion   = $codigopostal;                         // 4.16 Lugar de expedición (código postal).
    $moneda            = $moneda;                           // 4.17 Moneda
    $totalImpuestosRetenidos   = 0;                       // 4.18 Total de impuestos retenidos (se calculan mas abajo).
    $totalImpuestosTrasladados = 0;						 // 4.19 Total de impuestos trasladados (se calculan mas abajo).
	$tiporelacion=$tiporelacion;
	$comprobantesRelacionados="";
	$idsReferencias=""; //Ids de las ventas o detalles de ventas, cuando se realiza la factura desde la consulta de ventas
	                    
	
	
	### 6. ARRAYS QUE CONTIENEN LOS ARTICULOS QUE FORMAN PARTE DE LA VENTA #####################
	
	$arregloIdproducto=descomponerArreglo(6,0,$lista);
	$Array_Cantidad=descomponerArreglo(6,1,$lista);
	$Array_ValorUnitario=descomponerArreglo(6,2,$lista);
	$Array_Descuento=descomponerArreglo(6,3,$lista);
	$Array_DescripcionEgresos=descomponerArreglo(6,4,$lista);
	$Array_Idreferencia=descomponerArreglo(6,5,$lista);

	$Array_ClaveProdServ =crearArray($arregloIdproducto, "idcategoria", "categorias","codigo","extra");
	$Array_ClaveUnidad=crearArray($arregloIdproducto, "idunidad", "unidades","codigo","extra");
	$Array_NoIdentificacion=crearArray($arregloIdproducto, "codigo", "","","simple");
	$Array_Descripcion=crearArray($arregloIdproducto, "nombre", "","","simple");
	$Array_Unidad=crearArray($arregloIdproducto, "idunidad", "unidades","nombre","extra");
	$Array_Importe=calcularImporteArray($Array_Cantidad,$Array_ValorUnitario);
	if($tipocomprobante=="E"){
		$Array_Descripcion=$Array_DescripcionEgresos;
		foreach ($Array_ClaveProdServ as $clave => $valor) {
			$Array_ClaveProdServ[$clave]="84111506";
			$Array_NoIdentificacion[$clave]="FFC";
			$Array_ClaveUnidad[$clave]="ACT";
			$Array_Unidad[$clave]="ACT";
		}
	}
	
	### 6. ARRAYS QUE CONTIENEN LOS DOCUMENTOS RELACIONADOS #####################
	$arregloUUID=array();
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
	
	
	

	
	
	
	### 8 DETERMINANDO TOTALES ###################################################    

	$totalIVAretenido=0;
	$totalIVAtrasladado=0;
	$totalISRretenido=0;
	$totalIEPSretenido=0;
	$totalIEPStrasladado=0;
	
	$ivaretenido=0;
	$ivatrasladado=0;
	$isrretenido=0;
	$iepsretenido=0;
	$iepstrasladado=0;
	$descuento=0;
	$subTotal=0;
	$importeSok=0;


	$arregloIdproducto=descomponerArreglo(6,0,$lista);
	$Array_Cantidad=descomponerArreglo(6,1,$lista);
	$Array_ValorUnitario=descomponerArreglo(6,2,$lista);
	$Array_Descuento=descomponerArreglo(6,3,$lista);
	$Array_DescripcionEgresos=descomponerArreglo(6,4,$lista);
	$Array_Idreferencia=descomponerArreglo(6,5,$lista);
	
	$Array_Impuestos_impuesto=array();
	$Array_Impuestos_tipo=array();
	$Array_Impuestos_factor=array();
	$Array_Impuestos_valor=array();
	$Array_Impuestos_importe=array();
	$Array_Impuestos_Label=array();
		
	$con=0;
	$exentosUnicamente="si";
	$hayimpuestostrasladados=false;
	$hayimpuestosretenidos=false;
	
	while ($con < count($arregloIdproducto)){
		$idproducto=$arregloIdproducto[$con];
		$cantidad=round($Array_Cantidad[$con],6);
		$preciounitario=round($Array_ValorUnitario[$con],6);
		$descuentounitario=round($Array_Descuento[$con],6); 
		$idsReferencias=$idsReferencias.$Array_Idreferencia[$con].",";
	
		$idmodeloimpuestos=$Oproducto->obtenerCampo("idmodeloimpuestos",$idproducto);
		$resultado=$Oproducto->consultaLibre("SELECT * FROM impuestos WHERE idmodeloimpuesto='$idmodeloimpuestos'");
	
		$subTotal=$subTotal+($cantidad*$preciounitario);
		$subTotal=round($subTotal,$DECIMALES);
		$subTotal=number_format($subTotal, $DECIMALES, '.', '');
		
		$descuento=$descuento+(round($cantidad*$descuentounitario,$DECIMALES));
		$descuento=round($descuento,$DECIMALES);
		$descuento=number_format($descuento, $DECIMALES, '.', '');
		
		
		
		$impuestosLabel="";
	
		while ($filas=mysqli_fetch_array($resultado)) {
			$clavesat=$filas['clavesat'];
			$impuesto=$filas['nombre'];
			$tipo=$filas['tipo'];
			$factor=$filas['factor'];
			$valor=$filas['valor'];
			
			$importeSok=(($cantidad*$preciounitario)*$valor);
			$importeSok=round($importeSok,$DECIMALES);
			$importeSok=number_format($importeSok, $DECIMALES, '.', '');
			
			$tipoLabesok="";
			if ($tipo=="RETENCION"){
				$tipoLabesok="RET";
			}
			if($tipo=="TRASLADO"){
				$tipoLabesok="TRA";
			}
			
			$impuestosLabel=$impuestosLabel."<p style='margin-top:0; margin-bottom:0;'>$clavesat ($impuesto) - $tipoLabesok | $factor: $valor | \$".number_format($importeSok,$DECIMALES)."</p>";
			
			$impuestosEncontrados=false;
			$donde=0;
			

			foreach ($Array_Impuestos_impuesto as $clv => $dato) {
				$impuestosImpuesto=$Array_Impuestos_impuesto[$clv];
				$impuestosTipo=$Array_Impuestos_tipo[$clv];
				$impuestosFactor=$Array_Impuestos_factor[$clv];
				$impuestosValor=$Array_Impuestos_valor[$clv];
					
				if($impuestosImpuesto==$clavesat and $impuestosTipo==$tipo and $impuestosFactor==$factor and $impuestosValor==$valor and $impuestosEncontrados==false){
					$impuestosEncontrados=true;
					$donde=$clv;
					//echo "Enocntrado ";
				}
			}
			
			
			if($impuestosEncontrados){
				$Array_Impuestos_importe[$donde]=$Array_Impuestos_importe[$donde]+$importeSok;
			}else{
				array_push($Array_Impuestos_tipo, $tipo);
				array_push($Array_Impuestos_impuesto, $clavesat);
				array_push($Array_Impuestos_factor, $factor);
				array_push($Array_Impuestos_valor, $valor);
				array_push($Array_Impuestos_importe, $importeSok);
				//echo "Cantidad: ".$cantidad." Precio:".$preciounitario." Valor".$valor." = ".(($cantidad*$preciounitario)*$valor)."</br>";
			}
			
		
			
			if ($clavesat=="001"){ // Si es ISR
				if ($tipo=="RETENCION"){
					$totalISRretenido=$importeSok;
					$hayimpuestosretenidos=true;
					$isrretenido=$isrretenido+$totalISRretenido;
				}
			}// Fin Si es ISR
			if ($clavesat=="002"){ // Si es IVA
				if ($tipo=="RETENCION"){
					$totalIVAretenido=$importeSok;
					$hayimpuestosretenidos=true;
					$ivaretenido=$ivaretenido+$totalIVAretenido;
				}
				if ($tipo=="TRASLADO"){
					$totalIVAtrasladado=$importeSok;
					if($factor!="Exento"){
						$exentosUnicamente="no";
					}
					$hayimpuestostrasladados=true;
					$ivatrasladado=$ivatrasladado+$totalIVAtrasladado;
				}
			}// Fin Si es IVA
			if ($clavesat=="003"){ // Si es IEPS
				if ($tipo=="RETENCION"){
					$totalIEPSretenido=$importeSok;
					$hayimpuestosretenidos=true;
					$iepsretenido=$iepsretenido+$totalIEPSretenido;
				}
				if ($tipo=="TRASLADO"){
					$totalIEPStrasladado=$importeSok;
					if($factor!="Exento"){
						$exentosUnicamente="no";
					}
					$hayimpuestostrasladados=true;
					$iepstrasladado=$iepstrasladado+$totalIEPStrasladado;
				}
			}// Fin Si es IEPS
			
		} // Fin de while para obtener los impuestos
		
		
		array_push($Array_Impuestos_Label, $impuestosLabel);
		$con++;
	}
	$idsReferencias=substr($idsReferencias, 0, -1);


	//$subTotal=$subTotal+($cantidad*$preciounitario);
	//$descuento=$descuento+$descuentounitario;
	
	$isrretenido=round($isrretenido,$DECIMALES);
	$ivaretenido=round($ivaretenido,$DECIMALES);
	$iepsretenido=round($iepsretenido,$DECIMALES);
	
	$ivatrasladado=round($ivatrasladado,$DECIMALES);
	$iepstrasladado=round($iepstrasladado,$DECIMALES);
	
	$totalImpuestosRetenidos=$isrretenido+$ivaretenido+$iepsretenido;
	$totalImpuestosRetenidos=round($totalImpuestosRetenidos,$DECIMALES);
	$totalImpuestosTrasladados=$ivatrasladado+$iepstrasladado;
	$totalImpuestosTrasladados=round($totalImpuestosTrasladados,$DECIMALES);
	$descuento=round($descuento,$DECIMALES);
	$descuento=number_format($descuento, $DECIMALES, '.', '');
	
	$subTotal=round($subTotal,$DECIMALES);
	$subTotal=number_format($subTotal, $DECIMALES, '.', '');

	
	if($hayish==1){
		$ish=($tasaish/100)*$subTotal;
		$ish=round($ish,$DECIMALES);
		$ish=number_format($ish, $DECIMALES, '.', '');
	}
	
	if($hayimpuestocedular=="si"){
		$impCedular=($tasaimpuestocedular/100)*$subTotal;
		$impCedular=round($impCedular,$DECIMALES);
		$impCedular=number_format($impCedular, $DECIMALES, '.', '');
	}
	
	$total=$subTotal-$descuento+$totalImpuestosTrasladados-$totalImpuestosRetenidos-$impCedular+$ish;
	$total=round($total,$DECIMALES);
	$total=number_format($total, $DECIMALES, '.', '');
	
	
	
	
    


### 11. CREACIÓN Y ALMACENAMIENTO DEL ARCHIVO .XML (CFDI) ANTES DE SER TIMBRADO ###################
    
    #== 11.1 Creación de la variable de tipo DOM, aquí se conforma el XML a timbrar posteriormente.
    $xml = new DOMdocument('1.0', 'UTF-8'); 
    $root = $xml->createElement("cfdi:Comprobante");
    $root = $xml->appendChild($root); 
    
    $cadena_original='||';
    $noatt=  array();
    
   #== 11.2 Se crea e inserta el primer nodo donde se declaran los namespaces ======
    cargaAtt($root, array("xsi:schemaLocation"=>"http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv33.xsd",
            "xmlns:cfdi"=>"http://www.sat.gob.mx/cfd/3",
            "xmlns:xsi"=>"http://www.w3.org/2001/XMLSchema-instance"
        )
    );
    
    #== 11.3 Rutina de integración de nodos =========================================
    cargaAtt($root, array(
             "Version"=>"3.3", 
             "Serie"=>$fact_serie,
             "Folio"=>$fact_folio,
             "Fecha"=>date("Y-m-d")."T".date("H:i:s"),
             "FormaPago"=>$formaDePago,
             "NoCertificado"=>$noCertificado,
             "CondicionesDePago"=>$condicionesDePago,
             "SubTotal"=>$subTotal,
             "Moneda"=>$moneda,
             "TipoCambio"=>$TipoCambio,
             "Total"=>$total,
             "TipoDeComprobante"=>$fact_tipcompr,
             "MetodoPago"=>$metodoDePago,
             "LugarExpedicion"=>$LugarExpedicion
          )
       );

	   if ($descuento!=0){
		   cargaAtt($root, array("Descuento"=>$descuento));
	   }
    
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
    cargaAtt($receptor, array("Rfc"=>$receptor_rfc,
                    "Nombre"=>$receptor_rs,
                    "UsoCFDI"=>$uso
                )
            );
    
    
    $conceptos = $xml->createElement("cfdi:Conceptos");
    $conceptos = $root->appendChild($conceptos);
    
    #== 11.4 Ciclo "for", recopilación de datos de artículos e integración de sus respectivos nodos =
    
	
		
    for ($i=0; $i<count($Array_Cantidad); $i++){
		$haytraslados=false;
		$hayretencion=false;
		
		$productos=$Array_ClaveProdServ[$i].":::".$Array_NoIdentificacion[$i].":::".round($Array_Cantidad[$i],6).":::".$Array_ClaveUnidad[$i].":::".round($Array_ValorUnitario[$i],6).":::".round(round($Array_Descuento[$i],6)*round($Array_Cantidad[$i],6),6).":::".round($Array_Importe[$i],$DECIMALES).":::".$Array_Descripcion[$i].":::";
		
       	
        $concepto = $xml->createElement("cfdi:Concepto");
        $concepto = $conceptos->appendChild($concepto);
        cargaAtt($concepto, array(
               "ClaveProdServ"=>$Array_ClaveProdServ[$i],
               "NoIdentificacion"=>$Array_NoIdentificacion[$i],
               "Cantidad"=>round($Array_Cantidad[$i],6),
               "ClaveUnidad"=>$Array_ClaveUnidad[$i],
               "Unidad"=>$Array_Unidad[$i],
               "Descripcion"=>$Array_Descripcion[$i],
               "ValorUnitario"=>round($Array_ValorUnitario[$i],6),
               "Importe"=>number_format(round($Array_Importe[$i],$DECIMALES),$DECIMALES,'.','')
            )
        );
		
		$importeDescuento=round(round($Array_Descuento[$i],6)*round($Array_Cantidad[$i],6),$DECIMALES);
		$importeDescuento=number_format($importeDescuento,$DECIMALES,".","");
		
		if($importeDescuento!=0){
			cargaAtt($concepto, array("Descuento"=>$importeDescuento));
		}
    
        
		
		$idmodeloimpuestos=$Oproducto->obtenerCampo("idmodeloimpuestos",$arregloIdproducto[$i]);
		$resultado=$Oproducto->consultaLibre("SELECT * FROM impuestos WHERE idmodeloimpuesto='$idmodeloimpuestos' ORDER BY tipo DESC");
		
		$base=round($Array_Cantidad[$i]*$Array_ValorUnitario[$i],6); ///////IMPORTANTE PARA HACER LOS CALCULOS CORRECTOS, SE CAMBIO EL VALOR DE DECIMALES DE LA MOENDA A 6 DECIMAELES PARA QUE EL CALUCLO LO RELAICE EXACTO EL SISTEMA////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		
		$impuestos = $xml->createElement("cfdi:Impuestos");
        $impuestos = $concepto->appendChild($impuestos);
		
		while ($filas=mysqli_fetch_array($resultado)) {
			$clavesat=$filas['clavesat'];
			$impuesto=$filas['nombre'];
			$tipo=$filas['tipo'];
			$factor=$filas['factor'];
			$valor=$filas['valor'];
			$importe=$base*$valor;
			
			if ($tipo=="TRASLADO"){
				if($haytraslados==false){
					$Traslados = $xml->createElement("cfdi:Traslados");
            		$Traslados = $impuestos->appendChild($Traslados);
					$haytraslados=true;
				}

				$Traslado = $xml->createElement("cfdi:Traslado");
                $Traslado = $Traslados->appendChild($Traslado);
				if($factor=="Exento"){ // Si el impuesto es Exento se registran solo la base, el impuesto y el tipo de factor
						cargaAtt($Traslado, array(
							"Base"=>$base,
							"Impuesto"=>$clavesat,
							"TipoFactor"=>$factor
						) 
					); 
				}else{ // Si el impuesto es es diferente a Exento se registran todos los campos
						cargaAtt($Traslado, array(
							"Base"=>$base,
							"Impuesto"=>$clavesat,
							"TipoFactor"=>$factor,
							"TasaOCuota"=>$valor,
							"Importe"=>round($importe,$DECIMALES)
						) 
					); 

				}
			}
			if ($tipo=="RETENCION"){
				if($hayretencion==false){
					$Retenciones = $xml->createElement("cfdi:Retenciones");
            		$Retenciones = $impuestos->appendChild($Retenciones);
					$hayretencion=true;
				}
				$Retencion = $xml->createElement("cfdi:Retencion");
                $Retencion = $Retenciones->appendChild($Retencion);
				cargaAtt($Retencion, array(
                   		"Base"=>$base,
                   		"Impuesto"=>$clavesat,
                    	"TipoFactor"=>$factor,
                    	"TasaOCuota"=>$valor,
                    	"Importe"=>round($importe,$DECIMALES)
                	) 
            	);
			}
			
			
			
		} // Fin de while para obtener los impuestos

                
	}

#== 11.5 Impuestos retenidos y trasladados ==========================================

$Impuestos = $xml->createElement("cfdi:Impuestos");
$Impuestos = $root->appendChild($Impuestos);

	if($hayimpuestosretenidos){
    	$Retenciones = $xml->createElement("cfdi:Retenciones");
    	$Retenciones = $Impuestos->appendChild($Retenciones); 
	
		foreach ($Array_Impuestos_impuesto as $claveR => $valorR) {
			$impuestoTipo=$Array_Impuestos_tipo[$claveR];
			if($impuestoTipo=="RETENCION"){
				$claveImpuesto=$Array_Impuestos_impuesto[$claveR];
				$importeImpuesto=$Array_Impuestos_importe[$claveR];
				
				$Retencion = $xml->createElement("cfdi:Retencion");
				$Retencion = $Retenciones->appendChild($Retencion);
				cargaAtt($Retencion, array(
					"Impuesto"=>"$claveImpuesto",
					"Importe"=>round($importeImpuesto,$DECIMALES)
					) 
				);
			}
		}
            
	}
	cargaAtt($Impuestos, array("TotalImpuestosRetenidos"=>number_format($totalImpuestosRetenidos,$DECIMALES,".","")));
    if($hayimpuestostrasladados){  
	 	
		if ($exentosUnicamente=="no"){
			$Traslados = $xml->createElement("cfdi:Traslados");
			$Traslados = $Impuestos->appendChild($Traslados);
			
			foreach ($Array_Impuestos_impuesto as $claveT => $valorT) {
				
				$impuestoTipo=$Array_Impuestos_tipo[$claveT];
				if($impuestoTipo=="TRASLADO"){
					$claveImpuesto=$Array_Impuestos_impuesto[$claveT];
					$factorImpuesto=$Array_Impuestos_factor[$claveT];
					$valorImpuesto=$Array_Impuestos_valor[$claveT];
					$importeImpuesto=$Array_Impuestos_importe[$claveT];
					
					if($factorImpuesto!="Exento"){
						$Traslado = $xml->createElement("cfdi:Traslado");
						$Traslado = $Traslados->appendChild($Traslado);
						
						cargaAtt($Traslado, array(
							"Impuesto"=>"$claveImpuesto",
							"TipoFactor"=>$factorImpuesto,
							"TasaOCuota"=>$valorImpuesto,
							"Importe"=>round($importeImpuesto,$DECIMALES)
							) 
						); 
					}
				}
			}
		} // Fin si no hay solamente Exentos
	}
    cargaAtt($Impuestos, array("TotalImpuestosTrasladados"=>number_format($totalImpuestosTrasladados,$DECIMALES,".","")));

                         
    $complemento = $xml->createElement("cfdi:Complemento");
    $complemento = $root->appendChild($complemento);
	
	//Si hay impuestos de hospedaje ISH incluidos
	if($ish!=0 or $impCedular!=0){
		$implocal = $xml->createElement("implocal:ImpuestosLocales");
		$implocal = $complemento->appendChild($implocal);
		
		$impuestosEspecialesRetenidos=$impCedular; //Sumar otros impuestos retenidos que se puedan agregar con el tiempo
		$impuestosEspecialesTrasladados=$ish; //Sumar otros impuestos trasladados que se puedan agregar con el tiempo
		cargaAtt($implocal, array("xmlns:implocal"=>"http://www.sat.gob.mx/implocal","version"=>"1.0",
							"TotaldeRetenciones"=>$impuestosEspecialesRetenidos,
							"TotaldeTraslados"=>$impuestosEspecialesTrasladados,
							"xsi:schemaLocation"=>"http://www.sat.gob.mx/implocal http://www.sat.gob.mx/sitio_internet/cfd/implocal/implocal.xsd"));
		
		if($ish!=0){
			$trasladosLocales = $xml->createElement("implocal:TrasladosLocales");
			$trasladosLocales = $implocal->appendChild($trasladosLocales);
			cargaAtt($trasladosLocales, array("ImpLocTrasladado"=>"ISH","TasadeTraslado"=>$tasaish, "Importe"=>$ish));
		}
		if($impCedular!=0){
    		$retencionesLocales = $xml->createElement("implocal:RetencionesLocales");
    		$retencionesLocales = $implocal->appendChild($retencionesLocales);
    		cargaAtt($retencionesLocales, array("ImpLocRetenido"=>"CEDULAR","TasadeRetencion"=>$tasaimpuestocedular, "Importe"=>$impCedular));
		}
	
	}
	
	//Si hay impuestos cedulares incluidos
	
	
	
    
    #== 11.6 Termina de conformarse la "Cadena original" con doble ||
    $cadena_original .= "|";
	//echo $cadena_original;
	
	#=== 11.6.1 Se guarda el archivo .XML antes de ser timbrado =======================
    $NomArchCFDI = $SendaCFDI.$nombreArchivo.".xml"; 
	$cfdi = $xml->saveXML();
    $xml->formatOutput = true;             
	$xml->save($NomArchCFDI); // Guarda el archivo .XML (sin timbrar) en el directorio predeterminado. QUITAR CUANDO NO HAGA FALTA ARMANDO ARMANDO ARMANDO ARMANDO
    
	
	//ruta al archivo XML del CFDI
    $xmlFileX=$NomArchCFDI;
    // Ruta al archivo XSLT
    $xslFileX = "xslt33/cadenaoriginal_3_3.xslt"; 
    // Crear un objeto DOMDocument para cargar el CFDI
    $xmlX = new DOMDocument("1.0","UTF-8"); 
    // Cargar el CFDI
    $xmlX->load($xmlFileX);
    // Crear un objeto DOMDocument para cargar el archivo de transformación XSLT
    $xslX = new DOMDocument();
    $xslX->load($xslFileX);
    // Crear el procesador XSLT que nos generará la cadena original con base en las reglas descritas en el XSLT
    $procX = new XSLTProcessor;
    // Cargar las reglas de transformación desde el archivo XSLT.
    $procX->importStyleSheet($xslX);
    // Generar la cadena original y asignarla a una variable
    $cadenaOriginalX = $procX->transformToXML($xmlX);
    //echo $cadenaOriginalX;
    $cadena_original=$cadenaOriginalX;
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
	
    #=== 11.12 Se guarda el archivo .XML antes de ser timbrado =======================
    $NomArchCFDI = $SendaCFDI.$nombreArchivo.".xml"; 
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
					
					if($metodoDePago=="PUE"){
						$clasificacion="CONTADO";
						$montoPagado=$total;
						$estadoCFDI="PAGADO";
					}
					if($metodoDePago=="PPD"){
						$clasificacion="CREDITO";
						$montoPagado="0";
						$estadoCFDI="PENDIENTE";
					}
					
					$resultadoGuardado=$Ofactura->guardar($foliointerno,$fechaAlta,$tipocomprobante,$clasificacion,$razonsocialEmisor,$rfcEmisor,$razonsocialReceptor,$rfcReceptor,$subTotal,$total,$montoPagado,$estadoCFDI,$fechaPago,$formapago,"",$tim_uuid,$observaciones,$comprobantesRelacionados,$rutaEmpresaTrunca.$nombreArchivo, $moneda, $tipocambio,"1","","activo",$tiporelacion,$arregloUUID,$idtemporal,$idsReferencias,$codigopostal);
					
					if($resultadoGuardado=="exito"){
						$mensaje="exito@Factura generada@La factura ha sido timbrada con &eacute;xito. @".$rutaEmpresaTrunca.$nombreArchivo."@$rfcReceptor@$razonsocialReceptor";						$resres="";
					}else{
						$extramensaje="";
						if ($resultadoGuardado=="fracasoRelaciones"){
							$extramensaje="Las relaciones de la factura no se registraron";
						}
						if ($resultadoGuardado=="fracasoDetalle"){
							$extramensaje="No se actualizo el cfdi de los detalles de venta";
						}
						if ($resultadoGuardado=="fracasoSelectDetalle"){
							$extramensaje="No se obtuvieron resultados de la seleccion los detalles de venta";
						}
						if ($resultadoGuardado=="fracasoContarTotal"){
							$extramensaje="No se obtuvo el valor total de detalles de venta";
						}
						if ($resultadoGuardado=="fracasoContarFacturadas"){
							$extramensaje="No se obtuvo el valor total de detalles de venta facturados";
						}
						if ($resultadoGuardado=="fracasoActualizarCotizacion"){
							$extramensaje="No se actualizo el estado de facturacion de venta";
						}
						if ($resultadoGuardado=="fracasoArchivos"){
							$extramensaje="No se inserto el registro de archivos";
						}
						if ($resultadoGuardado=="fracasoFolios"){
							$extramensaje="No se actualizo el folio de la factura";
						}
						$mensaje="fracaso@No se pudo guardar la factura@Ha ocurrido un problema conocido: ($extramensaje). Por favor informe de este problema con el encargado de soporte informatico";
					}
					
            }
             
            
            #== 13.9 Se crea el archivo .PNG con codigo bidimensional =================================
            $filename = "Qr/Img_".$tim_uuid.".png";
            $CadImpTot = ProcesImpTot($total);
            $Cadena = "?re=".$rfcEmisor."&rr=".$rfcReceptor."&tt=".$CadImpTot."&id=".$tim_uuid;
            QRcode::png($Cadena, $filename, 'H', 3, 2);    
            chmod($filename, 0777); 
			//Creamos el archivo PDF
			include("crearPDF.php");
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