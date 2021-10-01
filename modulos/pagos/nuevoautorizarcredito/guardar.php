<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
require('../Pago.class.php');
$Opago=new Pago;
$mensaje="";
$validacion=true;

if (isset($_POST['idreferencia'])){
	$idreferencia=htmlentities(trim($_POST['idreferencia']));
	//$idreferencia=mysql_real_escape_string($idreferencia);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idreferencia no es correcto</p>";
}

if (isset($_POST['tablareferencia'])){
	$tablareferencia=htmlentities(trim($_POST['tablareferencia']));
	//$tablareferencia=mysql_real_escape_string($tablareferencia);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo tablareferencia no es correcto</p>";
}

if (isset($_POST['idcliente'])){
	$idcliente=htmlentities(trim($_POST['idcliente']));
	//$idcliente=mysql_real_escape_string($idcliente);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idcliente no es correcto</p>";
}

if (isset($_POST['idcaja'])){
	$idcaja=htmlentities(trim($_POST['idcaja']));
	//$idcaja=mysql_real_escape_string($idcaja);
	
}else{
	/*$validacion=false;
	$mensaje=$mensaje."<p>El campo idcaja no es correcto</p>";*/
	$idcaja = 0;
}

if (isset($_POST['tipocredito'])){
	$tipocredito=htmlentities(trim($_POST['tipocredito']));
	//$formapago=mysql_real_escape_string($formapago);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo tipocredito no es correcto</p>";
}

if($validacion){
	$resultado=$Opago->actualizarTipodePago($idreferencia,$tablareferencia,$tipocredito);
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