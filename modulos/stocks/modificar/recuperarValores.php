<?php
require("../Stock.class.php");
$idstock=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Ostock= new Stock;
	$resultado=$Ostock->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$idproducto=$extractor["idproducto"];
	$fechainicio=$extractor["fechainicio"];
	$fechafin=$extractor["fechafin"];
	$stockminimo=$extractor["stockminimo"];
	$reserva=$extractor["reserva"];
	$stockmaximo=$extractor["stockmaximo"];
}else{
	header("Location: ../nuevo/nuevo.php");
}
?>