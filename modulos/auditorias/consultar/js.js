// JavaScript Document
var orden, campoOrden, cantidadamostrar, paginacion;
orden="DESC";
campoOrden="idauditoria";
iniciar="0";
cantidadamostrar="20";
paginacion=0;

function abrirModal(id){
	$("#modal").modal();
	$("#contenidoModal").html("<div id='loading2' class='overlay'><i class='fa fa-cog fa-spin' style='color:#3d7698'></i> &nbsp;Espere un momento por favor</div>");
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
	if(recuperarCookie("campoOrdenAuditoria")!=null){
		campoOrden=recuperarCookie("campoOrdenAuditoria");
		 $("#campoOrden option[value="+campoOrden+"]").attr("selected",true);
	}else{
		campoOrden="idauditoria";
		$("#campoOrden option[value="+campoOrden+"]").attr("selected",true);
	}
	
	//Identificar el numero de elementos para mostrar
	if(recuperarCookie("cantidadamostrarAuditoria")!=null){
		cantidadamostrar=recuperarCookie("cantidadamostrarAuditoria");
		 $("#cantidadamostrar option[value="+cantidadamostrar+"]").attr("selected",true);
	}else{
		cantidadamostrar="20";
		$("#cantidadamostrar option[value="+cantidadamostrar+"]").attr("selected",true);
		
	}
	
	//Identificar el tipo de orden
	if(recuperarCookie("ordenAuditoria")=="asc"){
		orden="ASC"
		$('#asc').attr('checked', true);
		$('#desc').attr('checked', false);
	}else if(recuperarCookie("ordenAuditoria")=="desc"){
		orden="DESC"
		$('#asc').attr('checked', false);
		$('#desc').attr('checked', true);
	}else{
		orden="DESC"
		$('#asc').attr('checked', false);
		$('#desc').attr('checked', true);
	}
	//Mostrar u Ocultar Idauditoria
	if(recuperarCookie("mostrarIdauditoriaAuditoria")=="si"){
		$('.Cidauditoria').show();
		$('#CheckIdauditoria').attr('checked', true);
	}else if(recuperarCookie("mostrarIdauditoriaAuditoria")=="no"){
		$('.Cidauditoria').hide();
		$('#CheckIdauditoria').attr('checked', false);
	}
	//Mostrar u Ocultar Fecha
	if(recuperarCookie("mostrarFechaAuditoria")=="si"){
		$('.Cfecha').show();
		$('#CheckFecha').attr('checked', true);
	}else if(recuperarCookie("mostrarFechaAuditoria")=="no"){
		$('.Cfecha').hide();
		$('#CheckFecha').attr('checked', false);
	}
	//Mostrar u Ocultar Idusuario
	if(recuperarCookie("mostrarIdusuarioAuditoria")=="si"){
		$('.Cidusuario').show();
		$('#CheckIdusuario').attr('checked', true);
	}else if(recuperarCookie("mostrarIdusuarioAuditoria")=="no"){
		$('.Cidusuario').hide();
		$('#CheckIdusuario').attr('checked', false);
	}
	//Mostrar u Ocultar Idfamilia
	if(recuperarCookie("mostrarIdfamiliaAuditoria")=="si"){
		$('.Cidfamilia').show();
		$('#CheckIdfamilia').attr('checked', true);
	}else if(recuperarCookie("mostrarIdfamiliaAuditoria")=="no"){
		$('.Cidfamilia').hide();
		$('#CheckIdfamilia').attr('checked', false);
	}
	//Mostrar u Ocultar Idsucursal
	if(recuperarCookie("mostrarIdsucursalAuditoria")=="si"){
		$('.Cidsucursal').show();
		$('#CheckIdsucursal').attr('checked', true);
	}else if(recuperarCookie("mostrarIdsucursalAuditoria")=="no"){
		$('.Cidsucursal').hide();
		$('#CheckIdsucursal').attr('checked', false);
	}
	//Mostrar u Ocultar Comentarios
	if(recuperarCookie("mostrarComentariosAuditoria")=="si"){
		$('.Ccomentarios').show();
		$('#CheckComentarios').attr('checked', true);
	}else if(recuperarCookie("mostrarComentariosAuditoria")=="no"){
		$('.Ccomentarios').hide();
		$('#CheckComentarios').attr('checked', false);
	}
	//Mostrar u Ocultar Estado
	if(recuperarCookie("mostrarEstadoAuditoria")=="si"){
		$('.Cestado').show();
		$('#CheckEstado').attr('checked', true);
	}else if(recuperarCookie("mostrarEstadoAuditoria")=="no"){
		$('.Cestado').hide();
		$('#CheckEstado').attr('checked', false);
	}
	//Mostrar u Ocultar Composicion
	if(recuperarCookie("mostrarComposicionAuditoria")=="si"){
		$('.Ccomposicion').show();
		$('#CheckComposicion').attr('checked', true);
	}
	if(recuperarCookie("mostrarComposicionAuditoria")=="no"){
		$('.Ccomposicion').hide();
		$('#CheckComposicion').attr('checked', false);
	}
	
	//Elegir el tipo de vista
	if(recuperarCookie("tipoVistaAuditoria")=="tabla"){
		$('.tipoLista').show();
		$('.tipoTabla').hide();
		tipoVista="tabla";
	}else{
		$('.tipoLista').hide();
		$('.tipoTabla').show();
		tipoVista="lista";
	}
	$( ".tipoTabla" ).click(function() {
    	crearCookie("tipoVistaAuditoria", "tabla");
		tipoVista="tabla";
		$(".tipoLista").show();
		$(".tipoTabla").hide();
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$( ".tipoLista" ).click(function() {
    	crearCookie("tipoVistaAuditoria", "lista");
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
		crearCookie("campoOrdenAuditoria", campoOrden);
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$("#cantidadamostrar").change(function(){
		cantidadamostrar = this.value;
		crearCookie("cantidadamostrarAuditoria", cantidadamostrar);
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$( "#asc" ).click(function() {
    	if ($( "#asc" ).is(':checked')){
			crearCookie("ordenAuditoria", "asc");
			orden="ASC"
			load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
		}
	});
	$( "#desc" ).click(function() {
    	if ($( "#desc" ).is(':checked')){
			crearCookie("ordenAuditoria", "desc");
			orden="DESC"
			load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
		}
	});
	$( "#CheckIdauditoria" ).click(function() {
    	if ($( "#CheckIdauditoria" ).is(':checked')){
			crearCookie("mostrarIdauditoriaAuditoria", "si");
			$('.Cidauditoria').show();
		}else{
			crearCookie("mostrarIdauditoriaAuditoria", "no");
			$('.Cidauditoria').hide();
		}	
	});
	$( "#CheckFecha" ).click(function() {
    	if ($( "#CheckFecha" ).is(':checked')){
			crearCookie("mostrarFechaAuditoria", "si");
			$('.Cfecha').show();
		}else{
			crearCookie("mostrarFechaAuditoria", "no");
			$('.Cfecha').hide();
		}	
	});
	$( "#CheckIdusuario" ).click(function() {
    	if ($( "#CheckIdusuario" ).is(':checked')){
			crearCookie("mostrarIdusuarioAuditoria", "si");
			$('.Cidusuario').show();
		}else{
			crearCookie("mostrarIdusuarioAuditoria", "no");
			$('.Cidusuario').hide();
		}	
	});
	$( "#CheckIdfamilia" ).click(function() {
    	if ($( "#CheckIdfamilia" ).is(':checked')){
			crearCookie("mostrarIdfamiliaAuditoria", "si");
			$('.Cidfamilia').show();
		}else{
			crearCookie("mostrarIdfamiliaAuditoria", "no");
			$('.Cidfamilia').hide();
		}	
	});
	$( "#CheckIdsucursal" ).click(function() {
    	if ($( "#CheckIdsucursal" ).is(':checked')){
			crearCookie("mostrarIdsucursalAuditoria", "si");
			$('.Cidsucursal').show();
		}else{
			crearCookie("mostrarIdsucursalAuditoria", "no");
			$('.Cidsucursal').hide();
		}	
	});
	$( "#CheckComentarios" ).click(function() {
    	if ($( "#CheckComentarios" ).is(':checked')){
			crearCookie("mostrarComentariosAuditoria", "si");
			$('.Ccomentarios').show();
		}else{
			crearCookie("mostrarComentariosAuditoria", "no");
			$('.Ccomentarios').hide();
		}	
	});
	$( "#CheckEstado" ).click(function() {
    	if ($( "#CheckEstado" ).is(':checked')){
			crearCookie("mostrarEstadoAuditoria", "si");
			$('.Cestado').show();
		}else{
			crearCookie("mostrarEstadoAuditoria", "no");
			$('.Cestado').hide();
		}	
	});
	$( "#CheckComposicion" ).click(function() {
    	if ($( "#CheckComposicion" ).is(':checked')){
			crearCookie("mostrarComposicionAuditoria", "si");
			$('.Ccomposicion').show();
		}else{
			crearCookie("mostrarComposicionAuditoria", "no");
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