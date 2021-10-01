<?php 
	include("../../facturacion/Facturacion.class.php");
	$buscar=htmlentities($_GET['term']);
	$receptor=htmlentities($_GET['receptor']);
	$Ofacturacion = new Facturacion;
	$resultado=$Ofacturacion->consultaGeneral("WHERE (foliointerno LIKE '%$buscar%' OR receptor LIKE '%$buscar%') AND receptor='$receptor' AND tipo='I' AND estado='PENDIENTE' AND clasificacion='CREDITO' ORDER BY fecha DESC, foliointerno DESC LIMIT 20 ");
	$con=0;
	$return_arr = array();
	if(mysqli_num_rows($resultado) > 0){
		while($filas=mysqli_fetch_array($resultado)){
			$rfcReceptor= html_entity_decode($filas['rfcreceptor']);
			$fecha= html_entity_decode($filas['fecha']);
			$total= html_entity_decode($filas['montototal']);
			$nombreReceptor= html_entity_decode($filas['receptor']);
			$descripcion["id"] = html_entity_decode($filas['idfactura']);
			$descripcion["consulta"] = html_entity_decode($filas['foliointerno']);
			$descripcion["uuid"] = html_entity_decode($filas['foliofiscal']);
			$descripcion["moneda"] = html_entity_decode($filas['moneda']);
			$descripcion["montototal"] = html_entity_decode($filas['montototal']);
			$descripcion["montopagado"] = html_entity_decode($filas['montopagado']);
			$descripcion["saldoanterior"] = html_entity_decode($filas['montototal']-$filas['montopagado']);
			$descripcion["numparcialidad"] = html_entity_decode($filas['numparcialidad']);
			$descripcion["tipocambio"] = html_entity_decode($filas['tipocambio']);
			$descripcion["label"] = html_entity_decode($filas['foliointerno'])." ".$nombreReceptor." (".$rfcReceptor.") | ".$fecha."| $".number_format($total,2);
			array_push($return_arr,$descripcion);
			$con++;
		}
		echo json_encode($return_arr);
	}
?>
		