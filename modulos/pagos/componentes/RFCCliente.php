<?php 
	include("../../clientes/Cliente.class.php");
	$buscar=htmlentities($_POST['termino']);
	$Ocliente = new Cliente;
	$resultado=$Ocliente->consultaLibre("SELECT rfc FROM personas WHERE rfc = '$buscar'");
	$descripcion = new stdClass();
	if(mysqli_num_rows($resultado) > 0){
		$filas=mysqli_fetch_array($resultado);
		$descripcion->id= $filas['rfc'];
	}
	echo json_encode($descripcion);
?>
		