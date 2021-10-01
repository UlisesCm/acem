<?php
require("../Ruta.class.php");
$idruta=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Oruta= new Ruta;
	$resultado=$Oruta->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$serie=$extractor["serie"];
	$folio=$extractor["folio"];
	$nombre=$extractor["nombre"];
	$fecha=$extractor["fecha"];
	$idempleado=$extractor["idempleado"];
	$observacionesruta=$extractor["observacionesruta"];
	$observacionessalida=$extractor["observacionessalida"];
	$autorizada=$extractor["autorizada"];
	$estatus=$extractor["estatus"];
}else{
	header("Location: ../nuevo/nuevo.php");
}
?>