// JavaScript Document
var orden, campoOrden, cantidadamostrar, paginacion;
orden="DESC";
campoOrden="idbitacoravehicular";
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
	if(recuperarCookie("campoOrdenBitacoravehicular")!=null){
		campoOrden=recuperarCookie("campoOrdenBitacoravehicular");
		 $("#campoOrden option[value="+campoOrden+"]").attr("selected",true);
	}else{
		campoOrden="idbitacoravehicular";
		$("#campoOrden option[value="+campoOrden+"]").attr("selected",true);
	}
	
	//Identificar el numero de elementos para mostrar
	if(recuperarCookie("cantidadamostrarBitacoravehicular")!=null){
		cantidadamostrar=recuperarCookie("cantidadamostrarBitacoravehicular");
		 $("#cantidadamostrar option[value="+cantidadamostrar+"]").attr("selected",true);
	}else{
		cantidadamostrar="20";
		$("#cantidadamostrar option[value="+cantidadamostrar+"]").attr("selected",true);
		
	}
	
	//Identificar el tipo de orden
	if(recuperarCookie("ordenBitacoravehicular")=="asc"){
		orden="ASC"
		$('#asc').attr('checked', true);
		$('#desc').attr('checked', false);
	}else if(recuperarCookie("ordenBitacoravehicular")=="desc"){
		orden="DESC"
		$('#asc').attr('checked', false);
		$('#desc').attr('checked', true);
	}else{
		orden="DESC"
		$('#asc').attr('checked', false);
		$('#desc').attr('checked', true);
	}
	//Mostrar u Ocultar Idbitacoravehicular
	if(recuperarCookie("mostrarIdbitacoravehicularBitacoravehicular")=="si"){
		$('.Cidbitacoravehicular').show();
		$('#CheckIdbitacoravehicular').attr('checked', true);
	}else if(recuperarCookie("mostrarIdbitacoravehicularBitacoravehicular")=="no"){
		$('.Cidbitacoravehicular').hide();
		$('#CheckIdbitacoravehicular').attr('checked', false);
	}
	//Mostrar u Ocultar Idvehiculo
	if(recuperarCookie("mostrarIdvehiculoBitacoravehicular")=="si"){
		$('.Cidvehiculo').show();
		$('#CheckIdvehiculo').attr('checked', true);
	}else if(recuperarCookie("mostrarIdvehiculoBitacoravehicular")=="no"){
		$('.Cidvehiculo').hide();
		$('#CheckIdvehiculo').attr('checked', false);
	}
	//Mostrar u Ocultar Categoria
	if(recuperarCookie("mostrarCategoriaBitacoravehicular")=="si"){
		$('.Ccategoria').show();
		$('#CheckCategoria').attr('checked', true);
	}else if(recuperarCookie("mostrarCategoriaBitacoravehicular")=="no"){
		$('.Ccategoria').hide();
		$('#CheckCategoria').attr('checked', false);
	}
	//Mostrar u Ocultar Fecha
	if(recuperarCookie("mostrarFechaBitacoravehicular")=="si"){
		$('.Cfecha').show();
		$('#CheckFecha').attr('checked', true);
	}else if(recuperarCookie("mostrarFechaBitacoravehicular")=="no"){
		$('.Cfecha').hide();
		$('#CheckFecha').attr('checked', false);
	}
	//Mostrar u Ocultar Descripcion
	if(recuperarCookie("mostrarDescripcionBitacoravehicular")=="si"){
		$('.Cdescripcion').show();
		$('#CheckDescripcion').attr('checked', true);
	}else if(recuperarCookie("mostrarDescripcionBitacoravehicular")=="no"){
		$('.Cdescripcion').hide();
		$('#CheckDescripcion').attr('checked', false);
	}
	//Mostrar u Ocultar Tipocombustible
	if(recuperarCookie("mostrarTipocombustibleBitacoravehicular")=="si"){
		$('.Ctipocombustible').show();
		$('#CheckTipocombustible').attr('checked', true);
	}else if(recuperarCookie("mostrarTipocombustibleBitacoravehicular")=="no"){
		$('.Ctipocombustible').hide();
		$('#CheckTipocombustible').attr('checked', false);
	}
	//Mostrar u Ocultar Litros
	if(recuperarCookie("mostrarLitrosBitacoravehicular")=="si"){
		$('.Clitros').show();
		$('#CheckLitros').attr('checked', true);
	}else if(recuperarCookie("mostrarLitrosBitacoravehicular")=="no"){
		$('.Clitros').hide();
		$('#CheckLitros').attr('checked', false);
	}
	//Mostrar u Ocultar Kilometraje
	if(recuperarCookie("mostrarKilometrajeBitacoravehicular")=="si"){
		$('.Ckilometraje').show();
		$('#CheckKilometraje').attr('checked', true);
	}else if(recuperarCookie("mostrarKilometrajeBitacoravehicular")=="no"){
		$('.Ckilometraje').hide();
		$('#CheckKilometraje').attr('checked', false);
	}
	//Mostrar u Ocultar Archivo
	if(recuperarCookie("mostrarArchivoBitacoravehicular")=="si"){
		$('.Carchivo').show();
		$('#CheckArchivo').attr('checked', true);
	}else if(recuperarCookie("mostrarArchivoBitacoravehicular")=="no"){
		$('.Carchivo').hide();
		$('#CheckArchivo').attr('checked', false);
	}
	//Mostrar u Ocultar Composicion
	if(recuperarCookie("mostrarComposicionBitacoravehicular")=="si"){
		$('.Ccomposicion').show();
		$('#CheckComposicion').attr('checked', true);
	}
	if(recuperarCookie("mostrarComposicionBitacoravehicular")=="no"){
		$('.Ccomposicion').hide();
		$('#CheckComposicion').attr('checked', false);
	}
	
	//Elegir el tipo de vista
	if(recuperarCookie("tipoVistaBitacoravehicular")=="tabla"){
		$('.tipoLista').show();
		$('.tipoTabla').hide();
		tipoVista="tabla";
	}else{
		$('.tipoLista').hide();
		$('.tipoTabla').show();
		tipoVista="lista";
	}
	$( ".tipoTabla" ).click(function() {
    	crearCookie("tipoVistaBitacoravehicular", "tabla");
		tipoVista="tabla";
		$(".tipoLista").show();
		$(".tipoTabla").hide();
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$( ".tipoLista" ).click(function() {
    	crearCookie("tipoVistaBitacoravehicular", "lista");
		tipoVista="lista";
		$(".tipoLista").hide();
		$(".tipoTabla").show();
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});

}

	
$(document).ready(function() {
	$("#cajaBuscar").focus();
	comprobarReglas();
	//load_tablas(campoOrden,orden,cantidadamostrar,paginacion,busqueda,tipoVista);
	$("#loading").hide();
	
	llenarSelectVehiculo(idsucursalseleccionada);
	
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
		crearCookie("campoOrdenBitacoravehicular", campoOrden);
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$("#cantidadamostrar").change(function(){
		cantidadamostrar = this.value;
		crearCookie("cantidadamostrarBitacoravehicular", cantidadamostrar);
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$( "#asc" ).click(function() {
    	if ($( "#asc" ).is(':checked')){
			crearCookie("ordenBitacoravehicular", "asc");
			orden="ASC"
			load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
		}
	});
	$( "#desc" ).click(function() {
    	if ($( "#desc" ).is(':checked')){
			crearCookie("ordenBitacoravehicular", "desc");
			orden="DESC"
			load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
		}
	});
	$( "#CheckIdbitacoravehicular" ).click(function() {
    	if ($( "#CheckIdbitacoravehicular" ).is(':checked')){
			crearCookie("mostrarIdbitacoravehicularBitacoravehicular", "si");
			$('.Cidbitacoravehicular').show();
		}else{
			crearCookie("mostrarIdbitacoravehicularBitacoravehicular", "no");
			$('.Cidbitacoravehicular').hide();
		}	
	});
	$( "#CheckIdvehiculo" ).click(function() {
    	if ($( "#CheckIdvehiculo" ).is(':checked')){
			crearCookie("mostrarIdvehiculoBitacoravehicular", "si");
			$('.Cidvehiculo').show();
		}else{
			crearCookie("mostrarIdvehiculoBitacoravehicular", "no");
			$('.Cidvehiculo').hide();
		}	
	});
	$( "#CheckCategoria" ).click(function() {
    	if ($( "#CheckCategoria" ).is(':checked')){
			crearCookie("mostrarCategoriaBitacoravehicular", "si");
			$('.Ccategoria').show();
		}else{
			crearCookie("mostrarCategoriaBitacoravehicular", "no");
			$('.Ccategoria').hide();
		}	
	});
	$( "#CheckFecha" ).click(function() {
    	if ($( "#CheckFecha" ).is(':checked')){
			crearCookie("mostrarFechaBitacoravehicular", "si");
			$('.Cfecha').show();
		}else{
			crearCookie("mostrarFechaBitacoravehicular", "no");
			$('.Cfecha').hide();
		}	
	});
	$( "#CheckDescripcion" ).click(function() {
    	if ($( "#CheckDescripcion" ).is(':checked')){
			crearCookie("mostrarDescripcionBitacoravehicular", "si");
			$('.Cdescripcion').show();
		}else{
			crearCookie("mostrarDescripcionBitacoravehicular", "no");
			$('.Cdescripcion').hide();
		}	
	});
	$( "#CheckTipocombustible" ).click(function() {
    	if ($( "#CheckTipocombustible" ).is(':checked')){
			crearCookie("mostrarTipocombustibleBitacoravehicular", "si");
			$('.Ctipocombustible').show();
		}else{
			crearCookie("mostrarTipocombustibleBitacoravehicular", "no");
			$('.Ctipocombustible').hide();
		}	
	});
	$( "#CheckLitros" ).click(function() {
    	if ($( "#CheckLitros" ).is(':checked')){
			crearCookie("mostrarLitrosBitacoravehicular", "si");
			$('.Clitros').show();
		}else{
			crearCookie("mostrarLitrosBitacoravehicular", "no");
			$('.Clitros').hide();
		}	
	});
	$( "#CheckKilometraje" ).click(function() {
    	if ($( "#CheckKilometraje" ).is(':checked')){
			crearCookie("mostrarKilometrajeBitacoravehicular", "si");
			$('.Ckilometraje').show();
		}else{
			crearCookie("mostrarKilometrajeBitacoravehicular", "no");
			$('.Ckilometraje').hide();
		}	
	});
	$( "#CheckArchivo" ).click(function() {
    	if ($( "#CheckArchivo" ).is(':checked')){
			crearCookie("mostrarArchivoBitacoravehicular", "si");
			$('.Carchivo').show();
		}else{
			crearCookie("mostrarArchivoBitacoravehicular", "no");
			$('.Carchivo').hide();
		}	
	});
	$( "#CheckComposicion" ).click(function() {
    	if ($( "#CheckComposicion" ).is(':checked')){
			crearCookie("mostrarComposicionBitacoravehicular", "si");
			$('.Ccomposicion').show();
		}else{
			crearCookie("mostrarComposicionBitacoravehicular", "no");
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
	
	$("#botonFiltrar").click(function() {
			load_tablas(campoOrden,orden,cantidadamostrar,paginacion,busqueda,tipoVista);
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
	
	var variables = $("#formulario").serialize();
	
	xmlhttp.open("POST","consultar.php?campoOrden="+campoOrden+"&orden="+orden+"&cantidadamostrar="+cantidadamostrar+"&paginacion="+paginacion+"&busqueda="+busqueda+"&tipoVista="+tipoVista+"&papelera="+papelera+"&"+variables, true);
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

function llenarSelectVehiculo(condicion){
		$("#idvehiculo_ajax").html("<option value='1'>cargando...</option>");
		$.ajax({
			url: '../componentes/llenarSelectVehiculo.php',
			type: "POST",
			data: "submit=&condicion="+condicion, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#idvehiculo_ajax").html(mensaje);
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