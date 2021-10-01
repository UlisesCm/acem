<?php 
	include("../../domicilios/Domicilio.class.php");
	$buscar=htmlentities($_GET['term']);
	$Odomicilio = new Domicilio;
	$resultado=$Odomicilio->consultaGeneral("WHERE calle LIKE '%$buscar%'  AND estatus <> 'eliminado' ");
	$con=0;
	$return_arr = array();
	if(mysqli_num_rows($resultado) > 0){
		while($filas=mysqli_fetch_array($resultado)){
			$dato1=html_entity_decode($filas['calle']);
			$dato2=html_entity_decode($filas['noexterior']);
			$dato3=html_entity_decode($filas['nointerior']);
			if($dato3!=""){
				$dato3=", Int. $dato3";
			}
			$dato4=html_entity_decode($filas['colonia']);
			$dato5=html_entity_decode($filas['cp']);
			$dato6=html_entity_decode($filas['ciudad']);
			$dato7=html_entity_decode($filas['estado']);
			$descripcion["id"] = html_entity_decode($dato1);
			$descripcion["consulta"] = "<b>".$dato1."</b> No.".$dato2.$dato3. ", Col. ".$dato4.", C.P. ".$dato5. ", ".$dato6. ", ".$dato7;
			$descripcion["label"] = html_entity_decode($dato1); //Dato de referencia
			array_push($return_arr,$descripcion);
			$con++;
		}
		echo json_encode($return_arr);
	}
?>
		