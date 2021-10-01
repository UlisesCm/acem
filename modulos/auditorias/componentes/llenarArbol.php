<?php 
	include("../../familias/Familia.class.php");
	$Ofamilia = new Familia;
	global $arrayFamilia;
	$arrayFamilia=array();
	if (isset($_POST["idfamiliaseleccionada"])){
		$idfamiliaseleccionada=htmlentities(trim($_POST['idfamiliaseleccionada']));
	}else{
		$idfamiliaseleccionada="";
	}
	
	function crearArbol($idfamilia, $descripcionHeredada, $idfamiliaseleccionada){
		global $arrayFamilia;
		$Ofamilia = new Familia;
		$resultado2=$Ofamilia->consultaGeneral("WHERE estatus <> 'eliminado'AND idfamiliamadre='$idfamilia'");
		while ($filas2=mysqli_fetch_array($resultado2)) { 
			$nombre=$filas2['nombre']; 
			$idfamilia=$filas2['idfamilia']; 
			$idfamiliamadre=$filas2['idfamiliamadre'];
			$mostrarendescripcion=$filas2['mostrarendescripcion'];
			$nombredescripcion=$filas2['nombredescripcion'];
			$prefijocodigo=$filas2['prefijocodigo'];
			$camposrequeridos=$filas2['camposrequeridos'];
			if ($mostrarendescripcion=="si"){
				$descripcion=$descripcionHeredada." ".$nombredescripcion;
			}else{
				$descripcion=$descripcionHeredada."";
			}
			if ($idfamiliaseleccionada==$idfamilia){
				$seleccionado="data-jstree='{ \"selected\" : true }'";
			}else{
				$seleccionado="";
			}
			if (!in_array($idfamilia, $arrayFamilia)) {
			echo "<ul>";
				echo "<li nombre='$nombre' idfamilia='$idfamilia' $seleccionado>";
				echo $nombre;
				crearArbol($idfamilia,$descripcion,$idfamiliaseleccionada);
				echo "</li>";
			echo "</ul>";
			}
			array_push($arrayFamilia,$idfamilia);
		}
	}
	
	$resultado=$Ofamilia->consultaGeneral("WHERE estatus <> 'eliminado' ORDER BY idfamiliamadre ASC");
	echo "<ul>";
	while ($filas=mysqli_fetch_array($resultado)) { 
		$nombre=$filas['nombre']; 
		$idfamilia=$filas['idfamilia']; 
		$idfamiliamadre=$filas['idfamiliamadre'];
		$mostrarendescripcion=$filas['mostrarendescripcion'];
		$nombredescripcion=$filas['nombredescripcion'];
		$prefijocodigo=$filas['prefijocodigo'];
		$camposrequeridos=$filas['camposrequeridos'];
		if ($mostrarendescripcion=="si"){
			$descripcion=$nombredescripcion;
		}else{
			$descripcion="";
		}
		if ($idfamiliaseleccionada==$idfamilia){
			$seleccionado="data-jstree='{ \"selected\" : true }'";
		}else{
			$seleccionado="";
		}
		if (!in_array($idfamilia, $arrayFamilia)) {
			echo "<li nombre='$nombre' idfamilia='$idfamilia' $seleccionado>";
			echo $nombre;
			crearArbol($idfamilia, $descripcion, $idfamiliaseleccionada);
			echo "</li>";
		}
		array_push($arrayFamilia,$idfamilia);
    }
	echo "</ul>";
?>