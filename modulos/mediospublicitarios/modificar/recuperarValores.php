<?php
require("../Mediopublicitario.class.php");
$idmediopublicitario=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Omediopublicitario= new Mediopublicitario;
	$resultado=$Omediopublicitario->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$nombre=$extractor["nombre"];
	$estatus=$extractor["estatus"];
}else{
	header("Location: ../nuevo/nuevo.php");
}
?>