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
<script src="../../../librerias/js/jstree.min.js"></script>
<script src="../../../librerias/js/jquery-ui.js"></script>
<script src="js.js?V3"></script>
<script src="../../../librerias/js/cookies.js"></script>
<?php 
	if (isset($_GET['busqueda'])){
		echo "<script>
		var busqueda='".$_GET['busqueda']."';
		</script>";
	}else{
		echo '<script>var busqueda="";</script>';
	}
	if (isset($_GET['papelera'])){
		echo '<script>var papelera="si";</script>';
	}else{
		echo '<script>var papelera="no";</script>';
	}
?>
</head>
<body class="sidebar-mini <?php include("../../../componentes/skin.php");?>">
	<!-- Wrapper es el contenedor principal -->
    <div class="wrapper s">
      
      <?php include("../../../componentes/menuSuperior.php");?>
      <?php include("../../../componentes/menuLateral.php");?>
      <!-- Contenido-->
      <div class="content-wrapper">
        <!-- Contenido de la cabecera -->
        <section class="content-header">
          <h1>Productos<small> Consulta</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Consultar producto</a></li>
          </ol>
        </section>
        
        <div class="modal fade" id="modal2">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" id="tituloModal">Familias</h3>
              </div>
              <div class="modal-body" id="contenidoModal2">
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
        
		<?php include ("../componentes/modal.php");?>
		<!-- Contenido principal -->
        <section class="content">
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['productos']['consultar']) or  !isset($_SESSION['permisos']['productos']['acceso'])){
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
			
			<?php $herramientas="consultar"; include("../componentes/herramientas.php"); ?>
        	<?php include("../../../componentes/avisos.php");?>
            
            
            <!-- Herramientas de filtrado-->
            <!-- Horizontal Form -->
            
            
            <div class="box box-info" style="border-color:#13A44D">
              <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-filter text-green"></i> Filtrar Resultados</h3>
                
              </div><!-- /.box-header -->
              <!-- form start -->
			  <form class="form-horizontal" name="formulario" id="formulario" method="post">
                <div class="box-body">
                	
                	<div class='row' style="padding-left:20px; padding-right:20px; padding-bottom:0px; margin-bottom:0px;"><!-- /.Inicio row -->
                    
                    	<div class='col-sm-4' style="padding-top:2px;">
                            <div class="form-group">
                                <label for="cidfamiliamadre">Familia madre:</label>
                                
                                <input value="" name="idfamiliamadre" type="hidden" class="normal" id="cidfamiliamadre" style="width:50px;"/>
                                <input value="" name="consultaidfamiliamadre" type="hidden" class="normal" id="consultaidfamiliamadre" style="width:100px;"/>
                                <div class="input-group input-group-sm">
                                    <input value="" name="autoidfamiliamadre" type="text" class="form-control" id="autoidfamiliamadre" style="height:34px"/>
                                    <span class="input-group-btn">
                                        <button id="botonFamilia" type="button" class="btn btn-info btn-flat"style="height:34px">Seleccionar</button>
                                    </span>
                                </div>
                            </div>
                    	</div>
                        
                    	<div class='col-sm-2'>
                        	<div class="form-group">
                            	<label for="cmarca">Marca:</label>
                            	<select id="cmarca" name="marca" class="form-control" style="margin-top:2px;">
                            	</select>
                        	</div>
                    	</div>
                        
                        <div class='col-sm-2'>
                        	<div class="form-group">
                            	<label for="cespesor">Espesor:</label>
                            	<select id="cespesor" name="espesor" class="form-control" style="margin-top:2px;">
                            	</select>
                        	</div>
                    	</div>
                        
                        <div class='col-sm-2'>
                        	<div class="form-group">
                            	<label for="cancho">Ancho:</label>
                            	<select id="cancho" name="ancho" class="form-control" style="margin-top:2px;">
                            	</select>
                        	</div>
                    	</div>
                        
                        <div class='col-sm-2'>
                        	<div class="form-group">
                            	<label for="clargo">Largo:</label>
                            	<select id="clargo" name="largo" class="form-control" style="margin-top:2px;">
                            	</select>
                        	</div>
                    	</div>
                         
                	</div><!-- /.Fin row -->
                    
                    
                    
                    
                    <div class='row' style="padding-left:20px; padding-right:20px; padding-bottom:0px; margin-bottom:0px;"><!-- /.Row -->
                    	
                        <div class='col-sm-2'>
                        	<div class="form-group">
                            	<label for="calto">Alto:</label>
                            	<select id="calto" name="alto" class="form-control" style="margin-top:2px;">
                            	</select>
                        	</div>
                    	</div>
                        
                        <div class='col-sm-2'>
                        	<div class="form-group">
                            	<label for="cdiametro">Diámetro:</label>
                            	<select id="cdiametro" name="diametro" class="form-control" style="margin-top:2px;">
                            	</select>
                        	</div>
                    	</div>
                        
                        <div class='col-sm-2'>
                        	<div class="form-group">
                            	<label for="ccolor">Color:</label>
                            	<select id="ccolor" name="color" class="form-control" style="margin-top:2px;">
                            	</select>
                        	</div>
                    	</div>
                        
                        <div class='col-sm-2'>
                        	<div class="form-group">
                            	<label for="caplicacion">Aplicación:</label>
                            	<select id="caplicacion" name="aplicacion" class="form-control" style="margin-top:2px;">
                            	</select>
                        	</div>
                    	</div>
                        
                        <div class='col-sm-2'>
                        	<div class="form-group">
                            	<label for="ctipo">Tipo:</label>
                            	<select id="ctipo" name="tipo" class="form-control" style="margin-top:2px;">
                            	</select>
                        	</div>
                    	</div>
                        
                        <div class='col-sm-2 pull-right'>
                            <div class="form-group">
                            		<label for="caplicacion">&nbsp;</label>
                                    <button type="button" class="btn btn-success form-control  pull-right" id="botonFiltrar"><i class="fa fa-filter"></i>&nbsp;&nbsp;&nbsp;Filtrar</button>
                            </div>
                		</div>
                    </div><!-- /.Fin row -->
                    
                    
				</div><!-- /.box-body -->
                
              </form>
              
            </div><!-- /.box -->
            <!-- Fin Herramientas de filtrado>
            
            
          	<!-- box -->
            <div class="box box-info" style="border-color:#1fba88">
            	<div class="box-header with-border">
                	<h3 class="box-title">Consulta de registros</h3>
              	</div><!-- /.box-header -->
                <div id="muestra_contenido_ajax" style="min-height:100px;">
            	</div><!-- /din contenido ajax -->
                <div id="loading" class="overlay">
  					<i class="fa fa-cog fa-spin" style="color:#1fba88"></i>
			  	</div>
                
            </div><!-- Fin box>
			
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

	  <?php include("../../../componentes/pie.php");?>
    </div><!-- ./wrapper -->

</body>
</html>