<?php
require("../Asignacionvehicular.class.php");
$idasignacionvehicular=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Oasignacionvehicular= new Asignacionvehicular;
	$resultado=$Oasignacionvehicular->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$fecha=$extractor["fecha"];
	$idempleado=$extractor["idempleado"];
	$idvehiculo=$extractor["idvehiculo"];
	$observaciones=$extractor["observaciones"];
}else{
	header("Location: ../nuevo/nuevo.php");
}
?>