<?php
require("../Compra.class.php");
$idcompra=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Ocompra= new Compra;
	$resultado=$Ocompra->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$idcompra=$extractor["idcompra"];
	$fecha=$extractor["fecha"];
	$empleado=$extractor["nombreempleados"];
	$comentarios=$extractor["comentarios"];
	$estado=$extractor["estado"];
	$monto=$extractor["monto"];
	$sucursal=$extractor["nombresucursales"];
	$proveedor=$extractor["nombreproveedores"];
	$factura=$extractor["factura"];

?>
            <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Datos del registro</a></li>
              <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Comprobantes fiscales</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                <blockquote style="font-size:14px;">
					<p><b>ID:</b> <?php echo strtoupper(html_entity_decode($idcompra))?></p>
					<p><b>Fecha de orden:</b> <?php echo strtoupper(html_entity_decode($fecha))?></p>
					<p><b>Empleado:</b> <?php echo strtoupper(html_entity_decode($empleado))?></p>
					<p><b>Comentarios:</b> <?php echo strtoupper(html_entity_decode($comentarios))?></p>
					<p><b>Estado:</b> <?php echo strtoupper(html_entity_decode($estado))?></p>
					<p><b>Monto:</b> $<?php echo strtoupper(html_entity_decode($monto))?></p>
					<p><b>Sucursal:</b> <?php echo strtoupper(html_entity_decode($sucursal))?></p>
					<p><b>Proveedor:</b> <?php echo strtoupper(html_entity_decode($proveedor))?></p>
    			</blockquote>
                
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
               	<b>Comprobantes fiscales</b>
                
                
                <form class="form-horizontal" name="formularioArchivos" id="formularioArchivos" method="post" enctype="multipart/form-data">
                <div class="box-body">
                    <div class="form-group ">
                        <label for="x" class="col-sm-2 control-label">Archivo PDF:</label>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="file" name="pdf" style="display:none;" id="cpdf" accept=".pdf" onChange="fileinput('pdf')"/>
                                <input type="text" name="npdf" id="npdf" class="form-control" placeholder="Seleccionar Archivo" disabled="disabled">
                                <span class="input-group-btn">
                                    <a class="btn btn-warning" onclick="$('#cpdf').click();">&nbsp;&nbsp;&nbsp;Seleccionar Archivo</a>
                                </span>
                            </div>        
                        </div>
                        <span data-placement="bottom" data-toggle="tooltip" data-html="true" title="" data-original-title="
                <b>Adjunte el archivo .pdf de la representación impresa del comprobante fiscal</b>"><i class="fa fa-question-circle text-blue ayuda"></i></span>
                    </div>
                
                    <div class="form-group ">
                        <label for="x" class="col-sm-2 control-label">Archivo XML:</label>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="file" name="xml" style="display:none;" id="cxml" accept=".xml" onChange="fileinput('xml')"/>
                                <input type="text" name="nxml" id="nxml" class="form-control" placeholder="Seleccionar Archivo" disabled="disabled">
                                <span class="input-group-btn">
                                    <a class="btn btn-warning" onclick="$('#cxml').click();">&nbsp;&nbsp;&nbsp;Seleccionar Archivo</a>
                                </span>
                            </div>        
                        </div>
                        <span data-placement="bottom" data-toggle="tooltip" data-html="true" title="" data-original-title="
                <b>Ingrese el archivo .xml del comprobante fiscal</b>"><i class="fa fa-question-circle text-blue ayuda"></i></span>
                    </div>
                    
                    
                    <div class="form-group ">
                        <label for="x" class="col-sm-2 control-label">&nbsp;</label>
                        <div class="col-sm-5">
                            <div class="input-group pull-right">
                            	<input name="idreferencia" type="hidden" value="<?php echo $idcompra?>" id="cidreferencia"/>
                                <input name="tablareferencia" type="hidden" value="compras" id="ctablareferencia"/>
                                <div id="loading2" class="overlay" style="display:none">
  									<i class="fa fa-cog fa-spin" style="color:#ffaf09"></i> Guardando...
			  					</div>
                                <button type="button" class="btn btn-primary pull-right" id="botonGuardar" onclick="guardarArchivo()"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Guardar</button>
                            </div> 
                        </div> 
                    </div>
                
                </div>
                </form>
                <?php llenarArchivos($idcompra);?>
                
              </div>
 			<!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
<?php
}
function llenarArchivos($idreferencia){
	$Ocompra= new Compra;
	$resultado=$Ocompra->consultaLibre("SELECT * FROM archivos WHERE tablareferencia='compras' AND idreferencia='$idreferencia' ");
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