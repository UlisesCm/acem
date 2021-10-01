<?php 
include ("../../seguridad/comprobar_login.php");
require('../../ventas/Venta.class.php');
ini_set("max_execution_time","640");
$Oventa=new Venta;
$mensaje="";
$utilidad=0;
$idventa=0;

$resultado2=$Oventa->consultaLibre("SELECT idventa FROM ventas");
while ($filas2=mysqli_fetch_array($resultado2)) {
	$idventa=$filas2['idventa'];
	$resultado=$Oventa->consultaLibre("SELECT SUM(utilidad) FROM detalleventas WHERE idventa='$idventa'");
	if ($row3 = mysqli_fetch_row($resultado)) {
		$utilidad= $row3[0];
	}else{
		$utilidad=0;
	}
	$Oventa->consultaLibre("UPDATE ventas SET utilidad='$utilidad' WHERE idventa='$idventa'");
}
	
echo utf8_encode("Operación exitosa");

?>