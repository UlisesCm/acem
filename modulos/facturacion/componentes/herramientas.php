<?php
include("../../../componentes/herramientasup.php");
if ($herramientas=="nuevo"){ ?>
<li class="btn-default border-right tipoDescripcion" title="Búsqueda por descripción"><a href="#"><i class="fa fa-search"></i> <i class="fa fa-font"></i><span class="visible-xs-inline">&nbsp;&nbsp;Busca productos por descripción</span></a></li>
    <li class="btn-default border-right tipoCB" title="Búsqueda por Código de Barras"><a href="#"><i class="fa fa-search"></i> <i class="fa fa-barcode"></i><span class="visible-xs-inline">&nbsp;&nbsp;Busca productos por código de barras</span></a></li>
<?php
	include("../../../componentes/herramientasnuevo.php");
}
if ($herramientas=="consultar"){
	include("../../../componentes/herramientasconsultar.php"); ?>
		<?php /////PERMISOS////////////////
        if (isset($_SESSION['permisos']['facturacion']['eliminar'])){
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
									<option value="idfactura">ID</option>
									<option value="foliointerno">Folio</option>
									<option value="fecha">Fecha</option>
									<option value="tipo">Tipo</option>
									<option value="clasificacion">Clasificación</option>
									<option value="emisor">Emisor</option>
									<option value="rfcemisor">RFC emisor</option>
									<option value="receptor">Receptor</option>
									<option value="rfcreceptor">RFC receptor</option>
									<option value="montototal">Monto total</option>
									<option value="estado">Estado</option>
									<option value="fechapago">Fecha de pago</option>
									<option value="formapago">Forma de pago</option>
                </select>
                </a>
    		</li>
            <li><a><input id="asc" type="radio" name="orden" value="asc" checked="checked"><label for="asc">&nbsp;&nbsp;Ascendente</label></a></li>
            <li><a><input id="desc" type="radio" name="orden" value="desc"><label for="desc">&nbsp;&nbsp;Descendente</label></a></li>
            <li role="separator" class="divider"></li>
            <li><span class="titulo-herramientas">Mostrar / Ocultar campos</span></li>
				<div style="padding:10px; color:#666; max-height:200px !important; overflow:scroll;">
				<li><a><input id="CheckIdfactura" name="kidfactura" value="si" checked="checked" type="checkbox"/><label for="CheckIdfactura">&nbsp;&nbsp;ID</label></a></li>
			
				<li><a><input id="CheckFoliointerno" name="kfoliointerno" value="si" checked="checked" type="checkbox"/><label for="CheckFoliointerno">&nbsp;&nbsp;Folio</label></a></li>
			
				<li><a><input id="CheckFecha" name="kfecha" value="si" checked="checked" type="checkbox"/><label for="CheckFecha">&nbsp;&nbsp;Fecha</label></a></li>
			
				<li><a><input id="CheckTipo" name="ktipo" value="si" checked="checked" type="checkbox"/><label for="CheckTipo">&nbsp;&nbsp;Tipo</label></a></li>
			
				<li><a><input id="CheckClasificacion" name="kclasificacion" value="si" checked="checked" type="checkbox"/><label for="CheckClasificacion">&nbsp;&nbsp;Clasificación</label></a></li>
			
				<li><a><input id="CheckEmisor" name="kemisor" value="si" checked="checked" type="checkbox"/><label for="CheckEmisor">&nbsp;&nbsp;Emisor</label></a></li>
			
				<li><a><input id="CheckRfcemisor" name="krfcemisor" value="si" checked="checked" type="checkbox"/><label for="CheckRfcemisor">&nbsp;&nbsp;RFC emisor</label></a></li>
			
				<li><a><input id="CheckReceptor" name="kreceptor" value="si" checked="checked" type="checkbox"/><label for="CheckReceptor">&nbsp;&nbsp;Receptor</label></a></li>
			
				<li><a><input id="CheckRfcreceptor" name="krfcreceptor" value="si" checked="checked" type="checkbox"/><label for="CheckRfcreceptor">&nbsp;&nbsp;RFC Receptor</label></a></li>
			
				<li><a><input id="CheckMontototal" name="kmontototal" value="si" checked="checked" type="checkbox"/><label for="CheckMontototal">&nbsp;&nbsp;Monto total</label></a></li>
			
				<li><a><input id="CheckMontopagado" name="kmontopagado" value="si" checked="checked" type="checkbox"/><label for="CheckMontopagado">&nbsp;&nbsp;Monto pagado</label></a></li>
			
				<li><a><input id="CheckEstado" name="kestado" value="si" checked="checked" type="checkbox"/><label for="CheckEstado">&nbsp;&nbsp;Estado</label></a></li>
			
				<li><a><input id="CheckFechapago" name="kfechapago" value="si" checked="checked" type="checkbox"/><label for="CheckFechapago">&nbsp;&nbsp;Fecha de pago</label></a></li>
			
				<li><a><input id="CheckFormapago" name="kformapago" value="si" checked="checked" type="checkbox"/><label for="CheckFormapago">&nbsp;&nbsp;Forma de pago</label></a></li>
			
				<li><a><input id="CheckCuenta" name="kcuenta" value="si" checked="checked" type="checkbox"/><label for="CheckCuenta">&nbsp;&nbsp;Cuenta</label></a></li>
			
				<li><a><input id="CheckFoliofiscal" name="kfoliofiscal" value="si" checked="checked" type="checkbox"/><label for="CheckFoliofiscal">&nbsp;&nbsp;Folio fiscal</label></a></li>
			
				<li><a><input id="CheckObservaciones" name="kobservaciones" value="si" checked="checked" type="checkbox"/><label for="CheckObservaciones">&nbsp;&nbsp;Observaciones</label></a></li>
			
				<li><a><input id="CheckRelaciones" name="krelaciones" value="si" checked="checked" type="checkbox"/><label for="CheckRelaciones">&nbsp;&nbsp;Relaciones</label></a></li>
			
            	<li><a><input id="CheckComposicion" name="kcomposicion" value="si" type="checkbox" checked="checked"/><label for="CheckComposicion">&nbsp;&nbsp;Datos inferiores</label></a></li>
          	</div>
		  
		  </ul>
        </li>
<?php    
}
include("../../../componentes/herramientasdown.php");
?>