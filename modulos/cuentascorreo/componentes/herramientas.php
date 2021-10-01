<?php
include("../../../componentes/herramientasup.php");
if ($herramientas=="nuevo"){
	include("../../../componentes/herramientasnuevo.php");
}
if ($herramientas=="consultar"){
	include("../../../componentes/herramientasconsultar.php"); ?>
		<?php /////PERMISOS////////////////
        if (isset($_SESSION['permisos']['cuentascorreo']['eliminar'])){
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
									<option value="idcuentacorreo">ID</option>
									<option value="usuario">Usuario</option>
                </select>
                </a>
    		</li>
            <li><a><input id="asc" type="radio" name="orden" value="asc" checked="checked"><label for="asc">&nbsp;&nbsp;Ascendente</label></a></li>
            <li><a><input id="desc" type="radio" name="orden" value="desc"><label for="desc">&nbsp;&nbsp;Descendente</label></a></li>
            <li role="separator" class="divider"></li>
            <li><span class="titulo-herramientas">Mostrar / Ocultar campos</span></li>
				<div style="padding:10px; color:#666; max-height:200px !important; overflow:scroll;">
				<li><a><input id="CheckIdcuentacorreo" name="kidcuentacorreo" value="si" checked="checked" type="checkbox"/><label for="CheckIdcuentacorreo">&nbsp;&nbsp;ID</label></a></li>
			
				<li><a><input id="CheckUsuario" name="kusuario" value="si" checked="checked" type="checkbox"/><label for="CheckUsuario">&nbsp;&nbsp;Usuario</label></a></li>
			
				<li><a><input id="CheckServidorsmtp" name="kservidorsmtp" value="si" checked="checked" type="checkbox"/><label for="CheckServidorsmtp">&nbsp;&nbsp;Servidor smtp</label></a></li>
			
				<li><a><input id="CheckServidorpop" name="kservidorpop" value="si" checked="checked" type="checkbox"/><label for="CheckServidorpop">&nbsp;&nbsp;Servidor pop</label></a></li>
			
				<li><a><input id="CheckPuertosmtp" name="kpuertosmtp" value="si" checked="checked" type="checkbox"/><label for="CheckPuertosmtp">&nbsp;&nbsp;Puerto smtp</label></a></li>
			
				<li><a><input id="CheckPuertopop" name="kpuertopop" value="si" checked="checked" type="checkbox"/><label for="CheckPuertopop">&nbsp;&nbsp;Puerto pop</label></a></li>
			
				<li><a><input id="CheckAutenticacionssl" name="kautenticacionssl" value="si" checked="checked" type="checkbox"/><label for="CheckAutenticacionssl">&nbsp;&nbsp;SSL</label></a></li>
			
            	<li><a><input id="CheckComposicion" name="kcomposicion" value="si" type="checkbox" checked="checked"/><label for="CheckComposicion">&nbsp;&nbsp;Datos inferiores</label></a></li>
          	</div>
		  
		  </ul>
        </li>
<?php    
}
include("../../../componentes/herramientasdown.php");
?>