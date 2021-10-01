<?php 
include ("../../seguridad/comprobar_login.php");
$tipoempresa=$_SESSION["tipoempresa"];
include("../componentes/numerosaletras.php");
include("../../../librerias/php/validaciones.php");
require("../../productos$tipoempresa/Producto.class.php");
require('../Facturacion.class.php');
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


////////////////////////////////*******VALIDACION DEL COMPLEMENTO NOTARIAL******//////////////////////////////////////

if (isset($_POST['curpnotario']) && trim($_POST['curpnotario']) !=""){
	$curpnotario=htmlentities(trim($_POST['curpnotario']));
}else{
	$validacion=false;
	$mensaje=$mensaje." No se ha recibido la CURP del Notario.";
}

if (isset($_POST['numeronotaria']) && trim($_POST['numeronotaria']) !=""){
	$numeronotaria=htmlentities(trim($_POST['numeronotaria']));
}else{
	$validacion=false;
	$mensaje=$mensaje." No se ha recibido el Número de la Notaria.";
}

if (isset($_POST['entidadfederativa']) && trim($_POST['entidadfederativa']) !=""){
	$entidadfederativa=htmlentities(trim($_POST['entidadfederativa']));
}else{
	$validacion=false;
	$mensaje=$mensaje." No se ha recibido la Entidad Federativa del Notario.";
}

if (isset($_POST['adscripcion']) && trim($_POST['adscripcion']) !=""){
	$adscripcion=htmlentities(trim($_POST['adscripcion']));
}else{
	$adscripcion="";
}

if (isset($_POST['CheckSociedad'])){
	$sociedadEnajenantes=htmlentities(trim($_POST['CheckSociedad']));
	if ($sociedadEnajenantes=="si"){
		$sociedadEnajenantes="Si";
	}else{
		$sociedadEnajenantes="No";
	}
}else{
	$sociedadEnajenantes="No";
	//$validacion=true;
	//$mensaje=$mensaje." No se ha recibido el control de sociedad conyugal de los enajenantes";
}

if (isset($_POST['CheckSociedadAdquiriente'])){
	$sociedadAdquirientes=htmlentities(trim($_POST['CheckSociedadAdquiriente']));
	if ($sociedadAdquirientes=="si"){
		$sociedadAdquirientes="Si";
	}else{
		$sociedadAdquirientes="No";
	}
}else{
	$sociedadAdquirientes="No";
	//$validacion=false;
	//$mensaje=$mensaje." No se ha recibido el control de sociedad conyugal de los adquirientes";
}

if (isset($_POST['IVAOperacion']) && trim($_POST['IVAOperacion']) !=""){
	$ivaNotario=htmlentities(trim($_POST['IVAOperacion']));
	if (!is_numeric($ivaNotario)){
		$validacion=false;
		$mensaje=$mensaje." El IVA de la contraprestación no es numerico";
	}
}else{
	$mensaje=$mensaje." El IVA de la contraprestación no es numerico";
	$validacion=false;
	$ivaNotario=0;
}

if (isset($_POST['SubtotalOperacion']) && trim($_POST['SubtotalOperacion']) !=""){
	$SubtotalNotario=htmlentities(trim($_POST['SubtotalOperacion']));
	if (!is_numeric($SubtotalNotario)){
		$validacion=false;
		$mensaje=$mensaje." El Subtotal de la contraprestación no es numerico";
	}
}else{
	$mensaje=$mensaje." El Subtotal de la contraprestación no es numerico";
	$validacion=false;
	$SubtotalNotario=0;
}

if (isset($_POST['MontoOperacion']) && trim($_POST['MontoOperacion']) !=""){
	$MontoOperacion=htmlentities(trim($_POST['MontoOperacion']));
	if (!is_numeric($MontoOperacion)){
		$validacion=false;
		$mensaje=$mensaje." El Monto de la operación no es numerico";
	}
}else{
	$mensaje=$mensaje." El Monto de la operación no es numerico";
	$validacion=false;
	$MontoOperacion=0;
}

