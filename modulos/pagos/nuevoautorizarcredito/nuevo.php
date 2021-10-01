<?php 
include ("../../seguridad/comprobar_login.php");
include ("../Pago.class.php");
//$idreferencia = $_POST['idreferencia'];
$idreferencia = $_POST['idreferencia'];
$tablareferencia = $_POST['tablareferencia'];
$idcliente = $_POST['idcliente'];
$devuelto = 0;
$Opago=new Pago;
$idsucursal=$_SESSION["idsucursal"];
//$idempleado=$_SESSION["idempleado"];
/*$resultado=$Opago->consultaLibre("SELECT * FROM caja WHERE idsucursal='$idsucursal' AND idempleado='$idempleado' ORDER BY idcaja DESC");
if(mysqli_num_rows($resultado) > 0){
	$filas=mysqli_fetch_array($resultado);
	$estado= $filas['estado'];
	if ($estado!="abierta"){
		$idcaja=0;
	}else{
		$idcaja=$filas['idcaja'];
	}
}else{
	$idcaja=0;
}*/



$resultado=$Opago->consultaLibre("SELECT * FROM clientes WHERE idcliente='$idcliente'");
if(mysqli_num_rows($resultado) > 0){
	$filas=mysqli_fetch_array($resultado);
	$nombrecliente=$filas['nombre'];
	$saldocliente=$filas['saldo'];
	$limitecredito=$filas['limitecredito'];
	/*$calificacion=$filas['calificacion'];
		if ($calificacion==0){
			$estrella1="<i class='fa fa-star-o'></i>";
			$estrella2="<i class='fa fa-star-o'></i>";
			$estrella3="<i class='fa fa-star-o'></i>";
			$estrella4="<i class='fa fa-star-o'></i>";
			$estrella5="<i class='fa fa-star-o'></i>";
		}
		if ($calificacion==1){
			$estrella1="<i class='fa fa-star'></i>";
			$estrella2="<i class='fa fa-star-o'></i>";
			$estrella3="<i class='fa fa-star-o'></i>";
			$estrella4="<i class='fa fa-star-o'></i>";
			$estrella5="<i class='fa fa-star-o'></i>";
		}
		if ($calificacion==2){
			$estrella1="<i class='fa fa-star'></i>";
			$estrella2="<i class='fa fa-star'></i>";
			$estrella3="<i class='fa fa-star-o'></i>";
			$estrella4="<i class='fa fa-star-o'></i>";
			$estrella5="<i class='fa fa-star-o'></i>";
		}
		if ($calificacion==3){
			$estrella1="<i class='fa fa-star'></i>";
			$estrella2="<i class='fa fa-star'></i>";
			$estrella3="<i class='fa fa-star'></i>";
			$estrella4="<i class='fa fa-star-o'></i>";
			$estrella5="<i class='fa fa-star-o'></i>";
		}
		if ($calificacion==4){
			$estrella1="<i class='fa fa-star'></i>";
			$estrella2="<i class='fa fa-star'></i>";
			$estrella3="<i class='fa fa-star'></i>";
			$estrella4="<i class='fa fa-star'></i>";
			$estrella5="<i class='fa fa-star-o'></i>";
		}
		if ($calificacion==5){
			$estrella1="<i class='fa fa-star'></i>";
			$estrella2="<i class='fa fa-star'></i>";
			$estrella3="<i class='fa fa-star'></i>";
			$estrella4="<i class='fa fa-star'></i>";
			$estrella5="<i class='fa fa-star'></i>";
		}*/
}

