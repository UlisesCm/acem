// JavaScript Document
var orden, campoOrden, cantidadamostrar, paginacion;
orden="DESC";
campoOrden="idarchivo";
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
function comprobarReglas(){
	$(".checksEliminar").hide();
	//Identificar el campo de ordenamiento
	if(recuperarCookie("campoOrdenArchivo")!=null){
		campoOrden=recuperarCookie("campoOrdenArchivo");
		 $("#campoOrden option[value="+campoOrden+"]").attr("selected",true);
	}else{
		campoOrden="idarchivo";
		$("#campoOrden option[value="+campoOrden+"]").attr("selected",true);
	}
	
	//Identificar el numero de elementos para mostrar
	if(recuperarCookie("cantidadamostrarArchivo")!=null){
		cantidadamostrar=recuperarCookie("cantidadamostrarArchivo");
		 $("#cantidadamostrar option[value="+cantidadamostrar+"]").attr("selected",true);
	}else{
		cantidadamostrar="20";
		$("#cantidadamostrar option[value="+cantidadamostrar+"]").attr("selected",true);
		
	}
	
	//Identificar el tipo de orden
	if(recuperarCookie("ordenArchivo")=="asc"){
		orden="ASC"
		$('#asc').attr('checked', true);
		$('#desc').attr('checked', false);
	}else if(recuperarCookie("ordenArchivo")=="desc"){
		orden="DESC"
		$('#asc').attr('checked', false);
		$('#desc').attr('checked', true);
	}else{
		orden="DESC"
		$('#asc').attr('checked', false);
		$('#desc').attr('checked', true);
	}
	//Mostrar u Ocultar Idarchivo
	if(recuperarCookie("mostrarIdarchivoArchivo")=="si"){
		$('.Cidarchivo').show();
		$('#CheckIdarchivo').attr('checked', true);
	}else if(recuperarCookie("mostrarIdarchivoArchivo")=="no"){
		$('.Cidarchivo').hide();
		$('#CheckIdarchivo').attr('checked', false);
	}
	//Mostrar u Ocultar Pdf
	if(recuperarCookie("mostrarPdfArchivo")=="si"){
		$('.Cpdf').show();
		$('#CheckPdf').attr('checked', true);
	}else if(recuperarCookie("mostrarPdfArchivo")=="no"){
		$('.Cpdf').hide();
		$('#CheckPdf').attr('checked', false);
	}
	//Mostrar u Ocultar Xml
	if(recuperarCookie("mostrarXmlArchivo")=="si"){
		$('.Cxml').show();
		$('#CheckXml').attr('checked', true);
	}else if(recuperarCookie("mostrarXmlArchivo")=="no"){
		$('.Cxml').hide();
		$('#CheckXml').attr('checked', false);
	}
	//Mostrar u Ocultar Fechamodificacion
	if(recuperarCookie("mostrarFechamodificacionArchivo")=="si"){
		$('.Cfechamodificacion').show();
		$('#CheckFechamodificacion').attr('checked', true);
	}else if(recuperarCookie("mostrarFechamodificacionArchivo")=="no"){
		$('.Cfechamodificacion').hide();
		$('#CheckFechamodificacion').attr('checked', false);
	}
	//Mostrar u Ocultar Tablareferencia
	if(recuperarCookie("mostrarTablareferenciaArchivo")=="si"){
		$('.Ctablareferencia').show();
		$('#CheckTablareferencia').attr('checked', true);
	}else if(recuperarCookie("mostrarTablareferenciaArchivo")=="no"){
		$('.Ctablareferencia').hide();
		$('#CheckTablareferencia').attr('checked', false);
	}
	//Mostrar u Ocultar Idreferencia
	if(recuperarCookie("mostrarIdreferenciaArchivo")=="si"){
		$('.Cidreferencia').show();
		$('#CheckIdreferencia').attr('checked', true);
	}else if(recuperarCookie("mostrarIdreferenciaArchivo")=="no"){
		$('.Cidreferencia').hide();
		$('#CheckIdreferencia').attr('checked', false);
	}
	//Mostrar u Ocultar Serie
	if(recuperarCookie("mostrarSerieArchivo")=="si"){
		$('.Cserie').show();
		$('#CheckSerie').attr('checked', true);
	}else if(recuperarCookie("mostrarSerieArchivo")=="no"){
		$('.Cserie').hide();
		$('#CheckSerie').attr('checked', false);
	}
	//Mostrar u Ocultar Folio
	if(recuperarCookie("mostrarFolioArchivo")=="si"){
		$('.Cfolio').show();
		$('#CheckFolio').attr('checked', true);
	}else if(recuperarCookie("mostrarFolioArchivo")=="no"){
		$('.Cfolio').hide();
		$('#CheckFolio').attr('checked', false);
	}
	//Mostrar u Ocultar Tipo
	if(recuperarCookie("mostrarTipoArchivo")=="si"){
		$('.Ctipo').show();
		$('#CheckTipo').attr('checked', true);
	}else if(recuperarCookie("mostrarTipoArchivo")=="no"){
		$('.Ctipo').hide();
		$('#CheckTipo').attr('checked', false);
	}
	//Mostrar u Ocultar Fechatimbre
	if(recuperarCookie("mostrarFechatimbreArchivo")=="si"){
		$('.Cfechatimbre').show();
		$('#CheckFechatimbre').attr('checked', true);
	}else if(recuperarCookie("mostrarFechatimbreArchivo")=="no"){
		$('.Cfechatimbre').hide();
		$('#CheckFechatimbre').attr('checked', false);
	}
	//Mostrar u Ocultar Emisor
	if(recuperarCookie("mostrarEmisorArchivo")=="si"){
		$('.Cemisor').show();
		$('#CheckEmisor').attr('checked', true);
	}else if(recuperarCookie("mostrarEmisorArchivo")=="no"){
		$('.Cemisor').hide();
		$('#CheckEmisor').attr('checked', false);
	}
	//Mostrar u Ocultar Rfcemisor
	if(recuperarCookie("mostrarRfcemisorArchivo")=="si"){
		$('.Crfcemisor').show();
		$('#CheckRfcemisor').attr('checked', true);
	}else if(recuperarCookie("mostrarRfcemisorArchivo")=="no"){
		$('.Crfcemisor').hide();
		$('#CheckRfcemisor').attr('checked', false);
	}
	//Mostrar u Ocultar Receptor
	if(recuperarCookie("mostrarReceptorArchivo")=="si"){
		$('.Creceptor').show();
		$('#CheckReceptor').attr('checked', true);
	}else if(recuperarCookie("mostrarReceptorArchivo")=="no"){
		$('.Creceptor').hide();
		$('#CheckReceptor').attr('checked', false);
	}
	//Mostrar u Ocultar Rfcreceptor
	if(recuperarCookie("mostrarRfcreceptorArchivo")=="si"){
		$('.Crfcreceptor').show();
		$('#CheckRfcreceptor').attr('checked', true);
	}else if(recuperarCookie("mostrarRfcreceptorArchivo")=="no"){
		$('.Crfcreceptor').hide();
		$('#CheckRfcreceptor').attr('checked', false);
	}
	//Mostrar u Ocultar Monto
	if(recuperarCookie("mostrarMontoArchivo")=="si"){
		$('.Cmonto').show();
		$('#CheckMonto').attr('checked', true);
	}else if(recuperarCookie("mostrarMontoArchivo")=="no"){
		$('.Cmonto').hide();
		$('#CheckMonto').attr('checked', false);
	}
	//Mostrar u Ocultar Uuid
	if(recuperarCookie("mostrarUuidArchivo")=="si"){
		$('.Cuuid').show();
		$('#CheckUuid').attr('checked', true);
	}else if(recuperarCookie("mostrarUuidArchivo")=="no"){
		$('.Cuuid').hide();
		$('#CheckUuid').attr('checked', false);
	}
	//Mostrar u Ocultar Composicion
	if(recuperarCookie("mostrarComposicionArchivo")=="si"){
		$('.Ccomposicion').show();
		$('#CheckComposicion').attr('checked', true);
	}
	if(recuperarCookie("mostrarComposicionArchivo")=="no"){
		$('.Ccomposicion').hide();
		$('#CheckComposicion').attr('checked', false);
	}
	
	//Elegir el tipo de vista
	if(recuperarCookie("tipoVistaArchivo")=="tabla"){
		$('.tipoLista').show();
		$('.tipoTabla').hide();
		tipoVista="tabla";
	}else{
		$('.tipoLista').hide();
		$('.tipoTabla').show();
		tipoVista="lista";
	}
	$( ".tipoTabla" ).click(function() {
    	crearCookie("tipoVistaArchivo", "tabla");
		tipoVista="tabla";
		$(".tipoLista").show();
		$(".tipoTabla").hide();
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$( ".tipoLista" ).click(function() {
    	crearCookie("tipoVistaArchivo", "lista");
		tipoVista="lista";
		$(".tipoLista").hide();
		$(".tipoTabla").show();
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});

}

	
$(document).ready(function() {
	$("#cajaBuscar").focus();
	comprobarReglas();
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
		crearCookie("campoOrdenArchivo", campoOrden);
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$("#cantidadamostrar").change(function(){
		cantidadamostrar = this.value;
		crearCookie("cantidadamostrarArchivo", cantidadamostrar);
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$( "#asc" ).click(function() {
    	if ($( "#asc" ).is(':checked')){
			crearCookie("ordenArchivo", "asc");
			orden="ASC"
			load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
		}
	});
	$( "#desc" ).click(function() {
    	if ($( "#desc" ).is(':checked')){
			crearCookie("ordenArchivo", "desc");
			orden="DESC"
			load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
		}
	});
	$( "#CheckIdarchivo" ).click(function() {
    	if ($( "#CheckIdarchivo" ).is(':checked')){
			crearCookie("mostrarIdarchivoArchivo", "si");
			$('.Cidarchivo').show();
		}else{
			crearCookie("mostrarIdarchivoArchivo", "no");
			$('.Cidarchivo').hide();
		}	
	});
	$( "#CheckPdf" ).click(function() {
    	if ($( "#CheckPdf" ).is(':checked')){
			crearCookie("mostrarPdfArchivo", "si");
			$('.Cpdf').show();
		}else{
			crearCookie("mostrarPdfArchivo", "no");
			$('.Cpdf').hide();
		}	
	});
	$( "#CheckXml" ).click(function() {
    	if ($( "#CheckXml" ).is(':checked')){
			crearCookie("mostrarXmlArchivo", "si");
			$('.Cxml').show();
		}else{
			crearCookie("mostrarXmlArchivo", "no");
			$('.Cxml').hide();
		}	
	});
	$( "#CheckFechamodificacion" ).click(function() {
    	if ($( "#CheckFechamodificacion" ).is(':checked')){
			crearCookie("mostrarFechamodificacionArchivo", "si");
			$('.Cfechamodificacion').show();
		}else{
			crearCookie("mostrarFechamodificacionArchivo", "no");
			$('.Cfechamodificacion').hide();
		}	
	});
	$( "#CheckTablareferencia" ).click(function() {
    	if ($( "#CheckTablareferencia" ).is(':checked')){
			crearCookie("mostrarTablareferenciaArchivo", "si");
			$('.Ctablareferencia').show();
		}else{
			crearCookie("mostrarTablareferenciaArchivo", "no");
			$('.Ctablareferencia').hide();
		}	
	});
	$( "#CheckIdreferencia" ).click(function() {
    	if ($( "#CheckIdreferencia" ).is(':checked')){
			crearCookie("mostrarIdreferenciaArchivo", "si");
			$('.Cidreferencia').show();
		}else{
			crearCookie("mostrarIdreferenciaArchivo", "no");
			$('.Cidreferencia').hide();
		}	
	});
	$( "#CheckSerie" ).click(function() {
    	if ($( "#CheckSerie" ).is(':checked')){
			crearCookie("mostrarSerieArchivo", "si");
			$('.Cserie').show();
		}else{
			crearCookie("mostrarSerieArchivo", "no");
			$('.Cserie').hide();
		}	
	});
	$( "#CheckFolio" ).click(function() {
    	if ($( "#CheckFolio" ).is(':checked')){
			crearCookie("mostrarFolioArchivo", "si");
			$('.Cfolio').show();
		}else{
			crearCookie("mostrarFolioArchivo", "no");
			$('.Cfolio').hide();
		}	
	});
	$( "#CheckTipo" ).click(function() {
    	if ($( "#CheckTipo" ).is(':checked')){
			crearCookie("mostrarTipoArchivo", "si");
			$('.Ctipo').show();
		}else{
			crearCookie("mostrarTipoArchivo", "no");
			$('.Ctipo').hide();
		}	
	});
	$( "#CheckFechatimbre" ).click(function() {
    	if ($( "#CheckFechatimbre" ).is(':checked')){
			crearCookie("mostrarFechatimbreArchivo", "si");
			$('.Cfechatimbre').show();
		}else{
			crearCookie("mostrarFechatimbreArchivo", "no");
			$('.Cfechatimbre').hide();
		}	
	});
	$( "#CheckEmisor" ).click(function() {
    	if ($( "#CheckEmisor" ).is(':checked')){
			crearCookie("mostrarEmisorArchivo", "si");
			$('.Cemisor').show();
		}else{
			crearCookie("mostrarEmisorArchivo", "no");
			$('.Cemisor').hide();
		}	
	});
	$( "#CheckRfcemisor" ).click(function() {
    	if ($( "#CheckRfcemisor" ).is(':checked')){
			crearCookie("mostrarRfcemisorArchivo", "si");
			$('.Crfcemisor').show();
		}else{
			crearCookie("mostrarRfcemisorArchivo", "no");
			$('.Crfcemisor').hide();
		}	
	});
	$( "#CheckReceptor" ).click(function() {
    	if ($( "#CheckReceptor" ).is(':checked')){
			crearCookie("mostrarReceptorArchivo", "si");
			$('.Creceptor').show();
		}else{
			crearCookie("mostrarReceptorArchivo", "no");
			$('.Creceptor').hide();
		}	
	});
	$( "#CheckRfcreceptor" ).click(function() {
    	if ($( "#CheckRfcreceptor" ).is(':checked')){
			crearCookie("mostrarRfcreceptorArchivo", "si");
			$('.Crfcreceptor').show();
		}else{
			crearCookie("mostrarRfcreceptorArchivo", "no");
			$('.Crfcreceptor').hide();
		}	
	});
	$( "#CheckMonto" ).click(function() {
    	if ($( "#CheckMonto" ).is(':checked')){
			crearCookie("mostrarMontoArchivo", "si");
			$('.Cmonto').show();
		}else{
			crearCookie("mostrarMontoArchivo", "no");
			$('.Cmonto').hide();
		}	
	});
	$( "#CheckUuid" ).click(function() {
    	if ($( "#CheckUuid" ).is(':checked')){
			crearCookie("mostrarUuidArchivo", "si");
			$('.Cuuid').show();
		}else{
			crearCookie("mostrarUuidArchivo", "no");
			$('.Cuuid').hide();
		}	
	});
	$( "#CheckComposicion" ).click(function() {
    	if ($( "#CheckComposicion" ).is(':checked')){
			crearCookie("mostrarComposicionArchivo", "si");
			$('.Ccomposicion').show();
		}else{
			crearCookie("mostrarComposicionArchivo", "no");
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
	
	$(".botonNormal").click(function(){ 
		$("#panel_alertas").stop(false, true);
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
	
	xmlhttp.open("POST","consultar.php?campoOrden="+campoOrden+"&orden="+orden+"&cantidadamostrar="+cantidadamostrar+"&paginacion="+paginacion+"&busqueda="+busqueda+"&tipoVista="+tipoVista+"&papelera="+papelera, true);
	xmlhttp.send();
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