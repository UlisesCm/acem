<?php
require("../Datofiscal.class.php");
$iddatofiscal=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Odatofiscal= new Datofiscal;
	$resultado=$Odatofiscal->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$idcliente=$extractor["idcliente"];
	$domiciliocompleto=$extractor["domiciliocompleto"];
	$formapago=$extractor["formapago"];
	$metodopago=$extractor["metodopago"];
	$usocfdi=$extractor["usocfdi"];
	$estatus=$extractor["estatus"];
}else{
	header("Location: ../nuevo/nuevo.php");
}
?>