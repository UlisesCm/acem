<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
require('../Datofiscal.class.php');
$Odatofiscal=new Datofiscal;
$mensaje="";
$validacion=true;

if (isset($_POST['idcliente'])){
	$idcliente=htmlentities(trim($_POST['idcliente']));
	//$idcliente=mysql_real_escape_string($idcliente);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idcliente no es correcto</p>";
}

if (isset($_POST['domiciliocompleto'])){
	$domiciliocompleto=htmlentities(trim($_POST['domiciliocompleto']));
	//$domiciliocompleto=mysql_real_escape_string($domiciliocompleto);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo domiciliocompleto no es correcto</p>";
}

if (isset($_POST['formapago'])){
	$formapago=htmlentities(trim($_POST['formapago']));
	//$formapago=mysql_real_escape_string($formapago);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo formapago no es correcto</p>";
}

if (isset($_POST['metodopago'])){
	$metodopago=htmlentities(trim($_POST['metodopago']));
	//$metodopago=mysql_real_escape_string($metodopago);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo metodopago no es correcto</p>";
}

if (isset($_POST['usocfdi'])){
	$usocfdi=htmlentities(trim($_POST['usocfdi']));
	//$usocfdi=mysql_real_escape_string($usocfdi);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo usocfdi no es correcto</p>";
}

if (isset($_POST['estatus'])){
	$estatus=htmlentities(trim($_POST['estatus']));
	//$estatus=mysql_real_escape_string($estatus);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo estatus no es correcto</p>";
}
if($validacion){
	$resultado=$Odatofiscal->guardar($idcliente,$domiciliocompleto,$formapago,$metodopago,$usocfdi,$estatus);
	if($resultado=="exito"){
		
		$mensaje="exito@Operaci&oacute;n exitosa@El registro ha sido guardado";
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