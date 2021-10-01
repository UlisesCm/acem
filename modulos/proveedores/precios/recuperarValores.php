<?php
require("../Proveedor.class.php");
$idproveedor=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Oproveedor= new Proveedor;
	$resultado=$Oproveedor->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$nombre=$extractor["nombre"];
	$estatus=$extractor["estatus"];
}else{
	header("Location: ../nuevo/nuevo.php");
}
?>