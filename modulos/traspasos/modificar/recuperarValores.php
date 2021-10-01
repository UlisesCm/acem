<?php
require("../Traspaso.class.php");
$idtraspaso=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Otraspaso= new Traspaso;
	$resultado=$Otraspaso->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$idmovimiento=$extractor["idmovimiento"];
	$idsucursalorigen=$extractor["idsucursalorigen"];
	$idsucursaldestino=$extractor["idsucursaldestino"];
	$fechasalida=$extractor["fechasalida"];
	$fechaentrada=$extractor["fechaentrada"];
	$estado=$extractor["estado"];
	$numerocomprobante=$extractor["numerocomprobante"];
	$idusuariosalida=$extractor["idusuariosalida"];
	$idusuarioentrada=$extractor["idusuarioentrada"];
}else{
	header("Location: ../nuevo/nuevo.php");
}
?>