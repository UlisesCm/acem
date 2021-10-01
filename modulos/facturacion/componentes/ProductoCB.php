<?php 
	session_start();
	$tipoempresa=$_SESSION["tipoempresa"];
	include("../../productos$tipoempresa/Producto.class.php");
	$buscar=htmlentities($_POST['termino']);
	$Oproducto = new Producto;
	$idalmacen=$_SESSION['idalmacen'];
	$resultado=$Oproducto->consultaGeneral("WHERE codigo='$buscar' AND estatus <> 'eliminado'");
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
		$descuento=$filas['descuento'];
		$descripcion->descuento= $descuento;
		$descripcion->tasaiva= $iva;
		$descripcion->tasaieps= $ieps;
		
		$idunidad=$filas['idunidad'];
		$resultado2=$Oproducto->consultaLibre("SELECT nombre, codigo, simbolo FROM unidades WHERE idunidad = '$idunidad' ");
		if(mysqli_num_rows($resultado2) > 0){
			$filas2=mysqli_fetch_array($resultado2);
			$nombreunidad=$filas2['nombre'];
			$codigounidad=$filas2['codigo']; // V3.3 CFDI
			$simbolounidad=$filas2['simbolo']; // V3.3 CFDI
		}
		$descripcion->unidad= $nombreunidad; 
		$descripcion->codigounidad= $codigounidad; // V3.3 CFDI 
		$descripcion->simbolounidad= $simbolounidad; // V3.3 CFDI
		
		////////// V3.3 CFDI
		$idcategoria=$filas['idcategoria']; 
		$resultado4=$Oproducto->consultaLibre("SELECT nombre, codigo FROM categorias WHERE idcategoria = '$idcategoria' ");
		if(mysqli_num_rows($resultado4) > 0){
			$filas4=mysqli_fetch_array($resultado4);
			$codigocategoria=$filas4['codigo'];
		}
		$descripcion->codigocategoria= $codigocategoria;
		///////// FIN V3.3 CFD
		
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
		
		// SOLO PALICA PARA FACTURACION: OBTTIENE DIRECTAMENTE EL PRECIO PUBLICO///////////////////////////////////////////////////////////
		
		/*
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
		*/
		
		
		$descripcion->precio=$filas["preciopublico"];
		
		
		/********************************/
		//$precioventa=$filas["precio$precios"];
		$precioventa=$filas["preciopublico"];
		/********************************/
		
		
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
		