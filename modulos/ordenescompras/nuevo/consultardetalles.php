<?php
require("../Compra.class.php");
$Ocompra=new Compra;
$idprodcuto=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$codigoproducto=$Ocompra->obtenerCampo("productos","codigo","idproducto",$id);
	$nombreproducto=$Ocompra->obtenerCampo("productos","nombre","idproducto",$id);
	$idfila=htmlentities(trim($_POST['idfila']));
?>
			<blockquote style="font-size:14px;">
            	<p><b>Producto:</b> <?php echo strtoupper($nombreproducto)?></p>
                <small>Clave:  <cite title="Source Title"><?php echo $codigoproducto; ?></cite></small>
    		</blockquote>
            
            <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class=""><a href="#tab_1" data-toggle="tab" aria-expanded="true">Proveedores</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                <?php echo llenarDetalles($id, $idfila); ?>
              </div>
              <!-- /.tab-pane -->
              
            </div>
            <!-- /.tab-content -->
          </div>
<?php
}


function colocarCalificacion($calificacion){
	if ($calificacion==1){
			$estrella1="<li class='fa fa-star'></li>";
			$estrella2="<li class='fa fa-star-o'></li>";
			$estrella3="<li class='fa fa-star-o'></li>";
			$estrella4="<li class='fa fa-star-o'></li>";
			$estrella5="<li class='fa fa-star-o'></li>";
		}
		if ($calificacion==2){
			$estrella1="<li class='fa fa-star'></li>";
			$estrella2="<li class='fa fa-star'></li>";
			$estrella3="<li class='fa fa-star-o'></li>";
			$estrella4="<li class='fa fa-star-o'></li>";
			$estrella5="<li class='fa fa-star-o'></li>";
		}
		if ($calificacion==3){
			$estrella1="<li class='fa fa-star'></li>";
			$estrella2="<li class='fa fa-star'></li>";
			$estrella3="<li class='fa fa-star'></li>";
			$estrella4="<li class='fa fa-star-o'></li>";
			$estrella5="<li class='fa fa-star-o'></li>";
		}
		if ($calificacion==4){
			$estrella1="<li class='fa fa-star'></li>";
			$estrella2="<li class='fa fa-star'></li>";
			$estrella3="<li class='fa fa-star'></li>";
			$estrella4="<li class='fa fa-star'></li>";
			$estrella5="<li class='fa fa-star-o'></li>";
		}
		if ($calificacion==5){
			$estrella1="<li class='fa fa-star'></li>";
			$estrella2="<li class='fa fa-star'></li>";
			$estrella3="<li class='fa fa-star'></li>";
			$estrella4="<li class='fa fa-star'></li>";
			$estrella5="<li class='fa fa-star'></li>";
		}
		return $estrella1.$estrella2.$estrella3.$estrella4.$estrella5;
}
function llenarDetalles($idproducto, $idfila){
	$Ocompra=new Compra;
	$resultado=$Ocompra->mostrarProveedores($idproducto);
	
	?>
    	<table class="table table-hover table-bordered">
        	<tr>
                <th class="columnaDecorada" style="background:#2ea737;"></th>
                <th class="Cidproveedor">idproveedor</th>
				<th class="Cnombreproveedor">Proveedor</th>
				<th class="Cprecio1">Precio</th>
				<th class="Ctiemporespuesta">Tiempo de respuesta</th>
				<th class="Cnivelcalidad">Nivel de calidad</th>
                <th class="Cnivelexistencia">Nivel de existencia</th>
				
                <th width="40" class="sticky-column"></th>
      		</tr>
    <?php
	while ($filas=mysqli_fetch_array($resultado)) {
		
	
		
		?>
      		<tr id="iregistro<?php echo $filas['idproveedor'] ?>">
                <td class="columnaDecorada" style="background:#2ea737;"></td>
                <td class="Cidproveedor"><i><small><?php echo $filas['idproveedor']; ?></small></i></td>
				<td class="Cnombreproveedor"><i><small><?php echo $filas['nombreproveedor']; ?></small></i></td>
				<td class="Cprecio1"><?php echo $filas['precio1']; ?></td>
				<td class="Ctiemporespuesta"><?php echo $filas['tiempo']; ?></td>
				<td class="Cnivelcalidad"><?php echo colocarCalificacion($filas['calidad']); ?></td>
                <td class="Cnivelexistencia"><?php echo colocarCalificacion($filas['existencia']); ?></td>
				
                <td class="sticky-column">
                    
                        <button type="button" data-dismiss="modal" class="btn btn-success btn-xs" value=""  onclick="seleccionarProveedor(<?php echo $idfila; ?>,'<?php echo $filas['precio1']?>','<?php echo $filas['idproveedor']?>','<?php echo $filas['nombreproveedor']; ?>')" title="Seleccionar proveedor"><li class="fa fa-share"></li></button>
                	
                </td>
      		</tr>
    <?php
	}//Fin de while si es tabla ?>
		</table>
    <?php   
}
?>