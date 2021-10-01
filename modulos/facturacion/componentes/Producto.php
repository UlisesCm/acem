<?php 
	session_start();
	include("../../productos/Producto.class.php");
	$buscar=htmlentities($_POST['termino']);
	$Oproducto = new Producto;
	$resultado=$Oproducto->consultaGeneral("WHERE idproducto='$buscar' AND estatus <> 'eliminado'");
	$descripcion = new stdClass();
	$nombretalla="";
	$nombreunidad="";
	$simbolounidad="";
	$codigounidad="";
	$codigocategoria="";
	if(mysqli_num_rows($resultado) > 0){
		$filas=mysqli_fetch_array($resultado);
		$idproducto=$filas['idproducto'];
		$descripcion->id= $filas['idproducto'];
		$descripcion->codigo= $filas['codigo'];
		
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
		
	
		
		$descripcion->nombre= $filas['codigo']." - ".$filas['nombre'];
		
		$descripcion->precio=0;
		
		
		/********************************/
		//$precioventa=$filas["precio$precios"];
		$precioventa=0;
		/********************************/
		//Obtener tasas de la base de datos de impuestos
		$resultado5=$Oproducto->consultaLibre("SELECT valor FROM impuestos WHERE idmodeloimpuesto='".$filas['idmodeloimpuestos']."' AND clavesat='002' AND tipo='TRASLADADO'");
		if(mysqli_num_rows($resultado5) > 0){
			$filas5=mysqli_fetch_array($resultado5);
			$iva=$filas5['valor'];
		}else{
			$iva=999;
		}
		$ieps=0;
		
		if ($iva==999){
			$iva=0;
			$iva=$iva+1; //Quitar el + 1 en caso de sumar el iva, dejar el +1 en caso de extraer el iva
		}else{
			$iva=$iva+1; //Quitar el + 1 en caso de sumar el iva, dejar el +1 en caso de extraer el iva
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