<?php 
	include("../../giroscomerciales/Girocomercial.class.php");
	$Ogirocomercial = new Girocomercial;
	$resultado=$Ogirocomercial->consultaGeneral(" WHERE estatus <> 'eliminado'");
	
	if (isset($_POST['seleccionado'])) {
		$idselect=$_POST['seleccionado'];
	}else{
		$idselect=1;
	}
	while ($filas=mysqli_fetch_array($resultado)) { ?>
		<option value="<?php echo $filas['idgirocomercial']; ?>"
        <?php
        	if($filas['idgirocomercial']==$idselect){
				echo 'selected="selected"';
			}
		?>
        ><?php echo $filas['nombre']; ?></option>
	<?php
    }
?>