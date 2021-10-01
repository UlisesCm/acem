<?php
require("../Captacion.class.php");
$idcaptacion=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Ocaptacion= new Captacion;
	$resultado=$Ocaptacion->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$nombre=$extractor["nombre"];
	$estatus=$extractor["estatus"];
}else{
	header("Location: ../nuevo/nuevo.php");
}
?>