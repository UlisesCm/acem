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
          <h1>Archivos<small>Modificar registro</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Modificar archivo</a></li>
          </ol>
        </section>
		
		<!-- Contenido principal -->
        <section class="content">
		
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['archivos']['modificar']) or  !isset($_SESSION['permisos']['archivos']['acceso'])){
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
            <div class="box box-info" style="border-color:#ebbd45">
              <div class="box-header with-border">
                <h3 class="box-title">Formulario de registro</h3>
              </div><!-- /.box-header -->
              <!-- form start -->
			  <form class="form-horizontal" name="formulario" id="formulario" method="post" enctype="multipart/form-data" >
                <div class="box-body">
				<div class="form-group ">
                	<label for="x" class="col-sm-2 control-label">Archivo PDF:</label>
                    <div class="col-sm-5">
                    	<div class="input-group">
                            <input type="file" name="pdfI" style="display:none;" id="cpdfI" accept=".pdf" onChange="fileinput('pdf')"/>
                            <input value="<?php echo $pdf; ?>" type="text" name="pdf" id="cpdf" class="form-control" placeholder="Seleccionar Archivo" readonly >
                            <input value="<?php echo $pdf; ?>" type="hidden" name="pdfEliminacion" id="cpdfEliminacion" >
							<span class="input-group-btn">
                                <a class="btn btn-warning" onclick="$('#cpdfI').click();">&nbsp;&nbsp;&nbsp;Seleccionar Archivo</a>
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
                            <input type="file" name="xmlI" style="display:none;" id="cxmlI" accept=".xml" onChange="fileinput('xml')"/>
                            <input value="<?php echo $xml; ?>" type="text" name="xml" id="cxml" class="form-control" placeholder="Seleccionar Archivo" readonly >
                            <input value="<?php echo $xml; ?>" type="hidden" name="xmlEliminacion" id="cxmlEliminacion" >
							<span class="input-group-btn">
                                <a class="btn btn-warning" onclick="$('#cxmlI').click();">&nbsp;&nbsp;&nbsp;Seleccionar Archivo</a>
                            </span>
                    	</div>        
                    </div>
					<span data-placement="bottom" data-toggle="tooltip" data-html="true" title="" data-original-title="
			<b>Ingrese el archivo .xml del comprobante fiscal</b>"><i class="fa fa-question-circle text-blue ayuda"></i></span>
                </div>
			
				<div class="form-group hide">
                    <label for="cfechamodificacion" class="col-sm-2 control-label">Última Modificación:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $fechamodificacion; ?>" name="fechamodificacion" type="date" required="required" class="form-control" id="cfechamodificacion" />
            			
						
                    </div>
					
                </div>
			
				<div class="form-group hide">
                    <label for="ctablareferencia" class="col-sm-2 control-label">Tabla Referencia:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $tablareferencia; ?>" name="tablareferencia" type="hidden" class="form-control" id="ctablareferencia" />
            			
						
                    </div>
					
                </div>
			
				<div class="form-group hide">
                    <label for="cidreferencia" class="col-sm-2 control-label">Referencia:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $idreferencia; ?>" name="idreferencia" type="hidden" class="form-control" id="cidreferencia" />
            			
						
                    </div>
					
                </div>
			
				<div class="form-group ">
                    <label for="cserie" class="col-sm-2 control-label">Serie:</label>
                    <div class="col-sm-2">
                    	
                        <input value="<?php echo $serie; ?>" name="serie" type="text" class="form-control" id="cserie" />
            			
						
                    </div>
					
                </div>
			
				<div class="form-group ">
                    <label for="cfolio" class="col-sm-2 control-label">Folio:</label>
                    <div class="col-sm-2">
                    	
                        <input value="<?php echo $folio; ?>" name="folio" type="text" class="form-control" id="cfolio" />
            			
						
                    </div>
					
                </div>
			
				<div class="form-group ">
                    <label for="ctipo" class="col-sm-2 control-label">Tipo:</label>
                    <div class="col-sm-2">
                    	
                        <input value="<?php echo $tipo; ?>" name="tipo" type="text" class="form-control" id="ctipo" />
            			
						
                    </div>
					
                </div>
			
				<div class="form-group ">
                    <label for="cfechatimbre" class="col-sm-2 control-label">Fecha Timbrado:</label>
                    <div class="col-sm-3">
                    	
                        <input value="<?php echo $fechatimbre; ?>" name="fechatimbre" type="text" class="form-control" id="cfechatimbre" />
            			
						
                    </div>
					
                </div>
			
				<div class="form-group ">
                    <label for="cemisor" class="col-sm-2 control-label">Emisor:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $emisor; ?>" name="emisor" type="text" class="form-control" id="cemisor" />
            			
						
                    </div>
					
                </div>
			
				<div class="form-group ">
                    <label for="crfcemisor" class="col-sm-2 control-label">RFC Emisor:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $rfcemisor; ?>" name="rfcemisor" type="text" class="form-control" id="crfcemisor" />
            			
						
                    </div>
					
                </div>
			
				<div class="form-group ">
                    <label for="creceptor" class="col-sm-2 control-label">Receptor:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $receptor; ?>" name="receptor" type="text" class="form-control" id="creceptor" />
            			
						
                    </div>
					
                </div>
			
				<div class="form-group ">
                    <label for="crfcreceptor" class="col-sm-2 control-label">RFC Receptor:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $rfcreceptor; ?>" name="rfcreceptor" type="text" class="form-control" id="crfcreceptor" />
            			
						
                    </div>
					
                </div>
			
				<div class="form-group ">
                    <label for="cmonto" class="col-sm-2 control-label">Monto:</label>
                    <div class="col-sm-2">
                    	
                        <input value="<?php echo $monto; ?>" name="monto" type="text" class="form-control" id="cmonto" />
            			
						
                    </div>
					
                </div>
			
				<div class="form-group ">
                    <label for="cuuid" class="col-sm-2 control-label">UUID:</label>
                    <div class="col-sm-5">
                    	
                        <input value="<?php echo $uuid; ?>" name="uuid" type="text" class="form-control" id="cuuid" />
            			
						
                    </div>
					
                </div>
			
			</div><!-- /.box-body -->
                
                <div class="box-footer">
				  <input name="idarchivo" type="hidden" id="cidarchivo" value="<?php echo $id;?>"/>
                  <button type="button" class="btn btn-default" id="botonCancelar" onclick="vaciarCampos();">Limpiar</button>
                  <button type="button" class="btn btn-primary pull-right" id="botonGuardar"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Guardar</button>
                </div><!-- /.box-footer -->
              </form>
              <div id="loading" class="overlay" style="display:none">
  					<i class="fa fa-cog fa-spin" style="color:#ebbd45"></i>
			  </div>
              
            </div><!-- /.box -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

	  <?php include("../../../componentes/pie.php");?>
    </div><!-- ./wrapper -->
</body>
</html>