<?php 
	include("../../folios/Folio.class.php");
	$Ofolio = new Folio;
	$campo="serie";
	$folio=$Ofolio->obtenerFolio("PRODUCTOS");
	echo $folio;
?>