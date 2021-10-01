<?php
require("../Cotizacionproducto.class.php");
$idcotizacionproducto=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Ocotizacion= new Cotizacionproducto;
	$resultado=$Ocotizacion->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$serie=$extractor["serie"];
	$folio=$extractor["folio"];
	$fecha=$extractor["fecha"];
	$hora=$extractor["hora"];
	$estadopago=$extractor["estadopago"];
	$estadofacturacion=$extractor["estadofacturacion"];
	$tipo=$extractor["tipo"];
	$subtotal=$extractor["subtotal"];
	$impuestos=$extractor["impuestos"];
	$total=$extractor["total"];
	$costodeventa=$extractor["costodeventa"];
	$utilidad=$extractor["utilidad"];
	$idcliente=$extractor["idcliente"];
	$idusuario=$extractor["idusuario"];
	$idempleado=$extractor["idempleado"];
	$enviaradomicilio=$extractor["enviaradomicilio"];
	$fechaentrega=$extractor["fechaentrega"];
	$horaentregainicio=$extractor["horaentregainicio"];
	$horaentregafin=$extractor["horaentregafin"];
	$prioridad=$extractor["prioridad"];
	$iddomicilio=$extractor["iddomicilio"];
	$coordenadas=$extractor["coordenadas"];
	$observaciones=$extractor["observaciones"];
	$estadoentrega=$extractor["estadoentrega"];
	$estatus=$extractor["estatus"];
?>
			<blockquote style="font-size:14px;">
            	<p><b>Folio:</b> <?php echo $serie."-".$folio ?></p>
                <p><b>Total:</b> $<?php echo number_format($total,2)?> | <b>Tipo:</b> <?php echo $tipo;?></p>
                <p>
                	<b>Fecha de venta:</b><?php echo $fecha; ?> | 
                	<b>Hora:</b> <?php echo $hora; ?>
                </p>
                <small>Estado del pago:  <cite title="Source Title"><?php echo $estadopago; ?></cite></small>
                <small>Estado de facturación:  <cite title="Source Title"><?php echo $estadofacturacion; ?></cite></small>
    		</blockquote>
            
            <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Facturas</a></li>
              <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Notas de crédito</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                <b>Facturas</b>
                <?php llenarFacturas($id);?>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
               	<b>Editar información de facturación</b>
                <?php llenarNotasCredito($id);?>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
<?php
}

function llenarFacturas($idcotizacionproducto){
	$Ocotizacion=new Cotizacionproducto;
	$resultado=$Ocotizacion->consultaLibre("SELECT * FROM archivos WHERE tablareferencia='cotizacionesproductos' AND idreferencia='$idcotizacionproducto' AND tipo='I'");
	
	?>
    	<table class="table table-hover table-bordered">
        	<tr>
                <th class="columnaDecorada" style="background:#2ea737;"></th>
				<th class="Cfolio">Folio</th>
				<th class="Cemisor">Emisor</th>
				<th class="Crfc">RFC</th>
				<th class="Csubtotal">Subtotal</th>
				<th class="Ctotal">Total</th>
                <th class="Cuuid">UUID</th>
                <th width="40" class="sticky-column"></th>
                <th width="40" class="sticky-column"></th>
                <th width="40" class="sticky-column"></th>
      		</tr>
    <?php
	while ($filas=mysqli_fetch_array($resultado)) { ?>
      		<tr id="iregistro<?php echo $filas['idarchivo'] ?>">
                <td class="columnaDecorada" style="background:#2ea737;"></td>
				<td class="Cfolio"><i><small><?php echo $filas['serie']."-".$filas['folio']; ?></small></i></td>
				<td class="Cemisor"><?php echo $filas['emisor']; ?></td>
				<td class="Crfc"><?php echo $filas['rfcemisor']; ?></td>
				<td class="Csubtotal"><?php echo "$".number_format($filas['subtotal'],2); ?></td>
				<td class="Ctotal"><?php echo "$".number_format($filas['monto'],2); ?></td>
                <td class="Cuuid"><small><i><?php echo $filas['uuid']; ?></i></small></td>
                
                <td style=" padding-right:2px;">
						<?php 
							
						if ($filas['pdf']!=""){
						?>
                        	<form action="descargarFactura.php" method="post">
                            	<input type="hidden" name="f" value="<?php echo $filas['pdf']; ?>"/>
                            	<button type="submit" class="btn btn-default btn-xs" title="Descargar Factura"><i class="fa fa-file-pdf-o text-red"></i></button>
                            </form>
                        <?php
                        }else{
						?>
                        	<a class="btn btn-danger btn-xs" title="Requiere adjuntar factura"><i class="fa fa-exclamation-triangle"></i></a>
                        <?php
                        }
						?>
						
                </td>
                
                <td style=" padding-right:2px;">
						<?php 
							
						if ($filas['xml']!=""){
						?>
                        	<form action="descargarFactura.php" method="post">
                            	<input type="hidden" name="f" value="<?php echo $filas['xml']; ?>"/>
                            	<button type="submit" class="btn btn-default btn-xs" title="Descargar Factura"><i class="fa fa-file-code-o text-green"></i></button>
                            </form>
                        <?php
                        }else{
						?>
                        	<a class="btn btn-danger btn-xs" title="Requiere adjuntar factura"><i class="fa fa-exclamation-triangle"></i></a>
                        <?php
                        }
						?>
						
                </td>
                
                <td>
					
					<?php /////PERMISOS////////////////
                    if (isset($_SESSION['permisos']['facturacion']['cancelar'])){
                    ?>
                        <?php if($filas['idarchivo']==0){ ?>
                            <a class="btn btn-danger btn-xs disabled"><i class="fa fa-trash-o"></i></a>
                        <?php }else{ ?>
                            <a class="btn btn-danger btn-xs" title="Eliminar" onclick="(eliminarArchivo(<?php echo $filas['idarchivo'] ?>))"><li class="fa fa-trash"></li></a>
                        <?php }?>
                    <?php 
                    }else{ ?>
                        <a class="btn btn-danger btn-xs disabled"><i class="fa fa-trash-o"></i></a>
                    <?php
                    }
                    ?>
					
                </td>
      		</tr>
    <?php
	}//Fin de while si es tabla ?>
		</table>
    <?php   
}

