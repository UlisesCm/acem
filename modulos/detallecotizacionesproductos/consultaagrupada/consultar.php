<?php 
include ("../../seguridad/comprobar_login.php");
/////PERMISOS////////////////
if (!isset($_SESSION['permisos']['detallecotizacionesproductos']['acceso'])){
	echo $_SESSION['msgsinacceso'];
	exit;
}
/////FIN  DE PERMISOS////////
include ("../../../librerias/php/variasfunciones.php");
require('../Detallecotizacionproducto.class.php');

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
		$campoOrden="iddetallecotizacion";
	}
}else{
	$campoOrden="iddetallecotizacion";
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
$cantidadamostrar="10000";

if (isset($_REQUEST['paginacion']) && $_REQUEST['paginacion'] !="") {
$pg = htmlentities($_REQUEST['paginacion']);
}

if (isset($_REQUEST['busqueda']) && $_REQUEST['busqueda'] !="") {
$busqueda = htmlentities($_REQUEST['busqueda']);
// $busqueda=mysql_real_escape_string($busqueda);
}else{
	$busqueda ="";
}

if (isset($_REQUEST['idcotizacionproducto']) && $_REQUEST['idcotizacionproducto'] !="") {
	if($_REQUEST['idcotizacionproducto']!="undefined"){
		$idcotizacionproducto = htmlentities($_REQUEST['idcotizacionproducto']);
	}else{
		$idcotizacionproducto="";
	}
}else{
	$idcotizacionproducto="";
}

if (isset($_REQUEST['idruta']) && $_REQUEST['idruta'] !="") {
	if($_REQUEST['idruta']!="undefined"){
		$idruta = htmlentities($_REQUEST['idruta']);
	}else{
		$idruta="";
	}
}else{
	$idruta="";
}

//CODIGO DE PAGINACION (REQUIERE: "variasfunciones.php")
$inicial = $pg * $cantidadamostrar;
$Odetallecotizacionproducto=new Detallecotizacionproducto;

if($busqueda == ""){
	if($idcotizacionproducto!=""){														
		$resultado=$Odetallecotizacionproducto->mostrarTotalProductosAgrupados($campoOrden, $orden, $inicial, $cantidadamostrar, $busqueda, $papelera, $idcotizacionproducto);
	}
	
    $filasTotales=$resultado[1];
	$resultado=$resultado[0];
}
else{
	$resultado=$Odetallecotizacionproducto->mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $busqueda, $papelera);
	$filasTotales=$resultado[1];
	$resultado=$resultado[0];
}
if ($resultado=="denegado"){
	echo $_SESSION['msgsinacceso'];
	exit;
}
$filasTotales = $Odetallecotizacionproducto->contar($busqueda, $papelera);
// MOSTRAR LOS REGISTROS SEGUN EL RESULTADO DE LA CONSULTA



$tipoVista="tabla";
if ($tipoVista=="tabla"){ // Si se ha elegido el tipo tabla ?>
	<div class="box-body table-responsive no-padding"> <!-- /.box-body -->
    	<table class="table table-hover table-bordered">
        	<tr>
        		<th class="checksEliminar" width="10"><input id="seleccionarTodo" type="checkbox"  onclick="seleccionarTodo();"></th>
                <th class="columnaDecorada" style="background:#4da8ac;"></th>
				<th style = "Display:none" class="Ciddetallecotizacion">ID</th>
				<th class="Cidproducto">Producto</th>
				<th class="Ccantidad">Cantidad</th>
				<th style = "Display:none" class="Cidcotizacionproducto">Idcotizacionproducto</th>
				<th class="Cpesounitario">Peso total KG</th>
				<th style = "Display:none" class="Ccantidadentregada">Cantidad entregada</th>
      		</tr>
	<?php
	while ($filas=mysqli_fetch_array($resultado)) { ?>
      		<tr id="iregistro<?php echo $filas['iddetallecotizacion'] ?>">
        		<td class="checksEliminar" width="30" valign="middle">
					<?php /////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['detallecotizacionesproductos']['eliminar'])){ ?>
                		<?php if($filas['iddetallecotizacion']!=0){ ?>
							<input id="registroEliminar<?php echo $filas['iddetallecotizacion'] ?>" type="checkbox" name="registroEliminar[]"  value="<?php echo $filas['iddetallecotizacion'] ?>" class="checkEliminar">
                    	<?php } ?>
					<?php 
					}
					?>
            	</td>
                <td class="columnaDecorada" style="background:#4da8ac;"></td>
				<td style = "Display:none" class="Ciddetallecotizacion"><?php echo $filas['iddetallecotizacion']; ?></td>
				<td class="Cidproducto"><?php echo $filas['nombreproducto']; ?></td>
				<td class="Ccantidad"><?php echo $filas['cantidadtotal']; ?></td>
				<td style = "Display:none" class="Cidcotizacionproducto"><?php echo $filas['idcotizacionproducto']; ?></td>
				<td class="Cpesounitario"><?php echo $filas['pesototal']; ?></td>
				<td style = "Display:none" class="Ccantidadentregada"><?php echo $filas['cantidadentregada']; ?></td>
      		</tr>
    <?php
	}//Fin de while si es tabla ?>
		</table>
	</div><!-- /.box-body -->
