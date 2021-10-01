<?php 
	include("../../productos/Producto.class.php");
	$idproducto=htmlentities($_POST['idproducto']);
	$Oproducto = new Producto;
	$resultado=$Oproducto->consultaGeneral("WHERE idproducto='$idproducto'");
	$idalmacen=$_SESSION['idalmacen'];
	$resultado3=$Oproducto->consultaLibre("SELECT idlistaprecios FROM almacenes WHERE idalmacen = '$idalmacen' ");
	if(mysqli_num_rows($resultado3) > 0){
		$filas3=mysqli_fetch_array($resultado3);
		$precios=$filas3['idlistaprecios'];
		if ($precios==5){
			$precios=1;
		}else{
			$precios=1;
		}
	}else{
		$precios=1;
	}
	if ($precios==1){
		$select1='selected="selected"';
		$select2='';
		$select3='';
		$select4='';
	}else if ($precios==2){
		$select1='';
		$select2='selected="selected"';
		$select3='';
		$select4='';
	}else if ($precios=3){
		$select1='';
		$select2='';
		$select3='selected="selected"';
		$select4='';
	}else if ($precios==4){
		$select1='';
		$select2='';
		$select3='';
		$select4='selected="selected"';
	}else{
		$select1='selected="selected"';
		$select2='';
		$select3='';
		$select4='';
	}
	while ($filas=mysqli_fetch_array($resultado)) { ?>
		<option value="<?php echo $filas['preciopublico']; ?>">P.P $ <?php echo $filas['preciopublico']; ?></option>
        
        <option value="<?php echo $filas['precio1']; ?>" <?php echo $select1 ?>>P-1 $ <?php echo $filas['precio1']; ?></option>
        <option value="<?php echo $filas['precio2']; ?>" <?php echo $select2 ?>>P-2 $ <?php echo $filas['precio2']; ?></option>
        <option value="<?php echo $filas['precio3']; ?>" <?php echo $select3 ?>>P-3 $ <?php echo $filas['precio3']; ?></option>
        <option value="<?php echo $filas['precio4']; ?>" <?php echo $select4 ?>>P-4 $ <?php echo $filas['precio4']; ?></option>
	<?php
    }
?>