<?php
include("../../../componentes/herramientasup.php");
if ($herramientas=="nuevo"){
	include("../../../componentes/herramientasnuevo.php");
}
if ($herramientas=="consultar"){
	include("../../../componentes/herramientasconsultar.php"); ?>
		<?php /////PERMISOS////////////////
        if (isset($_SESSION['permisos']['vehiculos']['eliminar'])){
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
									<option value="tipo">Tipo</option>
									<option value="marca">Marca</option>
									<option value="submarca">Submarca</option>
									<option value="color">Color</option>
									<option value="anio">Año</option>
									<option value="asignado">Asignado</option>
									<option value="estado">Estado</option>
									<option value="idsucursal">Sucursal</option>
                </select>
                </a>
    		</li>
            <li><a><input id="asc" type="radio" name="orden" value="asc" checked="checked"><label for="asc">&nbsp;&nbsp;Ascendente</label></a></li>
            <li><a><input id="desc" type="radio" name="orden" value="desc"><label for="desc">&nbsp;&nbsp;Descendente</label></a></li>
            <li role="separator" class="divider"></li>
            <li><span class="titulo-herramientas">Mostrar / Ocultar campos</span></li>
				<div style="padding:10px; color:#666; max-height:200px !important; overflow:scroll;">
				<li><a><input id="CheckTipo" name="ktipo" value="si" checked="checked" type="checkbox"/><label for="CheckTipo">&nbsp;&nbsp;Tipo</label></a></li>
			
				<li><a><input id="CheckMarca" name="kmarca" value="si" checked="checked" type="checkbox"/><label for="CheckMarca">&nbsp;&nbsp;Marca</label></a></li>
			
				<li><a><input id="CheckSubmarca" name="ksubmarca" value="si" checked="checked" type="checkbox"/><label for="CheckSubmarca">&nbsp;&nbsp;Submarca</label></a></li>
			
				<li><a><input id="CheckColor" name="kcolor" value="si" checked="checked" type="checkbox"/><label for="CheckColor">&nbsp;&nbsp;Color</label></a></li>
			
				<li><a><input id="CheckPlaca" name="kplaca" value="si" checked="checked" type="checkbox"/><label for="CheckPlaca">&nbsp;&nbsp;Placa</label></a></li>
			
				<li><a><input id="CheckCapacidaddecarga" name="kcapacidaddecarga" value="si" checked="checked" type="checkbox"/><label for="CheckCapacidaddecarga">&nbsp;&nbsp;Capacidad de carga</label></a></li>
			
				<li><a><input id="CheckAnio" name="kanio" value="si" checked="checked" type="checkbox"/><label for="CheckAnio">&nbsp;&nbsp;Año</label></a></li>
			
				<li><a><input id="CheckKminicial" name="kkminicial" value="si" checked="checked" type="checkbox"/><label for="CheckKminicial">&nbsp;&nbsp;Kilometraje inicial</label></a></li>
			
				<li><a><input id="CheckKmactual" name="kkmactual" value="si" checked="checked" type="checkbox"/><label for="CheckKmactual">&nbsp;&nbsp;Kilometraje actual</label></a></li>
			
				<li><a><input id="CheckVigenciaseguro" name="kvigenciaseguro" value="si" checked="checked" type="checkbox"/><label for="CheckVigenciaseguro">&nbsp;&nbsp;Vigencia del seguro</label></a></li>
			
				<li><a><input id="CheckKmultimomantenimiento" name="kkmultimomantenimiento" value="si" checked="checked" type="checkbox"/><label for="CheckKmultimomantenimiento">&nbsp;&nbsp;Kilometraje del último mantenimiento</label></a></li>
			
				<li><a><input id="CheckFechaultimomantenimiento" name="kfechaultimomantenimiento" value="si" checked="checked" type="checkbox"/><label for="CheckFechaultimomantenimiento">&nbsp;&nbsp;Fecha del último mantenimiento</label></a></li>
			
				<li><a><input id="CheckTipodecombustible" name="ktipodecombustible" value="si" checked="checked" type="checkbox"/><label for="CheckTipodecombustible">&nbsp;&nbsp;Tipo de combustible</label></a></li>
			
				<li><a><input id="CheckFrecuenciamantenimientokm" name="kfrecuenciamantenimientokm" value="si" checked="checked" type="checkbox"/><label for="CheckFrecuenciamantenimientokm">&nbsp;&nbsp;Frecuencia de mantenimiento en km</label></a></li>
			
				<li><a><input id="CheckFrecuenciamantenimientofecha" name="kfrecuenciamantenimientofecha" value="si" checked="checked" type="checkbox"/><label for="CheckFrecuenciamantenimientofecha">&nbsp;&nbsp;Frecuencia de mantenimiento en meses</label></a></li>
			
				<li><a><input id="CheckAsignado" name="kasignado" value="si" checked="checked" type="checkbox"/><label for="CheckAsignado">&nbsp;&nbsp;Asignado</label></a></li>
			
				<li><a><input id="CheckEstado" name="kestado" value="si" checked="checked" type="checkbox"/><label for="CheckEstado">&nbsp;&nbsp;Estado</label></a></li>
			
				<li><a><input id="CheckIdempleado" name="kidempleado" value="si" checked="checked" type="checkbox"/><label for="CheckIdempleado">&nbsp;&nbsp;Empleado</label></a></li>
			
				<li><a><input id="CheckIdsucursal" name="kidsucursal" value="si" checked="checked" type="checkbox"/><label for="CheckIdsucursal">&nbsp;&nbsp;Sucursal</label></a></li>
			
            	<li><a><input id="CheckComposicion" name="kcomposicion" value="si" type="checkbox" checked="checked"/><label for="CheckComposicion">&nbsp;&nbsp;Datos inferiores</label></a></li>
          	</div>
		  
		  </ul>
        </li>
<?php    
}
include("../../../componentes/herramientasdown.php");
?>