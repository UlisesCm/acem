<?php 
include ("../../seguridad/comprobar_login.php");
/////PERMISOS////////////////
if (!isset($_SESSION['permisos']['movimientos']['acceso'])){
	echo $_SESSION['msgsinacceso'];
	exit;
}
/////FIN  DE PERMISOS////////
include ("../../../librerias/php/variasfunciones.php");
require('../../kardex/Kardex.class.php');
require('../../productos/Producto.class.php');

if (isset($_REQUEST['idalmacen'])){
	$idalmacen=$_REQUEST['idalmacen'];
}else{
	$idalmacen=$_SESSION['idalmacen'];
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
$resultado=$Oproducto->mostrarIndividual($idproducto,$idproducto);
if ($resultado){
	$extractor = mysqli_fetch_array($resultado);
	$id=$extractor["idproducto"];
	$nombre=$extractor["nombre"];
	$codigo=$extractor["codigo"];
	$modelo=$extractor["modelo"];
	$talla=$extractor["nombretallas"];
	$marca=$extractor["nombremarcas"];
	$caracteristicas=$extractor["caracteristicas"];
	
}else{
	header("Location: ../consultar/vista.php?n1=movimientos&n2=movimientos&n3=consultarmovimientos");
}
if ($idalmacen=="x"){
	$consultaKardex="";
	$nombreAlmacen="TODOS";
}else{
	$consultaKardex="AND kardex.idalmacen='$idalmacen'";
	$nombreAlmacen=$Okardex->obtenerCampo("almacenes","nombre","idalmacen",$idalmacen);
}

$existencias=number_format($Okardex->obtenerExistencias($id,$idalmacen),0);
$existenciasTotales=number_format($Okardex->obtenerExistencias($id,"x"),0);

$saldo=number_format($Okardex->obtenerSaldo($id,$idalmacen),0);
$saldoTotal=number_format($Okardex->obtenerSaldo($id,"x"),0);

$cpromedio=number_format($Okardex->obtenerPromedio($id),2);






if ($existencias>0){
	$colorEx="#00a65a";
}else if($existencias==0){
	$colorEx="#f39c12";
}else{
	$colorEx="#dd4b39";
}

if ($existenciasTotales >0){
	$colorExT="#00a65a";
}else if($existenciasTotales==0){
	$colorExT="#f39c12";
}else{
	$colorExT="#dd4b39";
}


if ($saldo>0){
	$colorSaldo="#00a65a";
}else if($saldo==0){
	$colorSaldo="#f39c12";
}else{
	$colorSaldo="#dd4b39";
}

if ($saldoTotal >0){
	$colorSaldoT="#00a65a";
}else if($saldoTotal==0){
	$colorSaldoT="#f39c12";
}else{
	$colorSaldoT="#dd4b39";
}

$resultado=$Okardex->consultaGeneral("WHERE productos.codigo='$idproducto' $consultaKardex");
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
                <div class="col-sm-4">
                  	<blockquote style="font-size:14px;" class="col">
                        <p>Código de barras: <span class="badge bg-blue"><?php echo $codigo; ?></span></p>
                        <p><b>Nombre:</b> <?php echo $nombre; ?></p>
                        <p><b>Modelo / Serie:</b> <?php echo $modelo; ?></p>
                        <p><b>Talla:</b> <?php echo $talla; ?></p>
                        <p><b>Marca:</b> <?php echo $marca; ?></p>
                        <small>Características:  <cite title="Source Title"><?php echo $caracteristicas; ?></cite></small>
                	</blockquote>
                </div>   
                <div class="col-sm-8">
                  	<?php 
					
$res=$Okardex->consultaLibre("SELECT * FROM almacenes");
while ($filas2=mysqli_fetch_array($res)) {
	$idalmacen=$filas2['idalmacen'];
	$nombreAlmacen=$filas2['nombre'];
	$existencias=number_format($Okardex->obtenerExistencias($id,$idalmacen),0);
	$existenciasR=$existencias;
	if ($existencias!=0){ ?>
		<h3 style="color:#069">
        <i class="fa fa-home"></i>
    <?php
		echo $nombreAlmacen.": <span class='badge bg-green' style='font-size:1em;'>".$existencias."<span>";
	}
	?>
    	</h3>
    <?php
	$consulta="SELECT * FROM concentrados WHERE idproducto='$id' AND idalmacen='$idalmacen' AND estado='abierto' AND idempleado <> '0' GROUP BY idempleado";
	$res3=$Okardex->consultaLibre($consulta);
	while ($filas3=mysqli_fetch_array($res3)) {
		$idvendedor=$filas3['idempleado'];
		$cantidad=$filas3['cantidad'];
		$existenciasR=$existenciasR-$cantidad;
		$nombreVendedor=$Okardex->obtenerCampo("empleados","nombre","idempleado",$idvendedor);
		
		$numeroComprobante=$filas3['numerocomprobante'];
		$fechaMovimiento=$Okardex->obtenerCampo("movimientos","fechamovimiento","idmovimiento",$filas3['idmovimiento']);
		$fechaNfechamovimiento=date_create($fechaMovimiento);
		$nuevaFecha= date_format($fechaNfechamovimiento, 'd/m/Y');
		?>
        <h4>&nbsp;&nbsp;&nbsp;<i class="fa fa-truck text-yellow"></i> <b>Vendedor: </b><?php echo $nombreVendedor; ?>,<b> Cantidad: </b> <span class="badge bg-yellow"><?php echo number_format($cantidad,0); ?></span><small> (<?php echo $numeroComprobante; ?>) <?php echo $nuevaFecha; ?></small></br></h4>
        <?php
	}
	

	$consulta="SELECT * FROM concentrados WHERE idproducto='$id' AND idalmacen='$idalmacen' AND estado='abierto' AND idcliente <> '0' GROUP BY idcliente";
	$res3=$Okardex->consultaLibre($consulta);
	while ($filas3=mysqli_fetch_array($res3)) {
		$idcliente=$filas3['idcliente'];
		$cantidad=$filas3['cantidad'];
		$existenciasR=$existenciasR-$cantidad;
		$nombreCliente=$Okardex->obtenerCampo("clientes","nombre","idcliente",$idcliente);
		
		$numeroComprobante=$filas3['numerocomprobante'];
		$fechaMovimiento=$Okardex->obtenerCampo("movimientos","fechamovimiento","idmovimiento",$filas3['idmovimiento']);
		$fechaNfechamovimiento=date_create($fechaMovimiento);
		$nuevaFecha= date_format($fechaNfechamovimiento, 'd/m/Y');
		
		?>
        <h4>&nbsp;&nbsp;&nbsp;<i class="fa fa-user text-red"></i> <b>Cliente: </b><?php echo $nombreCliente; ?>,<b> Cantidad: </b> <span class="badge bg-red"><?php echo number_format($cantidad,0); ?></span> <small>(<?php echo $numeroComprobante; ?>) <?php echo $nuevaFecha; ?></small></br></h4>
        <?php
	} ?>
   
	<?php
	if ($existencias!=0){
	?>
    <h4>&nbsp;&nbsp;&nbsp;<i class="fa fa-server text-green"></i> <b>En Sucursal: </b> <span class="badge bg-green"><?php echo number_format($existenciasR,0); ?></span></br></h4>
    <div class="progress progress-xxs">
    	<div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
    		<span class="sr-only"></span>
    	</div>
    </div>
    <?php
	}
}
					?>
                </div>
            </div>
    	</div><!-- /.box-body -->
   	</div>
	 

</div>