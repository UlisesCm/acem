<?php 
	include("../../categorias/Categoria.class.php");
	$Ocategoria = new Categoria;
	$resultado=$Ocategoria->consultaGeneral(" WHERE estatus <> 'eliminado'");
	
	if (isset($_POST['seleccionado'])) {
		$idselect=$_POST['seleccionado'];
	}else{
		$idselect=1;
	}
	while ($filas=mysqli_fetch_array($resultado)) { ?>
		<option value="<?php echo $filas['idcategoria']; ?>"
        <?php
        	if($filas['idcategoria']==$idselect){
				echo 'selected="selected"';
			}
		?>
        ><?php echo $filas['nombre']; ?></option>
	<?php
    }
?>