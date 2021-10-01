// JavaScript Document
var orden, campoOrden, cantidadamostrar, paginacion;
orden="DESC";
campoOrden="idkardex";
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
	if(recuperarCookie("campoOrdenKardex")!=null){
		campoOrden=recuperarCookie("campoOrdenKardex");
		 $("#campoOrden option[value="+campoOrden+"]").attr("selected",true);
	}else{
		campoOrden="idkardex";
		$("#campoOrden option[value="+campoOrden+"]").attr("selected",true);
	}
	
	//Identificar el numero de elementos para mostrar
	if(recuperarCookie("cantidadamostrarKardex")!=null){
		cantidadamostrar=recuperarCookie("cantidadamostrarKardex");
		 $("#cantidadamostrar option[value="+cantidadamostrar+"]").attr("selected",true);
	}else{
		cantidadamostrar="20";
		$("#cantidadamostrar option[value="+cantidadamostrar+"]").attr("selected",true);
		
	}
	
	//Identificar el tipo de orden
	if(recuperarCookie("ordenKardex")=="asc"){
		orden="ASC"
		$('#asc').attr('checked', true);
		$('#desc').attr('checked', false);
	}else if(recuperarCookie("ordenKardex")=="desc"){
		orden="DESC"
		$('#asc').attr('checked', false);
		$('#desc').attr('checked', true);
	}else{
		orden="DESC"
		$('#asc').attr('checked', false);
		$('#desc').attr('checked', true);
	}
	//Mostrar u Ocultar Idkardex
	if(recuperarCookie("mostrarIdkardexKardex")=="si"){
		$('.Cidkardex').show();
		$('#CheckIdkardex').attr('checked', true);
	}else if(recuperarCookie("mostrarIdkardexKardex")=="no"){
		$('.Cidkardex').hide();
		$('#CheckIdkardex').attr('checked', false);
	}
	//Mostrar u Ocultar Idproducto
	if(recuperarCookie("mostrarIdproductoKardex")=="si"){
		$('.Cidproducto').show();
		$('#CheckIdproducto').attr('checked', true);
	}else if(recuperarCookie("mostrarIdproductoKardex")=="no"){
		$('.Cidproducto').hide();
		$('#CheckIdproducto').attr('checked', false);
	}
	//Mostrar u Ocultar Fechamovimiento
	if(recuperarCookie("mostrarFechamovimientoKardex")=="si"){
		$('.Cfechamovimiento').show();
		$('#CheckFechamovimiento').attr('checked', true);
	}else if(recuperarCookie("mostrarFechamovimientoKardex")=="no"){
		$('.Cfechamovimiento').hide();
		$('#CheckFechamovimiento').attr('checked', false);
	}
	//Mostrar u Ocultar Descripcion
	if(recuperarCookie("mostrarDescripcionKardex")=="si"){
		$('.Cdescripcion').show();
		$('#CheckDescripcion').attr('checked', true);
	}else if(recuperarCookie("mostrarDescripcionKardex")=="no"){
		$('.Cdescripcion').hide();
		$('#CheckDescripcion').attr('checked', false);
	}
	//Mostrar u Ocultar Observaciones
	if(recuperarCookie("mostrarObservacionesKardex")=="si"){
		$('.Cobservaciones').show();
		$('#CheckObservaciones').attr('checked', true);
	}else if(recuperarCookie("mostrarObservacionesKardex")=="no"){
		$('.Cobservaciones').hide();
		$('#CheckObservaciones').attr('checked', false);
	}
	//Mostrar u Ocultar Entrada
	if(recuperarCookie("mostrarEntradaKardex")=="si"){
		$('.Centrada').show();
		$('#CheckEntrada').attr('checked', true);
	}else if(recuperarCookie("mostrarEntradaKardex")=="no"){
		$('.Centrada').hide();
		$('#CheckEntrada').attr('checked', false);
	}
	//Mostrar u Ocultar Salida
	if(recuperarCookie("mostrarSalidaKardex")=="si"){
		$('.Csalida').show();
		$('#CheckSalida').attr('checked', true);
	}else if(recuperarCookie("mostrarSalidaKardex")=="no"){
		$('.Csalida').hide();
		$('#CheckSalida').attr('checked', false);
	}
	//Mostrar u Ocultar Existencia
	if(recuperarCookie("mostrarExistenciaKardex")=="si"){
		$('.Cexistencia').show();
		$('#CheckExistencia').attr('checked', true);
	}else if(recuperarCookie("mostrarExistenciaKardex")=="no"){
		$('.Cexistencia').hide();
		$('#CheckExistencia').attr('checked', false);
	}
	//Mostrar u Ocultar Costounitario
	if(recuperarCookie("mostrarCostounitarioKardex")=="si"){
		$('.Ccostounitario').show();
		$('#CheckCostounitario').attr('checked', true);
	}else if(recuperarCookie("mostrarCostounitarioKardex")=="no"){
		$('.Ccostounitario').hide();
		$('#CheckCostounitario').attr('checked', false);
	}
	//Mostrar u Ocultar Promedio
	if(recuperarCookie("mostrarPromedioKardex")=="si"){
		$('.Cpromedio').show();
		$('#CheckPromedio').attr('checked', true);
	}else if(recuperarCookie("mostrarPromedioKardex")=="no"){
		$('.Cpromedio').hide();
		$('#CheckPromedio').attr('checked', false);
	}
	//Mostrar u Ocultar Debe
	if(recuperarCookie("mostrarDebeKardex")=="si"){
		$('.Cdebe').show();
		$('#CheckDebe').attr('checked', true);
	}else if(recuperarCookie("mostrarDebeKardex")=="no"){
		$('.Cdebe').hide();
		$('#CheckDebe').attr('checked', false);
	}
	//Mostrar u Ocultar Haber
	if(recuperarCookie("mostrarHaberKardex")=="si"){
		$('.Chaber').show();
		$('#CheckHaber').attr('checked', true);
	}else if(recuperarCookie("mostrarHaberKardex")=="no"){
		$('.Chaber').hide();
		$('#CheckHaber').attr('checked', false);
	}
	//Mostrar u Ocultar Saldo
	if(recuperarCookie("mostrarSaldoKardex")=="si"){
		$('.Csaldo').show();
		$('#CheckSaldo').attr('checked', true);
	}else if(recuperarCookie("mostrarSaldoKardex")=="no"){
		$('.Csaldo').hide();
		$('#CheckSaldo').attr('checked', false);
	}
	//Mostrar u Ocultar Idalmacen
	if(recuperarCookie("mostrarIdalmacenKardex")=="si"){
		$('.Cidalmacen').show();
		$('#CheckIdalmacen').attr('checked', true);
	}else if(recuperarCookie("mostrarIdalmacenKardex")=="no"){
		$('.Cidalmacen').hide();
		$('#CheckIdalmacen').attr('checked', false);
	}
	//Mostrar u Ocultar Idmovimiento
	if(recuperarCookie("mostrarIdmovimientoKardex")=="si"){
		$('.Cidmovimiento').show();
		$('#CheckIdmovimiento').attr('checked', true);
	}else if(recuperarCookie("mostrarIdmovimientoKardex")=="no"){
		$('.Cidmovimiento').hide();
		$('#CheckIdmovimiento').attr('checked', false);
	}
	//Mostrar u Ocultar Idreferencia
	if(recuperarCookie("mostrarIdreferenciaKardex")=="si"){
		$('.Cidreferencia').show();
		$('#CheckIdreferencia').attr('checked', true);
	}else if(recuperarCookie("mostrarIdreferenciaKardex")=="no"){
		$('.Cidreferencia').hide();
		$('#CheckIdreferencia').attr('checked', false);
	}
	//Mostrar u Ocultar Composicion
	if(recuperarCookie("mostrarComposicionKardex")=="si"){
		$('.Ccomposicion').show();
		$('#CheckComposicion').attr('checked', true);
	}
	if(recuperarCookie("mostrarComposicionKardex")=="no"){
		$('.Ccomposicion').hide();
		$('#CheckComposicion').attr('checked', false);
	}
	
	//Elegir el tipo de vista
	if(recuperarCookie("tipoVistaKardex")=="tabla"){
		$('.tipoLista').show();
		$('.tipoTabla').hide();
		tipoVista="tabla";
	}else{
		$('.tipoLista').hide();
		$('.tipoTabla').show();
		tipoVista="lista";
	}
	$( ".tipoTabla" ).click(function() {
    	crearCookie("tipoVistaKardex", "tabla");
		tipoVista="tabla";
		$(".tipoLista").show();
		$(".tipoTabla").hide();
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$( ".tipoLista" ).click(function() {
    	crearCookie("tipoVistaKardex", "lista");
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
		crearCookie("campoOrdenKardex", campoOrden);
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$("#cantidadamostrar").change(function(){
		cantidadamostrar = this.value;
		crearCookie("cantidadamostrarKardex", cantidadamostrar);
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$( "#asc" ).click(function() {
    	if ($( "#asc" ).is(':checked')){
			crearCookie("ordenKardex", "asc");
			orden="ASC"
			load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
		}
	});
	$( "#desc" ).click(function() {
    	if ($( "#desc" ).is(':checked')){
			crearCookie("ordenKardex", "desc");
			orden="DESC"
			load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
		}
	});
	$( "#CheckIdkardex" ).click(function() {
    	if ($( "#CheckIdkardex" ).is(':checked')){
			crearCookie("mostrarIdkardexKardex", "si");
			$('.Cidkardex').show();
		}else{
			crearCookie("mostrarIdkardexKardex", "no");
			$('.Cidkardex').hide();
		}	
	});
	$( "#CheckIdproducto" ).click(function() {
    	if ($( "#CheckIdproducto" ).is(':checked')){
			crearCookie("mostrarIdproductoKardex", "si");
			$('.Cidproducto').show();
		}else{
			crearCookie("mostrarIdproductoKardex", "no");
			$('.Cidproducto').hide();
		}	
	});
	$( "#CheckFechamovimiento" ).click(function() {
    	if ($( "#CheckFechamovimiento" ).is(':checked')){
			crearCookie("mostrarFechamovimientoKardex", "si");
			$('.Cfechamovimiento').show();
		}else{
			crearCookie("mostrarFechamovimientoKardex", "no");
			$('.Cfechamovimiento').hide();
		}	
	});
	$( "#CheckDescripcion" ).click(function() {
    	if ($( "#CheckDescripcion" ).is(':checked')){
			crearCookie("mostrarDescripcionKardex", "si");
			$('.Cdescripcion').show();
		}else{
			crearCookie("mostrarDescripcionKardex", "no");
			$('.Cdescripcion').hide();
		}	
	});
	$( "#CheckObservaciones" ).click(function() {
    	if ($( "#CheckObservaciones" ).is(':checked')){
			crearCookie("mostrarObservacionesKardex", "si");
			$('.Cobservaciones').show();
		}else{
			crearCookie("mostrarObservacionesKardex", "no");
			$('.Cobservaciones').hide();
		}	
	});
	$( "#CheckEntrada" ).click(function() {
    	if ($( "#CheckEntrada" ).is(':checked')){
			crearCookie("mostrarEntradaKardex", "si");
			$('.Centrada').show();
		}else{
			crearCookie("mostrarEntradaKardex", "no");
			$('.Centrada').hide();
		}	
	});
	$( "#CheckSalida" ).click(function() {
    	if ($( "#CheckSalida" ).is(':checked')){
			crearCookie("mostrarSalidaKardex", "si");
			$('.Csalida').show();
		}else{
			crearCookie("mostrarSalidaKardex", "no");
			$('.Csalida').hide();
		}	
	});
	$( "#CheckExistencia" ).click(function() {
    	if ($( "#CheckExistencia" ).is(':checked')){
			crearCookie("mostrarExistenciaKardex", "si");
			$('.Cexistencia').show();
		}else{
			crearCookie("mostrarExistenciaKardex", "no");
			$('.Cexistencia').hide();
		}	
	});
	$( "#CheckCostounitario" ).click(function() {
    	if ($( "#CheckCostounitario" ).is(':checked')){
			crearCookie("mostrarCostounitarioKardex", "si");
			$('.Ccostounitario').show();
		}else{
			crearCookie("mostrarCostounitarioKardex", "no");
			$('.Ccostounitario').hide();
		}	
	});
	$( "#CheckPromedio" ).click(function() {
    	if ($( "#CheckPromedio" ).is(':checked')){
			crearCookie("mostrarPromedioKardex", "si");
			$('.Cpromedio').show();
		}else{
			crearCookie("mostrarPromedioKardex", "no");
			$('.Cpromedio').hide();
		}	
	});
	$( "#CheckDebe" ).click(function() {
    	if ($( "#CheckDebe" ).is(':checked')){
			crearCookie("mostrarDebeKardex", "si");
			$('.Cdebe').show();
		}else{
			crearCookie("mostrarDebeKardex", "no");
			$('.Cdebe').hide();
		}	
	});
	$( "#CheckHaber" ).click(function() {
    	if ($( "#CheckHaber" ).is(':checked')){
			crearCookie("mostrarHaberKardex", "si");
			$('.Chaber').show();
		}else{
			crearCookie("mostrarHaberKardex", "no");
			$('.Chaber').hide();
		}	
	});
	$( "#CheckSaldo" ).click(function() {
    	if ($( "#CheckSaldo" ).is(':checked')){
			crearCookie("mostrarSaldoKardex", "si");
			$('.Csaldo').show();
		}else{
			crearCookie("mostrarSaldoKardex", "no");
			$('.Csaldo').hide();
		}	
	});
	$( "#CheckIdalmacen" ).click(function() {
    	if ($( "#CheckIdalmacen" ).is(':checked')){
			crearCookie("mostrarIdalmacenKardex", "si");
			$('.Cidalmacen').show();
		}else{
			crearCookie("mostrarIdalmacenKardex", "no");
			$('.Cidalmacen').hide();
		}	
	});
	$( "#CheckIdmovimiento" ).click(function() {
    	if ($( "#CheckIdmovimiento" ).is(':checked')){
			crearCookie("mostrarIdmovimientoKardex", "si");
			$('.Cidmovimiento').show();
		}else{
			crearCookie("mostrarIdmovimientoKardex", "no");
			$('.Cidmovimiento').hide();
		}	
	});
	$( "#CheckIdreferencia" ).click(function() {
    	if ($( "#CheckIdreferencia" ).is(':checked')){
			crearCookie("mostrarIdreferenciaKardex", "si");
			$('.Cidreferencia').show();
		}else{
			crearCookie("mostrarIdreferenciaKardex", "no");
			$('.Cidreferencia').hide();
		}	
	});
	$( "#CheckComposicion" ).click(function() {
    	if ($( "#CheckComposicion" ).is(':checked')){
			crearCookie("mostrarComposicionKardex", "si");
			$('.Ccomposicion').show();
		}else{
			crearCookie("mostrarComposicionKardex", "no");
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
	alert(idproducto);
	xmlhttp.open("POST","consultar.php?campoOrden="+campoOrden+"&orden="+orden+"&cantidadamostrar="+cantidadamostrar+"&paginacion="+paginacion+"&busqueda="+busqueda+"&tipoVista="+tipoVista+"&papelera="+papelera+"&idprodcuto="+idprodcuto+"&idsucursal"+idsucursal, true);
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