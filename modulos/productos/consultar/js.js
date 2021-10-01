// JavaScript Document
var orden, campoOrden, cantidadamostrar, paginacion;
orden="DESC";
campoOrden="idproducto";
iniciar="0";
cantidadamostrar="20";
paginacion=0;

function abrirModal(id){
	$("#modal").modal();
	$.ajax({
		url: 'consultardetalles.php',
		type: "POST",
		data: "submit=&id="+id, //Pasamos los datos en forma de array
		success: function(mensaje){
			$("#contenidoModal").html(mensaje);
		}
	});
	return false;
}

function agregarStock(idproducto,idsucursal) {
	var encoded = "¿Desea agregar un nuevo registro de stock para esta sucursal?";
	var decoded = $("<div/>").html(encoded).text();
    var pregunta = confirm(decoded);
	if (pregunta){
		agregar_stock(idproducto,idsucursal);
	}
}

function eliminarStock(id,idproducto) {
	var encoded = "¿Desea borrar el registro de stock?";
	var decoded = $("<div/>").html(encoded).text();
    var pregunta = confirm(decoded);
	if (pregunta){
		eliminar_stock(id,idproducto);
	}
}

function seleccionarTodo(){
	if ($("#seleccionarTodo").prop("checked")==true){
		$(".checkEliminar").prop("checked", "checked");
	}else{
		$(".checkEliminar").prop("checked", "");
	}   
}
function eliminarIndividual(id) {
	var encoded = "¿Desea borrar el registro?";
	var decoded = $("<div/>").html(encoded).text();
    var pregunta = confirm(decoded);
	if (pregunta){
		eliminar_individual(id);
	}
}
function restaurarIndividual(id) {
	var encoded = "¿Desea restaurar el registro?";
	var decoded = $("<div/>").html(encoded).text();
    var pregunta = confirm(decoded);
	if (pregunta){
		restaurar_individual(id);
	}
}
function comprobarReglas(){
	$(".checksEliminar").hide();
	//Identificar el campo de ordenamiento
	if(recuperarCookie("campoOrdenProducto")!=null){
		campoOrden=recuperarCookie("campoOrdenProducto");
		 $("#campoOrden option[value="+campoOrden+"]").attr("selected",true);
	}else{
		campoOrden="idproducto";
		$("#campoOrden option[value="+campoOrden+"]").attr("selected",true);
	}
	
	//Identificar el numero de elementos para mostrar
	if(recuperarCookie("cantidadamostrarProducto")!=null){
		cantidadamostrar=recuperarCookie("cantidadamostrarProducto");
		 $("#cantidadamostrar option[value="+cantidadamostrar+"]").attr("selected",true);
	}else{
		cantidadamostrar="20";
		$("#cantidadamostrar option[value="+cantidadamostrar+"]").attr("selected",true);
		
	}
	
	//Identificar el tipo de orden
	if(recuperarCookie("ordenProducto")=="asc"){
		orden="ASC"
		$('#asc').attr('checked', true);
		$('#desc').attr('checked', false);
	}else if(recuperarCookie("ordenProducto")=="desc"){
		orden="DESC"
		$('#asc').attr('checked', false);
		$('#desc').attr('checked', true);
	}else{
		orden="DESC"
		$('#asc').attr('checked', false);
		$('#desc').attr('checked', true);
	}
	//Mostrar u Ocultar Idproducto
	if(recuperarCookie("mostrarIdproductoProducto")=="si"){
		$('.Cidproducto').show();
		$('#CheckIdproducto').attr('checked', true);
	}else if(recuperarCookie("mostrarIdproductoProducto")=="no"){
		$('.Cidproducto').hide();
		$('#CheckIdproducto').attr('checked', false);
	}
	//Mostrar u Ocultar Idfamilia
	if(recuperarCookie("mostrarIdfamiliaProducto")=="si"){
		$('.Cidfamilia').show();
		$('#CheckIdfamilia').attr('checked', true);
	}else if(recuperarCookie("mostrarIdfamiliaProducto")=="no"){
		$('.Cidfamilia').hide();
		$('#CheckIdfamilia').attr('checked', false);
	}
	//Mostrar u Ocultar Nombre
	if(recuperarCookie("mostrarNombreProducto")=="si"){
		$('.Cnombre').show();
		$('#CheckNombre').attr('checked', true);
	}else if(recuperarCookie("mostrarNombreProducto")=="no"){
		$('.Cnombre').hide();
		$('#CheckNombre').attr('checked', false);
	}
	//Mostrar u Ocultar Codigo
	if(recuperarCookie("mostrarCodigoProducto")=="si"){
		$('.Ccodigo').show();
		$('#CheckCodigo').attr('checked', true);
	}else if(recuperarCookie("mostrarCodigoProducto")=="no"){
		$('.Ccodigo').hide();
		$('#CheckCodigo').attr('checked', false);
	}
	//Mostrar u Ocultar Autoclasificar
	if(recuperarCookie("mostrarAutoclasificarProducto")=="si"){
		$('.Cautoclasificar').show();
		$('#CheckAutoclasificar').attr('checked', true);
	}else if(recuperarCookie("mostrarAutoclasificarProducto")=="no"){
		$('.Cautoclasificar').hide();
		$('#CheckAutoclasificar').attr('checked', false);
	}
	//Mostrar u Ocultar Clasificacion
	if(recuperarCookie("mostrarClasificacionProducto")=="si"){
		$('.Cclasificacion').show();
		$('#CheckClasificacion').attr('checked', true);
	}else if(recuperarCookie("mostrarClasificacionProducto")=="no"){
		$('.Cclasificacion').hide();
		$('#CheckClasificacion').attr('checked', false);
	}
	//Mostrar u Ocultar Idmodeloimpuestos
	if(recuperarCookie("mostrarIdmodeloimpuestosProducto")=="si"){
		$('.Cidmodeloimpuestos').show();
		$('#CheckIdmodeloimpuestos').attr('checked', true);
	}else if(recuperarCookie("mostrarIdmodeloimpuestosProducto")=="no"){
		$('.Cidmodeloimpuestos').hide();
		$('#CheckIdmodeloimpuestos').attr('checked', false);
	}
	//Mostrar u Ocultar Idcategoria
	if(recuperarCookie("mostrarIdcategoriaProducto")=="si"){
		$('.Cidcategoria').show();
		$('#CheckIdcategoria').attr('checked', true);
	}else if(recuperarCookie("mostrarIdcategoriaProducto")=="no"){
		$('.Cidcategoria').hide();
		$('#CheckIdcategoria').attr('checked', false);
	}
	//Mostrar u Ocultar Idunidad
	if(recuperarCookie("mostrarIdunidadProducto")=="si"){
		$('.Cidunidad').show();
		$('#CheckIdunidad').attr('checked', true);
	}else if(recuperarCookie("mostrarIdunidadProducto")=="no"){
		$('.Cidunidad').hide();
		$('#CheckIdunidad').attr('checked', false);
	}
	//Mostrar u Ocultar Marca
	if(recuperarCookie("mostrarMarcaProducto")=="si"){
		$('.Cmarca').show();
		$('#CheckMarca').attr('checked', true);
	}else if(recuperarCookie("mostrarMarcaProducto")=="no"){
		$('.Cmarca').hide();
		$('#CheckMarca').attr('checked', false);
	}
	//Mostrar u Ocultar Pesoteorico
	if(recuperarCookie("mostrarPesoteoricoProducto")=="si"){
		$('.Cpesoteorico').show();
		$('#CheckPesoteorico').attr('checked', true);
	}else if(recuperarCookie("mostrarPesoteoricoProducto")=="no"){
		$('.Cpesoteorico').hide();
		$('#CheckPesoteorico').attr('checked', false);
	}
	//Mostrar u Ocultar Espesor
	if(recuperarCookie("mostrarEspesorProducto")=="si"){
		$('.Cespesor').show();
		$('#CheckEspesor').attr('checked', true);
	}else if(recuperarCookie("mostrarEspesorProducto")=="no"){
		$('.Cespesor').hide();
		$('#CheckEspesor').attr('checked', false);
	}
	//Mostrar u Ocultar Ancho
	if(recuperarCookie("mostrarAnchoProducto")=="si"){
		$('.Cancho').show();
		$('#CheckAncho').attr('checked', true);
	}else if(recuperarCookie("mostrarAnchoProducto")=="no"){
		$('.Cancho').hide();
		$('#CheckAncho').attr('checked', false);
	}
	//Mostrar u Ocultar Color
	if(recuperarCookie("mostrarColorProducto")=="si"){
		$('.Ccolor').show();
		$('#CheckColor').attr('checked', true);
	}else if(recuperarCookie("mostrarColorProducto")=="no"){
		$('.Ccolor').hide();
		$('#CheckColor').attr('checked', false);
	}
	//Mostrar u Ocultar Diametro
	if(recuperarCookie("mostrarDiametroProducto")=="si"){
		$('.Cdiametro').show();
		$('#CheckDiametro').attr('checked', true);
	}else if(recuperarCookie("mostrarDiametroProducto")=="no"){
		$('.Cdiametro').hide();
		$('#CheckDiametro').attr('checked', false);
	}
	//Mostrar u Ocultar Tipo
	if(recuperarCookie("mostrarTipoProducto")=="si"){
		$('.Ctipo').show();
		$('#CheckTipo').attr('checked', true);
	}else if(recuperarCookie("mostrarTipoProducto")=="no"){
		$('.Ctipo').hide();
		$('#CheckTipo').attr('checked', false);
	}
	//Mostrar u Ocultar Modelo
	if(recuperarCookie("mostrarModeloProducto")=="si"){
		$('.Cmodelo').show();
		$('#CheckModelo').attr('checked', true);
	}else if(recuperarCookie("mostrarModeloProducto")=="no"){
		$('.Cmodelo').hide();
		$('#CheckModelo').attr('checked', false);
	}
	//Mostrar u Ocultar Modelo2
	if(recuperarCookie("mostrarModelo2Producto")=="si"){
		$('.Cmodelo2').show();
		$('#CheckModelo2').attr('checked', true);
	}else if(recuperarCookie("mostrarModelo2Producto")=="no"){
		$('.Cmodelo2').hide();
		$('#CheckModelo2').attr('checked', false);
	}
	//Mostrar u Ocultar Lado
	if(recuperarCookie("mostrarLadoProducto")=="si"){
		$('.Clado').show();
		$('#CheckLado').attr('checked', true);
	}else if(recuperarCookie("mostrarLadoProducto")=="no"){
		$('.Clado').hide();
		$('#CheckLado').attr('checked', false);
	}
	//Mostrar u Ocultar Alto
	if(recuperarCookie("mostrarAltoProducto")=="si"){
		$('.Calto').show();
		$('#CheckAlto').attr('checked', true);
	}else if(recuperarCookie("mostrarAltoProducto")=="no"){
		$('.Calto').hide();
		$('#CheckAlto').attr('checked', false);
	}
	//Mostrar u Ocultar Largo
	if(recuperarCookie("mostrarLargoProducto")=="si"){
		$('.Clargo').show();
		$('#CheckLargo').attr('checked', true);
	}else if(recuperarCookie("mostrarLargoProducto")=="no"){
		$('.Clargo').hide();
		$('#CheckLargo').attr('checked', false);
	}
	//Mostrar u Ocultar Aplicacion
	if(recuperarCookie("mostrarAplicacionProducto")=="si"){
		$('.Caplicacion').show();
		$('#CheckAplicacion').attr('checked', true);
	}else if(recuperarCookie("mostrarAplicacionProducto")=="no"){
		$('.Caplicacion').hide();
		$('#CheckAplicacion').attr('checked', false);
	}
	//Mostrar u Ocultar Clave
	if(recuperarCookie("mostrarClaveProducto")=="si"){
		$('.Cclave').show();
		$('#CheckClave').attr('checked', true);
	}else if(recuperarCookie("mostrarClaveProducto")=="no"){
		$('.Cclave').hide();
		$('#CheckClave').attr('checked', false);
	}
	//Mostrar u Ocultar Descripcion
	if(recuperarCookie("mostrarDescripcionProducto")=="si"){
		$('.Cdescripcion').show();
		$('#CheckDescripcion').attr('checked', true);
	}else if(recuperarCookie("mostrarDescripcionProducto")=="no"){
		$('.Cdescripcion').hide();
		$('#CheckDescripcion').attr('checked', false);
	}
	//Mostrar u Ocultar Variacionpermitidaencosto
	if(recuperarCookie("mostrarVariacionpermitidaencostoProducto")=="si"){
		$('.Cvariacionpermitidaencosto').show();
		$('#CheckVariacionpermitidaencosto').attr('checked', true);
	}else if(recuperarCookie("mostrarVariacionpermitidaencostoProducto")=="no"){
		$('.Cvariacionpermitidaencosto').hide();
		$('#CheckVariacionpermitidaencosto').attr('checked', false);
	}
	//Mostrar u Ocultar Costo
	if(recuperarCookie("mostrarCostoProducto")=="si"){
		$('.Ccosto').show();
		$('#CheckCosto').attr('checked', true);
	}else if(recuperarCookie("mostrarCostoProducto")=="no"){
		$('.Ccosto').hide();
		$('#CheckCosto').attr('checked', false);
	}
	//Mostrar u Ocultar Composicion
	if(recuperarCookie("mostrarComposicionProducto")=="si"){
		$('.Ccomposicion').show();
		$('#CheckComposicion').attr('checked', true);
	}
	if(recuperarCookie("mostrarComposicionProducto")=="no"){
		$('.Ccomposicion').hide();
		$('#CheckComposicion').attr('checked', false);
	}
	
	//Elegir el tipo de vista
	if(recuperarCookie("tipoVistaProducto")=="tabla"){
		$('.tipoLista').show();
		$('.tipoTabla').hide();
		tipoVista="tabla";
	}else{
		$('.tipoLista').hide();
		$('.tipoTabla').show();
		tipoVista="lista";
	}
	$( ".tipoTabla" ).click(function() {
    	crearCookie("tipoVistaProducto", "tabla");
		tipoVista="tabla";
		$(".tipoLista").show();
		$(".tipoTabla").hide();
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$( ".tipoLista" ).click(function() {
    	crearCookie("tipoVistaProducto", "lista");
		tipoVista="lista";
		$(".tipoLista").hide();
		$(".tipoTabla").show();
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});

}

	
$(document).ready(function() {
	$("#cajaBuscar").focus();
	comprobarReglas();
	llenarSelect("cmarca","marca");
	llenarSelect("cespesor","espesor");
	llenarSelect("cancho","ancho");
	llenarSelect("cdiametro","diametro");
	llenarSelect("calto","alto");
	llenarSelect("clargo","largo");
	llenarSelect("ccolor","color");
	llenarSelect("caplicacion","aplicacion");
	llenarSelect("ctipo","tipo");
	llenarArbol("");
	load_tablas(campoOrden,orden,cantidadamostrar,paginacion,busqueda,tipoVista);
	
	$(".botonEliminar").click(function() {
		$("#barraPaginacion").hide();
		$(".cajaBorrar").show();
		$(".herramientasIndividuales").hide();
		$(".checksEliminar").show();
	});
	
	$(".botonCancelarBorrar").click(function() {
		$(".herramientasIndividuales").show();
		$("#barraPaginacion").show();
		$(".cajaBorrar").hide();
		$(".checksEliminar").hide();
	});
	
	$(".botonBorrar").click(function() {
		var pregunta = confirm("¿Desea borrar esta información?")
		if (pregunta){
			$(".herramientasIndividuales").show("slow");
			$("#barraPaginacion").show("slow");
			$(".cajaBorrar").hide();
			$(".checksEliminar").hide("slow");
			var valores = [];
			var todos = document.getElementsByName("registroEliminar[]");
			for(var i = 0; i < todos.length; i++){
				if (todos[i].checked){
					valores.push(todos[i].value);
				}
			}
			eliminar_registros(valores);
		}else{
			$(".herramientasIndividuales").show("slow");
			$("#barraPaginacion").show("slow");
			$(".cajaBorrar").hide();
			$(".checksEliminar").hide("slow");
		}
	});
	
	$("#campoOrden").change(function(){
		campoOrden = this.value;
		crearCookie("campoOrdenProducto", campoOrden);
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$("#cantidadamostrar").change(function(){
		cantidadamostrar = this.value;
		crearCookie("cantidadamostrarProducto", cantidadamostrar);
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$( "#asc" ).click(function() {
    	if ($( "#asc" ).is(':checked')){
			crearCookie("ordenProducto", "asc");
			orden="ASC"
			load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
		}
	});
	$( "#desc" ).click(function() {
    	if ($( "#desc" ).is(':checked')){
			crearCookie("ordenProducto", "desc");
			orden="DESC"
			load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
		}
	});
	$( "#CheckIdproducto" ).click(function() {
    	if ($( "#CheckIdproducto" ).is(':checked')){
			crearCookie("mostrarIdproductoProducto", "si");
			$('.Cidproducto').show();
		}else{
			crearCookie("mostrarIdproductoProducto", "no");
			$('.Cidproducto').hide();
		}	
	});
	$( "#CheckIdfamilia" ).click(function() {
    	if ($( "#CheckIdfamilia" ).is(':checked')){
			crearCookie("mostrarIdfamiliaProducto", "si");
			$('.Cidfamilia').show();
		}else{
			crearCookie("mostrarIdfamiliaProducto", "no");
			$('.Cidfamilia').hide();
		}	
	});
	$( "#CheckNombre" ).click(function() {
    	if ($( "#CheckNombre" ).is(':checked')){
			crearCookie("mostrarNombreProducto", "si");
			$('.Cnombre').show();
		}else{
			crearCookie("mostrarNombreProducto", "no");
			$('.Cnombre').hide();
		}	
	});
	$( "#CheckCodigo" ).click(function() {
    	if ($( "#CheckCodigo" ).is(':checked')){
			crearCookie("mostrarCodigoProducto", "si");
			$('.Ccodigo').show();
		}else{
			crearCookie("mostrarCodigoProducto", "no");
			$('.Ccodigo').hide();
		}	
	});
	$( "#CheckAutoclasificar" ).click(function() {
    	if ($( "#CheckAutoclasificar" ).is(':checked')){
			crearCookie("mostrarAutoclasificarProducto", "si");
			$('.Cautoclasificar').show();
		}else{
			crearCookie("mostrarAutoclasificarProducto", "no");
			$('.Cautoclasificar').hide();
		}	
	});
	$( "#CheckClasificacion" ).click(function() {
    	if ($( "#CheckClasificacion" ).is(':checked')){
			crearCookie("mostrarClasificacionProducto", "si");
			$('.Cclasificacion').show();
		}else{
			crearCookie("mostrarClasificacionProducto", "no");
			$('.Cclasificacion').hide();
		}	
	});
	$( "#CheckIdmodeloimpuestos" ).click(function() {
    	if ($( "#CheckIdmodeloimpuestos" ).is(':checked')){
			crearCookie("mostrarIdmodeloimpuestosProducto", "si");
			$('.Cidmodeloimpuestos').show();
		}else{
			crearCookie("mostrarIdmodeloimpuestosProducto", "no");
			$('.Cidmodeloimpuestos').hide();
		}	
	});
	$( "#CheckIdcategoria" ).click(function() {
    	if ($( "#CheckIdcategoria" ).is(':checked')){
			crearCookie("mostrarIdcategoriaProducto", "si");
			$('.Cidcategoria').show();
		}else{
			crearCookie("mostrarIdcategoriaProducto", "no");
			$('.Cidcategoria').hide();
		}	
	});
	$( "#CheckIdunidad" ).click(function() {
    	if ($( "#CheckIdunidad" ).is(':checked')){
			crearCookie("mostrarIdunidadProducto", "si");
			$('.Cidunidad').show();
		}else{
			crearCookie("mostrarIdunidadProducto", "no");
			$('.Cidunidad').hide();
		}	
	});
	$( "#CheckMarca" ).click(function() {
    	if ($( "#CheckMarca" ).is(':checked')){
			crearCookie("mostrarMarcaProducto", "si");
			$('.Cmarca').show();
		}else{
			crearCookie("mostrarMarcaProducto", "no");
			$('.Cmarca').hide();
		}	
	});
	$( "#CheckPesoteorico" ).click(function() {
    	if ($( "#CheckPesoteorico" ).is(':checked')){
			crearCookie("mostrarPesoteoricoProducto", "si");
			$('.Cpesoteorico').show();
		}else{
			crearCookie("mostrarPesoteoricoProducto", "no");
			$('.Cpesoteorico').hide();
		}	
	});
	$( "#CheckEspesor" ).click(function() {
    	if ($( "#CheckEspesor" ).is(':checked')){
			crearCookie("mostrarEspesorProducto", "si");
			$('.Cespesor').show();
		}else{
			crearCookie("mostrarEspesorProducto", "no");
			$('.Cespesor').hide();
		}	
	});
	$( "#CheckAncho" ).click(function() {
    	if ($( "#CheckAncho" ).is(':checked')){
			crearCookie("mostrarAnchoProducto", "si");
			$('.Cancho').show();
		}else{
			crearCookie("mostrarAnchoProducto", "no");
			$('.Cancho').hide();
		}	
	});
	$( "#CheckColor" ).click(function() {
    	if ($( "#CheckColor" ).is(':checked')){
			crearCookie("mostrarColorProducto", "si");
			$('.Ccolor').show();
		}else{
			crearCookie("mostrarColorProducto", "no");
			$('.Ccolor').hide();
		}	
	});
	$( "#CheckDiametro" ).click(function() {
    	if ($( "#CheckDiametro" ).is(':checked')){
			crearCookie("mostrarDiametroProducto", "si");
			$('.Cdiametro').show();
		}else{
			crearCookie("mostrarDiametroProducto", "no");
			$('.Cdiametro').hide();
		}	
	});
	$( "#CheckTipo" ).click(function() {
    	if ($( "#CheckTipo" ).is(':checked')){
			crearCookie("mostrarTipoProducto", "si");
			$('.Ctipo').show();
		}else{
			crearCookie("mostrarTipoProducto", "no");
			$('.Ctipo').hide();
		}	
	});
	$( "#CheckModelo" ).click(function() {
    	if ($( "#CheckModelo" ).is(':checked')){
			crearCookie("mostrarModeloProducto", "si");
			$('.Cmodelo').show();
		}else{
			crearCookie("mostrarModeloProducto", "no");
			$('.Cmodelo').hide();
		}	
	});
	$( "#CheckModelo2" ).click(function() {
    	if ($( "#CheckModelo2" ).is(':checked')){
			crearCookie("mostrarModelo2Producto", "si");
			$('.Cmodelo2').show();
		}else{
			crearCookie("mostrarModelo2Producto", "no");
			$('.Cmodelo2').hide();
		}	
	});
	$( "#CheckLado" ).click(function() {
    	if ($( "#CheckLado" ).is(':checked')){
			crearCookie("mostrarLadoProducto", "si");
			$('.Clado').show();
		}else{
			crearCookie("mostrarLadoProducto", "no");
			$('.Clado').hide();
		}	
	});
	$( "#CheckAlto" ).click(function() {
    	if ($( "#CheckAlto" ).is(':checked')){
			crearCookie("mostrarAltoProducto", "si");
			$('.Calto').show();
		}else{
			crearCookie("mostrarAltoProducto", "no");
			$('.Calto').hide();
		}	
	});
	$( "#CheckLargo" ).click(function() {
    	if ($( "#CheckLargo" ).is(':checked')){
			crearCookie("mostrarLargoProducto", "si");
			$('.Clargo').show();
		}else{
			crearCookie("mostrarLargoProducto", "no");
			$('.Clargo').hide();
		}	
	});
	$( "#CheckAplicacion" ).click(function() {
    	if ($( "#CheckAplicacion" ).is(':checked')){
			crearCookie("mostrarAplicacionProducto", "si");
			$('.Caplicacion').show();
		}else{
			crearCookie("mostrarAplicacionProducto", "no");
			$('.Caplicacion').hide();
		}	
	});
	$( "#CheckClave" ).click(function() {
    	if ($( "#CheckClave" ).is(':checked')){
			crearCookie("mostrarClaveProducto", "si");
			$('.Cclave').show();
		}else{
			crearCookie("mostrarClaveProducto", "no");
			$('.Cclave').hide();
		}	
	});
	$( "#CheckDescripcion" ).click(function() {
    	if ($( "#CheckDescripcion" ).is(':checked')){
			crearCookie("mostrarDescripcionProducto", "si");
			$('.Cdescripcion').show();
		}else{
			crearCookie("mostrarDescripcionProducto", "no");
			$('.Cdescripcion').hide();
		}	
	});
	$( "#CheckVariacionpermitidaencosto" ).click(function() {
    	if ($( "#CheckVariacionpermitidaencosto" ).is(':checked')){
			crearCookie("mostrarVariacionpermitidaencostoProducto", "si");
			$('.Cvariacionpermitidaencosto').show();
		}else{
			crearCookie("mostrarVariacionpermitidaencostoProducto", "no");
			$('.Cvariacionpermitidaencosto').hide();
		}	
	});
	$( "#CheckCosto" ).click(function() {
    	if ($( "#CheckCosto" ).is(':checked')){
			crearCookie("mostrarCostoProducto", "si");
			$('.Ccosto').show();
		}else{
			crearCookie("mostrarCostoProducto", "no");
			$('.Ccosto').hide();
		}	
	});
	$( "#CheckComposicion" ).click(function() {
    	if ($( "#CheckComposicion" ).is(':checked')){
			crearCookie("mostrarComposicionProducto", "si");
			$('.Ccomposicion').show();
		}else{
			crearCookie("mostrarComposicionProducto", "no");
			$('.Ccomposicion').hide();
		}
	});
	
	$(".botonBuscar").click(function() {
		var busqueda=$.trim( $("#cajaBuscar").val());
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,busqueda,tipoVista);
	});
	
	 $("#cajaBuscar").keypress(function(event){  
      	var keycode = (event.keyCode ? event.keyCode : event.which); 
      	if(keycode == '13'){  
      		var busqueda=$.trim( $("#cajaBuscar").val());
      		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,busqueda,tipoVista);
			$("#cajaBuscar").val("");
			$("#cajaBuscar").focus();
      	}     
 	}); 
	
	$("#botonFiltrar").click(function() {
		var busqueda=$.trim( $("#cajaBuscar").val());
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,busqueda,tipoVista);
	});
	
	$(".botonExportar").click(function() {
		var busqueda=$.trim( $("#cajaBuscar").val());
		exportar(campoOrden,orden,cantidadamostrar,paginacion,busqueda,tipoVista);
	});
	
	$(".botonNormal").click(function(){ 
		$("#panel_alertas").stop(false, true);
 	});
	
	$("#botonFamilia").click(function(){ 
		$("#modal2").modal();
 	});
	
	/*Importante*/
	$('.dropdown-menu').on('click', function(e){
        if($(this).hasClass('dropdown-menu-form')){
            e.stopPropagation();
        }
	});
	
	$(".close").click(function(){ 
		$("#panel_alertas").stop(false, true);
		$("#panel_alertas").hide();
 	});
	/*Fin de Importante*/
	
});

//***********************AJAX*********************

// Autor: Armando Viera Rodríguez
// Onixbm 2014
function load_tablas (campoOrden, orden, cantidadamostrar, paginacion, busqueda, tipoVista){
	//alert (orden);
	//alert (campoOrden);
	//alert (limit);
	var marca=$("#cmarca").val();
	var espesor=$("#cespesor").val();
	var ancho=$("#cancho").val();
	var diametro=$("#cdiametro").val();
	var alto=$("#calto").val();
	var largo=$("#clargo").val();
	var color=$("#ccolor").val();
	var aplicacion=$("#caplicacion").val();
	var tipo=$("#ctipo").val();
	var idfamilia=$("#cidfamiliamadre").val();
	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById("muestra_contenido_ajax").innerHTML=xmlhttp.responseText;
			comprobarReglas();
			$("#loading").hide();
		}
		else{
			$("#loading").show();
		}
	}
	
	xmlhttp.open("POST","consultar.php?campoOrden="+campoOrden+"&orden="+orden+"&cantidadamostrar="+cantidadamostrar+"&paginacion="+paginacion+"&busqueda="+busqueda+"&tipoVista="+tipoVista+"&papelera="+papelera+"&marca="+marca+"&espesor="+espesor+"&ancho="+ancho+"&diametro="+diametro+"&alto="+alto+"&largo="+largo+"&color="+color+"&aplicacion="+aplicacion+"&tipo="+tipo+"&idfamilia="+idfamilia, true);
	xmlhttp.send();
}

function exportar(campoOrden, orden, cantidadamostrar, paginacion, busqueda, tipoVista){
	var marca=$("#cmarca").val();
	var espesor=$("#cespesor").val();
	var ancho=$("#cancho").val();
	var diametro=$("#cdiametro").val();
	var alto=$("#calto").val();
	var largo=$("#clargo").val();
	var color=$("#ccolor").val();
	var aplicacion=$("#caplicacion").val();
	var tipo=$("#ctipo").val();
	var idfamilia=$("#cidfamiliamadre").val();
	window.open("consultarExcel.php?campoOrden="+campoOrden+"&orden="+orden+"&cantidadamostrar="+cantidadamostrar+"&paginacion="+paginacion+"&busqueda="+busqueda+"&tipoVista="+tipoVista+"&papelera="+papelera+"&marca="+marca+"&espesor="+espesor+"&ancho="+ancho+"&diametro="+diametro+"&alto="+alto+"&largo="+largo+"&color="+color+"&aplicacion="+aplicacion+"&tipo="+tipo+"&idfamilia="+idfamilia);
}

function eliminar_registros(ids){
		
		$.ajax({
			url: '../eliminar/eliminar.php',
			type: "POST",
			data: {ids:ids}, //Pasamos los datos en forma de array
			success: function(mensaje){
				mostrarMensaje(mensaje,ids,"eliminar");
			}
		});
		return false;
}

function eliminar_individual(id){
		$.ajax({
			url: '../eliminar/eliminar.php',
			type: "POST",
			data: "submit=&ids="+id, //Pasamos los datos en forma de array
			success: function(mensaje){
				mostrarMensaje(mensaje,id,"eliminar");
			}
		});
		return false;
}

function restaurar_individual(id){
		$.ajax({
			url: '../eliminar/restaurar.php',
			type: "POST",
			data: "submit=&ids="+id, //Pasamos los datos en forma de array
			success: function(mensaje){
				mostrarMensaje(mensaje,id,"eliminar");
			}
		});
		return false;
}

function llenarSelect(control,condicion){
		$("#idunidad_ajax").html("<option value='1'>cargando...</option>");
		$.ajax({
			url: '../componentes/llenarSelectCaracteristica.php',
			type: "POST",
			data: "submit=&condicion="+condicion, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#"+control).html(mensaje);
			}
		});
		return false;
}

