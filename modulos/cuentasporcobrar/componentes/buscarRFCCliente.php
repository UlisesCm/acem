<?php 
	include("../../clientes/Cliente.class.php");
	$buscar=htmlentities($_GET['term']);
	$Ocliente = new Cliente;
	$resultado=$Ocliente->consultaLibre("SELECT rfc FROM personas WHERE rfc LIKE '%$buscar%' AND estatus <> 'eliminado' LIMIT 0, 10");
	$con=0;
	$return_arr = array();
	if(mysqli_num_rows($resultado) > 0){
		while($filas=mysqli_fetch_array($resultado)){
			$descripcion["id"] = html_entity_decode($filas['rfc']);
			$descripcion["consulta"] = html_entity_decode($filas['rfc']);
			$descripcion["label"] = html_entity_decode($filas['rfc']);
			array_push($return_arr,$descripcion);
			$con++;
		}
		echo json_encode($return_arr);
	}
?>
		