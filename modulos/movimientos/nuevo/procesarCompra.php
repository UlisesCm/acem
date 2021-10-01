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
	$resultado=$Omovimiento->consultaLibre("SELECT 
	compras.idcompra,
	compras.serie,
	compras.folio,
	compras.fecha,
	compras.comentarios,
	compras.estado,
	compras.monto,
	compras.idsucursal,
	compras.idproveedor,
	compras.factura,
	compras.idempleado,
	sucursales.nombre AS nombresucursal,
	proveedores.nombre AS nombreproveedor,
	empleados.nombre AS nombreempleado
	FROM compras
	INNER JOIN sucursales ON sucursales.idsucursal=compras.idsucursal
	INNER JOIN proveedores ON proveedores.idproveedor=compras.idproveedor
	INNER JOIN empleados ON empleados.idempleado=compras.idempleado
	WHERE compras.idcompra='$numerocomprobante'");
	if(mysqli_num_rows($resultado) > 0){
		$filas=mysqli_fetch_array($resultado);
		$idcliente= $filas['idcompra'];
		$serie= $filas['serie'];
		$folio= $filas['folio'];
		$idempleado=$filas['idempleado'];
		$fechaNfechamovimiento=date_create($filas['fecha']);
		$nuevaFecha= date_format($fechaNfechamovimiento, 'd/m/Y');
		$idalmacen=$filas['idsucursal'];
		$estado=$filas['estado'];
		$comentarios=$filas['comentarios'];
		$nombresucursal=$filas['nombresucursal'];
		$nombreproveedor=$filas['nombreproveedor'];
		$nombreempleado=$filas['nombreempleado'];
		if ($estado=="activo"){
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
    			<p><b>Fecha de orden:</b> <?php echo $nuevaFecha; ?></p>
                <p><b>No. comprobante:</b> <?php echo $serie."-".$folio; ?></p>
                <p><b>Almacén o sucursal afectado:</b> <?php echo $nombresucursal; ?></p>
                <p><b>Proveedor:</b> <?php echo $nombreproveedor; ?></p>
                <p><b>Reesponsable de la compra:</b> <?php echo $nombreempleado; ?></p>
              
    			<small>Comentarios:  <cite title="Source Title"><?php echo $comentarios; ?></cite></small>
                <input type="hidden" value="<?php echo $filas['idsucursal']; ?>" name="idalmacenX"/>
                <input type="hidden" value="<?php echo $filas['idproveedor'];?>" name="idproveedorX"/>
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