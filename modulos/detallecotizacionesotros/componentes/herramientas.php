<?php
include("../../../componentes/herramientasup.php");
if ($herramientas=="nuevo"){
	include("../../../componentes/herramientasnuevo.php");
}
if ($herramientas=="consultar"){
	include("../../../componentes/herramientasconsultar.php"); ?>
		<?php /////PERMISOS////////////////
        if (isset($_SESSION['permisos']['detallecotizacionesotros']['eliminar'])){
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
									<option value="idcliente">Cliente</option>
									<option value="fecha">Fecha</option>
									<option value="total">Total</option>
									<option value="estadopago">Estado pago</option>
									<option value="estadofacturacion">Estado de facturación</option>
									<option value="factura">Factura</option>
                </select>
                </a>
    		</li>
            <li><a><input id="asc" type="radio" name="orden" value="asc" checked="checked"><label for="asc">&nbsp;&nbsp;Ascendente</label></a></li>
            <li><a><input id="desc" type="radio" name="orden" value="desc"><label for="desc">&nbsp;&nbsp;Descendente</label></a></li>
            <li role="separator" class="divider"></li>
            <li><span class="titulo-herramientas">Mostrar / Ocultar campos</span></li>
				<div style="padding:10px; color:#666; max-height:200px !important; overflow:scroll;">
				<li><a><input id="CheckIdcliente" name="kidcliente" value="si" checked="checked" type="checkbox"/><label for="CheckIdcliente">&nbsp;&nbsp;Cliente</label></a></li>
			
				<li><a><input id="CheckFecha" name="kfecha" value="si" checked="checked" type="checkbox"/><label for="CheckFecha">&nbsp;&nbsp;Fecha</label></a></li>
			
				<li><a><input id="CheckCantidad" name="kcantidad" value="si" checked="checked" type="checkbox"/><label for="CheckCantidad">&nbsp;&nbsp;Cantidad</label></a></li>
			
				<li><a><input id="CheckConcepto" name="kconcepto" value="si" checked="checked" type="checkbox"/><label for="CheckConcepto">&nbsp;&nbsp;Concepto</label></a></li>
			
				<li><a><input id="CheckUnidad" name="kunidad" value="si" checked="checked" type="checkbox"/><label for="CheckUnidad">&nbsp;&nbsp;Unidad</label></a></li>
			
				<li><a><input id="CheckNumeroservicio" name="knumeroservicio" value="si" checked="checked" type="checkbox"/><label for="CheckNumeroservicio">&nbsp;&nbsp;Número servicio</label></a></li>
			
				<li><a><input id="CheckTotalservicios" name="ktotalservicios" value="si" checked="checked" type="checkbox"/><label for="CheckTotalservicios">&nbsp;&nbsp;Total de servicios</label></a></li>
			
				<li><a><input id="CheckIdcotizacionotros" name="kidcotizacionotros" value="si" checked="checked" type="checkbox"/><label for="CheckIdcotizacionotros">&nbsp;&nbsp;Idcotizacionotros</label></a></li>
			
				<li><a><input id="CheckPrecio" name="kprecio" value="si" checked="checked" type="checkbox"/><label for="CheckPrecio">&nbsp;&nbsp;Precio</label></a></li>
			
				<li><a><input id="CheckImpuestos" name="kimpuestos" value="si" checked="checked" type="checkbox"/><label for="CheckImpuestos">&nbsp;&nbsp;Impuestos</label></a></li>
			
				<li><a><input id="CheckTotal" name="ktotal" value="si" checked="checked" type="checkbox"/><label for="CheckTotal">&nbsp;&nbsp;Total</label></a></li>
			
				<li><a><input id="CheckIdmodeloimpuestos" name="kidmodeloimpuestos" value="si" checked="checked" type="checkbox"/><label for="CheckIdmodeloimpuestos">&nbsp;&nbsp;Idmodeloimpuestos</label></a></li>
			
				<li><a><input id="CheckEstadopago" name="kestadopago" value="si" checked="checked" type="checkbox"/><label for="CheckEstadopago">&nbsp;&nbsp;Estado pago</label></a></li>
			
				<li><a><input id="CheckEstadofacturacion" name="kestadofacturacion" value="si" checked="checked" type="checkbox"/><label for="CheckEstadofacturacion">&nbsp;&nbsp;Estado de facturación</label></a></li>
			
				<li><a><input id="CheckFactura" name="kfactura" value="si" checked="checked" type="checkbox"/><label for="CheckFactura">&nbsp;&nbsp;Factura</label></a></li>
			
				<li><a><input id="CheckEstatus" name="kestatus" value="si" checked="checked" type="checkbox"/><label for="CheckEstatus">&nbsp;&nbsp;Estatus</label></a></li>
			
            	<li><a><input id="CheckComposicion" name="kcomposicion" value="si" type="checkbox" checked="checked"/><label for="CheckComposicion">&nbsp;&nbsp;Datos inferiores</label></a></li>
          	</div>
		  
		  </ul>
        </li>
<?php    
}
include("../../../componentes/herramientasdown.php");
?>