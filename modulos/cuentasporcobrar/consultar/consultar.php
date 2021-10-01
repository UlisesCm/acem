<?php 
include ("../../seguridad/comprobar_login.php");
/////PERMISOS////////////////
if (!isset($_SESSION['permisos']['cuentasporcobrar']['acceso'])){
	echo $_SESSION['msgsinacceso'];
	exit;
}
/////FIN  DE PERMISOS////////
include ("../../../librerias/php/variasfunciones.php");
require('../../cuentasporcobrar/CuentaPorCobrar.class.php');

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
		$campoOrden="idcotizacionproducto";
	}
}else{
	$campoOrden="idcotizacionproducto";
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


if (isset($_REQUEST['idsucursal'])){
	$idsucursal=htmlentities(trim($_REQUEST['idsucursal']));
	$idsucursal=trim($idsucursal);	
}else{
	$idsucursal="TODAS";
}

if (isset($_REQUEST['idcliente'])){
	$idcliente=htmlentities(trim($_REQUEST['idcliente']));
	$idcliente=trim($idcliente);	
}else{
	$idcliente="TODOS";
}

if (isset($_REQUEST['folio'])){
	$folio=htmlentities(trim($_REQUEST['folio']));
	$folio=trim($folio);	
}else{
	$folio="";
}

if (isset($_REQUEST['serie'])){
	$serie=htmlentities(trim($_REQUEST['serie']));
	$serie=trim($serie);	
}else{
	$serie="";
}

if (isset($_REQUEST['tiposerie'])){
	$tiposerie=htmlentities(trim($_REQUEST['tiposerie']));
	$tiposerie=trim($tiposerie);	
}else{
	$tiposerie="";
}

if (isset($_REQUEST['estadopago'])){
	$estadopago=htmlentities(trim($_REQUEST['estadopago']));
	$estadopago=trim($estadopago);	
}else{
	$estadopago="";
}


/*if (isset($_REQUEST['tipo'])){
	$tipo=htmlentities(trim($_REQUEST['tipo']));
	$tipo=trim($tipo);	
}else{
	$tipo="";
}*/
$tipo="";

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


//CODIGO DE PAGINACION (REQUIERE: "variasfunciones.php")
$inicial = $pg * $cantidadamostrar;
$Oventa=new Venta;
$resultado=$Oventa->mostrarProductos($campoOrden, $orden, $inicial, $cantidadamostrar, $busqueda, $papelera, $idcliente,$idsucursal,$serie,$folio,$tiposerie,$tipo,$filtrarfecha,$fechainicio,$fechafin,$estadopago,$excel="");

$resultado2=$Oventa->mostrarOtros($campoOrden, $orden, $inicial, $cantidadamostrar, $busqueda, $papelera, $idcliente,$idsucursal,$serie,$folio,$tiposerie,$tipo,$filtrarfecha,$fechainicio,$fechafin,$estadopago,$excel="");

if ($resultado=="denegado"){
	echo $_SESSION['msgsinacceso'];
	exit;
}
//recibir arreglos de consultas
$filasTotales=$resultado[1];
$resultado=$resultado[0];

$filasTotales= $filasTotales + $resultado2[1];
$resultado2=$resultado2[0];


// MOSTRAR LOS REGISTROS SEGUN EL RESULTADO DE LA CONSULTA
?>
	 <h2 class="page-header">&nbsp;&nbsp; <i class="fa fa-shopping-cart"></i> Ventas</h2> 
     
	<div class="box-body table-responsive no-padding"> <!-- /.box-body -->
    	<table class="table table-hover table-bordered">
        	<tr>
        		
                <th class="columnaDecorada" style="background:#0c63ba;"></th>
				<th class="Cidventa" style="display:none">ID</th>
                <th class="Cidcliente">Sucursal</th>
				<th class="Cfolio">Folio</th>
                <th class="Ctipo">Tipo</th>
                <th class="Cfecha">Fecha venta</th>
                <th class="Cidcliente">Cliente</th>
                <th class="Cusuario">Usuario</th>
                <th class="Cvendedor">Vendedor</th>
                <th class="Ctipoentrega" >Tipo entrega</th>
                <th class="Ctotal" >Total</th>
                <th class="Cpagado" >Pagado</th>
                <th class="Cdiferencia" >Diferencia</th>
                <th class="Cestadopago" >Estado pago</th>
                <th class="Cestadocredito" >Estado crédito</th>
                <th width="40"></th>
                <th width="40"></th>
                <th width="40"></th>
                <th width="40"></th>
      		</tr>
            
     <!--CARGAR RESULTADOS DE PRODUCTOS-->
	<?php
	while ($filas=mysqli_fetch_array($resultado)) { 
		$totalpagado=$Oventa->obtenerPagosVentas($filas['idcotizacionproducto'],'cotizacionesproductos');
		//$totalDevoluciones=$Oventa->obtenerDevoluciones($filas['idcotizacionproducto']);
		$fechaLiquidacion=$Oventa->obtenerFechaLiquidacion($filas['idcotizacionproducto'],'cotizacionesproductos');
		$total=$filas['total'];
		//$totaltotal=$total;
		//$total=$total-$totalDevoluciones;
		$diferencia=$total-$totalpagado;
	?>
      		<tr id="iregistro<?php echo $filas['idcotizacionproducto'] ?>">
        		
                <td class="columnaDecorada" style="background:#0c63ba;"></td>
				<td class="Cidventa" style="display:none"><?php echo $filas['idcotizacionproducto']; ?></td>
                <td class="Cidalmacen" ><?php echo $filas['nombresucursal']; ?></td>
                <td class="Cfolio"><?php echo $filas['serie'] ."-". $filas['folio']; ?></td>
                <td class="Ctipo"><?php echo "PRODUCTOS" ?></td>
				<?php
				$fechaNfecha=date_create($filas['fecha']);
				$nuevaFecha= date_format($fechaNfecha, 'd/m/Y');
				?>
                <td class="Cfecha"><?php echo $nuevaFecha; ?></td>
                <td class="Cidcliente"><?php echo $filas['cliente']." (".$filas['rfccliente'].")"; ?></td>
                <td class="Cidusuario"><?php echo $filas['usuario']; ?></td>
				<td class="Cidempleado"><?php echo $filas['vendedor']; ?></td>
                <td class="Ctipoentrega"><?php echo $filas['enviaradomicilio']; ?></td>
				<td class="Cidempleado">
                <span class="badge" style="background-color:#06F"><?php echo number_format($total,2); ?></span>
                </td>
                <td class="Ctotal"><span class="badge" style="background-color:#096"><?php echo number_format($totalpagado,2); ?></span></td>
                <td class="Cdiferencia"><span class="badge" style="background-color:#C33"><?php echo number_format($diferencia,2); ?></span></td>
                <td class="Cestado" style="font-style:italic; font-size:10px">
				<?php
                if ($filas['estadopago']=="PAGADO"){
					echo $filas['estadopago'];
					
					echo " / Liquidada el ".$fechaLiquidacion;
				}else{
					echo $filas['estadopago'];  
				}
				?>
                </td>
                
                <td class="Cestadocredito" style="font-style:italic; font-size:10px">
				<?php
                if ($filas['estadocredito']=="AUTORIZADO"){
					echo $filas['estadocredito']." / ".$filas['descripcioncredito'];
				}else{
					echo $filas['estadocredito'];  
				}
				?>
                </td>
        		
                <td>
                	<?php
                	/////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['pagos']['guardar'])){
					?>
						<form action="../../pagos/nuevo/nuevo.php?n1=facturacionycobranza&n2=cuentasporcobrar" method="post" target="_blank">
                            <input type="hidden" name="idventaajuste" value="0"/>
                            <input type="hidden" name="idcliente" value="<?php echo $filas['idcliente'] ?>"/>
                            <input type="hidden" name="idreferencia" value="<?php echo $filas['idcotizacionproducto'] ?>"/>
                            <input type="hidden" name="tablareferencia" value="<?php echo "cotizacionesproductos" ?>"/>
                            <input type="hidden" name="tipo" value="PRODUCTOS"/>
                            <button type="submit" class="btn btn-success btn-xs" value="" title="Registrar Pago"><li class="fa fa-clipboard"></li></button>
                		</form>
                	<?php 
					}else{ ?>
                    	<a class="btn btn-success btn-xs disabled"><i class="fa fa-pencil"></i></a>
					<?php
                    }
					?>
                </td>
                
                <td style=" padding-right:2px;">
						<?php /////PERMISOS////////////////
						if (isset($_SESSION['permisos']['pagos']['cambiarEstatus'])){ ?>
							<form action="../../pagos/nuevoautorizarcredito/nuevo.php?n1=facturacionycobranza&n2=cuentasporcobrar" method="post" target="_blank">
								<input type="hidden" name="idventaajuste" value="0"/>
                                <input type="hidden" name="idcliente" value="<?php echo $filas['idcliente'] ?>"/>
                                <input type="hidden" name="idreferencia" value="<?php echo $filas['idcotizacionproducto'] ?>"/>
                                <input type="hidden" name="tablareferencia" value="<?php echo "cotizacionesproductos" ?>"/>
                                <input type="hidden" name="tipo" value="PRODUCTOS"/>
								<button type="submit" class="btn btn-warning btn-xs" title="Cambiar estatus de crédito"><i class="fa fa-flag"></i></button>
							</form>
						<?php 
						}else{ ?>
							<a class="btn btn-warning btn-xs disabled"><i class="fa fa-flag"></i></a>
                        <?php
                        }
						?>
                </td>
                
                <td style=" padding-right:2px;">
						<?php /////PERMISOS////////////////
						if (isset($_SESSION['permisos']['pagos']['modificar'])){
							if ($filas['estadofacturacion']=="FACTURADO"){
								
						?>
                        	<a class="btn btn-success btn-xs" title="Facturada pero no hay archivos adjuntos"><i class="fa fa-exclamation-triangle text-yellow"></i></a>
                        <?php
                        		
							}else{
						?>	
                        	<a class="btn btn-danger btn-xs" title="No facturada"><i class="fa fa-exclamation-triangle"></i></a>
						<?php
                            }
						?>
						<?php 
						}else{ ?>
							<a class="btn btn-default disabled btn-xs"><i class="fa fa-file-pdf-o"></i></a>
                        <?php
                        }
						?>
                </td>
                <td>
                    <form target="_blank" action="../../detallecotizacionesproductos/consultar/vista.php?n1=ventas&n2=cotizacionesproductos&n3=consultarcotizacionesproductos" method="post">
                			<input type="hidden" name="idcotizacionproducto" value="<?php echo $filas['idcotizacionproducto'] ?>"/>
                            <button type="submit" class="btn btn-info btn-xs" value="" title="Detalles"><li class="fa fa-list"></li></button>
                		</form>
                	<!--<a href="../../ventas/consultardetalles/vista.php?idreferencia=<?php echo $filas['idcotizacionproducto'] ?>" target="_blank" title="Ver detalles" class="btn btn-info btn-xs"><i class="fa fa-eye"></i></a>-->
                </td>
      		</tr>
    <?php
	}//Fin de while si es tabla ?>
    
     <!--CARGAR RESULTADOS DE OTROS-->
	<?php
	while ($filas=mysqli_fetch_array($resultado2)) { 
		$totalpagado=$Oventa->obtenerPagosVentas($filas['iddetallecotizacionotros'],'detallecotizacionesotros');
		//$totalDevoluciones=$Oventa->obtenerDevoluciones($filas['idcotizacionproducto']);
		$fechaLiquidacion=$Oventa->obtenerFechaLiquidacion($filas['iddetallecotizacionotros'],'detallecotizacionesotros');
		$total=$filas['total'];
		//$totaltotal=$total;
		//$total=$total-$totalDevoluciones;
		$diferencia=$total-$totalpagado;
	?>
      		<tr id="iregistro<?php echo $filas['iddetallecotizacionotros'] ?>">
        		
                <td class="columnaDecorada" style="background:#0c63ba;"></td>
				<td class="Cidventa" style="display:none"><?php echo $filas['iddetallecotizacionotros']; ?></td>
                <td class="Cidalmacen" ><?php echo $filas['nombresucursal']; ?></td>
                <td class="Cfolio"><?php echo $filas['serie'] ."-". $filas['folio']; ?></td>
                <td class="Ctipo"><?php echo "OTROS" ?></td>
				<?php
				$fechaNfecha=date_create($filas['fecha']);
				$nuevaFecha= date_format($fechaNfecha, 'd/m/Y');
				?>
                <td class="Cfecha"><?php echo $nuevaFecha; ?></td>
                <td class="Cidcliente"><?php echo $filas['cliente']." (".$filas['rfccliente'].")"; ?></td>
                <td class="Cidusuario"><?php echo $filas['usuario']; ?></td>
				<td class="Cidempleado"><?php echo $filas['vendedor']; ?></td>
                <td class="Ctipoentrega"><?php echo "NO APLICA" ?></td>
				<td class="Cidempleado">
                <span class="badge" style="background-color:#06F"><?php echo number_format($total,2); ?></span>
                </td>
                <td class="Ctotal"><span class="badge" style="background-color:#096"><?php echo number_format($totalpagado,2); ?></span></td>
                <td class="Cdiferencia"><span class="badge" style="background-color:#C33"><?php echo number_format($diferencia,2); ?></span></td>
                <td class="Cestado" style="font-style:italic; font-size:10px">
				<?php
                if ($filas['estadopago']=="PAGADO"){
					echo $filas['estadopago'];
					
					echo " / Liquidada el ".$fechaLiquidacion;
				}else{
					echo $filas['estadopago'];  
				}
				?>
                </td>
				<td class="Cestadocredito" style="font-style:italic; font-size:10px">NO APLICA</td>
        		
                <td>
                	<?php
                	/////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['pagos']['guardar'])){
					?>
						<form action="../../pagos/nuevo/nuevo.php?n1=facturacionycobranza&n2=cuentasporcobrar" method="post" target="_blank">
                            <input type="hidden" name="idventaajuste" value="0"/>
                            <input type="hidden" name="idcliente" value="<?php echo $filas['idcliente'] ?>"/>
                            <input type="hidden" name="idreferencia" value="<?php echo $filas['iddetallecotizacionotros'] ?>"/>
                            <input type="hidden" name="tablareferencia" value="<?php echo "detallecotizacionesotros" ?>"/>
                            <input type="hidden" name="tipo" value="OTROS"/>
                            <button type="submit" class="btn btn-success btn-xs" value="" title="Registrar Pago"><li class="fa fa-clipboard"></li></button>
                		</form>
                	<?php 
					}else{ ?>
                    	<a class="btn btn-success btn-xs disabled"><i class="fa fa-pencil"></i></a>
					<?php
                    }
					?>
                </td>
                
                <td style=" padding-right:2px;">
						
							<a class="btn btn-warning btn-xs disabled"><i class="fa fa-flag"></i></a>
                       
                </td>
                
                <td style=" padding-right:2px;">
						<?php /////PERMISOS////////////////
						if (isset($_SESSION['permisos']['pagos']['modificar'])){
							if ($filas['estadofacturacion']=="FACTURADO"){
								
						?>
                        	<a class="btn btn-success btn-xs" title="Facturada pero no hay archivos adjuntos"><i class="fa fa-exclamation-triangle text-yellow"></i></a>
                        <?php
                        		
							}else{
						?>	
                        	<a class="btn btn-danger btn-xs" title="No facturada"><i class="fa fa-exclamation-triangle"></i></a>
						<?php
                            }
						?>
						<?php 
						}else{ ?>
							<a class="btn btn-default disabled btn-xs"><i class="fa fa-file-pdf-o"></i></a>
                        <?php
                        }
						?>
                </td>
                <td>
                    <form target="_blank" action="../../detallecotizacionesotros/consultar/vista.php?n1=ventas&n2=cotizacionesotros&n3=consultarcotizacionesotros" method="post">
                			<input type="hidden" name="iddetallecotizacionotros" value="<?php echo $filas['iddetallecotizacionotros'] ?>"/>
                            <button type="submit" class="btn btn-info btn-xs" value="" title="Detalles"><li class="fa fa-list"></li></button>
                		</form>
                	<!--<a href="../../ventas/consultardetalles/vista.php?idreferencia=<?php echo $filas['iddetallecotizacionotros'] ?>" target="_blank" title="Ver detalles" class="btn btn-info btn-xs"><i class="fa fa-eye"></i></a>-->
                </td>
      		</tr>
    <?php
	}//Fin de while si es tabla ?>
    
		</table>
	</div><!-- /.box-body -->
    
    
    
    


