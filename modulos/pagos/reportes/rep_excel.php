<?php 
header('Content-type: application/excel');
$filename = 'reporte_filtrado_pagos.xls';
header('Content-Disposition: attachment; filename='.$filename);

include ("../../seguridad/comprobar_login.php");
/////PERMISOS////////////////
if (!isset($_SESSION['permisos']['ventas']['acceso'])){
	echo $_SESSION['msgsinacceso'];
	exit;
}
/////FIN  DE PERMISOS////////
include ("../../../librerias/php/variasfunciones.php");
require('../Pago.class.php');
if (isset($_REQUEST['tipoVista']) && $_REQUEST['tipoVista'] !="") {
	if($_REQUEST['tipoVista']!="undefined"){
		$tipoVista = htmlentities($_REQUEST['tipoVista']);
	}else{
		$tipoVista="tabla";
	}
}else{
	$tipoVista="tabla";
}

if (isset($_REQUEST['papelera']) && $_REQUEST['papelera'] =="si") {
		$papelera=false; // Cambiar a true en caso de que se requiera trabajar con la papelera
}else{
	$papelera=false;
}
if (isset($_REQUEST['campoOrden']) && $_REQUEST['campoOrden'] !="") {
	if($_REQUEST['campoOrden']!="undefined"){
		$campoOrden = htmlentities($_REQUEST['campoOrden']);
	}else{
		$campoOrden="idpago";
	}
}else{
	$campoOrden="idpago";
}

if (isset($_REQUEST['orden']) && $_REQUEST['orden'] !="") {
	if($_REQUEST['orden']!="undefined"){
		$orden = htmlentities($_REQUEST['orden']);
	}else{
		$orden="DESC";
	}
}else{
	$orden="DESC";
}

if (isset($_REQUEST['cantidadamostrar']) && $_REQUEST['cantidadamostrar'] !="") {
	if($_REQUEST['cantidadamostrar']!="undefined"){
		$cantidadamostrar = htmlentities($_REQUEST['cantidadamostrar']);
	}else{
		$cantidadamostrar="20";
	}
}else{
	$cantidadamostrar="20";
}

if (isset($_REQUEST['paginacion']) && $_REQUEST['paginacion'] !="") {
$pg = htmlentities($_REQUEST['paginacion']);
}

if (isset($_REQUEST['busqueda']) && $_REQUEST['busqueda'] !="") {
$busqueda = htmlentities($_REQUEST['busqueda']);
$busqueda=trim($busqueda);
}else{
	$busqueda ="";
}


if (isset($_REQUEST['idalmacen'])){
	$idalmacen=htmlentities(trim($_REQUEST['idalmacen']));
	$idalmacen=trim($idalmacen);	
}else{
	$idalmacen="TODOS";
}

if (isset($_REQUEST['idcliente'])){
	$idcliente=htmlentities(trim($_REQUEST['idcliente']));
	$idcliente=trim($idcliente);	
}else{
	$idcliente="TODOS";
}

if (isset($_REQUEST['ticket'])){
	$ticket=htmlentities(trim($_REQUEST['ticket']));
	$ticket=trim($ticket);	
}else{
	$ticket="";
}

if (isset($_REQUEST['tipo'])){
	$tipo=htmlentities(trim($_REQUEST['tipo']));
	$tipo=trim($tipo);	
}else{
	$tipo="";
}

if (isset($_REQUEST['filtrarfecha'])){
	$filtrarfecha=htmlentities(trim($_REQUEST['filtrarfecha']));
	$filtrarfecha=trim($filtrarfecha);	
}else{
	$filtrarfecha="";
}

if (isset($_REQUEST['fechainicio'])){
	$fechainicio=htmlentities(trim($_REQUEST['fechainicio']));
	$fechainicio=trim($fechainicio);	
}else{
	$fechainicio="";
}

if (isset($_REQUEST['fechafin'])){
	$fechafin=htmlentities(trim($_REQUEST['fechafin']));
	$fechafin=trim($fechafin);	
}else{
	$fechafin="";
}



