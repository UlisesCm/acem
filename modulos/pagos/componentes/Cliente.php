<?php 
	include("../../clientes/Cliente.class.php");
	$buscar=htmlentities($_POST['termino']);
	$Ocliente = new Cliente;
	$resultado=$Ocliente->consultaGeneral("WHERE nombre ='$buscar' AND estatus <> 'elimiando'");
	$descripcion = new stdClass();
	$descripcion->saldofavor="0.00";
	if(mysqli_num_rows($resultado) > 0){
		$filas=mysqli_fetch_array($resultado);
		$descripcion->id= $filas['idcliente'];
		$descripcion->saldofavor= $filas['saldofavor'];
	}
	echo json_encode($descripcion);
?>
		