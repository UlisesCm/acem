<?php
require("../Auditoria.class.php");
$idauditoria=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Oauditoria= new Auditoria;
	$resultado=$Oauditoria->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$fecha=$extractor["fecha"];
	$idusuario=$extractor["idusuario"];
	$idfamilia=$extractor["idfamilia"];
	$idsucursal=$extractor["idsucursal"];
	$comentarios=$extractor["comentarios"];
	$nombreFamilia=$extractor["nombrefamilias"];
	$nombreSucursal=$extractor["nombresucursales"];
	$responsable=$extractor["nombreusuarios"];
	$estado=$extractor["estado"];
}else{
	header("Location: ../nuevo/nuevo.php");
}
?>