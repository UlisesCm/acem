<?php 
include ("../../seguridad/comprobar_login.php");
/////PERMISOS////////////////
if (!isset($_SESSION['permisos']['facturacion']['acceso'])){
	echo $_SESSION['msgsinacceso'];
	exit;
}
/////FIN  DE PERMISOS////////
include ("../../../librerias/php/variasfunciones.php");
require('../Facturacion.class.php');



function llenarDetalle($uuidrelacion, $folio){
	$Orelacion=new Facturacion;
	if ($Orelacion->existenRelaciones($uuidrelacion)=="si"){ // Si hay relaciones
	?>
    <tr style="background:#F4F4F4">
    <td colspan="18">
	<table class="table table-hover table-bordered no-padding">
        	<tr style="background:#F4F4F4">
                <th class="columnaDecorada" style="background:#da123f;"></th>
				<th class="Cfoliointerno" >Folios Relacionados con <?php echo $folio; ?></th>
                <th class="Cfoliointerno" >Fecha</th>
                <th class="Cfoliointerno" >Tipo</th>
                <th class="Cfoliointerno" >Monto</th>
                <th class="Cfoliointerno">Monto pagado</th>
                <th class="Cfoliointerno">Forma de pago</th>
                <th width="40"></th>
                <th width="40"></th>
                <th width="40"></th>
                <th width="40"></th>
      		</tr>
	<?php
	
	$resultadoRel=$Orelacion->obtenerRelaciones($uuidrelacion);
	while ($filasRel=mysqli_fetch_array($resultadoRel)) {
		$uuidhija=$filasRel['uuidhija'];
		$tipoRelacion=$filasRel['tiporelacion'];
		$resultado=$Orelacion->mostrarIndividualUUID($uuidhija);
		while ($filas=mysqli_fetch_array($resultado)) {
				$fechaNfecha=date_create($filas['fecha']);
				$nuevaFecha= date_format($fechaNfecha, 'd/m/Y');
				$tipo=$filas['tipo'];
				
				if($tipo=="I"){
					$tipo="Ingreso";
					$colorTipo="#096";
				}
				if($tipo=="E"){
					$tipo="Egreso";
					$colorTipo="#D7284B";
				}
				if($tipo=="P"){
					$tipo="Pago";
					$colorTipo="#F90";
				}
			?>
    		<tr>
                <td class="columnaDecorada" style="background:#F90;"></td>
				<td><b><?php echo $filas['foliointerno']; ?></b></td>
                <td><?php echo $nuevaFecha; ?></td>
                <td class="Ctipo"><span class="badge" style="background-color:<?php echo $colorTipo;?>"><?php echo $tipo; ?></span></td>
                <td>$<?php echo number_format($filas['montototal'],2); ?></td>
				<td>$<?php echo number_format($filas['montopagado'],2); ?></td>
                <td class="Cformapago"><?php echo $filas['formapago']; ?></td>
                <td>
                	<?php
                	/////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['facturacion']['descargar'])){
					?>
						<form action="descargar.php" method="post" class="inline">
                            <input name="f" type="hidden" value="<?php echo $filas['archivo'].".xml"; ?>"/>
                            <button type="submit" class="btn btn-default btn-xs" title="Descargar XML"><i class="fa fa-file-code-o" style="color:#096;"></i></button>
                        </form>
                	<?php 
					}else{ ?>
                    	<a class="btn btn-default btn-xs disabled"><i class="fa fa-file-code-o"></i></a>
					<?php
                    }
					?>
                </td>
                
                <td>
                	<?php
                	/////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['facturacion']['descargar'])){
					?>
						<form action="descargar.php" method="post" class="inline">
                            <input name="f" type="hidden" value="<?php echo $filas['archivo'].".pdf"; ?>"/>
                            <button type="submit" class="btn btn-default btn-xs" title="Descargar PDF"><i class="fa fa-file-pdf-o" style="color:#C00;"></i></button>
                        </form>
                	<?php 
					}else{ ?>
                    	<a class="btn btn-default btn-xs  disabled"><i class="fa fa-file-pdf-o"></i></a>
					<?php
                    }
					?>
                </td>
                
                
                <td>
                	<?php
                	/////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['email']['guardar'])){
					?>
						<form action="../../email/nuevo/nuevo.php" method="post">
                            <input type="hidden" name="xml" value="<?php echo $filas['archivo'].".xml" ?>"/>
                			<input type="hidden" name="pdf" value="<?php echo $filas['archivo'].".pdf" ?>"/>
                    		<input type="hidden" name="email" value="kenzzo_ba@gmail.com"/>
                    		<input type="hidden" name="cliente" value="<?php echo $filas['receptor'] ?>"/>
                    		<input type="hidden" name="rfccliente" value="<?php echo $filas['rfcreceptor'] ?>"/>
                            <button type="submit" class="btn btn-default btn-xs" title="Enviar al cliente"><i class="fa fa-envelope-o" style="color:#939;"></i></button>
                        </form>
                	<?php 
					}else{ ?>
                    	<a class="btn btn-default btn-xs disabled"><i class="fa fa-envelope-o"></i></a>
					<?php
                    }
					?>
                </td>
                
                <td>
                    <a class="btn btn-default btn-xs" title="Cancelar Comprobante" onclick="(cancelarFactura(<?php echo $filas['idfactura'] ?>))" >
                    	<i class="fa fa-minus-circle" style="color:#F00"></i>
                    </a>
                </td>
                
      		</tr>
    		<?php
		}
	}
	
	?>
    </table>
    </td>
    </tr>
    <?php  
	} // Fin si hay relaciones
}

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

