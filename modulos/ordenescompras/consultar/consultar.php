<?php 
include ("../../seguridad/comprobar_login.php");
/////PERMISOS////////////////
if (!isset($_SESSION['permisos']['compras']['acceso'])){
	echo $_SESSION['msgsinacceso'];
	exit;
}
/////FIN  DE PERMISOS////////
include ("../../../librerias/php/variasfunciones.php");
require('../Compra.class.php');

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
		$campoOrden="fecha";
	}
}else{
	$campoOrden="fecha";
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

if (isset($_REQUEST['estado']) && $_REQUEST['estado'] !="") {
	$estado = htmlentities($_REQUEST['estado']);
	$estado=trim($estado);
}else{
	$estado = "TODOS";
}

if (isset($_REQUEST['idsucursal']) && $_REQUEST['idsucursal'] !="") {
	$idsucursal = htmlentities($_REQUEST['idsucursal']);
	$idsucursal=trim($idsucursal);
}else{
	$idsucursal = "TODOS";
}

if (isset($_REQUEST['idproveedor']) && $_REQUEST['idproveedor'] !="") {
	$idproveedor = htmlentities($_REQUEST['idproveedor']);
	$idproveedor=trim($idproveedor);
}else{
	$idproveedor = "TODOS";
}

$consultaExtra="";
if ($filtrarfecha=="SI"){
	$consultaExtra=$consultaExtra." AND (compras.fecha >= '$fechainicio' AND  compras.fecha <= '$fechafin')";
}
if ($estado!="TODAS"){
	$consultaExtra=$consultaExtra." AND compras.estado='$estado'";
}
if ($idsucursal!="TODAS"){
	$consultaExtra=$consultaExtra." AND compras.idsucursal='$idsucursal'";
}
if ($idproveedor!="TODOS"){
	$consultaExtra=$consultaExtra." AND compras.idproveedor='$idproveedor'";
}


//CODIGO DE PAGINACION (REQUIERE: "variasfunciones.php")
$inicial = $pg * $cantidadamostrar;
$Ocompra=new Compra;
$resultado=$Ocompra->mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $busqueda, $papelera, $consultaExtra);
$filasTotales=$resultado[1];
$resultado=$resultado[0];
	
if ($resultado=="denegado"){
	echo $_SESSION['msgsinacceso'];
	exit;
}
// MOSTRAR LOS REGISTROS SEGUN EL RESULTADO DE LA CONSULTA




