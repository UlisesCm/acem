<?php
require("../Precios.class.php");
$idprecio=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Oprecios= new Precios;
	$resultado=$Oprecios->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$idlistaprecios=$extractor["idlistaprecios"];
	$idreferencia=$extractor["idreferencia"];
	$descripcion=$extractor["descripcion"];
	$preciopublico=$extractor["preciopublico"];
	$comisiongeneral=$extractor["comisiongeneral"];
	$comisionreferenciado=$extractor["comisionreferenciado"];
	$comisionmaster=$extractor["comisionmaster"];
	$precioproveedor=$extractor["precioproveedor"];
}else{
	header("Location: ../nuevo/nuevo.php");
}
?>