<?php
require("../Auditoria.class.php");
$idauditoria=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Oauditoria= new Auditoria;
	$resultado=$Oauditoria->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$idauditoria=$extractor["idauditoria"];
	$fecha=$extractor["fecha"];
	$idusuario=$extractor["idusuario"];
	$idfamilia=$extractor["idfamilia"];
	$idsucursal=$extractor["idsucursal"];
	$comentarios=$extractor["comentarios"];
	$nombreFamilia=$extractor["nombrefamilias"];
	$nombreSucursal=$extractor["nombresucursales"];
	$nombreResponsable=$extractor["nombreusuarios"];
	$estado=$extractor["estado"];

?>
            <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Datos del registro</a></li>
              <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Detalles de la auditoría</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                <blockquote style="font-size:14px;">
					<p><b>ID:</b> <?php echo strtoupper(html_entity_decode($idauditoria))?></p>
					<p><b>Fecha:</b> <?php echo strtoupper(html_entity_decode($fecha))?></p>
                    <p><b>Responsable:</b> <?php echo strtoupper(html_entity_decode($nombreResponsable))?></p>
                    <p><b>Sucursal:</b> <?php echo strtoupper(html_entity_decode($nombreSucursal))?></p>
					<p><b>Familia de productos:</b> <?php echo strtoupper(html_entity_decode($nombreFamilia))?></p>
					<p><b>Comentarios:</b> <i><?php echo html_entity_decode($comentarios)?></i></p>
    			</blockquote>
                
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
               	<b>Detalles de la auditor&iacute;a para los productos de la familia <?php echo $nombreFamilia?></b></br></br>
                <?php llenarOtrosDatos($idauditoria);?>
              </div-->
 			<!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
<?php
}
function llenarOtrosDatos($idauditoria){
	$Oauditoria= new Auditoria;
	$resultado=$Oauditoria->consultaLibre("SELECT
										detalleauditorias.iddetalleauditoria,
										detalleauditorias.idauditoria,
										detalleauditorias.idproducto,
										detalleauditorias.existenciaanterior,
										detalleauditorias.existencia,
										detalleauditorias.conteo,
										detalleauditorias.diferencia,
										detalleauditorias.idusuario,
										detalleauditorias.estado,
										detalleauditorias.fecha,
										auditorias.fecha AS fechaauditorias,
										productos.nombre AS nombreproducto,
										unidades.nombre AS nombreunidad,
										usuarios.nombre AS nombreusuarios
										FROM detalleauditorias 
										INNER JOIN auditorias ON detalleauditorias.idauditoria=auditorias.idauditoria
										INNER JOIN productos ON detalleauditorias.idproducto=productos.idproducto
										INNER JOIN usuarios ON detalleauditorias.idusuario=usuarios.idusuario
										INNER JOIN unidades ON productos.idunidad=unidades.idunidad
										WHERE detalleauditorias.idauditoria='$idauditoria'");

	if ($resultado=="denegado"){
		echo $_SESSION['msgsinacceso'];
		exit;
	}
	// MOSTRAR LOS REGISTROS SEGUN EL RESULTADO DE LA CONSULTA
	?>
    <!-- Tabla --> 
    <div class="box-body table-responsive no-padding">
        <table id="tablaSalida" class="table table-hover table-bordered" style="font-size:10px;">
            <thead>
                <tr style="background:#F3F3F3; color:#666; height:30px; border:1px" align="center">
                    <td width="80" style='display:none'>No.</td>
                    <td width="80" style='display:none'>ID</td>
                    <td width="200" class="columnaIzquierda" style="border-left: 10px solid #9FB580;">Producto</td>
                    <td width="100">Unidad</td>
                    <td width="100" title="Existencias antes de auditoria">Anterior</td>
                    <td width="100">Existencias</td>
                    <td width="100">Cantidad Física</td>
                    <td width="100">Diferencia</td>
                    <td width="100">Estado</td>
                    <td width="100">Verificador</td>
                </tr>
            </thead>
            <tbody id="filas" style="background:#FFF; border:1px #666 solid;" align="center">
    <?php
	$con=1000;
	while ($filas=mysqli_fetch_array($resultado)) {
		$colorCantidad="blue"; 
		if ($filas["estado"]=='Contado'){
			$colorCantidad="#096";
		}
		$colorDiferencia="#096";
		if ($filas["diferencia"] > 0){
			$colorDiferencia="#C33";
		}
		if ($filas["diferencia"] < 0){
			$colorDiferencia="#FC0";
		}
		?>
				
			<tr>
			<td style="display:none"><?php echo $con;?></td>
			<td style="display:none"><?php echo $filas["idproducto"];?></td>
			<td class="columnaIzquierda" style="border-left: 10px solid #9FB580;"><?php echo $filas["nombreproducto"]." -".$filas["estado"];?></td>
			<td><?php echo $filas["nombreunidad"];?></td>
            <td><?php echo $filas["existenciaanterior"];?></td>
			<td><?php echo $filas["existencia"];?></td>
			<td style="color:<?php echo $colorCantidad?>"><?php echo $filas["conteo"];?></td>
			<td style="color:<?php echo $colorDiferencia?>" id="diferencia<?php echo $con?>"><?php echo $filas["diferencia"];?></td>
            <td><span class="badge" style="background:<?php echo $colorCantidad; ?>"><?php echo $filas["estado"];?></span></td>
            <td><?php echo $filas["nombreusuarios"];?></td>
			</tr>
				
		<?php
		$con++;
	}//Fin de while si es tabla
	?>
    </tbody>
        </table>
    </div>
    <!-- Fina Tabla --> 
<?php
}
?>