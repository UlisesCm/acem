		<div class="modal fade" id="modalCaracteristicas">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" id="tituloModal">Detalles</h3>
              </div>
              
              <div class="modal-body" id="contenidoCarac">
                 <div id="loading2" class="overlay">
  					<i class="fa fa-cog fa-spin" style="color:#3d7698"></i> &nbsp;Espere un momento por favor
			  	</div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                <button id="botonAceptar2" type="button" class="btn btn-primary" data-dismiss="modal" onclick="colocarValores();">Aceptar</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->