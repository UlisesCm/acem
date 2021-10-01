<?php
require("../Empresa.class.php");
$idempresa=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Oempresa= new Empresa;
	$resultado=$Oempresa->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$nombrecomercial=$extractor["nombrecomercial"];
	$razonsocial=$extractor["razonsocial"];
	$rfc=$extractor["rfc"];
	$domiciliofiscal=$extractor["domiciliofiscal"];
	$regimen=$extractor["regimen"];
	$telefono=$extractor["telefono"];
	$email=$extractor["email"];
	$licenciasssa=$extractor["licenciasssa"];
	$logo=$extractor["logo"];
	$clave_csd=$extractor["clave_csd"];
	$cer_csd=$extractor["cer_csd"];
	$key_csd=$extractor["key_csd"];
	$numero_csd=$extractor["numero_csd"];
	$estatus=$extractor["estatus"];
}else{
	header("Location: ../nuevo/nuevo.php");
}
?>