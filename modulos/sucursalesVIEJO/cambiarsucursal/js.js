// JavaScript Document
var orden, campoOrden, cantidadamostrar, paginacion;
orden="DESC";
campoOrden="idsucursal";
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
	if(recuperarCookie("campoOrdenSucursal")!=null){
		campoOrden=recuperarCookie("campoOrdenSucursal");
		 $("#campoOrden option[value="+campoOrden+"]").attr("selected",true);
	}else{
		campoOrden="idsucursal";
		$("#campoOrden option[value="+campoOrden+"]").attr("selected",true);
	}
	
	//Identificar el numero de elementos para mostrar
	if(recuperarCookie("cantidadamostrarSucursal")!=null){
		cantidadamostrar=recuperarCookie("cantidadamostrarSucursal");
		 $("#cantidadamostrar option[value="+cantidadamostrar+"]").attr("selected",true);
	}else{
		cantidadamostrar="20";
		$("#cantidadamostrar option[value="+cantidadamostrar+"]").attr("selected",true);
		
	}
	
	//Identificar el tipo de orden
	if(recuperarCookie("ordenSucursal")=="asc"){
		orden="ASC"
		$('#asc').attr('checked', true);
		$('#desc').attr('checked', false);
	}else if(recuperarCookie("ordenSucursal")=="desc"){
		orden="DESC"
		$('#asc').attr('checked', false);
		$('#desc').attr('checked', true);
	}else{
		orden="DESC"
		$('#asc').attr('checked', false);
		$('#desc').attr('checked', true);
	}
	//Mostrar u Ocultar Idsucursal
	if(recuperarCookie("mostrarIdsucursalSucursal")=="si"){
		$('.Cidsucursal').show();
		$('#CheckIdsucursal').attr('checked', true);
	}else if(recuperarCookie("mostrarIdsucursalSucursal")=="no"){
		$('.Cidsucursal').hide();
		$('#CheckIdsucursal').attr('checked', false);
	}
	//Mostrar u Ocultar Nombre
	if(recuperarCookie("mostrarNombreSucursal")=="si"){
		$('.Cnombre').show();
		$('#CheckNombre').attr('checked', true);
	}else if(recuperarCookie("mostrarNombreSucursal")=="no"){
		$('.Cnombre').hide();
		$('#CheckNombre').attr('checked', false);
	}
	//Mostrar u Ocultar Calle
	if(recuperarCookie("mostrarCalleSucursal")=="si"){
		$('.Ccalle').show();
		$('#CheckCalle').attr('checked', true);
	}else if(recuperarCookie("mostrarCalleSucursal")=="no"){
		$('.Ccalle').hide();
		$('#CheckCalle').attr('checked', false);
	}
	//Mostrar u Ocultar Numero
	if(recuperarCookie("mostrarNumeroSucursal")=="si"){
		$('.Cnumero').show();
		$('#CheckNumero').attr('checked', true);
	}else if(recuperarCookie("mostrarNumeroSucursal")=="no"){
		$('.Cnumero').hide();
		$('#CheckNumero').attr('checked', false);
	}
	//Mostrar u Ocultar Colonia
	if(recuperarCookie("mostrarColoniaSucursal")=="si"){
		$('.Ccolonia').show();
		$('#CheckColonia').attr('checked', true);
	}else if(recuperarCookie("mostrarColoniaSucursal")=="no"){
		$('.Ccolonia').hide();
		$('#CheckColonia').attr('checked', false);
	}
	//Mostrar u Ocultar Cp
	if(recuperarCookie("mostrarCpSucursal")=="si"){
		$('.Ccp').show();
		$('#CheckCp').attr('checked', true);
	}else if(recuperarCookie("mostrarCpSucursal")=="no"){
		$('.Ccp').hide();
		$('#CheckCp').attr('checked', false);
	}
	//Mostrar u Ocultar Ciudad
	if(recuperarCookie("mostrarCiudadSucursal")=="si"){
		$('.Cciudad').show();
		$('#CheckCiudad').attr('checked', true);
	}else if(recuperarCookie("mostrarCiudadSucursal")=="no"){
		$('.Cciudad').hide();
		$('#CheckCiudad').attr('checked', false);
	}
	//Mostrar u Ocultar Estado
	if(recuperarCookie("mostrarEstadoSucursal")=="si"){
		$('.Cestado').show();
		$('#CheckEstado').attr('checked', true);
	}else if(recuperarCookie("mostrarEstadoSucursal")=="no"){
		$('.Cestado').hide();
		$('#CheckEstado').attr('checked', false);
	}
	//Mostrar u Ocultar Telefonocontacto
	if(recuperarCookie("mostrarTelefonocontactoSucursal")=="si"){
		$('.Ctelefonocontacto').show();
		$('#CheckTelefonocontacto').attr('checked', true);
	}else if(recuperarCookie("mostrarTelefonocontactoSucursal")=="no"){
		$('.Ctelefonocontacto').hide();
		$('#CheckTelefonocontacto').attr('checked', false);
	}
	//Mostrar u Ocultar Licenciassa
	if(recuperarCookie("mostrarLicenciassaSucursal")=="si"){
		$('.Clicenciassa').show();
		$('#CheckLicenciassa').attr('checked', true);
	}else if(recuperarCookie("mostrarLicenciassaSucursal")=="no"){
		$('.Clicenciassa').hide();
		$('#CheckLicenciassa').attr('checked', false);
	}
	//Mostrar u Ocultar Serie
	if(recuperarCookie("mostrarSerieSucursal")=="si"){
		$('.Cserie').show();
		$('#CheckSerie').attr('checked', true);
	}else if(recuperarCookie("mostrarSerieSucursal")=="no"){
		$('.Cserie').hide();
		$('#CheckSerie').attr('checked', false);
	}
	//Mostrar u Ocultar Folio
	if(recuperarCookie("mostrarFolioSucursal")=="si"){
		$('.Cfolio').show();
		$('#CheckFolio').attr('checked', true);
	}else if(recuperarCookie("mostrarFolioSucursal")=="no"){
		$('.Cfolio').hide();
		$('#CheckFolio').attr('checked', false);
	}
	//Mostrar u Ocultar Idcuentacorreo
	if(recuperarCookie("mostrarIdcuentacorreoSucursal")=="si"){
		$('.Cidcuentacorreo').show();
		$('#CheckIdcuentacorreo').attr('checked', true);
	}else if(recuperarCookie("mostrarIdcuentacorreoSucursal")=="no"){
		$('.Cidcuentacorreo').hide();
		$('#CheckIdcuentacorreo').attr('checked', false);
	}
	//Mostrar u Ocultar Archivofirma
	if(recuperarCookie("mostrarArchivofirmaSucursal")=="si"){
		$('.Carchivofirma').show();
		$('#CheckArchivofirma').attr('checked', true);
	}else if(recuperarCookie("mostrarArchivofirmaSucursal")=="no"){
		$('.Carchivofirma').hide();
		$('#CheckArchivofirma').attr('checked', false);
	}
	//Mostrar u Ocultar Composicion
	if(recuperarCookie("mostrarComposicionSucursal")=="si"){
		$('.Ccomposicion').show();
		$('#CheckComposicion').attr('checked', true);
	}
	if(recuperarCookie("mostrarComposicionSucursal")=="no"){
		$('.Ccomposicion').hide();
		$('#CheckComposicion').attr('checked', false);
	}
	
	//Elegir el tipo de vista
	if(recuperarCookie("tipoVistaSucursal")=="tabla"){
		$('.tipoLista').show();
		$('.tipoTabla').hide();
		tipoVista="tabla";
	}else{
		$('.tipoLista').hide();
		$('.tipoTabla').show();
		tipoVista="lista";
	}
	$( ".tipoTabla" ).click(function() {
    	crearCookie("tipoVistaSucursal", "tabla");
		tipoVista="tabla";
		$(".tipoLista").show();
		$(".tipoTabla").hide();
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$( ".tipoLista" ).click(function() {
    	crearCookie("tipoVistaSucursal", "lista");
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
		crearCookie("campoOrdenSucursal", campoOrden);
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$("#cantidadamostrar").change(function(){
		cantidadamostrar = this.value;
		crearCookie("cantidadamostrarSucursal", cantidadamostrar);
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$( "#asc" ).click(function() {
    	if ($( "#asc" ).is(':checked')){
			crearCookie("ordenSucursal", "asc");
			orden="ASC"
			load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
		}
	});
	$( "#desc" ).click(function() {
    	if ($( "#desc" ).is(':checked')){
			crearCookie("ordenSucursal", "desc");
			orden="DESC"
			load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
		}
	});
	$( "#CheckIdsucursal" ).click(function() {
    	if ($( "#CheckIdsucursal" ).is(':checked')){
			crearCookie("mostrarIdsucursalSucursal", "si");
			$('.Cidsucursal').show();
		}else{
			crearCookie("mostrarIdsucursalSucursal", "no");
			$('.Cidsucursal').hide();
		}	
	});
	$( "#CheckNombre" ).click(function() {
    	if ($( "#CheckNombre" ).is(':checked')){
			crearCookie("mostrarNombreSucursal", "si");
			$('.Cnombre').show();
		}else{
			crearCookie("mostrarNombreSucursal", "no");
			$('.Cnombre').hide();
		}	
	});
	$( "#CheckCalle" ).click(function() {
    	if ($( "#CheckCalle" ).is(':checked')){
			crearCookie("mostrarCalleSucursal", "si");
			$('.Ccalle').show();
		}else{
			crearCookie("mostrarCalleSucursal", "no");
			$('.Ccalle').hide();
		}	
	});
	$( "#CheckNumero" ).click(function() {
    	if ($( "#CheckNumero" ).is(':checked')){
			crearCookie("mostrarNumeroSucursal", "si");
			$('.Cnumero').show();
		}else{
			crearCookie("mostrarNumeroSucursal", "no");
			$('.Cnumero').hide();
		}	
	});
	$( "#CheckColonia" ).click(function() {
    	if ($( "#CheckColonia" ).is(':checked')){
			crearCookie("mostrarColoniaSucursal", "si");
			$('.Ccolonia').show();
		}else{
			crearCookie("mostrarColoniaSucursal", "no");
			$('.Ccolonia').hide();
		}	
	});
	$( "#CheckCp" ).click(function() {
    	if ($( "#CheckCp" ).is(':checked')){
			crearCookie("mostrarCpSucursal", "si");
			$('.Ccp').show();
		}else{
			crearCookie("mostrarCpSucursal", "no");
			$('.Ccp').hide();
		}	
	});
	$( "#CheckCiudad" ).click(function() {
    	if ($( "#CheckCiudad" ).is(':checked')){
			crearCookie("mostrarCiudadSucursal", "si");
			$('.Cciudad').show();
		}else{
			crearCookie("mostrarCiudadSucursal", "no");
			$('.Cciudad').hide();
		}	
	});
	$( "#CheckEstado" ).click(function() {
    	if ($( "#CheckEstado" ).is(':checked')){
			crearCookie("mostrarEstadoSucursal", "si");
			$('.Cestado').show();
		}else{
			crearCookie("mostrarEstadoSucursal", "no");
			$('.Cestado').hide();
		}	
	});
	$( "#CheckTelefonocontacto" ).click(function() {
    	if ($( "#CheckTelefonocontacto" ).is(':checked')){
			crearCookie("mostrarTelefonocontactoSucursal", "si");
			$('.Ctelefonocontacto').show();
		}else{
			crearCookie("mostrarTelefonocontactoSucursal", "no");
			$('.Ctelefonocontacto').hide();
		}	
	});
	$( "#CheckLicenciassa" ).click(function() {
    	if ($( "#CheckLicenciassa" ).is(':checked')){
			crearCookie("mostrarLicenciassaSucursal", "si");
			$('.Clicenciassa').show();
		}else{
			crearCookie("mostrarLicenciassaSucursal", "no");
			$('.Clicenciassa').hide();
		}	
	});
	$( "#CheckSerie" ).click(function() {
    	if ($( "#CheckSerie" ).is(':checked')){
			crearCookie("mostrarSerieSucursal", "si");
			$('.Cserie').show();
		}else{
			crearCookie("mostrarSerieSucursal", "no");
			$('.Cserie').hide();
		}	
	});
	$( "#CheckFolio" ).click(function() {
    	if ($( "#CheckFolio" ).is(':checked')){
			crearCookie("mostrarFolioSucursal", "si");
			$('.Cfolio').show();
		}else{
			crearCookie("mostrarFolioSucursal", "no");
			$('.Cfolio').hide();
		}	
	});
	$( "#CheckIdcuentacorreo" ).click(function() {
    	if ($( "#CheckIdcuentacorreo" ).is(':checked')){
			crearCookie("mostrarIdcuentacorreoSucursal", "si");
			$('.Cidcuentacorreo').show();
		}else{
			crearCookie("mostrarIdcuentacorreoSucursal", "no");
			$('.Cidcuentacorreo').hide();
		}	
	});
	$( "#CheckArchivofirma" ).click(function() {
    	if ($( "#CheckArchivofirma" ).is(':checked')){
			crearCookie("mostrarArchivofirmaSucursal", "si");
			$('.Carchivofirma').show();
		}else{
			crearCookie("mostrarArchivofirmaSucursal", "no");
			$('.Carchivofirma').hide();
		}	
	});
	$( "#CheckComposicion" ).click(function() {
    	if ($( "#CheckComposicion" ).is(':checked')){
			crearCookie("mostrarComposicionSucursal", "si");
			$('.Ccomposicion').show();
		}else{
			crearCookie("mostrarComposicionSucursal", "no");
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