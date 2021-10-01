<?php
require("../../notario/Notario.class.php");
$idnotario=1;
if ($idnotario){
	$id=htmlentities(trim($idnotario));
	$Onotario= new Notario;
	$resultado=$Onotario->mostrarIndividual($idnotario);
	$extractor = mysqli_fetch_array($resultado);
	$curpnotario=$extractor["curpnotario"];
	$numeronotaria=$extractor["numeronotaria"];
	$entidadfederativa=$extractor["entidadfederativa"];
	$adscripcion=$extractor["adscripcion"];
}
?>