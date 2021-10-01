// JavaScript Document
var orden, campoOrden, cantidadamostrar, paginacion;
orden="DESC";
campoOrden="idinventario";
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
	if(recuperarCookie("campoOrdenInventario")!=null){
		campoOrden=recuperarCookie("campoOrdenInventario");
		 $("#campoOrden option[value="+campoOrden+"]").attr("selected",true);
	}else{
		campoOrden="idinventario";
		$("#campoOrden option[value="+campoOrden+"]").attr("selected",true);
	}
	
	//Identificar el numero de elementos para mostrar
	if(recuperarCookie("cantidadamostrarInventario")!=null){
		cantidadamostrar=recuperarCookie("cantidadamostrarInventario");
		 $("#cantidadamostrar option[value="+cantidadamostrar+"]").attr("selected",true);
	}else{
		cantidadamostrar="20";
		$("#cantidadamostrar option[value="+cantidadamostrar+"]").attr("selected",true);
		
	}
	
	//Identificar el tipo de orden
	if(recuperarCookie("ordenInventario")=="asc"){
		orden="ASC"
		$('#asc').attr('checked', true);
		$('#desc').attr('checked', false);
	}else if(recuperarCookie("ordenInventario")=="desc"){
		orden="DESC"
		$('#asc').attr('checked', false);
		$('#desc').attr('checked', true);
	}else{
		orden="DESC"
		$('#asc').attr('checked', false);
		$('#desc').attr('checked', true);
	}
	//Mostrar u Ocultar Idinventario
	if(recuperarCookie("mostrarIdinventarioInventario")=="si"){
		$('.Cidinventario').show();
		$('#CheckIdinventario').attr('checked', true);
	}else if(recuperarCookie("mostrarIdinventarioInventario")=="no"){
		$('.Cidinventario').hide();
		$('#CheckIdinventario').attr('checked', false);
	}
	//Mostrar u Ocultar Idalmacen
	if(recuperarCookie("mostrarIdalmacenInventario")=="si"){
		$('.Cidalmacen').show();
		$('#CheckIdalmacen').attr('checked', true);
	}else if(recuperarCookie("mostrarIdalmacenInventario")=="no"){
		$('.Cidalmacen').hide();
		$('#CheckIdalmacen').attr('checked', false);
	}
	//Mostrar u Ocultar Idproducto
	if(recuperarCookie("mostrarIdproductoInventario")=="si"){
		$('.Cidproducto').show();
		$('#CheckIdproducto').attr('checked', true);
	}else if(recuperarCookie("mostrarIdproductoInventario")=="no"){
		$('.Cidproducto').hide();
		$('#CheckIdproducto').attr('checked', false);
	}
	//Mostrar u Ocultar Existencia
	if(recuperarCookie("mostrarExistenciaInventario")=="si"){
		$('.Cexistencia').show();
		$('#CheckExistencia').attr('checked', true);
	}else if(recuperarCookie("mostrarExistenciaInventario")=="no"){
		$('.Cexistencia').hide();
		$('#CheckExistencia').attr('checked', false);
	}
	//Mostrar u Ocultar Promedio
	if(recuperarCookie("mostrarPromedioInventario")=="si"){
		$('.Cpromedio').show();
		$('#CheckPromedio').attr('checked', true);
	}else if(recuperarCookie("mostrarPromedioInventario")=="no"){
		$('.Cpromedio').hide();
		$('#CheckPromedio').attr('checked', false);
	}
	//Mostrar u Ocultar Saldo
	if(recuperarCookie("mostrarSaldoInventario")=="si"){
		$('.Csaldo').show();
		$('#CheckSaldo').attr('checked', true);
	}else if(recuperarCookie("mostrarSaldoInventario")=="no"){
		$('.Csaldo').hide();
		$('#CheckSaldo').attr('checked', false);
	}
	//Mostrar u Ocultar Minimo
	if(recuperarCookie("mostrarMinimoInventario")=="si"){
		$('.Cminimo').show();
		$('#CheckMinimo').attr('checked', true);
	}else if(recuperarCookie("mostrarMinimoInventario")=="no"){
		$('.Cminimo').hide();
		$('#CheckMinimo').attr('checked', false);
	}
	//Mostrar u Ocultar Ubicacion
	if(recuperarCookie("mostrarUbicacionInventario")=="si"){
		$('.Cubicacion').show();
		$('#CheckUbicacion').attr('checked', true);
	}else if(recuperarCookie("mostrarUbicacionInventario")=="no"){
		$('.Cubicacion').hide();
		$('#CheckUbicacion').attr('checked', false);
	}
	//Mostrar u Ocultar Estado
	if(recuperarCookie("mostrarEstadoInventario")=="si"){
		$('.Cestado').show();
		$('#CheckEstado').attr('checked', true);
	}else if(recuperarCookie("mostrarEstadoInventario")=="no"){
		$('.Cestado').hide();
		$('#CheckEstado').attr('checked', false);
	}
	//Mostrar u Ocultar Composicion
	if(recuperarCookie("mostrarComposicionInventario")=="si"){
		$('.Ccomposicion').show();
		$('#CheckComposicion').attr('checked', true);
	}
	if(recuperarCookie("mostrarComposicionInventario")=="no"){
		$('.Ccomposicion').hide();
		$('#CheckComposicion').attr('checked', false);
	}
	
	//Elegir el tipo de vista
	if(recuperarCookie("tipoVistaInventario")=="tabla"){
		$('.tipoLista').show();
		$('.tipoTabla').hide();
		tipoVista="tabla";
	}else{
		$('.tipoLista').hide();
		$('.tipoTabla').show();
		tipoVista="lista";
	}
	$( ".tipoTabla" ).click(function() {
    	crearCookie("tipoVistaInventario", "tabla");
		tipoVista="tabla";
		$(".tipoLista").show();
		$(".tipoTabla").hide();
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$( ".tipoLista" ).click(function() {
    	crearCookie("tipoVistaInventario", "lista");
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
		crearCookie("campoOrdenInventario", campoOrden);
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$("#cantidadamostrar").change(function(){
		cantidadamostrar = this.value;
		crearCookie("cantidadamostrarInventario", cantidadamostrar);
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$( "#asc" ).click(function() {
    	if ($( "#asc" ).is(':checked')){
			crearCookie("ordenInventario", "asc");
			orden="ASC"
			load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
		}
	});
	$( "#desc" ).click(function() {
    	if ($( "#desc" ).is(':checked')){
			crearCookie("ordenInventario", "desc");
			orden="DESC"
			load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
		}
	});
	$( "#CheckIdinventario" ).click(function() {
    	if ($( "#CheckIdinventario" ).is(':checked')){
			crearCookie("mostrarIdinventarioInventario", "si");
			$('.Cidinventario').show();
		}else{
			crearCookie("mostrarIdinventarioInventario", "no");
			$('.Cidinventario').hide();
		}	
	});
	$( "#CheckIdalmacen" ).click(function() {
    	if ($( "#CheckIdalmacen" ).is(':checked')){
			crearCookie("mostrarIdalmacenInventario", "si");
			$('.Cidalmacen').show();
		}else{
			crearCookie("mostrarIdalmacenInventario", "no");
			$('.Cidalmacen').hide();
		}	
	});
	$( "#CheckIdproducto" ).click(function() {
    	if ($( "#CheckIdproducto" ).is(':checked')){
			crearCookie("mostrarIdproductoInventario", "si");
			$('.Cidproducto').show();
		}else{
			crearCookie("mostrarIdproductoInventario", "no");
			$('.Cidproducto').hide();
		}	
	});
	$( "#CheckExistencia" ).click(function() {
    	if ($( "#CheckExistencia" ).is(':checked')){
			crearCookie("mostrarExistenciaInventario", "si");
			$('.Cexistencia').show();
		}else{
			crearCookie("mostrarExistenciaInventario", "no");
			$('.Cexistencia').hide();
		}	
	});
	$( "#CheckPromedio" ).click(function() {
    	if ($( "#CheckPromedio" ).is(':checked')){
			crearCookie("mostrarPromedioInventario", "si");
			$('.Cpromedio').show();
		}else{
			crearCookie("mostrarPromedioInventario", "no");
			$('.Cpromedio').hide();
		}	
	});
	$( "#CheckSaldo" ).click(function() {
    	if ($( "#CheckSaldo" ).is(':checked')){
			crearCookie("mostrarSaldoInventario", "si");
			$('.Csaldo').show();
		}else{
			crearCookie("mostrarSaldoInventario", "no");
			$('.Csaldo').hide();
		}	
	});
	$( "#CheckMinimo" ).click(function() {
    	if ($( "#CheckMinimo" ).is(':checked')){
			crearCookie("mostrarMinimoInventario", "si");
			$('.Cminimo').show();
		}else{
			crearCookie("mostrarMinimoInventario", "no");
			$('.Cminimo').hide();
		}	
	});
	$( "#CheckUbicacion" ).click(function() {
    	if ($( "#CheckUbicacion" ).is(':checked')){
			crearCookie("mostrarUbicacionInventario", "si");
			$('.Cubicacion').show();
		}else{
			crearCookie("mostrarUbicacionInventario", "no");
			$('.Cubicacion').hide();
		}	
	});
	$( "#CheckEstado" ).click(function() {
    	if ($( "#CheckEstado" ).is(':checked')){
			crearCookie("mostrarEstadoInventario", "si");
			$('.Cestado').show();
		}else{
			crearCookie("mostrarEstadoInventario", "no");
			$('.Cestado').hide();
		}	
	});
	$( "#CheckComposicion" ).click(function() {
    	if ($( "#CheckComposicion" ).is(':checked')){
			crearCookie("mostrarComposicionInventario", "si");
			$('.Ccomposicion').show();
		}else{
			crearCookie("mostrarComposicionInventario", "no");
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
	
	$(".botonExportar").click(function() {
		var busqueda=$.trim( $("#cajaBuscar").val());
		exportar(campoOrden,orden,cantidadamostrar,paginacion,busqueda,tipoVista);
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

function exportar(campoOrden, orden, cantidadamostrar, paginacion, busqueda, tipoVista){
	var idcliente, idalmacen, tipo, ticket, fitlarfecha, fechainicio, fechafin, clasificacion, formapago;
	
	//idalmacen=$("#idalmacen_ajax").val();
	
	window.open("inventario_excel.php?campoOrden="+campoOrden+"&orden="+orden+"&cantidadamostrar="+cantidadamostrar+"&paginacion="+paginacion+"&busqueda="+busqueda+"&tipoVista="+tipoVista+"&papelera="+papelera);
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