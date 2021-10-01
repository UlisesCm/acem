<?php
include("../../../componentes/herramientasup.php");
if ($herramientas=="nuevo"){
	include("../../../componentes/herramientasnuevo.php");
}
if ($herramientas=="consultar"){
	include("../../../componentes/herramientasconsultar.php"); ?>
		<?php /////PERMISOS////////////////
        if (isset($_SESSION['permisos']['movimientos']['eliminar'])){
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
									<option value="idmovimiento">ID</option>
									<option value="tipo">Tipo</option>
									<option value="concepto">Concepto o Motivo</option>
									<option value="fechamovimiento">Fecha de movimiento</option>
									<option value="idalmacen">Almacén o sucursal</option>
									<option value="numerocomprobante">No. de comprobante</option>
									<option value="comentarios">Comentarios</option>
                </select>
                </a>
    		</li>
            <li><a><input id="asc" type="radio" name="orden" value="asc" checked="checked"><label for="asc">&nbsp;&nbsp;Ascendente</label></a></li>
            <li><a><input id="desc" type="radio" name="orden" value="desc"><label for="desc">&nbsp;&nbsp;Descendente</label></a></li>
            <li role="separator" class="divider"></li>
            <li><span class="titulo-herramientas">Mostrar / Ocultar campos</span></li>
			<li><a><input id="CheckIdmovimiento" name="kidmovimiento" value="si" checked="checked" type="checkbox"/><label for="CheckIdmovimiento">&nbsp;&nbsp;ID</label></a></li>
			
			<li><a><input id="CheckTipo" name="ktipo" value="si" checked="checked" type="checkbox"/><label for="CheckTipo">&nbsp;&nbsp;Tipo</label></a></li>
			
			<li><a><input id="CheckConcepto" name="kconcepto" value="si" checked="checked" type="checkbox"/><label for="CheckConcepto">&nbsp;&nbsp;Concepto o Motivo</label></a></li>
			
			<li><a><input id="CheckFechamovimiento" name="kfechamovimiento" value="si" checked="checked" type="checkbox"/><label for="CheckFechamovimiento">&nbsp;&nbsp;Fecha de movimiento</label></a></li>
			
			<li><a><input id="CheckIdalmacen" name="kidalmacen" value="si" checked="checked" type="checkbox"/><label for="CheckIdalmacen">&nbsp;&nbsp;Almacen</label></a></li>
			
			<li><a><input id="CheckNumerocomprobante" name="knumerocomprobante" value="si" checked="checked" type="checkbox"/><label for="CheckNumerocomprobante">&nbsp;&nbsp;No. de comprobante</label></a></li>
			
			<li><a><input id="CheckComentarios" name="kcomentarios" value="si" checked="checked" type="checkbox"/><label for="CheckComentarios">&nbsp;&nbsp;Comentarios</label></a></li>
			
            <li><a><input id="CheckComposicion" name="kcomposicion" value="si" type="checkbox" checked="checked"/><label for="CheckComposicion">&nbsp;&nbsp;Datos inferiores</label></a></li>
          </ul>
        </li>
<?php    
}
include("../../../componentes/herramientasdown.php");
?>