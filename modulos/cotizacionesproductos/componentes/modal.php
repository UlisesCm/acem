		<div class="modal fade" id="modalconsultaproductos">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" id="tituloModal">Catálogo de productos</h3>
              </div>
              <div class="modal-body" id="contenidoModal">
              	
                 <div class="nav-tabs-custom">
             <div class="box box-info" style="border-color:#13A44D"> 
             <div class="box-header with-border">
             <h3 class="box-title"><i class="fa fa-filter text-green"></i> Filtrar Resultados</h3>
              </div><!-- /.box-header -->
             			<form class="form-horizontal" name="formulariofiltrar" id="formulariofiltrar" method="post" >
                        <div class="box-body">
                            <div class='row' style="padding-left:20px; padding-right:20px; padding-bottom:0px; margin-bottom:0px;">
                                 <div class='col-sm-6'>
                                    <div class="form-group">
                                         <label for="productofiltro">Producto</label>
                                        <input value="" name="productofiltro" type="text" class="form-control" id="productofiltro" />
                                           
                                    </div>
                                 </div>
                                <div class='col-sm-2'>
                                    <div class="form-group">
                                        <label for="idsucursal_ajax">Sucursal:</label>
                                        <select id="idsucursal_ajax" name="idsucursal" class="form-control">
                                        </select>
                                    </div>
                                 </div>
                                <div class='col-sm-2'>
                                    <div class="form-group">
                                            <label for="idzona_ajax">Zona: </label>
                                            <select id="idzona_ajax" name="idzona" class="form-control"></select>
                                    </div>
                                </div>
                                <div class='col-sm-2 pull-right'>
                                    <div class="form-group">
                                            <label for="cdomicilio">&nbsp;</label>
                                            <button type="button" class="btn btn-success pull-right form-control" id="botonFiltrarModal" onclick = ""><i class="fa fa-filter"></i>&nbsp;&nbsp;&nbsp;Filtrar</button>
                                    </div>
                                </div>
                            </div><!-- /.Fin row -->
                            
                            
                        </div><!-- /.box-body -->
                      </form>
             
             </div>
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Productos</a></li>
              <li class="pull-right"><a class="text-muted"><i class="fa fa-gear"></i></a></li>
            </ul>
            
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
              </div>
            </div>
            <!-- /.tab-content -->
          </div>
          
          
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->