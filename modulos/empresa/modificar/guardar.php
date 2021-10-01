<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
/*CARGA DE ARCHIVOS*/
include_once('../../../librerias/php/thumb.php');
require('../Empresa.class.php');
$Oempresa=new Empresa;
$mensaje="";
$validacion=true;

if (isset($_POST['idempresa'])){
	$idempresa=htmlentities(trim($_POST['idempresa']));
	//$idempresa=mysql_real_escape_string($idempresa);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idempresa no es correcto</p>";
}

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
if (isset($_POST['logo'])){
	$logo=htmlentities(trim($_POST['logo']));
	$logoEliminacion=trim($_POST['logoEliminacion']);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo logo no es correcto</p>";
}	
	/*CARGAR ARCHIVO*/
if (isset($_FILES['logoI']['name'])){
	$logotemporal=$_FILES['logoI']['tmp_name'];
	$logonombre=$_FILES['logoI']['name'];
	$extencionlogo=pathinfo($_FILES['logoI']['name'], PATHINFO_EXTENSION);
	if($logotemporal==""){
		$logo=$logo;
	}else{
		$logo=basename($_FILES['logoI']['name'],".".$extencionlogo)."_".generarClave(5).".".$extencionlogo;
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
if (isset($_POST['cer_csd'])){
	$cer_csd=htmlentities(trim($_POST['cer_csd']));
	$cer_csdEliminacion=trim($_POST['cer_csdEliminacion']);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo cer_csd no es correcto</p>";
}	
	/*CARGAR ARCHIVO*/
if (isset($_FILES['cer_csdI']['name'])){
	$cer_csdtemporal=$_FILES['cer_csdI']['tmp_name'];
	$cer_csdnombre=$_FILES['cer_csdI']['name'];
	$extencioncer_csd=pathinfo($_FILES['cer_csdI']['name'], PATHINFO_EXTENSION);
	if($cer_csdtemporal==""){
		$cer_csd=$cer_csd;
	}else{
		$cer_csd=basename($_FILES['cer_csdI']['name'],".".$extencioncer_csd)."_".generarClave(5).".".$extencioncer_csd;
	}
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo cer_csd no es correcto</p>";
}
if (isset($_POST['key_csd'])){
	$key_csd=htmlentities(trim($_POST['key_csd']));
	$key_csdEliminacion=trim($_POST['key_csdEliminacion']);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo key_csd no es correcto</p>";
}	
	/*CARGAR ARCHIVO*/
if (isset($_FILES['key_csdI']['name'])){
	$key_csdtemporal=$_FILES['key_csdI']['tmp_name'];
	$key_csdnombre=$_FILES['key_csdI']['name'];
	$extencionkey_csd=pathinfo($_FILES['key_csdI']['name'], PATHINFO_EXTENSION);
	if($key_csdtemporal==""){
		$key_csd=$key_csd;
	}else{
		$key_csd=basename($_FILES['key_csdI']['name'],".".$extencionkey_csd)."_".generarClave(5).".".$extencionkey_csd;
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
	$resultado=$Oempresa->actualizar($nombrecomercial,$razonsocial,$rfc,$domiciliofiscal,$regimen,$telefono,$email,$licenciasssa,$logo,$clave_csd,$cer_csd,$key_csd,$numero_csd,$estatus, $idempresa);
	if($resultado=="exito"){
		/*CARGAR ARCHIVOS*/
		$mensajeArchivo="";
		
		if($logotemporal!=""){
			//Elimina la imagen antigua para actualizarla y que no ocupe espacio
			unlink("../archivosSubidos/empresa/".$logoEliminacion);
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
			//Elimina la imagen antigua para actualizarla y que no ocupe espacio
			unlink("../archivosSubidos/empresa/".$cer_csdEliminacion);
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
			//Elimina la imagen antigua para actualizarla y que no ocupe espacio
			unlink("../archivosSubidos/empresa/".$key_csdEliminacion);
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