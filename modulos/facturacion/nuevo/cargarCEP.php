<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
/*CARGA DE ARCHIVOS*/
include_once('../../../librerias/php/thumb.php');
$validacion=true;

/*CARGAR ARCHIVO*/
if (isset($_FILES['archivo']['name'])){
	$archivonombre=$_FILES['archivo']['name'];
	$archivotemporal=$_FILES['archivo']['tmp_name'];
	$extencionarchivo=pathinfo($_FILES['archivo']['name'], PATHINFO_EXTENSION);
	$archivo=basename($_FILES['archivo']['name'],".".$extencionarchivo)."_".generarClave(5).".".$extencionarchivo;
	
	if($archivotemporal==""){
		$archivo="";
		$validacion=false;
		$mensaje=$mensaje."<p>El campo archivo es obligatorio</p>";
	}
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo archivo no es correcto</p>";
}


if($validacion){
	
	/*CARGAR ARCHIVOS*/
	$mensajeArchivo="";
		
	if($archivotemporal!=""){
			
		$estadoArchivo=cargarArchivo($archivonombre,$extencionarchivo, $archivotemporal, $archivo,"xml","cep",0,0,"archivo","center");
		if ($estadoArchivo=="exito"){
			$mensajeArchivo="";
			$xml = file_get_contents("../archivosSubidos/cep/$archivo");
			
			
			
			
			#== 2. Obteniendo datos del archivo .XML =========================================

			$DOM = new DOMDocument('1.0', 'utf-8');
			$DOM->preserveWhiteSpace = FALSE;
			$DOM->loadXML($xml);
			$exito=true;
			
			$params = $DOM->getElementsByTagName('SPEI_Tercero');
			foreach ($params as $param) {
				   $fechaOperacion  = $param->getAttribute('FechaOperacion');
				   $Hora = $param->getAttribute('Hora');
				   $ClaveSPEI = $param->getAttribute('ClaveSPEI');
				   $sello = $param->getAttribute('sello');
				   $numeroCertificado = $param->getAttribute('numeroCertificado');
				   $cadenaCDA = $param->getAttribute('cadenaCDA');
				   $claveRastreo = $param->getAttribute('claveRastreo');
			}
			
			$params = $DOM->getElementsByTagName('Beneficiario');
			foreach ($params as $param) {
				   $BancoBeneficiario = $param->getAttribute('BancoReceptor');
				   $CuentaBeneficiario = $param->getAttribute('Cuenta');
				   $RFCBeneficiario = $param->getAttribute('RFC');
			}
			
			$params = $DOM->getElementsByTagName('Ordenante');
			foreach ($params as $param) {
				   $BancoOrdenante = $param->getAttribute('BancoEmisor');
				   $CuentaOrdenante = $param->getAttribute('Cuenta');
				   $RFCOrdenante= $param->getAttribute('RFC');
			}
			
			
			if ($fechaOperacion=="" or $sello=="" or $numeroCertificado=="" or $cadenaCDA==""){
				$exito=false;
			}
			if ($exito){
				$cadenaCDA=explode("||",$cadenaCDA);
				$cadenaCDA="||".$cadenaCDA[1]."||";
				$cadenaCDA=str_replace("|","&#124;",$cadenaCDA);
				
				$numeroCertificado=base64_encode($numeroCertificado);

				$mensaje="exito@".$fechaOperacion."@".$claveRastreo."@".$sello."@".$numeroCertificado."@".$cadenaCDA."@".$RFCOrdenante."@".$CuentaOrdenante."@".$BancoOrdenante."@".$RFCBeneficiario."@".$CuentaBeneficiario;
			}else{
				$mensaje="fracaso@fracaso";
			}
			
			unlink("../archivosSubidos/cep/$archivo");
			
		}else if ($estadoArchivo=="extencionInvalida"){
			$mensajeArchivo=$mensajeArchivo."| La extenci&oacute;n: ".$extencionarchivo. " del archivo, no es v&aacute;lida. ";
		}else{
			$mensajeArchivo=$mensajeArchivo."| No se pudo guardar el archivo (".$extencionfoto."). ";
		}
	}
	
}else{
	$mensaje="fracaso@Operaci&oacute;n fallida@ $mensaje";
}

echo utf8_encode($mensaje);

?>