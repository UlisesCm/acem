<?php
require("../Folio.class.php");
$idfolio=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Ofolio= new Folio;
	$resultado=$Ofolio->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$serie=$extractor["serie"];
	$folioactual=$extractor["folioactual"];
	$asignacion=$extractor["asignacion"];
	$idsucursal=$extractor["idsucursal"];
	$estatus=$extractor["estatus"];
}else{
	header("Location: ../nuevo/nuevo.php");
}
?>