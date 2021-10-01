<?php 
	include("../../productos/Producto.class.php");
	$buscar=htmlentities($_GET['term']);
	$Oproducto = new Producto;
	$resultado=$Oproducto->consultaGeneral("WHERE codigo='$buscar' AND estatus <> 'eliminado'");
	$con=0;
	$return_arr = array();
	if(mysqli_num_rows($resultado) > 0){
		while($filas=mysqli_fetch_array($resultado)){
			$descripcion["id"] = html_entity_decode($filas['idproducto']);
			$descripcion["consulta"] = html_entity_decode($filas['nombre']);
			$descripcion["label"] = html_entity_decode($filas['nombre']);
			array_push($return_arr,$descripcion);
			$con++;
		}
		echo json_encode($return_arr);
	}
?>
		