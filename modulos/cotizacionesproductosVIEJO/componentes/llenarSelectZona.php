<?php 
	include("../../zonas/Zona.class.php");
	$Ozona = new Zona;
	$resultado=$Ozona->consultaGeneral("  WHERE estatus <> 'eliminado'");
	
	if (isset($_POST['seleccionado'])) {
		$idselect=$_POST['seleccionado'];
	}else{
		$idselect=1;
	}
	while ($filas=mysqli_fetch_array($resultado)) { ?>
		<option value="<?php echo $filas['idzona']; ?>"
        <?php
        	if($filas['idzona']==$idselect){
				echo 'selected="selected"';
			}
		?>
        ><?php echo $filas['nombre']; ?></option>
	<?php
    }
?>
