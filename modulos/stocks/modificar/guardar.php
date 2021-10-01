<?php 
include ("../../seguridad/comprobar_login.php");
require('../Stock.class.php');
$Ostock=new Stock;
$mensaje="";
$validacion=true;

if (isset($_POST['idstock'])){
	$idstock=htmlentities(trim($_POST['idstock']));
	//$idstock=mysql_real_escape_string($idstock);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idstock no es correcto</p>";
}

if (isset($_POST['idproducto'])){
	$idproducto=htmlentities(trim($_POST['idproducto']));
	//$idproducto=mysql_real_escape_string($idproducto);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idproducto no es correcto</p>";
}

if (isset($_POST['fechainicio'])){
	$fechainicio=htmlentities(trim($_POST['fechainicio']));
	//$fechainicio=mysql_real_escape_string($fechainicio);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo fechainicio no es correcto</p>";
}

if (isset($_POST['fechafin'])){
	$fechafin=htmlentities(trim($_POST['fechafin']));
	//$fechafin=mysql_real_escape_string($fechafin);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo fechafin no es correcto</p>";
}

if (isset($_POST['stockminimo'])){
	$stockminimo=htmlentities(trim($_POST['stockminimo']));
	//$stockminimo=mysql_real_escape_string($stockminimo);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo stockminimo no es correcto</p>";
}

if (isset($_POST['reserva'])){
	$reserva=htmlentities(trim($_POST['reserva']));
	//$reserva=mysql_real_escape_string($reserva);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo reserva no es correcto</p>";
}

if (isset($_POST['stockmaximo'])){
	$stockmaximo=htmlentities(trim($_POST['stockmaximo']));
	//$stockmaximo=mysql_real_escape_string($stockmaximo);
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo stockmaximo no es correcto</p>";
}
if($validacion){
	$resultado=$Ostock->actualizar($idproducto,$fechainicio,$fechafin,$stockminimo,$reserva,$stockmaximo, $idstock);
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