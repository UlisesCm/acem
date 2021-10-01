<?php
require("../Cuentasbancarias.class.php");
$idcuenta=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Ocuentasbancarias= new Cuentasbancarias;
	$resultado=$Ocuentasbancarias->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$cuenta=$extractor["cuenta"];
	$banco=$extractor["banco"];
	$saldo=$extractor["saldo"];
	$estatus=$extractor["estatus"];
}else{
	header("Location: ../nuevo/nuevo.php");
}
?>