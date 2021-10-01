<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../cotizacionesproductos/Cotizacionproducto.class.php");
//$idreferencia = $_POST['idreferencia'];
$idreferencia = $_POST['idreferencia'];
$tablareferencia = $_POST['tablareferencia'];

$Ocotizacionproducto = new Cotizacionproducto;
$estadoLiquidacion="NO APLICA";
if($tablareferencia=="cotizacionesproductos"){
	$cotizacionesproductos = "cotizacionesproductos" . $_SESSION["idsucursal"];
	$resultado=$Ocotizacionproducto->consultaLibre("SELECT estadoliquidacion FROM $cotizacionesproductos WHERE idcotizacionproducto ='$idreferencia'");
	if(mysqli_num_rows($resultado) > 0){
		$filas=mysqli_fetch_array($resultado);
		$estadoLiquidacion=$filas['estadoliquidacion'];
	}
}

echo $estadoLiquidacion;
?>