<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
/*CARGA DE ARCHIVOS*/
include_once('../../../librerias/php/thumb.php');
require('../Empresa.class.php');
$Oempresa=new Empresa;
$mensaje="";
$validacion=true;

if (isset($_POST['nombrecomercial'])){
	$nombrecomercial=htmlentities(trim($_POST['nombrecomercial']));
	//$nombrecomercial=mysql_real_escape_string($nombrecomercial);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo nombrecomercial no es correcto</p>";
}

if (isset($_POST['razonsocial'])){
	$razonsocial=htmlentities(trim($_POST['razonsocial']));
	//$razonsocial=mysql_real_escape_string($razonsocial);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo razonsocial no es correcto</p>";
}

if (isset($_POST['rfc'])){
	$rfc=htmlentities(trim($_POST['rfc']));
	//$rfc=mysql_real_escape_string($rfc);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo rfc no es correcto</p>";
}

if (isset($_POST['domiciliofiscal'])){
	$domiciliofiscal=htmlentities(trim($_POST['domiciliofiscal']));
	//$domiciliofiscal=mysql_real_escape_string($domiciliofiscal);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo domiciliofiscal no es correcto</p>";
}

if (isset($_POST['regimen'])){
	$regimen=htmlentities(trim($_POST['regimen']));
	//$regimen=mysql_real_escape_string($regimen);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo regimen no es correcto</p>";
}

if (isset($_POST['telefono'])){
	$telefono=htmlentities(trim($_POST['telefono']));
	//$telefono=mysql_real_escape_string($telefono);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo telefono no es correcto</p>";
}

if (isset($_POST['email'])){
	$email=htmlentities(trim($_POST['email']));
	//$email=mysql_real_escape_string($email);
	
		if(!validarEmail($email)){
			$validacion=false;
			$mensaje=$mensaje."<p>Verifique que el campo email sea un email v&aacute;lido</p>";
		}
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo email no es correcto</p>";
}

if (isset($_POST['licenciasssa'])){
	$licenciasssa=htmlentities(trim($_POST['licenciasssa']));
	//$licenciasssa=mysql_real_escape_string($licenciasssa);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo licenciasssa no es correcto</p>";
}
/*CARGAR ARCHIVO*/
if (isset($_FILES['logo']['name'])){
	$logonombre=$_FILES['logo']['name'];
	$logotemporal=$_FILES['logo']['tmp_name'];
	$extencionlogo=pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
	$logo=basename($_FILES['logo']['name'],".".$extencionlogo)."_".generarClave(5).".".$extencionlogo;
	
	if($logotemporal==""){
		$logo="";
		$validacion=false;
		$mensaje=$mensaje."<p>El campo logo es obligatorio</p>";
	}
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo logo no es correcto</p>";
}

if (isset($_POST['clave_csd'])){
	$clave_csd=htmlentities(trim($_POST['clave_csd']));
	//$clave_csd=mysql_real_escape_string($clave_csd);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo clave_csd no es correcto</p>";
}
/*CARGAR ARCHIVO*/
if (isset($_FILES['cer_csd']['name'])){
	$cer_csdnombre=$_FILES['cer_csd']['name'];
	$cer_csdtemporal=$_FILES['cer_csd']['tmp_name'];
	$extencioncer_csd=pathinfo($_FILES['cer_csd']['name'], PATHINFO_EXTENSION);
	$cer_csd=basename($_FILES['cer_csd']['name'],".".$extencioncer_csd)."_".generarClave(5).".".$extencioncer_csd;
	
	if($cer_csdtemporal==""){
		$cer_csd="";
		$validacion=false;
		$mensaje=$mensaje."<p>El campo cer_csd es obligatorio</p>";
	}
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo cer_csd no es correcto</p>";
}
/*CARGAR ARCHIVO*/
if (isset($_FILES['key_csd']['name'])){
	$key_csdnombre=$_FILES['key_csd']['name'];
	$key_csdtemporal=$_FILES['key_csd']['tmp_name'];
	$extencionkey_csd=pathinfo($_FILES['key_csd']['name'], PATHINFO_EXTENSION);
	$key_csd=basename($_FILES['key_csd']['name'],".".$extencionkey_csd)."_".generarClave(5).".".$extencionkey_csd;
	
	if($key_csdtemporal==""){
		$key_csd="";
		$validacion=false;
		$mensaje=$mensaje."<p>El campo key_csd es obligatorio</p>";
	}
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo key_csd no es correcto</p>";
}