if (isset($_POST['FechaInstNotarial']) && trim($_POST['FechaInstNotarial']) !=""){
	$FechaInstNotarial=htmlentities(trim($_POST['FechaInstNotarial']));		
}else{
	$validacion=false;
	$mensaje="Formato de fecha inválido. Escriba la fecha utilizando el siguiente formato: dd/mm/aaaa";
}

if (isset($_POST['NumInstrumentoNotarial']) && trim($_POST['NumInstrumentoNotarial']) !=""){
	$NumInstrumentoNotarial=htmlentities(trim($_POST['NumInstrumentoNotarial']));
	if (!is_numeric($NumInstrumentoNotarial)){
		$validacion=false;
		$mensaje=$mensaje." El Número de Instrumento Notarial no es correcto. Ingrese únicamente números";
	}
	if ($NumInstrumentoNotarial > 999999 or $NumInstrumentoNotarial < 1){
		$validacion=false;
		$mensaje=$mensaje." El Número de Instrumento Notarial no es correcto.";
	}
}else{
	$validacion=false;
	$NumInstrumentoNotarial=0;
}

//VALIDACION DE LA LISTA DE INMUEBLES
if (isset($_POST['listaInmuebles']) && trim($_POST['listaInmuebles']) !=""){
	$inmuebles=trim($_POST['listaInmuebles']);
}else{
	$inmuebles=0;
	$validacion=false;
	$mensaje=$mensaje." No se ha recibido la lista de inmuebles";
}

$inmuebles=rtrim($inmuebles,":::");
$inmuebles=explode(":::",$inmuebles);
if ($validacion){
	if (!(count($inmuebles)%11==0) and (count($inmuebles)==0)){
		$validacion=false;
		$mensaje=$mensaje." La lista de inmuebles est&aacute; vac&iacute;a o contiene errores";
	}else{
		$con=0;
		$array=descomponerArreglo(11,10,$inmuebles);
		$filas=count($array);
		while($con < $filas){
			if(is_numeric($array[$con])){
				if (strlen($array[$con])!=5){
					$validacion=false;
				}
			}else{
				$validacion=false;
			}
			$con++;
		}
		if ($validacion==false){
				$mensaje=$mensaje." El código postal de uno o más inmuebles es incorrecto";
		}
	}
}
//FIN VALIDACION DE LA LISTA DE INMUEBLES

//VALIDACION DE LA LISTA DE ENAJENANTES
if (isset($_POST['listaEnajenantes']) && trim($_POST['listaEnajenantes']) !=""){
	$enajenantes=trim($_POST['listaEnajenantes']);
	$enajenantes=rtrim($enajenantes,":::");
	$enajenantes=explode(":::",$enajenantes);
	if (!(count($enajenantes)%6 ==0) and (count($enajenantes)==0)){
		$validacion=false;
		$mensaje=$mensaje." La lista de enajenantes est&aacute; vac&iacute;a o contiene errores";
	}else{
		if ($sociedadEnajenantes=="Si"){
			$con=0;
			$sum=0;
			$array=descomponerArreglo(6,5,$enajenantes);
			$filas=count($array);
			while($con < $filas){
				$sum=$sum+$array[$con];
				$con++;
			}
			if ($sum!=100){
					$validacion=false;
					$mensaje=$mensaje." Existe un error en los porcentajes de la sociedad conyugal de los enajenantes";
			}
		}
	}
}else{
	$enajenantes=0;
	$validacion=false;
	$mensaje=$mensaje." No se ha recibido la lista de enajenantes";
}
//FIN VALIDACION DE LA LISTA DE ENAJENANTES

