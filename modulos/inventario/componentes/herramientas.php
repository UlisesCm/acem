<?php
include("../../../componentes/herramientasup.php");
if ($herramientas=="nuevo"){
	include("../../../componentes/herramientasnuevo.php");
}
if ($herramientas=="consultar"){
	include("../../../componentes/herramientasconsultar.php"); ?>
		<?php /////PERMISOS////////////////
        if (isset($_SESSION['permisos']['inventario']['eliminar'])){
		?>
		<li class="btn-default border-right botonEliminar" title="Eliminar varios registros"><a href="#"><i class="fa fa-trash-o"></i><span class="visible-xs-inline">&nbsp;&nbsp;Eliminar</span></a></li>
    	<?php
		}
		?>
		<li class="dropdown btn-defaul border-right" style="background:#F4F4F4;" title="Visualización y ordenamiento">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"><i class="fa fa-eye"></i><span class="visible-xs-inline">&nbsp;&nbsp;Visualización y ordenamiento</span></a>
          <ul class="dropdown-menu dropdown-menu-form" style="min-width:250px;;">
            <li><span class="titulo-herramientas">Resultados por hoja:</span></li>
            <li><a>
            	<select id="cantidadamostrar" class="form-control input-sm">
                	<option value="1">1</option>
                	<option value="2">2</option>
                    <option value="5">5</option>
                    <option value="20">20</option>
                	<option value="30">30</option>
                	<option value="50">50</option>
                	<option value="100">100</option>
                    <option value="200">200</option>
                </select>
                </a></li>
            <li role="separator" class="divider"></li>
            <li><span class="titulo-herramientas">Ordenar por:</span></li>
            <li><a>
            	<select id="campoOrden" class="form-control input-sm">
									<option value="idinventario">ID</option>
									<option value="idalmacen">Almacén</option>
									<option value="idproducto">Producto</option>
									<option value="existencia">Existencia</option>
									<option value="promedio">Costo Promedio</option>
									<option value="saldo">Saldo</option>
									<option value="minimo">Stock Mínimo</option>
									<option value="ubicacion">Ubicación</option>
									<option value="estado">Estado</option>
                </select>
                </a>
    		</li>
            <li><a><input id="asc" type="radio" name="orden" value="asc" checked="checked"><label for="asc">&nbsp;&nbsp;Ascendente</label></a></li>
            <li><a><input id="desc" type="radio" name="orden" value="desc"><label for="desc">&nbsp;&nbsp;Descendente</label></a></li>
            <li role="separator" class="divider"></li>
            <li><span class="titulo-herramientas">Mostrar / Ocultar campos</span></li>
				<div style="padding:10px; color:#666; max-height:200px !important; overflow:scroll;">
				<li><a><input id="CheckIdinventario" name="kidinventario" value="si" checked="checked" type="checkbox"/><label for="CheckIdinventario">&nbsp;&nbsp;ID</label></a></li>
			
				<li><a><input id="CheckIdalmacen" name="kidalmacen" value="si" checked="checked" type="checkbox"/><label for="CheckIdalmacen">&nbsp;&nbsp;Almacén</label></a></li>
			
				<li><a><input id="CheckIdproducto" name="kidproducto" value="si" checked="checked" type="checkbox"/><label for="CheckIdproducto">&nbsp;&nbsp;Producto</label></a></li>
			
				<li><a><input id="CheckExistencia" name="kexistencia" value="si" checked="checked" type="checkbox"/><label for="CheckExistencia">&nbsp;&nbsp;Existencia</label></a></li>
			
				<li><a><input id="CheckPromedio" name="kpromedio" value="si" checked="checked" type="checkbox"/><label for="CheckPromedio">&nbsp;&nbsp; Costo Promedio</label></a></li>
			
				<li><a><input id="CheckSaldo" name="ksaldo" value="si" checked="checked" type="checkbox"/><label for="CheckSaldo">&nbsp;&nbsp;Saldo</label></a></li>
			
				<li><a><input id="CheckMinimo" name="kminimo" value="si" checked="checked" type="checkbox"/><label for="CheckMinimo">&nbsp;&nbsp;Stock Mínimo</label></a></li>
			
				<li><a><input id="CheckUbicacion" name="kubicacion" value="si" checked="checked" type="checkbox"/><label for="CheckUbicacion">&nbsp;&nbsp;Ubicación</label></a></li>
			
				<li><a><input id="CheckEstado" name="kestado" value="si" checked="checked" type="checkbox"/><label for="CheckEstado">&nbsp;&nbsp;Estado</label></a></li>
			
            	<li><a><input id="CheckComposicion" name="kcomposicion" value="si" type="checkbox" checked="checked"/><label for="CheckComposicion">&nbsp;&nbsp;Datos inferiores</label></a></li>
          	</div>
		  
		  </ul>
        </li>
<?php    
}
include("../../../componentes/herramientasdown.php");
?>