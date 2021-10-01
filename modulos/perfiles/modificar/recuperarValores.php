<?php
require("../Perfil.class.php");
$idperfil=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Operfil= new Perfil;
	$resultado=$Operfil->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$nombre=$extractor["nombre"];
	$color=$extractor["color"];
}else{
	header("Location: ../nuevo/nuevo.php");
}
?>