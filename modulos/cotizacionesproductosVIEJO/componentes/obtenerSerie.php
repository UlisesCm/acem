<?php 
	include("../../folios/Folio.class.php");
	$Oserie = new Folio;
	$serie=$Oserie->obtenerSerie("PRODUCTOS");
	echo $serie;
?>