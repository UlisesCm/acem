<?php 
include ("../../seguridad/comprobar_login.php");
include ("../../../librerias/php/variasfunciones.php");
include ("recuperarValores.php");
?>
<!DOCTYPE html>
<html>
  <head>
	<?php include ("../../../componentes/cabecera.php")?><link type="text/css" rel="stylesheet" href="../../../librerias/js/editor/jquery-te-1.4.0.css"><link type="text/css" rel="stylesheet" href="../../../librerias/js/editor/jquery-te-1.4.0.css">
<script src="../../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="../../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../../../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="../../../plugins/fastclick/fastclick.min.js"></script>
<script type="text/javascript" src="../../../librerias/js/editor/jquery-te-1.4.0.min.js" charset="utf-8"></script>
<script src="../../../dist/js/app.min.js" type="text/javascript"></script>
<script src="js.js?v1"></script>
<script src="../../../librerias/js/cookies.js"></script>
<script src="../../../librerias/js/jquery-filestyle.min.js"></script>

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
          <h1>Configuración
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Modificar configuración</a></li>
          </ol>
        </section>
		
		<!-- Contenido principal -->
        <section class="content">
		
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['configuracion']['modificar']) or  !isset($_SESSION['permisos']['configuracion']['acceso'])){
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
                <h3 class="box-title">Configuración</h3>
              </div><!-- /.box-header -->
              <!-- form start -->
			  <form class="form-horizontal" name="formulario" id="formulario" method="post" enctype="multipart/form-data">
              
              
              
              
              	<div class="box box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title"></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="box-group" id="accordion">
                  
                    <!-- Acordion -->
                    <div class="panel box box-primary">
                      <div class="box-header with-border">
                        <h4 class="box-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" class="collapsed">
                            Configuración General
                          </a>
                        </h4>
                      </div>
                      <div id="collapseOne" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                        <div class="box-body">
                        
                        	
                            
                          	<div class="form-group">
                                <label for="ctipoempresa" class="col-sm-2 control-label">Plantilla de productos: </label>
                                <div class="col-sm-5">
                                    <select id="ctipoempresa" name="tipoempresa" class="form-control">
                                                    <option value="Estandar" <?php 
                                                        if ($tipoempresa=="Estandar"){
                                                            echo 'selected="selected"';
                                                        }
                                                         ?>>Estandar</option>
                                                    
                                                    <option value="Boutique" <?php 
                                                        if ($tipoempresa=="Boutique"){
                                                            echo 'selected="selected"';
                                                        }
                                                         ?>>Boutique y Zapatería</option>
                                                    
                                                    <option value="Farmacia" <?php 
                                                        if ($tipoempresa=="Farmacia"){
                                                            echo 'selected="selected"';
                                                        }
                                                         ?>>Farmacia</option>
                                                    
                                    </select>
                                </div> 
                            </div> <!--Fin form-group-->
                            
                        </div>
                      </div>
                    </div> <!-- FIN Acordion -->
                    
                    
                    <!-- Acordion -->
                    <div class="panel box box-primary">
                      <div class="box-header with-border">
                        <h4 class="box-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapse2" aria-expanded="false" class="collapsed">
                            Configuración de impresión de tickets
                          </a>
                        </h4>
                      </div>
                      <div id="collapse2" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                        <div class="box-body">
                        	<div class="form-group">
                                <label for="ccabeceraimpresion" class="col-sm-2 control-label">Cabecera Ticket:</label>
                                <div class="col-sm-5">
                                    
                                    <input value="<?php echo $cabeceraimpresion; ?>" name="cabeceraimpresion" type="text" class="jqte-test" id="ccabeceraimpresion" style="width:col-sm-5px;"/>
                                    
                                    
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="x" class="col-sm-2 control-label">&nbsp;</label>
                                <div class="col-sm-10">
                                    <label>
                                        <?php 
                                            $checked="";
                                            if($mostrarlogo=="si"){
                                                $checked="checked='checked'";
                                            }
                                        ?>
                                        <input id="cmostrarlogo" type="checkbox" name="mostrarlogo" value="si" <?php echo $checked; ?>>
                                         Mostrar logotipo en el Ticket
                                    </label>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="x" class="col-sm-2 control-label">Logo del ticket:</label>
                                <div class="col-sm-5">
                                    <div class="input-group">
                                        <input type="file" name="logoticketI" style="display:none;" id="clogoticketI" accept=".jpg" onChange="fileinput('logoticket')"/>
                                        <input value="<?php echo $logoticket; ?>" type="text" name="logoticket" id="clogoticket" class="form-control" placeholder="Seleccionar Imagen" readonly >
                                        <input value="<?php echo $logoticket; ?>" type="hidden" name="logoticketEliminacion" id="clogoticketEliminacion" >
                                        <span class="input-group-btn">
                                            <a class="btn btn-success" onclick="$('#clogoticketI').click();">&nbsp;&nbsp;&nbsp;Seleccionar Imagen</a>
                                        </span>
                                    </div>        
                                </div>
                            </div>
                        
                            <div class="form-group">
                                <label for="cpieimpresion" class="col-sm-2 control-label">Pie Ticket:</label>
                                <div class="col-sm-5">
                                    
                                    <input value="<?php echo $pieimpresion; ?>" name="pieimpresion" type="text" class="jqte-test" id="cpieimpresion" style="width:col-sm-5px;"/>
                                    
                                    
                                </div>
                            </div>
                        
                            <div class="form-group">
                                <label for="cseparadorimpresion" class="col-sm-2 control-label">Separador:</label>
                                <div class="col-sm-5">
                                    <select id="cseparadorimpresion" name="separadorimpresion" class="form-control">
                                                    <option value="dotted" <?php 
                                                        if ($separadorimpresion=="dotted"){
                                                            echo 'selected="selected"';
                                                        }
                                                         ?>>Punteado</option>
                                                    
                                                    <option value="solid" <?php 
                                                        if ($separadorimpresion=="solid"){
                                                            echo 'selected="selected"';
                                                        }
                                                         ?>>Continuo</option>
                                                    
                                                    <option value="dashed" <?php 
                                                        if ($separadorimpresion=="dashed"){
                                                            echo 'selected="selected"';
                                                        }
                                                         ?>>Discontinuo</option>
                                                    
                                                    <option value="double" <?php 
                                                        if ($separadorimpresion=="double"){
                                                            echo 'selected="selected"';
                                                        }
                                                         ?>>Doble</option>
                                                    
                                    </select>
                                </div> 
                            </div>
                            <div class="form-group hide">
                                <label for="x" class="col-sm-2 control-label">&nbsp;</label>
                                <div class="col-sm-10">
                                    <label>
                                        <?php 
                                            $checked="";
                                            if($descripcioncompletaimpresion=="si"){
                                                $checked="checked='checked'";
                                            }
                                        ?>
                                        <input id="cdescripcioncompletaimpresion" type="checkbox" name="descripcioncompletaimpresion" value="si" <?php echo $checked; ?>>
                                         Descripción completa
                                    </label>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="x" class="col-sm-2 control-label">&nbsp;</label>
                                <div class="col-sm-10">
                                    <label>
                                        <?php 
                                            $checked="";
                                            if($cbticket=="si"){
                                                $checked="checked='checked'";
                                            }
                                        ?>
                                        <input id="ccbticket" type="checkbox" name="cbticket" value="si" <?php echo $checked; ?>>
                                         Mostrar el Código de barras en la descripción del producto / servicio
                                    </label>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="x" class="col-sm-2 control-label">&nbsp;</label>
                                <div class="col-sm-10">
                                    <label>
                                        <?php 
                                            $checked="";
                                            if($nombreproducticket=="si"){
                                                $checked="checked='checked'";
                                            }
                                        ?>
                                        <input id="cnombreproducticket" type="checkbox" name="nombreproducticket" value="si" <?php echo $checked; ?>>
                                         Mostrar el Nombre en la descripción del producto / servicio
                                    </label>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="x" class="col-sm-2 control-label">&nbsp;</label>
                                <div class="col-sm-10">
                                    <label>
                                        <?php 
                                            $checked="";
                                            if($modeloticket=="si"){
                                                $checked="checked='checked'";
                                            }
                                        ?>
                                        <input id="cmodeloticket" type="checkbox" name="modeloticket" value="si" <?php echo $checked; ?>>
                                         Mostrar el Modelo, Línea o Sustancia en la descripción del producto / servicio
                                    </label>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="x" class="col-sm-2 control-label">&nbsp;</label>
                                <div class="col-sm-10">
                                    <label>
                                        <?php 
                                            $checked="";
                                            if($generoticket=="si"){
                                                $checked="checked='checked'";
                                            }
                                        ?>
                                        <input id="cgeneroticket" type="checkbox" name="generoticket" value="si" <?php echo $checked; ?>>
                                         Mostrar el Género o presentación en la descripción del producto / servicio
                                    </label>
                                </div>
                            </div>
                            
                            
                        </div>
                      </div>
                    </div> <!-- FIN Acordion -->
                    
                    
                    
                   
                  </div>
                </div><!-- /.box-body -->
              </div>
              
              
              
              
                <div class="box-body">
				
                
			</div><!-- /.box-body -->
                
                <div class="box-footer">
				  <input name="idconfiguracion" type="hidden" id="cidconfiguracion" value="<?php echo $id;?>"/>
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