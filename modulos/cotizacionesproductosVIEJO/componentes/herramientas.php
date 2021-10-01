<?php
include("../../../componentes/herramientasup.php");
if ($herramientas=="nuevo"){
	include("../../../componentes/herramientasnuevo.php");
}
if ($herramientas=="consultar"){
	include("../../../componentes/herramientasconsultar.php"); ?>
		<?php /////PERMISOS////////////////
        if (isset($_SESSION['permisos']['cotizacionesproductos']['eliminar'])){
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
									<option value="serie">Serie</option>
									<option value="folio">Folio</option>
									<option value="fecha">Fecha</option>
									<option value="hora">Hora</option>
									<option value="estadopago">Estado pago</option>
									<option value="estadofacturacion">Estado facturación</option>
									<option value="tipo">Tipo</option>
									<option value="subtotal">Subtotal</option>
									<option value="impuestos">Impuestos</option>
									<option value="total">Total</option>
									<option value="idcliente">Cliente</option>
									<option value="idusuario">Usuario</option>
									<option value="idempleado">Vendedor</option>
									<option value="enviaradomicilio">Entrega</option>
									<option value="fechaentrega">Fecha entrega</option>
									<option value="horaentregainicio">Hora entrega inicio</option>
									<option value="horaentregafin">Hora entrega fin</option>
									<option value="prioridad">Prioridad</option>
									<option value="domicilioentrega">Domicilio de entrega</option>
									<option value="coordenadas">Coordenadas</option>
									<option value="observaciones">Observaciones</option>
									<option value="estadoentrega">Estado entrega</option>
                </select>
                </a>
    		</li>
            <li><a><input id="asc" type="radio" name="orden" value="asc" checked="checked"><label for="asc">&nbsp;&nbsp;Ascendente</label></a></li>
            <li><a><input id="desc" type="radio" name="orden" value="desc"><label for="desc">&nbsp;&nbsp;Descendente</label></a></li>
            <li role="separator" class="divider"></li>
            <li><span class="titulo-herramientas">Mostrar / Ocultar campos</span></li>
				<div style="padding:10px; color:#666; max-height:200px !important; overflow:scroll;">
				<li><a><input id="CheckIdcotizacionproducto" name="kidcotizacionproducto" value="si" checked="checked" type="checkbox"/><label for="CheckIdcotizacionproducto">&nbsp;&nbsp;ID</label></a></li>
			
				<li><a><input id="CheckSerie" name="kserie" value="si" checked="checked" type="checkbox"/><label for="CheckSerie">&nbsp;&nbsp;Serie</label></a></li>
			
				<li><a><input id="CheckFolio" name="kfolio" value="si" checked="checked" type="checkbox"/><label for="CheckFolio">&nbsp;&nbsp;Folio</label></a></li>
			
				<li><a><input id="CheckFecha" name="kfecha" value="si" checked="checked" type="checkbox"/><label for="CheckFecha">&nbsp;&nbsp;Fecha</label></a></li>
			
				<li><a><input id="CheckHora" name="khora" value="si" checked="checked" type="checkbox"/><label for="CheckHora">&nbsp;&nbsp;Hora</label></a></li>
			
				<li><a><input id="CheckEstadopago" name="kestadopago" value="si" checked="checked" type="checkbox"/><label for="CheckEstadopago">&nbsp;&nbsp;Estado pago</label></a></li>
			
				<li><a><input id="CheckEstadofacturacion" name="kestadofacturacion" value="si" checked="checked" type="checkbox"/><label for="CheckEstadofacturacion">&nbsp;&nbsp;Estado facturación</label></a></li>
			
				<li><a><input id="CheckTipo" name="ktipo" value="si" checked="checked" type="checkbox"/><label for="CheckTipo">&nbsp;&nbsp;Tipo</label></a></li>
			
				<li><a><input id="CheckSubtotal" name="ksubtotal" value="si" checked="checked" type="checkbox"/><label for="CheckSubtotal">&nbsp;&nbsp;Subtotal</label></a></li>
			
				<li><a><input id="CheckImpuestos" name="kimpuestos" value="si" checked="checked" type="checkbox"/><label for="CheckImpuestos">&nbsp;&nbsp;Impuestos</label></a></li>
			
				<li><a><input id="CheckTotal" name="ktotal" value="si" checked="checked" type="checkbox"/><label for="CheckTotal">&nbsp;&nbsp;Total</label></a></li>
			
				<li><a><input id="CheckIdcliente" name="kidcliente" value="si" checked="checked" type="checkbox"/><label for="CheckIdcliente">&nbsp;&nbsp;Cliente</label></a></li>
			
				<li><a><input id="CheckIdusuario" name="kidusuario" value="si" checked="checked" type="checkbox"/><label for="CheckIdusuario">&nbsp;&nbsp;Usuario</label></a></li>
			
				<li><a><input id="CheckIdempleado" name="kidempleado" value="si" checked="checked" type="checkbox"/><label for="CheckIdempleado">&nbsp;&nbsp;Vendedor</label></a></li>
			
				<li><a><input id="CheckEnviaradomicilio" name="kenviaradomicilio" value="si" checked="checked" type="checkbox"/><label for="CheckEnviaradomicilio">&nbsp;&nbsp;Entrega</label></a></li>
			
				<li><a><input id="CheckFechaentrega" name="kfechaentrega" value="si" checked="checked" type="checkbox"/><label for="CheckFechaentrega">&nbsp;&nbsp;Fecha entrega</label></a></li>
			
				<li><a><input id="CheckHoraentregainicio" name="khoraentregainicio" value="si" checked="checked" type="checkbox"/><label for="CheckHoraentregainicio">&nbsp;&nbsp;Hora entrega inicio</label></a></li>
			
				<li><a><input id="CheckHoraentregafin" name="khoraentregafin" value="si" checked="checked" type="checkbox"/><label for="CheckHoraentregafin">&nbsp;&nbsp;Hora entrega fin</label></a></li>
			
				<li><a><input id="CheckPrioridad" name="kprioridad" value="si" checked="checked" type="checkbox"/><label for="CheckPrioridad">&nbsp;&nbsp;Prioridad</label></a></li>
			
				<li><a><input id="CheckDomicilioentrega" name="kdomicilioentrega" value="si" checked="checked" type="checkbox"/><label for="CheckDomicilioentrega">&nbsp;&nbsp;Domicilio de entrega</label></a></li>
			
				<li><a><input id="CheckCoordenadas" name="kcoordenadas" value="si" checked="checked" type="checkbox"/><label for="CheckCoordenadas">&nbsp;&nbsp;Coordenadas</label></a></li>
			
				<li><a><input id="CheckObservaciones" name="kobservaciones" value="si" checked="checked" type="checkbox"/><label for="CheckObservaciones">&nbsp;&nbsp;Observaciones</label></a></li>
			
				<li><a><input id="CheckEstadoentrega" name="kestadoentrega" value="si" checked="checked" type="checkbox"/><label for="CheckEstadoentrega">&nbsp;&nbsp;Estado entrega</label></a></li>
			
            	<li><a><input id="CheckComposicion" name="kcomposicion" value="si" type="checkbox" checked="checked"/><label for="CheckComposicion">&nbsp;&nbsp;Datos inferiores</label></a></li>
          	</div>
		  
		  </ul>
        </li>
<?php    
}
include("../../../componentes/herramientasdown.php");
?>