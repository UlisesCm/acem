<?php 
	include("../../sucursales/Sucursal.class.php");
	$Osucursal = new Sucursal;
	$resultado=$Osucursal->consultaGeneral("");
	
	
	if (isset($_POST['seleccionado'])) {
		$idselect=$_POST['seleccionado'];
	}else{
		$idselect=1;
	}
	while ($filas=mysqli_fetch_array($resultado)) { ?>
		<option value="<?php echo $filas['idsucursal']; ?>"
        <?php
        	if($filas['idsucursal']==$idselect){
				echo 'selected="selected"';
			}
		?>
        ><?php echo $filas['nombre']; ?></option>
	<?php
    } ?>
		<option value="x"
        <?php
        	if($idselect=="x"){
				echo 'selected="selected"';
			}
		?>
        >TODOS</option>