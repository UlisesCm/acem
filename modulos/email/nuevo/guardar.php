<?php
include ("../../seguridad/comprobar_login.php");
include ("../../empresa/Empresa.class.php");
$Oempresa=new Empresa;
$resultado=$Oempresa->consultaGeneral("WHERE idempresa='1'");
$extractor = mysqli_fetch_array($resultado);
$razonsocial=$extractor["razonsocial"];
$emailEmpresa=$extractor["email"];
	
$validacion=true;
$mensaje="";
if (isset($_POST['email']) && trim($_POST['email']) !=""){
	$email=trim($_POST['email']);
	if ($email=="[]"){
		$validacion=false;
		$mensaje=$mensaje." No se ha especificado un email de destino";
	}else{
		$email=str_replace("[","",$email);
		$email=str_replace("]","",$email);
		$email=str_replace('"','',$email);
	}
}else{
	$validacion=false;
	$mensaje=$mensaje." No se ha especificado un email de destino";
}

if (isset($_POST['mensaje']) && trim($_POST['mensaje']) !=""){
	$mensajeemail=htmlentities(trim($_POST['mensaje']));
}else{
	$mensajeemail="";
}

if (isset($_POST['asunto']) && trim($_POST['asunto']) !=""){
	$asunto=htmlentities(trim($_POST['asunto']));
}else{
	$asunto="";
}

if (isset($_POST['pdf']) && trim($_POST['pdf']) !=""){
	$pdf=htmlentities(trim($_POST['pdf']));
}else{
	$pdf="";
}

if (isset($_POST['xml']) && trim($_POST['xml']) !=""){
	$xml=htmlentities(trim($_POST['xml']));
}else{
	$xml="";
}


if (isset($_POST['tablareferencia']) && trim($_POST['tablareferencia']) !=""){
	$tablareferencia=htmlentities(trim($_POST['tablareferencia']));
	if ($tablareferencia=="compras"){
		if (isset($_POST['idreferencia']) && trim($_POST['idreferencia']) !=""){
			$idreferencia=htmlentities(trim($_POST['idreferencia']));
			$fechaenvio=date("Y-m-d H:i:s");
			if ($Oempresa->consultaLibre("UPDATE compras SET estado='Enviada', fechaenvio='$fechaenvio' WHERE idcompra='$idreferencia' AND (estado='Enviada' OR estado='Pendiente')")){
			}else{
				$validacion=false;
				$mensaje="No se puede actualizar el estado de la compra, por esta raz&oacute;n no se puede enviar al proveedor";
			}
		}
	}
}

function TildesHtml($cadena) 
{ 
    return str_replace(array("á","é","í","ó","ú","ñ","Á","É","Í","Ó","Ú","Ñ"),
                                     array("&aacute;","&eacute;","&iacute;","&oacute;","&uacute;","&ntilde;",
                                                "&Aacute;","&Eacute;","&Iacute;","&Oacute;","&Uacute;","&Ntilde;"), $cadena);     
}

if ($validacion){
	//error_reporting(E_ALL);
	error_reporting(E_STRICT);
	
	date_default_timezone_set('America/Mexico_City');
	
	require_once('../../../librerias/php/phpmailer/class.phpmailer.php');
	
	$mail             = new PHPMailer();
	
	$body             = TildesHtml(html_entity_decode($mensajeemail));
	$body             = eregi_replace("[\]",'',$body);
	
	$mail->IsSMTP(); // telling the class to use SMTP
											   // 1 = errors and messages
											   // 2 = messages only
	$mail->SMTPAuth   = true; 
	$mail->Mailer="smtp";
	$mail->Helo="www.imodula.com";                 // enable SMTP authentication
	$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
	$mail->Host       = "server109.neubox.net";      // sets GMAIL as the SMTP server
	$mail->Port       = 465;                   // set the SMTP port for the GMAIL server
	$mail->Username   = "facturacion@imodula.com";  // GMAIL username
	$mail->Password   = "KENzzok1988$";            // GMAIL password
	
	$mail->SetFrom("facturacion@imodula.com", $razonsocial);
	
	$mail->Subject    = $asunto;
	
	$mail->AltBody    = "Para ver el mensaje, por favor use un visor compatible con HTML"; // optional, comment out and test
	
	$mail->MsgHTML($body);
	
	$destinatarios = explode(",",$email);
	
	foreach($destinatarios as $address){ 
        $mail->AddAddress($address, "");
    } 
	
	if ($xml!=""){
		$mail->AddAttachment("../../../empresas/".$_SESSION["empresa"]."/$xml");      // attachment
	}
	if ($pdf!=""){
		$mail->AddAttachment("../../../empresas/".$_SESSION["empresa"]."/$pdf");  // attachment
	}
	
	if(!$mail->Send()) {
	  echo "fracaso@Operaci&oacute;n fallida@".$mail->ErrorInfo;
	} else {
	  echo "exito@Operaci&oacute;n exitosa@El correo ha sido enviado";
	}
}else{
	echo "fracaso@Operaci&oacute;n fallida@$mensaje";
}

?>