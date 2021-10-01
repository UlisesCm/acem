<?php
include("../../../componentes/herramientasup.php");
if ($herramientas=="nuevo"){
	include("../../../componentes/herramientasnuevo.php");
}
if ($herramientas=="consultar"){
	?>
    <li class="btn-default border-right" title="Exportar Consulta a Excel"><a href="#" class="botonExportar"><i class="fa fa-file-excel-o"></i><span class="visible-xs-inline">&nbsp;&nbsp;Exportar a Excel</span></a></li>
	<?php
	include("../../../componentes/herramientasconsultar.php"); ?>
		<?php /////PERMISOS////////////////
        if (isset($_SESSION['permisos']['productos']['eliminar'])){
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
									<option value="idproducto">ID</option>
									<option value="idfamilia">Familia</option>
									<option value="nombre">Nombre</option>
									<option value="codigo">Código</option>
									<option value="autoclasificar">Autoclasificar</option>
									<option value="clasificacion">Clasificación</option>
									<option value="idmodeloimpuestos">Modelo Impuestos</option>
									<option value="idcategoria">Categoria</option>
									<option value="idunidad">Unidad</option>
									<option value="marca">Marca</option>
									<option value="pesoteorico">Peso teórico</option>
									<option value="espesor">Espesor</option>
									<option value="ancho">Ancho</option>
									<option value="color">Color</option>
									<option value="diametro">Diametro</option>
									<option value="tipo">Tipo</option>
									<option value="modelo">Modelo A</option>
									<option value="modelo2">Modelo B</option>
									<option value="lado">Lado</option>
									<option value="alto">Alto</option>
									<option value="largo">Largo</option>
									<option value="aplicacion">Aplicación</option>
									<option value="clave">Clave</option>
									<option value="descripcion">Descripción</option>
									<option value="variacionpermitidaencosto">Variación de costo</option>
									<option value="costo">Costo</option>
                </select>
                </a>
    		</li>
            <li><a><input id="asc" type="radio" name="orden" value="asc" checked="checked"><label for="asc">&nbsp;&nbsp;Ascendente</label></a></li>
            <li><a><input id="desc" type="radio" name="orden" value="desc"><label for="desc">&nbsp;&nbsp;Descendente</label></a></li>
            <li role="separator" class="divider"></li>
            <li><span class="titulo-herramientas">Mostrar / Ocultar campos</span></li>
				<div style="padding:10px; color:#666; max-height:200px !important; overflow:scroll;">
				<li><a><input id="CheckIdproducto" name="kidproducto" value="si" checked="checked" type="checkbox"/><label for="CheckIdproducto">&nbsp;&nbsp;ID</label></a></li>
			
				<li><a><input id="CheckIdfamilia" name="kidfamilia" value="si" checked="checked" type="checkbox"/><label for="CheckIdfamilia">&nbsp;&nbsp;Familia</label></a></li>
			
				<li><a><input id="CheckNombre" name="knombre" value="si" checked="checked" type="checkbox"/><label for="CheckNombre">&nbsp;&nbsp;Nombre</label></a></li>
			
				<li><a><input id="CheckCodigo" name="kcodigo" value="si" checked="checked" type="checkbox"/><label for="CheckCodigo">&nbsp;&nbsp;Código</label></a></li>
			
				<li><a><input id="CheckAutoclasificar" name="kautoclasificar" value="si" checked="checked" type="checkbox"/><label for="CheckAutoclasificar">&nbsp;&nbsp;Autoclasificar</label></a></li>
			
				<li><a><input id="CheckClasificacion" name="kclasificacion" value="si" checked="checked" type="checkbox"/><label for="CheckClasificacion">&nbsp;&nbsp;Clasificación</label></a></li>
			
				<li><a><input id="CheckIdmodeloimpuestos" name="kidmodeloimpuestos" value="si" checked="checked" type="checkbox"/><label for="CheckIdmodeloimpuestos">&nbsp;&nbsp;Modelo Impuestos</label></a></li>
			
				<li><a><input id="CheckIdcategoria" name="kidcategoria" value="si" checked="checked" type="checkbox"/><label for="CheckIdcategoria">&nbsp;&nbsp;Categoria</label></a></li>
			
				<li><a><input id="CheckIdunidad" name="kidunidad" value="si" checked="checked" type="checkbox"/><label for="CheckIdunidad">&nbsp;&nbsp;Unidad</label></a></li>
			
				<li><a><input id="CheckMarca" name="kmarca" value="si" checked="checked" type="checkbox"/><label for="CheckMarca">&nbsp;&nbsp;Marca</label></a></li>
			
				<li><a><input id="CheckPesoteorico" name="kpesoteorico" value="si" checked="checked" type="checkbox"/><label for="CheckPesoteorico">&nbsp;&nbsp;Peso teórico</label></a></li>
			
				<li><a><input id="CheckEspesor" name="kespesor" value="si" checked="checked" type="checkbox"/><label for="CheckEspesor">&nbsp;&nbsp;Espesor</label></a></li>
			
				<li><a><input id="CheckAncho" name="kancho" value="si" checked="checked" type="checkbox"/><label for="CheckAncho">&nbsp;&nbsp;Ancho</label></a></li>
			
				<li><a><input id="CheckColor" name="kcolor" value="si" checked="checked" type="checkbox"/><label for="CheckColor">&nbsp;&nbsp;Color</label></a></li>
			
				<li><a><input id="CheckDiametro" name="kdiametro" value="si" checked="checked" type="checkbox"/><label for="CheckDiametro">&nbsp;&nbsp;Diametro</label></a></li>
			
				<li><a><input id="CheckTipo" name="ktipo" value="si" checked="checked" type="checkbox"/><label for="CheckTipo">&nbsp;&nbsp;Tipo</label></a></li>
			
				<li><a><input id="CheckModelo" name="kmodelo" value="si" checked="checked" type="checkbox"/><label for="CheckModelo">&nbsp;&nbsp;Modelo A</label></a></li>
			
				<li><a><input id="CheckModelo2" name="kmodelo2" value="si" checked="checked" type="checkbox"/><label for="CheckModelo2">&nbsp;&nbsp;Modelo B</label></a></li>
			
				<li><a><input id="CheckLado" name="klado" value="si" checked="checked" type="checkbox"/><label for="CheckLado">&nbsp;&nbsp;Lado</label></a></li>
			
				<li><a><input id="CheckAlto" name="kalto" value="si" checked="checked" type="checkbox"/><label for="CheckAlto">&nbsp;&nbsp;Alto</label></a></li>
			
				<li><a><input id="CheckLargo" name="klargo" value="si" checked="checked" type="checkbox"/><label for="CheckLargo">&nbsp;&nbsp;Largo</label></a></li>
			
				<li><a><input id="CheckAplicacion" name="kaplicacion" value="si" checked="checked" type="checkbox"/><label for="CheckAplicacion">&nbsp;&nbsp;Aplicación</label></a></li>
			
				<li><a><input id="CheckClave" name="kclave" value="si" checked="checked" type="checkbox"/><label for="CheckClave">&nbsp;&nbsp;Clave</label></a></li>
			
				<li><a><input id="CheckDescripcion" name="kdescripcion" value="si" checked="checked" type="checkbox"/><label for="CheckDescripcion">&nbsp;&nbsp;Descripción</label></a></li>
			
				<li><a><input id="CheckVariacionpermitidaencosto" name="kvariacionpermitidaencosto" value="si" checked="checked" type="checkbox"/><label for="CheckVariacionpermitidaencosto">&nbsp;&nbsp;Variación de costo</label></a></li>
			
				<li><a><input id="CheckCosto" name="kcosto" value="si" checked="checked" type="checkbox"/><label for="CheckCosto">&nbsp;&nbsp;Costo</label></a></li>
			
            	<li><a><input id="CheckComposicion" name="kcomposicion" value="si" type="checkbox" checked="checked"/><label for="CheckComposicion">&nbsp;&nbsp;Datos inferiores</label></a></li>
          	</div>
		  
		  </ul>
        </li>
<?php    
}
include("../../../componentes/herramientasdown.php");
?>