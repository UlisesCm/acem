<?php 
	include("../../domicilios/Domicilio.class.php");
	$buscar=htmlentities($_POST['termino']);
	$Odomicilio = new Domicilio;
	$resultado=$Odomicilio->consultaGeneral("WHERE calle ='$buscar'");
	$descripcion = new stdClass();
	if(mysqli_num_rows($resultado) > 0){
		$filas=mysqli_fetch_array($resultado);
		$descripcion->id= $filas['calle'];
	}
	echo json_encode($descripcion);
?>
		