// JavaScript Document
var orden, campoOrden, cantidadamostrar, paginacion;
orden="DESC";
campoOrden="idcliente";
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
	if(recuperarCookie("campoOrdenCliente")!=null){
		campoOrden=recuperarCookie("campoOrdenCliente");
		 $("#campoOrden option[value="+campoOrden+"]").attr("selected",true);
	}else{
		campoOrden="idcliente";
		$("#campoOrden option[value="+campoOrden+"]").attr("selected",true);
	}
	
	//Identificar el numero de elementos para mostrar
	if(recuperarCookie("cantidadamostrarCliente")!=null){
		cantidadamostrar=recuperarCookie("cantidadamostrarCliente");
		 $("#cantidadamostrar option[value="+cantidadamostrar+"]").attr("selected",true);
	}else{
		cantidadamostrar="20";
		$("#cantidadamostrar option[value="+cantidadamostrar+"]").attr("selected",true);
		
	}
	
	//Identificar el tipo de orden
	if(recuperarCookie("ordenCliente")=="asc"){
		orden="ASC"
		$('#asc').attr('checked', true);
		$('#desc').attr('checked', false);
	}else if(recuperarCookie("ordenCliente")=="desc"){
		orden="DESC"
		$('#asc').attr('checked', false);
		$('#desc').attr('checked', true);
	}else{
		orden="DESC"
		$('#asc').attr('checked', false);
		$('#desc').attr('checked', true);
	}
	//Mostrar u Ocultar Idcliente
	if(recuperarCookie("mostrarIdclienteCliente")=="si"){
		$('.Cidcliente').show();
		$('#CheckIdcliente').attr('checked', true);
	}else if(recuperarCookie("mostrarIdclienteCliente")=="no"){
		$('.Cidcliente').hide();
		$('#CheckIdcliente').attr('checked', false);
	}else{
		$('.Cidcliente').hide();
		$('#CheckIdcliente').attr('checked', false);
	}
	//Mostrar u Ocultar Rfc
	if(recuperarCookie("mostrarRfcCliente")=="si"){
		$('.Crfc').show();
		$('#CheckRfc').attr('checked', true);
	}else if(recuperarCookie("mostrarRfcCliente")=="no"){
		$('.Crfc').hide();
		$('#CheckRfc').attr('checked', false);
	}
	//Mostrar u Ocultar Nombre
	if(recuperarCookie("mostrarNombreCliente")=="si"){
		$('.Cnombre').show();
		$('#CheckNombre').attr('checked', true);
	}else if(recuperarCookie("mostrarNombreCliente")=="no"){
		$('.Cnombre').hide();
		$('#CheckNombre').attr('checked', false);
	}
	//Mostrar u Ocultar Nic
	if(recuperarCookie("mostrarNicCliente")=="si"){
		$('.Cnic').show();
		$('#CheckNic').attr('checked', true);
	}else if(recuperarCookie("mostrarNicCliente")=="no"){
		$('.Cnic').hide();
		$('#CheckNic').attr('checked', false);
	}
	//Mostrar u Ocultar Limitecredito
	if(recuperarCookie("mostrarLimitecreditoCliente")=="si"){
		
		$('.Climitecredito').show();
		$('#CheckLimitecredito').attr('checked', true);
	}else if(recuperarCookie("mostrarLimitecreditoCliente")=="no"){
		$('.Climitecredito').hide();
		$('#CheckLimitecredito').attr('checked', false);
	}else{
		$('.Climitecredito').hide();
		$('#CheckLimitecredito').attr('checked', false);
	}
	
	//Mostrar u Ocultar Diascredito
	if(recuperarCookie("mostrarDiascreditoCliente")=="si"){
		$('.Cdiascredito').show();
		$('#CheckDiascredito').attr('checked', true);
	}else if(recuperarCookie("mostrarDiascreditoCliente")=="no"){
		$('.Cdiascredito').hide();
		$('#CheckDiascredito').attr('checked', false);
	}else{
		$('.Cdiascredito').hide();
		$('#CheckDiascredito').attr('checked', false);
	}
	//Mostrar u Ocultar Saldo
	if(recuperarCookie("mostrarSaldoCliente")=="si"){
		$('.Csaldo').show();
		$('#CheckSaldo').attr('checked', true);
	}else if(recuperarCookie("mostrarSaldoCliente")=="no"){
		$('.Csaldo').hide();
		$('#CheckSaldo').attr('checked', false);
	}
	//Mostrar u Ocultar Nombrecontacto
	if(recuperarCookie("mostrarNombrecontactoCliente")=="si"){
		$('.Cnombrecontacto').show();
		$('#CheckNombrecontacto').attr('checked', true);
	}else if(recuperarCookie("mostrarNombrecontactoCliente")=="no"){
		$('.Cnombrecontacto').hide();
		$('#CheckNombrecontacto').attr('checked', false);
	}
	//Mostrar u Ocultar Correocontacto
	if(recuperarCookie("mostrarCorreocontactoCliente")=="si"){
		$('.Ccorreocontacto').show();
		$('#CheckCorreocontacto').attr('checked', true);
	}else if(recuperarCookie("mostrarCorreocontactoCliente")=="no"){
		$('.Ccorreocontacto').hide();
		$('#CheckCorreocontacto').attr('checked', false);
	}
	//Mostrar u Ocultar Telefonocontacto
	if(recuperarCookie("mostrarTelefonocontactoCliente")=="si"){
		$('.Ctelefonocontacto').show();
		$('#CheckTelefonocontacto').attr('checked', true);
	}else if(recuperarCookie("mostrarTelefonocontactoCliente")=="no"){
		$('.Ctelefonocontacto').hide();
		$('#CheckTelefonocontacto').attr('checked', false);
	}
	//Mostrar u Ocultar Composicion
	if(recuperarCookie("mostrarComposicionCliente")=="si"){
		$('.Ccomposicion').show();
		$('#CheckComposicion').attr('checked', true);
	}
	if(recuperarCookie("mostrarComposicionCliente")=="no"){
		$('.Ccomposicion').hide();
		$('#CheckComposicion').attr('checked', false);
	}
	
	//Elegir el tipo de vista
	if(recuperarCookie("tipoVistaCliente")=="tabla"){
		$('.tipoLista').show();
		$('.tipoTabla').hide();
		tipoVista="tabla";
	}else{
		$('.tipoLista').hide();
		$('.tipoTabla').show();
		tipoVista="lista";
	}
	$( ".tipoTabla" ).click(function() {
    	crearCookie("tipoVistaCliente", "tabla");
		tipoVista="tabla";
		$(".tipoLista").show();
		$(".tipoTabla").hide();
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$( ".tipoLista" ).click(function() {
    	crearCookie("tipoVistaCliente", "lista");
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
		crearCookie("campoOrdenCliente", campoOrden);
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$("#cantidadamostrar").change(function(){
		cantidadamostrar = this.value;
		crearCookie("cantidadamostrarCliente", cantidadamostrar);
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$( "#asc" ).click(function() {
    	if ($( "#asc" ).is(':checked')){
			crearCookie("ordenCliente", "asc");
			orden="ASC"
			load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
		}
	});
	$( "#desc" ).click(function() {
    	if ($( "#desc" ).is(':checked')){
			crearCookie("ordenCliente", "desc");
			orden="DESC"
			load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
		}
	});
	$( "#CheckIdcliente" ).click(function() {
    	if ($( "#CheckIdcliente" ).is(':checked')){
			crearCookie("mostrarIdclienteCliente", "si");
			$('.Cidcliente').show();
		}else{
			crearCookie("mostrarIdclienteCliente", "no");
			$('.Cidcliente').hide();
		}	
	});
	$( "#CheckRfc" ).click(function() {
    	if ($( "#CheckRfc" ).is(':checked')){
			crearCookie("mostrarRfcCliente", "si");
			$('.Crfc').show();
		}else{
			crearCookie("mostrarRfcCliente", "no");
			$('.Crfc').hide();
		}	
	});
	$( "#CheckNombre" ).click(function() {
    	if ($( "#CheckNombre" ).is(':checked')){
			crearCookie("mostrarNombreCliente", "si");
			$('.Cnombre').show();
		}else{
			crearCookie("mostrarNombreCliente", "no");
			$('.Cnombre').hide();
		}	
	});
	$( "#CheckNic" ).click(function() {
    	if ($( "#CheckNic" ).is(':checked')){
			crearCookie("mostrarNicCliente", "si");
			$('.Cnic').show();
		}else{
			crearCookie("mostrarNicCliente", "no");
			$('.Cnic').hide();
		}	
	});
	$( "#CheckLimitecredito" ).click(function() {
    	if ($( "#CheckLimitecredito" ).is(':checked')){
			crearCookie("mostrarLimitecreditoCliente", "si");
			$('.Climitecredito').show();
		}else{
			crearCookie("mostrarLimitecreditoCliente", "no");
			$('.Climitecredito').hide();
		}	
	});
	$( "#CheckDiascredito" ).click(function() {
    	if ($( "#CheckDiascredito" ).is(':checked')){
			crearCookie("mostrarDiascreditoCliente", "si");
			$('.Cdiascredito').show();
		}else{
			crearCookie("mostrarDiascreditoCliente", "no");
			$('.Cdiascredito').hide();
		}	
	});
	$( "#CheckSaldo" ).click(function() {
    	if ($( "#CheckSaldo" ).is(':checked')){
			crearCookie("mostrarSaldoCliente", "si");
			$('.Csaldo').show();
		}else{
			crearCookie("mostrarSaldoCliente", "no");
			$('.Csaldo').hide();
		}	
	});
	$( "#CheckNombrecontacto" ).click(function() {
    	if ($( "#CheckNombrecontacto" ).is(':checked')){
			crearCookie("mostrarNombrecontactoCliente", "si");
			$('.Cnombrecontacto').show();
		}else{
			crearCookie("mostrarNombrecontactoCliente", "no");
			$('.Cnombrecontacto').hide();
		}	
	});
	$( "#CheckCorreocontacto" ).click(function() {
    	if ($( "#CheckCorreocontacto" ).is(':checked')){
			crearCookie("mostrarCorreocontactoCliente", "si");
			$('.Ccorreocontacto').show();
		}else{
			crearCookie("mostrarCorreocontactoCliente", "no");
			$('.Ccorreocontacto').hide();
		}	
	});
	$( "#CheckTelefonocontacto" ).click(function() {
    	if ($( "#CheckTelefonocontacto" ).is(':checked')){
			crearCookie("mostrarTelefonocontactoCliente", "si");
			$('.Ctelefonocontacto').show();
		}else{
			crearCookie("mostrarTelefonocontactoCliente", "no");
			$('.Ctelefonocontacto').hide();
		}	
	});
	$( "#CheckComposicion" ).click(function() {
    	if ($( "#CheckComposicion" ).is(':checked')){
			crearCookie("mostrarComposicionCliente", "si");
			$('.Ccomposicion').show();
		}else{
			crearCookie("mostrarComposicionCliente", "no");
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
	
	$("#botonAceptar").click(function(){ 
		var variables=$("#formularioProductos").serialize();
		guardarProductosAutorizados(variables);
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

function guardarProductosAutorizados(variables){
		//$("#botonGuardar").hide();
		//$("#botonSave").hide();
		//$("#loading").show();
		$.ajax({
			url: 'guardarAutorizarProductos.php',
			type: "POST",
			data: "submit=&"+variables, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				//$("#botonGuardar").show();
				//$("#botonSave").show();
				//$("#loading").hide();
				mostrarMensaje(mensaje);
			}
		});
		return false;
}

function mostrarMensaje(mensaje,ids, accion){
	//alert(mensaje);
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