<?php 
	include("../../categorias/Categoria.class.php");
	$buscar=htmlentities($_GET['term']);
	$Ocategoria = new Categoria;
	$resultado=$Ocategoria->consultaGeneral("WHERE nombre LIKE '%$buscar%' AND estatus <> 'eliminado' LIMIT 0, 19");
	$con=0;
	$return_arr = array();
	if(mysqli_num_rows($resultado) > 0){
		while($filas=mysqli_fetch_array($resultado)){
			$descripcion["id"] = html_entity_decode($filas['idcategoria']);
			$descripcion["consulta"] = html_entity_decode($filas['nombre']);
			$descripcion["label"] = html_entity_decode($filas['nombre']);
			array_push($return_arr,$descripcion);
			$con++;
		}
		echo json_encode($return_arr);
	}
?>
		