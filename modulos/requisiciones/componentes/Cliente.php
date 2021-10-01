<?php 
	include("../../clientes/Cliente.class.php");
	$buscar=htmlentities($_POST['termino']);
	$Ocliente = new Cliente;
	$resultado=$Ocliente->consultaGeneral("WHERE nombre ='$buscar'  AND clasificacion ='Cliente Mayorista'");
	$descripcion = new stdClass();
	if(mysqli_num_rows($resultado) > 0){
		$filas=mysqli_fetch_array($resultado);
		$descripcion->id= $filas['idcliente'];
	}
	echo json_encode($descripcion);
?>
		