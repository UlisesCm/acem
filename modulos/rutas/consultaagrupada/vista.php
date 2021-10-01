<?php 
include ("../../seguridad/comprobar_login.php");
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
          <h1>Salida de productos<small> Consulta</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Consultar detallecotizacionproducto</a></li>
          </ol>
        </section>
		
		<!-- Contenido principal -->
        <section class="content">
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['detallecotizacionesproductos']['consultar']) or  !isset($_SESSION['permisos']['detallecotizacionesproductos']['acceso'])){
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
               <form class="form-horizontal" name="formularioconsultasalida" id="formularioconsultasalida" method="post">
              <input name="idruta" type="hidden" id="idruta" value="<?php if (isset($_POST['idruta'])){echo $_POST['idruta'];}else{echo "";}?>"/>
            </form>
            
             <form class="form-horizontal" name="formulario" id="formulario" method="post">
              <input name="idcotizacionproducto" type="hidden" id="idcotizacionproducto" value="<?php if (isset($_POST['idcotizacionproducto'])){echo $_POST['idcotizacionproducto'];}else{echo "";}?>"/>
              
            </form>
          	<!-- box -->
            <div class="box box-info" style="border-color:#4da8ac">
            	<div class="box-header with-border">
                	<h3 class="box-title">Consulta de registros</h3>
              	</div><!-- /.box-header -->
                <div id="muestra_contenido_ajax" style="min-height:100px;">
            	</div><!-- /din contenido ajax -->
                <div id="loading" class="overlay">
  					<i class="fa fa-cog fa-spin" style="color:#4da8ac"></i>
			  	</div>
                <div class="box-footer">
                <div class="row">
                   <div class='col-sm-12'>
                            <div class="form-group">
                            	    <label for="observaciones" style="d<?php if (isset($_POST['hiddenbotonaceptar'])){echo $_POST['hiddenbotonaceptar'];}else{echo "";}?>">Observaciones de entrega: </label>
                            		<input name="observaciones" style="d<?php if (isset($_POST['hiddenbotonaceptar'])){echo $_POST['hiddenbotonaceptar'];}else{echo "";}?>" id="observaciones" class="form-control input-lg"></textarea>
                            </div>
                         </div>
                </div>
                <div class="row">
                        <div class='col-sm-12 pull-right'>
                            <div class="form-group">
                            		<button type="button" style="d<?php if (isset($_POST['hiddenbotonaceptar'])){echo $_POST['hiddenbotonaceptar'];}else{echo "";}?>" class="btn btn-success pull-right" id="botonAceptar"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Autorizar salida</button>
                            </div>
                		</div>
                         </div>
                </div>
            </div><!-- Fin box>-->
             
			
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

	  <?php include("../../../componentes/pie.php");?>
    </div><!-- ./wrapper -->

</body>
</html>