function eliminar_stock(idstock,idproducto){
	
		$.ajax({
			url: 'eliminarStock.php',
			type: "POST",
			data: "submit=&id="+idstock, //Pasamos los datos en forma de array
			success: function(mensaje){
				consultarStock(idproducto);
			}
		});
		return false;
}

function agregar_stock(idproducto,idsucursal){
		$.ajax({
			url: 'agregarStock.php',
			type: "POST",
			data: "submit=&idproducto="+idproducto+"&idsucursal="+idsucursal, //Pasamos los datos en forma de array
			success: function(mensaje){
				consultarStock(idproducto);
			}
		});
		return false;
}

function consultarStock(idproducto){
		$.ajax({
			url: 'consultarStock.php',
			type: "POST",
			data: "submit=&idproducto="+idproducto, //Pasamos los datos en forma de array
			success: function(mensaje){
				$("#contenidoStocks").html(mensaje);
			}
		});
		return false;
}

//////FUNCIONES DEL LLENADO DEL ARBOL DE FAMILIAS Y CONFIGURACION DE CAMPOS

function llenarArbol(variables){
		$("#arbol_ajax").jstree('destroy');
	    $("#arbol_ajax").html("");
		$("#loading").show();
		$.ajax({
			url: '../componentes/llenarArbol.php',
			type: "POST",
			data: "submit=&"+variables, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#loading").hide();
				$("#arbol_ajax").html(mensaje);
				$('#arbol_ajax').jstree();
				$('#arbol_ajax').on('changed.jstree', function (e, data) {
					var nombre=$(".jstree-clicked").parent().attr("nombre");
					var idfamilia=$(".jstree-clicked").parent().attr("idfamilia");
					if (nombre){
						$('#autoidfamiliamadre').val(nombre);
					}
					if (idfamilia){
						$('#cidfamiliamadre').val(idfamilia);
					}
				})
			}
		});
		return false;
}

