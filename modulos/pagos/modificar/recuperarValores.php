<?php
require("../Pago.class.php");
$idpago=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Opago= new Pago;
	$resultado=$Opago->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$idventa=$extractor["idventa"];
	$idventaajuste=$extractor["idventaajuste"];
	$idcliente=$extractor["idcliente"];
	$idcaja=$extractor["idcaja"];
	$fechapago=$extractor["fechapago"];
	$formapago=$extractor["formapago"];
	$monto=$extractor["monto"];
	$descripcion=$extractor["descripcion"];
}else{
	header("Location: ../nuevo/nuevo.php");
}
?>