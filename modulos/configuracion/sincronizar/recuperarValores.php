<?php
require("../Configuracion.class.php");
	$idconfiguracion=1;
	$id=1;
	$Oconfiguracion= new Configuracion;
	$resultado=$Oconfiguracion->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$cabeceraimpresion=$extractor["cabeceraimpresion"];
	$pieimpresion=$extractor["pieimpresion"];
	$separadorimpresion=$extractor["separadorimpresion"];
	$descripcioncompletaimpresion=$extractor["descripcioncompletaimpresion"];

?>