<?php 
header('Content-type: application/excel');
$filename = 'reporte_movimientos.xls';
header('Content-Disposition: attachment; filename='.$filename);

include ("../../seguridad/comprobar_login.php");
/////PERMISOS////////////////
if (!isset($_SESSION['permisos']['movimientos']['acceso'])){
	echo $_SESSION['msgsinacceso'];
	exit;
}
/////FIN  DE PERMISOS////////
include ("../../../librerias/php/variasfunciones.php");
require('../../kardex/Kardex.class.php');
require('../Movimiento.class.php');

if (isset($_REQUEST['idmovimiento'])){
	$idmovimiento=$_REQUEST['idmovimiento'];
}else{
	header("Location: ../consultar/vista.php?n1=movimientos&n2=movimientos&n3=consultarmovimientos");
}

if (isset($_REQUEST['idreferencia'])){
	$idreferencia=$_REQUEST['idreferencia'];
}else{
	header("Location: ../consultar/vista.php?n1=movimientos&n2=movimientos&n3=consultarmovimientos");
}

if (isset($_REQUEST['tabla'])){
	$idreferencia=$_REQUEST['tabla'];
}else{
	header("Location: ../consultar/vista.php?n1=movimientos&n2=movimientos&n3=consultarmovimientos");
}
$idsucursal=$_SESSION['idsucursal'];

$Omovimiento=new Movimiento ;
$Okardex= new Kardex;
$resultado=$Omovimiento->consultaGeneral("WHERE idmovimiento='$idmovimiento'");
if ($resultado){
	$extractor = mysqli_fetch_array($resultado);
	$tipo=$extractor["tipo"];
	$concepto=$extractor["concepto"];
	$numerocomprobante=$extractor["numerocomprobante"];
	$comentarios=$extractor["comentarios"];
	$idreferencia=$extractor["idreferencia"];
	if ($concepto=="ORDEN DE COMPRA"){
		$resultadoP=$Omovimiento->consultaLibre("SELECT compras.idcompra, compras.idproveedor, proveedores.nombre AS nombreProveedor FROM compras INNER JOIN proveedores ON proveedores.idproveedor=compras.idproveedor WHERE idcompra='$idreferencia'");
		if(mysqli_num_rows($resultadoP) > 0){
				$filasP=mysqli_fetch_array($resultadoP);
				$nombreProveedor= $filasP['nombreProveedor'];
			}else{
				$nombreProveedor="";
		}
	}
	$fechaNfechamovimiento=date_create($extractor['fechamovimiento']);
	$nuevaFecha= date_format($fechaNfechamovimiento, 'd/m/Y');
	if ($tipo=="entrada"){
		$colorTipo="bg-green";
		$colorIcon="text-green";
	}else{
		$colorTipo="bg-red";
		$colorIcon="text-red";
	}
	if ($concepto=="VENTA"){
		/////PERMISOS////////////////
		if (isset($_SESSION['permisos']['detallecotizacionesotros']['consultar'])){
			$urlventa="
			<form target=\"_blank\" action=\"../../detallecotizacionesproductos/consultar/vista.php?n1=ventas&n2=cotizacionesproductos&n3=consultarcotizacionesproductos\" method=\"post\">
				<input type=\"hidden\" name=\"idcotizacionproducto\" value=\"$idreferencia\"/>
				<button type=\"submit\" class=\"btn btn-info btn-xs\" value=\"\" title=\"Detalles\">Ver detalles</button>
			</form>";
		}else{ 
			$urlventa="<a class=\"btn btn-success btn-xs disabled\"><i class=\"fa fa-pencil\"></i></a>";
		}
	}
	else{
		$urlventa="";
	}
}else{
	header("Location: ../consultar/vista.php?n1=movimientos&n2=movimientos&n3=consultarmovimientos");
}

$nombreAlmacen=$Okardex->obtenerCampo("sucursales","nombre","idsucursal",$idsucursal);

