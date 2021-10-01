<?php
require("../Plantillamensaje.class.php");
$idplantillamensaje=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Oplantillamensaje= new Plantillamensaje;
	$resultado=$Oplantillamensaje->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$titulo=$extractor["titulo"];
	$asunto=$extractor["asunto"];
	$mensaje=$extractor["mensaje"];
}else{
	header("Location: ../nuevo/nuevo.php");
}
?>