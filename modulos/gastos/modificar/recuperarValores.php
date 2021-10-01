<?php
require("../Gasto.class.php");
$idgasto=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Ogasto= new Gasto;
	$resultado=$Ogasto->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$idcuentaprincipal=$extractor["idcuentaprincipal"];
	$idcuentasecundaria=$extractor["idcuentasecundaria"];
	$descripcion=$extractor["descripcion"];
	$idproveedor=$extractor["idproveedor"];
	$factura=$extractor["factura"];
	$idmodeloimpuestos=$extractor["idmodeloimpuestos"];
	$subtotal=$extractor["subtotal"];
	$impuestos=$extractor["impuestos"];
	$total=$extractor["total"];
	$idretiro=$extractor["idretiro"];
	$estatus=$extractor["estatus"];
}else{
	header("Location: ../nuevo/nuevo.php");
}
?>