<?php
require("../Producto.class.php");
$idproducto=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Oproducto= new Producto;
	$resultado=$Oproducto->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);	$idproducto=$extractor["idproducto"];
	$idfamilia=$extractor["idfamilia"];
	$nombre=$extractor["nombre"];
	$codigo=$extractor["codigo"];
	$autoclasificar=$extractor["autoclasificar"];
	$clasificacion=$extractor["clasificacion"];
	$idmodeloimpuestos=$extractor["idmodeloimpuestos"];
	$idcategoria=$extractor["idcategoria"];
	$idunidad=$extractor["idunidad"];
	$marca=$extractor["marca"];
	$pesoteorico=$extractor["pesoteorico"];
	$espesor=$extractor["espesor"];
	$ancho=$extractor["ancho"];
	$color=$extractor["color"];
	$diametro=$extractor["diametro"];
	$tipo=$extractor["tipo"];
	$modelo=$extractor["modelo"];
	$modelo2=$extractor["modelo2"];
	$lado=$extractor["lado"];
	$alto=$extractor["alto"];
	$largo=$extractor["largo"];
	$aplicacion=$extractor["aplicacion"];
	$clave=$extractor["clave"];
	$descripcion=$extractor["descripcion"];
	$variacionpermitidaencosto=$extractor["variacionpermitidaencosto"];
	$costo=$extractor["costo"];
	$estatus=$extractor["estatus"];

?>
            <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Datos del registro</a></li>
              <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Configurar Stocks en Sucursales</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                <blockquote style="font-size:14px;">
					<p><b>ID:</b> <?php echo strtoupper(html_entity_decode($idproducto))?></p>
					<p><b>Familia:</b> <?php echo strtoupper(html_entity_decode($idfamilia))?></p>
					<p><b>Nombre:</b> <?php echo strtoupper(html_entity_decode($nombre))?></p>
					<p><b>Código:</b> <?php echo strtoupper(html_entity_decode($codigo))?></p>
					<p><b>Autoclasificar:</b> <?php echo strtoupper(html_entity_decode($autoclasificar))?></p>
					<p><b>Clasificación:</b> <?php echo strtoupper(html_entity_decode($clasificacion))?></p>
					<p><b>Modelo Impuestos:</b> <?php echo strtoupper(html_entity_decode($idmodeloimpuestos))?></p>
					<p><b>Categoría:</b> <?php echo strtoupper(html_entity_decode($idcategoria))?></p>
					<p><b>Unidad:</b> <?php echo strtoupper(html_entity_decode($idunidad))?></p>
					<p><b>Marca:</b> <?php echo strtoupper(html_entity_decode($marca))?></p>
					<p><b>Peso teórico:</b> <?php echo strtoupper(html_entity_decode($pesoteorico))?></p>
					<p><b>Espesor:</b> <?php echo strtoupper(html_entity_decode($espesor))?></p>
					<p><b>Ancho:</b> <?php echo strtoupper(html_entity_decode($ancho))?></p>
					<p><b>Color:</b> <?php echo strtoupper(html_entity_decode($color))?></p>
					<p><b>Diametro:</b> <?php echo strtoupper(html_entity_decode($diametro))?></p>
					<p><b>Tipo:</b> <?php echo strtoupper(html_entity_decode($tipo))?></p>
					<p><b>Modelo A:</b> <?php echo strtoupper(html_entity_decode($modelo))?></p>
					<p><b>Modelo B:</b> <?php echo strtoupper(html_entity_decode($modelo2))?></p>
					<p><b>Lado:</b> <?php echo strtoupper(html_entity_decode($lado))?></p>
					<p><b>Alto:</b> <?php echo strtoupper(html_entity_decode($alto))?></p>
					<p><b>Largo:</b> <?php echo strtoupper(html_entity_decode($largo))?></p>
					<p><b>Aplicación:</b> <?php echo strtoupper(html_entity_decode($aplicacion))?></p>
					<p><b>Clave:</b> <?php echo strtoupper(html_entity_decode($clave))?></p>
					<p><b>Descripción:</b> <?php echo strtoupper(html_entity_decode($descripcion))?></p>
					<p><b>Variación de costo:</b> <?php echo strtoupper(html_entity_decode($variacionpermitidaencosto))?></p>
					<p><b>Costo:</b> <?php echo strtoupper(html_entity_decode($costo))?></p>
    			</blockquote>
                
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
               	<b>Editar información de stocks del producto: (<?php echo $nombre?>)</b>
                <div id="contenidoStocks" style="padding:10px;">
                <?php llenarStocks($idproducto);?>
                </div>
              </div>
              
 			<!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
