<?php
require("../Retiro.class.php");
$idretiro=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Oretiro= new Retiro;
	$resultado=$Oretiro->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$fecha=$extractor["fecha"];
	$descripcion=$extractor["descripcion"];
	$monto=$extractor["monto"];
	$cheque=$extractor["cheque"];
	$idcuenta=$extractor["idcuenta"];
	$estatus=$extractor["estatus"];
}else{
	header("Location: ../nuevo/nuevo.php");
}
?>