<?php 
include ("../../seguridad/comprobar_login.php");
/////PERMISOS////////////////
if (!isset($_SESSION['permisos']['rutas']['acceso'])){
	echo $_SESSION['msgsinacceso'];
	exit;
}
/////FIN  DE PERMISOS////////
include ("../../../librerias/php/variasfunciones.php");
require('../Ruta.class.php');

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
		$papelera=true;
}else{
	$papelera=false;
}
if (isset($_REQUEST['campoOrden']) && $_REQUEST['campoOrden'] !="") {
	if($_REQUEST['campoOrden']!="undefined"){
		$campoOrden = htmlentities($_REQUEST['campoOrden']);
	}else{
		$campoOrden="idruta";
	}
}else{
	$campoOrden="idruta";
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
// $busqueda=mysql_real_escape_string($busqueda);
}else{
	$busqueda ="";
}

if (isset($_REQUEST['folio']) && $_REQUEST['folio'] !="") {
	if($_REQUEST['folio']!="undefined"){
		$folio = htmlentities($_REQUEST['folio']);
	}else{
		$folio="";
	}
}else{
	$folio="";
}

if (isset($_REQUEST['filtrarfecha']) && $_REQUEST['filtrarfecha'] !="") {
	if($_REQUEST['filtrarfecha']!="undefined"){
		$filtrarfecha = htmlentities($_REQUEST['filtrarfecha']);
	}else{
		$filtrarfecha="";
	}
}else{
	$filtrarfecha="";
}

if (isset($_REQUEST['fechainicio']) && $_REQUEST['fechainicio'] !="") {
	if($_REQUEST['fechainicio']!="undefined"){
		$fechainicio = htmlentities($_REQUEST['fechainicio']);
	}else{
		$fechainicio="";
	}
}else{
	$fechainicio="";
}

if (isset($_REQUEST['fechafin']) && $_REQUEST['fechafin'] !="") {
	if($_REQUEST['fechafin']!="undefined"){
		$fechafin = htmlentities($_REQUEST['fechafin']);
	}else{
		$fechafin="";
	}
}else{
	$fechafin="";
}

if (isset($_REQUEST['autorizacion']) && $_REQUEST['autorizacion'] !="") {
	if($_REQUEST['autorizacion']!="undefined"){
		$autorizacion = htmlentities($_REQUEST['autorizacion']);
	}else{
		$autorizacion="";
	}
}else{
	$autorizacion="";
}

if (isset($_REQUEST['filtroavanzado']) && $_REQUEST['filtroavanzado'] !="") {
	if($_REQUEST['filtroavanzado']!="undefined"){
		$filtroavanzado = htmlentities($_REQUEST['filtroavanzado']);
	}else{
		$filtroavanzado="No";
	}
}else{
	$filtroavanzado="No";
}

//CODIGO DE PAGINACION (REQUIERE: "variasfunciones.php")
$inicial = $pg * $cantidadamostrar;
$Oruta=new Ruta;
$condicion="";
$resultado=$Oruta->mostrarReenvios($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera, $folio, $filtrarfecha,$fechainicio,$fechafin,$autorizacion);
if ($resultado=="denegado"){
	echo $_SESSION['msgsinacceso'];
	exit;
}
$filasTotales = $Oruta->contar($busqueda, $papelera);
// MOSTRAR LOS REGISTROS SEGUN EL RESULTADO DE LA CONSULTA


$tipoVista="tabla";

