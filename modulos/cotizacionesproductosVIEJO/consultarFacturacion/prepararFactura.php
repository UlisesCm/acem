<?php
include ("../../seguridad/comprobar_login.php");
/////PERMISOS////////////////
if (!isset($_SESSION['permisos']['cotizacionesproductos']['acceso'])){
	echo $_SESSION['msgsinacceso'];
	exit;
}
/////FIN  DE PERMISOS////////
include ("../../../librerias/php/variasfunciones.php");
require('../Cotizacionproducto.class.php');
$Ocotizacion=new Cotizacionproducto;

$idcotizacionproducto=$_POST['idcotizacionproducto'];
$subfolio=$_POST['subfolio'];

$idtemporal=$Ocotizacion->guardarTemporalSimple($idcotizacionproducto,$subfolio);
if($idtemporal != "fracaso"){
	header("Location: ../../facturacion/nuevo/nuevo.php?idtemporal=$idtemporal");
}
?>

    