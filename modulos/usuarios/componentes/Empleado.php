<?php
	include("../../empleados/Empleado.class.php");
	$buscar=htmlentities($_POST['termino']);
	$Oempleado = new Empleado;
	$resultado=$Otecnico->consultaGeneral("WHERE nombre ='$buscar' AND estatus <> 'eliminado'");
	$descripcion = new stdClass();
	if(mysqli_num_rows($resultado) > 0){
		$filas=mysqli_fetch_array($resultado);
		$descripcion->id= $filas['idempleado'];
	}
	echo json_encode($descripcion);
?>
