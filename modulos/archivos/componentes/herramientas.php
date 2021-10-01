<?php
include("../../../componentes/herramientasup.php");
if ($herramientas=="nuevo"){
	include("../../../componentes/herramientasnuevo.php");
}
if ($herramientas=="consultar"){
	include("../../../componentes/herramientasconsultar.php"); ?>
		<?php /////PERMISOS////////////////
        if (isset($_SESSION['permisos']['archivos']['eliminar'])){
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
									<option value="idarchivo">ID</option>
									<option value="pdf">Pdf</option>
									<option value="xml">Xml</option>
									<option value="fechamodificacion">Fecha Modificación</option>
									<option value="tablareferencia">Tabla Referencia</option>
									<option value="idreferencia">Referencia</option>
									<option value="serie">Serie</option>
									<option value="folio">Folio</option>
									<option value="tipo">Tipo</option>
									<option value="fechatimbre">Fecha Timbre</option>
									<option value="emisor">Emisor</option>
									<option value="rfcemisor">RFC Emisor</option>
									<option value="receptor">Receptor</option>
									<option value="rfcreceptor">RFC Receptor</option>
									<option value="monto">Monto</option>
									<option value="uuid">Uuid</option>
                </select>
                </a>
    		</li>
            <li><a><input id="asc" type="radio" name="orden" value="asc" checked="checked"><label for="asc">&nbsp;&nbsp;Ascendente</label></a></li>
            <li><a><input id="desc" type="radio" name="orden" value="desc"><label for="desc">&nbsp;&nbsp;Descendente</label></a></li>
            <li role="separator" class="divider"></li>
            <li><span class="titulo-herramientas">Mostrar / Ocultar campos</span></li>
				<div style="padding:10px; color:#666; max-height:200px !important; overflow:scroll;">
				<li><a><input id="CheckIdarchivo" name="kidarchivo" value="si" checked="checked" type="checkbox"/><label for="CheckIdarchivo">&nbsp;&nbsp;ID</label></a></li>
			
				<li><a><input id="CheckPdf" name="kpdf" value="si" checked="checked" type="checkbox"/><label for="CheckPdf">&nbsp;&nbsp;Pdf</label></a></li>
			
				<li><a><input id="CheckXml" name="kxml" value="si" checked="checked" type="checkbox"/><label for="CheckXml">&nbsp;&nbsp;Xml</label></a></li>
			
				<li><a><input id="CheckFechamodificacion" name="kfechamodificacion" value="si" checked="checked" type="checkbox"/><label for="CheckFechamodificacion">&nbsp;&nbsp;Fecha Modificación</label></a></li>
			
				<li><a><input id="CheckTablareferencia" name="ktablareferencia" value="si" checked="checked" type="checkbox"/><label for="CheckTablareferencia">&nbsp;&nbsp;Tabla Referencia</label></a></li>
			
				<li><a><input id="CheckIdreferencia" name="kidreferencia" value="si" checked="checked" type="checkbox"/><label for="CheckIdreferencia">&nbsp;&nbsp;Referencia</label></a></li>
			
				<li><a><input id="CheckSerie" name="kserie" value="si" checked="checked" type="checkbox"/><label for="CheckSerie">&nbsp;&nbsp;Serie</label></a></li>
			
				<li><a><input id="CheckFolio" name="kfolio" value="si" checked="checked" type="checkbox"/><label for="CheckFolio">&nbsp;&nbsp;Folio</label></a></li>
			
				<li><a><input id="CheckTipo" name="ktipo" value="si" checked="checked" type="checkbox"/><label for="CheckTipo">&nbsp;&nbsp;Tipo</label></a></li>
			
				<li><a><input id="CheckFechatimbre" name="kfechatimbre" value="si" checked="checked" type="checkbox"/><label for="CheckFechatimbre">&nbsp;&nbsp;Fecha Timbre</label></a></li>
			
				<li><a><input id="CheckEmisor" name="kemisor" value="si" checked="checked" type="checkbox"/><label for="CheckEmisor">&nbsp;&nbsp;Emisor</label></a></li>
			
				<li><a><input id="CheckRfcemisor" name="krfcemisor" value="si" checked="checked" type="checkbox"/><label for="CheckRfcemisor">&nbsp;&nbsp;RFC Emisor</label></a></li>
			
				<li><a><input id="CheckReceptor" name="kreceptor" value="si" checked="checked" type="checkbox"/><label for="CheckReceptor">&nbsp;&nbsp;Receptor</label></a></li>
			
				<li><a><input id="CheckRfcreceptor" name="krfcreceptor" value="si" checked="checked" type="checkbox"/><label for="CheckRfcreceptor">&nbsp;&nbsp;RFC Receptor</label></a></li>
			
				<li><a><input id="CheckMonto" name="kmonto" value="si" checked="checked" type="checkbox"/><label for="CheckMonto">&nbsp;&nbsp;Monto</label></a></li>
			
				<li><a><input id="CheckUuid" name="kuuid" value="si" checked="checked" type="checkbox"/><label for="CheckUuid">&nbsp;&nbsp;Uuid</label></a></li>
			
            	<li><a><input id="CheckComposicion" name="kcomposicion" value="si" type="checkbox" checked="checked"/><label for="CheckComposicion">&nbsp;&nbsp;Datos inferiores</label></a></li>
          	</div>
		  
		  </ul>
        </li>
<?php    
}
include("../../../componentes/herramientasdown.php");
?>