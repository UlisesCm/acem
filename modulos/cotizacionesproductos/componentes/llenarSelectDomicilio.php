<?php 
	include("../../domicilios/Domicilio.class.php");
	$Odomicilio = new Domicilio;
	if (isset($_POST['idcliente'])) {
		$idcliente=$_POST['idcliente'];
	}
	
	$resultado=$Odomicilio->consultaGeneral(" WHERE idcliente = $idcliente AND estatus <> 'eliminado'");
	
	if (isset($_POST['condicion'])) {
		$idselect=$_POST['condicion'];
	}else{
		$idselect=1;
	}
	$contadordomicilios = 0;
	while ($filas=mysqli_fetch_array($resultado)) { $contadordomicilios = $contadordomicilios + 1?>
		<option value="<?php echo $filas['iddomicilio']; ?>"
        <?php
        	if($filas['iddomicilio']==$idselect){
				echo 'selected="selected"';
			}
		?>
        ><?php echo $filas['tipovialidad'] . " " . $filas['calle'] . " NO EXT. " . $filas['noexterior'] . " NO INT. " . $filas['nointerior'] . " COL. " . $filas['colonia']. " " . $filas['ciudad']. " " . $filas['estado'] . " CP. " . $filas['cp']; ?></option>
	<?php
    }
	if ($idcliente == "" || $idcliente == 0) {
		//se borro el cliente seleccionado cargar las dos opciones principales
	    echo '<option value="SELECCIONE DOMICILIO...">SELECCIONE DOMICILIO...</option>';
		echo '<option value="NUEVO">NUEVO</option>';
	}
	else{//SE SELECIONO CLIENTE AGREGAR OPCION NUEVO DEBAJO
		if($contadordomicilios==0){//EN EL CASO DE QUE N OCARGUE NINGUN DIMICILIO PERO SEA UN CLIENTE QUE YA ESTÉ DADO DE ALTA AGREGAR ESTA OPCIÓN APRA QUE PERMITA HACER EL CAMBIO A NUEVO Y DAR DE ALTA SU PRIMER DOMICILIO
			echo '<option value="SELECCIONE DOMICILIO...">SELECCIONE DOMICILIO...</option>';
		}
		echo '<option value="NUEVO">NUEVO</option>';
	}
?>