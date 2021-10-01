<?php 
include ("../../seguridad/comprobar_login.php");
require('../Facturacion.class.php');
require('../../empresa/Empresa.class.php');
$Oempresa=new Empresa;
$Ofactura=new Facturacion;
$mensaje="";
if (isset($_REQUEST['ids']) && $_REQUEST['ids'] !="") {
	if($_REQUEST['ids']!="undefined"){
		if(is_array($_REQUEST['ids'])){
			$ids = implode(',', ($_REQUEST['ids']));
		}else{
			$ids=$_REQUEST['ids'];
		}	
			
			
			$resultadoempresa=$Oempresa->mostrarIndividual(1);
			$extractorempresa = mysqli_fetch_array($resultadoempresa);
			
			$resultado=$Ofactura->mostrarIndividual($ids);
			$extractor = mysqli_fetch_array($resultado);
			
			$cer_path = "../../../empresas/".$_SESSION["empresa"]."/certificados/".$extractorempresa["cer_csd"]; 
			$cer_file = fopen($cer_path, "r");
			$cer_content = fread($cer_file, filesize($cer_path));
			fclose($cer_file);
			
			$key_path = "../../../empresas/".$_SESSION["empresa"]."/certificados/csd_cancelacion.enc";
			$key_file = fopen($key_path, "r");
			$key_content = fread($key_file,filesize($key_path));
			fclose($key_file);
			
			
			$taxpayer_id = $extractor["rfcemisor"]; # The RFC of the Emisor
			$RFCemisor= $taxpayer_id;
			$UUIDcancelado=$extractor["foliofiscal"];
			$invoices = array($extractor["foliofiscal"]); # A list of UUIDs
			
			if ($_SESSION["empresa"]=="facturacion" or $_SESSION["empresa"]=="modula"){ //Empresa demo "modula" en modo de cancelacion de prueba
				$username = 'kenzzo_ba@hotmail.com';
				$password = 'KENzzo1!';
				$url = "https://demo-facturacion.finkok.com/servicios/soap/cancel.wsdl";
			}else{ //Empresas con cancelacion en modo de producción
				$username = 'kenzzo.ba@gmail.com';
				$password = 'KENzzo1!';
				$url = "https://facturacion.finkok.com/servicios/soap/cancel.wsdl";
			}
			try {
				$client = new SoapClient($url);
				$params = array(  
				  "UUIDS" => array('uuids' => $invoices),
				  "username" => $username,
				  "password" => $password,
				  "taxpayer_id" => $taxpayer_id,
				  "cer" => $cer_content,
				  "key" => $key_content
				);
				$response = $client->__soapCall("cancel", array($params));
				$continuar=true;
			}catch(SoapFault $e){ // Do NOT try and catch "Exception" here
				$mensaje= "fracaso@Operaci&oacute;n fallida@No se ha podido conectar con el PAC, intente más tarde";
				$continuar=false;
			}
			
			if($continuar){
				//print_r($response);
				if(isset($response->cancelResult->Acuse)){
					$Acuse = $response->cancelResult->Acuse;
				}else{
					$Acuse="";
				}
				if($Acuse!=""){
					if(isset($response->cancelResult->Folios->Folio->UUID)){
						$UUID = $response->cancelResult->Folios->Folio->UUID;
						//echo "</br></br>UUID: ".$UUID."</br>";
					}
					$Fecha = $response->cancelResult->Fecha;
					$CodStatus=$response->cancelResult->Folios->Folio->EstatusUUID;
					
					
				
					//echo "Fecha: ".$Fecha."</br>";
					//echo "Acuse: ".$Acuse."</br>";
					$myContent = $Acuse;
					$archivo=$extractor["archivo"];
					$myFile = "../../../empresas/".$_SESSION["empresa"]."/".$archivo."cancel";
					
					if ($CodStatus=="201"){
						if($Ofactura->cancelarTimbre($archivo."cancel","cancelada",$ids)){
							
							$escritura=file_put_contents($myFile.".xml", utf8_encode($myContent));
							
							$respuesta = simplexml_load_file($myFile.".xml");
							$namespace =$respuesta ->getNamespaces(true);
							$respuesta ->registerXPathNamespace('nm', $namespace['s']);
							$dato= $respuesta ->xpath('//nm:Body');
							$SignatureValue= (string)($dato[0]->CancelaCFDResponse->CancelaCFDResult->Signature->SignatureValue);
							$FechaCancelacion=($dato[0]->CancelaCFDResponse->CancelaCFDResult);
							$FechaCancelacion=$FechaCancelacion[0]['Fecha'];
							
							
							include("crearPDF.php");
							
							if($escritura){
								if ($CodStatus=="201"){
									$mensaje="exito@Operaci&oacute;n exitosa@el comprobante ha sido cancelado ".$CodStatus ;
								}else{
									$mensaje="fracaso@Operaci&oacute;n fallida@No se pudo cancelar la factura, intente nuevamente: ".$CodStatus;
								}
							}else{
								$mensaje="aviso@Operaci&oacute;n exitosa@el comprobante ha sido cancelado pero no se escribio el acuse".$CodStatus ;
							}
						}else{
							$mensaje="aviso@Operaci&oacute;n exitosa@el comprobante ha sido cancelado, pero no se ha podido guardar el estado ".$CodStatus ;
						}
					}else{ // Si CodStatus=201
						$mensaje="fracaso@Operaci&oacute;n fallida@No se pudo cancelar la factura, intente nuevamente: ".$CodStatus;
					}
					
				}else{
					if(isset($response->cancelResult->CodEstatus)){
					$CodStatus =$response->cancelResult->CodEstatus;
					$mensaje="fracaso@Operaci&oacute;n fallida@Ha ocurrido un problema: ".$CodStatus;
					}else if(isset($response->cancelResult->Folios->Folio->UUID)){
						$CodStatus =$response->cancelResult->Folios->Folio->EstatusUUID;
						
						$mensaje="fracaso@Operaci&oacute;n fallida@No se puede cancelar el folio por un problema de certificado: ".$CodStatus;
					}
				}
			}
			
		
	}else{
		$mensaje="fracaso@Operaci&oacute;n fallida@Ha ocurrido un problema la transmisión de datos[002]";
	}
}else{
	$mensaje="aviso@Operaci&oacute;n fallida@No se ha seleccionado ning&uacute;n registro";
}

echo $mensaje;

?>