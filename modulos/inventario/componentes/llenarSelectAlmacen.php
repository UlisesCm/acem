<?php 
	include("../../almacenes/Almacen.class.php");
	$Oalmacen = new Almacen;
	$resultado=$Oalmacen->consultaGeneral("");
	
	if (isset($_POST['seleccionado'])) {
		$idselect=$_POST['seleccionado'];
	}else{
		$idselect=1;
	}
	while ($filas=mysqli_fetch_array($resultado)) { ?>
		<option value="<?php echo $filas['idalmacen']; ?>"
        <?php
        	if($filas['idalmacen']==$idselect){
				echo 'selected="selected"';
			}
		?>
        ><?php echo $filas['nombre']; ?></option>
	<?php
    }
?>