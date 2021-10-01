<?php 
include ("../../seguridad/comprobar_login.php");
/////PERMISOS////////////////
if (!isset($_SESSION['permisos']['detallecotizacionesotros']['acceso'])){
	echo $_SESSION['msgsinacceso'];
	exit;
}
/////FIN  DE PERMISOS////////
include ("../../../librerias/php/variasfunciones.php");
require('../Detallecotizacionotro.class.php');

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


if (isset($_REQUEST['idsucursal']) && $_REQUEST['idsucursal'] !="") {
	if($_REQUEST['idsucursal']!="undefined"){
		$idsucursal = htmlentities($_REQUEST['idsucursal']);
	}else{
		$idsucursal="";
	}
}else{
	$idsucursal="";
}

if (isset($_REQUEST['idcliente']) && $_REQUEST['idcliente'] !="") {
	if($_REQUEST['idcliente']!="undefined"){
		$idcliente = htmlentities($_REQUEST['idcliente']);
	}else{
		$idcliente="";
	}
}else{
	$idcliente="";
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

if (isset($_REQUEST['idcotizacionesotros']) && $_REQUEST['idcotizacionesotros'] !="") {
	if($_REQUEST['idcotizacionesotros']!="undefined"){
		$idcotizacionesotros = htmlentities($_REQUEST['idcotizacionesotros']);
	}else{
		$idcotizacionesotros="";
	}
}else{
	$idcotizacionesotros="";
}

if (isset($_REQUEST['iddetallecotizacionotros']) && $_REQUEST['iddetallecotizacionotros'] !="") {
	if($_REQUEST['iddetallecotizacionotros']!="undefined"){
		$iddetallecotizacionotros = htmlentities($_REQUEST['iddetallecotizacionotros']);
	}else{
		$iddetallecotizacionotros="";
	}
}else{
	$iddetallecotizacionotros="";
}


//CODIGO DE PAGINACION (REQUIERE: "variasfunciones.php")
$inicial = $pg * $cantidadamostrar;
$Odetallecotizacionotro=new Detallecotizacionotro;

if($busqueda == ""){
$resultado=$Odetallecotizacionotro->mostrarA($campoOrden, $orden, $inicial, $cantidadamostrar, $busqueda, $papelera, $idcliente,$idsucursal,$filtrarfecha,$fechainicio,$fechafin,$idcotizacionesotros,$iddetallecotizacionotros);
	$filasTotales=$resultado[1];
	$resultado=$resultado[0];
}
else{
	$resultado=$Odetallecotizacionotro->mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $busqueda, $papelera);
	$filasTotales=$resultado[1];
	$resultado=$resultado[0];
}



if ($resultado=="denegado"){
	echo $_SESSION['msgsinacceso'];
	exit;
}
//$filasTotales = $Odetallecotizacionotro->contar($busqueda, $papelera);
// MOSTRAR LOS REGISTROS SEGUN EL RESULTADO DE LA CONSULTA
function floattostr( $val)
		{
			preg_match( "#^([\+\-]|)([0-9]*)(\.([0-9]*?)|)(0*)$#", trim($val), $o );
			return $o[1].sprintf('%d',$o[2]).($o[3]!='.'?$o[3]:'');
		}



