<?php 
	include("../../marcas/Marca.class.php");
	$Omarca = new Marca;
	$resultado=$Omarca->consultaGeneral(" WHERE estatus <> 'eliminado'");
	
	if (isset($_POST['seleccionado'])) {
		$idselect=$_POST['seleccionado'];
	}else{
		$idselect=1;
	}
	while ($filas=mysqli_fetch_array($resultado)) { ?>
		<option codigo="<?php echo $filas['nombre']; ?>" value="<?php echo $filas['idmarca']; ?>"
        <?php
        	if($filas['idmarca']==$idselect){
				echo 'selected="selected"';
			}
		?>
        ><?php echo $filas['nombre']; ?></option>
	<?php
    }
?>