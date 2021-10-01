<?php
include("../../../componentes/herramientasup.php");
if ($herramientas=="nuevo"){ ?>
	<li class="btn-default border-right tipoDescripcion" title="Búsqueda por descripción"><a href="#"><i class="fa fa-search"></i> <i class="fa fa-font"></i><span class="visible-xs-inline">&nbsp;&nbsp;Busca productos por descripción</span></a></li>
    <li class="btn-default border-right tipoCB" title="Búsqueda por Código de Barras"><a href="#"><i class="fa fa-search"></i> <i class="fa fa-barcode"></i><span class="visible-xs-inline">&nbsp;&nbsp;Busca productos por código de barras</span></a></li>
	<?php
    include("../../../componentes/herramientasnuevo.php");
}
if ($herramientas=="consultar"){
	?>
    <li class="btn-default border-right" title="Exportar Consulta a Excel"><a href="#" class="botonExportar"><i class="fa fa-file-excel-o"></i><span class="visible-xs-inline">&nbsp;&nbsp;Exportar a Excel</span></a></li>
	<li class="btn-default border-right" title="Imprimir Ticket"><a href="#" class="printer"><i class="fa fa-print"></i><span class="visible-xs-inline">&nbsp;&nbsp;Imprimir Ticket</span></a></li>
	<?php 
	include("../../../componentes/herramientasconsultar.php"); ?>
		<?php /////PERMISOS////////////////
        if (isset($_SESSION['permisos']['ventas']['eliminar'])){
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
									<option value="idventa">ID</option>
									<option value="fecha">Fecha</option>
									<option value="hora">Hora</option>
									<option value="formapago">Forma de pago</option>
									<option value="total">Total</option>
									<option value="estado">Estado</option>
									<option value="idcliente">Cliente</option>
									<option value="idcaja">No. Corte</option>
									<option value="idempleado">Empleado</option>
									<option value="idalmacen">Almacén</option>
                </select>
                </a>
    		</li>
            <li><a><input id="asc" type="radio" name="orden" value="asc" checked="checked"><label for="asc">&nbsp;&nbsp;Ascendente</label></a></li>
            <li><a><input id="desc" type="radio" name="orden" value="desc"><label for="desc">&nbsp;&nbsp;Descendente</label></a></li>
            <li role="separator" class="divider"></li>
            <li><span class="titulo-herramientas">Mostrar / Ocultar campos</span></li>
			<li><a><input id="CheckIdventa" name="kidventa" value="si" checked="checked" type="checkbox"/><label for="CheckIdventa">&nbsp;&nbsp;ID</label></a></li>
			
			<li><a><input id="CheckFecha" name="kfecha" value="si" checked="checked" type="checkbox"/><label for="CheckFecha">&nbsp;&nbsp;Fecha</label></a></li>
			
			<li><a><input id="CheckHora" name="khora" value="si" checked="checked" type="checkbox"/><label for="CheckHora">&nbsp;&nbsp;Hora</label></a></li>
			
			<li><a><input id="CheckFormapago" name="kformapago" value="si" checked="checked" type="checkbox"/><label for="CheckFormapago">&nbsp;&nbsp;Forma de pago</label></a></li>
			
			<li><a><input id="CheckEfectivo" name="kefectivo" value="si" checked="checked" type="checkbox"/><label for="CheckEfectivo">&nbsp;&nbsp;Efectivo</label></a></li>
			
			<li><a><input id="CheckCredito" name="kcredito" value="si" checked="checked" type="checkbox"/><label for="CheckCredito">&nbsp;&nbsp;Crédito</label></a></li>
			
			<li><a><input id="CheckTarjeta" name="ktarjeta" value="si" checked="checked" type="checkbox"/><label for="CheckTarjeta">&nbsp;&nbsp;Tarjeta</label></a></li>
			
			<li><a><input id="CheckReferencia" name="kreferencia" value="si" checked="checked" type="checkbox"/><label for="CheckReferencia">&nbsp;&nbsp;Referencia</label></a></li>
			
			<li><a><input id="CheckSubtotal" name="ksubtotal" value="si" checked="checked" type="checkbox"/><label for="CheckSubtotal">&nbsp;&nbsp;Subtotal</label></a></li>
			
			<li><a><input id="CheckIva" name="kiva" value="si" checked="checked" type="checkbox"/><label for="CheckIva">&nbsp;&nbsp;IVA</label></a></li>
			
			<li><a><input id="CheckIeps" name="kieps" value="si" checked="checked" type="checkbox"/><label for="CheckIeps">&nbsp;&nbsp;IEPS</label></a></li>
			
			<li><a><input id="CheckTotal" name="ktotal" value="si" checked="checked" type="checkbox"/><label for="CheckTotal">&nbsp;&nbsp;Total</label></a></li>
			
			<li><a><input id="CheckEstado" name="kestado" value="si" checked="checked" type="checkbox"/><label for="CheckEstado">&nbsp;&nbsp;Estado</label></a></li>
			
			<li><a><input id="CheckIdcliente" name="kidcliente" value="si" checked="checked" type="checkbox"/><label for="CheckIdcliente">&nbsp;&nbsp;Cliente</label></a></li>
			
			<li><a><input id="CheckIdcaja" name="kidcaja" value="si" checked="checked" type="checkbox"/><label for="CheckIdcaja">&nbsp;&nbsp;No. Corte</label></a></li>
			
			<li><a><input id="CheckIdempleado" name="kidempleado" value="si" checked="checked" type="checkbox"/><label for="CheckIdempleado">&nbsp;&nbsp;Empleado</label></a></li>
			
			<li><a><input id="CheckIdalmacen" name="kidalmacen" value="si" checked="checked" type="checkbox"/><label for="CheckIdalmacen">&nbsp;&nbsp;Almacén</label></a></li>
			
            <li><a><input id="CheckComposicion" name="kcomposicion" value="si" type="checkbox" checked="checked"/><label for="CheckComposicion">&nbsp;&nbsp;Datos inferiores</label></a></li>
          </ul>
        </li>
<?php    
}
include("../../../componentes/herramientasdown.php");
?>