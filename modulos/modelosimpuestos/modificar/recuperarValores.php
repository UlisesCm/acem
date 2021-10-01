<?php
require("../Modeloimpuestos.class.php");
$idmodeloimpuestos=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Omodeloimpuestos= new Modeloimpuestos;
	$resultado=$Omodeloimpuestos->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$nombre=$extractor["nombre"];
	$fechaactualizacion=$extractor["fechaactualizacion"];
	$estatus=$extractor["estatus"];
}else{
	header("Location: ../nuevo/nuevo.php");
}
?>