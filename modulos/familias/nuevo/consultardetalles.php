<?php
require("../Suscriptor.class.php");
$idsuscriptor=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Osuscriptor= new Suscriptor;
	$resultado=$Osuscriptor->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);	$idsuscriptor=$extractor["idsuscriptor"];
	$nombre=$extractor["nombre"];
	$domicilio=$extractor["domicilio"];
	$coordenadas=$extractor["coordenadas"];
	$telefono=$extractor["telefono"];
	$plan=$extractor["plan"];
	$precio=$extractor["precio"];
	$ip=$extractor["ip"];
	$idestacion=$extractor["idestacion"];
	$archivo=$extractor["archivo"];
	$estado=$extractor["estado"];
	$estatus=$extractor["estatus"];

?>
            <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Datos del registro</a></li>
              <!--li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Otros datos</a></li-->
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                <blockquote style="font-size:14px;">
					<p><b>ID:</b> <?php echo strtoupper(html_entity_decode($idsuscriptor))?></p>
					<p><b>Nombre Completo:</b> <?php echo strtoupper(html_entity_decode($nombre))?></p>
					<p><b>Domicilio Completo:</b> <?php echo strtoupper(html_entity_decode($domicilio))?></p>
					<p><b>Coordenadas:</b> <?php echo strtoupper(html_entity_decode($coordenadas))?></p>
					<p><b>Teléfono:</b> <?php echo strtoupper(html_entity_decode($telefono))?></p>
					<p><b>Plan cotnratado:</b> <?php echo strtoupper(html_entity_decode($plan))?></p>
					<p><b>Precio:</b> <?php echo strtoupper(html_entity_decode($precio))?></p>
					<p><b>Dirección IP:</b> <?php echo strtoupper(html_entity_decode($ip))?></p>
					<p><b>Estación:</b> <?php echo strtoupper(html_entity_decode($idestacion))?></p>
					<p><b>Archivo:</b> <?php echo strtoupper(html_entity_decode($archivo))?></p>
					<p><b>Estado del servicio:</b> <?php echo strtoupper(html_entity_decode($estado))?></p>
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