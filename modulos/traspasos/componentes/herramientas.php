<?php
include("../../../componentes/herramientasup.php");
if ($herramientas=="nuevo"){
	include("../../../componentes/herramientasnuevo.php");
}
if ($herramientas=="consultar"){
	include("../../../componentes/herramientasconsultar.php"); ?>
		<?php /////PERMISOS////////////////
        if (isset($_SESSION['permisos']['traspasos']['eliminar'])){
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
									<option value="idtraspaso">ID</option>
									<option value="idmovimiento">Movimiento</option>
									<option value="idsucursalorigen">Sucursalorigen</option>
									<option value="idsucursaldestino">Sucursaldestino</option>
									<option value="fechasalida">Fecha Salida</option>
									<option value="fechaentrada">Fecha Entrada</option>
									<option value="estado">Estado</option>
									<option value="numerocomprobante">Número Comprobante</option>
									<option value="idusuariosalida">Usuariosalida</option>
									<option value="idusuarioentrada">Usuarioentrada</option>
                </select>
                </a>
    		</li>
            <li><a><input id="asc" type="radio" name="orden" value="asc" checked="checked"><label for="asc">&nbsp;&nbsp;Ascendente</label></a></li>
            <li><a><input id="desc" type="radio" name="orden" value="desc"><label for="desc">&nbsp;&nbsp;Descendente</label></a></li>
            <li role="separator" class="divider"></li>
            <li><span class="titulo-herramientas">Mostrar / Ocultar campos</span></li>
				<div style="padding:10px; color:#666; max-height:200px !important; overflow:scroll;">
				<li><a><input id="CheckIdtraspaso" name="kidtraspaso" value="si" checked="checked" type="checkbox"/><label for="CheckIdtraspaso">&nbsp;&nbsp;ID</label></a></li>
			
				<li><a><input id="CheckIdmovimiento" name="kidmovimiento" value="si" checked="checked" type="checkbox"/><label for="CheckIdmovimiento">&nbsp;&nbsp;Movimiento</label></a></li>
			
				<li><a><input id="CheckIdsucursalorigen" name="kidsucursalorigen" value="si" checked="checked" type="checkbox"/><label for="CheckIdsucursalorigen">&nbsp;&nbsp;Sucursalorigen</label></a></li>
			
				<li><a><input id="CheckIdsucursaldestino" name="kidsucursaldestino" value="si" checked="checked" type="checkbox"/><label for="CheckIdsucursaldestino">&nbsp;&nbsp;Sucursaldestino</label></a></li>
			
				<li><a><input id="CheckFechasalida" name="kfechasalida" value="si" checked="checked" type="checkbox"/><label for="CheckFechasalida">&nbsp;&nbsp;Fecha Salida</label></a></li>
			
				<li><a><input id="CheckFechaentrada" name="kfechaentrada" value="si" checked="checked" type="checkbox"/><label for="CheckFechaentrada">&nbsp;&nbsp;Fecha Entrada</label></a></li>
			
				<li><a><input id="CheckEstado" name="kestado" value="si" checked="checked" type="checkbox"/><label for="CheckEstado">&nbsp;&nbsp;Estado</label></a></li>
			
				<li><a><input id="CheckNumerocomprobante" name="knumerocomprobante" value="si" checked="checked" type="checkbox"/><label for="CheckNumerocomprobante">&nbsp;&nbsp;Número Comprobante</label></a></li>
			
				<li><a><input id="CheckIdusuariosalida" name="kidusuariosalida" value="si" checked="checked" type="checkbox"/><label for="CheckIdusuariosalida">&nbsp;&nbsp;Usuariosalida</label></a></li>
			
				<li><a><input id="CheckIdusuarioentrada" name="kidusuarioentrada" value="si" checked="checked" type="checkbox"/><label for="CheckIdusuarioentrada">&nbsp;&nbsp;Usuarioentrada</label></a></li>
			
            	<li><a><input id="CheckComposicion" name="kcomposicion" value="si" type="checkbox" checked="checked"/><label for="CheckComposicion">&nbsp;&nbsp;Datos inferiores</label></a></li>
          	</div>
		  
		  </ul>
        </li>
<?php    
}
include("../../../componentes/herramientasdown.php");
?>