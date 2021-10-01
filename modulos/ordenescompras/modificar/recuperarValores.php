<?php
require("../Compra.class.php");
$idcompra=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Ocompra= new Compra;
	$resultado=$Ocompra->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$fecha=$extractor["fecha"];
	$fechavencimiento=$extractor["fechavencimiento"];
	$idempleado=$extractor["idempleado"];
	$idsucursal=$extractor["idsucursal"];
	$comentarios=$extractor["comentarios"];
	$estado=$extractor["estado"];
	$idproveedor=$extractor["idproveedor"];
	$nombreProveedor=$extractor["nombreproveedores"];
	$nombreSucursal=$extractor["nombresucursales"];
}else{
	header("Location: ../nuevo/nuevo.php");
}
?>