<?php
require("../Cliente.class.php");
$idcliente=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Ocliente= new Cliente;
	$resultado=$Ocliente->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$rfc=$extractor["rfc"];
	$nombre=$extractor["nombre"];
	$nic=$extractor["nic"];
	$limitecredito=$extractor["limitecredito"];
	$diascredito=$extractor["diascredito"];
	$saldo=$extractor["saldo"];
	$nombrecontacto=$extractor["nombrecontacto"];
	$correocontacto=$extractor["correocontacto"];
	$telefonocontacto=$extractor["telefonocontacto"];
	$autorizardosis=$extractor["autorizardosis"];
	$autorizarproductos=$extractor["autorizarproductos"];
	$estatus=$extractor["estatus"];
	sleep(2);
?>
			<blockquote style="font-size:14px;">
            	<p><b>Nombre del cliente:</b> <?php echo strtoupper($nombre)?></p>
                <small>Estatus:  <cite title="Source Title"><?php echo $estatus; ?></cite></small>
    		</blockquote>
            
            <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class=""><a href="#tab_1" data-toggle="tab" aria-expanded="false">Domicilios de Servicio</a></li>
              <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Domicilios Fiscales</a></li>
              <li class="active"><a href="#tab_3" data-toggle="tab" aria-expanded="true">Formatos</a></li>
              <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane" id="tab_1">
                <b>How to use:</b>

                <p>Exactly like the original bootstrap tabs except you should use
                  the custom wrapper <code>.nav-tabs-custom</code> to achieve this style.</p>
                A wonderful serenity has taken possession of my entire soul,
                like these sweet mornings of spring which I enjoy with my whole heart.
                I am alone, and feel the charm of existence in this spot,
                which was created for the bliss of souls like mine. I am so happy,
                my dear friend, so absorbed in the exquisite sense of mere tranquil existence,
                that I neglect my talents. I should be incapable of drawing a single stroke
                at the present moment; and yet I feel that I never was a greater artist than now.
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
                The European languages are members of the same family. Their separate existence is a myth.
                For science, music, sport, etc, Europe uses the same vocabulary. The languages only differ
                in their grammar, their pronunciation and their most common words. Everyone realizes why a
                new common language would be desirable: one could refuse to pay expensive translators. To
                achieve this, it would be necessary to have uniform grammar, pronunciation and more common
                words. If several languages coalesce, the grammar of the resulting language is more simple
                and regular than that of the individual languages.
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane active" id="tab_3">
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                It has survived not only five centuries, but also the leap into electronic typesetting,
                remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset
                sheets containing Lorem Ipsum passages, and more recently with desktop publishing software
                like Aldus PageMaker including versions of Lorem Ipsum.
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
<?php
}
?>