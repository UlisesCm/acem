<?php
require("../Unidad.class.php");
$idunidad=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Ounidad= new Unidad;
	$resultado=$Ounidad->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$codigo=$extractor["codigo"];
	$nombre=$extractor["nombre"];
	$simbolo=$extractor["simbolo"];
	$estatus=$extractor["estatus"];
}else{
	header("Location: ../nuevo/nuevo.php");
}
?>