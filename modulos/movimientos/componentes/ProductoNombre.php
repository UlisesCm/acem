<?php 
	include("../../productos/Producto.class.php");
	$buscar=htmlentities($_POST['termino']);
	$Oproducto = new Producto;
	$idalmacen=$_SESSION['idalmacen'];
	$resultado=$Oproducto->consultaGeneral("WHERE nombre='$buscar' AND estatus <> 'eliminado'");
	$descripcion = new stdClass();
	$nombretalla="";
	$nombreunidad="";
	if(mysqli_num_rows($resultado) > 0){
		$filas=mysqli_fetch_array($resultado);
		$idproducto=$filas['idproducto'];
		$descripcion->id= $filas['idproducto'];
		$descripcion->codigo= $filas['codigo'];
		$iva=$filas['iva'];
		$ieps=$filas['ieps'];
		$descripcion->tasaiva= $iva;
		$descripcion->tasaieps= $ieps;
		
		$idunidad=$filas['idunidad'];
		$resultado2=$Oproducto->consultaLibre("SELECT nombre FROM unidades WHERE idunidad = '$idunidad' ");
		if(mysqli_num_rows($resultado2) > 0){
			$filas2=mysqli_fetch_array($resultado2);
			$nombreunidad=$filas2['nombre'];
		}
		$descripcion->unidad= $nombreunidad;
		
		$idtalla=$filas['idtalla'];
		$resultado3=$Oproducto->consultaLibre("SELECT nombre FROM tallas WHERE idtalla = '$idtalla' ");
		if(mysqli_num_rows($resultado3) > 0){
			$filas3=mysqli_fetch_array($resultado3);
			$nombretalla=$filas3['nombre'];
			if ($nombretalla!="NO APLICA"){
				$nombretalla=" ($nombretalla)";
			}else{
				$nombretalla="";
			}
		}
		$descripcion->talla= $nombretalla;
		$descripcion->nombre= $filas['codigo']." - ".$filas['nombre'].$nombretalla;
		
		$resultado3=$Oproducto->consultaLibre("SELECT idlistaprecios FROM almacenes WHERE idalmacen = '$idalmacen' ");
		if(mysqli_num_rows($resultado3) > 0){
			$filas3=mysqli_fetch_array($resultado3);
			$precios=$filas3['idlistaprecios'];
			if ($precios==5){
				$precios=1;
			}
		}else{
			$precios=1;
		}
		$descripcion->precio=$filas["precio$precios"];
		$precioventa=$filas["precio$precios"];
		if ($iva==999){
			$iva=0;
			$iva=($iva/100)+1; //Quitar el + 1 en caso de sumar el iva, dejar el +1 en caso de extraer el iva
		}else{
			$iva=($iva/100)+1; //Quitar el + 1 en caso de sumar el iva, dejar el +1 en caso de extraer el iva
		}
		
		$iva=$precioventa-($precioventa/$iva);
		if ($iva!=0){
			$precioventa=$precioventa/$iva;
		}
		
		$ieps=($ieps/100); 
		$ieps=$precioventa*$ieps;
		$precioventa=$precioventa+$ieps;
		
		
		$descripcion->iva= $iva;
		$descripcion->ieps= $ieps;
		
		
	}
	echo json_encode($descripcion);
?>
		