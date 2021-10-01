<?php 
include ("../../seguridad/comprobar_login.php");
/////PERMISOS////////////////
if (!isset($_SESSION['permisos']['movimientos']['acceso'])){
	echo $_SESSION['msgsinacceso'];
	exit;
}
/////FIN  DE PERMISOS////////
include ("../../../librerias/php/variasfunciones.php");
require('../Movimiento.class.php');

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
		$campoOrden="fechamovimiento";
	}
}else{
	$campoOrden="fechamovimiento";
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

if (isset($_REQUEST['filtrarfecha']) && $_REQUEST['filtrarfecha'] !="") {
	$filtrarfecha = htmlentities($_REQUEST['filtrarfecha']);
	$filtrarfecha=trim($filtrarfecha);
}else{
	$filtrarfecha ="NO";
}

if (isset($_REQUEST['fechainicio']) && $_REQUEST['fechainicio'] !="") {
	$fechainicio = htmlentities($_REQUEST['fechainicio']);
	$fechainicio=trim($fechainicio);
}else{
	$fechainicio = date("Y-m-d");
}

if (isset($_REQUEST['fechafin']) && $_REQUEST['fechafin'] !="") {
	$fechafin = htmlentities($_REQUEST['fechafin']);
	$fechafin=trim($fechafin);
}else{
	$fechafin = date("Y-m-d");
}

if (isset($_REQUEST['tipo']) && $_REQUEST['tipo'] !="") {
	$tipo = htmlentities($_REQUEST['tipo']);
	$tipo=trim($tipo);
}else{
	$tipo = "TODOS";
}

if (isset($_REQUEST['motivo']) && $_REQUEST['motivo'] !="") {
	$motivo = htmlentities($_REQUEST['motivo']);
	$motivo=trim($motivo);
}else{
	$motivo = "TODOS";
}

$consultaExtra="";
$idsucursal=$_SESSION['idsucursal'];
if ($filtrarfecha=="SI"){
	$consultaExtra=$consultaExtra." AND (movimientos$idsucursal.fechamovimiento >= '$fechainicio' AND  movimientos$idsucursal.fechamovimiento <= '$fechafin')";
}
if ($tipo!="TODOS"){
	$consultaExtra=$consultaExtra." AND movimientos$idsucursal.tipo='$tipo'";
}
if ($motivo!="TODOS"){
	$consultaExtra=$consultaExtra." AND movimientos$idsucursal.concepto='$motivo'";
}



//CODIGO DE PAGINACION (REQUIERE: "variasfunciones.php")
$inicial = $pg * $cantidadamostrar;
$Omovimiento=new Movimiento;
$resultado=$Omovimiento->mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $busqueda, $papelera, $consultaExtra);
if ($resultado=="denegado"){
	echo $_SESSION['msgsinacceso'];
	exit;
}
$filasTotales = $Omovimiento->contar($busqueda, $papelera);
// MOSTRAR LOS REGISTROS SEGUN EL RESULTADO DE LA CONSULTA




