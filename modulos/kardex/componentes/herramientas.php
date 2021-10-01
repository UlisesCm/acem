<?php
include("../../../componentes/herramientasup.php");
if ($herramientas=="nuevo"){
	include("../../../componentes/herramientasnuevo.php");
}
if ($herramientas=="consultar"){
	include("../../../componentes/herramientasconsultar.php"); ?>
		<?php /////PERMISOS////////////////
        if (isset($_SESSION['permisos']['kardex']['eliminar'])){
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
									<option value="idproducto">Producto</option>
									<option value="fechamovimiento">Fecha de movimiento</option>
									<option value="descripcion">Descripción</option>
									<option value="idalmacen">Almacén</option>
									<option value="idmovimiento">No. movimiento</option>
									<option value="idreferencia">Referencia</option>
                </select>
                </a>
    		</li>
            <li><a><input id="asc" type="radio" name="orden" value="asc" checked="checked"><label for="asc">&nbsp;&nbsp;Ascendente</label></a></li>
            <li><a><input id="desc" type="radio" name="orden" value="desc"><label for="desc">&nbsp;&nbsp;Descendente</label></a></li>
            <li role="separator" class="divider"></li>
            <li><span class="titulo-herramientas">Mostrar / Ocultar campos</span></li>
				<div style="padding:10px; color:#666; max-height:200px !important; overflow:scroll;">
				<li><a><input id="CheckIdkardex" name="kidkardex" value="si" checked="checked" type="checkbox"/><label for="CheckIdkardex">&nbsp;&nbsp;ID</label></a></li>
			
				<li><a><input id="CheckIdproducto" name="kidproducto" value="si" checked="checked" type="checkbox"/><label for="CheckIdproducto">&nbsp;&nbsp;Producto</label></a></li>
			
				<li><a><input id="CheckFechamovimiento" name="kfechamovimiento" value="si" checked="checked" type="checkbox"/><label for="CheckFechamovimiento">&nbsp;&nbsp;Fecha de movimiento</label></a></li>
			
				<li><a><input id="CheckDescripcion" name="kdescripcion" value="si" checked="checked" type="checkbox"/><label for="CheckDescripcion">&nbsp;&nbsp;Descripción</label></a></li>
			
				<li><a><input id="CheckObservaciones" name="kobservaciones" value="si" checked="checked" type="checkbox"/><label for="CheckObservaciones">&nbsp;&nbsp;Observaciones</label></a></li>
			
				<li><a><input id="CheckEntrada" name="kentrada" value="si" checked="checked" type="checkbox"/><label for="CheckEntrada">&nbsp;&nbsp;Entrada</label></a></li>
			
				<li><a><input id="CheckSalida" name="ksalida" value="si" checked="checked" type="checkbox"/><label for="CheckSalida">&nbsp;&nbsp;Salida</label></a></li>
			
				<li><a><input id="CheckExistencia" name="kexistencia" value="si" checked="checked" type="checkbox"/><label for="CheckExistencia">&nbsp;&nbsp;Existencia</label></a></li>
			
				<li><a><input id="CheckCostounitario" name="kcostounitario" value="si" checked="checked" type="checkbox"/><label for="CheckCostounitario">&nbsp;&nbsp;Costo unitario</label></a></li>
			
				<li><a><input id="CheckPromedio" name="kpromedio" value="si" checked="checked" type="checkbox"/><label for="CheckPromedio">&nbsp;&nbsp;Costo promedio</label></a></li>
			
				<li><a><input id="CheckDebe" name="kdebe" value="si" checked="checked" type="checkbox"/><label for="CheckDebe">&nbsp;&nbsp;Debe</label></a></li>
			
				<li><a><input id="CheckHaber" name="khaber" value="si" checked="checked" type="checkbox"/><label for="CheckHaber">&nbsp;&nbsp;Haber</label></a></li>
			
				<li><a><input id="CheckSaldo" name="ksaldo" value="si" checked="checked" type="checkbox"/><label for="CheckSaldo">&nbsp;&nbsp;Saldo</label></a></li>
			
				<li><a><input id="CheckIdalmacen" name="kidalmacen" value="si" checked="checked" type="checkbox"/><label for="CheckIdalmacen">&nbsp;&nbsp;Almacén</label></a></li>
			
				<li><a><input id="CheckIdmovimiento" name="kidmovimiento" value="si" checked="checked" type="checkbox"/><label for="CheckIdmovimiento">&nbsp;&nbsp;No. movimiento</label></a></li>
			
				<li><a><input id="CheckIdreferencia" name="kidreferencia" value="si" checked="checked" type="checkbox"/><label for="CheckIdreferencia">&nbsp;&nbsp;Referencia</label></a></li>
			
            	<li><a><input id="CheckComposicion" name="kcomposicion" value="si" type="checkbox" checked="checked"/><label for="CheckComposicion">&nbsp;&nbsp;Datos inferiores</label></a></li>
          	</div>
		  
		  </ul>
        </li>
<?php    
}
include("../../../componentes/herramientasdown.php");
?>