if (isset($_REQUEST['formapago'])){
	$formapago=htmlentities(trim($_REQUEST['formapago']));
	$formapago=trim($formapago);	
}else{
	$formapago="";
}

if (isset($_REQUEST['diacobro'])){
	$diacobro=htmlentities(trim($_REQUEST['diacobro']));
	$diacobro=trim($diacobro);	
}else{
	$diacobro="";
}

if (isset($_REQUEST['facturada'])){
	$facturada=htmlentities(trim($_REQUEST['facturada']));
	$facturada=trim($facturada);	
}else{
	$facturada="";
}

if (isset($_REQUEST['domicilio'])){
	$domicilio=htmlentities(trim($_REQUEST['domicilio']));
	$domicilio=trim($domicilio);	
}else{
	$domicilio="";
}

//CODIGO DE PAGINACION (REQUIERE: "variasfunciones.php")
$inicial = $pg * $cantidadamostrar;
$Opago=new Pago;
$resultado=$Opago->mostrarA($campoOrden, $orden, $inicial, $cantidadamostrar, $busqueda, $papelera, $idalmacen, $idcliente, $ticket, $tipo, $filtrarfecha, $fechainicio, $fechafin, $formapago, $diacobro, $facturada, $domicilio, "SI");

$filasTotales=$resultado[1];
$resultado=$resultado[0];


if ($resultado=="denegado"){
	echo $_SESSION['msgsinacceso'];
	exit;
}

// MOSTRAR LOS REGISTROS SEGUN EL RESULTADO DE LA CONSULTA
?>
	 <h2 class="page-header">&nbsp;&nbsp; <i class="fa fa-dollar"></i> Pagos</h2> 
     
	<div class="box-body table-responsive no-padding"> <!-- /.box-body -->
    	<table class="table table-hover table-bordered" border="1">
        	<tr>
        		
                <th class="columnaDecorada" style="background:#FC0; width:30px"></th>
				<th class="Cidpago" >ID</th>
                <th class="Cidcliente">Sucursal</th>
				<th class="Cticket">Ticket</th>
                <th class="Cfecha">Fecha del pago</th>
                <?php if ($diacobro!="NO APLICA"){?>
                <th class="Cidcliente">Día cobro</th>
                <?php }?>
                <th class="Cidcliente">Cliente</th>
                <th class="Cefectivo" >Pago</th>
                <th class="Cefectivo" >Forma de pago</th>
      		</tr>
	<?php
	while ($filas=mysqli_fetch_array($resultado)) { 
		$total=$filas['monto'];
		$domicilio="";
		if($filas['marcarventa']=="si"){
			$domicilio=" (D)";
		}
	?>
      		<tr id="iregistro<?php echo $filas['idventa'] ?>">
        		
                <td class="columnaDecorada" style="background:#FC0;"></td>
				<td class="Cidpago" ><?php echo $filas['idpago']; ?></td>
                <td class="Cidalmacen" ><?php echo $filas['nombrealmacenes'].$domicilio; ?></td>
                <td class="Cticket"><?php echo $filas['ticket']; ?></td>
				<?php
				$fechaNfecha=date_create($filas['fechapago']);
				$nuevaFecha= date_format($fechaNfecha, 'd/m/Y');
				?>
                <td class="Cfecha"><?php echo $nuevaFecha; ?></td>
                <?php if ($diacobro!="NO APLICA"){?>
                <td class="Cfecha"><?php echo $diacobro; ?></td>
                <?php }?>
                <td class="Cidcliente"><?php echo $filas['nombreclientes']; ?></td>
				<td class="Cmonto"><?php echo number_format($total,2); ?></span></td>
                <td class="Cformapago"><?php echo $filas['formapago']; ?></td>
      		</tr>
    <?php
	}//Fin de while si es tabla ?>
		</table>
	</div><!-- /.box-body -->
    
    
    
    


</div>
<?php 
//FIN DEL CODIGO DE PAGINACION
if(mysqli_num_rows($resultado)==0){
	include("../../../componentes/mensaje_no_hay_registros.php");
}
?>

    