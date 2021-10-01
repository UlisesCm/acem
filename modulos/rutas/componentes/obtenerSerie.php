<?php 
	include("../../folios/Folio.class.php");
	$Oserie = new Folio;
	$serie=$Oserie->obtenerSerie("RUTAS");
	echo $serie;
?>