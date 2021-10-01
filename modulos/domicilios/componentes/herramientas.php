<?php
include("../../../componentes/herramientasup.php");
if ($herramientas=="nuevo"){
	include("../../../componentes/herramientasnuevo.php");
}
if ($herramientas=="consultar"){
	include("../../../componentes/herramientasconsultar.php"); ?>
		<?php /////PERMISOS////////////////
        if (isset($_SESSION['permisos']['domicilios']['eliminar'])){
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
									<option value="nombrecomercial">Nombre comercial</option>
									<option value="calle">Calle</option>
									<option value="colonia">Colonia</option>
									<option value="ciudad">Ciudad</option>
									<option value="estado">Estado</option>
									<option value="idzona">Zona</option>
									<option value="idsucursal">Sucursal</option>
									<option value="idgirocomercial">Giro comercial</option>
									<option value="idempleado">Ejecutivo de cuenta</option>
                </select>
                </a>
    		</li>
            <li><a><input id="asc" type="radio" name="orden" value="asc" checked="checked"><label for="asc">&nbsp;&nbsp;Ascendente</label></a></li>
            <li><a><input id="desc" type="radio" name="orden" value="desc"><label for="desc">&nbsp;&nbsp;Descendente</label></a></li>
            <li role="separator" class="divider"></li>
            <li><span class="titulo-herramientas">Mostrar / Ocultar campos</span></li>
				<div style="padding:10px; color:#666; max-height:200px !important; overflow:scroll;">
				<li><a><input id="CheckIdcliente" name="kidcliente" value="si" checked="checked" type="checkbox"/><label for="CheckIdcliente">&nbsp;&nbsp;Cliente</label></a></li>
			
				<li><a><input id="CheckNombrecomercial" name="knombrecomercial" value="si" checked="checked" type="checkbox"/><label for="CheckNombrecomercial">&nbsp;&nbsp;Nombre comercial</label></a></li>
			
				<li><a><input id="CheckTipovialidad" name="ktipovialidad" value="si" checked="checked" type="checkbox"/><label for="CheckTipovialidad">&nbsp;&nbsp;Tipo vialidad</label></a></li>
			
				<li><a><input id="CheckCalle" name="kcalle" value="si" checked="checked" type="checkbox"/><label for="CheckCalle">&nbsp;&nbsp;Calle</label></a></li>
			
				<li><a><input id="CheckNoexterior" name="knoexterior" value="si" checked="checked" type="checkbox"/><label for="CheckNoexterior">&nbsp;&nbsp;No exterior</label></a></li>
			
				<li><a><input id="CheckNointerior" name="knointerior" value="si" checked="checked" type="checkbox"/><label for="CheckNointerior">&nbsp;&nbsp;No interior</label></a></li>
			
				<li><a><input id="CheckColonia" name="kcolonia" value="si" checked="checked" type="checkbox"/><label for="CheckColonia">&nbsp;&nbsp;Colonia</label></a></li>
			
				<li><a><input id="CheckCp" name="kcp" value="si" checked="checked" type="checkbox"/><label for="CheckCp">&nbsp;&nbsp;CP</label></a></li>
			
				<li><a><input id="CheckCiudad" name="kciudad" value="si" checked="checked" type="checkbox"/><label for="CheckCiudad">&nbsp;&nbsp;Ciudad</label></a></li>
			
				<li><a><input id="CheckEstado" name="kestado" value="si" checked="checked" type="checkbox"/><label for="CheckEstado">&nbsp;&nbsp;Estado</label></a></li>
			
				<li><a><input id="CheckIdzona" name="kidzona" value="si" checked="checked" type="checkbox"/><label for="CheckIdzona">&nbsp;&nbsp;Zona</label></a></li>
			
				<li><a><input id="CheckCoordenadas" name="kcoordenadas" value="si" checked="checked" type="checkbox"/><label for="CheckCoordenadas">&nbsp;&nbsp;Coordenadas</label></a></li>
			
				<li><a><input id="CheckReferencia" name="kreferencia" value="si" checked="checked" type="checkbox"/><label for="CheckReferencia">&nbsp;&nbsp;Referencia</label></a></li>
			
				<li><a><input id="CheckObservaciones" name="kobservaciones" value="si" checked="checked" type="checkbox"/><label for="CheckObservaciones">&nbsp;&nbsp;Observaciones</label></a></li>
			
				<li><a><input id="CheckIdsucursal" name="kidsucursal" value="si" checked="checked" type="checkbox"/><label for="CheckIdsucursal">&nbsp;&nbsp;Sucursal</label></a></li>
			
				<li><a><input id="CheckIdgirocomercial" name="kidgirocomercial" value="si" checked="checked" type="checkbox"/><label for="CheckIdgirocomercial">&nbsp;&nbsp;Giro comercial</label></a></li>
			
				<li><a><input id="CheckIdempleado" name="kidempleado" value="si" checked="checked" type="checkbox"/><label for="CheckIdempleado">&nbsp;&nbsp;Ejecutivo de cuenta</label></a></li>
			
            	<li><a><input id="CheckComposicion" name="kcomposicion" value="si" type="checkbox" checked="checked"/><label for="CheckComposicion">&nbsp;&nbsp;Datos inferiores</label></a></li>
          	</div>
		  
		  </ul>
        </li>
<?php    
}
include("../../../componentes/herramientasdown.php");
?>