<?php
include("../../../componentes/herramientasup.php");
if ($herramientas=="nuevo"){
	include("../../../componentes/herramientasnuevo.php");
}
if ($herramientas=="consultar"){
	include("../../../componentes/herramientasconsultar.php"); ?>
		<?php /////PERMISOS////////////////
        if (isset($_SESSION['permisos']['clientes']['eliminar'])){
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
									<option value="rfc">RFC</option>
									<option value="nombre">Nombre</option>
									<option value="nic">NIC</option>
									<option value="limitecredito">Limite de crédito</option>
									<option value="diascredito">Días de crédito</option>
									<option value="saldo">Saldo</option>
                </select>
                </a>
    		</li>
            <li><a><input id="asc" type="radio" name="orden" value="asc" checked="checked"><label for="asc">&nbsp;&nbsp;Ascendente</label></a></li>
            <li><a><input id="desc" type="radio" name="orden" value="desc"><label for="desc">&nbsp;&nbsp;Descendente</label></a></li>
            <li role="separator" class="divider"></li>
            <li><span class="titulo-herramientas">Mostrar / Ocultar campos</span></li>
				<div style="padding:10px; color:#666; max-height:200px !important; overflow:scroll;">
				<li><a><input id="CheckIdcliente" name="kidcliente" value="si" checked="checked" type="checkbox"/><label for="CheckIdcliente">&nbsp;&nbsp;ID</label></a></li>
			
				<li><a><input id="CheckRfc" name="krfc" value="si" checked="checked" type="checkbox"/><label for="CheckRfc">&nbsp;&nbsp;RFC</label></a></li>
			
				<li><a><input id="CheckNombre" name="knombre" value="si" checked="checked" type="checkbox"/><label for="CheckNombre">&nbsp;&nbsp;Nombre</label></a></li>
			
				<li><a><input id="CheckNic" name="knic" value="si" checked="checked" type="checkbox"/><label for="CheckNic">&nbsp;&nbsp;NIC</label></a></li>
			
				<li><a><input id="CheckLimitecredito" name="klimitecredito" value="si" checked="checked" type="checkbox"/><label for="CheckLimitecredito">&nbsp;&nbsp;Limite de crédito</label></a></li>
			
				<li><a><input id="CheckDiascredito" name="kdiascredito" value="si" checked="checked" type="checkbox"/><label for="CheckDiascredito">&nbsp;&nbsp;Días de crédito</label></a></li>
			
				<li><a><input id="CheckSaldo" name="ksaldo" value="si" checked="checked" type="checkbox"/><label for="CheckSaldo">&nbsp;&nbsp;Saldo</label></a></li>
			
				<li><a><input id="CheckNombrecontacto" name="knombrecontacto" value="si" checked="checked" type="checkbox"/><label for="CheckNombrecontacto">&nbsp;&nbsp;Nombre de contacto</label></a></li>
			
				<li><a><input id="CheckCorreocontacto" name="kcorreocontacto" value="si" checked="checked" type="checkbox"/><label for="CheckCorreocontacto">&nbsp;&nbsp;Correo de contacto</label></a></li>
			
				<li><a><input id="CheckTelefonocontacto" name="ktelefonocontacto" value="si" checked="checked" type="checkbox"/><label for="CheckTelefonocontacto">&nbsp;&nbsp;Teléfono de contacto</label></a></li>
			
            	<li><a><input id="CheckComposicion" name="kcomposicion" value="si" type="checkbox" checked="checked"/><label for="CheckComposicion">&nbsp;&nbsp;Datos inferiores</label></a></li>
          	</div>
		  
		  </ul>
        </li>
<?php    
}
include("../../../componentes/herramientasdown.php");
?>