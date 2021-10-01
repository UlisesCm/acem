<?php
require("../Traspaso.class.php");
$idtraspaso=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Otraspaso= new Traspaso;
	$resultado=$Otraspaso->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);	$idtraspaso=$extractor["idtraspaso"];
	$idmovimiento=$extractor["idmovimiento"];
	$idsucursalorigen=$extractor["idsucursalorigen"];
	$idsucursaldestino=$extractor["idsucursaldestino"];
	$fechasalida=$extractor["fechasalida"];
	$fechaentrada=$extractor["fechaentrada"];
	$estado=$extractor["estado"];
	$numerocomprobante=$extractor["numerocomprobante"];
	$idusuariosalida=$extractor["idusuariosalida"];
	$idusuarioentrada=$extractor["idusuarioentrada"];

?>
            <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Datos del registro</a></li>
              <!--li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Otros datos</a></li-->
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                <blockquote style="font-size:14px;">
					<p><b>ID:</b> <?php echo strtoupper(html_entity_decode($idtraspaso))?></p>
					<p><b>Movimiento:</b> <?php echo strtoupper(html_entity_decode($idmovimiento))?></p>
					<p><b>Sucursal origen:</b> <?php echo strtoupper(html_entity_decode($idsucursalorigen))?></p>
					<p><b>Sucursal destino:</b> <?php echo strtoupper(html_entity_decode($idsucursaldestino))?></p>
					<p><b>Fecha Salida:</b> <?php echo strtoupper(html_entity_decode($fechasalida))?></p>
					<p><b>Fecha Entrada:</b> <?php echo strtoupper(html_entity_decode($fechaentrada))?></p>
					<p><b>Estado:</b> <?php echo strtoupper(html_entity_decode($estado))?></p>
					<p><b>Número Comprobante:</b> <?php echo strtoupper(html_entity_decode($numerocomprobante))?></p>
					<p><b>Usuario salida:</b> <?php echo strtoupper(html_entity_decode($idusuariosalida))?></p>
					<p><b>Usuario entrada:</b> <?php echo strtoupper(html_entity_decode($idusuarioentrada))?></p>
    			</blockquote>
                
              </div>
              <!-- /.tab-pane -->
              <!--div class="tab-pane" id="tab_2">
               	<b>Editar información de facturación</b>
                <?php //llenarOtrosDatos($variables);?>
              </div-->
 			<!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
<?php
}
//function llenarOtrosDatos($variables){}
?>