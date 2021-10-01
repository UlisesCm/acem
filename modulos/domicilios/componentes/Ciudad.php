<?php 
	include("../../ciudades/Ciudad.class.php");
	$buscar=htmlentities($_POST['termino']);
	$Ociudad = new Ciudad;
	$resultado=$Ociudad->consultaGeneral("WHERE nombre ='$buscar'");
	$descripcion = new stdClass();
	if(mysqli_num_rows($resultado) > 0){
		$filas=mysqli_fetch_array($resultado);
		$descripcion->id= $filas['nombre'];
	}
	echo json_encode($descripcion);
?>
		