if ($idreferencia!=0){
	$IDTabla = "";
	//DEFINIR QUE CAMPO SE VA A CONSULTAR SEGUN TABLAREFERENCIA
	if($tablareferencia=="cotizacionesproductos"){
		$IDTabla = "idcotizacionproducto";
	}
	if($tablareferencia=="detallecotizacionesotros"){
		$IDTabla = "iddetallecotizacionotros";
	}
	$tablareferenciaConsulta = "$tablareferencia" . $_SESSION["idsucursal"];
	$resultado=$Opago->consultaLibre("SELECT * FROM $tablareferenciaConsulta WHERE $IDTabla='$idreferencia'");
	if(mysqli_num_rows($resultado) > 0){
		$filas=mysqli_fetch_array($resultado);
		$fechaventa=$filas['fecha'];
		$totaltotal=$filas['total'];
		//$formapago=$filas['formapago'];
		//$devuelto=$filas['devuelto'];
		$pagos = "pagos" . $_SESSION["idsucursal"];
		$resultado2=$Opago->consultaLibre("SELECT SUM(monto) AS totalpagos FROM $pagos WHERE idreferencia='$idreferencia' AND tablareferencia = '$tablareferencia'");
		if(mysqli_num_rows($resultado2) > 0){
			$filas2=mysqli_fetch_array($resultado2);
			$totalpagos=$filas2['totalpagos'];
		}
	}
}else{
	$resultado=$Opago->consultaLibre("SELECT * FROM ventasajuste WHERE tablareferencia='$tablareferencia'");
	if(mysqli_num_rows($resultado) > 0){
		$filas=mysqli_fetch_array($resultado);
		$fechaventa=$filas['fecha'];
		$totaltotal=$filas['total'];
		$formapago="CREDITO";
		$devuelto=0;
		$resultado2=$Opago->consultaLibre("SELECT SUM(monto) AS totalpagos FROM pagos WHERE tablareferencia='$tablareferencia'");
		if(mysqli_num_rows($resultado2) > 0){
			$filas2=mysqli_fetch_array($resultado2);
			$totalpagos=$filas2['totalpagos'];
		}
	}
}

$total=$totaltotal-$devuelto;
?>
<!DOCTYPE html>
<html>
  <head>
    <?php include ("../../../componentes/cabecera.php")?><link href="../../../librerias/js/Spry/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<script src="../../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="../../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../../../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="../../../plugins/fastclick/fastclick.min.js"></script>
