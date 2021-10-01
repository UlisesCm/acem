<?php
require("../Caracteristica.class.php");
$idcaracteristica=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Ocaracteristica= new Caracteristica;
	$resultado=$Ocaracteristica->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$caracteristica=$extractor["caracteristica"];
	$valor=$extractor["valor"];
}else{
	header("Location: ../nuevo/nuevo.php");
}
?>