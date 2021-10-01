<?php
require("../Empleado.class.php");
$idempleado=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Oempleado= new Empleado;
	$resultado=$Oempleado->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$nombre=$extractor["nombre"];
	$puesto=$extractor["puesto"];
	$domicilio=$extractor["domicilio"];
	$telefono=$extractor["telefono"];
	$email=$extractor["email"];
	$estatus=$extractor["estatus"];
}else{
	header("Location: ../nuevo/nuevo.php");
}
?>