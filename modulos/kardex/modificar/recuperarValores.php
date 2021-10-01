<?php
require("../Kardex.class.php");
$idkardex=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Okardex= new Kardex;
	$resultado=$Okardex->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$idproducto=$extractor["idproducto"];
	$fechamovimiento=$extractor["fechamovimiento"];
	$descripcion=$extractor["descripcion"];
	$observaciones=$extractor["observaciones"];
	$entrada=$extractor["entrada"];
	$salida=$extractor["salida"];
	$existencia=$extractor["existencia"];
	$costounitario=$extractor["costounitario"];
	$promedio=$extractor["promedio"];
	$debe=$extractor["debe"];
	$haber=$extractor["haber"];
	$saldo=$extractor["saldo"];
	$idalmacen=$extractor["idalmacen"];
	$idmovimiento=$extractor["idmovimiento"];
	$idreferencia=$extractor["idreferencia"];
	$estatus=$extractor["estatus"];
}else{
	header("Location: ../nuevo/nuevo.php");
}
?>