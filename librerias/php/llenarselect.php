<?php 

//Llenar un campo Select 
$ruta= $_REQUEST['ruta'];
$campos= $_REQUEST['campos'];
$condicion= $_REQUEST['condicion'];

	include($ruta);
	$valores= explode("@",$campos);
	$id=$valores [0];
	$campo=$valores [1];
	$Ousuario = new Usuario;
	$resultado=$Ousuario->consultaGeneral($condicion);
	while ($filas=mysqli_fetch_array($resultado)) { ?>
		<option value="<?php echo $filas["$id"]; ?>"><?php echo $filas["$campo"]; ?></option>
	<?php
    }

	echo "<option value='1'>hojoho</option>";
?>