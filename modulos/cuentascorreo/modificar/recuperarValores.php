<?php
require("../Cuentacorreo.class.php");
$idcuentacorreo=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Ocuentacorreo= new Cuentacorreo;
	$resultado=$Ocuentacorreo->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$usuario=$extractor["usuario"];
	$contrasena=$extractor["contrasena"];
	$servidorsmtp=$extractor["servidorsmtp"];
	$servidorpop=$extractor["servidorpop"];
	$puertosmtp=$extractor["puertosmtp"];
	$puertopop=$extractor["puertopop"];
	$autenticacionssl=$extractor["autenticacionssl"];
	$estatus=$extractor["estatus"];
}else{
	header("Location: ../nuevo/nuevo.php");
}
?>