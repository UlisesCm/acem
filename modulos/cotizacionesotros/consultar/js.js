// JavaScript Document
var orden, campoOrden, cantidadamostrar, paginacion;
orden="DESC";
campoOrden="idcotizacionesotros";
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
	if(recuperarCookie("campoOrdenCotizacionotro")!=null){
		campoOrden=recuperarCookie("campoOrdenCotizacionotro");
		 $("#campoOrden option[value="+campoOrden+"]").attr("selected",true);
	}else{
		campoOrden="idcotizacionesotros";
		$("#campoOrden option[value="+campoOrden+"]").attr("selected",true);
	}
	
	//Identificar el numero de elementos para mostrar
	if(recuperarCookie("cantidadamostrarCotizacionotro")!=null){
		cantidadamostrar=recuperarCookie("cantidadamostrarCotizacionotro");
		 $("#cantidadamostrar option[value="+cantidadamostrar+"]").attr("selected",true);
	}else{
		cantidadamostrar="20";
		$("#cantidadamostrar option[value="+cantidadamostrar+"]").attr("selected",true);
		
	}
	
	//Identificar el tipo de orden
	if(recuperarCookie("ordenCotizacionotro")=="asc"){
		orden="ASC"
		$('#asc').attr('checked', true);
		$('#desc').attr('checked', false);
	}else if(recuperarCookie("ordenCotizacionotro")=="desc"){
		orden="DESC"
		$('#asc').attr('checked', false);
		$('#desc').attr('checked', true);
	}else{
		orden="DESC"
		$('#asc').attr('checked', false);
		$('#desc').attr('checked', true);
	}
	//Mostrar u Ocultar Idcotizacionesotros
	if(recuperarCookie("mostrarIdcotizacionesotrosCotizacionotro")=="si"){
		$('.Cidcotizacionesotros').show();
		$('#CheckIdcotizacionesotros').attr('checked', true);
	}else if(recuperarCookie("mostrarIdcotizacionesotrosCotizacionotro")=="no"){
		$('.Cidcotizacionesotros').hide();
		$('#CheckIdcotizacionesotros').attr('checked', false);
	}
	//Mostrar u Ocultar Serie
	if(recuperarCookie("mostrarSerieCotizacionotro")=="si"){
		$('.Cserie').show();
		$('#CheckSerie').attr('checked', true);
	}else if(recuperarCookie("mostrarSerieCotizacionotro")=="no"){
		$('.Cserie').hide();
		$('#CheckSerie').attr('checked', false);
	}
	//Mostrar u Ocultar Folio
	if(recuperarCookie("mostrarFolioCotizacionotro")=="si"){
		$('.Cfolio').show();
		$('#CheckFolio').attr('checked', true);
	}else if(recuperarCookie("mostrarFolioCotizacionotro")=="no"){
		$('.Cfolio').hide();
		$('#CheckFolio').attr('checked', false);
	}
	//Mostrar u Ocultar Fecha
	if(recuperarCookie("mostrarFechaCotizacionotro")=="si"){
		$('.Cfecha').show();
		$('#CheckFecha').attr('checked', true);
	}else if(recuperarCookie("mostrarFechaCotizacionotro")=="no"){
		$('.Cfecha').hide();
		$('#CheckFecha').attr('checked', false);
	}
	//Mostrar u Ocultar Tipo
	if(recuperarCookie("mostrarTipoCotizacionotro")=="si"){
		$('.Ctipo').show();
		$('#CheckTipo').attr('checked', true);
	}else if(recuperarCookie("mostrarTipoCotizacionotro")=="no"){
		$('.Ctipo').hide();
		$('#CheckTipo').attr('checked', false);
	}
	//Mostrar u Ocultar Monto
	if(recuperarCookie("mostrarMontoCotizacionotro")=="si"){
		$('.Cmonto').show();
		$('#CheckMonto').attr('checked', true);
	}else if(recuperarCookie("mostrarMontoCotizacionotro")=="no"){
		$('.Cmonto').hide();
		$('#CheckMonto').attr('checked', false);
	}
	//Mostrar u Ocultar Idcliente
	if(recuperarCookie("mostrarIdclienteCotizacionotro")=="si"){
		$('.Cidcliente').show();
		$('#CheckIdcliente').attr('checked', true);
	}else if(recuperarCookie("mostrarIdclienteCotizacionotro")=="no"){
		$('.Cidcliente').hide();
		$('#CheckIdcliente').attr('checked', false);
	}
	//Mostrar u Ocultar Idsucursal
	if(recuperarCookie("mostrarIdsucursalCotizacionotro")=="si"){
		$('.Cidsucursal').show();
		$('#CheckIdsucursal').attr('checked', true);
	}else if(recuperarCookie("mostrarIdsucursalCotizacionotro")=="no"){
		$('.Cidsucursal').hide();
		$('#CheckIdsucursal').attr('checked', false);
	}
	//Mostrar u Ocultar Idempleado
	if(recuperarCookie("mostrarIdempleadoCotizacionotro")=="si"){
		$('.Cidempleado').show();
		$('#CheckIdempleado').attr('checked', true);
	}else if(recuperarCookie("mostrarIdempleadoCotizacionotro")=="no"){
		$('.Cidempleado').hide();
		$('#CheckIdempleado').attr('checked', false);
	}
	//Mostrar u Ocultar Observaciones
	if(recuperarCookie("mostrarObservacionesCotizacionotro")=="si"){
		$('.Cobservaciones').show();
		$('#CheckObservaciones').attr('checked', true);
	}else if(recuperarCookie("mostrarObservacionesCotizacionotro")=="no"){
		$('.Cobservaciones').hide();
		$('#CheckObservaciones').attr('checked', false);
	}
	//Mostrar u Ocultar Estatus
	if(recuperarCookie("mostrarEstatusCotizacionotro")=="si"){
		$('.Cestatus').show();
		$('#CheckEstatus').attr('checked', true);
	}else if(recuperarCookie("mostrarEstatusCotizacionotro")=="no"){
		$('.Cestatus').hide();
		$('#CheckEstatus').attr('checked', false);
	}
	//Mostrar u Ocultar Composicion
	if(recuperarCookie("mostrarComposicionCotizacionotro")=="si"){
		$('.Ccomposicion').show();
		$('#CheckComposicion').attr('checked', true);
	}
	if(recuperarCookie("mostrarComposicionCotizacionotro")=="no"){
		$('.Ccomposicion').hide();
		$('#CheckComposicion').attr('checked', false);
	}
	
	//Elegir el tipo de vista
	if(recuperarCookie("tipoVistaCotizacionotro")=="tabla"){
		$('.tipoLista').show();
		$('.tipoTabla').hide();
		tipoVista="tabla";
	}else{
		$('.tipoLista').hide();
		$('.tipoTabla').show();
		tipoVista="lista";
	}
	$( ".tipoTabla" ).click(function() {
    	crearCookie("tipoVistaCotizacionotro", "tabla");
		tipoVista="tabla";
		$(".tipoLista").show();
		$(".tipoTabla").hide();
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$( ".tipoLista" ).click(function() {
    	crearCookie("tipoVistaCotizacionotro", "lista");
		tipoVista="lista";
		$(".tipoLista").hide();
		$(".tipoTabla").show();
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});

}

	
$(document).ready(function() {
	$("#cajaBuscar").focus();
	comprobarReglas();
	//QUITO LA FUNCION load_tablas PARA QUE NO CONSULTE POR DEFAULT SI NO HASTA QUE LE DEN CLIC EN FILTRAR
	//load_tablas(campoOrden,orden,cantidadamostrar,paginacion,busqueda,tipoVista);
	$("#loading").hide();//ocultar engrane que se queda como si estuviera consultando
	
	llenarSelectSucursal(idsucursalseleccionada);
	
	//AUTOCOMPLETAR
	$( "#autoidcliente" ).autocomplete({
        source: "../componentes/buscarCliente.php",
		autoFocus:true,
		select:function(event,ui){ 
        	$('#cidcliente').val(ui.item.id);
			$('#consultaidcliente').val(ui.item.consulta);
    	},
		search: function (event, ui) {
			$("#cidcliente").val("");
			$("#consultaidcliente").val($("#autoidcliente").val());
		},
		change: function (event, ui) {
			$.ajax({
            	url:'../componentes/Cliente.php',
            	type:'POST',
            	dataType:'json',
				/*En caso de generar una descripció "label" compuesta por dos o mas datos
				en el archivo buscarX.php será necesario cambiar el termino 
				$('#autoX').val() por $('#consultaX').val()*/
            	data:{ termino:$('#autoidcliente').val()}
        		}).done(function(respuesta){
            		$("#cidcliente").val(respuesta.id);
        	});
		},
        minLength: 1
    });
	// FIN AUTOCOMPLETAR
	
	//AUTOCOMPLETAR
	$("#autoidcliente").blur(function(){
		if($("#autoidcliente").val()==""){
			$("#cidcliente").val("");
		}
		if ($("#cidcliente").val()==""){
			$("#consultaidcliente").html(""); 
			$.ajax({
					url:'../componentes/Cliente.php',
					type:'POST',
					dataType:'json',
					/*En caso de generar una descripció "label" compuesta por dos o mas datos
					en el archivo buscarX.php será necesario cambiar el termino 
					$('#autoX').val() por $('#consultaX').val()*/
					data:{ termino:$('#autoidcliente').val()}
					}).done(function(respuesta){
						$('#cidcliente').val(respuesta.id);
			            $('#consultaidcliente').val(respuesta.id);
				});
		}
 	});
	
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
		crearCookie("campoOrdenCotizacionotro", campoOrden);
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$("#cantidadamostrar").change(function(){
		cantidadamostrar = this.value;
		crearCookie("cantidadamostrarCotizacionotro", cantidadamostrar);
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$( "#asc" ).click(function() {
    	if ($( "#asc" ).is(':checked')){
			crearCookie("ordenCotizacionotro", "asc");
			orden="ASC"
			load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
		}
	});
	$( "#desc" ).click(function() {
    	if ($( "#desc" ).is(':checked')){
			crearCookie("ordenCotizacionotro", "desc");
			orden="DESC"
			load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
		}
	});
	$( "#CheckIdcotizacionesotros" ).click(function() {
    	if ($( "#CheckIdcotizacionesotros" ).is(':checked')){
			crearCookie("mostrarIdcotizacionesotrosCotizacionotro", "si");
			$('.Cidcotizacionesotros').show();
		}else{
			crearCookie("mostrarIdcotizacionesotrosCotizacionotro", "no");
			$('.Cidcotizacionesotros').hide();
		}	
	});
	$( "#CheckSerie" ).click(function() {
    	if ($( "#CheckSerie" ).is(':checked')){
			crearCookie("mostrarSerieCotizacionotro", "si");
			$('.Cserie').show();
		}else{
			crearCookie("mostrarSerieCotizacionotro", "no");
			$('.Cserie').hide();
		}	
	});
	$( "#CheckFolio" ).click(function() {
    	if ($( "#CheckFolio" ).is(':checked')){
			crearCookie("mostrarFolioCotizacionotro", "si");
			$('.Cfolio').show();
		}else{
			crearCookie("mostrarFolioCotizacionotro", "no");
			$('.Cfolio').hide();
		}	
	});
	$( "#CheckFecha" ).click(function() {
    	if ($( "#CheckFecha" ).is(':checked')){
			crearCookie("mostrarFechaCotizacionotro", "si");
			$('.Cfecha').show();
		}else{
			crearCookie("mostrarFechaCotizacionotro", "no");
			$('.Cfecha').hide();
		}	
	});
	$( "#CheckTipo" ).click(function() {
    	if ($( "#CheckTipo" ).is(':checked')){
			crearCookie("mostrarTipoCotizacionotro", "si");
			$('.Ctipo').show();
		}else{
			crearCookie("mostrarTipoCotizacionotro", "no");
			$('.Ctipo').hide();
		}	
	});
	$( "#CheckMonto" ).click(function() {
    	if ($( "#CheckMonto" ).is(':checked')){
			crearCookie("mostrarMontoCotizacionotro", "si");
			$('.Cmonto').show();
		}else{
			crearCookie("mostrarMontoCotizacionotro", "no");
			$('.Cmonto').hide();
		}	
	});
	$( "#CheckIdcliente" ).click(function() {
    	if ($( "#CheckIdcliente" ).is(':checked')){
			crearCookie("mostrarIdclienteCotizacionotro", "si");
			$('.Cidcliente').show();
		}else{
			crearCookie("mostrarIdclienteCotizacionotro", "no");
			$('.Cidcliente').hide();
		}	
	});
	$( "#CheckIdsucursal" ).click(function() {
    	if ($( "#CheckIdsucursal" ).is(':checked')){
			crearCookie("mostrarIdsucursalCotizacionotro", "si");
			$('.Cidsucursal').show();
		}else{
			crearCookie("mostrarIdsucursalCotizacionotro", "no");
			$('.Cidsucursal').hide();
		}	
	});
	$( "#CheckIdempleado" ).click(function() {
    	if ($( "#CheckIdempleado" ).is(':checked')){
			crearCookie("mostrarIdempleadoCotizacionotro", "si");
			$('.Cidempleado').show();
		}else{
			crearCookie("mostrarIdempleadoCotizacionotro", "no");
			$('.Cidempleado').hide();
		}	
	});
	$( "#CheckObservaciones" ).click(function() {
    	if ($( "#CheckObservaciones" ).is(':checked')){
			crearCookie("mostrarObservacionesCotizacionotro", "si");
			$('.Cobservaciones').show();
		}else{
			crearCookie("mostrarObservacionesCotizacionotro", "no");
			$('.Cobservaciones').hide();
		}	
	});
	$( "#CheckEstatus" ).click(function() {
    	if ($( "#CheckEstatus" ).is(':checked')){
			crearCookie("mostrarEstatusCotizacionotro", "si");
			$('.Cestatus').show();
		}else{
			crearCookie("mostrarEstatusCotizacionotro", "no");
			$('.Cestatus').hide();
		}	
	});
	$( "#CheckComposicion" ).click(function() {
    	if ($( "#CheckComposicion" ).is(':checked')){
			crearCookie("mostrarComposicionCotizacionotro", "si");
			$('.Ccomposicion').show();
		}else{
			crearCookie("mostrarComposicionCotizacionotro", "no");
			$('.Ccomposicion').hide();
		}
	});
	
	$(".botonBuscar").click(function() {
		var busqueda=$.trim( $("#cajaBuscar").val());
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,busqueda,tipoVista);
	});
	
	$("#botonFiltrar").click(function() {
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
	
	var variables = $("#formulario").serialize();
	
	xmlhttp.open("POST","consultar.php?campoOrden="+campoOrden+"&orden="+orden+"&cantidadamostrar="+cantidadamostrar+"&paginacion="+paginacion+"&busqueda="+busqueda+"&tipoVista="+tipoVista+"&papelera="+papelera+"&"+variables, true);
	xmlhttp.send();
}


function llenarSelectSucursal(condicion){
		$("#idsucursal_ajax").html("<option value='1'>cargando...</option>");
		$.ajax({
			url: '../componentes/llenarSelectSucursal.php',
			type: "POST",
			data: "submit=&condicion="+condicion, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#idsucursal_ajax").html(mensaje);
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