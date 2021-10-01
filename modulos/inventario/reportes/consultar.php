<?php 
include ("../../seguridad/comprobar_login.php");
/////PERMISOS////////////////
if (!isset($_SESSION['permisos']['movimientos']['acceso'])){
	echo $_SESSION['msgsinacceso'];
	exit;
}
/////FIN  DE PERMISOS////////
include ("../../../librerias/php/variasfunciones.php");
require('../../inventario/Inventario.class.php');
require('../../productos/Producto.class.php');

if (isset($_REQUEST['idalmacen'])){
	$idalmacen=$_REQUEST['idalmacen'];
}else{
	$idalmacen=$_SESSION['idalmacen'];
}


$Oinventario= new Inventario;
if ($idalmacen=="x"){
	$nombreAlmacen="TODOS";
}else{
	$nombreAlmacen=$Oinventario->obtenerCampo("almacenes","nombre","idalmacen",$idalmacen);
}
$totalInventario=$Oinventario->obtenerCostoTotal($idalmacen);
$totalTotalInventario=$Oinventario->obtenerCostoTotal("x");

// MOSTRAR LOS REGISTROS SEGUN EL RESULTADO DE LA CONSULTA
?>
	<div class="box box-solid">
    	<div class="box-header with-border">
    		<i class="fa fa-book"></i>
    		<h3 class="box-title">Detalles del inventario</h3>
    	</div><!-- /.box-header -->
    	<div class="box-body">
        	<div class="row">
                <div class="col-md-5 col-sm-6 col-xs-12">
                  	
                    <div class="info-box">
                    	<span class="info-box-icon" style="color:#FFF; background-color:#6C3;"><i class="fa fa-dollar"></i></span>
                    	<div class="info-box-content">
                      		<span class="info-box-text">Valor del inventario</span>
                      		<span class="info-box-number"><small><?php echo $nombreAlmacen; ?>: </small><span style="color:#6C3;">$ <?php echo $totalInventario; ?></span></span>
                            <span class="info-box-number"><small>General: </small><span style="color:#6C3;">$ <?php echo $totalTotalInventario; ?></span></span>
                    		<span class="info-box-number"><h6>Fecha de consulta:  <?php echo date('d/m/Y'); ?> </h6></span>
                        </div><!-- /.info-box-content -->
                  	</div><!-- /.info-box -->
                    
                </div>
            </div>
    	</div><!-- /.box-body -->
   	</div>
	
              
	