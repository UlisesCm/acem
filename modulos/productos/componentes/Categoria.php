<?php 
	include("../../categorias/Categoria.class.php");
	$buscar=htmlentities($_POST['termino']);
	$Ocategoria = new Categoria;
	$resultado=$Ocategoria->consultaGeneral("WHERE nombre ='$buscar'");
	$descripcion = new stdClass();
	if(mysqli_num_rows($resultado) > 0){
		$filas=mysqli_fetch_array($resultado);
		$descripcion->id= $filas['idcategoria'];
	}
	echo json_encode($descripcion);
?>
		