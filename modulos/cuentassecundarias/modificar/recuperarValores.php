<?php
require("../Cuentasecundaria.class.php");
$idcuentasecundaria=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Ocuentasecundaria= new Cuentasecundaria;
	$resultado=$Ocuentasecundaria->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$nombre=$extractor["nombre"];
	$idcuentaprincipal=$extractor["idcuentaprincipal"];
	$estatus=$extractor["estatus"];
}else{
	header("Location: ../nuevo/nuevo.php");
}
?>