if ($tipoVista=="tabla"){ // Si se ha elegido el tipo tabla ?>
	<div class="box-body table-responsive no-padding"> <!-- /.box-body -->
    	<table class="table table-hover table-bordered">
        	<tr>
        		<th class="checksEliminar" width="10"><input id="seleccionarTodo" type="checkbox"  onclick="seleccionarTodo();"></th>
                <th class="columnaDecorada" style="background:#25c274;"></th>
				<th class="Cidmovimiento">ID</th>
                <th class="Ctipo">Tipo</th>
				<th class="Cconcepto">Motivo</th>
				<th class="Cfechamovimiento">Fecha del movimiento</th>
				<th class="Cnumerocomprobante">No. comprobante</th>
				<th class="Ccomentarios">Comentarios</th>
				<th width="40"></th>
                <th width="40"></th>
      		</tr>
	<?php
	while ($filas=mysqli_fetch_array($resultado)) { 
		if ($filas['tipo']=="entrada"){
			$color="#25c274";
		}else{
			$color="#D82533";
		}
	?>
    		
      		<tr id="iregistro<?php echo $filas['idmovimiento'] ?>">
        		<td class="checksEliminar" width="30" valign="middle">
					<?php /////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['movimientos']['eliminar'])){ ?>
                		<?php if($filas['idmovimiento']!=0){ ?>
							<input id="registroEliminar<?php echo $filas['idmovimiento'] ?>" type="checkbox" name="registroEliminar[]"  value="<?php echo $filas['idmovimiento'] ?>" class="checkEliminar">
                    	<?php } ?>
					<?php 
					}
					?>
            	</td>
                <td class="columnaDecorada" style="background:<?php echo $color; ?>;"></td>
				<td class="Cidmovimiento"><?php echo $filas['idmovimiento']; ?></td>
                <td class="Cidmovimiento"><span class="badge" style="background-color:<?php echo $color;?>"><?php echo $filas['tipo']; ?></span></td>
				<td class="Cconcepto"><?php echo $filas['concepto']; ?></td>
				<?php
				$fechaNfechamovimiento=date_create($filas['fechamovimiento']);
				$nuevaFecha= date_format($fechaNfechamovimiento, 'd/m/Y');
				?>
				<td class="Cfechamovimiento"><?php echo $nuevaFecha; ?></td>
                <?php 
				if ($filas['concepto']=="CONSIGNACION A CLIENTE" or $filas['concepto']=="CONSIGNACION A VENDEDOR"){
					if ($filas['tipo']=="salida"){
						$tipoMov="salida";
					}else{
						$tipoMov="diferencia";
					}
				?>
                <td class="Cnumerocomprobante" style="min-width:150px; font-size:10px; font-weight:bold;">
                <?php echo $filas['numerocomprobante'];?>&nbsp;
                <form action="descargar.php" method="post" class="inline">
            		<input name="f" type="hidden" value="<?php echo $filas['numerocomprobante']."-".$tipoMov.".pdf"; ?>"/>
					<button type="submit" class="btn btn-warning btn-xs"><i class="fa fa-download"></i></button>
        		</form>
                </td>
                <?php }else{ ?>
				<td class="Cnumerocomprobante"><?php if($filas['concepto']=="ORDEN DE COMPRA"){echo $Omovimiento->obtenerFolioCompra($filas['numerocomprobante']);}else{echo $filas['numerocomprobante'];} ?></td>
                <?php }?>
				<td class="Ccomentarios"><small><i><?php echo $filas['comentarios']; ?></i></small></td>
        		<td title="No se pueden eliminar los movimientos cuyos conceptos sean: venta o devolución. Estos se eliminarán cuando se cancelen las ventas o devoluciones respectivas">
					<?php 
					if (!$papelera){
					?>
						<?php /////PERMISOS////////////////
						if (isset($_SESSION['permisos']['movimientos']['eliminar'])){
						?>
							<?php if($filas['idmovimiento']==0 or $filas['idreferencia']!=0){ ?>
								<a class="btn btn-danger btn-xs disabled"><i class="fa fa-trash-o"></i></a>
							<?php }else{ ?>
								<a class="btn btn-danger btn-xs" title="Eliminar" onclick="(eliminarIndividual(<?php echo $filas['idmovimiento'] ?>))"><li class="fa fa-trash"></li></a>
							<?php }?>
						<?php 
						}else{ ?>
							<a class="btn btn-danger btn-xs disabled"><i class="fa fa-trash-o"></i></a>
						<?php
						}
						?>
					<?php 
					}else{ ?>
							<a class="btn btn-primary btn-xs" title="Restaurar Registro" onclick="(restaurarIndividual(<?php echo $filas['idmovimiento'] ?>))"><li class="fa fa-recycle"></li></a>
					<?php
					}
					?>
                </td>
                <td>
                	<?php
                	/////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['movimientos']['modificar'])){
					?>
                        <form action="../consultardetalles/vista.php?n1=movimientos&n2=movimientos&n3=consultarmovimientos" method="post" target="_blank">
							<input type="hidden" name="idmovimiento" value="<?php echo $filas['idmovimiento'] ?>"/>
                            <input type="hidden" name="idreferencia" value="<?php echo $filas['idreferencia'] ?>"/>
                            <input type="hidden" name="tabla" value="<?php echo $filas['tabla'] ?>"/>
							<button type="submit" class="btn btn-success btn-xs" value="" title="Ver detalles"><i class="fa fa-eye"></i></button>
						</form>
                	<?php 
					}else{ ?>
                    	<a class="btn btn-success btn-xs disabled"><i class="fa fa-pencil"></i></a>
					<?php
                    }
					?>
                </td>
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
	
	if ($filas['tipo']=="entrada"){
			$color="#25c274";
			$icono="download";
		}else{
			$color="#D82533";
			$icono="upload";
		}	
