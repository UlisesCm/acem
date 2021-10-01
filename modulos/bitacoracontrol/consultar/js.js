// JavaScript Document
var orden, campoOrden, cantidadamostrar, paginacion;
orden="DESC";
campoOrden="idbitacoracontrol";
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
function comprobarReglas(){
	$(".checksEliminar").hide();
	//Identificar el campo de ordenamiento
	if(recuperarCookie("campoOrdenBitacoracontrol")!=null){
		campoOrden=recuperarCookie("campoOrdenBitacoracontrol");
		 $("#campoOrden option[value="+campoOrden+"]").attr("selected",true);
	}else{
		campoOrden="idbitacoracontrol";
		$("#campoOrden option[value="+campoOrden+"]").attr("selected",true);
	}
	
	//Identificar el numero de elementos para mostrar
	if(recuperarCookie("cantidadamostrarBitacoracontrol")!=null){
		cantidadamostrar=recuperarCookie("cantidadamostrarBitacoracontrol");
		 $("#cantidadamostrar option[value="+cantidadamostrar+"]").attr("selected",true);
	}else{
		cantidadamostrar="20";
		$("#cantidadamostrar option[value="+cantidadamostrar+"]").attr("selected",true);
		
	}
	
	//Identificar el tipo de orden
	if(recuperarCookie("ordenBitacoracontrol")=="asc"){
		orden="ASC"
		$('#asc').attr('checked', true);
		$('#desc').attr('checked', false);
	}else if(recuperarCookie("ordenBitacoracontrol")=="desc"){
		orden="DESC"
		$('#asc').attr('checked', false);
		$('#desc').attr('checked', true);
	}else{
		orden="DESC"
		$('#asc').attr('checked', false);
		$('#desc').attr('checked', true);
	}
	//Mostrar u Ocultar Idbitacoracontrol
	if(recuperarCookie("mostrarIdbitacoracontrolBitacoracontrol")=="si"){
		$('.Cidbitacoracontrol').show();
		$('#CheckIdbitacoracontrol').attr('checked', true);
	}else if(recuperarCookie("mostrarIdbitacoracontrolBitacoracontrol")=="no"){
		$('.Cidbitacoracontrol').hide();
		$('#CheckIdbitacoracontrol').attr('checked', false);
	}
	//Mostrar u Ocultar Fecha
	if(recuperarCookie("mostrarFechaBitacoracontrol")=="si"){
		$('.Cfecha').show();
		$('#CheckFecha').attr('checked', true);
	}else if(recuperarCookie("mostrarFechaBitacoracontrol")=="no"){
		$('.Cfecha').hide();
		$('#CheckFecha').attr('checked', false);
	}
	//Mostrar u Ocultar Hora
	if(recuperarCookie("mostrarHoraBitacoracontrol")=="si"){
		$('.Chora').show();
		$('#CheckHora').attr('checked', true);
	}else if(recuperarCookie("mostrarHoraBitacoracontrol")=="no"){
		$('.Chora').hide();
		$('#CheckHora').attr('checked', false);
	}
	//Mostrar u Ocultar Idusuario
	if(recuperarCookie("mostrarIdusuarioBitacoracontrol")=="si"){
		$('.Cidusuario').show();
		$('#CheckIdusuario').attr('checked', true);
	}else if(recuperarCookie("mostrarIdusuarioBitacoracontrol")=="no"){
		$('.Cidusuario').hide();
		$('#CheckIdusuario').attr('checked', false);
	}
	//Mostrar u Ocultar Modulo
	if(recuperarCookie("mostrarModuloBitacoracontrol")=="si"){
		$('.Cmodulo').show();
		$('#CheckModulo').attr('checked', true);
	}else if(recuperarCookie("mostrarModuloBitacoracontrol")=="no"){
		$('.Cmodulo').hide();
		$('#CheckModulo').attr('checked', false);
	}
	//Mostrar u Ocultar Accion
	if(recuperarCookie("mostrarAccionBitacoracontrol")=="si"){
		$('.Caccion').show();
		$('#CheckAccion').attr('checked', true);
	}else if(recuperarCookie("mostrarAccionBitacoracontrol")=="no"){
		$('.Caccion').hide();
		$('#CheckAccion').attr('checked', false);
	}
	//Mostrar u Ocultar Descripcion
	if(recuperarCookie("mostrarDescripcionBitacoracontrol")=="si"){
		$('.Cdescripcion').show();
		$('#CheckDescripcion').attr('checked', true);
	}else if(recuperarCookie("mostrarDescripcionBitacoracontrol")=="no"){
		$('.Cdescripcion').hide();
		$('#CheckDescripcion').attr('checked', false);
	}
	//Mostrar u Ocultar Tabla
	if(recuperarCookie("mostrarTablaBitacoracontrol")=="si"){
		$('.Ctabla').show();
		$('#CheckTabla').attr('checked', true);
	}else if(recuperarCookie("mostrarTablaBitacoracontrol")=="no"){
		$('.Ctabla').hide();
		$('#CheckTabla').attr('checked', false);
	}
	//Mostrar u Ocultar Composicion
	if(recuperarCookie("mostrarComposicionBitacoracontrol")=="si"){
		$('.Ccomposicion').show();
		$('#CheckComposicion').attr('checked', true);
	}
	if(recuperarCookie("mostrarComposicionBitacoracontrol")=="no"){
		$('.Ccomposicion').hide();
		$('#CheckComposicion').attr('checked', false);
	}
	
	//Elegir el tipo de vista
	if(recuperarCookie("tipoVistaBitacoracontrol")=="tabla"){
		$('.tipoLista').show();
		$('.tipoTabla').hide();
		tipoVista="tabla";
	}else{
		$('.tipoLista').hide();
		$('.tipoTabla').show();
		tipoVista="lista";
	}
	$( ".tipoTabla" ).click(function() {
    	crearCookie("tipoVistaBitacoracontrol", "tabla");
		tipoVista="tabla";
		$(".tipoLista").show();
		$(".tipoTabla").hide();
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$( ".tipoLista" ).click(function() {
    	crearCookie("tipoVistaBitacoracontrol", "lista");
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
		crearCookie("campoOrdenBitacoracontrol", campoOrden);
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$("#cantidadamostrar").change(function(){
		cantidadamostrar = this.value;
		crearCookie("cantidadamostrarBitacoracontrol", cantidadamostrar);
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$( "#asc" ).click(function() {
    	if ($( "#asc" ).is(':checked')){
			crearCookie("ordenBitacoracontrol", "asc");
			orden="ASC"
			load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
		}
	});
	$( "#desc" ).click(function() {
    	if ($( "#desc" ).is(':checked')){
			crearCookie("ordenBitacoracontrol", "desc");
			orden="DESC"
			load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
		}
	});
	$( "#CheckIdbitacoracontrol" ).click(function() {
    	if ($( "#CheckIdbitacoracontrol" ).is(':checked')){
			crearCookie("mostrarIdbitacoracontrolBitacoracontrol", "si");
			$('.Cidbitacoracontrol').show();
		}else{
			crearCookie("mostrarIdbitacoracontrolBitacoracontrol", "no");
			$('.Cidbitacoracontrol').hide();
		}	
	});
	$( "#CheckFecha" ).click(function() {
    	if ($( "#CheckFecha" ).is(':checked')){
			crearCookie("mostrarFechaBitacoracontrol", "si");
			$('.Cfecha').show();
		}else{
			crearCookie("mostrarFechaBitacoracontrol", "no");
			$('.Cfecha').hide();
		}	
	});
	$( "#CheckHora" ).click(function() {
    	if ($( "#CheckHora" ).is(':checked')){
			crearCookie("mostrarHoraBitacoracontrol", "si");
			$('.Chora').show();
		}else{
			crearCookie("mostrarHoraBitacoracontrol", "no");
			$('.Chora').hide();
		}	
	});
	$( "#CheckIdusuario" ).click(function() {
    	if ($( "#CheckIdusuario" ).is(':checked')){
			crearCookie("mostrarIdusuarioBitacoracontrol", "si");
			$('.Cidusuario').show();
		}else{
			crearCookie("mostrarIdusuarioBitacoracontrol", "no");
			$('.Cidusuario').hide();
		}	
	});
	$( "#CheckModulo" ).click(function() {
    	if ($( "#CheckModulo" ).is(':checked')){
			crearCookie("mostrarModuloBitacoracontrol", "si");
			$('.Cmodulo').show();
		}else{
			crearCookie("mostrarModuloBitacoracontrol", "no");
			$('.Cmodulo').hide();
		}	
	});
	$( "#CheckAccion" ).click(function() {
    	if ($( "#CheckAccion" ).is(':checked')){
			crearCookie("mostrarAccionBitacoracontrol", "si");
			$('.Caccion').show();
		}else{
			crearCookie("mostrarAccionBitacoracontrol", "no");
			$('.Caccion').hide();
		}	
	});
	$( "#CheckDescripcion" ).click(function() {
    	if ($( "#CheckDescripcion" ).is(':checked')){
			crearCookie("mostrarDescripcionBitacoracontrol", "si");
			$('.Cdescripcion').show();
		}else{
			crearCookie("mostrarDescripcionBitacoracontrol", "no");
			$('.Cdescripcion').hide();
		}	
	});
	$( "#CheckTabla" ).click(function() {
    	if ($( "#CheckTabla" ).is(':checked')){
			crearCookie("mostrarTablaBitacoracontrol", "si");
			$('.Ctabla').show();
		}else{
			crearCookie("mostrarTablaBitacoracontrol", "no");
			$('.Ctabla').hide();
		}	
	});
	$( "#CheckComposicion" ).click(function() {
    	if ($( "#CheckComposicion" ).is(':checked')){
			crearCookie("mostrarComposicionBitacoracontrol", "si");
			$('.Ccomposicion').show();
		}else{
			crearCookie("mostrarComposicionBitacoracontrol", "no");
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