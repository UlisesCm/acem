<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/variasfunciones.php");
include ("recuperarValores.php");
?>
<!DOCTYPE html>
<html>
  <head>
	<?php include ("../../../componentes/cabecera.php")?>
<script src="../../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="../../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../../../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="../../../plugins/fastclick/fastclick.min.js"></script>
<script src="../../../dist/js/app.min.js" type="text/javascript"></script>
<script src="js.js"></script>
<script> var idauditoria=<?php echo $id?>;</script>
<script src="../../../librerias/js/cookies.js"></script>


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
          <h1>Auditorias de inventario sucursal: <?php echo $_SESSION['nombresucursal']; ?><small>Modificar registro</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Modificar auditoria</a></li>
          </ol>
        </section>
		
		<!-- Contenido principal -->
        <section class="content">
		
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['auditorias']['modificar']) or  !isset($_SESSION['permisos']['auditorias']['acceso'])){
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
                        <input value="<?php echo $fecha ?>" name="fecha" type="date" required class="form-control" id="cfecha" readonly/>
                    </div>
                </div>
			
            
            	<div class="form-group">
                    <label class="col-sm-2 control-label">Sucursal:</label>
                    <div class="col-sm-3">
                    	<input value="<?php echo $nombreSucursal ?>" type="text" class="form-control" readonly/>
                    </div>
                </div>
                
                <div class="form-group">
                	<label class="col-sm-2 control-label">Reesponsable:</label>
                	<div class="col-sm-3">
                    <input value="<?php echo $responsable ?>" type="text" class="form-control" readonly/>
                    </div>
                </div>
			
				<div class="form-group hide">
                    <label for="cidusuario" class="col-sm-2 control-label">Usuario:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $idusuario; ?>" name="idusuario" type="hidden" class="form-control" id="cidusuario" />
            			
						
                    </div>
					
                </div>
			
				<div class="form-group ">
                    <label for="cidfamilia" class="col-sm-2 control-label">Familia de productos:</label>
                    <div class="col-sm-3">
                    	<input value="<?php echo $nombreFamilia ?>" type="text" class="form-control" readonly/>
                        <input value="<?php echo $idfamilia; ?>" name="idfamilia" type="hidden" class="form-control" id="cidfamilia" />
                    </div>
					
                </div>
			
				<div class="form-group hide">
                    <label for="cidsucursal" class="col-sm-2 control-label">Sucursal:</label>
                    <div class="col-sm-5">
                        <input value="<?php echo $idsucursal; ?>" name="idsucursal" type="hidden" class="form-control" id="cidsucursal" />
                    </div>
					
                </div>
			
				<div class="form-group ">
                    <label for="ccomentarios" class="col-sm-2 control-label">Comentarios:</label>
                    <div class="col-sm-5">
                    	
                        <textarea name="comentarios" id="ccomentarios" class="form-control"><?php echo $comentarios; ?></textarea>
            			
						
                    </div>
					
                </div>
			
				<div class="form-group hide">
                    <label for="cestado" class="col-sm-2 control-label">Estado:</label>
                    <div class="col-sm-5">
                        <input value="<?php echo $estado; ?>" name="estado" type="hidden" class="form-control" id="cestado" />
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
				  <input name="idauditoria" type="hidden" id="cidauditoria" value="<?php echo $id;?>"/>
                  <button type="button" class="btn btn-primary" id="botonGuardar"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Guardar</button>
                  <button type="button" class="btn btn-warning pull-right" id="botonAjustar"><i class="fa fa-gear"></i>&nbsp;&nbsp;&nbsp;Ajustar Inventario</button>
                </div><!-- /.box-footer -->
              </form>
              <div id="loading" class="overlay" style="display:none">
  					<i class="fa fa-cog fa-spin" style="color:#8bb189"></i>
			  </div>
              
            </div><!-- /.box -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

	  <?php include("../../../componentes/pie.php");?>
    </div><!-- ./wrapper -->
</body>
</html>