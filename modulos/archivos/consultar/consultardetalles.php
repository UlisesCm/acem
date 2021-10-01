<?php
require("../Archivo.class.php");
$idarchivo=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Oarchivo= new Archivo;
	$resultado=$Oarchivo->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);	$idarchivo=$extractor["idarchivo"];
	$pdf=$extractor["pdf"];
	$xml=$extractor["xml"];
	$fechamodificacion=$extractor["fechamodificacion"];
	$tablareferencia=$extractor["tablareferencia"];
	$idreferencia=$extractor["idreferencia"];
	$serie=$extractor["serie"];
	$folio=$extractor["folio"];
	$tipo=$extractor["tipo"];
	$fechatimbre=$extractor["fechatimbre"];
	$emisor=$extractor["emisor"];
	$rfcemisor=$extractor["rfcemisor"];
	$receptor=$extractor["receptor"];
	$rfcreceptor=$extractor["rfcreceptor"];
	$monto=$extractor["monto"];
	$uuid=$extractor["uuid"];

?>
            <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Datos del registro</a></li>
              <!--li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Otros datos</a></li-->
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                <blockquote style="font-size:14px;">
					<p><b>ID:</b> <?php echo strtoupper(html_entity_decode($idarchivo))?></p>
					<p><b>Archivo PDF:</b> <?php echo strtoupper(html_entity_decode($pdf))?></p>
					<p><b>Archivo XML:</b> <?php echo strtoupper(html_entity_decode($xml))?></p>
					<p><b>Serie:</b> <?php echo strtoupper(html_entity_decode($serie))?></p>
					<p><b>Folio:</b> <?php echo strtoupper(html_entity_decode($folio))?></p>
					<p><b>Tipo:</b> <?php echo strtoupper(html_entity_decode($tipo))?></p>
					<p><b>Fecha Timbrado:</b> <?php echo strtoupper(html_entity_decode($fechatimbre))?></p>
					<p><b>Emisor:</b> <?php echo strtoupper(html_entity_decode($emisor))?></p>
					<p><b>RFC Emisor:</b> <?php echo strtoupper(html_entity_decode($rfcemisor))?></p>
					<p><b>Receptor:</b> <?php echo strtoupper(html_entity_decode($receptor))?></p>
					<p><b>RFC Receptor:</b> <?php echo strtoupper(html_entity_decode($rfcreceptor))?></p>
					<p><b>Monto:</b> <?php echo strtoupper(html_entity_decode($monto))?></p>
					<p><b>UUID:</b> <?php echo strtoupper(html_entity_decode($uuid))?></p>
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