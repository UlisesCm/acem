<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
require('../Ruta.class.php');
$Oruta=new Ruta;
$mensaje="";
$validacion=true;

if (isset($_POST['serie'])){
	$serie=htmlentities(trim($_POST['serie']));
	//$serie=mysql_real_escape_string($serie);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo serie no es correcto</p>";
}

if (isset($_POST['folio'])){
	$folio=htmlentities(trim($_POST['folio']));
	//$folio=mysql_real_escape_string($folio);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo folio no es correcto</p>";
}

if (isset($_POST['nombre'])){
	$nombre=htmlentities(trim($_POST['nombre']));
	//$nombre=mysql_real_escape_string($nombre);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo nombre no es correcto</p>";
}

if (isset($_POST['fecha'])){
	$fecha=htmlentities(trim($_POST['fecha']));
	//$fecha=mysql_real_escape_string($fecha);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo fecha no es correcto</p>";
}

if (isset($_POST['idempleado'])){
	$idempleado=htmlentities(trim($_POST['idempleado']));
	//$idempleado=mysql_real_escape_string($idempleado);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idempleado no es correcto</p>";
}

if (isset($_POST['observacionesruta'])){
	$observacionesruta=htmlentities(trim($_POST['observacionesruta']));
	//$observacionesruta=mysql_real_escape_string($observacionesruta);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo observacionesruta no es correcto</p>";
}

if (isset($_POST['observacionessalida'])){
	$observacionessalida=htmlentities(trim($_POST['observacionessalida']));
	//$observacionessalida=mysql_real_escape_string($observacionessalida);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo observacionessalida no es correcto</p>";
}

if (isset($_POST['autorizada'])){
	$autorizada=htmlentities(trim($_POST['autorizada']));
	//$autorizada=mysql_real_escape_string($autorizada);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo autorizada no es correcto</p>";
}

if (isset($_POST['estatus'])){
	$estatus=htmlentities(trim($_POST['estatus']));
	//$estatus=mysql_real_escape_string($estatus);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo estatus no es correcto</p>";
}
if($validacion){
	$resultado=$Oruta->guardar($serie,$folio,$nombre,$fecha,$idempleado,$observacionesruta,$observacionessalida,$autorizada,$estatus);
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