if (isset($_POST['numero_csd'])){
	$numero_csd=htmlentities(trim($_POST['numero_csd']));
	//$numero_csd=mysql_real_escape_string($numero_csd);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo numero_csd no es correcto</p>";
}

if (isset($_POST['estatus'])){
	$estatus=htmlentities(trim($_POST['estatus']));
	//$estatus=mysql_real_escape_string($estatus);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo estatus no es correcto</p>";
}
if($validacion){
	$resultado=$Oempresa->guardar($nombrecomercial,$razonsocial,$rfc,$domiciliofiscal,$regimen,$telefono,$email,$licenciasssa,$logo,$clave_csd,$cer_csd,$key_csd,$numero_csd,$estatus);
	if($resultado=="exito"){
		/*CARGAR ARCHIVOS*/
		$mensajeArchivo="";
		
		if($logotemporal!=""){
			
			$estadoArchivo=cargarArchivo($logonombre,$extencionlogo, $logotemporal, $logo,"jpg","empresa",100,0,"resize","center");
			if ($estadoArchivo=="exito"){
				$mensajeArchivo="";
			}else if ($estadoArchivo=="extencionInvalida"){
				$mensajeArchivo=$mensajeArchivo."| La extenci&oacute;n: ".$extencionlogo. " del archivo, no es v&aacute;lida. ";
			}else{
				$mensajeArchivo=$mensajeArchivo."| No se pudo guardar el archivo (".$extencionfoto."). ";
			}
		}
		if($cer_csdtemporal!=""){
			
			$estadoArchivo=cargarArchivo($cer_csdnombre,$extencioncer_csd, $cer_csdtemporal, $cer_csd,"cer","empresa",0,0,"archivo","center");
			if ($estadoArchivo=="exito"){
				$mensajeArchivo="";
			}else if ($estadoArchivo=="extencionInvalida"){
				$mensajeArchivo=$mensajeArchivo."| La extenci&oacute;n: ".$extencioncer_csd. " del archivo, no es v&aacute;lida. ";
			}else{
				$mensajeArchivo=$mensajeArchivo."| No se pudo guardar el archivo (".$extencionfoto."). ";
			}
		}
		if($key_csdtemporal!=""){
			
			$estadoArchivo=cargarArchivo($key_csdnombre,$extencionkey_csd, $key_csdtemporal, $key_csd,"key","empresa",0,0,"archivo","center");
			if ($estadoArchivo=="exito"){
				$mensajeArchivo="";
			}else if ($estadoArchivo=="extencionInvalida"){
				$mensajeArchivo=$mensajeArchivo."| La extenci&oacute;n: ".$extencionkey_csd. " del archivo, no es v&aacute;lida. ";
			}else{
				$mensajeArchivo=$mensajeArchivo."| No se pudo guardar el archivo (".$extencionfoto."). ";
			}
		}
		$mensaje="exito@Operaci&oacute;n exitosa@El registro ha sido guardado";
		$mensaje=$mensaje.$mensajeArchivo;
	}
	if($resultado=="fracaso"){
		$mensaje="fracaso@Operaci&oacute;n fallida@Ha ocurrido un problema en la base de datos [001]";
	}
	if($resultado=="denegado"){
		$mensaje="aviso@Acceso denegado@Su cuenta no cuenta con los privilegios para poder realizar esta tarea";
	}
}else{
	$mensaje="fracaso@Operaci&oacute;n fallida@ $mensaje";
}

echo utf8_encode($mensaje);

?>