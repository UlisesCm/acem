<?php 
include ("../../seguridad/comprobar_login.php");
require('../Auditoria.class.php');
$Oauditoria=new Auditoria;
$mensaje="";
$validacion=true;

if (isset($_POST['fecha'])){
	$fecha=htmlentities(trim($_POST['fecha']));
	//$fecha=mysql_real_escape_string($fecha);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo fecha no es correcto</p>";
}

if (isset($_POST['idusuario'])){
	$idusuario=htmlentities(trim($_POST['idusuario']));
	//$idusuario=mysql_real_escape_string($idusuario);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idusuario no es correcto</p>";
}

if (isset($_POST['idfamiliamadre'])){
	$idfamilia=htmlentities(trim($_POST['idfamiliamadre']));
	//$idfamilia=mysql_real_escape_string($idfamilia);
	if ($idfamilia==0 or $idfamilia==""){
		$validacion=false;
		$mensaje=$mensaje."<p>Es necesario que elija una familia de productos v&aacute;lida</p>";
	}
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idfamilia no es correcto</p>";
}

if (isset($_POST['idsucursal'])){
	$idsucursal=htmlentities(trim($_POST['idsucursal']));
	//$idsucursal=mysql_real_escape_string($idsucursal);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idsucursal no es correcto</p>";
}

if (isset($_POST['comentarios'])){
	$comentarios=htmlentities(trim($_POST['comentarios']));
	//$comentarios=mysql_real_escape_string($comentarios);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo comentarios no es correcto</p>";
}

if (isset($_POST['estado'])){
	$estado=htmlentities(trim($_POST['estado']));
	//$estado=mysql_real_escape_string($estado);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo estado no es correcto</p>";
}
if($validacion){
	$resultado=$Oauditoria->guardar($fecha,$idusuario,$idfamilia,$idsucursal,$comentarios,$estado);
	$resultado2=explode("@",$resultado);
	if($resultado2[0]=="exito"){
		$mensaje="exito@".$resultado2[1];
	}
	if($resultado=="fracaso"){
		$mensaje="fracaso@Operaci&oacute;n fallida@Ha ocurrido un problema en la base de datos [001]";
	}
	if($resultado=="fracasoDetalles"){
		$mensaje="fracaso@Operaci&oacute;n fallida@No se han podido guardar los detalles de la auditor&iacute;a";
	}
	if($resultado=="denegado"){
		$mensaje="aviso@Acceso denegado@Su cuenta no cuenta con los privilegios para poder realizar esta tarea";
	}
}else{
	$mensaje="fracaso@Operaci&oacute;n fallida@ $mensaje";
}

echo utf8_encode($mensaje);

?>