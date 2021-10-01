<?php 
	include("../../almacenes/Almacen.class.php");
	$Oalmacen = new Almacen;
	$resultado=$Oalmacen->consultaGeneral("");
	$idselect=$_SESSION['idalmacen'];
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
		<option value="">TODOS</option>