<?php 
include ("../../seguridad/comprobar_login.php");
/////PERMISOS////////////////
if (!isset($_SESSION['permisos']['inventario']['consultarkardex'])){
	echo $_SESSION['msgsinacceso'];
	exit;
}
/////FIN  DE PERMISOS////////
include ("../../../librerias/php/variasfunciones.php");
require('../../kardex/Kardex.class.php');
require('../../productos/Producto.class.php');

if (isset($_REQUEST['idsucursal'])){
	$idsucursal=$_REQUEST['idsucursal'];
}else{
	$idsucursal=$_REQUEST['idsucursal'];
}

if (isset($_REQUEST['idproducto'])){
	$idproducto=$_REQUEST['idproducto'];
}else{
	?>
<div class="alert alert-warning alert-dismissable">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	<h4><i class="icon fa fa-warning"></i> Alerta!</h4>
	No se ha recibido el parámetro del identificador del produto
</div>
<?php
	exit;
}

$Oproducto= new Producto;
$Okardex= new Kardex;
$resultado=$Oproducto->mostrarIndividual($idproducto);
if ($resultado){
	$extractor = mysqli_fetch_array($resultado);
	$id=$extractor["idproducto"];
	$nombre=$extractor["nombre"];
	$codigo=$extractor["codigo"];
	
}else{
	header("Location: ../consultar/vista.php?n1=movimientos&n2=movimientos&n3=consultarmovimientos");
}
if ($idsucursal=="x"){
	$nombreAlmacen="TODOS";
}else{
	$nombreAlmacen=$Okardex->obtenerCampo("sucursales","nombre","idsucursal",$idsucursal);
}

$existencias=number_format($Okardex->obtenerExistencias($id,$idsucursal),0);

$saldo=number_format($Okardex->obtenerSaldo($id,$idsucursal),0);

$cpromedio=number_format($Okardex->obtenerPromedio($id),2);

if ($existencias>0){
	$colorEx="#00a65a";
}else if($existencias==0){
	$colorEx="#f39c12";
}else{
	$colorEx="#dd4b39";
}




if ($saldo>0){
	$colorSaldo="#00a65a";
}else if($saldo==0){
	$colorSaldo="#f39c12";
}else{
	$colorSaldo="#dd4b39";
}



