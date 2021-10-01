<?php
require("../Compra.class.php");
$idcompra=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Ocompra= new Compra;
	$resultado=$Ocompra->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$fecha=$extractor["fecha"];
	$idempleado=$extractor["idempleado"];
	$comentarios=$extractor["comentarios"];
	$estado=$extractor["estado"];
	$monto=$extractor["monto"];
	$idsucursal=$extractor["idsucursal"];
	$idproveedor=$extractor["idproveedor"];
	$factura=$extractor["factura"];
}else{
	header("Location: ../nuevo/nuevo.php");
}
?>