<?php
require("../Vehiculo.class.php");
$idvehiculo=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Ovehiculo= new Vehiculo;
	$resultado=$Ovehiculo->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$tipo=$extractor["tipo"];
	$marca=$extractor["marca"];
	$submarca=$extractor["submarca"];
	$color=$extractor["color"];
	$placa=$extractor["placa"];
	$capacidaddecarga=$extractor["capacidaddecarga"];
	$anio=$extractor["anio"];
	$kminicial=$extractor["kminicial"];
	$kmactual=$extractor["kmactual"];
	$vigenciaseguro=$extractor["vigenciaseguro"];
	$kmultimomantenimiento=$extractor["kmultimomantenimiento"];
	$fechaultimomantenimiento=$extractor["fechaultimomantenimiento"];
	$tipodecombustible=$extractor["tipodecombustible"];
	$frecuenciamantenimientokm=$extractor["frecuenciamantenimientokm"];
	$frecuenciamantenimientofecha=$extractor["frecuenciamantenimientofecha"];
	$asignado=$extractor["asignado"];
	$estado=$extractor["estado"];
	$idempleado=$extractor["idempleado"];
	$idsucursal=$extractor["idsucursal"];
	$estatus=$extractor["estatus"];
}else{
	header("Location: ../nuevo/nuevo.php");
}
?>