function mostrarMensaje(mensaje,ids, accion){
	var cadena= $.trim(mensaje); //Limpia la cadena regresada desde php
	var res=cadena.split("@"); //Separa la cadena en cada @ y convierte las partes en un array
	if (res[0]=="exito"){ //Si la primer frase contiene la palabra "exito"
		$("#panel_alertas").removeClass().addClass("alert alert-success alert-dismissable");
		$("#notificacionTitulo").html("<i class='icon fa fa-check'></i>"+res[1]);
		$("#notificacionContenido").html(res[2]);
		if(accion=="eliminar"){
			ocultar_registros_eliminados(ids);
		}
		$(".checkEliminar").attr('checked', false);
	}else if (res[0]=="fracaso"){
		$("#panel_alertas").removeClass().addClass("alert alert-error alert-dismissable");
		$("#notificacionTitulo").html("<i class='icon fa fa-ban'></i>"+res[1]);
		$("#notificacionContenido").html(res[2]);
	}else if (res[0]=="aviso"){
		$("#panel_alertas").removeClass().addClass("alert alert-warning alert-dismissable");
		$("#notificacionTitulo").html("<i class='icon fa fa-warning'></i>"+res[1]);
		$("#notificacionContenido").html(res[2]);
	}else{
		$("#panel_alertas").removeClass().addClass("alert alert-error alert-dismissable");
		$("#notificacionTitulo").html("Operaci&oacute;n fallida");
		$("#notificacionContenido").html("<i class='icon fa fa-ban'></i>No se han resivido datos de respuesta desde el servidor [003]");
	}
	$("#panel_alertas").stop(false, true);
	$("#panel_alertas").fadeIn("slow");
	$("#panel_alertas").delay(5000).fadeOut("slow");
}
function ocultar_registros_eliminados(ids){
	if (ids.length){
		for(var i = 0; i < ids.length; i++){
			$("#iregistro"+ids[i]).hide("slow");
		}
	}
	else{
		$("#iregistro"+ids).hide("slow");
	}
}