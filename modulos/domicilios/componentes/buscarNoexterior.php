<?php 
	include("../../domicilios/Domicilio.class.php");
	$buscar=htmlentities($_GET['term']);
	$Odomicilio = new Domicilio;
	$resultado=$Odomicilio->consultaGeneral("WHERE noexterior LIKE '%$buscar%'  AND estatus <> 'eliminado' ");
	$con=0;
	$return_arr = array();
	if(mysqli_num_rows($resultado) > 0){
		while($filas=mysqli_fetch_array($resultado)){
			$descripcion["id"] = html_entity_decode($filas['noexterior']);
			$descripcion["consulta"] = html_entity_decode($filas['noexterior']);
			$descripcion["label"] = html_entity_decode($filas['noexterior']);
			array_push($return_arr,$descripcion);
			$con++;
		}
		echo json_encode($return_arr);
	}
?>
		