function llenarNotasCredito($idcotizacionproducto){
	$Ocotizacion=new Cliente;
	$resultado=$Ocotizacion->consultaLibre(" SELECT
					*
					FROM datosfiscales
					WHERE estatus <> 'eliminado' AND idcliente='$idcliente' AND tipo='E'");
	
	?>
    	<table class="table table-hover table-bordered">
        	<tr>
                <th class="columnaDecorada" style="background:#2ea737;"></th>
				<th class="Cfolio">Folio</th>
				<th class="Cemisor">Emisor</th>
				<th class="Crfc">RFC</th>
				<th class="Csubtotal">Subtotal</th>
				<th class="Ctotal">Total</th>
                <th class="Cuuid">UUID</th>
                <th width="40" class="sticky-column"></th>
                <th width="40" class="sticky-column"></th>
                <th width="40" class="sticky-column"></th>
      		</tr>
    <?php
	while ($filas=mysqli_fetch_array($resultado)) { ?>
      		<tr id="iregistro<?php echo $filas['idarchivo'] ?>">
                <td class="columnaDecorada" style="background:#2ea737;"></td>
				<td class="Cfolio"><i><small><?php echo $filas['serie']."-".$filas['folio']; ?></small></i></td>
				<td class="Cemisor"><?php echo $filas['emisor']; ?></td>
				<td class="Crfc"><?php echo $filas['rfcemisor']; ?></td>
				<td class="Csubtotal"><?php echo "$".number_format($filas['subtotal'],2); ?></td>
				<td class="Ctotal"><?php echo "$".number_format($filas['monto'],2); ?></td>
                <td class="Cuuid"><small><i><?php echo $filas['uuid']; ?></i></small></td>
                
                <td style=" padding-right:2px;">
						<?php 
							
						if ($filas['pdf']!=""){
						?>
                        	<form action="descargarFactura.php" method="post">
                            	<input type="hidden" name="f" value="<?php echo $filas['pdf']; ?>"/>
                            	<button type="submit" class="btn btn-default btn-xs" title="Descargar Factura"><i class="fa fa-file-pdf-o text-red"></i></button>
                            </form>
                        <?php
                        }else{
						?>
                        	<a class="btn btn-danger btn-xs" title="Requiere adjuntar factura"><i class="fa fa-exclamation-triangle"></i></a>
                        <?php
                        }
						?>
						
                </td>
                
                <td style=" padding-right:2px;">
						<?php 
							
						if ($filas['xml']!=""){
						?>
                        	<form action="descargarFactura.php" method="post">
                            	<input type="hidden" name="f" value="<?php echo $filas['xml']; ?>"/>
                            	<button type="submit" class="btn btn-default btn-xs" title="Descargar Factura"><i class="fa fa-file-code-o text-green"></i></button>
                            </form>
                        <?php
                        }else{
						?>
                        	<a class="btn btn-danger btn-xs" title="Requiere adjuntar factura"><i class="fa fa-exclamation-triangle"></i></a>
                        <?php
                        }
						?>
						
                </td>
                
                <td>
					
					<?php /////PERMISOS////////////////
                    if (isset($_SESSION['permisos']['archivos']['eliminar'])){
                    ?>
                        <?php if($filas['idarchivo']==0){ ?>
                            <a class="btn btn-danger btn-xs disabled"><i class="fa fa-trash-o"></i></a>
                        <?php }else{ ?>
                            <a class="btn btn-danger btn-xs" title="Eliminar" onclick="(eliminarArchivo(<?php echo $filas['idarchivo'] ?>))"><li class="fa fa-trash"></li></a>
                        <?php }?>
                    <?php 
                    }else{ ?>
                        <a class="btn btn-danger btn-xs disabled"><i class="fa fa-trash-o"></i></a>
                    <?php
                    }
                    ?>
					
                </td>
      		</tr>
    <?php
	}//Fin de while si es tabla ?>
		</table>
    <?php   
}


?>