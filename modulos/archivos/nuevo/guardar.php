<?php 
include ("../../seguridad/comprobar_login.php");
/*CARGA DE ARCHIVOS*/
include_once('../../../librerias/php/thumb.php');
require('../Archivo.class.php');
$Oarchivo=new Archivo;
$mensaje="";
$validacion=true;

sleep(5);
/*CARGAR ARCHIVO*/
if (isset($_FILES['pdf']['name'])){
	$pdfnombre=$_FILES['pdf']['name'];
	$pdftemporal=$_FILES['pdf']['tmp_name'];
	$extencionpdf=pathinfo($_FILES['pdf']['name'], PATHINFO_EXTENSION);
	$pdf=basename($_FILES['pdf']['name'],".".$extencionpdf)."_".generarClave(5).".".$extencionpdf;
	
	if($pdftemporal==""){
		$pdf="";
	}
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo pdf no es correcto</p>";
}
/*CARGAR ARCHIVO*/
if (isset($_FILES['xml']['name'])){
	$xmlnombre=$_FILES['xml']['name'];
	$xmltemporal=$_FILES['xml']['tmp_name'];
	$extencionxml=pathinfo($_FILES['xml']['name'], PATHINFO_EXTENSION);
	$xml=basename($_FILES['xml']['name'],".".$extencionxml)."_".generarClave(5).".".$extencionxml;
	
	if($xmltemporal==""){
		$xml="";
		$validacion=false;
		$mensaje=$mensaje."<p>El campo xml es obligatorio</p>";
	}
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo xml no es correcto</p>";
}
	

if (isset($_POST['tablareferencia'])){
	$tablareferencia=htmlentities(trim($_POST['tablareferencia']));
	//$tablareferencia=mysql_real_escape_string($tablareferencia);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo tablareferencia no es correcto</p>";
}

if (isset($_POST['idreferencia'])){
	$idreferencia=htmlentities(trim($_POST['idreferencia']));
	//$idreferencia=mysql_real_escape_string($idreferencia);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idreferencia no es correcto</p>";
}
	$fechamodificacion=date("Y-m-d");
	$serie="";
	$folio="";
	$tipo="";
	$fechatimbre="";
	$emisor="";
	$rfcemisor="";
	$receptor="";
	$rfcreceptor="";
	$monto="";
	$uuid="";
	$subtotal="";
	
