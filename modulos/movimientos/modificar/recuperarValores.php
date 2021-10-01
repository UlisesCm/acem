<?php
require("../Movimiento.class.php");
$idmovimiento=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Omovimiento= new Movimiento;
	$resultado=$Omovimiento->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$tipo=$extractor["tipo"];
	$concepto=$extractor["concepto"];
	$fechamovimiento=$extractor["fechamovimiento"];
	$idalmacen=$extractor["idalmacen"];
	$numerocomprobante=$extractor["numerocomprobante"];
	$comentarios=$extractor["comentarios"];
	$estatus=$extractor["estatus"];
}else{
	header("Location: ../nuevo/nuevo.php");
}
?>