//VALIDACION DE LA LISTA DE ADQUIRIENTES
if (isset($_POST['listaAdquirientes']) && trim($_POST['listaAdquirientes']) !=""){
	$adquirientes=trim($_POST['listaAdquirientes']);
	$adquirientes=rtrim($adquirientes,":::");
	$adquirientes=explode(":::",$adquirientes);
	if (!(count($adquirientes)%6 ==0) and (count($adquirientes)==0)){
		$validacion=false;
		$mensaje=$mensaje." La lista de adquirientes est&aacute; vac&iacute;a o contiene errores";
	}else{
		if ($sociedadAdquirientes=="Si"){
			$con=0;
			$sum=0;
			$array=descomponerArreglo(6,5,$adquirientes);
			$filas=count($array);
			while($con < $filas){
				$sum=$sum+$array[$con];
				$con++;
			}
			if ($sum!=100){
					$validacion=false;
					$mensaje=$mensaje." Existe un error en los porcentajes de la sociedad conyugal de los adquirientes";
			}
		}
	}
}else{
	$adquirientes=0;
	$validacion=false;
	$mensaje=$mensaje." No se ha recibido la lista de adquirientes";
}
//FIN VALIDACION DE LA LISTA DE ADQUIRIENTES
////////////////////////////////******* FIN VALIDACION DEL COMPLEMENTO NOTARIAL******//////////////////////////////////////

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
	
	### 6. ARRAYS QUE CONTIENEN LOS ARTICULOS QUE FORMAN PARTE DE LA VENTA #####################
	
	if($tiporelacion!=""){
		$arregloUUID=descomponerArreglo(1,0,$lista2);
		$comprobantesRelacionados="";
		for ($i=0; $i<count($arregloUUID); $i++){
			$comprobantesRelacionados=$comprobantesRelacionados." (".$arregloUUID[$i].")";
		}
	}
	
	$arregloIdproducto=descomponerArreglo(4,0,$lista);
	$Array_Cantidad=descomponerArreglo(4,1,$lista);
	$Array_ValorUnitario=descomponerArreglo(4,2,$lista);
	$Array_Descuento=descomponerArreglo(4,3,$lista);

	$Array_ClaveProdServ =crearArray($arregloIdproducto, "idcategoria", "categorias","codigo","extra");
	$Array_ClaveUnidad=crearArray($arregloIdproducto, "idunidad", "unidades","codigo","extra");
	$Array_NoIdentificacion=crearArray($arregloIdproducto, "codigo", "","","simple");
	$Array_Descripcion=crearArray($arregloIdproducto, "nombre", "","","simple");
	$Array_Unidad=crearArray($arregloIdproducto, "idunidad", "unidades","nombre","extra");
	$Array_Importe=calcularImporteArray($Array_Cantidad,$Array_ValorUnitario);
	if($tipocomprobante=="E"){
		foreach ($Array_ClaveProdServ as $clave => $valor) {
			$Array_ClaveProdServ[$clave]="84111506";
			$Array_ClaveUnidad[$clave]="ACT";
			$Array_Unidad[$clave]="ACT";
		}
	}
	
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


	$arregloIdproducto=descomponerArreglo(4,0,$lista);
	$Array_Cantidad=descomponerArreglo(4,1,$lista);
	$Array_ValorUnitario=descomponerArreglo(4,2,$lista);
	$Array_Descuento=descomponerArreglo(4,3,$lista);
	
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
	
   
 
	$version_timbre = "3.3";
	$sello_SAT      = "Sello SAT";
	$cert_SAT       = "Certificado SAT"; 
	$sello_CFD      = "CELLO CDF"; 
	$tim_fecha      = ""; 
	$tim_uuid       = ""; 
					
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
	$relaciones="";
            
	$filename="../componentes/qr.png";
	include("plantilla.php");     
	echo $mensaje;
        
##### FIN DE PROCEDIMIENTOS ####################################################      
}else{
	$mensaje="fracaso@Operaci&oacute;n fallida@ $mensaje";
	echo $mensaje;
}
?>