if($validacion){
	$resultado=$Oarchivo->guardar($pdf,$xml,$fechamodificacion,$tablareferencia,$idreferencia,$serie,$folio,$tipo,$fechatimbre,$emisor,$rfcemisor,$receptor,$rfcreceptor,$monto,$subtotal, $uuid);
	$resultado=explode("@",$resultado);
	$idarchivo=$resultado[1];
	if($resultado[0]=="exito"){
		/*CARGAR ARCHIVOS*/
		$mensajeArchivo="";
		
		if($pdftemporal!=""){
			
			$estadoArchivo=cargarArchivo($pdfnombre,$extencionpdf, $pdftemporal, $pdf,"pdf","archivos",0,0,"archivo","center");
			if ($estadoArchivo=="exito"){
				$mensajeArchivo="";
			}else if ($estadoArchivo=="extencionInvalida"){
				$mensajeArchivo=$mensajeArchivo."| La extenci&oacute;n: ".$extencionpdf. " del archivo, no es v&aacute;lida. ";
			}else{
				$mensajeArchivo=$mensajeArchivo."| No se pudo guardar el archivo (".$extencionfoto."). ";
			}
		}
		if($xmltemporal!=""){
			
			$estadoArchivo=cargarArchivo($xmlnombre,$extencionxml, $xmltemporal, $xml,"xml","archivos",0,0,"archivo","center");
			if ($estadoArchivo=="exito"){
				
				$xml = simplexml_load_file("../../../empresas/".$_SESSION["empresa"]."/archivosSubidos/archivos/$xml"); 
				$ns = $xml->getNamespaces(true);
				$xml->registerXPathNamespace('c', $ns['cfdi']);
				$xml->registerXPathNamespace('t', $ns['tfd']);
				
				$uuid="";
			    $rfcreceptor=""; 
			    $receptor="";
			    $rfcemisor="";
			    $emisor="";
			    $tipo="";
			    $fecha="";
				$monto="";
				$subtotal="";
 
				//ESTA ULTIMA PARTE ES LA QUE GENERABA EL ERROR
				
				//EMPIEZO A LEER LA INFORMACION DEL CFDI E IMPRIMIRLA 
				foreach ($xml->xpath('//cfdi:Comprobante') as $cfdiComprobante){ 
					  //echo $cfdiComprobante['Version'];
					  $fecha=$cfdiComprobante['Fecha']; 
					  //echo $cfdiComprobante['Sello']; 
					  $monto=$cfdiComprobante['Total']; 
					  $subtotal=$cfdiComprobante['SubTotal']; 
					  //echo $cfdiComprobante['Certificado']; 
					  //echo $cfdiComprobante['FormaDePago']; 
					  //echo $cfdiComprobante['NoCertificado']; 
					  $tipo= $cfdiComprobante['TipoDeComprobante']; 
					  $serie=$cfdiComprobante['Serie']; 
					  $folio=$cfdiComprobante['Folio']; 
					  
				} 
				foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Emisor') as $Emisor){ 
				   $rfcemisor=$Emisor['Rfc']; 
				   $emisor=$Emisor['Nombre']; 
				} 
				/*
				foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Emisor//cfdi:DomicilioFiscal') as $DomicilioFiscal){ 
				   echo $DomicilioFiscal['Pais']; 
				   echo "<br />"; 
				   echo $DomicilioFiscal['Calle']; 
				   echo "<br />"; 
				   echo $DomicilioFiscal['Estado']; 
				   echo "<br />"; 
				   echo $DomicilioFiscal['Colonia']; 
				   echo "<br />"; 
				   echo $DomicilioFiscal['Municipio']; 
				   echo "<br />"; 
				   echo $DomicilioFiscal['NoExterior']; 
				   echo "<br />"; 
				   echo $DomicilioFiscal['CodigoPostal']; 
				   echo "<br />"; 
				} 
				
				foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Emisor//cfdi:ExpedidoEn') as $ExpedidoEn){ 
				   echo $ExpedidoEn['Pais']; 
				   echo "<br />"; 
				   echo $ExpedidoEn['Calle']; 
				   echo "<br />"; 
				   echo $ExpedidoEn['Estado']; 
				   echo "<br />"; 
				   echo $ExpedidoEn['Colonia']; 
				   echo "<br />"; 
				   echo $ExpedidoEn['NoExterior']; 
				   echo "<br />"; 
				   echo $ExpedidoEn['CodigoPostal']; 
				   echo "<br />"; 
				} */
				foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Receptor') as $Receptor){ 
				   $rfcreceptor=$Receptor['Rfc']; 
				   $receptor=$Receptor['Nombre'];
				} 
				/*
				foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Receptor//cfdi:Domicilio') as $ReceptorDomicilio){ 
				   echo $ReceptorDomicilio['Pais']; 
				   echo "<br />"; 
				   echo $ReceptorDomicilio['Calle']; 
				   echo "<br />"; 
				   echo $ReceptorDomicilio['Estado']; 
				   echo "<br />"; 
				   echo $ReceptorDomicilio['Colonia']; 
				   echo "<br />"; 
				   echo $ReceptorDomicilio['Municipio']; 
				   echo "<br />"; 
				   echo $ReceptorDomicilio['NoExterior']; 
				   echo "<br />"; 
				   echo $ReceptorDomicilio['NoInterior']; 
				   echo "<br />"; 
				   echo $ReceptorDomicilio['CodigoPostal']; 
				   echo "<br />"; 
				} 
				
				foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Conceptos//cfdi:Concepto') as $Concepto){ 
				   echo "<br />"; 
				   echo $Concepto['Unidad']; 
				   echo "<br />"; 
				   echo $Concepto['Importe']; 
				   echo "<br />"; 
				   echo $Concepto['Cantidad']; 
				   echo "<br />"; 
				   echo $Concepto['Descripcion']; 
				   echo "<br />"; 
				   echo $Concepto['ValorUnitario']; 
				   echo "<br />";   
				   echo "<br />"; 
				} 
				foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Impuestos//cfdi:Traslados//cfdi:Traslado') as $Traslado){ 
				   echo $Traslado['Tasa']; 
				   echo "<br />"; 
				   echo $Traslado['Importe']; 
				   echo "<br />"; 
				   echo $Traslado['Impuesto']; 
				   echo "<br />";   
				   echo "<br />"; 
				}*/
				 
				/*ESTA ULTIMA PARTE ES LA QUE GENERABA EL ERROR
				foreach ($xml->xpath('//t:TimbreFiscalDigital') as $tfd) {
				   echo $tfd['SelloCFD']; 
				   echo "<br />"; 
				   echo $tfd['FechaTimbrado']; 
				   echo "<br />"; 
				   echo $tfd['UUID']; 
				   echo "<br />"; 
				   echo $tfd['NoCertificadoSAT']; 
				   echo "<br />"; 
				   echo $tfd['Version']; 
				   echo "<br />"; 
				   echo $tfd['SelloSAT']; 
				} 
				*/
				foreach ($xml->xpath('//t:TimbreFiscalDigital') as $tfd) {
					$uuid=$tfd['UUID'];
				}
				$Oarchivo->actualizarDatos($serie,$folio,$tipo,$fecha,$emisor,$rfcemisor,$receptor,$rfcreceptor,$monto,$subtotal,$uuid,$idarchivo); 
				
				$mensajeArchivo="";
			}else if ($estadoArchivo=="extencionInvalida"){
				$mensajeArchivo=$mensajeArchivo."| La extenci&oacute;n: ".$extencionxml. " del archivo, no es v&aacute;lida. ";
			}else{
				$mensajeArchivo=$mensajeArchivo."| No se pudo guardar el archivo (".$extencionfoto."). ";
			}
		}
		$mensaje="exito@Operaci&oacute;n exitosa@El registro ha sido guardado";
		$mensaje=$mensaje.$mensajeArchivo;
	}
	if($resultado[0]=="fracaso"){
		$mensaje="fracaso@Operaci&oacute;n fallida@Ha ocurrido un problema en la base de datos [001]";
	}
	if($resultado[0]=="denegado"){
		$mensaje="aviso@Acceso denegado@Su cuenta no cuenta con los privilegios para poder realizar esta tarea";
	}
}else{
	$mensaje="fracaso@Operaci&oacute;n fallida@ $mensaje";
}

echo utf8_encode($mensaje);

?>