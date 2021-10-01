<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
require('../Proveedor.class.php');
$Oproveedor=new Proveedor;
$mensaje="";
$validacion=true;

if (isset($_POST['idproveedor'])){
	$idproveedor=htmlentities(trim($_POST['idproveedor']));
	//$idproveedor=mysql_real_escape_string($idproveedor);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idproveedor no es correcto</p>";
}

if (isset($_POST['nombre'])){
	$nombre=htmlentities(trim($_POST['nombre']));
	//$nombre=mysql_real_escape_string($nombre);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo nombre no es correcto</p>";
}

if (isset($_POST['rfc'])){
	$rfc=htmlentities(trim($_POST['rfc']));
	//$rfc=mysql_real_escape_string($rfc);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo rfc no es correcto</p>";
}

if (isset($_POST['nivelcalidad'])){
	$nivelcalidad=htmlentities(trim($_POST['nivelcalidad']));
	//$nivelcalidad=mysql_real_escape_string($nivelcalidad);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo nivelcalidad no es correcto</p>";
}

if (isset($_POST['nivelexistencia'])){
	$nivelexistencia=htmlentities(trim($_POST['nivelexistencia']));
	//$nivelexistencia=mysql_real_escape_string($nivelexistencia);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo nivelexistencia no es correcto</p>";
}

if (isset($_POST['tiemporespuesta'])){
	$tiemporespuesta=htmlentities(trim($_POST['tiemporespuesta']));
	//$tiemporespuesta=mysql_real_escape_string($tiemporespuesta);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo tiemporespuesta no es correcto</p>";
}

if (isset($_POST['tipoprontopago'])){
	$tipoprontopago=htmlentities(trim($_POST['tipoprontopago']));
	//$tipoprontopago=mysql_real_escape_string($tipoprontopago);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo tipoprontopago no es correcto</p>";
}

if (isset($_POST['prontopagofactura'])){
	$prontopagofactura=htmlentities(trim($_POST['prontopagofactura']));
	//$prontopagofactura=mysql_real_escape_string($prontopagofactura);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo prontopagofactura no es correcto</p>";
}

if (isset($_POST['prontopagorecepcion'])){
	$prontopagorecepcion=htmlentities(trim($_POST['prontopagorecepcion']));
	//$prontopagorecepcion=mysql_real_escape_string($prontopagorecepcion);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo prontopagorecepcion no es correcto</p>";
}

if (isset($_POST['email'])){
	$email=htmlentities(trim($_POST['email']));
	//$email=mysql_real_escape_string($email);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo email no es correcto</p>";
}

if (isset($_POST['estatus'])){
	$estatus=htmlentities(trim($_POST['estatus']));
	//$estatus=mysql_real_escape_string($estatus);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo estatus no es correcto</p>";
}
if($validacion){
	$resultado=$Oproveedor->actualizar($nombre,$rfc,$nivelcalidad,$nivelexistencia,$tiemporespuesta,$tipoprontopago,$prontopagofactura,$prontopagorecepcion,$estatus, $email, $idproveedor);
	if($resultado=="exito"){
		
		$mensaje="exito@Operaci&oacute;n exitosa@El registro ha sido guardado";
	}
	if($resultado=="nombreExiste"){
		$mensaje="fracaso@Operaci&oacute;n fallida@El campo nombre ya existe en la base de datos";
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