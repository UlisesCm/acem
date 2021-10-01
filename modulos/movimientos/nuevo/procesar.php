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

if (isset($_POST['otro'])){
	$otro=htmlentities(trim($_POST['otro']));
	$otro=trim($otro);
	$numerocomprobante=$otro;
	
}else{
	$validacion=false;
	$mensaje=$mensaje."<p>El campo orden de compra no es correcto</p>";
}


if($validacion){
	
	$resultadoM=$Omovimiento->consultaLibre("SELECT * FROM traspasos WHERE numerocomprobante='$numerocomprobante'");
	if ($resultadoM){
		$extractorM = mysqli_fetch_array($resultadoM);
		$idsucursalorigen=$extractorM["idsucursalorigen"];
		$idsucursaldestino=$extractorM["idsucursaldestino"];
		$idmovimiento=$extractorM["idmovimiento"];
	}else{
		$idsucursalorigen=0;
	}
	
	$resultado=$Omovimiento->consultaLibre("SELECT * FROM movimientos$idsucursalorigen WHERE numerocomprobante='$numerocomprobante' AND tipo='salida'");
	if(mysqli_num_rows($resultado) > 0){
		$filas=mysqli_fetch_array($resultado);
		$tabla= $filas['tabla'];
		$idreferencia=$filas['idreferencia'];
		$fechaNfechamovimiento=date_create($filas['fechamovimiento']);
		$nuevaFecha= date_format($fechaNfechamovimiento, 'd/m/Y');

		$estado=$filas['estado'];
		$comentarios=$filas['comentarios'];
		$nombresucursalorigen=$Omovimiento->obtenerCampo("sucursales","nombre","idsucursal",$idsucursalorigen);
		$nombrealmacendestino="";
		if($idsucursaldestino!=0){
			$nombresucursaldestino=$Omovimiento->obtenerCampo("sucursales","nombre","idsucursal",$idsucursaldestino);
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
                <?php if ($idsucursaldestino!=0){?>
                <p><b>Almacén o sucursal origen:</b> <?php echo $nombresucursalorigen; ?></p>
                <p><b>Almacén o sucursal destino:</b> <?php echo $nombresucursaldestino; ?></p>
                <?php }else{?>
                <p><b>Almacén o sucursal afectado:</b> <?php echo $nombresucursalorigen; ?></p>
                <?php }?>
    			<small>Comentarios:  <cite title="Source Title"><?php echo $comentarios; ?></cite></small>
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