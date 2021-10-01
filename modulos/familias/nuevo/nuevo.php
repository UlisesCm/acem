<?php 
include ("../../seguridad/comprobar_login.php");
?>
<!DOCTYPE html>
<html>
  <head>
    <?php include ("../../../componentes/cabecera.php")?>
    <link href="../../../librerias/js/Spry/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
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
    <script src="../../../librerias/js/Spry/SpryValidationTextField.js" type="text/javascript"></script>
   	<style>
		.todo-list>li.done .label{
			background:#C00!important;
		}
		.label2 {
			margin-left: 10px;
    		font-size: 9px;
		}
    </style>
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
          <h1>Familia<small>Nuevo registro</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Nueva familia</a></li>
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
        
        <?php include ("../componentes/modal.php");?>
		
		<!-- Contenido principal -->
        <section class="content">
		
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['familias']['guardar']) or  !isset($_SESSION['permisos']['familias']['acceso'])){
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
            <div class="box box-info" style="border-color:#9f2d6b">
              <div class="box-header with-border">
                <h3 class="box-title">Formulario de registro</h3>
              </div><!-- /.box-header -->
              <!-- form start -->
			  <form class="form-horizontal" name="formulario" id="formulario" method="post">
                <div class="box-body">
				
				<div class="form-group ">
                    <label for="cnombre" class="col-sm-2 control-label">Nombre:</label>
                    <div class="col-sm-5">
                    	<span id="Vnombre">
                        <input value="" name="nombre" type="text" class="form-control" id="cnombre" />
            			<span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="x" class="col-sm-2 control-label">&nbsp;</label>
                    <div class="col-sm-10">
                    	<label>
                  			<input id="cmostrarendescripcion" type="checkbox" name="mostrarendescripcion" value="si" >
                  			Mostrar en descripción
                 		</label>
                    </div>
                </div>
				
				<div class="form-group ">
                    <label for="cnombredescripcion" class="col-sm-2 control-label">Nombre en descripción:</label>
                    <div class="col-sm-5">
                    	
                        <input value="" name="nombredescripcion" type="text" class="form-control" id="cnombredescripcion" />
            			
						
                    </div>
                </div>
			
				
				<div class="form-group ">
                    <label for="cprefijocodigo" class="col-sm-2 control-label">Prefijo en código:</label>
                    <div class="col-sm-2">
                        <input value="" name="prefijocodigo" type="text" class="form-control" id="cprefijocodigo" />
                    </div>
                </div>
                
                <div class="form-group ">
                    <label for="cidfamiliamadre" class="col-sm-2 control-label">Familia madre:</label>
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
                
                <div class="form-group ">
                    <label for="cprefijocodigo" class="col-sm-2 control-label">Características:</label>
                    <div class="col-sm-7">
                    
                    
                    	<ul id="tablaOrden" class="todo-list ui-sortable">
                        	<li class="" style="">
                                <span class="handle ui-sortable-handle">
                                    <i class="fa fa-ellipsis-v"></i>
                                    <i class="fa fa-ellipsis-v"></i>
                                </span>
                                
                                <span class="text">
                                	<input type="checkbox" value="pesoteorico" id="propiedad0" class="activeCampos prop" onClick="recorrerTablaOrden('tablaOrden','ccamposrequeridos')">
                                    <label for="propiedad0" class="control-label"> Peso teórico</label>
                                    
                                </span>
                                
                                  
                                <div class="tools" style="display:inline-block">
                                	<input type="hidden" id="orden0" value="" class="activeCampos orden">
                                	<input type="checkbox" value="tipo" id="mostrar0" class="activeCampos corden" onClick="recorrerTablaOrden('tablaOrden','ccamposrequeridos')">
                                    <label for="mostrar0" class="control-label"> Mostrar</label>
                                    <small class="label" style="background-color:#C00"></small>
                                    <input type="hidden" id="caracteristicaspesoteorico" value="" class="caracteristicas">
                                </div>
                            </li>
                            
                            
                            <li class="" style="">
                                <span class="handle ui-sortable-handle">
                                    <i class="fa fa-ellipsis-v"></i>
                                    <i class="fa fa-ellipsis-v"></i>
                                </span>
                                
                                <span class="text">
                                	<input type="checkbox" value="espesor" id="propiedad1" class="activeCampos prop" onClick="recorrerTablaOrden('tablaOrden','ccamposrequeridos')">
                                    <label for="propiedad1" class="control-label"> Calibre / Grosor / Espesor</label>
                                    
                                </span>
                                
                                  
                                <div class="tools" style="display:inline-block">
                                	<input type="hidden" id="orden1" value="" class="activeCampos orden">
                                    
                                	<input type="checkbox" value="tipo" id="mostrar1" class="activeCampos corden" onClick="recorrerTablaOrden('tablaOrden','ccamposrequeridos')">
                                    <label for="mostrar1" class="control-label"> Mostrar</label>
                                    <small class="label" style="background-color:#C00"></small>
                                    <input type="hidden" id="caracteristicasespesor" value="" class="caracteristicas">
                                    <a style="display:none" class="btn btn-warning btn-xs label2" id="Bespesor" onClick="abrirModal('espesor');"><i class="fa fa-gear"></i> Configurar</a>
                                </div>
                            </li>
                            
                            <li class="" style="">
                                <span class="handle ui-sortable-handle">
                                    <i class="fa fa-ellipsis-v"></i>
                                    <i class="fa fa-ellipsis-v"></i>
                                </span>
                                
                                <span class="text">
                                	<input type="checkbox" value="ancho" id="propiedad2"  class="activeCampos prop" onClick="recorrerTablaOrden('tablaOrden','ccamposrequeridos')">
                                    <label for="propiedad2" class="control-label"> Ancho</label>
                                    
                                </span>
                                
                                  
                                <div class="tools" style="display:inline-block">
                                	<input type="hidden" id="orden2" value="" class="activeCampos orden">
                                	<input type="checkbox" value="tipo" id="mostrar2" class="activeCampos corden" onClick="recorrerTablaOrden('tablaOrden','ccamposrequeridos')">
                                    <label for="mostrar2" class="control-label"> Mostrar</label>
                                    <small class="label" style="background-color:#C00"></small>
                                    <input type="hidden" id="caracteristicasancho" value="" class="caracteristicas">
                                    <a style="display:none" class="btn btn-warning btn-xs label2" id="Bancho" onClick="abrirModal('ancho');"><i class="fa fa-gear"></i>Configurar</a>
                                </div>
                            </li>
                            
                            
                            <li class="" style="">
                                <span class="handle ui-sortable-handle">
                                    <i class="fa fa-ellipsis-v"></i>
                                    <i class="fa fa-ellipsis-v"></i>
                                </span>
                                
                                <span class="text">
                                	<input type="checkbox" value="color" id="propiedad3" class="activeCampos prop" onClick="recorrerTablaOrden('tablaOrden','ccamposrequeridos')">
                                    <label for="propiedad3" class="control-label"> Color</label>
                                    
                                </span>
                                
                                  
                                <div class="tools" style="display:inline-block">
                                	<input type="hidden" id="orden3" value="" class="activeCampos orden">
                                	<input type="checkbox" value="tipo" id="mostrar3" class="activeCampos corden" onClick="recorrerTablaOrden('tablaOrden','ccamposrequeridos')">
                                    <label for="mostrar3" class="control-label"> Mostrar</label>
                                    <small class="label" style="background-color:#C00"></small>
                                    <input type="hidden" id="caracteristicascolor" value="" class="caracteristicas">
                                    <a style="display:none" class="btn btn-warning btn-xs label2" id="Bcolor" onClick="abrirModal('color');"><i class="fa fa-gear"></i>Configurar</a>
                                </div>
                            </li>
                            
                            <li class="" style="">
                                <span class="handle ui-sortable-handle">
                                    <i class="fa fa-ellipsis-v"></i>
                                    <i class="fa fa-ellipsis-v"></i>
                                </span>
                                
                                <span class="text">
                                	<input type="checkbox" value="diametro" id="propiedad4"  class="activeCampos prop" onClick="recorrerTablaOrden('tablaOrden','ccamposrequeridos')">
                                    <label for="propiedad4" class="control-label"> Diámetro</label>
                                    
                                </span>
                                
                                  
                                <div class="tools" style="display:inline-block">
                                	<input type="hidden" id="orden4" value="" class="activeCampos orden">
                                	<input type="checkbox" value="tipo" id="mostrar4" class="activeCampos corden" onClick="recorrerTablaOrden('tablaOrden','ccamposrequeridos')">
                                    <label for="mostrar4" class="control-label"> Mostrar</label>
                                    <small class="label" style="background-color:#C00"></small>
                                    <input type="hidden" id="caracteristicasdiametro" value="" class="caracteristicas">
                                    <a style="display:none" class="btn btn-warning btn-xs label2" id="Bdiametro" onClick="abrirModal('diametro');"><i class="fa fa-gear"></i>Configurar</a>
                                </div>
                            </li>
                            
                            <li class="" style="">
                                <span class="handle ui-sortable-handle">
                                    <i class="fa fa-ellipsis-v"></i>
                                    <i class="fa fa-ellipsis-v"></i>
                                </span>
                                
                                <span class="text">
                                	<input type="checkbox" value="lado" id="propiedad5" class="activeCampos prop" onClick="recorrerTablaOrden('tablaOrden','ccamposrequeridos')">
                                    <label for="propiedad5" class="control-label"> Lado</label>
                                    
                                </span>
                                
                                  
                                <div class="tools" style="display:inline-block">
                                	<input type="hidden" id="orden5" value="" class="activeCampos orden">
                                	<input type="checkbox" value="tipo" id="mostrar5" class="activeCampos corden" onClick="recorrerTablaOrden('tablaOrden','ccamposrequeridos')">
                                    <label for="mostrar5" class="control-label"> Mostrar</label>
                                    <small class="label" style="background-color:#C00"></small>
                                    <input type="hidden" id="caracteristicaslado" value="" class="caracteristicas">
                                    <a style="display:none" class="btn btn-warning btn-xs label2" id="Blado" onClick="abrirModal('lado');"><i class="fa fa-gear"></i>Configurar</a>
                                </div>
                            </li>
                            
                            <li class="" style="">
                                <span class="handle ui-sortable-handle">
                                    <i class="fa fa-ellipsis-v"></i>
                                    <i class="fa fa-ellipsis-v"></i>
                                </span>
                                
                                <span class="text">
                                	<input type="checkbox" value="tipo" id="propiedad6" class="activeCampos prop" onClick="recorrerTablaOrden('tablaOrden','ccamposrequeridos')">
                                    <label for="propiedad6" class="control-label"> Tipo</label>
                                    
                                </span>
                                
                                  
                                <div class="tools" style="display:inline-block">
                                	<input type="hidden" id="orden6" value="" class="activeCampos orden">
                                	<input type="checkbox" value="tipo" id="mostrar6" class="activeCampos corden" onClick="recorrerTablaOrden('tablaOrden','ccamposrequeridos')">
                                    <label for="mostrar6" class="control-label"> Mostrar</label>
                                    <small class="label" style="background-color:#C00"></small>
                                    <input type="hidden" id="caracteristicastipo" value="" class="caracteristicas">
                                    <a style="display:none" class="btn btn-warning btn-xs label2" id="Btipo" onClick="abrirModal('tipo');"><i class="fa fa-gear"></i>Configurar</a>
                                </div>
                            </li>
                            
                            <li class="" style="">
                                <span class="handle ui-sortable-handle">
                                    <i class="fa fa-ellipsis-v"></i>
                                    <i class="fa fa-ellipsis-v"></i>
                                </span>
                                
                                <span class="text">
                                	<input type="checkbox" value="marca" id="propiedad7" class="activeCampos prop" onClick="recorrerTablaOrden('tablaOrden','ccamposrequeridos')">
                                    <label for="propiedad7" class="control-label"> Marca</label>
                                    
                                </span>
                                
                                  
                                <div class="tools" style="display:inline-block">
                                	<input type="hidden" id="orden7" value="" class="activeCampos orden">
                                	<input type="checkbox" value="tipo" id="mostrar7" class="activeCampos corden" onClick="recorrerTablaOrden('tablaOrden','ccamposrequeridos')">
                                    <label for="mostrar7" class="control-label"> Mostrar</label>
                                    <small class="label" style="background-color:#C00"></small>
                                    <input type="hidden" id="caracteristicasmarca" value="" class="caracteristicas">
                                    <a style="display:none" class="btn btn-warning btn-xs label2" id="Bmarca" onClick="abrirModal('marca');"><i class="fa fa-gear"></i>Configurar</a>
                                </div>
                            </li>
                            
                            <li class="" style="">
                                <span class="handle ui-sortable-handle">
                                    <i class="fa fa-ellipsis-v"></i>
                                    <i class="fa fa-ellipsis-v"></i>
                                </span>
                                
                                <span class="text">
                                	<input type="checkbox" value="alto" id="propiedad8" class="activeCampos prop" onClick="recorrerTablaOrden('tablaOrden','ccamposrequeridos')">
                                    <label for="propiedad8" class="control-label"> Alto</label>
                                </span>
                                
                                  
                                <div class="tools" style="display:inline-block">
                                	<input type="hidden" id="orden8" value="" class="activeCampos orden">
                                	<input type="checkbox" value="alto" id="mostrar8" class="activeCampos corden" onClick="recorrerTablaOrden('tablaOrden','ccamposrequeridos')">
                                    <label for="mostrar8" class="control-label"> Mostrar</label>
                                    <small class="label" style="background-color:#C00"></small>
                                    <input type="hidden" id="caracteristicasalto" value="" class="caracteristicas">
                                    <a style="display:none" class="btn btn-warning btn-xs label2" id="Balto" onClick="abrirModal('alto');"><i class="fa fa-gear"></i>Configurar</a>
                                </div>
                            </li>
                            
                            
                            <li class="" style="">
                                <span class="handle ui-sortable-handle">
                                    <i class="fa fa-ellipsis-v"></i>
                                    <i class="fa fa-ellipsis-v"></i>
                                </span>
                                
                                <span class="text">
                                	<input type="checkbox" value="aplicacion" id="propiedad9" class="activeCampos prop" onClick="recorrerTablaOrden('tablaOrden','ccamposrequeridos')">
                                    <label for="propiedad9" class="control-label"> Aplicación</label>
                                    
                                </span>
                                
                                  
                                <div class="tools" style="display:inline-block">
                                	<input type="hidden" id="orden9" value="" class="activeCampos orden">
                                	<input type="checkbox" value="aplicacion" id="mostrar9" class="activeCampos corden" onClick="recorrerTablaOrden('tablaOrden','ccamposrequeridos')">
                                    <label for="mostrar9" class="control-label"> Mostrar</label>
                                    <small class="label" style="background-color:#C00"></small>
                                    <input type="hidden" id="caracteristicasaplicacion" value="" class="caracteristicas">
                                    <a style="display:none" class="btn btn-warning btn-xs label2" id="Baplicacion" onClick="abrirModal('aplicacion');"><i class="fa fa-gear"></i>Configurar</a>
                                </div>
                            </li>
                            
                            <li class="" style="">
                                <span class="handle ui-sortable-handle">
                                    <i class="fa fa-ellipsis-v"></i>
                                    <i class="fa fa-ellipsis-v"></i>
                                </span>
                                
                                <span class="text">
                                	<input type="checkbox" value="modelo" id="propiedad10" class="activeCampos prop" onClick="recorrerTablaOrden('tablaOrden','ccamposrequeridos')">
                                    <label for="propiedad10" class="control-label"> Modelo A</label>
                                    
                                </span>
                                
                                  
                                <div class="tools" style="display:inline-block">
                                	<input type="hidden" id="orden10" value="" class="activeCampos orden">
                                	<input type="checkbox" value="modelo2" id="mostrar10" class="activeCampos corden" onClick="recorrerTablaOrden('tablaOrden','ccamposrequeridos')">
                                    <label for="mostrar10" class="control-label"> Mostrar</label>
                                    <small class="label" style="background-color:#C00"></small>
                                    <input type="hidden" id="caracteristicasmodelo2" value="" class="caracteristicas">
                                </div>
                            </li>
                            
                            <li class="" style="">
                                <span class="handle ui-sortable-handle">
                                    <i class="fa fa-ellipsis-v"></i>
                                    <i class="fa fa-ellipsis-v"></i>
                                </span>
                                
                                <span class="text">
                                	<input type="checkbox" value="modelo2" id="propiedad13" class="activeCampos prop" onClick="recorrerTablaOrden('tablaOrden','ccamposrequeridos')">
                                    <label for="propiedad13" class="control-label"> Modelo B</label>
                                    
                                </span>
                                
                                  
                                <div class="tools" style="display:inline-block">
                                	<input type="hidden" id="orden13" value="" class="activeCampos orden">
                                	<input type="checkbox" value="modelo" id="mostrar13" class="activeCampos corden" onClick="recorrerTablaOrden('tablaOrden','ccamposrequeridos')">
                                    <label for="mostrar13" class="control-label"> Mostrar</label>
                                    <small class="label" style="background-color:#C00"></small>
                                    <input type="hidden" id="caracteristicasmodelo" value="" class="caracteristicas">
                                </div>
                            </li>
                            
                            <li class="" style="">
                                <span class="handle ui-sortable-handle">
                                    <i class="fa fa-ellipsis-v"></i>
                                    <i class="fa fa-ellipsis-v"></i>
                                </span>
                                
                                <span class="text">
                                	<input type="checkbox" value="largo" id="propiedad11" class="activeCampos prop" onClick="recorrerTablaOrden('tablaOrden','ccamposrequeridos')">
                                    <label for="propiedad11" class="control-label"> Largo</label>
                                    
                                </span>
                                
                                  
                                <div class="tools" style="display:inline-block">
                                	<input type="hidden" id="orden11" value="" class="activeCampos orden">
                                	<input type="checkbox" value="largo" id="mostrar11" class="activeCampos corden" onClick="recorrerTablaOrden('tablaOrden','ccamposrequeridos')">
                                    <label for="mostrar11" class="control-label"> Mostrar</label>
                                    <small class="label" style="background-color:#C00"></small>
                                    <input type="hidden" id="caracteristicaslargo" value="" class="caracteristicas">
                                    <a style="display:none" class="btn btn-warning btn-xs label2" id="Blargo" onClick="abrirModal('largo');"><i class="fa fa-gear"></i>Configurar</a>
                                </div>
                            </li>
                            
                            
                            <li class="" style="">
                                <span class="handle ui-sortable-handle">
                                    <i class="fa fa-ellipsis-v"></i>
                                    <i class="fa fa-ellipsis-v"></i>
                                </span>
                                
                                <span class="text">
                                	<input type="checkbox" value="clave" id="propiedad12" class="activeCampos prop" onClick="recorrerTablaOrden('tablaOrden','ccamposrequeridos')">
                                    <label for="propiedad12" class="control-label"> Código</label>
                                    
                                </span>
                                
                                  
                                <div class="tools" style="display:inline-block">
                                	<input type="hidden" id="orden12" value="" class="activeCampos orden">
                                	<input type="checkbox" value="clave" id="mostrar12" class="activeCampos corden" onClick="recorrerTablaOrden('tablaOrden','ccamposrequeridos')">
                                    <label for="mostrar12" class="control-label"> Mostrar</label>
                                    <small class="label" style="background-color:#C00"></small>
                                    <input type="hidden" id="caracteristicasclave" value="" class="caracteristicas">
                                </div>
                            </li>
                            
                            
                        </ul>
                    </div>
                </div>
                
                
			
				
				<div class="form-group hide">
                    <label for="ccamposrequeridos" class="col-sm-2 control-label">Campos requeridos:</label>
                    <div class="col-sm-5">
                        <input value="" name="camposrequeridos" type="text" class="form-control" id="ccamposrequeridos" />
                    </div>
                </div>
			
				
				
			
				
				<div class="form-group hide">
                    <label for="cestatus" class="col-sm-2 control-label">Estatus:</label>
                    <div class="col-sm-5">
                    	
                        <input value="activo" name="estatus" type="hidden" class="form-control" id="cestatus" />
            			
						
                    </div>
                </div>
                
                
			
			</div><!-- /.box-body -->
                
                <div class="box-footer">
                  <button type="button" class="btn btn-default" id="botonCancelar" onclick="vaciarCampos();">Limpiar</button>
                  <button type="button" class="btn btn-primary pull-right" id="botonGuardar"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Guardar</button>
                </div><!-- /.box-footer -->
              </form>
              <div id="loading" class="overlay" style="display:none">
  					<i class="fa fa-cog fa-spin" style="color:#9f2d6b"></i>
			  </div>
              
            </div><!-- /.box -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

	  <?php include("../../../componentes/pie.php");?>
    </div><!-- ./wrapper -->
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("Vnombre", "none", {validateOn:["blur"],  maxChars:50,  minChars:1});
				
</script>

</body>
</html>