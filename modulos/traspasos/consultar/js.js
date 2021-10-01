// JavaScript Document
var orden, campoOrden, cantidadamostrar, paginacion;
orden="DESC";
campoOrden="idtraspaso";
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
	if(recuperarCookie("campoOrdenTraspaso")!=null){
		campoOrden=recuperarCookie("campoOrdenTraspaso");
		 $("#campoOrden option[value="+campoOrden+"]").attr("selected",true);
	}else{
		campoOrden="idtraspaso";
		$("#campoOrden option[value="+campoOrden+"]").attr("selected",true);
	}
	
	//Identificar el numero de elementos para mostrar
	if(recuperarCookie("cantidadamostrarTraspaso")!=null){
		cantidadamostrar=recuperarCookie("cantidadamostrarTraspaso");
		 $("#cantidadamostrar option[value="+cantidadamostrar+"]").attr("selected",true);
	}else{
		cantidadamostrar="20";
		$("#cantidadamostrar option[value="+cantidadamostrar+"]").attr("selected",true);
		
	}
	
	//Identificar el tipo de orden
	if(recuperarCookie("ordenTraspaso")=="asc"){
		orden="ASC"
		$('#asc').attr('checked', true);
		$('#desc').attr('checked', false);
	}else if(recuperarCookie("ordenTraspaso")=="desc"){
		orden="DESC"
		$('#asc').attr('checked', false);
		$('#desc').attr('checked', true);
	}else{
		orden="DESC"
		$('#asc').attr('checked', false);
		$('#desc').attr('checked', true);
	}
	//Mostrar u Ocultar Idtraspaso
	if(recuperarCookie("mostrarIdtraspasoTraspaso")=="si"){
		$('.Cidtraspaso').show();
		$('#CheckIdtraspaso').attr('checked', true);
	}else if(recuperarCookie("mostrarIdtraspasoTraspaso")=="no"){
		$('.Cidtraspaso').hide();
		$('#CheckIdtraspaso').attr('checked', false);
	}
	//Mostrar u Ocultar Idmovimiento
	if(recuperarCookie("mostrarIdmovimientoTraspaso")=="si"){
		$('.Cidmovimiento').show();
		$('#CheckIdmovimiento').attr('checked', true);
	}else if(recuperarCookie("mostrarIdmovimientoTraspaso")=="no"){
		$('.Cidmovimiento').hide();
		$('#CheckIdmovimiento').attr('checked', false);
	}
	//Mostrar u Ocultar Idsucursalorigen
	if(recuperarCookie("mostrarIdsucursalorigenTraspaso")=="si"){
		$('.Cidsucursalorigen').show();
		$('#CheckIdsucursalorigen').attr('checked', true);
	}else if(recuperarCookie("mostrarIdsucursalorigenTraspaso")=="no"){
		$('.Cidsucursalorigen').hide();
		$('#CheckIdsucursalorigen').attr('checked', false);
	}
	//Mostrar u Ocultar Idsucursaldestino
	if(recuperarCookie("mostrarIdsucursaldestinoTraspaso")=="si"){
		$('.Cidsucursaldestino').show();
		$('#CheckIdsucursaldestino').attr('checked', true);
	}else if(recuperarCookie("mostrarIdsucursaldestinoTraspaso")=="no"){
		$('.Cidsucursaldestino').hide();
		$('#CheckIdsucursaldestino').attr('checked', false);
	}
	//Mostrar u Ocultar Fechasalida
	if(recuperarCookie("mostrarFechasalidaTraspaso")=="si"){
		$('.Cfechasalida').show();
		$('#CheckFechasalida').attr('checked', true);
	}else if(recuperarCookie("mostrarFechasalidaTraspaso")=="no"){
		$('.Cfechasalida').hide();
		$('#CheckFechasalida').attr('checked', false);
	}
	//Mostrar u Ocultar Fechaentrada
	if(recuperarCookie("mostrarFechaentradaTraspaso")=="si"){
		$('.Cfechaentrada').show();
		$('#CheckFechaentrada').attr('checked', true);
	}else if(recuperarCookie("mostrarFechaentradaTraspaso")=="no"){
		$('.Cfechaentrada').hide();
		$('#CheckFechaentrada').attr('checked', false);
	}
	//Mostrar u Ocultar Estado
	if(recuperarCookie("mostrarEstadoTraspaso")=="si"){
		$('.Cestado').show();
		$('#CheckEstado').attr('checked', true);
	}else if(recuperarCookie("mostrarEstadoTraspaso")=="no"){
		$('.Cestado').hide();
		$('#CheckEstado').attr('checked', false);
	}
	//Mostrar u Ocultar Numerocomprobante
	if(recuperarCookie("mostrarNumerocomprobanteTraspaso")=="si"){
		$('.Cnumerocomprobante').show();
		$('#CheckNumerocomprobante').attr('checked', true);
	}else if(recuperarCookie("mostrarNumerocomprobanteTraspaso")=="no"){
		$('.Cnumerocomprobante').hide();
		$('#CheckNumerocomprobante').attr('checked', false);
	}
	//Mostrar u Ocultar Idusuariosalida
	if(recuperarCookie("mostrarIdusuariosalidaTraspaso")=="si"){
		$('.Cidusuariosalida').show();
		$('#CheckIdusuariosalida').attr('checked', true);
	}else if(recuperarCookie("mostrarIdusuariosalidaTraspaso")=="no"){
		$('.Cidusuariosalida').hide();
		$('#CheckIdusuariosalida').attr('checked', false);
	}
	//Mostrar u Ocultar Idusuarioentrada
	if(recuperarCookie("mostrarIdusuarioentradaTraspaso")=="si"){
		$('.Cidusuarioentrada').show();
		$('#CheckIdusuarioentrada').attr('checked', true);
	}else if(recuperarCookie("mostrarIdusuarioentradaTraspaso")=="no"){
		$('.Cidusuarioentrada').hide();
		$('#CheckIdusuarioentrada').attr('checked', false);
	}
	//Mostrar u Ocultar Composicion
	if(recuperarCookie("mostrarComposicionTraspaso")=="si"){
		$('.Ccomposicion').show();
		$('#CheckComposicion').attr('checked', true);
	}
	if(recuperarCookie("mostrarComposicionTraspaso")=="no"){
		$('.Ccomposicion').hide();
		$('#CheckComposicion').attr('checked', false);
	}
	
	//Elegir el tipo de vista
	if(recuperarCookie("tipoVistaTraspaso")=="tabla"){
		$('.tipoLista').show();
		$('.tipoTabla').hide();
		tipoVista="tabla";
	}else{
		$('.tipoLista').hide();
		$('.tipoTabla').show();
		tipoVista="lista";
	}
	$( ".tipoTabla" ).click(function() {
    	crearCookie("tipoVistaTraspaso", "tabla");
		tipoVista="tabla";
		$(".tipoLista").show();
		$(".tipoTabla").hide();
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$( ".tipoLista" ).click(function() {
    	crearCookie("tipoVistaTraspaso", "lista");
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
		crearCookie("campoOrdenTraspaso", campoOrden);
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$("#cantidadamostrar").change(function(){
		cantidadamostrar = this.value;
		crearCookie("cantidadamostrarTraspaso", cantidadamostrar);
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$( "#asc" ).click(function() {
    	if ($( "#asc" ).is(':checked')){
			crearCookie("ordenTraspaso", "asc");
			orden="ASC"
			load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
		}
	});
	$( "#desc" ).click(function() {
    	if ($( "#desc" ).is(':checked')){
			crearCookie("ordenTraspaso", "desc");
			orden="DESC"
			load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
		}
	});
	$( "#CheckIdtraspaso" ).click(function() {
    	if ($( "#CheckIdtraspaso" ).is(':checked')){
			crearCookie("mostrarIdtraspasoTraspaso", "si");
			$('.Cidtraspaso').show();
		}else{
			crearCookie("mostrarIdtraspasoTraspaso", "no");
			$('.Cidtraspaso').hide();
		}	
	});
	$( "#CheckIdmovimiento" ).click(function() {
    	if ($( "#CheckIdmovimiento" ).is(':checked')){
			crearCookie("mostrarIdmovimientoTraspaso", "si");
			$('.Cidmovimiento').show();
		}else{
			crearCookie("mostrarIdmovimientoTraspaso", "no");
			$('.Cidmovimiento').hide();
		}	
	});
	$( "#CheckIdsucursalorigen" ).click(function() {
    	if ($( "#CheckIdsucursalorigen" ).is(':checked')){
			crearCookie("mostrarIdsucursalorigenTraspaso", "si");
			$('.Cidsucursalorigen').show();
		}else{
			crearCookie("mostrarIdsucursalorigenTraspaso", "no");
			$('.Cidsucursalorigen').hide();
		}	
	});
	$( "#CheckIdsucursaldestino" ).click(function() {
    	if ($( "#CheckIdsucursaldestino" ).is(':checked')){
			crearCookie("mostrarIdsucursaldestinoTraspaso", "si");
			$('.Cidsucursaldestino').show();
		}else{
			crearCookie("mostrarIdsucursaldestinoTraspaso", "no");
			$('.Cidsucursaldestino').hide();
		}	
	});
	$( "#CheckFechasalida" ).click(function() {
    	if ($( "#CheckFechasalida" ).is(':checked')){
			crearCookie("mostrarFechasalidaTraspaso", "si");
			$('.Cfechasalida').show();
		}else{
			crearCookie("mostrarFechasalidaTraspaso", "no");
			$('.Cfechasalida').hide();
		}	
	});
	$( "#CheckFechaentrada" ).click(function() {
    	if ($( "#CheckFechaentrada" ).is(':checked')){
			crearCookie("mostrarFechaentradaTraspaso", "si");
			$('.Cfechaentrada').show();
		}else{
			crearCookie("mostrarFechaentradaTraspaso", "no");
			$('.Cfechaentrada').hide();
		}	
	});
	$( "#CheckEstado" ).click(function() {
    	if ($( "#CheckEstado" ).is(':checked')){
			crearCookie("mostrarEstadoTraspaso", "si");
			$('.Cestado').show();
		}else{
			crearCookie("mostrarEstadoTraspaso", "no");
			$('.Cestado').hide();
		}	
	});
	$( "#CheckNumerocomprobante" ).click(function() {
    	if ($( "#CheckNumerocomprobante" ).is(':checked')){
			crearCookie("mostrarNumerocomprobanteTraspaso", "si");
			$('.Cnumerocomprobante').show();
		}else{
			crearCookie("mostrarNumerocomprobanteTraspaso", "no");
			$('.Cnumerocomprobante').hide();
		}	
	});
	$( "#CheckIdusuariosalida" ).click(function() {
    	if ($( "#CheckIdusuariosalida" ).is(':checked')){
			crearCookie("mostrarIdusuariosalidaTraspaso", "si");
			$('.Cidusuariosalida').show();
		}else{
			crearCookie("mostrarIdusuariosalidaTraspaso", "no");
			$('.Cidusuariosalida').hide();
		}	
	});
	$( "#CheckIdusuarioentrada" ).click(function() {
    	if ($( "#CheckIdusuarioentrada" ).is(':checked')){
			crearCookie("mostrarIdusuarioentradaTraspaso", "si");
			$('.Cidusuarioentrada').show();
		}else{
			crearCookie("mostrarIdusuarioentradaTraspaso", "no");
			$('.Cidusuarioentrada').hide();
		}	
	});
	$( "#CheckComposicion" ).click(function() {
    	if ($( "#CheckComposicion" ).is(':checked')){
			crearCookie("mostrarComposicionTraspaso", "si");
			$('.Ccomposicion').show();
		}else{
			crearCookie("mostrarComposicionTraspaso", "no");
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