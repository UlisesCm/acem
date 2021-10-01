<?php 
include ("../../seguridad/comprobar_login.php");
?>
<!DOCTYPE html>
<html>
  <head>
    <?php include ("../../../componentes/cabecera.php")?><link type="text/css" rel="stylesheet" href="../../../librerias/js/editor/jquery-te-1.4.0.css">
<script src="../../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="../../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../../../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="../../../plugins/fastclick/fastclick.min.js"></script>
<script src="../../../dist/js/app.min.js" type="text/javascript"></script>
<script src="js.js"></script><script src="../../../librerias/js/cookies.js"></script><script type="text/javascript" src="../../../librerias/js/editor/jquery-te-1.4.0.min.js" charset="utf-8"></script>
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
          <h1>Configuracion<small>Nuevo registro</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Nuevo configuracion</a></li>
          </ol>
        </section>
		
		<!-- Contenido principal -->
        <section class="content">
		
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['configuracion']['guardar']) or  !isset($_SESSION['permisos']['configuracion']['acceso'])){
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
            <div class="box box-info" style="border-color:#5b6c79">
              <div class="box-header with-border">
                <h3 class="box-title">Formulario de registro</h3>
              </div><!-- /.box-header -->
              <!-- form start -->
			  <form class="form-horizontal" name="formulario" id="formulario" method="post">
                <div class="box-body">
				
				<div class="form-group">
                    <label for="ccabeceraimpresion" class="col-sm-2 control-label">Cabecera Ticket:</label>
                    <div class="col-sm-5">
                    	
                        <input value="" name="cabeceraimpresion" type="text" class="jqte-test" id="ccabeceraimpresion" />
            			
						
                    </div>
                </div>
			
				
				<div class="form-group">
                    <label for="cpieimpresion" class="col-sm-2 control-label">Pie Ticket:</label>
                    <div class="col-sm-5">
                    	
                        <input value="" name="pieimpresion" type="text" class="jqte-test" id="cpieimpresion" />
            			
						
                    </div>
                </div>
			
				<div class="form-group">
                  	<label for="cseparadorimpresion" class="col-sm-2 control-label">Separador:</label>
                    <div class="col-sm-5">
                    	<select id="cseparadorimpresion" name="separadorimpresion" class="form-control">
							<option value="dotted">Punteado</option>
							<option value="solid">Continuo</option>
							<option value="dashed">Discontinuo</option>
							<option value="double">Doble</option>
						</select>
                    </div> 
                </div>
				<div class="form-group">
                    <label for="x" class="col-sm-2 control-label">&nbsp;</label>
                    <div class="col-sm-10">
                    	<label>
                  			<input id="cdescripcioncompletaimpresion" type="checkbox" name="descripcioncompletaimpresion" value="si" >
                  			 Descripción completa
                 		</label>
                    </div>
                </div>
			</div><!-- /.box-body -->
                
                <div class="box-footer">
                  <button type="button" class="btn btn-default" id="botonCancelar" onclick="vaciarCampos();">Limpiar</button>
                  <button type="button" class="btn btn-primary pull-right" id="botonGuardar"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Guardar</button>
                </div><!-- /.box-footer -->
              </form>
              <div id="loading" class="overlay" style="display:none">
  					<i class="fa fa-cog fa-spin" style="color:#5b6c79"></i>
			  </div>
              
            </div><!-- /.box -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

	  <?php include("../../../componentes/pie.php");?>
    </div><!-- ./wrapper --><script>
$('.jqte-test').jqte();
var jqteStatus = true;
$(".status").click(function(){
		jqteStatus = jqteStatus ? false : true;
		$('.jqte-test').jqte({"status" : jqteStatus})
});
</script>

</body>
</html>