//CODIGO DE PAGINACION (REQUIERE: "variasfunciones.php")
$inicial = $pg * $cantidadamostrar;
$Ofacturacion=new Facturacion;
$tipo="P";
$resultado=$Ofacturacion->mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $busqueda, $papelera, $tipo);
if ($resultado=="denegado"){
	echo $_SESSION['msgsinacceso'];
	exit;
}
$filasTotales = $Ofacturacion->contar($busqueda, $papelera, $tipo);
// MOSTRAR LOS REGISTROS SEGUN EL RESULTADO DE LA CONSULTA




if ($tipoVista=="tabla"){ // Si se ha elegido el tipo tabla ?>
	<div class="box-body table-responsive no-padding"> <!-- /.box-body -->
    	<table class="table table-hover table-bordered">
        	<tr>
        		<th class="checksEliminar" width="10"><input id="seleccionarTodo" type="checkbox"  onclick="seleccionarTodo();"></th>
                <th class="columnaDecorada" style="background:#da123f;"></th>
				<th class="Cfoliointerno">Folio</th>
				<th class="Cfecha">Fecha</th>
				<th class="Ctipo">Tipo</th>
				<th class="Cclasificacion">Clasificación</th>
				<th class="Creceptor">Receptor</th>
				<th class="Crfcreceptor">RFC Receptor</th>
				<th class="Cmontototal">Monto total</th>
				<th class="Cmontopagado">Monto pagado</th>
				<th class="Cestado">Estado del pago</th>
                <th class="Cfechapago">Fecha del pago</th>
				<th class="Cformapago">Forma de pago</th>
				<th width="40"></th>
                <th width="40"></th>
                <th width="40"></th>
                <th width="40"></th>
                <th width="40"></th>
                <th width="40"></th>
      		</tr>
	<?php
	while ($filas=mysqli_fetch_array($resultado)) { 
		$tipo=$filas['tipo'];
		$estado=$filas['estado'];
		if($estado=="PAGADO"){
			$estado="Liquidada";
			$colorEstado="#096";
		}else{
			$estado="Pendiente";
			$colorEstado="#D7284B";
		}
				
		if($tipo=="I"){
			$tipo="Ingreso";
			$colorTipo="#096";
		}
		if($tipo=="E"){
			$tipo="Egreso";
			$colorTipo="#D7284B";
		}
		if($tipo=="P"){
			$tipo="Pago";
			$colorTipo="#F90";
		}
		$estatus=$filas['estatus'];
		
		if($estatus=="cancelada"){
			$cancel="cancel";
			$colorTipo="#999";
			$tipo=$tipo."-Cancelada";
			$colorEstado="#999";
		}else{
			$cancel="";
		}
		
	?>
      		<tr id="iregistro<?php echo $filas['idfactura'] ?>" class="<?php echo $cancel; ?>">
        		<td class="checksEliminar" width="30" valign="middle">
					<?php /////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['facturacion']['eliminar'])){ ?>
                		<?php if($filas['idfactura']!=0){ ?>
							<input id="registroEliminar<?php echo $filas['idfactura'] ?>" type="checkbox" name="registroEliminar[]"  value="<?php echo $filas['idfactura'] ?>" class="checkEliminar">
                    	<?php } ?>
					<?php 
					}
					?>
            	</td>
                <td class="columnaDecorada" style="background:#da123f;"></td>
				<td class="Cfoliointerno"><b><?php echo $filas['foliointerno']; ?></b></td>
				<?php
				$fechaNfecha=date_create($filas['fecha']);
				$nuevaFecha= date_format($fechaNfecha, 'd/m/Y');
				?>
				<td class="Cfecha"><?php echo $nuevaFecha; ?></td>
				<td class="Ctipo"><span class="badge" style="background-color:<?php echo $colorTipo;?>"><?php echo $tipo; ?></span></td>
				<td class="Cclasificacion"><?php echo $filas['clasificacion']; ?></td>
				<td class="Creceptor"><?php echo $filas['receptor']; ?></td>
				<td class="Crfcreceptor"><?php echo $filas['rfcreceptor']; ?></td>
				<td class="Cmontototal">$<?php echo number_format($filas['montototal'],2); ?></td>
				<td class="Cmontopagado">$<?php echo number_format($filas['montopagado'],2); ?></td>
				<td class="Cestado"><span class="badge" style="background-color:<?php echo $colorEstado;?>"><?php echo $estado; ?></span></td>
                <td class="Cfechapago">
				<?php
				if ($estado=="Pendiente"){
					echo "NA";
				}else{
					$fechaNfechapago=date_create($filas['fechapago']);
					$nuevaFecha= date_format($fechaNfechapago, 'd/m/Y');
					echo $nuevaFecha;
				}
				?>
                </td>
				<td class="Cformapago"><?php echo $filas['formapago']; ?></td>
        		<td>
					<?php 
					if (!$papelera){
					?>
						<?php /////PERMISOS////////////////
						if (isset($_SESSION['permisos']['facturacion']['eliminar'])){
						?>
							<?php if($filas['idfactura']==0){ ?>
								<a class="btn btn-danger btn-xs disabled"><i class="fa fa-trash-o"></i></a>
							<?php }else{ ?>
								<a class="btn btn-danger btn-xs" title="Eliminar" onclick="(eliminarIndividual(<?php echo $filas['idfactura'] ?>))"><li class="fa fa-trash"></li></a>
							<?php }?>
						<?php 
						}else{ ?>
							<a class="btn btn-danger btn-xs disabled"><i class="fa fa-trash-o"></i></a>
						<?php
						}
						?>
					<?php 
					}else{ ?>
							<a class="btn btn-primary btn-xs" title="Restaurar Registro" onclick="(restaurarIndividual(<?php echo $filas['idfactura'] ?>))"><li class="fa fa-recycle"></li></a>
					<?php
					}
					?>
                </td>
                <td>
                	<?php
                	/////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['facturacion']['modificar'])){
					?>
						<form action="../modificar/actualizar.php?n1=facturacion&n2=consultarfacturacion" method="post">
                			<input type="hidden" name="id" value="<?php echo $filas['idfactura'] ?>"/>
                            <button type="submit" class="btn btn-success btn-xs" value="" title="Modificar"><li class="fa fa-pencil"></li></button>
                		</form>
                	<?php 
					}else{ ?>
                    	<a class="btn btn-success btn-xs disabled"><i class="fa fa-pencil"></i></a>
					<?php
                    }
					?>
                </td>
                
                <td>
                	<?php
                	/////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['facturacion']['descargar'])){
					?>
						<form action="descargar.php" method="post" class="inline">
                            <input name="f" type="hidden" value="<?php echo $filas['archivo'].".xml"; ?>"/>
                            <button type="submit" class="btn btn-default btn-xs" title="Descargar XML"><i class="fa fa-file-code-o" style="color:#096;"></i></button>
                        </form>
                	<?php 
					}else{ ?>
                    	<a class="btn btn-default btn-xs disabled"><i class="fa fa-file-code-o"></i></a>
					<?php
                    }
					?>
                </td>
                
                <td>
                	<?php
                	/////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['facturacion']['descargar'])){
					?>
						<form action="descargar.php" method="post" class="inline">
                            <input name="f" type="hidden" value="<?php echo $filas['archivo'].".pdf"; ?>"/>
                            <button type="submit" class="btn btn-default btn-xs" title="Descargar PDF"><i class="fa fa-file-pdf-o" style="color:#C00;"></i></button>
                        </form>
                	<?php 
					}else{ ?>
                    	<a class="btn btn-default btn-xs disabled"><i class="fa fa-file-pdf-o"></i></a>
					<?php
                    }
					?>
                </td>
                
                
                <td>
                	<?php
                	/////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['email']['guardar'])){
					?>
						<form action="../../email/nuevo/nuevo.php" method="post">
                            <input type="hidden" name="xml" value="<?php echo $filas['archivo'].".xml" ?>"/>
                			<input type="hidden" name="pdf" value="<?php echo $filas['archivo'].".pdf" ?>"/>
                    		<input type="hidden" name="email" value="kenzzo_ba@gmail.com"/>
                    		<input type="hidden" name="cliente" value="<?php echo $filas['receptor'] ?>"/>
                    		<input type="hidden" name="rfccliente" value="<?php echo $filas['rfcreceptor'] ?>"/>
                            <button type="submit" class="btn btn-default btn-xs" title="Enviar al cliente"><i class="fa fa-envelope-o" style="color:#939;"></i></button>
                        </form>
                	<?php 
					}else{ ?>
                    	<a class="btn btn-default btn-xs disabled"><i class="fa fa-envelope-o"></i></a>
					<?php
                    }
					?>
                </td>
                
                <td>
                    
                    <a class="btn btn-default btn-xs" title="Cancelar Comprobante" onclick="(cancelarFactura(<?php echo $filas['idfactura'] ?>))" ><i class="fa fa-minus-circle" style="color:#F00"></i></a>
                </td>
                    
                    
      		</tr>
            <?php echo llenarDetalle($filas['foliofiscal'], $filas['foliointerno']);?>
                
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
	<div class="info-box" style="height:120px;" id="iregistro<?php echo $filas['idfactura'] ?>">
    	<span class="info-box-icon bg-red" style="background-color:#da123f !important; height:120px; padding-top:15px;"><i class="fa fa-clipboard"></i></span>
    	<div class="info-box-content">
    		<span class="info-box-text Creceptor" style="font-size:18px;">
				<span class="checksEliminar">
					<?php /////PERMISOS////////////////
					if (isset($_SESSION['permisos']['facturacion']['eliminar'])){ ?>
						<?php if($filas['idfactura']!=0){ ?>
							<input id="registroEliminar<?php echo $filas['idfactura'] ?>" type="checkbox" name="registroEliminar[]"  value="<?php echo $filas['idfactura'] ?>" class="checkEliminar">
						<?php } ?>
					<?php
					}
					?>
				</span>
			<?php echo $filas['receptor'] ?>
            </span>
    		<span class="info-box-number Crfcreceptor" style="font-weight:normal; color:#da123f;"><?php echo $filas['rfcreceptor'] ?></span>
            <span class="info-box-number Ccomposicion" style="font-weight:normal; font-size:12px;">
				<?php 
				$composicion="";
				if (trim($filas['foliointerno'])!=""){
					$composicion=$composicion."Folio: ".$filas['foliointerno'];
				}
				if (trim($filas['fecha'])!=""){
					$composicion=$composicion.", Fecha: ".$filas['fecha'];
				}
				if (trim($filas['montototal'])!=""){
					$composicion=$composicion.", Monto: $".$filas['montototal'];
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
							if (isset($_SESSION['permisos']['facturacion']['eliminar'])){ ?>
								<?php if($filas['idfactura']==0){ ?>
									<a class="btn btn-default disabled"><i class="fa fa-trash-o"></i></a>
								<?php }else{ ?>
									<a class="btn btn-default" onclick="(eliminarIndividual(<?php echo $filas['idfactura'] ?>))" title="Eliminar"><i class="fa fa-trash-o"></i></a>
								<?php } ?>
							<?php 
							}else{ ?>
								<a class="btn btn-default disabled"><i class="fa fa-trash-o"></i></a>
							<?php
							}
							?>
						<?php 
						}else{?>
								<a class="btn btn-default" onclick="(restaurarIndividual(<?php echo $filas['idfactura'] ?>))" title="Restaurar Resgistro"><i class="fa fa-recycle"></i></a>
						<?php 
						}
						?>
					</td>
					<td style=" padding-right:2px;">
						<?php /////PERMISOS////////////////
						if (isset($_SESSION['permisos']['facturacion']['modificar'])){ ?>
							<form action="../modificar/actualizar.php?n1=facturacion&n2=consultarfacturacion" method="post">
								<input type="hidden" name="id" value="<?php echo $filas['idfactura'] ?>"/>
								<button type="submit" class="btn btn-default"><i class="fa fa-pencil"></i></button>
							</form>
						<?php 
						}else{ ?>
							<a class="btn btn-default disabled"><i class="fa fa-pencil"></i></a>
                        <?php
                        }
						?>
                	</td>
                    
                    
                    
                    
                     <td>
                	<?php
                	/////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['facturacion']['descargar'])){
					?>
						<form action="descargar.php" method="post" class="inline">
                            <input name="f" type="hidden" value="<?php echo $filas['archivo'].".xml"; ?>"/>
                            <button type="submit" class="btn btn-default " title="Descargar XML"><i class="fa fa-file-code-o" style="color:#096;"></i></button>
                        </form>
                	<?php 
					}else{ ?>
                    	<a class="btn btn-default  disabled"><i class="fa fa-file-code-o"></i></a>
					<?php
                    }
					?>
                </td>
                
                <td>
                	<?php
                	/////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['facturacion']['descargar'])){
					?>
						<form action="descargar.php" method="post" class="inline">
                            <input name="f" type="hidden" value="<?php echo $filas['archivo'].".pdf"; ?>"/>
                            <button type="submit" class="btn btn-default " title="Descargar PDF"><i class="fa fa-file-pdf-o" style="color:#C00;"></i></button>
                        </form>
                	<?php 
					}else{ ?>
                    	<a class="btn btn-default  disabled"><i class="fa fa-file-pdf-o"></i></a>
					<?php
                    }
					?>
                </td>
                
                
                <td>
                	<?php
                	/////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['email']['guardar'])){
					?>
						<form action="../../email/nuevo/nuevo.php" method="post">
                            <input type="hidden" name="xml" value="<?php echo $filas['archivo'].".xml" ?>"/>
                			<input type="hidden" name="pdf" value="<?php echo $filas['archivo'].".pdf" ?>"/>
                    		<input type="hidden" name="email" value="kenzzo_ba@gmail.com"/>
                    		<input type="hidden" name="cliente" value="<?php echo $filas['receptor'] ?>"/>
                    		<input type="hidden" name="rfccliente" value="<?php echo $filas['rfcreceptor'] ?>"/>
                            <button type="submit" class="btn btn-default " title="Enviar al cliente"><i class="fa fa-envelope-o" style="color:#939;"></i></button>
                        </form>
                	<?php 
					}else{ ?>
                    	<a class="btn btn-default  disabled"><i class="fa fa-envelope-o"></i></a>
					<?php
                    }
					?>
                </td>
                
                <td>
                    <a class="btn btn-default " title="Cancelar Comprobante" onclick="(cancelarFactura(<?php echo $filas['idfactura'] ?>))" >
                    	<i class="fa fa-minus-circle" style="color:#F00"></i>
                    </a>
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