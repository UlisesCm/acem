// JavaScript Document
var orden, campoOrden, cantidadamostrar, paginacion;
orden="DESC";
campoOrden="idfactura";
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

function cancelarFactura(id) {
	var encoded = "¿Desea cancelar la factura?";
	var decoded = $("<div/>").html(encoded).text();
    var pregunta = confirm(decoded);
			if (pregunta){
				cancelar_factura(id);
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
	if(recuperarCookie("campoOrdenFacturacion")!=null){
		campoOrden=recuperarCookie("campoOrdenFacturacion");
		 $("#campoOrden option[value="+campoOrden+"]").attr("selected",true);
	}else{
		campoOrden="idfactura";
		$("#campoOrden option[value="+campoOrden+"]").attr("selected",true);
	}
	
	//Identificar el numero de elementos para mostrar
	if(recuperarCookie("cantidadamostrarFacturacion")!=null){
		cantidadamostrar=recuperarCookie("cantidadamostrarFacturacion");
		 $("#cantidadamostrar option[value="+cantidadamostrar+"]").attr("selected",true);
	}else{
		cantidadamostrar="20";
		$("#cantidadamostrar option[value="+cantidadamostrar+"]").attr("selected",true);
		
	}
	
	//Identificar el tipo de orden
	if(recuperarCookie("ordenFacturacion")=="asc"){
		orden="ASC"
		$('#asc').attr('checked', true);
		$('#desc').attr('checked', false);
	}else if(recuperarCookie("ordenFacturacion")=="desc"){
		orden="DESC"
		$('#asc').attr('checked', false);
		$('#desc').attr('checked', true);
	}else{
		orden="DESC"
		$('#asc').attr('checked', false);
		$('#desc').attr('checked', true);
	}
	//Mostrar u Ocultar Idfactura
	if(recuperarCookie("mostrarIdfacturaFacturacion")=="si"){
		$('.Cidfactura').show();
		$('#CheckIdfactura').attr('checked', true);
	}else if(recuperarCookie("mostrarIdfacturaFacturacion")=="no"){
		$('.Cidfactura').hide();
		$('#CheckIdfactura').attr('checked', false);
	}
	//Mostrar u Ocultar Foliointerno
	if(recuperarCookie("mostrarFoliointernoFacturacion")=="si"){
		$('.Cfoliointerno').show();
		$('#CheckFoliointerno').attr('checked', true);
	}else if(recuperarCookie("mostrarFoliointernoFacturacion")=="no"){
		$('.Cfoliointerno').hide();
		$('#CheckFoliointerno').attr('checked', false);
	}
	//Mostrar u Ocultar Fecha
	if(recuperarCookie("mostrarFechaFacturacion")=="si"){
		$('.Cfecha').show();
		$('#CheckFecha').attr('checked', true);
	}else if(recuperarCookie("mostrarFechaFacturacion")=="no"){
		$('.Cfecha').hide();
		$('#CheckFecha').attr('checked', false);
	}
	//Mostrar u Ocultar Tipo
	if(recuperarCookie("mostrarTipoFacturacion")=="si"){
		$('.Ctipo').show();
		$('#CheckTipo').attr('checked', true);
	}else if(recuperarCookie("mostrarTipoFacturacion")=="no"){
		$('.Ctipo').hide();
		$('#CheckTipo').attr('checked', false);
	}
	//Mostrar u Ocultar Clasificacion
	if(recuperarCookie("mostrarClasificacionFacturacion")=="si"){
		$('.Cclasificacion').show();
		$('#CheckClasificacion').attr('checked', true);
	}else if(recuperarCookie("mostrarClasificacionFacturacion")=="no"){
		$('.Cclasificacion').hide();
		$('#CheckClasificacion').attr('checked', false);
	}
	//Mostrar u Ocultar Emisor
	if(recuperarCookie("mostrarEmisorFacturacion")=="si"){
		$('.Cemisor').show();
		$('#CheckEmisor').attr('checked', true);
	}else if(recuperarCookie("mostrarEmisorFacturacion")=="no"){
		$('.Cemisor').hide();
		$('#CheckEmisor').attr('checked', false);
	}
	//Mostrar u Ocultar Rfcemisor
	if(recuperarCookie("mostrarRfcemisorFacturacion")=="si"){
		$('.Crfcemisor').show();
		$('#CheckRfcemisor').attr('checked', true);
	}else if(recuperarCookie("mostrarRfcemisorFacturacion")=="no"){
		$('.Crfcemisor').hide();
		$('#CheckRfcemisor').attr('checked', false);
	}
	//Mostrar u Ocultar Receptor
	if(recuperarCookie("mostrarReceptorFacturacion")=="si"){
		$('.Creceptor').show();
		$('#CheckReceptor').attr('checked', true);
	}else if(recuperarCookie("mostrarReceptorFacturacion")=="no"){
		$('.Creceptor').hide();
		$('#CheckReceptor').attr('checked', false);
	}
	//Mostrar u Ocultar Rfcreceptor
	if(recuperarCookie("mostrarRfcreceptorFacturacion")=="si"){
		$('.Crfcreceptor').show();
		$('#CheckRfcreceptor').attr('checked', true);
	}else if(recuperarCookie("mostrarRfcreceptorFacturacion")=="no"){
		$('.Crfcreceptor').hide();
		$('#CheckRfcreceptor').attr('checked', false);
	}
	//Mostrar u Ocultar Montototal
	if(recuperarCookie("mostrarMontototalFacturacion")=="si"){
		$('.Cmontototal').show();
		$('#CheckMontototal').attr('checked', true);
	}else if(recuperarCookie("mostrarMontototalFacturacion")=="no"){
		$('.Cmontototal').hide();
		$('#CheckMontototal').attr('checked', false);
	}
	//Mostrar u Ocultar Montopagado
	if(recuperarCookie("mostrarMontopagadoFacturacion")=="si"){
		$('.Cmontopagado').show();
		$('#CheckMontopagado').attr('checked', true);
	}else if(recuperarCookie("mostrarMontopagadoFacturacion")=="no"){
		$('.Cmontopagado').hide();
		$('#CheckMontopagado').attr('checked', false);
	}
	//Mostrar u Ocultar Estado
	if(recuperarCookie("mostrarEstadoFacturacion")=="si"){
		$('.Cestado').show();
		$('#CheckEstado').attr('checked', true);
	}else if(recuperarCookie("mostrarEstadoFacturacion")=="no"){
		$('.Cestado').hide();
		$('#CheckEstado').attr('checked', false);
	}
	//Mostrar u Ocultar Fechapago
	if(recuperarCookie("mostrarFechapagoFacturacion")=="si"){
		$('.Cfechapago').show();
		$('#CheckFechapago').attr('checked', true);
	}else if(recuperarCookie("mostrarFechapagoFacturacion")=="no"){
		$('.Cfechapago').hide();
		$('#CheckFechapago').attr('checked', false);
	}
	//Mostrar u Ocultar Formapago
	if(recuperarCookie("mostrarFormapagoFacturacion")=="si"){
		$('.Cformapago').show();
		$('#CheckFormapago').attr('checked', true);
	}else if(recuperarCookie("mostrarFormapagoFacturacion")=="no"){
		$('.Cformapago').hide();
		$('#CheckFormapago').attr('checked', false);
	}
	//Mostrar u Ocultar Cuenta
	if(recuperarCookie("mostrarCuentaFacturacion")=="si"){
		$('.Ccuenta').show();
		$('#CheckCuenta').attr('checked', true);
	}else if(recuperarCookie("mostrarCuentaFacturacion")=="no"){
		$('.Ccuenta').hide();
		$('#CheckCuenta').attr('checked', false);
	}
	//Mostrar u Ocultar Foliofiscal
	if(recuperarCookie("mostrarFoliofiscalFacturacion")=="si"){
		$('.Cfoliofiscal').show();
		$('#CheckFoliofiscal').attr('checked', true);
	}else if(recuperarCookie("mostrarFoliofiscalFacturacion")=="no"){
		$('.Cfoliofiscal').hide();
		$('#CheckFoliofiscal').attr('checked', false);
	}
	//Mostrar u Ocultar Observaciones
	if(recuperarCookie("mostrarObservacionesFacturacion")=="si"){
		$('.Cobservaciones').show();
		$('#CheckObservaciones').attr('checked', true);
	}else if(recuperarCookie("mostrarObservacionesFacturacion")=="no"){
		$('.Cobservaciones').hide();
		$('#CheckObservaciones').attr('checked', false);
	}
	//Mostrar u Ocultar Relaciones
	if(recuperarCookie("mostrarRelacionesFacturacion")=="si"){
		$('.Crelaciones').show();
		$('#CheckRelaciones').attr('checked', true);
	}else if(recuperarCookie("mostrarRelacionesFacturacion")=="no"){
		$('.Crelaciones').hide();
		$('#CheckRelaciones').attr('checked', false);
	}
	//Mostrar u Ocultar Composicion
	if(recuperarCookie("mostrarComposicionFacturacion")=="si"){
		$('.Ccomposicion').show();
		$('#CheckComposicion').attr('checked', true);
	}
	if(recuperarCookie("mostrarComposicionFacturacion")=="no"){
		$('.Ccomposicion').hide();
		$('#CheckComposicion').attr('checked', false);
	}
	
	//Elegir el tipo de vista
	if(recuperarCookie("tipoVistaFacturacion")=="tabla"){
		$('.tipoLista').show();
		$('.tipoTabla').hide();
		tipoVista="tabla";
	}else{
		$('.tipoLista').hide();
		$('.tipoTabla').show();
		tipoVista="lista";
	}
	$( ".tipoTabla" ).click(function() {
    	crearCookie("tipoVistaFacturacion", "tabla");
		tipoVista="tabla";
		$(".tipoLista").show();
		$(".tipoTabla").hide();
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$( ".tipoLista" ).click(function() {
    	crearCookie("tipoVistaFacturacion", "lista");
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
		crearCookie("campoOrdenFacturacion", campoOrden);
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$("#cantidadamostrar").change(function(){
		cantidadamostrar = this.value;
		crearCookie("cantidadamostrarFacturacion", cantidadamostrar);
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$( "#asc" ).click(function() {
    	if ($( "#asc" ).is(':checked')){
			crearCookie("ordenFacturacion", "asc");
			orden="ASC"
			load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
		}
	});
	$( "#desc" ).click(function() {
    	if ($( "#desc" ).is(':checked')){
			crearCookie("ordenFacturacion", "desc");
			orden="DESC"
			load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
		}
	});
	$( "#CheckIdfactura" ).click(function() {
    	if ($( "#CheckIdfactura" ).is(':checked')){
			crearCookie("mostrarIdfacturaFacturacion", "si");
			$('.Cidfactura').show();
		}else{
			crearCookie("mostrarIdfacturaFacturacion", "no");
			$('.Cidfactura').hide();
		}	
	});
	$( "#CheckFoliointerno" ).click(function() {
    	if ($( "#CheckFoliointerno" ).is(':checked')){
			crearCookie("mostrarFoliointernoFacturacion", "si");
			$('.Cfoliointerno').show();
		}else{
			crearCookie("mostrarFoliointernoFacturacion", "no");
			$('.Cfoliointerno').hide();
		}	
	});
	$( "#CheckFecha" ).click(function() {
    	if ($( "#CheckFecha" ).is(':checked')){
			crearCookie("mostrarFechaFacturacion", "si");
			$('.Cfecha').show();
		}else{
			crearCookie("mostrarFechaFacturacion", "no");
			$('.Cfecha').hide();
		}	
	});
	$( "#CheckTipo" ).click(function() {
    	if ($( "#CheckTipo" ).is(':checked')){
			crearCookie("mostrarTipoFacturacion", "si");
			$('.Ctipo').show();
		}else{
			crearCookie("mostrarTipoFacturacion", "no");
			$('.Ctipo').hide();
		}	
	});
	$( "#CheckClasificacion" ).click(function() {
    	if ($( "#CheckClasificacion" ).is(':checked')){
			crearCookie("mostrarClasificacionFacturacion", "si");
			$('.Cclasificacion').show();
		}else{
			crearCookie("mostrarClasificacionFacturacion", "no");
			$('.Cclasificacion').hide();
		}	
	});
	$( "#CheckEmisor" ).click(function() {
    	if ($( "#CheckEmisor" ).is(':checked')){
			crearCookie("mostrarEmisorFacturacion", "si");
			$('.Cemisor').show();
		}else{
			crearCookie("mostrarEmisorFacturacion", "no");
			$('.Cemisor').hide();
		}	
	});
	$( "#CheckRfcemisor" ).click(function() {
    	if ($( "#CheckRfcemisor" ).is(':checked')){
			crearCookie("mostrarRfcemisorFacturacion", "si");
			$('.Crfcemisor').show();
		}else{
			crearCookie("mostrarRfcemisorFacturacion", "no");
			$('.Crfcemisor').hide();
		}	
	});
	$( "#CheckReceptor" ).click(function() {
    	if ($( "#CheckReceptor" ).is(':checked')){
			crearCookie("mostrarReceptorFacturacion", "si");
			$('.Creceptor').show();
		}else{
			crearCookie("mostrarReceptorFacturacion", "no");
			$('.Creceptor').hide();
		}	
	});
	$( "#CheckRfcreceptor" ).click(function() {
    	if ($( "#CheckRfcreceptor" ).is(':checked')){
			crearCookie("mostrarRfcreceptorFacturacion", "si");
			$('.Crfcreceptor').show();
		}else{
			crearCookie("mostrarRfcreceptorFacturacion", "no");
			$('.Crfcreceptor').hide();
		}	
	});
	$( "#CheckMontototal" ).click(function() {
    	if ($( "#CheckMontototal" ).is(':checked')){
			crearCookie("mostrarMontototalFacturacion", "si");
			$('.Cmontototal').show();
		}else{
			crearCookie("mostrarMontototalFacturacion", "no");
			$('.Cmontototal').hide();
		}	
	});
	$( "#CheckMontopagado" ).click(function() {
    	if ($( "#CheckMontopagado" ).is(':checked')){
			crearCookie("mostrarMontopagadoFacturacion", "si");
			$('.Cmontopagado').show();
		}else{
			crearCookie("mostrarMontopagadoFacturacion", "no");
			$('.Cmontopagado').hide();
		}	
	});
	$( "#CheckEstado" ).click(function() {
    	if ($( "#CheckEstado" ).is(':checked')){
			crearCookie("mostrarEstadoFacturacion", "si");
			$('.Cestado').show();
		}else{
			crearCookie("mostrarEstadoFacturacion", "no");
			$('.Cestado').hide();
		}	
	});
	$( "#CheckFechapago" ).click(function() {
    	if ($( "#CheckFechapago" ).is(':checked')){
			crearCookie("mostrarFechapagoFacturacion", "si");
			$('.Cfechapago').show();
		}else{
			crearCookie("mostrarFechapagoFacturacion", "no");
			$('.Cfechapago').hide();
		}	
	});
	$( "#CheckFormapago" ).click(function() {
    	if ($( "#CheckFormapago" ).is(':checked')){
			crearCookie("mostrarFormapagoFacturacion", "si");
			$('.Cformapago').show();
		}else{
			crearCookie("mostrarFormapagoFacturacion", "no");
			$('.Cformapago').hide();
		}	
	});
	$( "#CheckCuenta" ).click(function() {
    	if ($( "#CheckCuenta" ).is(':checked')){
			crearCookie("mostrarCuentaFacturacion", "si");
			$('.Ccuenta').show();
		}else{
			crearCookie("mostrarCuentaFacturacion", "no");
			$('.Ccuenta').hide();
		}	
	});
	$( "#CheckFoliofiscal" ).click(function() {
    	if ($( "#CheckFoliofiscal" ).is(':checked')){
			crearCookie("mostrarFoliofiscalFacturacion", "si");
			$('.Cfoliofiscal').show();
		}else{
			crearCookie("mostrarFoliofiscalFacturacion", "no");
			$('.Cfoliofiscal').hide();
		}	
	});
	$( "#CheckObservaciones" ).click(function() {
    	if ($( "#CheckObservaciones" ).is(':checked')){
			crearCookie("mostrarObservacionesFacturacion", "si");
			$('.Cobservaciones').show();
		}else{
			crearCookie("mostrarObservacionesFacturacion", "no");
			$('.Cobservaciones').hide();
		}	
	});
	$( "#CheckRelaciones" ).click(function() {
    	if ($( "#CheckRelaciones" ).is(':checked')){
			crearCookie("mostrarRelacionesFacturacion", "si");
			$('.Crelaciones').show();
		}else{
			crearCookie("mostrarRelacionesFacturacion", "no");
			$('.Crelaciones').hide();
		}	
	});
	$( "#CheckComposicion" ).click(function() {
    	if ($( "#CheckComposicion" ).is(':checked')){
			crearCookie("mostrarComposicionFacturacion", "si");
			$('.Ccomposicion').show();
		}else{
			crearCookie("mostrarComposicionFacturacion", "no");
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


function cancelar_factura(id){
		$("#cajaCancelar"+id).html('<div class="loading">Espere...</div>');
		$.ajax({
			url: '../cancelar/cancelar.php',
			type: "POST",
			data: "submit=&ids="+id, //Pasamos los datos en forma de array
			success: function(mensaje){
				$("#cajaCancelar"+id).html('<div class="botonCancelarI" onclick="(cancelarFactura('+id+'))" title="Cancelar comprobante">');
				mostrarMensaje(mensaje,id,"cancelar");
			}
		});
		return false;
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
	alert(mensaje);
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