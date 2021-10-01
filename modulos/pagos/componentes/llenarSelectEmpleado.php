<?php 
	include("../../empleados/Empleado.class.php");
	$Oempleado = new Empleado;
	include("../../asignacionvehicular/Asignacionvehicular.class.php");
	$Oasignacion = new Asignacionvehicular;
	
	
	$resultado=$Oempleado->consultaGeneral(" WHERE estatus <> 'eliminado'");//AND (puesto ='CHOFER')
	
	if (isset($_POST['seleccionado'])) {
		$idselect=$_POST['seleccionado'];
	}else{
		$idselect=1;
	}
	while ($filas=mysqli_fetch_array($resultado)) { 
	
	  $idempleado = $filas['idempleado'];
	  //revisar si el empleado tiene un vehiculo asignado
	  $resultado2=$Oasignacion->consultaGeneral(" WHERE idempleado = '$idempleado'");
	  if($filas2=mysqli_fetch_array($resultado2)) { 
	    //ya se encuentra asignado
	  }
	  else{
		  //no tien asignacion agregarlo al combo
			?>
			<option value="<?php echo $filas['idempleado']; ?>"
			<?php
				if($filas['idempleado']==$idselect){
					echo 'selected="selected"';
				}
			?>
			><?php echo $filas['nombre']; ?></option>
		<?php
	  }//fin else no tiene asignacion
    }
?>