<?php
require("../Bitacoragerencial.class.php");
$idbitacoragerencial=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Obitacoragerencial= new Bitacoragerencial;
	$resultado=$Obitacoragerencial->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$fecha=$extractor["fecha"];
	$evento=$extractor["evento"];
	$idusuario=$extractor["idusuario"];
	$idsucursal=$extractor["idsucursal"];
	$archivo=$extractor["archivo"];
	$estatus=$extractor["estatus"];
}else{
	header("Location: ../nuevo/nuevo.php");
}
?>