<?php
require("../Listaprecios.class.php");
$idlistaprecios=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Olistaprecios= new Listaprecios;
	$resultado=$Olistaprecios->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$nombre=$extractor["nombre"];
	$estatus=$extractor["estatus"];
}else{
	header("Location: ../nuevo/nuevo.php");
}
?>