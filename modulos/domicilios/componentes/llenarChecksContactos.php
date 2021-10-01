<?php 
	include("../Domicilio.class.php");
	$Odomicilio= new Domicilio;
	if (isset($_POST['idcliente'])) {
		$idcliente=$_POST['idcliente'];
		
	}else{
		$idcliente=0;
	}
	if (isset($_POST['iddomicilio'])) {
		$iddomicilio=$_POST['iddomicilio'];
		
	}else{
		$iddomicilio=0;
	}
	$resultado=$Odomicilio->consultaLibre("SELECT * FROM contactos WHERE idcliente='$idcliente'");
	
	$con = 0;
	if ($idcliente == "") {?>
	<div>
		<p> No se encontro contactos</p>
	</div>
		 <?php
	}
	while ($filas=mysqli_fetch_array($resultado)) { ?>
        
	    <div class="col-sm-12">
			<div >
			<label>
				<input id="contacto<?php echo $con?>" type="checkbox" name="contactos[]"  value="<?php echo $filas['idcontacto']?>" <?php echo $Odomicilio->comprobarDomicilioContacto($iddomicilio,$filas['idcontacto'])?>>
               	<?php 
			   	echo $filas['nombrecontacto']." (".$filas['departamento'].")";
			   	?>
           </label>
			</div>
           
        </div>
	<?php
	 $con++;
    }
?>