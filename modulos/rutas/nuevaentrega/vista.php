<?php 
include ("../../seguridad/comprobar_login.php");
?>
<!DOCTYPE html>
<html>
<head>
<?php include ("../../../componentes/cabecera.php")?>
 <link rel="stylesheet" type="text/css" media="screen" href="../../../dist/css/autocompletar/jqueryui.css" />
<script src="../../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="../../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../../../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="../../../plugins/fastclick/fastclick.min.js"></script>
<script src="../../../dist/js/app.min.js" type="text/javascript"></script>
<script src="js.js"></script>
<script src="../../../librerias/js/jquery-ui.js"></script>
<script src="../../../librerias/js/cookies.js"></script>
<script src="../../../librerias/js/validaciones.js"></script>
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
	
	echo '<script>var idsucursalseleccionada="'.$_SESSION['idsucursal'].'";</script>';
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
          <h1>Entregas<small> Nueva</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Consultar cotizacionproducto</a></li>
          </ol>
        </section>
		
		<!-- Contenido principal -->
        <section class="content">
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cotizacionesproductos']['consultar']) or  !isset($_SESSION['permisos']['cotizacionesproductos']['acceso'])){
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
            
          	<!-- box -->
            <div class="box box-info" style="border-color:#649ad0">
            	<div class="box-header with-border">
                	<h3 class="box-title">Ventas pendientes de entregar</h3>
              	</div><!-- /.box-header -->
                <div id="muestra_contenido_ajax" style="min-height:100px;">
            	</div><!-- /din contenido ajax -->
                <div id="loading" class="overlay">
  					<i class="fa fa-cog fa-spin" style="color:#649ad0"></i>
			  	</div>
                 <div id="salida"></div>
            </div><!-- Fin box>
			
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

	  <?php include("../../../componentes/pie.php");?>
    </div><!-- ./wrapper -->

</body>
</html>