<?php 
	include("../../productos/Producto.class.php");
	$buscar=htmlentities($_GET['term']);
	//armar LIKE con cada palabra en el texto de busqueda
	$lista=trim($buscar)." ";//AGREGAMOS UN ESPACIO AL FINAL APRA QUE TOME EN CUENTA LA ULTIMA PALABRA ESCRITA EN AL CONSULTA
	//$lista= substr($lista, 0, -3);
	$lista=explode(" ",$lista);
	$con=0;
	$LIKE="";
	while($con<count($lista)){
			$LIKE=$LIKE . "nombre LIKE '%$lista[$con]%' AND ";
		$con++;
	}
	//$LIKE = substr($lista, 0, -3);//le quitamos el ultimo AND
	
	
	$Oproducto = new Producto;
	$resultado=$Oproducto->consultaGeneral("WHERE $LIKE estatus <> 'eliminado' LIMIT 0, 19");
	$con=0;
	$return_arr = array();
	if(mysqli_num_rows($resultado) > 0){
		while($filas=mysqli_fetch_array($resultado)){
		    $Arreglo = $Oproducto->obtenerPrecios($filas['idproducto']);
			$descripcion["id"] = html_entity_decode($filas['idproducto']);
			$descripcion["precios"] = $Arreglo[0];
			$descripcion["IDListas"] = $Arreglo[1];
			$descripcion["IDvaloresimpuestos"] = $Arreglo[2];
			$descripcion["costopromedio"] = $Arreglo[3];
			$descripcion["pesoteorico"] = $Arreglo[4];
			$descripcion["claveproducto"] = $Arreglo[5];
			$descripcion["consulta"] = html_entity_decode($filas['nombre']);
			$descripcion["label"] = html_entity_decode($filas['nombre']);
			array_push($return_arr,$descripcion);
			$con++;
		}
		echo json_encode($return_arr);
	}
?>
		