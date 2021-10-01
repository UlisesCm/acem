<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
require('../Persona.class.php');
$Opersona=new Persona;
$mensaje="";
$validacion=true;

if (isset($_POST['rfc'])){
	$rfc=htmlentities(trim($_POST['rfc']));
	//$rfc=mysql_real_escape_string($rfc);
	
		if(!validarRFC($rfc)){
			$validacion=false;
			$mensaje=$mensaje."<p>El campo rfc no es correcto. Verifique el RFC</p>";
		}
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo rfc no es correcto</p>";
}
if ($rfc=="XEXX010101000"){ // Si el RFC es de un extranjero

	if (isset($_POST['estado'])){ // Numero de Identificacion para extranjeros (TAX ID)
		$estado=htmlentities(trim($_POST['estado']));
		if ($estado==""){
			$validacion=false;
			$mensaje=$mensaje."<p>El campo Numero de registro de identidad no es correcto</p>";
		}
	}else{
		$validacion=false;
		$mensaje=$mensaje."<p>El campo Numero de registro de identidad no es correcto</p>";
	}
	
	if (isset($_POST['pais'])){
		$pais=htmlentities(trim($_POST['pais']));
	}else{
		$validacion=false;
		$mensaje=$mensaje."<p>El campo pa&iacute;s no es correcto</p>";
	}
}else{
	$estado="";
	$pais="";
}

if (isset($_POST['razonsocial'])){
	$razonsocial=htmlentities(trim($_POST['razonsocial']));
	//$razonsocial=mysql_real_escape_string($razonsocial);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo razonsocial no es correcto</p>";
}

if (isset($_POST['usocfdi'])){
	$usocfdi=htmlentities(trim($_POST['usocfdi']));
	//$usocfdi=mysql_real_escape_string($usocfdi);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo usocfdi no es correcto</p>";
}

if (isset($_POST['calle'])){
	$calle=htmlentities(trim($_POST['calle']));
	//$calle=mysql_real_escape_string($calle);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo calle no es correcto</p>";
}

if (isset($_POST['numeroexterior'])){
	$numeroexterior=htmlentities(trim($_POST['numeroexterior']));
	//$numeroexterior=mysql_real_escape_string($numeroexterior);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo numeroexterior no es correcto</p>";
}

if (isset($_POST['numerointerior'])){
	$numerointerior=htmlentities(trim($_POST['numerointerior']));
	//$numerointerior=mysql_real_escape_string($numerointerior);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo numerointerior no es correcto</p>";
}

if (isset($_POST['colonia'])){
	$colonia=htmlentities(trim($_POST['colonia']));
	//$colonia=mysql_real_escape_string($colonia);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo colonia no es correcto</p>";
}

if (isset($_POST['municipio'])){
	$municipio=htmlentities(trim($_POST['municipio']));
	//$municipio=mysql_real_escape_string($municipio);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo municipio no es correcto</p>";
}

if (isset($_POST['localidad'])){
	$localidad=htmlentities(trim($_POST['localidad']));
	//$localidad=mysql_real_escape_string($localidad);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo localidad no es correcto</p>";
}


if (isset($_POST['cp'])){
	$cp=htmlentities(trim($_POST['cp']));
	//$cp=mysql_real_escape_string($cp);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo cp no es correcto</p>";
}

if (isset($_POST['email'])){
	$email=htmlentities(trim($_POST['email']));
	//$email=mysql_real_escape_string($email);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo email no es correcto</p>";
}

if (isset($_POST['mensaje'])){
	$mensaje2=htmlentities(trim($_POST['mensaje']));
	//$mensaje=mysql_real_escape_string($mensaje);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo mensaje no es correcto</p>";
}

if (isset($_POST['estatus'])){
	$estatus=htmlentities(trim($_POST['estatus']));
	//$estatus=mysql_real_escape_string($estatus);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo estatus no es correcto</p>";
}
if($validacion){
	$resultado=$Opersona->guardar($rfc,$razonsocial,$usocfdi,$calle,$numeroexterior,$numerointerior,$colonia,$municipio,$localidad,$estado,$pais,$cp,$email,$mensaje2,$estatus);
	if($resultado=="exito"){
		
		$mensaje="exito@Operaci&oacute;n exitosa@El registro ha sido guardado";
	}
	if($resultado=="rfcExiste"){
		$mensaje="fracaso@Operaci&oacute;n fallida@El campo rfc ya existe en la base de datos";
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