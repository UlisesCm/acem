<?php
require("../Marca.class.php");
$idmarca=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Omarca= new Marca;
	$resultado=$Omarca->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$nombre=$extractor["nombre"];
	$estatus=$extractor["estatus"];
}else{
	header("Location: ../nuevo/nuevo.php");
}
?>