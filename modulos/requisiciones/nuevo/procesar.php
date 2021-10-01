<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/validaciones.php");
require('../Movimiento.class.php');
$Omovimiento=new Movimiento;
$mensaje="";
$validacion=true;

if (isset($_POST['concepto'])){
	$concepto=htmlentities(trim($_POST['concepto']));
	$concepto=trim($concepto);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo concepto no es correcto</p>";
}

if (isset($_POST['numerocomprobante'])){
	$numerocomprobante=htmlentities(trim($_POST['numerocomprobante']));
	$numerocomprobante=trim($numerocomprobante);
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo numerocomprobante no es correcto</p>";
}

if($validacion){
	$resultado=$Omovimiento->consultaGeneral(" WHERE numerocomprobante='$numerocomprobante' and tipo='salida'");
	if(mysqli_num_rows($resultado) > 0){
		$filas=mysqli_fetch_array($resultado);
		$idcliente= $filas['idcliente'];
		$idempleado=$filas['idempleado'];
		$fechaNfechamovimiento=date_create($filas['fechamovimiento']);
		$nuevaFecha= date_format($fechaNfechamovimiento, 'd/m/Y');
		$idalmacen=$filas['idalmacen'];
		$idalmacendestino=$filas['idalmacendestino'];
		$estado=$filas['estado'];
		$comentarios=$filas['comentarios'];
		$nombrecliente=$Omovimiento->obtenerCampo("clientes","nombre","idcliente",$idcliente);
		$nombreempleado=$Omovimiento->obtenerCampo("empleados","nombre","idempleado",$idempleado);
		$nombrealmacen=$Omovimiento->obtenerCampo("almacenes","nombre","idalmacen",$idalmacen);
		$nombrealmacendestino="";
		if($idalmacendestino!=0){
			$nombrealmacendestino=$Omovimiento->obtenerCampo("almacenes","nombre","idalmacen",$idalmacendestino);
		}
		if ($estado=="abierto"){
			$colorTipo="bg-green";
			$colorIcon="text-green";
		}else{
			$colorTipo="bg-red";
			$colorIcon="text-red";
		}
		?>
    <div class="box box-solid">
    	<div class="box-header with-border">
    		<i class="fa fa-book <?php echo $colorIcon; ?>"></i>
    		<h3 class="box-title">Detalles del movimiento</h3>
    	</div><!-- /.box-header -->
    	<div class="box-body">
    		<blockquote style="font-size:14px;">
            	<p><span class="badge <?php echo $colorTipo; ?>"><?php echo strtoupper($estado)?></span></p>
    			<p><b>Fecha del movimiento:</b> <?php echo $nuevaFecha; ?></p>
                <p><b>No. comprobante:</b> <?php echo $numerocomprobante; ?></p>
                <?php if ($idalmacendestino!=0){?>
                <p><b>Almacén o sucursal origen:</b> <?php echo $nombrealmacen; ?></p>
                <p><b>Almacén o sucursal destino:</b> <?php echo $nombrealmacendestino; ?></p>
                <?php }else{?>
                <p><b>Almacén o sucursal afectado:</b> <?php echo $nombrealmacen; ?></p>
                <?php }?>
    			<small>Comentarios:  <cite title="Source Title"><?php echo $comentarios; ?></cite></small>
                <input type="text" value="<?php echo $idalmacen; ?>" name="idalmacenX"/>
                <input type="text" value="<?php echo $idalmacendestino; ?>" name="idalmacendestino"/>
                <input type="text" value="<?php echo $idempleado; ?>" name="idempleadoX"/>
                <input type="text" value="<?php echo $idcliente; ?>" name="idclienteX"/>
    		</blockquote>
    	</div><!-- /.box-body -->
   	</div>
		<?php
	}else{?><!--x-->
     <div class="box box-solid">
    	<div class="box-header with-border">
    		<i class="fa fa-alert text-yellow"></i>
    		<h3 class="box-title">No existe el movimiento</h3>
    	</div><!-- /.box-header -->
    	<div class="box-body">
    		<blockquote style="font-size:14px;">
    			<p><i>Compruebe el número de comprobante, no existe o no se encuentra ninguna salida asociada</i></p>
    		</blockquote>
    	</div><!-- /.box-body -->
   	</div>
		<?php
	}
}else{
	$mensaje="fracaso@Operaci&oacute;n fallida@ $mensaje";
}

echo utf8_encode($mensaje);

?>