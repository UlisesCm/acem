<?php 
include ("../../seguridad/comprobar_login.php");
require('../Traspaso.class.php');
$Otraspaso=new Traspaso;
$mensaje="";
$validacion=true;

if (isset($_POST['idmovimiento'])){
	$idmovimiento=htmlentities(trim($_POST['idmovimiento']));
	//$idmovimiento=mysql_real_escape_string($idmovimiento);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idmovimiento no es correcto</p>";
}

if (isset($_POST['idsucursalorigen'])){
	$idsucursalorigen=htmlentities(trim($_POST['idsucursalorigen']));
	//$idsucursalorigen=mysql_real_escape_string($idsucursalorigen);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idsucursalorigen no es correcto</p>";
}

if (isset($_POST['idsucursaldestino'])){
	$idsucursaldestino=htmlentities(trim($_POST['idsucursaldestino']));
	//$idsucursaldestino=mysql_real_escape_string($idsucursaldestino);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idsucursaldestino no es correcto</p>";
}

if (isset($_POST['fechasalida'])){
	$fechasalida=htmlentities(trim($_POST['fechasalida']));
	//$fechasalida=mysql_real_escape_string($fechasalida);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo fechasalida no es correcto</p>";
}

if (isset($_POST['fechaentrada'])){
	$fechaentrada=htmlentities(trim($_POST['fechaentrada']));
	//$fechaentrada=mysql_real_escape_string($fechaentrada);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo fechaentrada no es correcto</p>";
}

if (isset($_POST['estado'])){
	$estado=htmlentities(trim($_POST['estado']));
	//$estado=mysql_real_escape_string($estado);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo estado no es correcto</p>";
}

if (isset($_POST['numerocomprobante'])){
	$numerocomprobante=htmlentities(trim($_POST['numerocomprobante']));
	//$numerocomprobante=mysql_real_escape_string($numerocomprobante);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo numerocomprobante no es correcto</p>";
}

if (isset($_POST['idusuariosalida'])){
	$idusuariosalida=htmlentities(trim($_POST['idusuariosalida']));
	//$idusuariosalida=mysql_real_escape_string($idusuariosalida);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idusuariosalida no es correcto</p>";
}

if (isset($_POST['idusuarioentrada'])){
	$idusuarioentrada=htmlentities(trim($_POST['idusuarioentrada']));
	//$idusuarioentrada=mysql_real_escape_string($idusuarioentrada);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idusuarioentrada no es correcto</p>";
}
if($validacion){
	$resultado=$Otraspaso->guardar($idmovimiento,$idsucursalorigen,$idsucursaldestino,$fechasalida,$fechaentrada,$estado,$numerocomprobante,$idusuariosalida,$idusuarioentrada);
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