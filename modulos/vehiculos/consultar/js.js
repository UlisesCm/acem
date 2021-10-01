// JavaScript Document
var orden, campoOrden, cantidadamostrar, paginacion;
orden="DESC";
campoOrden="idvehiculo";
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
	if(recuperarCookie("campoOrdenVehiculo")!=null){
		campoOrden=recuperarCookie("campoOrdenVehiculo");
		 $("#campoOrden option[value="+campoOrden+"]").attr("selected",true);
	}else{
		campoOrden="idvehiculo";
		$("#campoOrden option[value="+campoOrden+"]").attr("selected",true);
	}
	
	//Identificar el numero de elementos para mostrar
	if(recuperarCookie("cantidadamostrarVehiculo")!=null){
		cantidadamostrar=recuperarCookie("cantidadamostrarVehiculo");
		 $("#cantidadamostrar option[value="+cantidadamostrar+"]").attr("selected",true);
	}else{
		cantidadamostrar="20";
		$("#cantidadamostrar option[value="+cantidadamostrar+"]").attr("selected",true);
		
	}
	
	//Identificar el tipo de orden
	if(recuperarCookie("ordenVehiculo")=="asc"){
		orden="ASC"
		$('#asc').attr('checked', true);
		$('#desc').attr('checked', false);
	}else if(recuperarCookie("ordenVehiculo")=="desc"){
		orden="DESC"
		$('#asc').attr('checked', false);
		$('#desc').attr('checked', true);
	}else{
		orden="DESC"
		$('#asc').attr('checked', false);
		$('#desc').attr('checked', true);
	}
	//Mostrar u Ocultar Tipo
	if(recuperarCookie("mostrarTipoVehiculo")=="si"){
		$('.Ctipo').show();
		$('#CheckTipo').attr('checked', true);
	}else if(recuperarCookie("mostrarTipoVehiculo")=="no"){
		$('.Ctipo').hide();
		$('#CheckTipo').attr('checked', false);
	}
	//Mostrar u Ocultar Marca
	if(recuperarCookie("mostrarMarcaVehiculo")=="si"){
		$('.Cmarca').show();
		$('#CheckMarca').attr('checked', true);
	}else if(recuperarCookie("mostrarMarcaVehiculo")=="no"){
		$('.Cmarca').hide();
		$('#CheckMarca').attr('checked', false);
	}
	//Mostrar u Ocultar Submarca
	if(recuperarCookie("mostrarSubmarcaVehiculo")=="si"){
		$('.Csubmarca').show();
		$('#CheckSubmarca').attr('checked', true);
	}else if(recuperarCookie("mostrarSubmarcaVehiculo")=="no"){
		$('.Csubmarca').hide();
		$('#CheckSubmarca').attr('checked', false);
	}
	//Mostrar u Ocultar Color
	if(recuperarCookie("mostrarColorVehiculo")=="si"){
		$('.Ccolor').show();
		$('#CheckColor').attr('checked', true);
	}else if(recuperarCookie("mostrarColorVehiculo")=="no"){
		$('.Ccolor').hide();
		$('#CheckColor').attr('checked', false);
	}
	//Mostrar u Ocultar Placa
	if(recuperarCookie("mostrarPlacaVehiculo")=="si"){
		$('.Cplaca').show();
		$('#CheckPlaca').attr('checked', true);
	}else if(recuperarCookie("mostrarPlacaVehiculo")=="no"){
		$('.Cplaca').hide();
		$('#CheckPlaca').attr('checked', false);
	}
	//Mostrar u Ocultar Capacidaddecarga
	if(recuperarCookie("mostrarCapacidaddecargaVehiculo")=="si"){
		$('.Ccapacidaddecarga').show();
		$('#CheckCapacidaddecarga').attr('checked', true);
	}else if(recuperarCookie("mostrarCapacidaddecargaVehiculo")=="no"){
		$('.Ccapacidaddecarga').hide();
		$('#CheckCapacidaddecarga').attr('checked', false);
	}
	//Mostrar u Ocultar Anio
	if(recuperarCookie("mostrarAnioVehiculo")=="si"){
		$('.Canio').show();
		$('#CheckAnio').attr('checked', true);
	}else if(recuperarCookie("mostrarAnioVehiculo")=="no"){
		$('.Canio').hide();
		$('#CheckAnio').attr('checked', false);
	}
	//Mostrar u Ocultar Kminicial
	if(recuperarCookie("mostrarKminicialVehiculo")=="si"){
		$('.Ckminicial').show();
		$('#CheckKminicial').attr('checked', true);
	}else if(recuperarCookie("mostrarKminicialVehiculo")=="no"){
		$('.Ckminicial').hide();
		$('#CheckKminicial').attr('checked', false);
	}
	//Mostrar u Ocultar Kmactual
	if(recuperarCookie("mostrarKmactualVehiculo")=="si"){
		$('.Ckmactual').show();
		$('#CheckKmactual').attr('checked', true);
	}else if(recuperarCookie("mostrarKmactualVehiculo")=="no"){
		$('.Ckmactual').hide();
		$('#CheckKmactual').attr('checked', false);
	}
	//Mostrar u Ocultar Vigenciaseguro
	if(recuperarCookie("mostrarVigenciaseguroVehiculo")=="si"){
		$('.Cvigenciaseguro').show();
		$('#CheckVigenciaseguro').attr('checked', true);
	}else if(recuperarCookie("mostrarVigenciaseguroVehiculo")=="no"){
		$('.Cvigenciaseguro').hide();
		$('#CheckVigenciaseguro').attr('checked', false);
	}
	//Mostrar u Ocultar Kmultimomantenimiento
	if(recuperarCookie("mostrarKmultimomantenimientoVehiculo")=="si"){
		$('.Ckmultimomantenimiento').show();
		$('#CheckKmultimomantenimiento').attr('checked', true);
	}else if(recuperarCookie("mostrarKmultimomantenimientoVehiculo")=="no"){
		$('.Ckmultimomantenimiento').hide();
		$('#CheckKmultimomantenimiento').attr('checked', false);
	}
	//Mostrar u Ocultar Fechaultimomantenimiento
	if(recuperarCookie("mostrarFechaultimomantenimientoVehiculo")=="si"){
		$('.Cfechaultimomantenimiento').show();
		$('#CheckFechaultimomantenimiento').attr('checked', true);
	}else if(recuperarCookie("mostrarFechaultimomantenimientoVehiculo")=="no"){
		$('.Cfechaultimomantenimiento').hide();
		$('#CheckFechaultimomantenimiento').attr('checked', false);
	}
	//Mostrar u Ocultar Tipodecombustible
	if(recuperarCookie("mostrarTipodecombustibleVehiculo")=="si"){
		$('.Ctipodecombustible').show();
		$('#CheckTipodecombustible').attr('checked', true);
	}else if(recuperarCookie("mostrarTipodecombustibleVehiculo")=="no"){
		$('.Ctipodecombustible').hide();
		$('#CheckTipodecombustible').attr('checked', false);
	}
	//Mostrar u Ocultar Frecuenciamantenimientokm
	if(recuperarCookie("mostrarFrecuenciamantenimientokmVehiculo")=="si"){
		$('.Cfrecuenciamantenimientokm').show();
		$('#CheckFrecuenciamantenimientokm').attr('checked', true);
	}else if(recuperarCookie("mostrarFrecuenciamantenimientokmVehiculo")=="no"){
		$('.Cfrecuenciamantenimientokm').hide();
		$('#CheckFrecuenciamantenimientokm').attr('checked', false);
	}
	//Mostrar u Ocultar Frecuenciamantenimientofecha
	if(recuperarCookie("mostrarFrecuenciamantenimientofechaVehiculo")=="si"){
		$('.Cfrecuenciamantenimientofecha').show();
		$('#CheckFrecuenciamantenimientofecha').attr('checked', true);
	}else if(recuperarCookie("mostrarFrecuenciamantenimientofechaVehiculo")=="no"){
		$('.Cfrecuenciamantenimientofecha').hide();
		$('#CheckFrecuenciamantenimientofecha').attr('checked', false);
	}
	//Mostrar u Ocultar Asignado
	if(recuperarCookie("mostrarAsignadoVehiculo")=="si"){
		$('.Casignado').show();
		$('#CheckAsignado').attr('checked', true);
	}else if(recuperarCookie("mostrarAsignadoVehiculo")=="no"){
		$('.Casignado').hide();
		$('#CheckAsignado').attr('checked', false);
	}
	//Mostrar u Ocultar Estado
	if(recuperarCookie("mostrarEstadoVehiculo")=="si"){
		$('.Cestado').show();
		$('#CheckEstado').attr('checked', true);
	}else if(recuperarCookie("mostrarEstadoVehiculo")=="no"){
		$('.Cestado').hide();
		$('#CheckEstado').attr('checked', false);
	}
	//Mostrar u Ocultar Idempleado
	if(recuperarCookie("mostrarIdempleadoVehiculo")=="si"){
		$('.Cidempleado').show();
		$('#CheckIdempleado').attr('checked', true);
	}else if(recuperarCookie("mostrarIdempleadoVehiculo")=="no"){
		$('.Cidempleado').hide();
		$('#CheckIdempleado').attr('checked', false);
	}
	//Mostrar u Ocultar Idsucursal
	if(recuperarCookie("mostrarIdsucursalVehiculo")=="si"){
		$('.Cidsucursal').show();
		$('#CheckIdsucursal').attr('checked', true);
	}else if(recuperarCookie("mostrarIdsucursalVehiculo")=="no"){
		$('.Cidsucursal').hide();
		$('#CheckIdsucursal').attr('checked', false);
	}
	//Mostrar u Ocultar Composicion
	if(recuperarCookie("mostrarComposicionVehiculo")=="si"){
		$('.Ccomposicion').show();
		$('#CheckComposicion').attr('checked', true);
	}
	if(recuperarCookie("mostrarComposicionVehiculo")=="no"){
		$('.Ccomposicion').hide();
		$('#CheckComposicion').attr('checked', false);
	}
	
	//Elegir el tipo de vista
	if(recuperarCookie("tipoVistaVehiculo")=="tabla"){
		$('.tipoLista').show();
		$('.tipoTabla').hide();
		tipoVista="tabla";
	}else{
		$('.tipoLista').hide();
		$('.tipoTabla').show();
		tipoVista="lista";
	}
	$( ".tipoTabla" ).click(function() {
    	crearCookie("tipoVistaVehiculo", "tabla");
		tipoVista="tabla";
		$(".tipoLista").show();
		$(".tipoTabla").hide();
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$( ".tipoLista" ).click(function() {
    	crearCookie("tipoVistaVehiculo", "lista");
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
		crearCookie("campoOrdenVehiculo", campoOrden);
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$("#cantidadamostrar").change(function(){
		cantidadamostrar = this.value;
		crearCookie("cantidadamostrarVehiculo", cantidadamostrar);
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$( "#asc" ).click(function() {
    	if ($( "#asc" ).is(':checked')){
			crearCookie("ordenVehiculo", "asc");
			orden="ASC"
			load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
		}
	});
	$( "#desc" ).click(function() {
    	if ($( "#desc" ).is(':checked')){
			crearCookie("ordenVehiculo", "desc");
			orden="DESC"
			load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
		}
	});
	$( "#CheckTipo" ).click(function() {
    	if ($( "#CheckTipo" ).is(':checked')){
			crearCookie("mostrarTipoVehiculo", "si");
			$('.Ctipo').show();
		}else{
			crearCookie("mostrarTipoVehiculo", "no");
			$('.Ctipo').hide();
		}	
	});
	$( "#CheckMarca" ).click(function() {
    	if ($( "#CheckMarca" ).is(':checked')){
			crearCookie("mostrarMarcaVehiculo", "si");
			$('.Cmarca').show();
		}else{
			crearCookie("mostrarMarcaVehiculo", "no");
			$('.Cmarca').hide();
		}	
	});
	$( "#CheckSubmarca" ).click(function() {
    	if ($( "#CheckSubmarca" ).is(':checked')){
			crearCookie("mostrarSubmarcaVehiculo", "si");
			$('.Csubmarca').show();
		}else{
			crearCookie("mostrarSubmarcaVehiculo", "no");
			$('.Csubmarca').hide();
		}	
	});
	$( "#CheckColor" ).click(function() {
    	if ($( "#CheckColor" ).is(':checked')){
			crearCookie("mostrarColorVehiculo", "si");
			$('.Ccolor').show();
		}else{
			crearCookie("mostrarColorVehiculo", "no");
			$('.Ccolor').hide();
		}	
	});
	$( "#CheckPlaca" ).click(function() {
    	if ($( "#CheckPlaca" ).is(':checked')){
			crearCookie("mostrarPlacaVehiculo", "si");
			$('.Cplaca').show();
		}else{
			crearCookie("mostrarPlacaVehiculo", "no");
			$('.Cplaca').hide();
		}	
	});
	$( "#CheckCapacidaddecarga" ).click(function() {
    	if ($( "#CheckCapacidaddecarga" ).is(':checked')){
			crearCookie("mostrarCapacidaddecargaVehiculo", "si");
			$('.Ccapacidaddecarga').show();
		}else{
			crearCookie("mostrarCapacidaddecargaVehiculo", "no");
			$('.Ccapacidaddecarga').hide();
		}	
	});
	$( "#CheckAnio" ).click(function() {
    	if ($( "#CheckAnio" ).is(':checked')){
			crearCookie("mostrarAnioVehiculo", "si");
			$('.Canio').show();
		}else{
			crearCookie("mostrarAnioVehiculo", "no");
			$('.Canio').hide();
		}	
	});
	$( "#CheckKminicial" ).click(function() {
    	if ($( "#CheckKminicial" ).is(':checked')){
			crearCookie("mostrarKminicialVehiculo", "si");
			$('.Ckminicial').show();
		}else{
			crearCookie("mostrarKminicialVehiculo", "no");
			$('.Ckminicial').hide();
		}	
	});
	$( "#CheckKmactual" ).click(function() {
    	if ($( "#CheckKmactual" ).is(':checked')){
			crearCookie("mostrarKmactualVehiculo", "si");
			$('.Ckmactual').show();
		}else{
			crearCookie("mostrarKmactualVehiculo", "no");
			$('.Ckmactual').hide();
		}	
	});
	$( "#CheckVigenciaseguro" ).click(function() {
    	if ($( "#CheckVigenciaseguro" ).is(':checked')){
			crearCookie("mostrarVigenciaseguroVehiculo", "si");
			$('.Cvigenciaseguro').show();
		}else{
			crearCookie("mostrarVigenciaseguroVehiculo", "no");
			$('.Cvigenciaseguro').hide();
		}	
	});
	$( "#CheckKmultimomantenimiento" ).click(function() {
    	if ($( "#CheckKmultimomantenimiento" ).is(':checked')){
			crearCookie("mostrarKmultimomantenimientoVehiculo", "si");
			$('.Ckmultimomantenimiento').show();
		}else{
			crearCookie("mostrarKmultimomantenimientoVehiculo", "no");
			$('.Ckmultimomantenimiento').hide();
		}	
	});
	$( "#CheckFechaultimomantenimiento" ).click(function() {
    	if ($( "#CheckFechaultimomantenimiento" ).is(':checked')){
			crearCookie("mostrarFechaultimomantenimientoVehiculo", "si");
			$('.Cfechaultimomantenimiento').show();
		}else{
			crearCookie("mostrarFechaultimomantenimientoVehiculo", "no");
			$('.Cfechaultimomantenimiento').hide();
		}	
	});
	$( "#CheckTipodecombustible" ).click(function() {
    	if ($( "#CheckTipodecombustible" ).is(':checked')){
			crearCookie("mostrarTipodecombustibleVehiculo", "si");
			$('.Ctipodecombustible').show();
		}else{
			crearCookie("mostrarTipodecombustibleVehiculo", "no");
			$('.Ctipodecombustible').hide();
		}	
	});
	$( "#CheckFrecuenciamantenimientokm" ).click(function() {
    	if ($( "#CheckFrecuenciamantenimientokm" ).is(':checked')){
			crearCookie("mostrarFrecuenciamantenimientokmVehiculo", "si");
			$('.Cfrecuenciamantenimientokm').show();
		}else{
			crearCookie("mostrarFrecuenciamantenimientokmVehiculo", "no");
			$('.Cfrecuenciamantenimientokm').hide();
		}	
	});
	$( "#CheckFrecuenciamantenimientofecha" ).click(function() {
    	if ($( "#CheckFrecuenciamantenimientofecha" ).is(':checked')){
			crearCookie("mostrarFrecuenciamantenimientofechaVehiculo", "si");
			$('.Cfrecuenciamantenimientofecha').show();
		}else{
			crearCookie("mostrarFrecuenciamantenimientofechaVehiculo", "no");
			$('.Cfrecuenciamantenimientofecha').hide();
		}	
	});
	$( "#CheckAsignado" ).click(function() {
    	if ($( "#CheckAsignado" ).is(':checked')){
			crearCookie("mostrarAsignadoVehiculo", "si");
			$('.Casignado').show();
		}else{
			crearCookie("mostrarAsignadoVehiculo", "no");
			$('.Casignado').hide();
		}	
	});
	$( "#CheckEstado" ).click(function() {
    	if ($( "#CheckEstado" ).is(':checked')){
			crearCookie("mostrarEstadoVehiculo", "si");
			$('.Cestado').show();
		}else{
			crearCookie("mostrarEstadoVehiculo", "no");
			$('.Cestado').hide();
		}	
	});
	$( "#CheckIdempleado" ).click(function() {
    	if ($( "#CheckIdempleado" ).is(':checked')){
			crearCookie("mostrarIdempleadoVehiculo", "si");
			$('.Cidempleado').show();
		}else{
			crearCookie("mostrarIdempleadoVehiculo", "no");
			$('.Cidempleado').hide();
		}	
	});
	$( "#CheckIdsucursal" ).click(function() {
    	if ($( "#CheckIdsucursal" ).is(':checked')){
			crearCookie("mostrarIdsucursalVehiculo", "si");
			$('.Cidsucursal').show();
		}else{
			crearCookie("mostrarIdsucursalVehiculo", "no");
			$('.Cidsucursal').hide();
		}	
	});
	$( "#CheckComposicion" ).click(function() {
    	if ($( "#CheckComposicion" ).is(':checked')){
			crearCookie("mostrarComposicionVehiculo", "si");
			$('.Ccomposicion').show();
		}else{
			crearCookie("mostrarComposicionVehiculo", "no");
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