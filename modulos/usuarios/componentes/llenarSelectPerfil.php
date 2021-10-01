<?php 
	include("../../perfiles/Perfil.class.php");
	$Operfil = new Perfil;
	$resultado=$Operfil->consultaGeneral("");
	
	if (isset($_POST['seleccionado'])) {
		$idselect=$_POST['seleccionado'];
	}else{
		$idselect=1;
	}
	while ($filas=mysqli_fetch_array($resultado)) { ?>
		<option value="<?php echo $filas['idperfil']; ?>"
        <?php
        	if($filas['idperfil']==$idselect){
				echo 'selected="selected"';
			}
		?>
        ><?php echo $filas['nombre']; ?></option>
	<?php
    }
?>