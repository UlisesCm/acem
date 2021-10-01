<?php 
header('Content-type: application/excel');
$filename = 'inventario_comparativo.xls';
header('Content-Disposition: attachment; filename='.$filename);

include ("../../seguridad/comprobar_login.php");
/////PERMISOS////////////////
if (!isset($_SESSION['permisos']['inventario']['acceso'])){
	echo $_SESSION['msgsinacceso'];
	exit;
}
/////FIN  DE PERMISOS////////
include ("../../../librerias/php/variasfunciones.php");
require('../Inventario.class.php');

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
		$campoOrden="idproducto";
	}
}else{
	$campoOrden="idproducto";
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

//CODIGO DE PAGINACION (REQUIERE: "variasfunciones.php")
$inicial = $pg * $cantidadamostrar;
$Oinventario=new Inventario;
$resultado=$Oinventario->mostrar($campoOrden, $orden, 0, 500000000, $busqueda, $papelera);
if ($resultado=="denegado"){
	echo $_SESSION['msgsinacceso'];
	exit;
}
//$filasTotales = $Oinventario->contar($busqueda, $papelera);
// MOSTRAR LOS REGISTROS SEGUN EL RESULTADO DE LA CONSULTA

$tipoVista="tabla";


if ($tipoVista=="tabla"){ // Si se ha elegido el tipo tabla ?>
	<h2 class="page-header">&nbsp;&nbsp; <i class="fa fa-shopping-cart"></i> COMPARATIVO DE INVNETARIO</h2> 
	<div class="box-body table-responsive no-padding"> <!-- /.box-body -->
    	<table class="table table-hover table-bordered" border="1">
        	<tr>
        		
                <th class="columnaDecorada" style="background:#3972ce;"></th>
				<th class="Cidinventario" style="display:none">ID</th>
                <th class="Cidalmacen">Almacén</th>
                <th class="Cidproducto">Código</th>
                <th class="Cidproducto">Serie</th>
				<th class="Cidproducto">Producto</th>
				<th class="Cexistencia">Existencia Nueva</th>
                <th class="Cexistencia">Existencia Vieja</th>
                <th class="Csaldo">Diferencia</th>
				<th class="Cpromedio">Costo Promedio</th>
      		</tr>
	<?php
	while ($filas=mysqli_fetch_array($resultado)) {
		$existenciaVieja=$Oinventario->obtenerDatoViejo($filas['idalmacen'],$filas['idproducto'],"existencia");
		$diferencia=$filas['existencia']-$existenciaVieja;
		if ($diferencia==0){
			$colorExistencia="#096";
		}else if($diferencia>0){
			$colorExistencia="#F90";
		}else if ($diferencia<0){
			$colorExistencia="#F03";
		}
		
	?>
      		<tr id="iregistro<?php echo $filas['idinventario'] ?>">
        		
                <td class="columnaDecorada" style="background:#3972ce;"></td>
                <td class="Cidinventario" style="display:none"><?php echo $filas['idinventario']; ?></td>
                <td class="Cidalmacen"><?php echo $filas['nombrealmacenes']; ?></td>
                <td class="Cidproducto"><?php echo $filas['codigoproductos']; ?></td>
                <td class="Cidproducto"><?php echo $filas['modeloproductos']; ?></td>
				<td class="Cidproducto"><?php echo $filas['nombreproductos']; ?></td>
               	<td class="Cexistencia"><?php echo $filas['existencia']; ?></td>
				<td class="Cexistencia"><?php echo $existenciaVieja ?></td>
                <td class="Cexistencia" style="color:<?php echo $colorExistencia?>"><?php echo $diferencia; ?></td>
				<td class="Cpromedio"><?php echo $filas['promedio']; ?></td>
        		
      		</tr>
    <?php
	}//Fin de while si es tabla ?>
		</table>
	</div><!-- /.box-body -->
<?php
}

?>

</div>
<?php
//FIN DEL CODIGO DE PAGINACION
if(mysqli_num_rows($resultado)==0){
	include("../../../componentes/mensaje_no_hay_registros.php");
}
?>