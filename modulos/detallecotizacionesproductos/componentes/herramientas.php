<?php
include("../../../componentes/herramientasup.php");
if ($herramientas=="nuevo"){
	include("../../../componentes/herramientasnuevo.php");
}
if ($herramientas=="consultar"){
	include("../../../componentes/herramientasconsultar.php"); ?>
		<?php /////PERMISOS////////////////
        if (isset($_SESSION['permisos']['detallecotizacionesproductos']['eliminar'])){
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
									<option value="subfolio">Subfolio</option>
									<option value="cantidad">Cantidad</option>
									<option value="costo">Costo</option>
									<option value="precio">Precio</option>
									<option value="subtotal">Subtotal</option>
									<option value="impuestos">Impuestos</option>
									<option value="total">Total</option>
									<option value="utilidad">Utilidad</option>
									<option value="idcotizacionproducto">ID cotización producto</option>
									<option value="pesounitario">Peso unitario</option>
									<option value="cantidadentregada">Cantidad entregada</option>
                </select>
                </a>
    		</li>
            <li><a><input id="asc" type="radio" name="orden" value="asc" checked="checked"><label for="asc">&nbsp;&nbsp;Ascendente</label></a></li>
            <li><a><input id="desc" type="radio" name="orden" value="desc"><label for="desc">&nbsp;&nbsp;Descendente</label></a></li>
            <li role="separator" class="divider"></li>
            <li><span class="titulo-herramientas">Mostrar / Ocultar campos</span></li>
				<div style="padding:10px; color:#666; max-height:200px !important; overflow:scroll;">
				<li><a><input id="CheckIddetallecotizacion" name="kiddetallecotizacion" value="si" checked="checked" type="checkbox"/><label for="CheckIddetallecotizacion">&nbsp;&nbsp;ID</label></a></li>
			
				<li><a><input id="CheckSubfolio" name="ksubfolio" value="si" checked="checked" type="checkbox"/><label for="CheckSubfolio">&nbsp;&nbsp;Subfolio</label></a></li>
			
				<li><a><input id="CheckIdproducto" name="kidproducto" value="si" checked="checked" type="checkbox"/><label for="CheckIdproducto">&nbsp;&nbsp;Producto</label></a></li>
			
				<li><a><input id="CheckCantidad" name="kcantidad" value="si" checked="checked" type="checkbox"/><label for="CheckCantidad">&nbsp;&nbsp;Cantidad</label></a></li>
			
				<li><a><input id="CheckCosto" name="kcosto" value="si" checked="checked" type="checkbox"/><label for="CheckCosto">&nbsp;&nbsp;Costo</label></a></li>
			
				<li><a><input id="CheckPrecio" name="kprecio" value="si" checked="checked" type="checkbox"/><label for="CheckPrecio">&nbsp;&nbsp;Precio</label></a></li>
			
				<li><a><input id="CheckSubtotal" name="ksubtotal" value="si" checked="checked" type="checkbox"/><label for="CheckSubtotal">&nbsp;&nbsp;Subtotal</label></a></li>
			
				<li><a><input id="CheckImpuestos" name="kimpuestos" value="si" checked="checked" type="checkbox"/><label for="CheckImpuestos">&nbsp;&nbsp;Impuestos</label></a></li>
			
				<li><a><input id="CheckTotal" name="ktotal" value="si" checked="checked" type="checkbox"/><label for="CheckTotal">&nbsp;&nbsp;Total</label></a></li>
			
				<li><a><input id="CheckUtilidad" name="kutilidad" value="si" checked="checked" type="checkbox"/><label for="CheckUtilidad">&nbsp;&nbsp;Utilidad</label></a></li>
			
				<li><a><input id="CheckIdcotizacionproducto" name="kidcotizacionproducto" value="si" checked="checked" type="checkbox"/><label for="CheckIdcotizacionproducto">&nbsp;&nbsp;ID cotización </label></a></li>
			
				<li><a><input id="CheckPesounitario" name="kpesounitario" value="si" checked="checked" type="checkbox"/><label for="CheckPesounitario">&nbsp;&nbsp;Peso unitario</label></a></li>
			
				<li><a><input id="CheckCantidadentregada" name="kcantidadentregada" value="si" checked="checked" type="checkbox"/><label for="CheckCantidadentregada">&nbsp;&nbsp;Cantidad entregada</label></a></li>
			
            	<li><a><input id="CheckComposicion" name="kcomposicion" value="si" type="checkbox" checked="checked"/><label for="CheckComposicion">&nbsp;&nbsp;Datos inferiores</label></a></li>
          	</div>
		  
		  </ul>
        </li>
<?php    
}
include("../../../componentes/herramientasdown.php");
?>