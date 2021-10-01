<?php
require("../Cuentaprincipal.class.php");
$idcuentaprincipal=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Ocuentaprincipal= new Cuentaprincipal;
	$resultado=$Ocuentaprincipal->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$nombre=$extractor["nombre"];
	$tipo=$extractor["tipo"];
	$estatus=$extractor["estatus"];
}else{
	header("Location: ../nuevo/nuevo.php");
}
?>