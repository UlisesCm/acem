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
<script src="js.js"></script><script src="../../../librerias/js/cookies.js"></script>


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
          <h1>Bitacoracontrol<small>Modificar registro</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Modificar bitacoracontrol</a></li>
          </ol>
        </section>
		
		<!-- Contenido principal -->
        <section class="content">
		
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['bitacoracontrol']['modificar']) or  !isset($_SESSION['permisos']['bitacoracontrol']['acceso'])){
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
            <div class="box box-info" style="border-color:#606060">
              <div class="box-header with-border">
                <h3 class="box-title">Formulario de registro</h3>
              </div><!-- /.box-header -->
              <!-- form start -->
			  <form class="form-horizontal" name="formulario" id="formulario" method="post">
                <div class="box-body">
				<div class="form-group">
                    <label for="cfecha" class="col-sm-2 control-label">Fecha:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $fecha; ?>" name="fecha" type="text" class="form-control" id="cfecha" />
            			
						
                    </div>
                </div>
			
				<div class="form-group">
                    <label for="chora" class="col-sm-2 control-label">Hora:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $hora; ?>" name="hora" type="text" class="form-control" id="chora" />
            			
						
                    </div>
                </div>
			
				<div class="form-group">
                    <label for="cidusuario" class="col-sm-2 control-label">Idusuario:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $idusuario; ?>" name="idusuario" type="text" class="form-control" id="cidusuario" />
            			
						
                    </div>
                </div>
			
				<div class="form-group">
                    <label for="cmodulo" class="col-sm-2 control-label">Modulo:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $modulo; ?>" name="modulo" type="text" class="form-control" id="cmodulo" />
            			
						
                    </div>
                </div>
			
				<div class="form-group">
                    <label for="caccion" class="col-sm-2 control-label">Accion:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $accion; ?>" name="accion" type="text" class="form-control" id="caccion" />
            			
						
                    </div>
                </div>
			
				<div class="form-group">
                    <label for="cdescripcion" class="col-sm-2 control-label">Descripcion:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $descripcion; ?>" name="descripcion" type="text" class="form-control" id="cdescripcion" />
            			
						
                    </div>
                </div>
			
				<div class="form-group">
                    <label for="cidregistro" class="col-sm-2 control-label">Idregistro:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $idregistro; ?>" name="idregistro" type="text" class="form-control" id="cidregistro" />
            			
						
                    </div>
                </div>
			
				<div class="form-group">
                    <label for="ctabla" class="col-sm-2 control-label">Tabla:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $tabla; ?>" name="tabla" type="text" class="form-control" id="ctabla" />
            			
						
                    </div>
                </div>
			
			</div><!-- /.box-body -->
                
                <div class="box-footer">
				  <input name="idbitacoracontrol" type="hidden" id="cidbitacoracontrol" value="<?php echo $id;?>"/>
                  <button type="button" class="btn btn-default" id="botonCancelar" onclick="vaciarCampos();">Limpiar</button>
                  <button type="button" class="btn btn-primary pull-right" id="botonGuardar"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Guardar</button>
                </div><!-- /.box-footer -->
              </form>
              <div id="loading" class="overlay" style="display:none">
  					<i class="fa fa-cog fa-spin" style="color:#606060"></i>
			  </div>
              
            </div><!-- /.box -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

	  <?php include("../../../componentes/pie.php");?>
    </div><!-- ./wrapper -->
</body>
</html>