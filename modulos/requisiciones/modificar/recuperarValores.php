<?php
require("../Requisicion.class.php");
$idrequisicion=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Orequisicion= new Requisicion;
	$resultado=$Orequisicion->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$fecha=$extractor["fecha"];
	$idempleado=$extractor["idempleado"];
	$idsucursal=$extractor["idsucursal"];
	$comentarios=$extractor["comentarios"];
	$estado=$extractor["estado"];
	$folio=$extractor["folio"];
	$serie=$extractor["serie"];
	$idproveedor=$extractor["idproveedor"];
	$nombreproveedor=$Orequisicion->obtenerCampo("proveedores","nombre","idproveedor",$idproveedor);
	
}else{
	header("Location: ../nuevo/nuevo.php");
}
?>