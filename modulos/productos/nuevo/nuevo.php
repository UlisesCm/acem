<?php 
include ("../../seguridad/comprobar_login.php");
?>
<!DOCTYPE html>
<html>
  <head>
    <?php include ("../../../componentes/cabecera.php")?>
    <link href="../../../librerias/js/Spry/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="../../../dist/css/jtree/style.min.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="../../../dist/css/autocompletar/jqueryui.css" />
	<script src="../../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
	<script src="../../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="../../../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
	<script src="../../../plugins/fastclick/fastclick.min.js"></script>
	<script src="../../../dist/js/app.min.js" type="text/javascript"></script>
	<script src="js.js?v1.1"></script>
    <script src="../../../librerias/js/jquery-ui.js"></script>
	<script src="../../../librerias/js/jstree.min.js"></script>
	<script src="../../../librerias/js/cookies.js"></script>
	<script src="../../../librerias/js/validaciones.js"></script><script src="../../../librerias/js/Spry/SpryValidationTextField.js" type="text/javascript"></script>
    <style>
	 .cajaActiva{
		 border:1px #39F dashed;  padding-bottom:4px; border-radius:10px;
	 }
	 .cajaClave{
		 border: 2px #39F solid; border-radius:8px; padding-left:5px; color:#39F; font-size:10px; width:100%; height:20px;
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
          <h1>Producto<small>Nuevo registro</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Nuevo producto</a></li>
          </ol>
        </section>
		
		<!-- Contenido principal -->
        <section class="content">
		
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['productos']['guardar']) or  !isset($_SESSION['permisos']['productos']['acceso'])){
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
            <div class="box box-info" style="border-color:#494441">
              <div class="box-header with-border">
                <h3 class="box-title">Formulario de registro</h3>
              </div><!-- /.box-header -->
              <!-- form start -->
			  <form class="form-horizontal" name="formulario" id="formulario" method="post">
                <div class="box-body">
                
                
                <div class="form-group">
                    <label for="cnombre" class="col-sm-2 control-label">Familia:</label>
                    <div class="col-sm-5">
                        <div id="arbol_ajax">
                		</div>
                    </div>
                </div>
                
                <div class="form-group hide">
                    <label for="cidfamilia" class="col-sm-2 control-label">ID Familia:</label>
                    <div class="col-sm-5">
                        <input value="" name="idfamilia" type="text" class="form-control" id="cidfamilia" />
                    </div>
                </div>
				
				<div class="form-group ">
                    <label for="cnombre" class="col-sm-2 control-label">Nombre:</label>
                    <div class="col-sm-8">
                    	<span id="Vnombre">
                        <input value="" name="nombre" type="text" class="form-control" id="cnombre" readonly/>
            			<span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span>
					<span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span>
						<span class="textfieldRequiredMsg">Se necesita un valor.</span>
					</span>
                    </div>
                </div>
			
				
				<div class="form-group hide">
                    <label for="ccodigo" class="col-sm-2 control-label">Codigo:</label>
                    <div class="col-sm-5">
                        <input value="" name="codigo" type="text" class="form-control" id="ccodigo" />
                    </div>
                </div>
			
				<div class="form-group ">
                    <label for="x" class="col-sm-2 control-label">&nbsp;</label>
                    <div class="col-sm-10">
                    	<label>
                  			<input id="cautoclasificar" type="checkbox" name="autoclasificar" value="si" >
                  			Auto clasificar ABC
                 		</label>
                    </div>
                </div>
				<div class="form-group ">
                  	<label for="cclasificacion" class="col-sm-2 control-label">Clasificación:</label>
                    <div class="col-sm-5">
                    	<select id="cclasificacion" name="clasificacion" class="form-control">
							<option value="A">A</option>
							<option value="B">B</option>
							<option value="C">C</option>
						</select>
                    </div> 
                </div>
                <div class="form-group hide">
                  	<label for="ccosto" class="col-sm-2 control-label">Costo unitario:</label>
                    <div class="col-sm-2">
                      <input type="text" class="form-control" name="costo" id="ccosto" value="1">
                    </div> 
                </div>
                
				<div class="form-group ">
                  	<label for="selectidmodeloimpuestos_ajax" class="col-sm-2 control-label">Impuestos:</label>
                    <div class="col-sm-5">
                      <select id="idmodeloimpuestos_ajax" name="idmodeloimpuestos" class="form-control">
                      </select>
                    </div> 
                </div>
				
				<div class="form-group ">
                    <label for="cidcategoria" class="col-sm-2 control-label">Categoría SAT:</label>
                    <div class="col-sm-5">
                    <input value="" name="idcategoria" type="hidden" class="normal" id="cidcategoria" style="width:50px;"/>
                    <input value="" name="consultaidcategoria" type="hidden" class="normal" id="consultaidcategoria" style="width:100px;"/>
                    <input value="" name="autoidcategoria" type="text" class="form-control" id="autoidcategoria" />
                    </div>
                </div>
				
				<div class="form-group ">
                  	<label for="selectidunidad_ajax" class="col-sm-2 control-label">Unidad SAT:</label>
                    <div class="col-sm-5">
                      <select id="idunidad_ajax" name="idunidad" class="form-control">
                      </select>
                    </div> 
                </div>
				
				<div class="form-group Lmarca"style="display:none;">
                  	<label for="cmarca" class="col-sm-2 control-label">Marca:</label>
                    <div class="col-sm-5">
                      <select id="cmarca" name="marca" class="form-control cmarca" onChange="agregarDescripcion()">
                        	<option value="" selected>Cargando datos...</option>
						</select>
                    </div> 
                </div>
				
				
				<div class="form-group Lpesoteorico" style="display:none;">
                    <label for="cpesoteorico" class="col-sm-2 control-label">Peso teórico:</label>
                    <div class="col-sm-2">
                        <input value="" name="pesoteorico" type="text" class="form-control cpesoteorico" id="cpesoteorico" onChange="agregarDescripcion()"/>
                    </div>
                </div>
			
				<div class="form-group Lespesor" style="display:none;">
                  	<label for="cespesor" class="col-sm-2 control-label">Grosor / Calibre:</label>
                    <div class="col-sm-5">
                    	<select id="cespesor" name="espesor" class="form-control cespesor" onChange="agregarDescripcion()">
                        	<option value="" selected>Cargando datos...</option>
						</select>
                    </div> 
                </div>
				<div class="form-group Lancho" style="display:none;">
                  	<label for="cancho" class="col-sm-2 control-label">Ancho:</label>
                    <div class="col-sm-5">
                    	<select id="cancho" name="ancho" class="form-control cancho" onChange="agregarDescripcion()">
                        	<option value="" selected>Seleccione uno</option>
						</select>
                    </div> 
                </div>
                
                <div class="form-group Lalto" style="display:none;">
                  	<label for="calto" class="col-sm-2 control-label">Alto:</label>
                    <div class="col-sm-5">
                    	<select id="calto" name="alto" class="form-control calto" onChange="agregarDescripcion()">
                        	<option value="" selected>Seleccione uno</option>
						</select>
                    </div> 
                </div>
				<div class="form-group Lcolor" style="display:none;">
                  	<label for="ccolor" class="col-sm-2 control-label">Color:</label>
                    <div class="col-sm-5">
                    	<select id="ccolor" name="color" class="form-control ccolor" onChange="agregarDescripcion()">
                        	<option value="" selected>Seleccione uno</option>
						</select>
                    </div> 
                </div>
				<div class="form-group Ldiametro" style="display:none;">
                  	<label for="cdiametro" class="col-sm-2 control-label">Diametro:</label>
                    <div class="col-sm-5">
                    	<select id="cdiametro" name="diametro" class="form-control cdiametro" onChange="agregarDescripcion()">
                        	<option value="" selected>Seleccione uno</option>
						</select>
                    </div> 
                </div>
				
				<div class="form-group Ltipo" style="display:none;">
                  	<label for="ctipo" class="col-sm-2 control-label">Tipo:</label>
                    <div class="col-sm-5">
                    	<select id="ctipo" name="tipo" class="form-control ctipo" onChange="agregarDescripcion()">
                        	<option value="" selected>Seleccione uno</option>
						</select>
                    </div> 
                </div>
			
				<div class="form-group Lclave" style="display:none;">
                    <label for="cclave" class="col-sm-2 control-label">Código:</label>
                    <div class="col-sm-2">
                        <input value="" name="clave" type="text" class="form-control cclave" id="cclave" onChange="agregarDescripcion()"/>
                    </div>
                </div>
                
				<div class="form-group Lmodelo" style="display:none;">
                    <label for="cmodelo" class="col-sm-2 control-label">Modelo A:</label>
                    <div class="col-sm-3">
                        <input value="" name="modelo" type="text" class="form-control cmodelo" id="cmodelo" onChange="agregarDescripcion()"/>
                    </div>
                </div>
                
                <div class="form-group Lmodelo2" style="display:none;">
                    <label for="cmodelo2" class="col-sm-2 control-label">Modelo B:</label>
                    <div class="col-sm-3">
                        <input value="" name="modelo2" type="text" class="form-control cmodelo2" id="cmodelo2" onChange="agregarDescripcion()"/>
                    </div>
                </div>
			
				<div class="form-group Llado" style="display:none;">
                  	<label for="clado" class="col-sm-2 control-label">Lado:</label>
                    <div class="col-sm-5">
                    	<select id="clado" name="lado" class="form-control clado" onChange="agregarDescripcion()">
                        	<option value="" selected>Seleccione uno</option>
						</select>
                    </div> 
                </div>
                
                
                <div class="form-group Laplicacion" style="display:none;">
                  	<label for="caplicacion" class="col-sm-2 control-label">Aplicación:</label>
                    <div class="col-sm-5">
                    	<select id="caplicacion" name="aplicacion" class="form-control caplicacion" onChange="agregarDescripcion()">
                        	<option value="" selected>Seleccione uno</option>
						</select>
                    </div> 
                </div>
                
                <div class="form-group Llargo" style="display:none;">
                  	<label for="clargo" class="col-sm-2 control-label">Largo:</label>
                    <div class="col-sm-5">
                    	<select id="clargo" name="largo" class="form-control clargo" onChange="agregarDescripcion()">
                        	<option value="" selected>Seleccione uno</option>
						</select>
                    </div> 
                </div>
                
                
				
				<div class="form-group hide">
                    <label for="cdescripcion" class="col-sm-2 control-label">Descripción:</label>
                    <div class="col-sm-5">
                        <input value="" name="descripcion" type="text" class="form-control" id="cdescripcion" />
                    </div>
                </div>
			
				<div class="form-group ">
                  	<label for="cvariacionpermitidaencosto" class="col-sm-2 control-label">Variación permitida en costo al comprar:</label>
                    <div class="col-sm-5">
                    	<select id="cvariacionpermitidaencosto" name="variacionpermitidaencosto" class="form-control">
							<option value="1">1%</option>
						</select>
                    </div> 
                </div>
                
                <br/>
				<h4> Proveedores relacionados: </h4>
                <hr/>
            
				<div style = "width:100%;">
                    <div class="row" id="proveedores_ajax">
                        
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
  					<i class="fa fa-cog fa-spin" style="color:#494441"></i>
			  </div>
              
            </div><!-- /.box -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

	  <?php include("../../../componentes/pie.php");?>
    </div><!-- ./wrapper -->
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("Vnombre", "none", {validateOn:["blur"],  maxChars:200,  minChars:1});
				
</script>

</body>
</html>