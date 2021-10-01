// JavaScript Document
var orden, campoOrden, cantidadamostrar, paginacion;
orden="DESC";
campoOrden="idempresa";
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
	if(recuperarCookie("campoOrdenEmpresa")!=null){
		campoOrden=recuperarCookie("campoOrdenEmpresa");
		 $("#campoOrden option[value="+campoOrden+"]").attr("selected",true);
	}else{
		campoOrden="idempresa";
		$("#campoOrden option[value="+campoOrden+"]").attr("selected",true);
	}
	
	//Identificar el numero de elementos para mostrar
	if(recuperarCookie("cantidadamostrarEmpresa")!=null){
		cantidadamostrar=recuperarCookie("cantidadamostrarEmpresa");
		 $("#cantidadamostrar option[value="+cantidadamostrar+"]").attr("selected",true);
	}else{
		cantidadamostrar="20";
		$("#cantidadamostrar option[value="+cantidadamostrar+"]").attr("selected",true);
		
	}
	
	//Identificar el tipo de orden
	if(recuperarCookie("ordenEmpresa")=="asc"){
		orden="ASC"
		$('#asc').attr('checked', true);
		$('#desc').attr('checked', false);
	}else if(recuperarCookie("ordenEmpresa")=="desc"){
		orden="DESC"
		$('#asc').attr('checked', false);
		$('#desc').attr('checked', true);
	}else{
		orden="DESC"
		$('#asc').attr('checked', false);
		$('#desc').attr('checked', true);
	}
	//Mostrar u Ocultar Nombrecomercial
	if(recuperarCookie("mostrarNombrecomercialEmpresa")=="si"){
		$('.Cnombrecomercial').show();
		$('#CheckNombrecomercial').attr('checked', true);
	}else if(recuperarCookie("mostrarNombrecomercialEmpresa")=="no"){
		$('.Cnombrecomercial').hide();
		$('#CheckNombrecomercial').attr('checked', false);
	}
	//Mostrar u Ocultar Razonsocial
	if(recuperarCookie("mostrarRazonsocialEmpresa")=="si"){
		$('.Crazonsocial').show();
		$('#CheckRazonsocial').attr('checked', true);
	}else if(recuperarCookie("mostrarRazonsocialEmpresa")=="no"){
		$('.Crazonsocial').hide();
		$('#CheckRazonsocial').attr('checked', false);
	}
	//Mostrar u Ocultar Rfc
	if(recuperarCookie("mostrarRfcEmpresa")=="si"){
		$('.Crfc').show();
		$('#CheckRfc').attr('checked', true);
	}else if(recuperarCookie("mostrarRfcEmpresa")=="no"){
		$('.Crfc').hide();
		$('#CheckRfc').attr('checked', false);
	}
	//Mostrar u Ocultar Domiciliofiscal
	if(recuperarCookie("mostrarDomiciliofiscalEmpresa")=="si"){
		$('.Cdomiciliofiscal').show();
		$('#CheckDomiciliofiscal').attr('checked', true);
	}else if(recuperarCookie("mostrarDomiciliofiscalEmpresa")=="no"){
		$('.Cdomiciliofiscal').hide();
		$('#CheckDomiciliofiscal').attr('checked', false);
	}
	//Mostrar u Ocultar Regimen
	if(recuperarCookie("mostrarRegimenEmpresa")=="si"){
		$('.Cregimen').show();
		$('#CheckRegimen').attr('checked', true);
	}else if(recuperarCookie("mostrarRegimenEmpresa")=="no"){
		$('.Cregimen').hide();
		$('#CheckRegimen').attr('checked', false);
	}
	//Mostrar u Ocultar Telefono
	if(recuperarCookie("mostrarTelefonoEmpresa")=="si"){
		$('.Ctelefono').show();
		$('#CheckTelefono').attr('checked', true);
	}else if(recuperarCookie("mostrarTelefonoEmpresa")=="no"){
		$('.Ctelefono').hide();
		$('#CheckTelefono').attr('checked', false);
	}
	//Mostrar u Ocultar Email
	if(recuperarCookie("mostrarEmailEmpresa")=="si"){
		$('.Cemail').show();
		$('#CheckEmail').attr('checked', true);
	}else if(recuperarCookie("mostrarEmailEmpresa")=="no"){
		$('.Cemail').hide();
		$('#CheckEmail').attr('checked', false);
	}
	//Mostrar u Ocultar Licenciasssa
	if(recuperarCookie("mostrarLicenciasssaEmpresa")=="si"){
		$('.Clicenciasssa').show();
		$('#CheckLicenciasssa').attr('checked', true);
	}else if(recuperarCookie("mostrarLicenciasssaEmpresa")=="no"){
		$('.Clicenciasssa').hide();
		$('#CheckLicenciasssa').attr('checked', false);
	}
	//Mostrar u Ocultar Composicion
	if(recuperarCookie("mostrarComposicionEmpresa")=="si"){
		$('.Ccomposicion').show();
		$('#CheckComposicion').attr('checked', true);
	}
	if(recuperarCookie("mostrarComposicionEmpresa")=="no"){
		$('.Ccomposicion').hide();
		$('#CheckComposicion').attr('checked', false);
	}
	
	//Elegir el tipo de vista
	if(recuperarCookie("tipoVistaEmpresa")=="tabla"){
		$('.tipoLista').show();
		$('.tipoTabla').hide();
		tipoVista="tabla";
	}else{
		$('.tipoLista').hide();
		$('.tipoTabla').show();
		tipoVista="lista";
	}
	$( ".tipoTabla" ).click(function() {
    	crearCookie("tipoVistaEmpresa", "tabla");
		tipoVista="tabla";
		$(".tipoLista").show();
		$(".tipoTabla").hide();
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$( ".tipoLista" ).click(function() {
    	crearCookie("tipoVistaEmpresa", "lista");
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
		crearCookie("campoOrdenEmpresa", campoOrden);
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$("#cantidadamostrar").change(function(){
		cantidadamostrar = this.value;
		crearCookie("cantidadamostrarEmpresa", cantidadamostrar);
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$( "#asc" ).click(function() {
    	if ($( "#asc" ).is(':checked')){
			crearCookie("ordenEmpresa", "asc");
			orden="ASC"
			load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
		}
	});
	$( "#desc" ).click(function() {
    	if ($( "#desc" ).is(':checked')){
			crearCookie("ordenEmpresa", "desc");
			orden="DESC"
			load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
		}
	});
	$( "#CheckNombrecomercial" ).click(function() {
    	if ($( "#CheckNombrecomercial" ).is(':checked')){
			crearCookie("mostrarNombrecomercialEmpresa", "si");
			$('.Cnombrecomercial').show();
		}else{
			crearCookie("mostrarNombrecomercialEmpresa", "no");
			$('.Cnombrecomercial').hide();
		}	
	});
	$( "#CheckRazonsocial" ).click(function() {
    	if ($( "#CheckRazonsocial" ).is(':checked')){
			crearCookie("mostrarRazonsocialEmpresa", "si");
			$('.Crazonsocial').show();
		}else{
			crearCookie("mostrarRazonsocialEmpresa", "no");
			$('.Crazonsocial').hide();
		}	
	});
	$( "#CheckRfc" ).click(function() {
    	if ($( "#CheckRfc" ).is(':checked')){
			crearCookie("mostrarRfcEmpresa", "si");
			$('.Crfc').show();
		}else{
			crearCookie("mostrarRfcEmpresa", "no");
			$('.Crfc').hide();
		}	
	});
	$( "#CheckDomiciliofiscal" ).click(function() {
    	if ($( "#CheckDomiciliofiscal" ).is(':checked')){
			crearCookie("mostrarDomiciliofiscalEmpresa", "si");
			$('.Cdomiciliofiscal').show();
		}else{
			crearCookie("mostrarDomiciliofiscalEmpresa", "no");
			$('.Cdomiciliofiscal').hide();
		}	
	});
	$( "#CheckRegimen" ).click(function() {
    	if ($( "#CheckRegimen" ).is(':checked')){
			crearCookie("mostrarRegimenEmpresa", "si");
			$('.Cregimen').show();
		}else{
			crearCookie("mostrarRegimenEmpresa", "no");
			$('.Cregimen').hide();
		}	
	});
	$( "#CheckTelefono" ).click(function() {
    	if ($( "#CheckTelefono" ).is(':checked')){
			crearCookie("mostrarTelefonoEmpresa", "si");
			$('.Ctelefono').show();
		}else{
			crearCookie("mostrarTelefonoEmpresa", "no");
			$('.Ctelefono').hide();
		}	
	});
	$( "#CheckEmail" ).click(function() {
    	if ($( "#CheckEmail" ).is(':checked')){
			crearCookie("mostrarEmailEmpresa", "si");
			$('.Cemail').show();
		}else{
			crearCookie("mostrarEmailEmpresa", "no");
			$('.Cemail').hide();
		}	
	});
	$( "#CheckLicenciasssa" ).click(function() {
    	if ($( "#CheckLicenciasssa" ).is(':checked')){
			crearCookie("mostrarLicenciasssaEmpresa", "si");
			$('.Clicenciasssa').show();
		}else{
			crearCookie("mostrarLicenciasssaEmpresa", "no");
			$('.Clicenciasssa').hide();
		}	
	});
	$( "#CheckComposicion" ).click(function() {
    	if ($( "#CheckComposicion" ).is(':checked')){
			crearCookie("mostrarComposicionEmpresa", "si");
			$('.Ccomposicion').show();
		}else{
			crearCookie("mostrarComposicionEmpresa", "no");
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