<?php 
	include("../../usuarios/Usuario.class.php");
	$Ousuario = new Usuario;
	$resultado=$Ousuario->consultaGeneral("");
	
	if (isset($_POST['seleccionado'])) {
		$idselect=$_POST['seleccionado'];
	}else{
		$idselect=1;
	}
	while ($filas=mysqli_fetch_array($resultado)) { ?>
		<option value="<?php echo $filas['idusuario']; ?>"
        <?php
        	if($filas['idusuario']==$idselect){
				echo 'selected="selected"';
			}
		?>
        ><?php echo $filas['nombre']; ?></option>
	<?php
    }
?>