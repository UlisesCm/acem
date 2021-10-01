<?php 
	include("../../vehiculos/Vehiculo.class.php");
	$Ovehiculo = new Vehiculo;
	include("../../asignacionvehicular/Asignacionvehicular.class.php");
	$Oasignacion = new Asignacionvehicular;
	
	$resultado=$Ovehiculo->consultaGeneral(" WHERE estatus <> 'eliminado'");
	
	if (isset($_POST['seleccionado'])) {
		$idselect=$_POST['seleccionado'];
	}else{
		$idselect=1;
	}
	while ($filas=mysqli_fetch_array($resultado)) { 
	
	  $idvehiculo = $filas['idvehiculo'];
	  //revisar si el empleado tiene un vehiculo asignado
	  $resultado2=$Oasignacion->consultaGeneral(" WHERE idvehiculo = '$idvehiculo'");
	  if($filas2=mysqli_fetch_array($resultado2)) { 
	    //ya se encuentra asignado
	  }
	  else{
		  //no tien asignacion agregarlo al combo
			?>
			<option value="<?php echo $filas['idvehiculo']; ?>"
			<?php
				if($filas['idvehiculo']==$idselect){
					echo 'selected="selected"';
				}
			?>
			><?php echo $filas['tipo']." ".$filas['marca']." ".$filas['submarca']." ".$filas['color']." PLACA: ".$filas['placa']; ?></option>
			<?php
	  }
    }
?>