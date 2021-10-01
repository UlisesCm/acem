<?php
require("../Producto.class.php");
if (isset($_POST['idproducto'])){
	$idproducto=htmlentities(trim($_POST['idproducto']));
	llenarStocks($idproducto);
}else{
	echo "<p>El campo idproducto no es correcto</p>";
}

function llenarStocks($idproducto){
	$Oproducto=new Producto;
	$resultado=$Oproducto->consultaLibre(" SELECT
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
                <th class="Celiminar" width="30"></th>
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