?>
	<div class="info-box" style="height:120px;" id="iregistro<?php echo $filas['idmovimiento'] ?>">
    	<span class="info-box-icon bg-red" style="background-color:<?php echo $color; ?> !important; height:120px; padding-top:15px;"><i class="fa fa-<?php echo $icono; ?>"></i></span>
    	<div class="info-box-content">
    		<span class="info-box-text Cconcepto" style="font-size:18px;">
				<span class="checksEliminar">
					<?php /////PERMISOS////////////////
					if (isset($_SESSION['permisos']['movimientos']['eliminar'])){ ?>
						<?php if($filas['idmovimiento']!=0){ ?>
							<input id="registroEliminar<?php echo $filas['idmovimiento'] ?>" type="checkbox" name="registroEliminar[]"  value="<?php echo $filas['idmovimiento'] ?>" class="checkEliminar">
						<?php } ?>
					<?php
					}
					?>
				</span>
			<?php echo $filas['concepto'] ?>
            </span>
    		<span class="info-box-number Ctipo" style="font-weight:normal; color:<?php echo $color; ?>;"><?php echo $filas['tipo'] ?></span>
            <span class="info-box-number Ccomposicion" style="font-weight:normal; font-size:12px;">
				<?php 
				$composicion="";
				if (trim($filas['fechamovimiento'])!=""){
					$composicion=$composicion."Fecha de movimiento: ".$filas['fechamovimiento'];
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
							if (isset($_SESSION['permisos']['movimientos']['eliminar'])){ ?>
								<?php if($filas['idmovimiento']==0 or $filas['idreferencia']!=0){ ?>
										<a class="btn btn-default disabled"><i class="fa fa-trash-o"></i></a>
								<?php }else{ ?>
										<a class="btn btn-default" onclick="(eliminarIndividual(<?php echo $filas['idmovimiento'] ?>))" title="Eliminar"><i class="fa fa-trash-o"></i></a>
								<?php } ?>
							<?php 
							}else{ ?>
								<a class="btn btn-default disabled"><i class="fa fa-trash-o"></i></a>
							<?php
							}
							?>
						<?php 
						}else{?>
								<a class="btn btn-default" onclick="(restaurarIndividual(<?php echo $filas['idmovimiento'] ?>))" title="Restaurar Resgistro"><i class="fa fa-recycle"></i></a>
						<?php 
						}
						?>
					</td>
					<td style=" padding-right:2px;">
						<?php /////PERMISOS////////////////
						if (isset($_SESSION['permisos']['movimientos']['modificar'])){ ?>
							<form action="../consultardetalles/vista.php?n1=movimientos&n2=movimientos&n3=consultarmovimientos" method="post" target="_blank">
								<input type="hidden" name="idmovimiento" value="<?php echo $filas['idmovimiento'] ?>"/>
								<input type="hidden" name="idreferencia" value="<?php echo $filas['idreferencia'] ?>"/>
                                <input type="hidden" name="tabla" value="<?php echo $filas['tabla'] ?>"/>
                                <button type="submit" class="btn btn-default"><i class="fa fa-eye"></i></button>
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