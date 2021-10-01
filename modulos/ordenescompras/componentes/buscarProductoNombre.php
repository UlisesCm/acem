<?php 
	include("../../productos/Producto.class.php");
	include("..//Compra.class.php");
	$buscar=htmlentities($_GET['term']);
	
	if (isset($_POST["parametrocotizacion"])){
	$parametrocotizacion=$_POST["parametrocotizacion"];
		}else{
	$parametrocotizacion="precio";
	}
	
	if (isset($_GET["idproveedor"])){
		$idproveedor=$_GET["idproveedor"];
		$consulta="SELECT
				productos.idproducto,
				productos.codigo,
				productos.nombre,
				productos.estatus,
				productos.pesoteorico,
				productos.pesoreal,
				unidades.nombre AS nombreunidad,
				productosproveedores.idproveedor
				FROM productos
				INNER JOIN unidades ON unidades.idunidad=productos.idunidad
				INNER JOIN productosproveedores ON productosproveedores.idproducto = productos.idproducto
				WHERE productos.nombre LIKE '%$buscar%' AND productos.estatus <> 'eliminado' AND productosproveedores.idproveedor='$idproveedor'  LIMIT 0, 19";;
	}else{
		$consulta="SELECT
				productos.idproducto,
				productos.codigo,
				productos.nombre,
				productos.estatus,
				productos.pesoteorico,
				productos.pesoreal,
				unidades.nombre AS nombreunidad
				FROM productos
				INNER JOIN unidades ON unidades.idunidad=productos.idunidad
				WHERE productos.nombre LIKE '%$buscar%' AND productos.estatus <> 'eliminado' LIMIT 0, 19";
	}		

	$Oproducto = new Producto;
	$Ocompra= new Compra;
	$resultado=$Oproducto->consultaLibre($consulta);
	$con=0;
	$return_arr = array();
	if(mysqli_num_rows($resultado) > 0){
		while($filas=mysqli_fetch_array($resultado)){
			
			$datosProveedor=$Ocompra->obtenerDatosProveedor($filas['idproducto'],$parametrocotizacion);
			$descripcion["idproveedor"] = $datosProveedor[0];
			$descripcion["nombreproveedor"] = $datosProveedor[1];
			$descripcion["precio1"] = $datosProveedor[2];
			$descripcion["id"] = html_entity_decode($filas['idproducto']);
			$descripcion["costo"] = 0;
			$descripcion["unidad"] = html_entity_decode($filas['nombreunidad']);
			$descripcion["codigo"] = html_entity_decode($filas['codigo']);
			$descripcion["idproducto"] = html_entity_decode($filas['idproducto']);
			$descripcion["consulta"] = html_entity_decode($filas['nombre']);
			$descripcion["label"] = html_entity_decode($filas['nombre']);
			$descripcion["pesoteorico"] = html_entity_decode($filas['pesoteorico']);
			$descripcion["pesoreal"] = html_entity_decode($filas['pesoreal']);
			array_push($return_arr,$descripcion);
			$con++;
		}
		echo json_encode($return_arr);
	}
?>
<?php 
	/*include("../../productos/Producto.class.php");
	$buscar=htmlentities($_GET['term']);
	$Oproducto = new Producto;
	$resultado=$Oproducto->consultaLibre("SELECT
	presentaciones.idpresentacion,
	presentaciones.costo,
	presentaciones.contenidoneto,
	productos.nombre AS nombreproducto,
	productos.estatus,
	unidades.nombre AS nombreunidad
	FROM presentaciones
	INNER JOIN productos ON productos.idproducto=presentaciones.idproducto
	INNER JOIN unidades ON unidades.idunidad=presentaciones.idunidad
	WHERE nombreproducto LIKE '%$buscar%' AND productos.estatus <> 'eliminado' LIMIT 0, 19");
	$con=0;
	$return_arr = array();
	if(mysqli_num_rows($resultado) > 0){
		while($filas=mysqli_fetch_array($resultado)){
			$nombrePresentacion=html_entity_decode($filas['nombreproducto'])." ".html_entity_decode($filas['presentacion']);
			$descripcion["id"] = html_entity_decode($filas['idpresentacion']);
			$descripcion["costo"] = html_entity_decode($filas['costo']);
			$descripcion["consulta"] = $nombrePresentacion;
			$descripcion["label"] = $nombrePresentacion;
			array_push($return_arr,$descripcion);
			$con++;
		}
		echo json_encode($return_arr);
	}*/
?>	