<?php
}

function llenarStocks($idproducto){
	$Oproducto=new Producto;
	$resultado=$Oproducto->consultaLibre("SELECT
					stocks.idstock,
					stocks.idproducto,
					stocks.periodoinicio,
					stocks.periodofin,
					stocks.stockminimo,
					stocks.stockmaximo,
					stocks.idreferencia,
					stocks.tablareferencia,
					sucursales.nombre AS nombresucursal
					FROM stocks
					INNER JOIN sucursales ON sucursales.idsucursal=stocks.idreferencia
					WHERE idproducto='$idproducto' AND tablareferencia='sucursales'
					ORDER BY sucursales.nombre");
	?>
    	<script type="text/javascript">
			function guardarStocks(idproducto,idreferencia,tablareferencia,control,idstock,idcontrol){
				var periodoinicio=$("#ciniciorotacion"+idcontrol).val();
				var periodofin=$("#cfinrotacion"+idcontrol).val();
				var stockminimo=$("#stockminimo"+idcontrol).val();
				var stockmaximo=$("#stockmaximo"+idcontrol).val();
				$.ajax({
					url: 'guardarStocks.php',
					type: "POST",
					data: "submit=&idproducto="+idproducto+'&periodoinicio='+periodoinicio+'&periodofin='+periodofin+'&stockminimo='+stockminimo+'&stockmaximo='+stockmaximo+'&idreferencia='+idreferencia+'&tablareferencia='+tablareferencia+"&idstock="+idstock, //Pasamos los datos en forma de array seralizado desde la funcion de envio
					success: function(mensaje){
						mensaje=$.trim(mensaje);
						if (mensaje=="exito"){
							$("#"+control+idcontrol).css("color","#096");
						}else{
							$("#"+control+idcontrol).css("color","#F03");
						}
					}
				});
				return false;
			}
			
			$(document).ready(function() {
			
				$(".decimal").keypress(function(){
					return checarDecimal(event, this);
				});
				
				$(".decimal").focus(function(){
					$(this).select();
				});
			});
				
        </script>
    	<table class="table table-hover table-bordered">
        	<tr>
                <th class="columnaDecorada" style="background:#2ea737; color:"></th>
				<th class="Ccodmicilio">Sucursal</th>
				<th class="Cformapago" style="display:none">Periodo de Inicio</th>
				<th class="Cmetodopago" style="display:none">Periodo de Fin</th>
				<th class="Cuso">Stock Mínimo</th>
				<th class="Cuso">Stock Máximo</th>
                <th class="Celiminar" width="30">
                <a class="btn btn-default" onclick="(agregarStock(<?php echo $idproducto ?>,<?php echo $_SESSION["idsucursal"];?>))" title="Agregar Línea"><i class="fa fa-plus"></i></a>
                </th>
                <th class="CAgregar" width="30"></th>
      		</tr>
    <?php
	$con=0;
	while ($filas=mysqli_fetch_array($resultado)) {
		$idsucursal=$filas["idreferencia"];
		$idstock=$filas["idstock"];
		$datosStock=$Oproducto->obtenerStocks($idproducto,$idsucursal,"sucursales",$idstock);
		$idreferencia=$idsucursal;
		if($datosStock!=false){
			$idstock=$datosStock[0];
			$iniciorotacion=$datosStock[1];
			$finrotacion=$datosStock[2];
			$stockminimo=$datosStock[3];
			$stockmaximo=$datosStock[4];
		}else{
			$datosStock=$Oproducto->actualizarStock("INDEFINIDO","INDEFINIDO","0","0",$idsucursal,"sucursales",$idproducto,0);
			$datosStock=explode("@",$datosStock);
			$idstock=$datosStock[1];
			$iniciorotacion="00";
			$finrotacion="00";
			$stockminimo=0;
			$stockmaximo=0;
		}
	?>
      		<tr id="iregistro<?php echo $con ?>">
                <td class="columnaDecorada" style="background:#2ea737;"></td>
				<td class="Ctipovialidad"><i><small><?php echo $filas['nombresucursal']; ?></small></i></td>
				<td class="Ccalle" style="display:none">
                <select id="ciniciorotacion<?php echo $con;?>" name="iniciorotacion" class="form-control" onchange="guardarStocks('<?php echo $idproducto?>','<?php echo $idreferencia?>','sucursales','ciniciorotacion','<?php echo $idstock;?>','<?php echo $con ?>')">
										<option value="00" <?php 
											if ($iniciorotacion=="00"){
												echo 'selected="selected"';
											}
											 ?>>INDEFINIDO</option>
										
										<option value="01" <?php 
											if ($iniciorotacion=="01"){
												echo 'selected="selected"';
											}
											 ?>>ENERO</option>
										
										<option value="02" <?php 
											if ($iniciorotacion=="02"){
												echo 'selected="selected"';
											}
											 ?>>FEBRERO</option>
										
										<option value="03" <?php 
											if ($iniciorotacion=="03"){
												echo 'selected="selected"';
											}
											 ?>>MARZO</option>
										
										<option value="04" <?php 
											if ($iniciorotacion=="04"){
												echo 'selected="selected"';
											}
											 ?>>ABRIL</option>
										
										<option value="05" <?php 
											if ($iniciorotacion=="05"){
												echo 'selected="selected"';
											}
											 ?>>MAYO</option>
										
										<option value="06" <?php 
											if ($iniciorotacion=="06"){
												echo 'selected="selected"';
											}
											 ?>>JUNIO</option>
										
										<option value="07" <?php 
											if ($iniciorotacion=="07"){
												echo 'selected="selected"';
											}
											 ?>>JULIO</option>
										
										<option value="08" <?php 
											if ($iniciorotacion=="08"){
												echo 'selected="selected"';
											}
											 ?>>AGOSTO</option>
										
										<option value="09" <?php 
											if ($iniciorotacion=="09"){
												echo 'selected="selected"';
											}
											 ?>>SEPTIEMBRE</option>
										
										<option value="10" <?php 
											if ($iniciorotacion=="10"){
												echo 'selected="selected"';
											}
											 ?>>OCTUBRE</option>
										
										<option value="11" <?php 
											if ($iniciorotacion=="11"){
												echo 'selected="selected"';
											}
											 ?>>NOVIEMBRE</option>
										
										<option value="12" <?php 
											if ($iniciorotacion=="12"){
												echo 'selected="selected"';
											}
											 ?>>DICIEMBRE</option>
										
						</select>
                </td>
				<td class="Cnoexterior" style="display:none">
                	<select id="cfinrotacion<?php echo $con;?>" name="finrotacion" class="form-control" onchange="guardarStocks('<?php echo $idproducto?>','<?php echo $idreferencia?>','sucursales','cfinrotacion','<?php echo $idstock;?>','<?php echo $con ?>')">
										<option value="00" <?php 
											if ($finrotacion=="00"){
												echo 'selected="selected"';
											}
											 ?>>INDEFINIDO</option>
										
										<option value="01" <?php 
											if ($finrotacion=="01"){
												echo 'selected="selected"';
											}
											 ?>>ENERO</option>
										
										<option value="02" <?php 
											if ($finrotacion=="02"){
												echo 'selected="selected"';
											}
											 ?>>FEBRERO</option>
										
										<option value="03" <?php 
											if ($finrotacion=="03"){
												echo 'selected="selected"';
											}
											 ?>>MARZO</option>
										
										<option value="04" <?php 
											if ($finrotacion=="04"){
												echo 'selected="selected"';
											}
											 ?>>ABRIL</option>
										
										<option value="05" <?php 
											if ($finrotacion=="05"){
												echo 'selected="selected"';
											}
											 ?>>MAYO</option>
										
										<option value="06" <?php 
											if ($finrotacion=="06"){
												echo 'selected="selected"';
											}
											 ?>>JUNIO</option>
										
										<option value="07" <?php 
											if ($finrotacion=="07"){
												echo 'selected="selected"';
											}
											 ?>>JULIO</option>
										
										<option value="08" <?php 
											if ($finrotacion=="08"){
												echo 'selected="selected"';
											}
											 ?>>AGOSTO</option>
										
										<option value="09" <?php 
											if ($finrotacion=="09"){
												echo 'selected="selected"';
											}
											 ?>>SEPTIEMBRE</option>
										
										<option value="10" <?php 
											if ($finrotacion=="10"){
												echo 'selected="selected"';
											}
											 ?>>OCTUBRE</option>
										
										<option value="11" <?php 
											if ($finrotacion=="11"){
												echo 'selected="selected"';
											}
											 ?>>NOVIEMBRE</option>
										
										<option value="12" <?php 
											if ($finrotacion=="12"){
												echo 'selected="selected"';
											}
											 ?>>DICIEMBRE</option>
						</select>
                </td>
				
                <td class="sticky-column">
                        <input type="text" id="stockminimo<?php echo $con;?>" name="stockminimo" value="<?php echo $stockminimo;?>" class="form-control decimal" onblur="guardarStocks('<?php echo $idproducto?>','<?php echo $idreferencia?>','sucursales','stockminimo','<?php echo $idstock;?>','<?php echo $con ?>')"/>
                </td>
                <td class="sticky-column">
                		<input type="text" id="stockmaximo<?php echo $con;?>" name="stockmaximo" value="<?php echo $stockmaximo?>" class="form-control decimal" onblur="guardarStocks('<?php echo $idproducto?>','<?php echo $idreferencia?>','sucursales','stockmaximo','<?php echo $idstock;?>','<?php echo $con ?>')"/>
                </td>
                
                <td style=" padding-right:2px;">
					<?php /////PERMISOS////////////////
                    if (isset($_SESSION['permisos']['productos']['modificar'])){ ?>
                            <a class="btn btn-default" onclick="(agregarStock(<?php echo $idproducto ?>,<?php echo $idsucursal?>))" title="Agregar Línea"><i class="fa fa-plus"></i></a>
                        
                    <?php 
                    }else{ ?>
                        <a class="btn btn-default disabled"><i class="fa fa-plus"></i></a>
                    <?php
                    }
                    ?>
                </td>
                
                <td style=" padding-right:2px;">
					<?php /////PERMISOS////////////////
                    if (isset($_SESSION['permisos']['productos']['modificar'])){ ?>
                            <a class="btn btn-default" onclick="eliminarStock('<?php echo $idstock ?>','<?php echo $idproducto; ?>')" title="Eliminar"><i class="fa fa-trash"></i></a>
                        
                    <?php 
                    }else{ ?>
                        <a class="btn btn-default disabled"><i class="fa fa-trash"></i></a>
                    <?php
                    }
                    ?>
                </td>
                
      		</tr>
    <?php
	$con++;
	}//Fin de while si es tabla ?>
		</table>
    <?php   
	
}
?>