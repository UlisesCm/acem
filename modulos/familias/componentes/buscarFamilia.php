<?php 
	include("../../familias/Familia.class.php");
	$buscar=htmlentities($_GET['term']);
	$Ofamilia = new Familia;
	$resultado=$Ofamilia->consultaGeneral("WHERE nombre LIKE '%$buscar%'  AND estatus <> 'eliminado' ");
	$con=0;
	$return_arr = array();
	if(mysqli_num_rows($resultado) > 0){
		while($filas=mysqli_fetch_array($resultado)){
			$descripcion["id"] = html_entity_decode($filas['idfamilia']);
			$descripcion["consulta"] = html_entity_decode($filas['nombre']);
			$descripcion["label"] = html_entity_decode($filas['nombre']);
			array_push($return_arr,$descripcion);
			$con++;
		}
		echo json_encode($return_arr);
	}
?>
		