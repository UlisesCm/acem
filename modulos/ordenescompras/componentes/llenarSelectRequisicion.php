<?php 
	include("../../requisiciones/Requisicion.class.php");
	$Orequisicion = new Requisicion;
	
	if (isset($_POST['idsucursal'])) {
		$idsucursal=$_POST['idsucursal'];
	}else{
		$idsucursal="TODAS";
	}
	
	if (isset($_POST['idproveedor'])) {
		$idproveedor=$_POST['idproveedor'];
	}else{
		$idproveedor="TODOS";
	}
	
	if (isset($_POST['listaRequisiciones'])) {
		$listaRequisiciones=$_POST['listaRequisiciones'];
	}else{
		$listaRequisiciones="";
	}
	
	$consultaRequisiciones="";
	if ($listaRequisiciones!=""){
		$consultaRequisiciones=" AND requisiciones.idrequisicion NOT IN ($listaRequisiciones)";
	}
	$consultaSucursales="";
	if ($idsucursal!="TODAS"){
		$consultaSucursales="AND requisiciones.idsucursal='$idsucursal'";
	}
	
	$consultaProveedores="";
	if ($idproveedor!="TODOS"){
		$consultaProveedores="AND requisiciones.idproveedor='$idproveedor'";
	}
	 
	$resultado=$Orequisicion->consultaGeneral(" WHERE requisiciones.estado = 'pendiente' $consultaSucursales $consultaProveedores $consultaRequisiciones");
	
	if (isset($_POST['seleccionado'])) {
		$idselect=$_POST['seleccionado'];
	}else{
		$idselect=1;
	}
	while ($filas=mysqli_fetch_array($resultado)) { ?>
		<option prov="<?php echo $filas['idproveedor'];?>" value="<?php echo $filas['idrequisicion']; ?>"
        <?php
        	if($filas['idrequisicion']==$idselect){
				echo 'selected="selected"';
			}
		?>
        ><?php echo $filas['nombresucursales']." ".$filas['serie']."-".$filas['folio']." (".$filas['nombreproveedor'].") - ".$filas["fecha"]; ?></option>
	<?php
    }
?>