$resultado=$Okardex->consultaGeneral("WHERE kardex$idsucursal.idmovimiento='$idmovimiento'");
if ($resultado=="denegado"){
	echo $_SESSION['msgsinacceso'];
	exit;
}
// MOSTRAR LOS REGISTROS SEGUN EL RESULTADO DE LA CONSULTA
?>
	<div class="box box-solid">
    	<div class="box-header with-border">
    		<i class="fa fa-book <?php echo $colorIcon; ?>"></i>
    		<h3 class="box-title">Detalles del movimiento</h3>
    	</div><!-- /.box-header -->
    	<div class="box-body">
    		<blockquote style="font-size:14px;">
            	<p><span class="badge <?php echo $colorTipo; ?>"><?php echo strtoupper($tipo)?></span></p>
    			<p><b>Fecha del movimiento:</b> <?php echo $nuevaFecha; ?></p>
                <p><b>Concepto o motivo:</b> <?php echo $concepto. " &nbsp;&nbsp;&nbsp;".$urlventa; ?></p>
                <?php if ($concepto=="ORDEN DE COMPRA"){?>
                <p><b>Proveedor:</b> <?php echo $nombreProveedor; ?></p>
                <?php }?>
                <p><b>No. comprobante:</b> <?php echo $numerocomprobante; ?></p>
                <p><b>Almac&eacute;n o sucursal:</b> <?php echo $nombreAlmacen; ?></p>
    			<small>Comentarios:  <cite title="Source Title"><?php echo $comentarios; ?></cite></small>
    		</blockquote>
    	</div><!-- /.box-body -->
   	</div>
	
              
	<div class="box-body table-responsive no-padding"> <!-- /.box-body -->
    	<table class="table table-hover table-bordered" border="1">
        	<tr>
                <th class="columnaDecorada" style="background:#25c274;"></th>
				<th class="Cidkardex">ID</th>
                <th class="Cidproducto">C&oacute;digo del producto</th>
                <th class="Cidproducto">Producto</th>
                <?php if ($tipo=="entrada"){?>
                <th class="Ccantidad">Cantidad Ingresada</th>
                <th class="Ccosto">Costo de Entrada</th>
                <th class="Ccosto">Monto</th>
                <?php }else{?>
                <th class="Ccantidad">Cantidad Saliente</th>
                <th class="Ccosto">Costo Promedio</th>
                <th class="Ccosto">Monto</th>
                <?php }?>
      		</tr>
	<?php
	$sumaCantidad=0;
	$sumaMonto=0;
	while ($filas=mysqli_fetch_array($resultado)) { 
	?>
    		
      		<tr id="iregistro<?php echo $filas['idkardex'] ?>">
                <td class="columnaDecorada" style="background:#25c274;"></td>
				<td class="Cidkardex"><?php echo $filas['idkardex']; ?></td>
                <td class="Cidproductos"><?php echo $filas['codigoproductos']; ?></td>
                <td class="Cidproductos"><?php echo $filas['nombreproductos']; ?></td>
                <?php if ($tipo=="entrada"){
					$sumaCantidad=$sumaCantidad+$filas['entrada'];
					$sumaMonto=$sumaMonto+($filas['costounitario']*$filas['entrada']);
				?>
                <td class="Ccantidad"><?php echo $filas['entrada']; ?></td>
                <td class="Ccosto"><?php echo $filas['costounitario']; ?></td>
                <td class="Ccosto"><?php echo $filas['costounitario']*$filas['entrada']; ?></td>
                <?php }else{
					$sumaCantidad=$sumaCantidad+$filas['salida'];
					$sumaMonto=$sumaMonto+($filas['promedio']*$filas['salida']);
				?>
                <td class="Ccantidad"><?php echo $filas['salida']; ?></td>
                <td class="Ccosto"><?php echo $filas['promedio']; ?></td>
                <td class="Ccosto"><?php echo $filas['promedio']*$filas['salida']; ?></td>
                <?php }?>
      		</tr>
    <?php
	}//Fin de while si es tabla ?>
    	<tr id="iregistro<?php echo $filas['idkardex'] ?>">
                <td class="columnaDecorada" style="background:#25c274;"></td>
				<td class="Cidkardex"></td>
                <td class="Cidproductos"></td>
                <td class="Cidproductos"></td>
                <td class="Cidproductos" style="font-weight:bold" align="right">No. Productos:</td>
                <?php if ($tipo=="entrada"){?>
                <td class="Ccantidad" style="font-weight:bold; color:#F00;"><?php echo $sumaCantidad; ?></td>
                <td class="Ccosto" style="font-weight:bold" align="right">Total:</td>
                <td class="Ccosto" style="font-weight:bold; color:#F00;"><?php echo $sumaMonto ?></td>
                <?php }else{?>
                <td class="Ccantidad" style="font-weight:bold; color:#F00;"><?php echo $sumaCantidad; ?></td>
                <td class="Ccosto" style="font-weight:bold" align="right">Total:</td>
                <td class="Ccosto" style="font-weight:bold; color:#F00;"><?php echo $sumaMonto ?></td>
                <?php }?>
      		</tr>
		</table>
	</div><!-- /.box-body -->

</div>