<?php 
include ("../../seguridad/comprobar_login.php");
require('../Cotizacionproducto.class.php');

$Ocotizacionproducto=new Cotizacionproducto;
$mensaje="";

if (isset($_REQUEST['dias']) && $_REQUEST['dias'] !="") {
			$dias=$_REQUEST['dias'];
}
if($resultado=$Ocotizacionproducto->eliminarauto($dias, "falsa")){
}

echo utf8_encode($resultado);
?>
