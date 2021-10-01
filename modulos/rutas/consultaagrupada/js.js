// JavaScript Document
var orden, campoOrden, cantidadamostrar, paginacion;
orden="DESC";
campoOrden="iddetallecotizacion";
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
	if(recuperarCookie("campoOrdenDetallecotizacionproducto")!=null){
		campoOrden=recuperarCookie("campoOrdenDetallecotizacionproducto");
		 $("#campoOrden option[value="+campoOrden+"]").attr("selected",true);
	}else{
		campoOrden="iddetallecotizacion";
		$("#campoOrden option[value="+campoOrden+"]").attr("selected",true);
	}
	
	//Identificar el numero de elementos para mostrar
	if(recuperarCookie("cantidadamostrarDetallecotizacionproducto")!=null){
		cantidadamostrar=recuperarCookie("cantidadamostrarDetallecotizacionproducto");
		 $("#cantidadamostrar option[value="+cantidadamostrar+"]").attr("selected",true);
	}else{
		cantidadamostrar="20";
		$("#cantidadamostrar option[value="+cantidadamostrar+"]").attr("selected",true);
		
	}
	
	//Identificar el tipo de orden
	if(recuperarCookie("ordenDetallecotizacionproducto")=="asc"){
		orden="ASC"
		$('#asc').attr('checked', true);
		$('#desc').attr('checked', false);
	}else if(recuperarCookie("ordenDetallecotizacionproducto")=="desc"){
		orden="DESC"
		$('#asc').attr('checked', false);
		$('#desc').attr('checked', true);
	}else{
		orden="DESC"
		$('#asc').attr('checked', false);
		$('#desc').attr('checked', true);
	}
	//Mostrar u Ocultar Iddetallecotizacion
	if(recuperarCookie("mostrarIddetallecotizacionDetallecotizacionproducto")=="si"){
		$('.Ciddetallecotizacion').show();
		$('#CheckIddetallecotizacion').attr('checked', true);
	}else if(recuperarCookie("mostrarIddetallecotizacionDetallecotizacionproducto")=="no"){
		$('.Ciddetallecotizacion').hide();
		$('#CheckIddetallecotizacion').attr('checked', false);
	}
	//Mostrar u Ocultar Subfolio
	if(recuperarCookie("mostrarSubfolioDetallecotizacionproducto")=="si"){
		$('.Csubfolio').show();
		$('#CheckSubfolio').attr('checked', true);
	}else if(recuperarCookie("mostrarSubfolioDetallecotizacionproducto")=="no"){
		$('.Csubfolio').hide();
		$('#CheckSubfolio').attr('checked', false);
	}
	//Mostrar u Ocultar Idproducto
	if(recuperarCookie("mostrarIdproductoDetallecotizacionproducto")=="si"){
		$('.Cidproducto').show();
		$('#CheckIdproducto').attr('checked', true);
	}else if(recuperarCookie("mostrarIdproductoDetallecotizacionproducto")=="no"){
		$('.Cidproducto').hide();
		$('#CheckIdproducto').attr('checked', false);
	}
	//Mostrar u Ocultar Cantidad
	if(recuperarCookie("mostrarCantidadDetallecotizacionproducto")=="si"){
		$('.Ccantidad').show();
		$('#CheckCantidad').attr('checked', true);
	}else if(recuperarCookie("mostrarCantidadDetallecotizacionproducto")=="no"){
		$('.Ccantidad').hide();
		$('#CheckCantidad').attr('checked', false);
	}
	//Mostrar u Ocultar Costo
	if(recuperarCookie("mostrarCostoDetallecotizacionproducto")=="si"){
		$('.Ccosto').show();
		$('#CheckCosto').attr('checked', true);
	}else if(recuperarCookie("mostrarCostoDetallecotizacionproducto")=="no"){
		$('.Ccosto').hide();
		$('#CheckCosto').attr('checked', false);
	}
	//Mostrar u Ocultar Precio
	if(recuperarCookie("mostrarPrecioDetallecotizacionproducto")=="si"){
		$('.Cprecio').show();
		$('#CheckPrecio').attr('checked', true);
	}else if(recuperarCookie("mostrarPrecioDetallecotizacionproducto")=="no"){
		$('.Cprecio').hide();
		$('#CheckPrecio').attr('checked', false);
	}
	//Mostrar u Ocultar Subtotal
	if(recuperarCookie("mostrarSubtotalDetallecotizacionproducto")=="si"){
		$('.Csubtotal').show();
		$('#CheckSubtotal').attr('checked', true);
	}else if(recuperarCookie("mostrarSubtotalDetallecotizacionproducto")=="no"){
		$('.Csubtotal').hide();
		$('#CheckSubtotal').attr('checked', false);
	}
	//Mostrar u Ocultar Impuestos
	if(recuperarCookie("mostrarImpuestosDetallecotizacionproducto")=="si"){
		$('.Cimpuestos').show();
		$('#CheckImpuestos').attr('checked', true);
	}else if(recuperarCookie("mostrarImpuestosDetallecotizacionproducto")=="no"){
		$('.Cimpuestos').hide();
		$('#CheckImpuestos').attr('checked', false);
	}
	//Mostrar u Ocultar Total
	if(recuperarCookie("mostrarTotalDetallecotizacionproducto")=="si"){
		$('.Ctotal').show();
		$('#CheckTotal').attr('checked', true);
	}else if(recuperarCookie("mostrarTotalDetallecotizacionproducto")=="no"){
		$('.Ctotal').hide();
		$('#CheckTotal').attr('checked', false);
	}
	//Mostrar u Ocultar Utilidad
	if(recuperarCookie("mostrarUtilidadDetallecotizacionproducto")=="si"){
		$('.Cutilidad').show();
		$('#CheckUtilidad').attr('checked', true);
	}else if(recuperarCookie("mostrarUtilidadDetallecotizacionproducto")=="no"){
		$('.Cutilidad').hide();
		$('#CheckUtilidad').attr('checked', false);
	}
	//Mostrar u Ocultar Idcotizacionproducto
	if(recuperarCookie("mostrarIdcotizacionproductoDetallecotizacionproducto")=="si"){
		$('.Cidcotizacionproducto').show();
		$('#CheckIdcotizacionproducto').attr('checked', true);
	}else if(recuperarCookie("mostrarIdcotizacionproductoDetallecotizacionproducto")=="no"){
		$('.Cidcotizacionproducto').hide();
		$('#CheckIdcotizacionproducto').attr('checked', false);
	}
	//Mostrar u Ocultar Pesounitario
	if(recuperarCookie("mostrarPesounitarioDetallecotizacionproducto")=="si"){
		$('.Cpesounitario').show();
		$('#CheckPesounitario').attr('checked', true);
	}else if(recuperarCookie("mostrarPesounitarioDetallecotizacionproducto")=="no"){
		$('.Cpesounitario').hide();
		$('#CheckPesounitario').attr('checked', false);
	}
	//Mostrar u Ocultar Cantidadentregada
	if(recuperarCookie("mostrarCantidadentregadaDetallecotizacionproducto")=="si"){
		$('.Ccantidadentregada').show();
		$('#CheckCantidadentregada').attr('checked', true);
	}else if(recuperarCookie("mostrarCantidadentregadaDetallecotizacionproducto")=="no"){
		$('.Ccantidadentregada').hide();
		$('#CheckCantidadentregada').attr('checked', false);
	}
	//Mostrar u Ocultar Composicion
	if(recuperarCookie("mostrarComposicionDetallecotizacionproducto")=="si"){
		$('.Ccomposicion').show();
		$('#CheckComposicion').attr('checked', true);
	}
	if(recuperarCookie("mostrarComposicionDetallecotizacionproducto")=="no"){
		$('.Ccomposicion').hide();
		$('#CheckComposicion').attr('checked', false);
	}
	
	//Elegir el tipo de vista
	if(recuperarCookie("tipoVistaDetallecotizacionproducto")=="tabla"){
		$('.tipoLista').show();
		$('.tipoTabla').hide();
		tipoVista="tabla";
	}else{
		$('.tipoLista').hide();
		$('.tipoTabla').show();
		tipoVista="lista";
	}
	$( ".tipoTabla" ).click(function() {
    	crearCookie("tipoVistaDetallecotizacionproducto", "tabla");
		tipoVista="tabla";
		$(".tipoLista").show();
		$(".tipoTabla").hide();
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$( ".tipoLista" ).click(function() {
    	crearCookie("tipoVistaDetallecotizacionproducto", "lista");
		tipoVista="lista";
		$(".tipoLista").hide();
		$(".tipoTabla").show();
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});

}

	
$(document).ready(function() {
	$("#cajaBuscar").focus();
	comprobarReglas();
	if($("#idruta").val()!=""){
	    load_tablas(campoOrden,orden,cantidadamostrar,paginacion,busqueda,tipoVista);
	}
	//COMPROBAR SI HAY UN IDCOTIZACIÓN CARGADO EN EL TEXTO IDCOTICAZION DE SER VERDADERO CONSULTAR TODOS LOS SERVICIOS RELACIONADOS
	if($("#idcotizacionproducto").val()!=""){
	    load_tablas(campoOrden,orden,cantidadamostrar,paginacion,busqueda,tipoVista);
	}
	
	//QUITO LA FUNCION load_tablas PARA QUE NO CONSULTE POR DEFAULT SI NO HASTA QUE LE DEN CLIC EN FILTRAR
	//load_tablas(campoOrden,orden,cantidadamostrar,paginacion,busqueda,tipoVista);
	$("#loading").hide();//ocultar engrane que se queda como si estuviera consultando
	
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
		crearCookie("campoOrdenDetallecotizacionproducto", campoOrden);
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$("#cantidadamostrar").change(function(){
		cantidadamostrar = this.value;
		crearCookie("cantidadamostrarDetallecotizacionproducto", cantidadamostrar);
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$( "#asc" ).click(function() {
    	if ($( "#asc" ).is(':checked')){
			crearCookie("ordenDetallecotizacionproducto", "asc");
			orden="ASC"
			load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
		}
	});
	$( "#desc" ).click(function() {
    	if ($( "#desc" ).is(':checked')){
			crearCookie("ordenDetallecotizacionproducto", "desc");
			orden="DESC"
			load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
		}
	});
	$( "#CheckIddetallecotizacion" ).click(function() {
    	if ($( "#CheckIddetallecotizacion" ).is(':checked')){
			crearCookie("mostrarIddetallecotizacionDetallecotizacionproducto", "si");
			$('.Ciddetallecotizacion').show();
		}else{
			crearCookie("mostrarIddetallecotizacionDetallecotizacionproducto", "no");
			$('.Ciddetallecotizacion').hide();
		}	
	});
	$( "#CheckSubfolio" ).click(function() {
    	if ($( "#CheckSubfolio" ).is(':checked')){
			crearCookie("mostrarSubfolioDetallecotizacionproducto", "si");
			$('.Csubfolio').show();
		}else{
			crearCookie("mostrarSubfolioDetallecotizacionproducto", "no");
			$('.Csubfolio').hide();
		}	
	});
	$( "#CheckIdproducto" ).click(function() {
    	if ($( "#CheckIdproducto" ).is(':checked')){
			crearCookie("mostrarIdproductoDetallecotizacionproducto", "si");
			$('.Cidproducto').show();
		}else{
			crearCookie("mostrarIdproductoDetallecotizacionproducto", "no");
			$('.Cidproducto').hide();
		}	
	});
	$( "#CheckCantidad" ).click(function() {
    	if ($( "#CheckCantidad" ).is(':checked')){
			crearCookie("mostrarCantidadDetallecotizacionproducto", "si");
			$('.Ccantidad').show();
		}else{
			crearCookie("mostrarCantidadDetallecotizacionproducto", "no");
			$('.Ccantidad').hide();
		}	
	});
	$( "#CheckCosto" ).click(function() {
    	if ($( "#CheckCosto" ).is(':checked')){
			crearCookie("mostrarCostoDetallecotizacionproducto", "si");
			$('.Ccosto').show();
		}else{
			crearCookie("mostrarCostoDetallecotizacionproducto", "no");
			$('.Ccosto').hide();
		}	
	});
	$( "#CheckPrecio" ).click(function() {
    	if ($( "#CheckPrecio" ).is(':checked')){
			crearCookie("mostrarPrecioDetallecotizacionproducto", "si");
			$('.Cprecio').show();
		}else{
			crearCookie("mostrarPrecioDetallecotizacionproducto", "no");
			$('.Cprecio').hide();
		}	
	});
	$( "#CheckSubtotal" ).click(function() {
    	if ($( "#CheckSubtotal" ).is(':checked')){
			crearCookie("mostrarSubtotalDetallecotizacionproducto", "si");
			$('.Csubtotal').show();
		}else{
			crearCookie("mostrarSubtotalDetallecotizacionproducto", "no");
			$('.Csubtotal').hide();
		}	
	});
	$( "#CheckImpuestos" ).click(function() {
    	if ($( "#CheckImpuestos" ).is(':checked')){
			crearCookie("mostrarImpuestosDetallecotizacionproducto", "si");
			$('.Cimpuestos').show();
		}else{
			crearCookie("mostrarImpuestosDetallecotizacionproducto", "no");
			$('.Cimpuestos').hide();
		}	
	});
	$( "#CheckTotal" ).click(function() {
    	if ($( "#CheckTotal" ).is(':checked')){
			crearCookie("mostrarTotalDetallecotizacionproducto", "si");
			$('.Ctotal').show();
		}else{
			crearCookie("mostrarTotalDetallecotizacionproducto", "no");
			$('.Ctotal').hide();
		}	
	});
	$( "#CheckUtilidad" ).click(function() {
    	if ($( "#CheckUtilidad" ).is(':checked')){
			crearCookie("mostrarUtilidadDetallecotizacionproducto", "si");
			$('.Cutilidad').show();
		}else{
			crearCookie("mostrarUtilidadDetallecotizacionproducto", "no");
			$('.Cutilidad').hide();
		}	
	});
	$( "#CheckIdcotizacionproducto" ).click(function() {
    	if ($( "#CheckIdcotizacionproducto" ).is(':checked')){
			crearCookie("mostrarIdcotizacionproductoDetallecotizacionproducto", "si");
			$('.Cidcotizacionproducto').show();
		}else{
			crearCookie("mostrarIdcotizacionproductoDetallecotizacionproducto", "no");
			$('.Cidcotizacionproducto').hide();
		}	
	});
	$( "#CheckPesounitario" ).click(function() {
    	if ($( "#CheckPesounitario" ).is(':checked')){
			crearCookie("mostrarPesounitarioDetallecotizacionproducto", "si");
			$('.Cpesounitario').show();
		}else{
			crearCookie("mostrarPesounitarioDetallecotizacionproducto", "no");
			$('.Cpesounitario').hide();
		}	
	});
	$( "#CheckCantidadentregada" ).click(function() {
    	if ($( "#CheckCantidadentregada" ).is(':checked')){
			crearCookie("mostrarCantidadentregadaDetallecotizacionproducto", "si");
			$('.Ccantidadentregada').show();
		}else{
			crearCookie("mostrarCantidadentregadaDetallecotizacionproducto", "no");
			$('.Ccantidadentregada').hide();
		}	
	});
	$( "#CheckComposicion" ).click(function() {
    	if ($( "#CheckComposicion" ).is(':checked')){
			crearCookie("mostrarComposicionDetallecotizacionproducto", "si");
			$('.Ccomposicion').show();
		}else{
			crearCookie("mostrarComposicionDetallecotizacionproducto", "no");
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
	
	$("#botonAceptar").click(function(){
		autorizarSalida($("#idcotizacionproducto").val(),$("#observaciones").val());
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
	
	
	var variables = $("#formulario").serialize();
	if($("#idruta").val()!=""){
	   variables = $("#formularioconsultasalida").serialize();
	}
	
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

function autorizarSalida(idcotizacionproducto,observaciones){
	//var autorizacion = $(".Cautorizada"+no).html();
	$("#loading").show();
	$.ajax({
		url: 'autorizarSalida.php',
		type: "POST",
		data: "submit=&idcotizacionproducto="+idcotizacionproducto+"&observaciones="+observaciones, //Pasamos los datos en forma de array
		success: function(mensaje){
			$("#loading").hide();
			mostrarMensaje(mensaje);
			load_tablas(campoOrden,orden,cantidadamostrar,paginacion,busqueda,tipoVista);
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