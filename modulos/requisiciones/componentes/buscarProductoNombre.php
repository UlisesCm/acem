<?php 
	include("../../productos/Producto.class.php");
	$buscar=htmlentities($_GET['term']);
	$idproveedor=htmlentities($_GET['idproveedor']);
	$Oproducto = new Producto;
	$resultado=$Oproducto->consultaLibre("SELECT
	productos.idproducto,
	productos.codigo,
	productos.nombre,
	productos.pesoteorico,
	productos.pesoreal,
	productos.estatus,
	productos.costo,
	productos.clasificacion,
	unidades.nombre AS nombreunidad
	FROM productos
	INNER JOIN productosproveedores ON productosproveedores.idproducto=productos.idproducto
	INNER JOIN unidades ON unidades.idunidad=productos.idunidad
	WHERE productos.nombre LIKE '%$buscar%' AND productos.estatus <> 'eliminado' AND productosproveedores.idproveedor='$idproveedor' LIMIT 0, 19");
	$con=0;
	$return_arr = array();
	if(mysqli_num_rows($resultado) > 0){
		while($filas=mysqli_fetch_array($resultado)){
			$pesoteorico=html_entity_decode($filas['pesoteorico']);
			if ($pesoteorico==""){
				$pesoteorico=0;
			}
			
			$pesoreal=html_entity_decode($filas['pesoreal']);
			if ($pesoreal==""){
				$pesoreal=0;
			}
			$datosStocks=$Oproducto->calcularStocks($filas['idproducto']);
			$existencias=$Oproducto->obtenerExistencias($filas['idproducto']);
			$descripcion["stockminimo"] = $datosStocks[0];
			$descripcion["stockmaximo"] = $datosStocks[1];
			$descripcion["existencias"] = number_format($existencias,2);
			$descripcion["id"] = html_entity_decode($filas['idproducto']);
			$descripcion["costo"] = html_entity_decode($filas['costo']);;
			$descripcion["unidad"] = html_entity_decode($filas['nombreunidad']);
			$descripcion["codigo"] = html_entity_decode($filas['codigo']);
			$descripcion["idproducto"] = html_entity_decode($filas['idproducto']);
			$descripcion["consulta"] = html_entity_decode($filas['nombre']);
			$descripcion["label"] = html_entity_decode($filas['nombre']);
			$descripcion["pesoteorico"] = $pesoteorico;
			$descripcion["pesoreal"] = $pesoreal;
			$descripcion["clasificacion"] = html_entity_decode($filas['clasificacion']);
			array_push($return_arr,$descripcion);
			$con++;
		}
		echo json_encode($return_arr);
	}
?>