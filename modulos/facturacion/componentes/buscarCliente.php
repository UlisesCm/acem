<?php 
	include("../../clientes/Cliente.class.php");
	$buscar=htmlentities($_GET['term']);
	$OPersona = new Cliente;
	$resultado=$OPersona->consultaGeneral("WHERE nombre LIKE '%$buscar%' AND estatus <> 'eliminado' LIMIT 0, 19");
	$con=0;
	$return_arr = array();
	if(mysqli_num_rows($resultado) > 0){
		while($filas=mysqli_fetch_array($resultado)){
			$descripcion["id"] = html_entity_decode($filas['idcliente']);
			$descripcion["consulta"] = html_entity_decode($filas['nombre']);
			$descripcion["label"] = html_entity_decode($filas['nombre']);
			$descripcion["uso"] = "P01";//html_entity_decode($filas['usocfdi']);
			array_push($return_arr,$descripcion);
			$con++;
		}
		echo json_encode($return_arr);
	}
?>
		