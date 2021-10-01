<?php
require("../Caracteristica.class.php");
$idcaracteristica=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Ocaracteristica= new Caracteristica;
	$resultado=$Ocaracteristica->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);	$idcaracteristica=$extractor["idcaracteristica"];
	$caracteristica=$extractor["caracteristica"];
	$valor=$extractor["valor"];

?>
            <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Datos del registro</a></li>
              <!--li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Otros datos</a></li-->
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                <blockquote style="font-size:14px;">
					<p><b>ID:</b> <?php echo strtoupper(html_entity_decode($idcaracteristica))?></p>
					<p><b>Caracteristica:</b> <?php echo strtoupper(html_entity_decode($caracteristica))?></p>
					<p><b>Valor:</b> <?php echo strtoupper(html_entity_decode($valor))?></p>
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