// JavaScript Document
var orden, campoOrden, cantidadamostrar, paginacion;
orden="DESC";
campoOrden="idcodigo";
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
	if(recuperarCookie("campoOrdenCodigo")!=null){
		campoOrden=recuperarCookie("campoOrdenCodigo");
		 $("#campoOrden option[value="+campoOrden+"]").attr("selected",true);
	}else{
		campoOrden="idcodigo";
		$("#campoOrden option[value="+campoOrden+"]").attr("selected",true);
	}
	
	//Identificar el numero de elementos para mostrar
	if(recuperarCookie("cantidadamostrarCodigo")!=null){
		cantidadamostrar=recuperarCookie("cantidadamostrarCodigo");
		 $("#cantidadamostrar option[value="+cantidadamostrar+"]").attr("selected",true);
	}else{
		cantidadamostrar="20";
		$("#cantidadamostrar option[value="+cantidadamostrar+"]").attr("selected",true);
		
	}
	
	//Identificar el tipo de orden
	if(recuperarCookie("ordenCodigo")=="asc"){
		orden="ASC"
		$('#asc').attr('checked', true);
		$('#desc').attr('checked', false);
	}else if(recuperarCookie("ordenCodigo")=="desc"){
		orden="DESC"
		$('#asc').attr('checked', false);
		$('#desc').attr('checked', true);
	}else{
		orden="DESC"
		$('#asc').attr('checked', false);
		$('#desc').attr('checked', true);
	}
	//Mostrar u Ocultar Idcodigo
	if(recuperarCookie("mostrarIdcodigoCodigo")=="si"){
		$('.Cidcodigo').show();
		$('#CheckIdcodigo').attr('checked', true);
	}else if(recuperarCookie("mostrarIdcodigoCodigo")=="no"){
		$('.Cidcodigo').hide();
		$('#CheckIdcodigo').attr('checked', false);
	}
	//Mostrar u Ocultar Codigo
	if(recuperarCookie("mostrarCodigoCodigo")=="si"){
		$('.Ccodigo').show();
		$('#CheckCodigo').attr('checked', true);
	}else if(recuperarCookie("mostrarCodigoCodigo")=="no"){
		$('.Ccodigo').hide();
		$('#CheckCodigo').attr('checked', false);
	}
	//Mostrar u Ocultar Tipo
	if(recuperarCookie("mostrarTipoCodigo")=="si"){
		$('.Ctipo').show();
		$('#CheckTipo').attr('checked', true);
	}else if(recuperarCookie("mostrarTipoCodigo")=="no"){
		$('.Ctipo').hide();
		$('#CheckTipo').attr('checked', false);
	}
	//Mostrar u Ocultar Idvendedor
	if(recuperarCookie("mostrarIdvendedorCodigo")=="si"){
		$('.Cidvendedor').show();
		$('#CheckIdvendedor').attr('checked', true);
	}else if(recuperarCookie("mostrarIdvendedorCodigo")=="no"){
		$('.Cidvendedor').hide();
		$('#CheckIdvendedor').attr('checked', false);
	}
	//Mostrar u Ocultar Serie
	if(recuperarCookie("mostrarSerieCodigo")=="si"){
		$('.Cserie').show();
		$('#CheckSerie').attr('checked', true);
	}else if(recuperarCookie("mostrarSerieCodigo")=="no"){
		$('.Cserie').hide();
		$('#CheckSerie').attr('checked', false);
	}
	//Mostrar u Ocultar Estado
	if(recuperarCookie("mostrarEstadoCodigo")=="si"){
		$('.Cestado').show();
		$('#CheckEstado').attr('checked', true);
	}else if(recuperarCookie("mostrarEstadoCodigo")=="no"){
		$('.Cestado').hide();
		$('#CheckEstado').attr('checked', false);
	}
	//Mostrar u Ocultar Preciopublico
	if(recuperarCookie("mostrarPreciopublicoCodigo")=="si"){
		$('.Cpreciopublico').show();
		$('#CheckPreciopublico').attr('checked', true);
	}else if(recuperarCookie("mostrarPreciopublicoCodigo")=="no"){
		$('.Cpreciopublico').hide();
		$('#CheckPreciopublico').attr('checked', false);
	}
	//Mostrar u Ocultar Comisiongeneral
	if(recuperarCookie("mostrarComisiongeneralCodigo")=="si"){
		$('.Ccomisiongeneral').show();
		$('#CheckComisiongeneral').attr('checked', true);
	}else if(recuperarCookie("mostrarComisiongeneralCodigo")=="no"){
		$('.Ccomisiongeneral').hide();
		$('#CheckComisiongeneral').attr('checked', false);
	}
	//Mostrar u Ocultar Comisionreferenciado
	if(recuperarCookie("mostrarComisionreferenciadoCodigo")=="si"){
		$('.Ccomisionreferenciado').show();
		$('#CheckComisionreferenciado').attr('checked', true);
	}else if(recuperarCookie("mostrarComisionreferenciadoCodigo")=="no"){
		$('.Ccomisionreferenciado').hide();
		$('#CheckComisionreferenciado').attr('checked', false);
	}
	//Mostrar u Ocultar Comisionmaster
	if(recuperarCookie("mostrarComisionmasterCodigo")=="si"){
		$('.Ccomisionmaster').show();
		$('#CheckComisionmaster').attr('checked', true);
	}else if(recuperarCookie("mostrarComisionmasterCodigo")=="no"){
		$('.Ccomisionmaster').hide();
		$('#CheckComisionmaster').attr('checked', false);
	}
	//Mostrar u Ocultar Idcliente
	if(recuperarCookie("mostrarIdclienteCodigo")=="si"){
		$('.Cidcliente').show();
		$('#CheckIdcliente').attr('checked', true);
	}else if(recuperarCookie("mostrarIdclienteCodigo")=="no"){
		$('.Cidcliente').hide();
		$('#CheckIdcliente').attr('checked', false);
	}
	//Mostrar u Ocultar MAC
	if(recuperarCookie("mostrarMACCodigo")=="si"){
		$('.CMAC').show();
		$('#CheckMAC').attr('checked', true);
	}else if(recuperarCookie("mostrarMACCodigo")=="no"){
		$('.CMAC').hide();
		$('#CheckMAC').attr('checked', false);
	}
	//Mostrar u Ocultar Fechacorte
	if(recuperarCookie("mostrarFechacorteCodigo")=="si"){
		$('.Cfechacorte').show();
		$('#CheckFechacorte').attr('checked', true);
	}else if(recuperarCookie("mostrarFechacorteCodigo")=="no"){
		$('.Cfechacorte').hide();
		$('#CheckFechacorte').attr('checked', false);
	}
	//Mostrar u Ocultar Fechacreacion
	if(recuperarCookie("mostrarFechacreacionCodigo")=="si"){
		$('.Cfechacreacion').show();
		$('#CheckFechacreacion').attr('checked', true);
	}else if(recuperarCookie("mostrarFechacreacionCodigo")=="no"){
		$('.Cfechacreacion').hide();
		$('#CheckFechacreacion').attr('checked', false);
	}
	//Mostrar u Ocultar Tiemporestante
	if(recuperarCookie("mostrarTiemporestanteCodigo")=="si"){
		$('.Ctiemporestante').show();
		$('#CheckTiemporestante').attr('checked', true);
	}else if(recuperarCookie("mostrarTiemporestanteCodigo")=="no"){
		$('.Ctiemporestante').hide();
		$('#CheckTiemporestante').attr('checked', false);
	}
	//Mostrar u Ocultar Idusuariocreacion
	if(recuperarCookie("mostrarIdusuariocreacionCodigo")=="si"){
		$('.Cidusuariocreacion').show();
		$('#CheckIdusuariocreacion').attr('checked', true);
	}else if(recuperarCookie("mostrarIdusuariocreacionCodigo")=="no"){
		$('.Cidusuariocreacion').hide();
		$('#CheckIdusuariocreacion').attr('checked', false);
	}
	//Mostrar u Ocultar Idusuariocorte
	if(recuperarCookie("mostrarIdusuariocorteCodigo")=="si"){
		$('.Cidusuariocorte').show();
		$('#CheckIdusuariocorte').attr('checked', true);
	}else if(recuperarCookie("mostrarIdusuariocorteCodigo")=="no"){
		$('.Cidusuariocorte').hide();
		$('#CheckIdusuariocorte').attr('checked', false);
	}
	//Mostrar u Ocultar Composicion
	if(recuperarCookie("mostrarComposicionCodigo")=="si"){
		$('.Ccomposicion').show();
		$('#CheckComposicion').attr('checked', true);
	}
	if(recuperarCookie("mostrarComposicionCodigo")=="no"){
		$('.Ccomposicion').hide();
		$('#CheckComposicion').attr('checked', false);
	}
	
	//Elegir el tipo de vista
	if(recuperarCookie("tipoVistaCodigo")=="tabla"){
		$('.tipoLista').show();
		$('.tipoTabla').hide();
		tipoVista="tabla";
	}else{
		$('.tipoLista').hide();
		$('.tipoTabla').show();
		tipoVista="lista";
	}
	$( ".tipoTabla" ).click(function() {
    	crearCookie("tipoVistaCodigo", "tabla");
		tipoVista="tabla";
		$(".tipoLista").show();
		$(".tipoTabla").hide();
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$( ".tipoLista" ).click(function() {
    	crearCookie("tipoVistaCodigo", "lista");
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
		crearCookie("campoOrdenCodigo", campoOrden);
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$("#cantidadamostrar").change(function(){
		cantidadamostrar = this.value;
		crearCookie("cantidadamostrarCodigo", cantidadamostrar);
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$( "#asc" ).click(function() {
    	if ($( "#asc" ).is(':checked')){
			crearCookie("ordenCodigo", "asc");
			orden="ASC"
			load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
		}
	});
	$( "#desc" ).click(function() {
    	if ($( "#desc" ).is(':checked')){
			crearCookie("ordenCodigo", "desc");
			orden="DESC"
			load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
		}
	});
	$( "#CheckIdcodigo" ).click(function() {
    	if ($( "#CheckIdcodigo" ).is(':checked')){
			crearCookie("mostrarIdcodigoCodigo", "si");
			$('.Cidcodigo').show();
		}else{
			crearCookie("mostrarIdcodigoCodigo", "no");
			$('.Cidcodigo').hide();
		}	
	});
	$( "#CheckCodigo" ).click(function() {
    	if ($( "#CheckCodigo" ).is(':checked')){
			crearCookie("mostrarCodigoCodigo", "si");
			$('.Ccodigo').show();
		}else{
			crearCookie("mostrarCodigoCodigo", "no");
			$('.Ccodigo').hide();
		}	
	});
	$( "#CheckTipo" ).click(function() {
    	if ($( "#CheckTipo" ).is(':checked')){
			crearCookie("mostrarTipoCodigo", "si");
			$('.Ctipo').show();
		}else{
			crearCookie("mostrarTipoCodigo", "no");
			$('.Ctipo').hide();
		}	
	});
	$( "#CheckIdvendedor" ).click(function() {
    	if ($( "#CheckIdvendedor" ).is(':checked')){
			crearCookie("mostrarIdvendedorCodigo", "si");
			$('.Cidvendedor').show();
		}else{
			crearCookie("mostrarIdvendedorCodigo", "no");
			$('.Cidvendedor').hide();
		}	
	});
	$( "#CheckSerie" ).click(function() {
    	if ($( "#CheckSerie" ).is(':checked')){
			crearCookie("mostrarSerieCodigo", "si");
			$('.Cserie').show();
		}else{
			crearCookie("mostrarSerieCodigo", "no");
			$('.Cserie').hide();
		}	
	});
	$( "#CheckEstado" ).click(function() {
    	if ($( "#CheckEstado" ).is(':checked')){
			crearCookie("mostrarEstadoCodigo", "si");
			$('.Cestado').show();
		}else{
			crearCookie("mostrarEstadoCodigo", "no");
			$('.Cestado').hide();
		}	
	});
	$( "#CheckPreciopublico" ).click(function() {
    	if ($( "#CheckPreciopublico" ).is(':checked')){
			crearCookie("mostrarPreciopublicoCodigo", "si");
			$('.Cpreciopublico').show();
		}else{
			crearCookie("mostrarPreciopublicoCodigo", "no");
			$('.Cpreciopublico').hide();
		}	
	});
	$( "#CheckComisiongeneral" ).click(function() {
    	if ($( "#CheckComisiongeneral" ).is(':checked')){
			crearCookie("mostrarComisiongeneralCodigo", "si");
			$('.Ccomisiongeneral').show();
		}else{
			crearCookie("mostrarComisiongeneralCodigo", "no");
			$('.Ccomisiongeneral').hide();
		}	
	});
	$( "#CheckComisionreferenciado" ).click(function() {
    	if ($( "#CheckComisionreferenciado" ).is(':checked')){
			crearCookie("mostrarComisionreferenciadoCodigo", "si");
			$('.Ccomisionreferenciado').show();
		}else{
			crearCookie("mostrarComisionreferenciadoCodigo", "no");
			$('.Ccomisionreferenciado').hide();
		}	
	});
	$( "#CheckComisionmaster" ).click(function() {
    	if ($( "#CheckComisionmaster" ).is(':checked')){
			crearCookie("mostrarComisionmasterCodigo", "si");
			$('.Ccomisionmaster').show();
		}else{
			crearCookie("mostrarComisionmasterCodigo", "no");
			$('.Ccomisionmaster').hide();
		}	
	});
	$( "#CheckIdcliente" ).click(function() {
    	if ($( "#CheckIdcliente" ).is(':checked')){
			crearCookie("mostrarIdclienteCodigo", "si");
			$('.Cidcliente').show();
		}else{
			crearCookie("mostrarIdclienteCodigo", "no");
			$('.Cidcliente').hide();
		}	
	});
	$( "#CheckMAC" ).click(function() {
    	if ($( "#CheckMAC" ).is(':checked')){
			crearCookie("mostrarMACCodigo", "si");
			$('.CMAC').show();
		}else{
			crearCookie("mostrarMACCodigo", "no");
			$('.CMAC').hide();
		}	
	});
	$( "#CheckFechacorte" ).click(function() {
    	if ($( "#CheckFechacorte" ).is(':checked')){
			crearCookie("mostrarFechacorteCodigo", "si");
			$('.Cfechacorte').show();
		}else{
			crearCookie("mostrarFechacorteCodigo", "no");
			$('.Cfechacorte').hide();
		}	
	});
	$( "#CheckFechacreacion" ).click(function() {
    	if ($( "#CheckFechacreacion" ).is(':checked')){
			crearCookie("mostrarFechacreacionCodigo", "si");
			$('.Cfechacreacion').show();
		}else{
			crearCookie("mostrarFechacreacionCodigo", "no");
			$('.Cfechacreacion').hide();
		}	
	});
	$( "#CheckTiemporestante" ).click(function() {
    	if ($( "#CheckTiemporestante" ).is(':checked')){
			crearCookie("mostrarTiemporestanteCodigo", "si");
			$('.Ctiemporestante').show();
		}else{
			crearCookie("mostrarTiemporestanteCodigo", "no");
			$('.Ctiemporestante').hide();
		}	
	});
	$( "#CheckIdusuariocreacion" ).click(function() {
    	if ($( "#CheckIdusuariocreacion" ).is(':checked')){
			crearCookie("mostrarIdusuariocreacionCodigo", "si");
			$('.Cidusuariocreacion').show();
		}else{
			crearCookie("mostrarIdusuariocreacionCodigo", "no");
			$('.Cidusuariocreacion').hide();
		}	
	});
	$( "#CheckIdusuariocorte" ).click(function() {
    	if ($( "#CheckIdusuariocorte" ).is(':checked')){
			crearCookie("mostrarIdusuariocorteCodigo", "si");
			$('.Cidusuariocorte').show();
		}else{
			crearCookie("mostrarIdusuariocorteCodigo", "no");
			$('.Cidusuariocorte').hide();
		}	
	});
	$( "#CheckComposicion" ).click(function() {
    	if ($( "#CheckComposicion" ).is(':checked')){
			crearCookie("mostrarComposicionCodigo", "si");
			$('.Ccomposicion').show();
		}else{
			crearCookie("mostrarComposicionCodigo", "no");
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