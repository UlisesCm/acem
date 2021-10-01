<?php 
	include("../../proveedores/Proveedor.class.php");
	$Oproveedor = new Proveedor;
	$resultado=$Oproveedor->consultaGeneral("ORDER BY nombre ASC");
	
	
	if (isset($_POST['seleccionado'])) {
		$idselect=$_POST['seleccionado'];
		$idselect=1;
	}else{
		$idselect=1;
	}
	$idselect=$_SESSION['idproveedor'];
	while ($filas=mysqli_fetch_array($resultado)) { ?>
		<option value="<?php echo $filas['idproveedor']; ?>"
        <?php
        	if($filas['idproveedor']==$idselect){
				echo 'selected="selected"';
			}
		?>
        ><?php echo $filas['nombre']; ?></option>
	<?php
    }
	if($idselect==1){
		echo '<option value="TODOS" selected="selected">TODOS</option>';
	}else{
		echo '<option value="TODOS" selected="selected">TODOS</option>';
	}
?>