<?php
}
else{ // Si se ha elegido el tipo lista ?>
	<div class="box-body">
    <?php
	while ($filas=mysqli_fetch_array($resultado)) {		
?>
	<div class="info-box" style="height:120px;" id="iregistro<?php echo $filas['iddetallecotizacion'] ?>">
    	<span class="info-box-icon bg-red" style="background-color:#4da8ac !important; height:120px; padding-top:15px;"><i class="fa fa-magic"></i></span>
    	<div class="info-box-content">
    		<span class="info-box-text Csubfolio" style="font-size:18px;">
				<span class="checksEliminar">
					<?php /////PERMISOS////////////////
					if (isset($_SESSION['permisos']['detallecotizacionesproductos']['eliminar'])){ ?>
						<?php if($filas['iddetallecotizacion']!=0){ ?>
							<input id="registroEliminar<?php echo $filas['iddetallecotizacion'] ?>" type="checkbox" name="registroEliminar[]"  value="<?php echo $filas['iddetallecotizacion'] ?>" class="checkEliminar">
						<?php } ?>
					<?php
					}
					?>
				</span>
			<?php echo "Sub folio ".$filas['subfolio'] ?>
            </span>
    		<span class="info-box-number Cidproducto" style="font-weight:normal; color:#4da8ac;"><?php echo $filas['nombreproducto'] ?></span>
            <span class="info-box-number Ccomposicion" style="font-weight:normal; font-size:12px;">
				<?php 
				$composicion="";
				if (trim($filas['cantidad'])!=""){
					$composicion=$composicion."Cantidad ".$filas['cantidad'];
				}
				if (trim($filas['precio'])!=""){
					$composicion=$composicion.", Precio ".$filas['precio'];
				}
				if (trim($filas['subtotal'])!=""){
					$composicion=$composicion.", Subtotal ".$filas['subtotal'];
				}
				if (trim($filas['impuestos'])!=""){
					$composicion=$composicion.", Impuestos ".$filas['impuestos'];
				}
				if (trim($filas['total'])!=""){
					$composicion=$composicion.", Total ".$filas['total'];
				}
				if (trim($filas['pesounitario'])!=""){
					$composicion=$composicion.", Precio Unitario ".$filas['pesounitario'];
				}
				if (trim($filas['cantidadentregada'])!=""){
					$composicion=$composicion.", Cantidad Entregada ".$filas['cantidadentregada'];
				}
				echo $composicion;
				?>
			</span>
			 
            
    	</div><!-- /.info-box-content -->
    </div><!-- /.box -->
<?php 
		} //Fin de while
}// Fin de sis es lista
?>

</div>
<?php 
paginar($pg, $cantidadamostrar, $filasTotales, $campoOrden, $orden, $busqueda, $tipoVista);
//FIN DEL CODIGO DE PAGINACION
if(mysqli_num_rows($resultado)==0){
	include("../../../componentes/mensaje_no_hay_registros.php");
}
?>