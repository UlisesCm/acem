<?php
require("../../productos/Producto.class.php");
require('../Cotizacionproducto.class.php');

//recepcion de variables de funcion ajax
//descripción de producto

if (isset($_POST['productofiltro'])){//éste objeto está en el archivo modal junto con zona y sucursal
	$producto=htmlentities(trim($_POST['productofiltro']));
	
}else{
	$mensaje=$mensaje."<p>El campo producto no es correcto</p>";
}
//resibir mas variables de filtro como marca espesor etc


llenarCatalogodeProductos($producto);

function llenarCatalogodeProductos($producto){ 
	$Oproducto=new Producto;
	//armar la consulta según las variables que se hayan involucrado en la busqueda
	
	//talvez la consulta debera ser un INNER join con las tablas relacionadas para poder filtrar por nombre de marca por ejemplo si es que se usa un autocomplete
	$consulta= "SELECT * FROM productos WHERE nombre LIKE '%".$producto."%'";
    $resultado=$Oproducto->consultaLibre($consulta);
?>
	<div style="overflow:scroll"> <!-- /.box-body -->
    	<table class="table table-hover table-bordered">
        	<tr>
        		<th class="checksEliminar" width="10"><input id="seleccionarTodo" type="checkbox"  onclick="seleccionarTodo();"></th>
                <th class="columnaDecorada" style="background:#494441;"></th>
				<th class="Cidproducto" style = "display:none">ID</th>
				<th class="Ccodigo">Clave</th>
                <th class="Cnombre">Nombre</th>
                <!-- /cargar columnas con existencias de todas las sucursales -->
				<th class="Cidmarca">Marca</th>
				<th class="Cpesoteorico">Peso teórico</th>
				<th class="Cespesor">Espesor</th>
				<th class="Cancho">Ancho</th>
				<th class="Ccolor">Color</th>
				<th class="Cdiametro">Diametro</th>
				<th class="Ctipo">Tipo</th>
				<th class="Cmodelo">Modelo</th>
				<th class="Clado">Lado</th>
				<th class="Cdescripcion">Descripción</th>
      		</tr>
	<?php
	while ($filas=mysqli_fetch_array($resultado)) { ?>
      		<tr id="iregistro<?php echo $filas['idproducto'] ?>">
        		<td class="checksEliminar" width="30" valign="middle">
					<?php /////PERMISOS////////////////
                	if (isset($_SESSION['permisos']['productos']['eliminar'])){ ?>
                		<?php if($filas['idproducto']!=0){ ?>
							<input id="registroEliminar<?php echo $filas['idproducto'] ?>" type="checkbox" name="registroEliminar[]"  value="<?php echo $filas['idproducto'] ?>" class="checkEliminar">
                    	<?php } ?>
					<?php 
					}
					?>
            	</td>
                <td class="columnaDecorada" style="background:#494441;"></td>
				<td class="Cidproducto" style = "display:none"><?php echo $filas['idproducto']; ?></td>
                <td class="Ccodigo"><?php echo $filas['codigo']; ?></td>
				<td class="Cnombre"><?php echo $filas['nombre']; ?></td>
                <!-- /cargar columnas con existencias de todas las sucursales -->
				<td class="Cidmarca"><?php echo $filas['idmarca']; ?></td>
				<td class="Cpesoteorico"><?php echo $filas['pesoteorico']; ?></td>
				<td class="Cespesor"><?php echo $filas['espesor']; ?></td>
				<td class="Cancho"><?php echo $filas['ancho']; ?></td>
				<td class="Ccolor"><?php echo $filas['color']; ?></td>
				<td class="Cdiametro"><?php echo $filas['diametro']; ?></td>
				<td class="Ctipo"><?php echo $filas['tipo']; ?></td>
				<td class="Cmodelo"><?php echo $filas['modelo']; ?></td>
				<td class="Clado"><?php echo $filas['lado']; ?></td>
				<td class="Cdescripcion"><?php echo $filas['descripcion']; ?></td>
                <td class="sticky-column">
                    <button type="button" class="btn btn-primary btn-xs" data-dismiss="modal" onclick="CargarProductoDesdeModal('<?php echo $filas['idproducto']?>','<?php echo $filas['nombre']; ?>')"><i class="fa fa-arrow-down"></i></button>
                </td>
      		</tr>
    <?php
	}//Fin de while si es tabla ?>
		</table>
	</div><!-- /.box-body -->
<?php
}
?>