<?php 
	session_start();
	$tipoempresa=$_SESSION["tipoempresa"];
	include("../../productos$tipoempresa/Producto.class.php");
	$buscar=htmlentities($_GET['term']);
	$Oproducto = new Producto;
	$resultado=$Oproducto->consultaGeneral("WHERE codigo LIKE '%$buscar%' AND estatus <> 'eliminado' LIMIT 0, 19");
	$con=0;
	$return_arr = array();
	if(mysqli_num_rows($resultado) > 0){
		while($filas=mysqli_fetch_array($resultado)){
		
			$descripcion["id"] = html_entity_decode($filas['idproducto']);
			$descripcion["consulta"] = html_entity_decode($filas['codigo']);
			$descripcion["label"] = html_entity_decode($filas['codigo']);
			array_push($return_arr,$descripcion);
			$con++;
		}
		echo json_encode($return_arr);
	}
?>
		