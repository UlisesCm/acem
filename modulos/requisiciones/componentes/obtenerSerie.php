<?php 
	include("../../folios/Folio.class.php");
	$Oserie = new Folio;
	$serie=$Oserie->obtenerSerie("REQUISICIONES");
	echo $serie;
?>