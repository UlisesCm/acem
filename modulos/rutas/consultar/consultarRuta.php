<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
require('../Cotizacionproducto.class.php');
$Ocotizacionproducto=new Cotizacionproducto;

$mensaje="";
$validacion=true;

	
if (isset($_POST['idruta'])){
	$idruta=htmlentities(trim($_POST['idruta']));
	//$idgirocomercial=mysql_real_escape_string($idgirocomercial);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo idruta no es correcto</p>";
}

if($validacion){
	//Guardar cotización de productos
	$resultado=$Ocotizacionproducto->consultarRuta($idruta);
}

echo utf8_encode($resultado);

?>