<?php
	include("../../ordenescompras/Compra.class.php");
	$Ocompra = new Compra;
	$idsucursal=$_SESSION['idsucursal'];
	$resultado=$Ocompra->consultaLibre("SELECT
										compras.idcompra,
										compras.idproveedor,
										compras.folio,
										compras.serie,
										proveedores.nombre AS nombreproveedor
										FROM compras
										INNER JOIN proveedores ON proveedores.idproveedor=compras.idproveedor
										WHERE compras.estado ='Autorizada para recepcion' AND compras.idsucursal='$idsucursal'");
	
	if (isset($_POST['condicion'])) {
		$idselect=$_POST['condicion'];
	}else{
		$idselect=1;
	}
	while ($filas=mysqli_fetch_array($resultado)) { ?>
		<option value="<?php echo $filas['idcompra']; ?>"
        <?php
        	if($filas['idcompra']==$idselect){
				echo 'selected="selected"';
			}
		?>
        ><?php echo $filas['serie']."-".$filas['folio']." (".$filas['nombreproveedor'].")"; ?></option>
	<?php
    }
	if(mysqli_num_rows($resultado)==0){
		echo "<option value=''>No hay ordenes autorizadas</option>";
	}
?>