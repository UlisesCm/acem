<?php 
	include("../../productos/Producto.class.php");
	$idproveedor=htmlentities($_POST['idproveedor']);
	$Oproducto = new Producto;
	$resultado=$Oproducto->consultaLibre("SELECT
	productos.idproducto,
	productos.codigo,
	productos.nombre,
	productos.pesoteorico,
	productos.pesoreal,
	productos.estatus,
	productos.costo,
	productos.clasificacion,
	unidades.nombre AS nombreunidad
	FROM productos
	INNER JOIN productosproveedores ON productosproveedores.idproducto=productos.idproducto
	INNER JOIN unidades ON unidades.idunidad=productos.idunidad
	WHERE productos.estatus <> 'eliminado' AND productosproveedores.idproveedor='$idproveedor' ORDER BY productos.nombre ASC");
	$con=99999;
	$return_arr = array();
	if(mysqli_num_rows($resultado) > 0){
		while($filas=mysqli_fetch_array($resultado)){
			$pesoteorico=html_entity_decode($filas['pesoteorico']);
			if ($pesoteorico==""){
				$pesoteorico=0;
			}
			//$pesoteorico=floatval($pesoteorico);
			$pesoreal=html_entity_decode($filas['pesoreal']);
			if ($pesoreal==""){
				$pesoreal=0;
			}
			
			$datosStocks=$Oproducto->calcularStocks($filas['idproducto']);
			$existencias=$Oproducto->obtenerExistencias($filas['idproducto']);
			$stockMinimo = $datosStocks[0];
			$stockMaximo = $datosStocks[1];
			$existencias = number_format($existencias,2);
			$costo = html_entity_decode($filas['costo']);
			$habilitar="";
			
			$colorTexto="rgb(0, 0, 255)";
			if ($pesoreal==0 and $pesoteorico==0){
				$habilitar='disabled="disabled"';
				$colorTexto="#CCC";
			}
			
			?>
            <tr>
                <td style="display:none"><?php echo $con?></td>
                <td style="display:none"><?php echo $filas['idproducto']?></td>
                <td style="display:none"><?php echo $filas['codigo']?></td>
                <td class="columnaIzquierda" style="border-left: 10px solid #909;"><?php echo html_entity_decode($filas['nombre'])?></td>
                <td><?php echo html_entity_decode($filas['nombreunidad']) ?></td>
                <td>
                    <input value="0" name="cant<?php echo $con?>" type="text" class="caja" id="cant<?php echo $con?>" onblur="calcular('cant','<?php echo $con?>')" onkeyup="permitirDecimal('cant<?php echo $con?>');" onfocus="activarValidacion('cant<?php echo $con?>');" style="color: rgb(255, 0, 0);">
                </td>
                <td>
                    <input value="<?php echo html_entity_decode($filas['costo'])?>" name="cost<?php echo $con?>" type="text" class="caja" id="cost<?php echo $con?>" onblur="calcular('cost','<?php echo $con?>')" onkeyup="permitirDecimal('cost<?php echo $con?>');" onfocus="activarValidacion('cost<?php echo $con?>');" style="color:rgb(0, 0, 255);">
                </td>
                <td>
                    <input value="0" name="cost2<?php echo $con?>" type="text" class="caja" id="cost2<?php echo $con?>" onblur="calcular('cost2','<?php echo $con?>')" onkeyup="permitirDecimal('cost2<?php echo $con?>');" onfocus="activarValidacion('cost2<?php echo $con?>');" <?php echo $habilitar?> style="color:<?php echo $colorTexto?>">
                </td>
                <td id="monto<?php echo $con?>">0</td>
                <td id="pesoteoricounitario<?php echo $con?>"><?php echo $pesoteorico?></td>
                <td id="pesoreal<?php echo $con?>"><?php echo $pesoreal?></td>
                <td>
                    <input value="0" name="pesoteorico<?php echo $con?>" type="text" class="caja" id="pesoteorico<?php echo $con?>" onblur="calcular('pesoteorico','<?php echo $con?>')" onkeyup="permitirDecimal('pesoteorico<?php echo $con?>');" onfocus="activarValidacion('pesoteorico<?php echo $con?>');" <?php echo $habilitar?> style="color:<?php echo $colorTexto?>">
                </td>
                <td id="existancias<?php echo $con?>"><?php echo $existencias?></td>
                <td id="stockminimo"><?php echo $stockMinimo?></td>
                <td id="stockmaximo<?php echo $con?>"><?php echo $stockMaximo?></td>
                <td><?php echo  html_entity_decode($filas['clasificacion'])?></td>
                <td title="Eliminar Fila" class="eliminarFila">
                    <a class="btn btn-default btn-xs"><i class="fa fa-trash-o text-green"></i></a>
                </td>
            </tr>
            <?php
			$con++;
		}
		echo json_encode($return_arr);
	}
?>