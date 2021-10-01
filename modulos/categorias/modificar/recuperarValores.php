<?php
require("../Categoria.class.php");
$idcategoria=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Ocategoria= new Categoria;
	$resultado=$Ocategoria->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$codigo=$extractor["codigo"];
	$nombre=$extractor["nombre"];
	$estatus=$extractor["estatus"];
}else{
	header("Location: ../nuevo/nuevo.php");
}
?>