// JavaScript Document
var orden, campoOrden, cantidadamostrar, paginacion;
orden="DESC";
campoOrden="idcuentacorreo";
iniciar="0";
cantidadamostrar="20";
paginacion=0;
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
	if(recuperarCookie("campoOrdenCuentacorreo")!=null){
		campoOrden=recuperarCookie("campoOrdenCuentacorreo");
		 $("#campoOrden option[value="+campoOrden+"]").attr("selected",true);
	}else{
		campoOrden="idcuentacorreo";
		$("#campoOrden option[value="+campoOrden+"]").attr("selected",true);
	}
	
	//Identificar el numero de elementos para mostrar
	if(recuperarCookie("cantidadamostrarCuentacorreo")!=null){
		cantidadamostrar=recuperarCookie("cantidadamostrarCuentacorreo");
		 $("#cantidadamostrar option[value="+cantidadamostrar+"]").attr("selected",true);
	}else{
		cantidadamostrar="20";
		$("#cantidadamostrar option[value="+cantidadamostrar+"]").attr("selected",true);
		
	}
	
	//Identificar el tipo de orden
	if(recuperarCookie("ordenCuentacorreo")=="asc"){
		orden="ASC"
		$('#asc').attr('checked', true);
		$('#desc').attr('checked', false);
	}else if(recuperarCookie("ordenCuentacorreo")=="desc"){
		orden="DESC"
		$('#asc').attr('checked', false);
		$('#desc').attr('checked', true);
	}else{
		orden="DESC"
		$('#asc').attr('checked', false);
		$('#desc').attr('checked', true);
	}
	//Mostrar u Ocultar Idcuentacorreo
	if(recuperarCookie("mostrarIdcuentacorreoCuentacorreo")=="si"){
		$('.Cidcuentacorreo').show();
		$('#CheckIdcuentacorreo').attr('checked', true);
	}else if(recuperarCookie("mostrarIdcuentacorreoCuentacorreo")=="no"){
		$('.Cidcuentacorreo').hide();
		$('#CheckIdcuentacorreo').attr('checked', false);
	}
	//Mostrar u Ocultar Usuario
	if(recuperarCookie("mostrarUsuarioCuentacorreo")=="si"){
		$('.Cusuario').show();
		$('#CheckUsuario').attr('checked', true);
	}else if(recuperarCookie("mostrarUsuarioCuentacorreo")=="no"){
		$('.Cusuario').hide();
		$('#CheckUsuario').attr('checked', false);
	}
	//Mostrar u Ocultar Servidorsmtp
	if(recuperarCookie("mostrarServidorsmtpCuentacorreo")=="si"){
		$('.Cservidorsmtp').show();
		$('#CheckServidorsmtp').attr('checked', true);
	}else if(recuperarCookie("mostrarServidorsmtpCuentacorreo")=="no"){
		$('.Cservidorsmtp').hide();
		$('#CheckServidorsmtp').attr('checked', false);
	}
	//Mostrar u Ocultar Servidorpop
	if(recuperarCookie("mostrarServidorpopCuentacorreo")=="si"){
		$('.Cservidorpop').show();
		$('#CheckServidorpop').attr('checked', true);
	}else if(recuperarCookie("mostrarServidorpopCuentacorreo")=="no"){
		$('.Cservidorpop').hide();
		$('#CheckServidorpop').attr('checked', false);
	}
	//Mostrar u Ocultar Puertosmtp
	if(recuperarCookie("mostrarPuertosmtpCuentacorreo")=="si"){
		$('.Cpuertosmtp').show();
		$('#CheckPuertosmtp').attr('checked', true);
	}else if(recuperarCookie("mostrarPuertosmtpCuentacorreo")=="no"){
		$('.Cpuertosmtp').hide();
		$('#CheckPuertosmtp').attr('checked', false);
	}
	//Mostrar u Ocultar Puertopop
	if(recuperarCookie("mostrarPuertopopCuentacorreo")=="si"){
		$('.Cpuertopop').show();
		$('#CheckPuertopop').attr('checked', true);
	}else if(recuperarCookie("mostrarPuertopopCuentacorreo")=="no"){
		$('.Cpuertopop').hide();
		$('#CheckPuertopop').attr('checked', false);
	}
	//Mostrar u Ocultar Autenticacionssl
	if(recuperarCookie("mostrarAutenticacionsslCuentacorreo")=="si"){
		$('.Cautenticacionssl').show();
		$('#CheckAutenticacionssl').attr('checked', true);
	}else if(recuperarCookie("mostrarAutenticacionsslCuentacorreo")=="no"){
		$('.Cautenticacionssl').hide();
		$('#CheckAutenticacionssl').attr('checked', false);
	}
	//Mostrar u Ocultar Composicion
	if(recuperarCookie("mostrarComposicionCuentacorreo")=="si"){
		$('.Ccomposicion').show();
		$('#CheckComposicion').attr('checked', true);
	}
	if(recuperarCookie("mostrarComposicionCuentacorreo")=="no"){
		$('.Ccomposicion').hide();
		$('#CheckComposicion').attr('checked', false);
	}
	
	//Elegir el tipo de vista
	if(recuperarCookie("tipoVistaCuentacorreo")=="tabla"){
		$('.tipoLista').show();
		$('.tipoTabla').hide();
		tipoVista="tabla";
	}else{
		$('.tipoLista').hide();
		$('.tipoTabla').show();
		tipoVista="lista";
	}
	$( ".tipoTabla" ).click(function() {
    	crearCookie("tipoVistaCuentacorreo", "tabla");
		tipoVista="tabla";
		$(".tipoLista").show();
		$(".tipoTabla").hide();
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$( ".tipoLista" ).click(function() {
    	crearCookie("tipoVistaCuentacorreo", "lista");
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
		crearCookie("campoOrdenCuentacorreo", campoOrden);
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$("#cantidadamostrar").change(function(){
		cantidadamostrar = this.value;
		crearCookie("cantidadamostrarCuentacorreo", cantidadamostrar);
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$( "#asc" ).click(function() {
    	if ($( "#asc" ).is(':checked')){
			crearCookie("ordenCuentacorreo", "asc");
			orden="ASC"
			load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
		}
	});
	$( "#desc" ).click(function() {
    	if ($( "#desc" ).is(':checked')){
			crearCookie("ordenCuentacorreo", "desc");
			orden="DESC"
			load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
		}
	});
	$( "#CheckIdcuentacorreo" ).click(function() {
    	if ($( "#CheckIdcuentacorreo" ).is(':checked')){
			crearCookie("mostrarIdcuentacorreoCuentacorreo", "si");
			$('.Cidcuentacorreo').show();
		}else{
			crearCookie("mostrarIdcuentacorreoCuentacorreo", "no");
			$('.Cidcuentacorreo').hide();
		}	
	});
	$( "#CheckUsuario" ).click(function() {
    	if ($( "#CheckUsuario" ).is(':checked')){
			crearCookie("mostrarUsuarioCuentacorreo", "si");
			$('.Cusuario').show();
		}else{
			crearCookie("mostrarUsuarioCuentacorreo", "no");
			$('.Cusuario').hide();
		}	
	});
	$( "#CheckServidorsmtp" ).click(function() {
    	if ($( "#CheckServidorsmtp" ).is(':checked')){
			crearCookie("mostrarServidorsmtpCuentacorreo", "si");
			$('.Cservidorsmtp').show();
		}else{
			crearCookie("mostrarServidorsmtpCuentacorreo", "no");
			$('.Cservidorsmtp').hide();
		}	
	});
	$( "#CheckServidorpop" ).click(function() {
    	if ($( "#CheckServidorpop" ).is(':checked')){
			crearCookie("mostrarServidorpopCuentacorreo", "si");
			$('.Cservidorpop').show();
		}else{
			crearCookie("mostrarServidorpopCuentacorreo", "no");
			$('.Cservidorpop').hide();
		}	
	});
	$( "#CheckPuertosmtp" ).click(function() {
    	if ($( "#CheckPuertosmtp" ).is(':checked')){
			crearCookie("mostrarPuertosmtpCuentacorreo", "si");
			$('.Cpuertosmtp').show();
		}else{
			crearCookie("mostrarPuertosmtpCuentacorreo", "no");
			$('.Cpuertosmtp').hide();
		}	
	});
	$( "#CheckPuertopop" ).click(function() {
    	if ($( "#CheckPuertopop" ).is(':checked')){
			crearCookie("mostrarPuertopopCuentacorreo", "si");
			$('.Cpuertopop').show();
		}else{
			crearCookie("mostrarPuertopopCuentacorreo", "no");
			$('.Cpuertopop').hide();
		}	
	});
	$( "#CheckAutenticacionssl" ).click(function() {
    	if ($( "#CheckAutenticacionssl" ).is(':checked')){
			crearCookie("mostrarAutenticacionsslCuentacorreo", "si");
			$('.Cautenticacionssl').show();
		}else{
			crearCookie("mostrarAutenticacionsslCuentacorreo", "no");
			$('.Cautenticacionssl').hide();
		}	
	});
	$( "#CheckComposicion" ).click(function() {
    	if ($( "#CheckComposicion" ).is(':checked')){
			crearCookie("mostrarComposicionCuentacorreo", "si");
			$('.Ccomposicion').show();
		}else{
			crearCookie("mostrarComposicionCuentacorreo", "no");
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