if ($tipoVista=="tabla"){ // Si se ha elegido el tipo tabla ?>
	<div class="box-body table-responsive no-padding"> <!-- /.box-body -->
    	<table class="table table-hover table-bordered">
        	<tr>
        		<th class="checksEliminar" width="10"><input id="seleccionarTodo" type="checkbox"  onclick="seleccionarTodo();"></th>
                <th class="columnaDecorada" style="background:#b15fb8;"></th>
				<th style="display:none;" class="Ciddetallecotizacionotros">ID</th>
                <th class="Cfolio">Folio cotización</th>
                <th class="Cnumeracion">Numeración</th>
				<th class="Cidcliente">Cliente</th>
				<th class="Cfecha">Fecha</th>
				<th class="Ccantidad">Cantidad</th>
				<th class="Cconcepto">Concepto</th>
				<th class="Cunidad">Unidad</th>
				<th class="Cprecio">Precio</th>
				<th class="Cimpuestos">Impuestos</th>
				<th class="Ctotal">Total</th>
				<th class="Cidmodeloimpuestos">Modelo impuestos</th>
				<th class="Cestadopago">Estado pago</th>
				<th class="Cestadofacturacion">Estado facturación</th>
				<th class="Cfactura">Factura</th>
				<th width="40"></th>
                <th width="40"></th>
      		</tr>
	<?php
	while ($filas=mysqli_fetch_array($resultado)) { ?>
      		<tr id="iregistro<?php echo $filas['iddetallecotizacionotros'] ?>">
        		<td class="checksEliminar" width="30" valign="middle">
					<?php /////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['detallecotizacionesotros']['eliminar'])){ ?>
                		<?php if($filas['iddetallecotizacionotros']!=0){ ?>
							<input id="registroEliminar<?php echo $filas['iddetallecotizacionotros'] ?>" type="checkbox" name="registroEliminar[]"  value="<?php echo $filas['iddetallecotizacionotros'] ?>" class="checkEliminar">
                    	<?php } ?>
					<?php 
					}
					?>
            	</td>
                <td class="columnaDecorada" style="background:#b15fb8;"></td>
				<td style="display:none;" class="Ciddetallecotizacionotros"><?php echo $filas['iddetallecotizacionotros']; ?></td>
                <td class="Cfolio"><?php echo $filas['serie'] ."-". $filas['folio']?></td>
                <td class="Cnumeracion"><?php echo $filas['numeroservicio'] ." de ". $filas['totalservicios']?></td>
				<td class="Cidcliente"><?php echo $filas['nombrecliente']; ?></td>
				<?php
				$fechaNfecha=date_create($filas['fecha']);
				$nuevaFecha= date_format($fechaNfecha, 'd/m/Y');
				?>
				<td class="Cfecha"><input value="<?php echo $filas['fecha'];?>" name="fecha<?php echo $filas['iddetallecotizacionotros']; ?>" type="date" class="caja" id="fecha<?php echo $filas['iddetallecotizacionotros']; ?>" onblur="actualizarDato('cantidad<?php echo $filas['iddetallecotizacionotros']; ?>','fecha<?php echo $filas['iddetallecotizacionotros']; ?>','fecha','<?php echo $filas['iddetallecotizacionotros']; ?>','Fecha')" style="color:#0027FF"></td>
				<td class="Ccantidad"  id = "cantidad<?php echo $filas['iddetallecotizacionotros']; ?>"><?php echo $filas['cantidad']; ?></td>
				<td class="Cconcepto"><?php echo $filas['concepto']; ?></td>
				<td class="Cunidad"><?php echo $filas['unidad']; ?></td>
				<td class="Cprecio"> <input value="$<?php echo floattostr($filas['precio']); ?>" name="precio<?php echo $filas['iddetallecotizacionotros']; ?>" type="text" class="caja" id="precio<?php echo $filas['iddetallecotizacionotros']; ?>" onblur="actualizarDato('cantidad<?php echo $filas['iddetallecotizacionotros']; ?>','precio<?php echo $filas['iddetallecotizacionotros']; ?>','precio','<?php echo $filas['iddetallecotizacionotros']; ?>','<?php echo $filas['idmodeloimpuestos']; ?>')" onkeypress="return soloNumeros(event,'precio<?php echo $filas['iddetallecotizacionotros']; ?>');" style="color:#0027FF"></td>
				<td class="Cimpuestos" id = "impuestos<?php echo $filas['iddetallecotizacionotros']; ?>">$<?php echo floattostr($filas['impuestos']); ?></td>
                <td class="Ctotal" id = "total<?php echo $filas['iddetallecotizacionotros']; ?>">$<?php echo floattostr($filas['total']); ?></td>
				<td class="Cidmodeloimpuestos"><?php echo $filas['modeloimpuestos']; ?></td>
				<td class="Cestadopago"><?php echo $filas['estadopago']; ?></td>
				<td class="Cestadofacturacion"><?php echo $filas['estadofacturacion']; ?></td>
				<td class="Cfactura"><?php echo $filas['factura']; ?></td>
        		<td>
					<?php 
					if (!$papelera){
					?>
						<?php /////PERMISOS////////////////
						if (isset($_SESSION['permisos']['detallecotizacionesotros']['eliminar'])){
						?>
							<?php if($filas['iddetallecotizacionotros']==0){ ?>
								<a class="btn btn-danger btn-xs disabled"><i class="fa fa-trash-o"></i></a>
							<?php }else{ ?>
								<a class="btn btn-danger btn-xs" title="Eliminar" onclick="(eliminarIndividual(<?php echo $filas['iddetallecotizacionotros'] ?>))"><li class="fa fa-trash"></li></a>
							<?php }?>
						<?php 
						}else{ ?>
							<a class="btn btn-danger btn-xs disabled"><i class="fa fa-trash-o"></i></a>
						<?php
						}
						?>
					<?php 
					}else{ ?>
							<a class="btn btn-primary btn-xs" title="Restaurar Registro" onclick="(restaurarIndividual(<?php echo $filas['iddetallecotizacionotros'] ?>))"><li class="fa fa-recycle"></li></a>
					<?php
					}
					?>
                </td>
                <td>
                	<?php
                	/////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['detallecotizacionesotros']['modificar'])){
					?>
						<form action="../modificar/actualizar.php?n1=ventas&n2=cotizacionesotros&n3=consultardetallecotizacionesotros" method="post">
                			<input type="hidden" name="id" value="<?php echo $filas['iddetallecotizacionotros'] ?>"/>
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
	<div class="info-box" style="height:120px;" id="iregistro<?php echo $filas['iddetallecotizacionotros'] ?>">
    	<span class="info-box-icon bg-red" style="background-color:#b15fb8 !important; height:120px; padding-top:15px;"><i class="fa fa-magic"></i></span>
    	<div class="info-box-content">
    		<span class="info-box-text Cfecha" style="font-size:18px;">
				<span class="checksEliminar">
					<?php /////PERMISOS////////////////
					if (isset($_SESSION['permisos']['detallecotizacionesotros']['eliminar'])){ ?>
						<?php if($filas['iddetallecotizacionotros']!=0){ ?>
							<input id="registroEliminar<?php echo $filas['iddetallecotizacionotros'] ?>" type="checkbox" name="registroEliminar[]"  value="<?php echo $filas['iddetallecotizacionotros'] ?>" class="checkEliminar">
						<?php } ?>
					<?php
					}
					?>
				</span>
			<?php echo $filas['fecha'] ?>
            </span>
    		<span class="info-box-number Cidcliente" style="font-weight:normal; color:#b15fb8;"><?php echo $filas['idcliente'] ?></span>
            <span class="info-box-number Ccomposicion" style="font-weight:normal; font-size:12px;">
				<?php 
				$composicion="";
				if (trim($filas['total'])!=""){
					$composicion=$composicion.", ".$filas['total'];
				}
				if (trim($filas['estadopago'])!=""){
					$composicion=$composicion.", ".$filas['estadopago'];
				}
				if (trim($filas['estadofacturacion'])!=""){
					$composicion=$composicion.", ".$filas['estadofacturacion'];
				}
				if (trim($filas['factura'])!=""){
					$composicion=$composicion.", ".$filas['factura'];
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
							if (isset($_SESSION['permisos']['detallecotizacionesotros']['eliminar'])){ ?>
								<?php if($filas['iddetallecotizacionotros']==0){ ?>
									<a class="btn btn-default disabled"><i class="fa fa-trash-o"></i></a>
								<?php }else{ ?>
									<a class="btn btn-default" onclick="(eliminarIndividual(<?php echo $filas['iddetallecotizacionotros'] ?>))" title="Eliminar"><i class="fa fa-trash-o"></i></a>
								<?php } ?>
							<?php 
							}else{ ?>
								<a class="btn btn-default disabled"><i class="fa fa-trash-o"></i></a>
							<?php
							}
							?>
						<?php 
						}else{?>
								<a class="btn btn-default" onclick="(restaurarIndividual(<?php echo $filas['iddetallecotizacionotros'] ?>))" title="Restaurar Resgistro"><i class="fa fa-recycle"></i></a>
						<?php 
						}
						?>
					</td>
					<td style=" padding-right:2px;">
						<?php /////PERMISOS////////////////
						if (isset($_SESSION['permisos']['detallecotizacionesotros']['modificar'])){ ?>
							<form action="../modificar/actualizar.php?n1=ventas&n2=cotizacionesotros&n3=consultardetallecotizacionesotros" method="post">
								<input type="hidden" name="id" value="<?php echo $filas['iddetallecotizacionotros'] ?>"/>
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