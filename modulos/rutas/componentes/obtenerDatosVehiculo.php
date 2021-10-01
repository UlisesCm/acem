<?php 
	include("../../vehiculos/Vehiculo.class.php");
	$Ovehiculo = new Vehiculo;
	
	
	if (isset($_POST['idempleado'])) {
		$idempleado=$_POST['idempleado'];
	}else{
		$idempleado=1;
	}
	$resultado=$Ovehiculo->consultaAsignacionVehicular($idempleado);
	
	echo $resultado;
	
?>