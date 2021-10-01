<?php
require("../Zona.class.php");
$idzona=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Ozona= new Zona;
	$resultado=$Ozona->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$nombre=$extractor["nombre"];
	$estatus=$extractor["estatus"];
}else{
	header("Location: ../nuevo/nuevo.php");
}
?>