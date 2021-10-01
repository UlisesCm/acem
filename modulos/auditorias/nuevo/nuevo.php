<?php 
include ("../../seguridad/comprobar_login.php");
?>
<!DOCTYPE html>
<html>
  <head>
    <?php include ("../../../componentes/cabecera.php")?>
<link rel="stylesheet" type="text/css" media="screen" href="../../../dist/css/autocompletar/jqueryui.css" />
<link rel="stylesheet" href="../../../dist/css/jtree/style.min.css" />
<script src="../../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="../../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../../../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="../../../plugins/fastclick/fastclick.min.js"></script>
<script src="../../../dist/js/app.min.js" type="text/javascript"></script>
<script src="js.js"></script>
<script src="../../../librerias/js/jstree.min.js"></script>
<script src="../../../librerias/js/jquery-ui.js"></script>
<script src="../../../librerias/js/cookies.js"></script>
<script src="../../../librerias/js/validaciones.js"></script>
</head>
  <body class="sidebar-mini <?php include("../../../componentes/skin.php");?>">
    <!-- Wrapper es el contenedor principal -->
    <div class="wrapper">
      
      <?php include("../../../componentes/menuSuperior.php");?>
      <?php include("../../../componentes/menuLateral.php");?>

      <!-- Contenido-->
      <div class="content-wrapper">
        <!-- Contenido de la cabecera -->
        <section class="content-header">
          <h1>Auditorias de inventario sucursal: <?php echo $_SESSION['nombresucursal']; ?><small>Nuevo registro</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Nuevo auditoria</a></li>
          </ol>
        </section>
        
        <div class="modal fade" id="modal">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" id="tituloModal">Familias</h3>
              </div>
              <div class="modal-body" id="contenidoModal">
                 <div id="arbol_ajax" style="max-height:400px; overflow:scroll"></div>
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
		
		<!-- Contenido principal -->
        <section class="content">
		
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['auditorias']['guardar']) or  !isset($_SESSION['permisos']['auditorias']['acceso'])){
			echo $_SESSION['msgsinacceso'];
			echo "
		</section><!-- /.content -->
       </div><!-- /.content-wrapper -->";
       include("../../../componentes/pie.php");
	   echo "
	</div><!-- ./wrapper -->
</body>
</html>";
			include ("../../../componentes/avisos.php");
			exit;
		}
	/////FIN  DE PERMISOS////////
    		?>
			
			<?php $herramientas="nuevo"; include("../componentes/herramientas.php"); ?>
			<?php include("../../../componentes/avisos.php");?>
        
          	<!-- Horizontal Form -->
            <div class="box box-info" style="border-color:#8bb189">
              <div class="box-header with-border">
                <h3 class="box-title">Formulario de registro</h3>
              </div><!-- /.box-header -->
              <!-- form start -->
			  <form class="form-horizontal" name="formulario" id="formulario" method="post">
                <div class="box-body">
				
				<div class="form-group ">
                    <label for="cfecha" class="col-sm-2 control-label">Fecha:</label>
                    <div class="col-sm-3">
                        <input value="<?php echo date('Y-m-d'); ?>" name="fecha" type="date" required class="form-control" id="cfecha" />
                    </div>
                </div>
			
            
            	<div class="form-group">
                    <label class="col-sm-2 control-label">Sucursal:</label>
                    <div class="col-sm-3">
                    	<input value="<?php echo $_SESSION['nombresucursal'] ?>" type="text" class="form-control" readonly/>
                    </div>
                </div>
                
                <div class="form-group">
                	<label class="col-sm-2 control-label">Reesponsable:</label>
                	<div class="col-sm-3">
                    <input value="<?php echo $_SESSION['nombreusuario'] ?>" type="text" class="form-control" readonly/>
                    </div>
                </div>
				
				<div class="form-group hide">
                    <label for="cidusuario" class="col-sm-2 control-label">Usuario:</label>
                    <div class="col-sm-5">
                        <input value="<?php echo $_SESSION['idusuario'] ?>" name="idusuario" type="hidden" class="form-control" id="cidusuario" />
                    </div>
                </div>
			
				
				<div class="form-group ">
                    <label for="cidfamiliamadre" class="col-sm-2 control-label">Familia de productos:</label>
                    <div class="col-sm-5">
						<input value="" name="idfamiliamadre" type="hidden" class="normal" id="cidfamiliamadre" style="width:50px;"/>
						<input value="" name="consultaidfamiliamadre" type="hidden" class="normal" id="consultaidfamiliamadre" style="width:100px;"/>
                        <div class="input-group input-group-sm">
                        	<input value="" name="autoidfamiliamadre" type="text" class="form-control" id="autoidfamiliamadre" />
                        	<span class="input-group-btn">
                        		<button id="botonFamilia" type="button" class="btn btn-info btn-flat">Seleccionar</button>
                        	</span>
                        </div>
                    </div>
                </div>
			
				
				<div class="form-group hide">
                    <label for="cidsucursal" class="col-sm-2 control-label">Sucursal:</label>
                    <div class="col-sm-5">
                        <input value="<?php echo $_SESSION['idsucursal'] ?>" name="idsucursal" type="hidden" class="form-control" id="cidsucursal" />
                    </div>
                </div>
			
				
				<div class="form-group ">
                    <label for="ccomentarios" class="col-sm-2 control-label">Comentarios:</label>
                    <div class="col-sm-5">
                        <textarea name="comentarios" id="ccomentarios" class="form-control"></textarea>
                    </div>
                </div>
			
				
				<div class="form-group hide">
                    <label for="cestado" class="col-sm-2 control-label">Estado:</label>
                    <div class="col-sm-5">
                        <input value="abierta" name="estado" type="hidden" class="form-control" id="cestado" />
                    </div>
					
                </div>
                
                <!-- Tabla --> 
                <div class="box-body table-responsive no-padding">
                    <table id="tablaSalida" class="table table-hover table-bordered">
                        <thead>
                            <tr style="background:#F3F3F3; color:#666; height:30px; border:1px" align="center">
                                <td width="80" style='display:none'>No.</td>
                                <td width="80" style='display:none'>ID</td>
                                <td width="200" class="columnaIzquierda" style="border-left: 10px solid #9FB580;">Producto</td>
                                <td width="100">Unidad</td>
                                <td width="100">Existencias</td>
                                <td width="100">Cantidad Física</td>
                                <td width="100">Diferencia</td>
                                <td width="30" align="center"></td>
                            </tr>
                        </thead>
                        <tbody id="filas" style="background:#FFF; border:1px #666 solid;" align="center">
                        </tbody>
                    </table>
                </div>
                <!-- Fina Tabla --> 
			
			</div><!-- /.box-body -->
                
                <div class="box-footer">
                	<input value="" name="idauditoria" type="hidden" class="form-control" id="cidauditoria" />
                  <button type="button" class="btn btn-default" id="botonCancelar" onclick="vaciarCampos();">Limpiar</button>
                  <button type="button" class="btn btn-primary pull-right" id="botonGuardar"><i class="fa fa-gear"></i>&nbsp;&nbsp;&nbsp;Comenzar</button>
                  <button type="button" class="btn btn-warning pull-right" id="botonAjustar" style="display:none"><i class="fa fa-gear"></i>&nbsp;&nbsp;&nbsp;Ajustar Inventario</button>
                </div><!-- /.box-footer -->
              </form>
              <div id="loading" class="overlay" style="display:none">
  					<i class="fa fa-cog fa-spin" style="color:#8bb189"></i>
			  </div>
              
              
                
              <div id="mensaje"></div>
              
            </div><!-- /.box -->
            
            
            
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

	  <?php include("../../../componentes/pie.php");?>
    </div><!-- ./wrapper -->

</body>
</html>