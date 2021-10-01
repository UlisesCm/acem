// JavaScript Document
var orden, campoOrden, cantidadamostrar, paginacion;
orden="DESC";
campoOrden="idmovimiento";
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
	if(recuperarCookie("campoOrdenMovimiento")!=null){
		campoOrden=recuperarCookie("campoOrdenMovimiento");
		 $("#campoOrden option[value="+campoOrden+"]").attr("selected",true);
	}else{
		campoOrden="idmovimiento";
		$("#campoOrden option[value="+campoOrden+"]").attr("selected",true);
	}
	
	//Identificar el numero de elementos para mostrar
	if(recuperarCookie("cantidadamostrarMovimiento")!=null){
		cantidadamostrar=recuperarCookie("cantidadamostrarMovimiento");
		 $("#cantidadamostrar option[value="+cantidadamostrar+"]").attr("selected",true);
	}else{
		cantidadamostrar="20";
		$("#cantidadamostrar option[value="+cantidadamostrar+"]").attr("selected",true);
		
	}
	
	//Identificar el tipo de orden
	if(recuperarCookie("ordenMovimiento")=="asc"){
		orden="ASC"
		$('#asc').attr('checked', true);
		$('#desc').attr('checked', false);
	}else if(recuperarCookie("ordenMovimiento")=="desc"){
		orden="DESC"
		$('#asc').attr('checked', false);
		$('#desc').attr('checked', true);
	}else{
		orden="DESC"
		$('#asc').attr('checked', false);
		$('#desc').attr('checked', true);
	}
	//Mostrar u Ocultar Idmovimiento
	if(recuperarCookie("mostrarIdmovimientoMovimiento")=="si"){
		$('.Cidmovimiento').show();
		$('#CheckIdmovimiento').attr('checked', true);
	}else if(recuperarCookie("mostrarIdmovimientoMovimiento")=="no"){
		$('.Cidmovimiento').hide();
		$('#CheckIdmovimiento').attr('checked', false);
	}
	//Mostrar u Ocultar Tipo
	if(recuperarCookie("mostrarTipoMovimiento")=="si"){
		$('.Ctipo').show();
		$('#CheckTipo').attr('checked', true);
	}else if(recuperarCookie("mostrarTipoMovimiento")=="no"){
		$('.Ctipo').hide();
		$('#CheckTipo').attr('checked', false);
	}
	//Mostrar u Ocultar Concepto
	if(recuperarCookie("mostrarConceptoMovimiento")=="si"){
		$('.Cconcepto').show();
		$('#CheckConcepto').attr('checked', true);
	}else if(recuperarCookie("mostrarConceptoMovimiento")=="no"){
		$('.Cconcepto').hide();
		$('#CheckConcepto').attr('checked', false);
	}
	//Mostrar u Ocultar Fechamovimiento
	if(recuperarCookie("mostrarFechamovimientoMovimiento")=="si"){
		$('.Cfechamovimiento').show();
		$('#CheckFechamovimiento').attr('checked', true);
	}else if(recuperarCookie("mostrarFechamovimientoMovimiento")=="no"){
		$('.Cfechamovimiento').hide();
		$('#CheckFechamovimiento').attr('checked', false);
	}
	//Mostrar u Ocultar Idalmacen
	if(recuperarCookie("mostrarIdalmacenMovimiento")=="si"){
		$('.Cidalmacen').show();
		$('#CheckIdalmacen').attr('checked', true);
	}else if(recuperarCookie("mostrarIdalmacenMovimiento")=="no"){
		$('.Cidalmacen').hide();
		$('#CheckIdalmacen').attr('checked', false);
	}
	//Mostrar u Ocultar Numerocomprobante
	if(recuperarCookie("mostrarNumerocomprobanteMovimiento")=="si"){
		$('.Cnumerocomprobante').show();
		$('#CheckNumerocomprobante').attr('checked', true);
	}else if(recuperarCookie("mostrarNumerocomprobanteMovimiento")=="no"){
		$('.Cnumerocomprobante').hide();
		$('#CheckNumerocomprobante').attr('checked', false);
	}
	//Mostrar u Ocultar Comentarios
	if(recuperarCookie("mostrarComentariosMovimiento")=="si"){
		$('.Ccomentarios').show();
		$('#CheckComentarios').attr('checked', true);
	}else if(recuperarCookie("mostrarComentariosMovimiento")=="no"){
		$('.Ccomentarios').hide();
		$('#CheckComentarios').attr('checked', false);
	}
	//Mostrar u Ocultar Composicion
	if(recuperarCookie("mostrarComposicionMovimiento")=="si"){
		$('.Ccomposicion').show();
		$('#CheckComposicion').attr('checked', true);
	}
	if(recuperarCookie("mostrarComposicionMovimiento")=="no"){
		$('.Ccomposicion').hide();
		$('#CheckComposicion').attr('checked', false);
	}
	
	//Elegir el tipo de vista
	if(recuperarCookie("tipoVistaMovimiento")=="tabla"){
		$('.tipoLista').show();
		$('.tipoTabla').hide();
		tipoVista="tabla";
	}else{
		$('.tipoLista').hide();
		$('.tipoTabla').show();
		tipoVista="lista";
	}
	$( ".tipoTabla" ).click(function() {
    	crearCookie("tipoVistaMovimiento", "tabla");
		tipoVista="tabla";
		$(".tipoLista").show();
		$(".tipoTabla").hide();
		load_tablas();
	});
	$( ".tipoLista" ).click(function() {
    	crearCookie("tipoVistaMovimiento", "lista");
		tipoVista="lista";
		$(".tipoLista").hide();
		$(".tipoTabla").show();
		load_tablas();
	});
	
	$( "#idalmacen_ajax" ).change(function() {
		load_tablas();
	});

}

