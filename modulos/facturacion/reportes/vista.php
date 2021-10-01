<?php 
include ("../../seguridad/comprobar_login.php");
include ("../Facturacion.class.php");
include ("../../../librerias/php/variasFunciones.php");
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

<script src="../../../librerias/js/highcharts.js"></script>
<script src="../../../librerias/js/exporting.js"></script>



<?php 
$Ografica= new Facturacion;
$anoactual=date('Y');
$anopasado=$anoactual-1;

//GRAFICA 1
$resultado=$Ografica->consultaLibre("SELECT SUM(montototal) AS total,
MONTH(fecha) AS mes
FROM facturacion WHERE YEAR(fecha)='$anoactual' AND tipo='I' AND estatus <> 'cancelada'
GROUP BY MONTH(fecha)
ORDER BY MONTH(fecha) ASC");

$con=0;
$ingresos=array();
while ($filas=mysqli_fetch_array($resultado)) {
	$titulo[$con]=$filas['mes'];
	$titulo[$con]=obtenerMes($titulo[$con]);
	$ingresos[$con]=(float)$filas['total'];
	$con++;
}
$axis1 = array( 'name' => 'Ingresos Facturados' , 'data' => $ingresos) ;
$datos = array();
array_push( $datos, $axis1);

//GRAFICA 2



$resultado3=$Ografica->consultaLibre("SELECT SUM(montototal) AS total,
MONTH(fecha) AS mes
FROM facturacion WHERE YEAR(fecha)='$anopasado' AND tipo='I' AND estatus <> 'cancelada'
GROUP BY MONTH(fecha)
ORDER BY MONTH(fecha) ASC");

$con=0;
$ingresos2=0;

$ingresos2=array();
while ($filas3=mysqli_fetch_array($resultado3)) {
	$titulo2[$con]=$filas3['mes'];
	$titulo2[$con]=obtenerMes($titulo2[$con]);
	$ingresos2[$con]=(float)$filas3['total'];
	$con++;
}

$axis2 = array( 'name' => 'Ingresos Facturados' , 'data' => $ingresos2) ;
$datos2 = array();
array_push( $datos2, $axis2);
?>
     
        
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


<script type="text/javascript">
	var chart;
	$(document).ready(function() {
		chart = new Highcharts.Chart({
			chart: {
				renderTo: 'container',
				defaultSeriesType: 'line'
			},
			title: {
				text: 'Gráfica de tendencia de Facturación'
			},
			colors: ['red', 'orange', 'green', 'blue', 'purple', 'brown'],
			subtitle: {
				text: 'CFDI emitidos durante el año <?php echo $anoactual; ?>'
			},
			xAxis: {
				// Le pasamos los datos que irán en el eje de las 'X' en JSON
				categories: <?php echo json_encode($titulo) ?>
			},
			yAxis: {
				title: {
					text: 'Precios (Pesos Mexicanos)'
				},
                labels: {
                    align: 'left',
                    x: 3,
                    y: 16,
                    format: '${value:.,0f}'
                },
                showFirstLabel: false
			},
			tooltip: {
				enabled: true,
				formatter: function() {
					return '<b>'+ this.series.name +'</b><br/>'+this.x +': $'+ this.y +' '+this.series.name;
				},
			},
			plotOptions: {
				line: {
					dataLabels: {
						enabled: true,
						format: '${point.y:.,0f}'
					},
					enableMouseTracking: true
				}
			},
			// Le pasamos los datos en JSON
			series: <?php echo json_encode($datos);?>
		});	
	});		
</script>



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
          <h1>Comprobantes Fiscales<small> Consulta</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Consultar facturacion</a></li>
          </ol>
        </section>
		
		<!-- Contenido principal -->
        <section class="content">
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['facturacion']['consultar']) or  !isset($_SESSION['permisos']['facturacion']['acceso'])){
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
            <div class="box box-info" style="border-color:#da123f">
            	<div class="box-header with-border">
                	<h3 class="box-title">Consulta de registros</h3>
              	</div><!-- /.box-header -->
                
                <div id="container" style="width: 100%; height: 500px; margin: 0 auto"></div>
                
                <div id="loading" class="overlay" style="display:none">
  					<i class="fa fa-cog fa-spin" style="color:#da123f"></i>
			  	</div>
                
            </div><!-- Fin box>
			
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

	  <?php include("../../../componentes/pie.php");?>
    </div><!-- ./wrapper -->

</body>
</html>