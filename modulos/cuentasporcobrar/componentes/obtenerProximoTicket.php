<?php 
	include("../Venta.class.php");
	$Oventa = new Venta;
	$resultado=$Oventa->obtenerProximoTicket($_SESSION['idalmacen']);
	echo $resultado;
?>