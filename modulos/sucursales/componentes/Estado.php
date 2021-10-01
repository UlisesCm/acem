<?php 
	include("../../estados/Estado.class.php");
	$buscar=htmlentities($_POST['termino']);
	$Oestado = new Estado;
	$resultado=$Oestado->consultaGeneral("WHERE nombre ='$buscar'");
	$descripcion = new stdClass();
	if(mysqli_num_rows($resultado) > 0){
		$filas=mysqli_fetch_array($resultado);
		$descripcion->id= $filas['idestado'];
	}
	echo json_encode($descripcion);
?>
		