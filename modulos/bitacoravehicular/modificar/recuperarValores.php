<?php
require("../Bitacoravehicular.class.php");
$idbitacoravehicular=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Obitacoravehicular= new Bitacoravehicular;
	$resultado=$Obitacoravehicular->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$idvehiculo=$extractor["idvehiculo"];
	$categoria=$extractor["categoria"];
	$fecha=$extractor["fecha"];
	$descripcion=$extractor["descripcion"];
	$tipocombustible=$extractor["tipocombustible"];
	$litros=$extractor["litros"];
	$kilometraje=$extractor["kilometraje"];
	$archivo=$extractor["archivo"];
	$estatus=$extractor["estatus"];
}else{
	header("Location: ../nuevo/nuevo.php");
}
?>