if ($tipoVista=="tabla"){ // Si se ha elegido el tipo tabla ?>
	<div class="box-body table-responsive no-padding"> <!-- /.box-body -->
    	<table class="table table-hover table-bordered">
        	<tr>
        		<th class="checksEliminar" width="10"><input id="seleccionarTodo" type="checkbox"  onclick="seleccionarTodo();"></th>
                <th class="columnaDecorada" style="background:#ffaf09;"></th>
				<th class="Cidcompra">ID</th>
				<th class="Cfecha">Fecha de orden</th>
				<th class="Cidempleado">Empleado</th>
				<th class="Ccomentarios">Comentarios</th>
				<th class="Cestado">Estado</th>
				<th class="Cmonto">Monto</th>
				<th class="Cidsucursal">Sucursal</th>
				<th class="Cidproveedor">Proveedor</th>
				<th width="40"></th>
				<th width="40"></th>
                <th width="40"></th>
      		</tr>
	<?php
	while ($filas=mysqli_fetch_array($resultado)) {
		$estadoCompra=$filas['estado'];
		$colorEstado="#ffaf09";
		if ($estadoCompra=="Autorizada para recepcion"){
			$colorEstado="#096";
		}
		$fechaenvio="";
		if ($estadoCompra=="Enviada"){
			$colorEstado="#F06";
			
			$fechaNfecha2=date_create($filas['fechaenvio']);
			$fechaenvio= date_format($fechaNfecha2, 'd/m/Y H:i');
		}
		if ($estadoCompra=="Recepcionada"){
			$colorEstado="#06C";
		}
	?>
      		<tr id="iregistro<?php echo $filas['idcompra'] ?>" ondblclick="abrirModal(<?php echo $filas['idcompra'] ?>);">
        		<td class="checksEliminar" width="30" valign="middle">
					<?php /////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['compras']['eliminar'])){ ?>
                		<?php if($filas['idcompra']!=0){ ?>
							<input id="registroEliminar<?php echo $filas['idcompra'] ?>" type="checkbox" name="registroEliminar[]"  value="<?php echo $filas['idcompra'] ?>" class="checkEliminar">
                    	<?php } ?>
					<?php 
					}
					?>
            	</td>
                <td class="columnaDecorada" style="background:#ffaf09;"></td>
				<td class="Cidcompra"><?php echo $filas['idcompra']; ?></td>
				<?php
				$fechaNfecha=date_create($filas['fecha']);
				$nuevaFecha= date_format($fechaNfecha, 'd/m/Y');
				?>
				<td class="Cfecha"><?php echo $nuevaFecha; ?></td>
				<td class="Cidempleado"><?php echo $filas['nombreempleados']; ?></td>
				<td class="Ccomentarios"><?php echo $filas['comentarios']; ?></td>
				<td class="Cestado"><span class="badge" style="background:<?php echo $colorEstado?>"><?php echo $filas['estado'] ?> <small><i><?php echo $fechaenvio?></i></small></span></td>
				<td class="Cmonto"><?php echo $filas['monto']; ?></td>
				<td class="Cidsucursal"><?php echo $filas['nombresucursales']; ?></td>
				<td class="Cidproveedor"><b><?php echo $filas['nombreproveedores']; ?></b></td>
				<td>
                	<?php
                	/////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['email']['guardar'])){
					?>
						<form action="../../email/nuevo/nuevoProveedor.php" method="post">
                    		<input type="hidden" name="email" value="kenzzo_ba@gmail.com"/>
                    		<input type="hidden" name="idproveedor" value="<?php echo $filas['idproveedor'] ?>"/>
                    		<input type="hidden" name="idcompra" value="<?php echo $filas['idcompra'] ?>"/>
                            <button type="submit" class="btn btn-default btn-xs" title="Enviar al proveedor"><i class="fa fa-envelope-o" style="color:#939;"></i></button>
                        </form>
                	<?php 
					}else{ ?>
                    	<a class="btn btn-default btn-xs disabled"><i class="fa fa-envelope-o"></i></a>
					<?php
                    }
					?>
                </td>
        		<td>
					<?php 
					if (!$papelera){
					?>
						<?php /////PERMISOS////////////////
						if (isset($_SESSION['permisos']['compras']['eliminar']) and $filas['estado']=='Pendiente'){
						?>
							<?php if($filas['idcompra']==0){ ?>
								<a class="btn btn-danger btn-xs disabled"><i class="fa fa-trash-o"></i></a>
							<?php }else{ ?>
								<a class="btn btn-danger btn-xs" title="Eliminar" onclick="(eliminarIndividual(<?php echo $filas['idcompra'] ?>))"><li class="fa fa-trash"></li></a>
							<?php }?>
						<?php 
						}else{ ?>
							<a class="btn btn-danger btn-xs disabled"><i class="fa fa-trash-o"></i></a>
						<?php
						}
						?>
					<?php 
					}else{ ?>
							<a class="btn btn-primary btn-xs" title="Restaurar Registro" onclick="(restaurarIndividual(<?php echo $filas['idcompra'] ?>))"><li class="fa fa-recycle"></li></a>
					<?php
					}
					?>
                </td>
                <td>
                	<?php
                	/////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['compras']['modificar'])){
					?>
						<form action="../modificar/actualizar.php?n1=compras&n2=consultarcompras" method="post">
                			<input type="hidden" name="id" value="<?php echo $filas['idcompra'] ?>"/>
                            <button type="submit" class="btn btn-success btn-xs" value="" title="Modificar"><li class="fa fa-pencil"></li></button>
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
?>
	<div class="info-box" style="height:120px;" id="iregistro<?php echo $filas['idcompra'] ?>">
    	<span class="info-box-icon bg-red" style="background-color:#ffaf09 !important; height:120px; padding-top:15px;"><i class="fa fa-list-ol"></i></span>
    	<div class="info-box-content">
    		<span class="info-box-text Cidsucursal" style="font-size:18px;">
				<span class="checksEliminar">
					<?php /////PERMISOS////////////////
					if (isset($_SESSION['permisos']['compras']['eliminar'])){ ?>
						<?php if($filas['idcompra']!=0){ ?>
							<input id="registroEliminar<?php echo $filas['idcompra'] ?>" type="checkbox" name="registroEliminar[]"  value="<?php echo $filas['idcompra'] ?>" class="checkEliminar">
						<?php } ?>
					<?php
					}
					?>
				</span>
			<?php echo $filas['idsucursal'] ?>
            </span>
    		<span class="info-box-number Cidproveedor" style="font-weight:normal; color:#ffaf09;"><?php echo $filas['idproveedor'] ?></span>
            <span class="info-box-number Ccomposicion" style="font-weight:normal; font-size:12px;">
				<?php 
				$composicion="";
				if (trim($filas['fecha'])!=""){
					$composicion=$composicion."Fecha: ".$filas['fecha'];
				}
				if (trim($filas['estado'])!=""){
					$composicion=$composicion." | Estatus: ".$filas['estado'];
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
							if (isset($_SESSION['permisos']['compras']['eliminar'])){ ?>
								<?php if($filas['idcompra']==0){ ?>
									<a class="btn btn-default disabled"><i class="fa fa-trash-o"></i></a>
								<?php }else{ ?>
									<a class="btn btn-default" onclick="(eliminarIndividual(<?php echo $filas['idcompra'] ?>))" title="Eliminar"><i class="fa fa-trash-o"></i></a>
								<?php } ?>
							<?php 
							}else{ ?>
								<a class="btn btn-default disabled"><i class="fa fa-trash-o"></i></a>
							<?php
							}
							?>
						<?php 
						}else{?>
								<a class="btn btn-default" onclick="(restaurarIndividual(<?php echo $filas['idcompra'] ?>))" title="Restaurar Resgistro"><i class="fa fa-recycle"></i></a>
						<?php 
						}
						?>
					</td>
					<td style=" padding-right:2px;">
						<?php /////PERMISOS////////////////
						if (isset($_SESSION['permisos']['compras']['modificar'])){ ?>
							<form action="../modificar/actualizar.php?n1=compras&n2=consultarcompras" method="post">
								<input type="hidden" name="id" value="<?php echo $filas['idcompra'] ?>"/>
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