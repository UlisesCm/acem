<?php
require("../Girocomercial.class.php");
$idgirocomercial=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Ogirocomercial= new Girocomercial;
	$resultado=$Ogirocomercial->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$nombre=$extractor["nombre"];
	$estatus=$extractor["estatus"];
}else{
	header("Location: ../nuevo/nuevo.php");
}
?>