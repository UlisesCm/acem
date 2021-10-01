<?php
require("../Archivo.class.php");
$idarchivo=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Oarchivo= new Archivo;
	$resultado=$Oarchivo->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$pdf=$extractor["pdf"];
	$xml=$extractor["xml"];
	$fechamodificacion=$extractor["fechamodificacion"];
	$tablareferencia=$extractor["tablareferencia"];
	$idreferencia=$extractor["idreferencia"];
	$serie=$extractor["serie"];
	$folio=$extractor["folio"];
	$tipo=$extractor["tipo"];
	$fechatimbre=$extractor["fechatimbre"];
	$emisor=$extractor["emisor"];
	$rfcemisor=$extractor["rfcemisor"];
	$receptor=$extractor["receptor"];
	$rfcreceptor=$extractor["rfcreceptor"];
	$monto=$extractor["monto"];
	$uuid=$extractor["uuid"];
}else{
	header("Location: ../nuevo/nuevo.php");
}
?>