<?php
require("../Ciudad.class.php");
$idciudad=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Ociudad= new Ciudad;
	$resultado=$Ociudad->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$nombre=$extractor["nombre"];
	$idestado=$extractor["idestado"];
}else{
	header("Location: ../nuevo/nuevo.php");
}
?>