$resultado=$Okardex->consultaKardex($idsucursal,$idproducto);
if ($resultado=="denegado"){
	echo $_SESSION['msgsinacceso'];
	exit;
}
// MOSTRAR LOS REGISTROS SEGUN EL RESULTADO DE LA CONSULTA
?>
	<div class="box box-solid">
    	<div class="box-header with-border">
    		<i class="fa fa-book"></i>
    		<h3 class="box-title">Detalles del producto</h3>
    	</div><!-- /.box-header -->
    	<div class="box-body">
        	<div class="row">
                <div class="col-md-4 col-sm-6 col-xs-12">
                  	<blockquote style="font-size:14px;" class="col">
                        <p><b>KARDEX DE ALMACÉN:</b> <?php echo $nombreAlmacen; ?></p>
                        <p>Código de barras: <span class="badge bg-blue"><?php echo $codigo; ?></span></p>
                        <p><b>Nombre:</b> <?php echo $nombre; ?></p>
                        
                	</blockquote>
                </div>   
                <div class="col-md-5 col-sm-6 col-xs-12">
                  	<div class="info-box">
                    	<span class="info-box-icon" style="color:#FFF; background-color:<?php echo $colorEx; ?>"><i class="fa fa-server"></i></span>
                    	<div class="info-box-content">
                      		<span class="info-box-text">Existencias</span>
                      		<span class="info-box-number"><small><?php echo $nombreAlmacen; ?>: </small><span style="color:<?php echo $colorEx; ?>"><?php echo $existencias; ?></span></span>
                    	</div><!-- /.info-box-content -->
                  	</div><!-- /.info-box -->
                    
                    <div class="info-box">
                    	<span class="info-box-icon" style="color:#FFF; background-color:<?php echo $colorSaldo; ?>"><i class="fa fa-dollar"></i></span>
                    	<div class="info-box-content">
                      		<span class="info-box-text">Saldos</span>
                      		<span class="info-box-number"><small><?php echo $nombreAlmacen; ?>: </small><span style="color:<?php echo $colorSaldo; ?>">$ <?php echo $saldo; ?></span></span>
                    		<span class="info-box-number"><h6><b>Costo Promedio Unitario:</b>  $ <?php echo $cpromedio; ?> </h6></span>
                        </div><!-- /.info-box-content -->
                  	</div><!-- /.info-box -->
                    
                </div>
            </div>
    	</div><!-- /.box-body -->
   	</div>
	
              
	<div class="box-body table-responsive no-padding"> <!-- /.box-body -->
    	<table class="table table-hover table-bordered">
        	<tr>
                <th class="columnaDecorada" style="background:#25c274;"></th>
				<th class="Cidkardex">ID</th>
                <th class="Cidproducto">Fecha</th>
                <th class="Cidproducto">Descripción</th>
                <th class="Cidproducto">Entradas</th>
                <th class="Ccantidad">Salidas</th>
                <th class="Ccosto">Existencia</th>
                <th class="Ccantidad">Costo Unit</th>
                <th class="Ccosto">Costo Prom</th>
                <th class="Ccosto">Debe</th>
                <th class="Ccosto">Haber</th>
                <th class="Ccosto">Saldo</th>
                <th width="40"></th>
      		</tr>
	<?php
	while ($filas=mysqli_fetch_array($resultado)) { 
		if ($filas['entrada']==0){
			$color="#D22637";
			$iconoSalida='<i class="fa fa-arrow-up" style="color:'.$color.'"></i>&nbsp;&nbsp;';
			$iconoEntrada="";
		}else{
			$color="#25c274";
			$iconoEntrada='<i class="fa fa-arrow-down" style="color:'.$color.'"></i>&nbsp;&nbsp;';
			$iconoSalida="";
		}
		
		if ($filas['existencia']>0){
			$colorExistencia="bg-green";
		}else if($filas['existencia']==0){
			$colorExistencia="bg-yellow";
		}else{
			$colorExistencia="bg-red";
		}
	?>
    		
      		<tr id="iregistro<?php echo $filas['idkardex'] ?>" title="<?php echo $filas['observaciones']; ?>">
            	
                <td class="columnaDecorada" style="background:<?php echo $color; ?>;"></td>
				<td class="Cidkardex"><?php echo $filas['idkardex']; ?></td>
                <td class="Cidproductos"><?php echo $filas['fechamovimiento']; ?></td>
                <td class="Cidproductos"><?php echo $filas['descripcion']; ?></td>
                <td class="Cidproductos"><?php echo $iconoEntrada.$filas['entrada']; ?></td>
                <td class="Ccantidad"><?php echo $iconoSalida.$filas['salida']; ?></td>
                <td class="Ccosto"><span class="badge <?php echo $colorExistencia; ?>"><?php echo $filas['existencia']; ?></span></td>
                <td class="Ccantidad"><?php echo $filas['costounitario']; ?></td>
                <td class="Ccosto"><?php echo $filas['promedio']; ?></td>
                <td class="Ccosto"><?php echo $filas['debe']; ?></td>
                <td class="Ccosto"><?php echo $filas['haber']; ?></td>
                <td class="Ccosto"><?php echo $filas['saldo']; ?></td>
                <td>
                        <form action="../../movimientos/consultardetalles/vista.php?n1=movimientos&n2=movimientos&n3=consultarmovimientos" method="post" target="_blank">
							<input type="hidden" name="idmovimiento" value="<?php echo $filas['idmovimiento'] ?>"/>
                            <input type="hidden" name="idreferencia" value="0"/>
							<button type="submit" class="btn btn-success btn-xs" value="" title="Ver detalles del movimiento"><i class="fa fa-eye"></i></button>
						</form>
                </td>
      		</tr>
    <?php
	}//Fin de while si es tabla ?>
		</table>
	</div><!-- /.box-body -->

</div>