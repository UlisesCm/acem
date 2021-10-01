<?php 
	include("../../plantillasmensajes/Plantillamensaje.class.php");
	$Oplantillamensaje = new Plantillamensaje;
	$resultado=$Oplantillamensaje->consultaGeneral("");
	
	if (isset($_POST['seleccionado'])) {
		$idselect=$_POST['seleccionado'];
	}else{
		$idselect=1;
	}
	while ($filas=mysqli_fetch_array($resultado)) { ?>
		<option value="<?php echo $filas['idplantillamensaje']; ?>"
        <?php
        	if($filas['idplantillamensaje']==$idselect){
				echo 'selected="selected"';
			}
		?>
        ><?php echo $filas['titulo']; ?></option>
	<?php
    }
?>