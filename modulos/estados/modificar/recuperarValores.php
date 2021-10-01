<?php
require("../Estado.class.php");
$idestado=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Oestado= new Estado;
	$resultado=$Oestado->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$nombre=$extractor["nombre"];
}else{
	header("Location: ../nuevo/nuevo.php");
}
?>