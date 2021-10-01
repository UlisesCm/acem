<?php 
	include("../../clientes/Cliente.class.php");
	$buscar=htmlentities($_POST['termino']);
	$Ocliente = new Cliente;
	$resultado=$Ocliente->consultaGeneral("WHERE rfc ='$buscar' AND estatus <> 'eliminado'");
	$descripcion = new stdClass();
	if(mysqli_num_rows($resultado) > 0){
		$filas=mysqli_fetch_array($resultado);
		$descripcion->id= $filas['rfc'];
	}
	echo json_encode($descripcion);
?>
		