function llenarSelectAlmacen(seleccionado,condicion){
		$("#idalmacen_ajax").html("<option value='1'>cargando...</option>");
		$.ajax({
			url: '../componentes/llenarSelectAlmacen.php',
			type: "POST",
			data: "submit=&condicion="+condicion+"&seleccionado="+seleccionado, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#idalmacen_ajax").html(mensaje);
			}
		});
		return false;
}
	
$(document).ready(function() {
	$("#cajaBuscar").focus();
	comprobarReglas();
	llenarSelectAlmacen(idalmacenSeleccionado,"");
	load_tablas();
	
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
		crearCookie("campoOrdenMovimiento", campoOrden);
		load_tablas();
	});
	$("#cantidadamostrar").change(function(){
		cantidadamostrar = this.value;
		crearCookie("cantidadamostrarMovimiento", cantidadamostrar);
		load_tablas();
	});
	$( "#asc" ).click(function() {
    	if ($( "#asc" ).is(':checked')){
			crearCookie("ordenMovimiento", "asc");
			orden="ASC"
			load_tablas();
		}
	});
	$( "#desc" ).click(function() {
    	if ($( "#desc" ).is(':checked')){
			crearCookie("ordenMovimiento", "desc");
			orden="DESC"
			load_tablas();
		}
	});
	$( "#CheckIdmovimiento" ).click(function() {
    	if ($( "#CheckIdmovimiento" ).is(':checked')){
			crearCookie("mostrarIdmovimientoMovimiento", "si");
			$('.Cidmovimiento').show();
		}else{
			crearCookie("mostrarIdmovimientoMovimiento", "no");
			$('.Cidmovimiento').hide();
		}	
	});
	$( "#CheckTipo" ).click(function() {
    	if ($( "#CheckTipo" ).is(':checked')){
			crearCookie("mostrarTipoMovimiento", "si");
			$('.Ctipo').show();
		}else{
			crearCookie("mostrarTipoMovimiento", "no");
			$('.Ctipo').hide();
		}	
	});
	$( "#CheckConcepto" ).click(function() {
    	if ($( "#CheckConcepto" ).is(':checked')){
			crearCookie("mostrarConceptoMovimiento", "si");
			$('.Cconcepto').show();
		}else{
			crearCookie("mostrarConceptoMovimiento", "no");
			$('.Cconcepto').hide();
		}	
	});
	$( "#CheckFechamovimiento" ).click(function() {
    	if ($( "#CheckFechamovimiento" ).is(':checked')){
			crearCookie("mostrarFechamovimientoMovimiento", "si");
			$('.Cfechamovimiento').show();
		}else{
			crearCookie("mostrarFechamovimientoMovimiento", "no");
			$('.Cfechamovimiento').hide();
		}	
	});
	$( "#CheckIdalmacen" ).click(function() {
    	if ($( "#CheckIdalmacen" ).is(':checked')){
			crearCookie("mostrarIdalmacenMovimiento", "si");
			$('.Cidalmacen').show();
		}else{
			crearCookie("mostrarIdalmacenMovimiento", "no");
			$('.Cidalmacen').hide();
		}	
	});
	$( "#CheckNumerocomprobante" ).click(function() {
    	if ($( "#CheckNumerocomprobante" ).is(':checked')){
			crearCookie("mostrarNumerocomprobanteMovimiento", "si");
			$('.Cnumerocomprobante').show();
		}else{
			crearCookie("mostrarNumerocomprobanteMovimiento", "no");
			$('.Cnumerocomprobante').hide();
		}	
	});
	$( "#CheckComentarios" ).click(function() {
    	if ($( "#CheckComentarios" ).is(':checked')){
			crearCookie("mostrarComentariosMovimiento", "si");
			$('.Ccomentarios').show();
		}else{
			crearCookie("mostrarComentariosMovimiento", "no");
			$('.Ccomentarios').hide();
		}	
	});
	$( "#CheckComposicion" ).click(function() {
    	if ($( "#CheckComposicion" ).is(':checked')){
			crearCookie("mostrarComposicionMovimiento", "si");
			$('.Ccomposicion').show();
		}else{
			crearCookie("mostrarComposicionMovimiento", "no");
			$('.Ccomposicion').hide();
		}
	});
	
	$(".botonBuscar").click(function() {
		var idproducto=$.trim( $("#cajaBuscar").val());
		load_tablas();
	});
	
	 $("#cajaBuscar").keypress(function(event){  
      	var keycode = (event.keyCode ? event.keyCode : event.which); 
      	if(keycode == '13'){  
      		load_tablas();
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
function load_tablas(){
	//alert (orden);
	//alert (campoOrden);
	//alert (limit);
	//var idalmacen=$("#idalmacen_ajax").val();
	//var idproducto=$.trim( $("#cajaBuscar").val());
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
	
	xmlhttp.open("POST","consultar.php?idproducto="+idproducto+"&idsucursal="+idsucursal, true);
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