<script src="../../../dist/js/app.min.js" type="text/javascript"></script>
<?php 
if (isset($_POST['idreferencia'])){
	echo "
<script>
	var idreferencia='".$_POST['idreferencia']."';
</script>";
}
if (isset($_POST['tablareferencia'])){
	echo "
<script>
	var tablareferencia='".$_POST['tablareferencia']."';
</script>";
}
?>
<script src="js.js"></script><script src="../../../librerias/js/cookies.js"></script><script src="../../../librerias/js/validaciones.js"></script><script src="../../../librerias/js/Spry/SpryValidationTextField.js" type="text/javascript"></script>

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
          <h1>Autorizar crédito<small>Nuevo registro</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../inicio/inicio/inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Autorizar crédito</a></li>
          </ol>
        </section>
		
		<!-- Contenido principal -->
        <section class="content">
		
		<?php
    /////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['pagos']['guardar']) or  !isset($_SESSION['permisos']['pagos']['acceso'])){
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
            <div class="box box-info" style="border-color:#b4d571">
              <div class="box-header with-border">
                <h3 class="box-title">Formulario de registro</h3>
              </div><!-- /.box-header -->
              <!-- Datos de venta -->
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  	<blockquote style="font-size:14px;" class="col">
                        <p class="pull-right">
                        <b>CLIENTE:</b> <?php echo strtoupper($nombrecliente); ?> | <b>Deuda General: </b><span class="badge" style="background-color:#FFB506" id="deudageneral">$ <?php echo number_format($saldocliente,2); ?></span>
                        </p>
                        <p>
                            <b>TOTAL VENTAS: </b>
                            <span class="badge" style="background-color:#06F" id="total">$ <?php echo number_format($total,2); ?></span>
                            <?php if ($devuelto<>0){ ?>
                                <a data-toggle="tooltip" data-placement="bottom" style="cursor:default" title="" data-original-title="Devoluciones registradas&#10; Total vendido: $<?php echo $totaltotal;?>&#10; Total devuelto: $<?php echo $devuelto;?>&#10; Total restante: $<?php echo $total; ?>"><i class="fa fa-flag text-red" style=" font-size:10px;" data-toggle="tooltip"></i></a>
                            <?php } ?>
                        	<b> | TOTAL PAGADO: </b><span class="badge" style="background-color:#096;" id="totalpagado">$ <?php echo number_format($totalpagos,2); ?></span>
                        	<b> | DIFERENCIA: </b><span class="badge" style="background-color:#C33;" id="diferencia">$ <?php echo number_format($total-$totalpagos,2); ?></span>
                        </p>
                        <p>
                        	<small>Fecha de venta: <cite title="Source Title"><?php echo $fechaventa; ?></cite></small>
                        </p>
                	</blockquote>
                </div>
              </div>
              <?php 
			  if (isset($_SESSION['permisos']['pagos']['registrarPago'])){
			  ?>
                
              <!-- form start -->
			  <form class="form-horizontal" name="formulario" id="formulario" method="post">
                <div class="box-body">
                	<div class='row' style="padding-left:20px; padding-right:20px; padding-top:0px; margin-top:0px;">
                    	
                        <div class='col-sm-3'>
                            <div class="form-group">
                           		<label for="ctipocredito" class="control-label">Tipo de pago:</label>
                                <select id="ctipocredito" name="tipocredito" class="form-control">
                                	<option value="CONTADO">CONTADO</option>
                                    <option value="PAGO CONTRA ENTREGA">PAGO CONTRA ENTREGA</option>
                                    <option value="CREDITO">CREDITO</option>
                                </select>
                           	</div>
                        </div>
                        
                        <div class="form-group hide">
                                <label for="csaldo" class="control-label">Saldo:</label>
                        		<input value=" <?php echo $total-$totalpagos;?>"  name="saldo" type="text" class="form-control" id="csaldo" />
                        </div>
                        <div class="form-group hide">
                                <label for="ctipo" class="control-label">Tipo:</label>
                        		<input value=" <?php echo $_POST['tipo'];?>"  name="tipo" type="text" class="form-control" id="ctipo" />
                        </div>
                        
                        <div class='col-sm-2 pull-right'>
                            <div class="form-group">
                            	<input value="<?php echo $_POST['idcliente']; ?>" name="idcliente" type="hidden" class="form-control" id="cidcliente"/>
                            	<input value="<?php echo $_POST['idreferencia']; ?>" name="idreferencia" type="hidden" class="form-control" id="cidreferencia" />
                        		<input value="<?php echo $_POST['tablareferencia']; ?>" name="tablareferencia" type="hidden" class="form-control" id="ctablareferencia" />
                                <label for="botonGuardar" class="control-label">&nbsp;</label>
                                <button type="button" class="form-control btn btn-primary pull-right" id="botonGuardar"><i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Guardar</button>
                            </div>
                		</div>
                    	
                	</div><!-- /.Fin row -->
                    
                    
                    <div id ="mensaje"></div>
                    
				</div><!-- /.box-body -->
                
              </form>
              <?php }?>
			</div><!-- /Fin box -->

            <div class="box box-info" style="border-color:#b4d571">
            	<div class="box-header with-border">
                	<h3 class="box-title">Consulta de registros</h3>
              	</div><!-- /.box-header -->
                <div id="muestra_contenido_ajax" style="min-height:100px;">
            	</div><!-- /din contenido ajax -->
                <div id="loading2" class="overlay" style="display:none">
  					<i class="fa fa-cog fa-spin" style="color:#b4d571"></i>
			  	</div>
            </div><!-- Fin box>
            
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

	  <?php include("../../../componentes/pie.php");?>
    </div><!-- ./wrapper -->

</body>
</html>