if ($tipoVista=="tabla"){ // Si se ha elegido el tipo tabla ?>
	<div class="box-body table-responsive no-padding"> <!-- /.box-body -->
    	<table class="table table-hover table-bordered">
        	<tr>
        		<th class="checksEliminar" width="10"><input id="seleccionarTodo" type="checkbox"  onclick="seleccionarTodo();"></th>
                <th class="columnaDecorada" style="background:#13a840;"></th>
				<th class="Cidruta">ID</th>
				<th class="Cfolioruta">Folio ruta</th>
                <th class="Cfolioventa">Folio venta</th>
				<th class="Cnombre">Nombre</th>
				<th class="Cfecha">Fecha</th>
				<th class="Cidempleado">Chofer</th>
				<th class="Cobservacionesruta">Observaciones ruta</th>
				<th class="Cobservacionessalida">Observaciones salida</th>
				<th class="Cestadoentrega">Estado entrega</th>
				<th width="40"></th>
      		</tr>
	<?php
	$con=0;
	while ($filas=mysqli_fetch_array($resultado)) { ?>
      		<tr id="iregistro<?php echo $filas['idruta'] ?>">
        		<td class="checksEliminar" width="30" valign="middle">
					<?php /////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['rutas']['eliminar'])){ ?>
                		<?php if($filas['idruta']!=0){ ?>
							<input id="registroEliminar<?php echo $filas['idruta'] ?>" type="checkbox" name="registroEliminar[]"  value="<?php echo $filas['idruta'] ?>" class="checkEliminar">
                    	<?php } ?>
					<?php 
					}
					?>
            	</td>
                <td class="columnaDecorada" style="background:#13a840;"></td>
				<td class="Cidruta"><?php echo $filas['idruta']; ?></td>
				<td class="Cfolioruta"><?php echo $filas['serie']."-".$filas['folio']; ?></td>
				<td class="Cfolioventa"><?php echo $filas['serieventa']."-".$filas['folioventa'];  ?></td>
				<td class="Cnombre"><?php echo $filas['nombre']; ?></td>
				<?php
				$fechaNfecha=date_create($filas['fecha']);
				$nuevaFecha= date_format($fechaNfecha, 'd/m/Y');
				?>
				<td class="Cfecha"><?php echo $nuevaFecha; ?></td>
				<td class="Cidempleado"><?php echo $filas['nombreempleado']; ?></td>
				<td class="Cobservacionesruta"><?php echo $filas['observacionesruta']; ?></td>
				<td class="Cobservacionessalida"><?php echo $filas['observacionessalida']; ?></td>
				<td class="Cestadoentrega<?php echo $con?>"><?php echo $filas['estadoentregaventa']; ?></td>
        		<td>
                	<?php
                	/////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['cotizacionesproductos']['consultar'])){
					?>
						<form target="_blank" action="../../../modulos/rutas/nuevadevolucionfinalizar/vista.php?n1=logisticaysalidas&n2=enviosadomicilio&n3=devoluciones&n4=nuevodevoluciones" method="post">
                			<input type="hidden" name="idcotizacionproducto" id="idcotizacionproducto" value="<?php echo $filas['idcotizacionproducto']; ?>"/>
                            <input type="hidden" name="estadoentrega" id="estadoentrega" value="<?php echo $filas['estadoentregaventa']; ?>"/>
                            <input type="hidden" name="devolucion" id="devolucion" value="SI"/>
                            <button type="submit" class="btn btn-success btn-xs" value="" title="Revisar devolución de productos"><li class="fa fa-truck"></li></button>
                		</form>
                	<?php 
					}else{ ?>
                    	<a class="btn btn-success btn-xs disabled"><i class="fa fa-truck"></i></a>
					<?php
                    }
					?>
                </td>
                
      		</tr>
    <?php
	$con++;
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
	<div class="info-box" style="height:120px;" id="iregistro<?php echo $filas['idruta'] ?>">
    	<span class="info-box-icon bg-red" style="background-color:#13a840 !important; height:120px; padding-top:15px;"><i class="fa fa-map"></i></span>
    	<div class="info-box-content">
    		<span class="info-box-text Cidempleado" style="font-size:18px;">
				<span class="checksEliminar">
					<?php /////PERMISOS////////////////
					if (isset($_SESSION['permisos']['rutas']['eliminar'])){ ?>
						<?php if($filas['idruta']!=0){ ?>
							<input id="registroEliminar<?php echo $filas['idruta'] ?>" type="checkbox" name="registroEliminar[]"  value="<?php echo $filas['idruta'] ?>" class="checkEliminar">
						<?php } ?>
					<?php
					}
					?>
				</span>
			<?php echo $filas['nombreempleado'] ?>
            </span>
    		<span class="info-box-number Cnombre" style="font-weight:normal; color:#13a840;"><?php echo $filas['nombre'] ?></span>
            <span class="info-box-number Ccomposicion" style="font-weight:normal; font-size:12px;">
				<?php 
				$composicion="";
				if (trim($filas['fecha'])!=""){
					$composicion=$composicion."".$filas['fecha'];
				}
				if (trim($filas['serie'])!=""){
					$composicion=$composicion.", ".$filas['serie'];
				}
				if (trim($filas['folio'])!=""){
					$composicion=$composicion."-".$filas['folio'];
				}
				if (trim($filas['autorizada'])!=""){
					$composicion=$composicion.", ".$filas['autorizada'];
				}
				echo $composicion;
				?>
			</span>
			
            <table border="0">
             	<tr>
             		<td style=" padding-right:2px;">
						<?php 
						if (!$papelera){
						?>
							<?php /////PERMISOS////////////////
							if (isset($_SESSION['permisos']['rutas']['eliminar'])){ ?>
								<?php if($filas['idruta']==0){ ?>
									<a class="btn btn-default disabled"><i class="fa fa-trash-o"></i></a>
								<?php }else{ ?>
									<a class="btn btn-default" onclick="(eliminarIndividual(<?php echo $filas['idruta'] ?>))" title="Eliminar"><i class="fa fa-trash-o"></i></a>
								<?php } ?>
							<?php 
							}else{ ?>
								<a class="btn btn-default disabled"><i class="fa fa-trash-o"></i></a>
							<?php
							}
							?>
						<?php 
						}else{?>
								<a class="btn btn-default" onclick="(restaurarIndividual(<?php echo $filas['idruta'] ?>))" title="Restaurar Resgistro"><i class="fa fa-recycle"></i></a>
						<?php 
						}
						?>
					</td>
					<td style=" padding-right:2px;">
						<?php /////PERMISOS////////////////
						if (isset($_SESSION['permisos']['rutas']['modificar'])){ ?>
							<form action="../modificar/actualizar.php?n1=logisticaysalidas&n2=enviosadomicilio&n3=rutas&n4=consultarrutas" method="post">
								<input type="hidden" name="id" value="<?php echo $filas['idruta'] ?>"/>
								<button type="submit" class="btn btn-default"><i class="fa fa-pencil"></i></button>
							</form>
						<?php 
						}else{ ?>
							<a class="btn btn-default disabled"><i class="fa fa-pencil"></i></a>
                        <?php
                        }
						?>
                	</td>
        	 	</tr>
             </table>  
            
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