</div>
<?php 
paginar($pg, $cantidadamostrar, $filasTotales, $campoOrden, $orden, $busqueda, $tipoVista);
//FIN DEL CODIGO DE PAGINACION
if(mysqli_num_rows($resultado)==0 && mysqli_num_rows($resultado2)==0){
	include("../../../componentes/mensaje_no_hay_registros.php");
}
?>


<?php
/*/CODIGO DE PAGINACION (REQUIERE: "variasfunciones.php")
$inicial = $pg * $cantidadamostrar;
$OventaAjuste =new Venta;
$resultadoAjuste =$OventaAjuste->mostrarB($campoOrden, $orden, $inicial, $cantidadamostrar, $busqueda, $papelera, $idalmacen, $idcliente, $ticket, $tipo);
if ($resultadoAjuste =="denegado"){
	echo $_SESSION['msgsinacceso'];
	exit;
}
//$filasTotalesAjuste = $OventaAjuste ->contarB($busqueda, $papelera, $idalmacen, $idcliente, $ticket, $tipo);
// MOSTRAR LOS REGISTROS SEGUN EL RESULTADO DE LA CONSULTA
?>
	<h2 class="page-header">&nbsp;&nbsp; <i class="fa fa-cart-plus"></i> Ventas de Ajuste</h2>
    
	<div class="box-body table-responsive no-padding"> <!-- /.box-body -->
    	<table class="table table-hover table-bordered">
        	<tr>
        		
                <th class="columnaDecorada" style="background:#F90;"></th>
				<th class="Cidventa" >ID</th>
                <th class="Cfecha">Fecha</th>
				<th class="Chora" >Fecha límite</th>
                <th class="Cidcliente">Cliente</th>
                <th class="Ctotal">Total</th>
                <th class="Ctotal">Pagado</th>
                <th class="Ctotal">Diferencia</th>
                <th class="Cdescripcion">Descripción</th>
                <th class="Cestado">Estatus</th>
                <th width="40"></th>
                <th width="40"></th>
                <th width="40"></th>
                <th width="40"></th>
      		</tr>
	<?php
	while ($filas=mysqli_fetch_array($resultadoAjuste)) { 
		$totalpagado=$Oventa->obtenerPagosAjuste($filas['idventaajuste']);
		$total=$filas['total'];
		$diferencia=$total-$totalpagado;
	?>
      		<tr id="iregistro<?php echo $filas['idventaajuste'] ?>">
        		
                <td class="columnaDecorada" style="background:#F90;"></td>
				<td class="Cidventaajuste" ><?php echo $filas['idventaajuste']; ?></td>
				<?php
				$fechaNfecha=date_create($filas['fecha']);
				$nuevaFecha= date_format($fechaNfecha, 'd/m/Y');
				$fechaNfecha2=date_create($filas['fechalimite']);
				$nuevaFecha2= date_format($fechaNfecha2, 'd/m/Y');
				?>
				<td class="Cfecha"><?php echo $nuevaFecha; ?></td>
                <td class="Cfechalimite"><?php echo $nuevaFecha2; ?></td>
                <td class="Cidcliente"><?php echo $filas['nombreclientes']; ?></td>
                <td class="Cidempleado"><span class="badge" style="background-color:#06F"><?php echo number_format($total,2); ?></span></td>
                <td class="Cidempleado"><span class="badge" style="background-color:#096"><?php echo number_format($totalpagado,2); ?></span></td>
                <td class="Cidempleado"><span class="badge" style="background-color:#C33"><?php echo number_format($diferencia,2); ?></span></td>
                <td class="Cdescripcion"><?php echo $filas['descripcion']; ?></td>
                <td class="Cestado"><?php echo $filas['estado']; ?></td>
        		
                <td>
                	<?php
                	/////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['pagos']['guardar'])){
					?>
						<form action="../../pagos/nuevo/nuevo.php?n1=ventas&n2=consultarventas" method="post" target="_blank">
                			<input type="hidden" name="idventaajuste" value="<?php echo $filas['idventaajuste'] ?>"/>
                            <input type="hidden" name="idcliente" value="<?php echo $filas['idcliente'] ?>"/>
                            <input type="hidden" name="idventa" value="0"/>
                            <button type="submit" class="btn btn-success btn-xs" value="" title="Registrar Pago"><li class="fa fa-clipboard"></li></button>
                		</form>
                	<?php 
					}else{ ?>
                    	<a class="btn btn-success btn-xs disabled"><i class="fa fa-pencil"></i></a>
					<?php
                    }
					?>
                </td>
                
                <td style=" padding-right:2px;">
						<?php /////PERMISOS////////////////
						if (isset($_SESSION['permisos']['pagos']['modificar'])){ ?>
							<form action="../../ventasajuste/modificarEstatus/actualizar.php?n1=ventas&n2=consultarventas" method="post">
								<input type="hidden" name="id" value="<?php echo $filas['idventaajuste'] ?>"/>
								<button type="submit" class="btn btn-warning btn-xs" title="Cambiar Estatus"><i class="fa fa-flag"></i></button>
							</form>
						<?php 
						}else{ ?>
							<a class="btn btn-default disabled"><i class="fa fa-flag"></i></a>
                        <?php
                        }
						?>
                </td>
                
                <td style=" padding-right:2px;">
						<?php /////PERMISOS////////////////
						if (isset($_SESSION['permisos']['pagos']['modificar'])){
							if ($filas['facturada']=="si"){
								if ($filas['archivoFactura']!=""){
						?>
                        	<form action="descargarFacturaAjuste.php" method="post">
                            <input type="hidden" name="f" value="<?php echo $filas['archivoFactura']; ?>"/>
                            <button type="submit" class="btn btn-success btn-xs" title="Descargar Archivos de Factura"><i class="fa fa-file-pdf-o"></i></button>
                            </form>
                        <?php
                        		}else{
						?>
                        	<a class="btn btn-success btn-xs" title="Facturada pero no hay archivos adjuntos"><i class="fa fa-exclamation-triangle text-yellow"></i></a>
                        <?php
                        		}
							}else{
						?>	
                        	<a class="btn btn-danger btn-xs" title="No facturada"><i class="fa fa-exclamation-triangle"></i></a>
						<?php
                            }
						?>
						<?php 
						}else{ ?>
							<a class="btn btn-default disabled btn-xs"><i class="fa fa-file-pdf-o"></i></a>
                        <?php
                        }
						?>
                </td>
                
                <td style=" padding-right:2px;">
						<?php 
							if ($filas['estado']=="Liquidada"){
								if ($filas['diferenciaCredito']!=0){
									if ($filas['archivoNota']!=""){
						?>
                        	<form action="descargarNotaAjuste.php" method="post">
                            <input type="hidden" name="f" value="<?php echo $filas['archivoNota']; ?>"/>
                            <button type="submit" class="btn btn-success btn-xs" title="Descargar Nota de Crédito"><i class="fa fa-file-pdf-o"></i></button>
                            </form>
                        <?php
                        			}else{
						?>
                        	<a class="btn btn-danger btn-xs" title="Requiere adjuntar nota de crédito"><i class="fa fa-exclamation-triangle"></i></a>
                        <?php
                        			}
								}
							}
						?>
						
                </td>
                
      		</tr>
    <?php
	}//Fin de while si es tabla ?>
		</table>
	</div><!-- /.box-body --> 
    
    if(mysqli_num_rows($resultadoAjuste)==0){
		include("../../../componentes/mensaje_no_hay_registros.php");
	} */
?>
    