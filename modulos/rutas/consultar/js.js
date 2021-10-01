// JavaScript Document
var orden, campoOrden, cantidadamostrar, paginacion;
orden="DESC";
campoOrden="idruta";
iniciar="0";
cantidadamostrar="20";
paginacion=0;
var CrearRuta=false;
destinos=[];

function verRutaenMapa(idruta,con){
	//crar arreglo de coordenadas y enviar al mapa
	consultarRuta(idruta);
}


//MAPA DE GENERACION DE RUTA
function initMapRuta() {
	
        var directionsService = new google.maps.DirectionsService;
        var directionsRenderer = new google.maps.DirectionsRenderer;
        var mapaRuta = new google.maps.Map(document.getElementById('mapaRuta'), {
          zoom: 6,
          center: {lat: 41.85, lng: -87.65} //Recomendable colocar las coordenadas de la sucursal
        });
        directionsRenderer.setMap(mapaRuta);
		
		///////CREAR CICLO DE COORDENADAS ///////
		var inicio=coordenadassucursal; //cargada desde SSESION en variable por javascript
		var fin=coordenadassucursal; //cargada desde SSESION en variable por javascript
		///////FIN CICLO DE COORDENADAS ///////
			  
		var optimizar=false;
		mostrarRuta(directionsService, directionsRenderer, inicio, destinos, fin, optimizar);
       
		
      }
	  
      function mostrarRuta(directionsService, directionsRenderer, coordenadasinicio,coordenadasintermedias,coordenadasfin, optimizar) {
        var waypts = coordenadasintermedias;
        directionsService.route({
          origin: coordenadasinicio,
          destination: coordenadasfin,
          waypoints: waypts,
          optimizeWaypoints: optimizar,
          travelMode: 'DRIVING'
        },function(response, status) {
          if (status === 'OK') {
            directionsRenderer.setDirections(response);
            var route = response.routes[0];
            // For each route, display summary information.
            var segmentos="";
			var distancia=0;
			var tiempo=0;
			  
			for (var i = 0; i < route.legs.length; i++) {
              var routeSegment = i + 1;
			  
              segmentos += '<b>Segmentos de ruta: ' + routeSegment +
                  '</b><br>';
              segmentos += route.legs[i].start_address + ' <b>a</b> ';
              segmentos += route.legs[i].end_address + '<br>';
              segmentos += route.legs[i].distance.text + '<br>';
			  segmentos += route.legs[i].duration.text + '<br><br>';
			  distancia=distancia+route.legs[i].distance.value;
			  tiempo=tiempo+route.legs[i].duration.value;
            }
			
			$("#kilometrosRuta").html((distancia/1000)+" Km. Totales.");
			$("#tiempoRuta").html((tiempo/60)+" minutos Totales.");
			  
			segmentos +=(distancia/1000)+" Km. Totales.<br>";
			segmentos +=(tiempo/60)+" minutos Totales.";
			
          } else {
            window.alert('No se ha podido trazar la ruta, es probable que algunos destinos no sean accesibles. Verifique su licencia de API Maps Google ' + status);
          }
        });
      }
//MAPA DE EDICION DE COORDENADAS

var vecesMap=false;
var marker;          //variable del marcador
//Funcion principal
initMap = function () 
{
	//usamos la API para geolocalizar el usuario
    var longitud=19.40503465287001;
	var latitud=-102.04849538421627;
	setMapa(longitud,latitud,0);  //pasamos las coordenadas al metodo para crear el mapa
	document.getElementById("ccoordenadas").value =longitud+","+latitud;	
}

function setMapa (longitud,latitud,no){ 
	var geocoder = new google.maps.Geocoder();
	var map = new google.maps.Map(document.getElementById('map'),{
        zoom: 16,
        center:new google.maps.LatLng(longitud,latitud),
	});
	var calle=$("#autocalle").val(), numero=$("#autonoexterior").val(), codigopostal=$("#ccp").val(), ciudad=$("#autociudad").val(), estado=$("#estado_ajax").val();
	var direccion=ciudad+", "+estado+", "+calle+" "+numero+", "+codigopostal;
	direccion=longitud+","+latitud;
	geocoder.geocode({'address': direccion}, function(results, status) {
	if (status === 'OK') {
		var resultados = results[0].geometry.location,
		latitud = resultados.lat(),
		longitud = resultados.lng();
		map.setCenter(results[0].geometry.location);
		var marker = new google.maps.Marker({
			map: map,
			draggable: true,
			animation: google.maps.Animation.DROP,
			position: results[0].geometry.location
		});	
	}else{
		var mensajeError = "";
		if (status === "ZERO_RESULTS") {
			mensajeError = "No hubo resultados para la dirección ingresada.";
		}else if(status === "OVER_QUERY_LIMIT" || status === "REQUEST_DENIED" || status === "UNKNOWN_ERROR"){
			mensajeError = "Error general del mapa.";
		}else if(status === "INVALID_REQUEST"){
			mensajeError = "Error de la web. Contacte con Name Agency.";
		}
			alert(mensajeError);
		}
			
		marker.addListener('click', toggleBounce);
      	marker.addListener( 'dragend', function (event) {
			//escribimos las coordenadas de la posicion actual del marcador dentro del input #ccoordenadas
			document.getElementById("ccoordenadas").value = this.getPosition().lat()+","+ this.getPosition().lng();
			$(".Celdacoordenadas"+noCeldaCoordenada).html($("#ccoordenadas").val());
			actualizarCoordenadasDomicilio($("#ccoordenadas").val(),iddomicilioactualizar);
			noCeldaCoordenada= -1;
		});
	});
    //Creamos el marcador en el mapa con sus propiedades
    //para nuestro obetivo tenemos que poner el atributo draggable en true
    //position pondremos las mismas coordenas que obtuvimos en la geolocalización
      
    //agregamos un evento al marcador junto con la funcion callback al igual que el evento dragend que indica 
    //cuando el usuario a soltado el marcador 
}

//callback al hacer clic en el marcador lo que hace es quitar y poner la animacion BOUNCE
function toggleBounce() {
  if (marker.getAnimation() !== null) {
    marker.setAnimation(null);
  } else {
    marker.setAnimation(google.maps.Animation.BOUNCE);
  }
}


function cancelarRuta(idruta,no){
	var autorizacion = $(".Cautorizada"+no).html();
	$("#loading").show();
	$.ajax({
		url: 'cancelarRuta.php',
		type: "POST",
		data: "submit=&idruta="+idruta+"&autorizacion="+autorizacion, //Pasamos los datos en forma de array
		success: function(mensaje){
			$("#loading").hide();
			mostrarMensaje(mensaje);
			load_tablas(campoOrden,orden,cantidadamostrar,paginacion,busqueda,tipoVista);
		}
	});
	return false;
}

function consultarRuta(idruta){
	//consultar las coordenadas de la ruta
	$.ajax({
		url: 'consultarRuta.php',
		type: "POST",
		data: "submit=&idruta="+idruta, //Pasamos los datos
		success: function(mensaje){
			$("#rutaConsulta").val(mensaje);//obtenemos el resultado de la base de datos
			destinos=obtenerListaCoordenadas();
			initMapRuta();
		}
	});
}

function obtenerListaCoordenadas(){
	//inicializar valores
	var coordenadas=[];//arreglo que se llena para regresarlo de resultado
	var coordenada="";//variable que contiene una coordenada del arreglo por vez en el ciclo
	
	var aCoordenada=[];//arreglo para recibir y dividir la cadena de la base de datos
	//var strCoordenadas="19.40503465287001,-102.04849538421627:19.401940839122346,-102.01000037672122:";//recibir la cadena de la base de datos sin dividir
	
	var strCoordenadas= $("#rutaConsulta").val();
	aCoordenada = strCoordenadas.split(':');
	var con = 0;
	while(con < aCoordenada.length-1){
		coordenada = aCoordenada[con];
		coordenadas.push({location:coordenada,stopover: true});
		con++;
	}
	return coordenadas;
}



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
	if(recuperarCookie("campoOrdenRuta")!=null){
		campoOrden=recuperarCookie("campoOrdenRuta");
		 $("#campoOrden option[value="+campoOrden+"]").attr("selected",true);
	}else{
		campoOrden="idruta";
		$("#campoOrden option[value="+campoOrden+"]").attr("selected",true);
	}
	
	//Identificar el numero de elementos para mostrar
	if(recuperarCookie("cantidadamostrarRuta")!=null){
		cantidadamostrar=recuperarCookie("cantidadamostrarRuta");
		 $("#cantidadamostrar option[value="+cantidadamostrar+"]").attr("selected",true);
	}else{
		cantidadamostrar="20";
		$("#cantidadamostrar option[value="+cantidadamostrar+"]").attr("selected",true);
		
	}
	
	//Identificar el tipo de orden
	if(recuperarCookie("ordenRuta")=="asc"){
		orden="ASC"
		$('#asc').attr('checked', true);
		$('#desc').attr('checked', false);
	}else if(recuperarCookie("ordenRuta")=="desc"){
		orden="DESC"
		$('#asc').attr('checked', false);
		$('#desc').attr('checked', true);
	}else{
		orden="DESC"
		$('#asc').attr('checked', false);
		$('#desc').attr('checked', true);
	}
	//Mostrar u Ocultar Serie
	if(recuperarCookie("mostrarSerieRuta")=="si"){
		$('.Cserie').show();
		$('#CheckSerie').attr('checked', true);
	}else if(recuperarCookie("mostrarSerieRuta")=="no"){
		$('.Cserie').hide();
		$('#CheckSerie').attr('checked', false);
	}
	//Mostrar u Ocultar Folio
	if(recuperarCookie("mostrarFolioRuta")=="si"){
		$('.Cfolio').show();
		$('#CheckFolio').attr('checked', true);
	}else if(recuperarCookie("mostrarFolioRuta")=="no"){
		$('.Cfolio').hide();
		$('#CheckFolio').attr('checked', false);
	}
	//Mostrar u Ocultar Nombre
	if(recuperarCookie("mostrarNombreRuta")=="si"){
		$('.Cnombre').show();
		$('#CheckNombre').attr('checked', true);
	}else if(recuperarCookie("mostrarNombreRuta")=="no"){
		$('.Cnombre').hide();
		$('#CheckNombre').attr('checked', false);
	}
	//Mostrar u Ocultar Fecha
	if(recuperarCookie("mostrarFechaRuta")=="si"){
		$('.Cfecha').show();
		$('#CheckFecha').attr('checked', true);
	}else if(recuperarCookie("mostrarFechaRuta")=="no"){
		$('.Cfecha').hide();
		$('#CheckFecha').attr('checked', false);
	}
	//Mostrar u Ocultar Idempleado
	if(recuperarCookie("mostrarIdempleadoRuta")=="si"){
		$('.Cidempleado').show();
		$('#CheckIdempleado').attr('checked', true);
	}else if(recuperarCookie("mostrarIdempleadoRuta")=="no"){
		$('.Cidempleado').hide();
		$('#CheckIdempleado').attr('checked', false);
	}
	//Mostrar u Ocultar Observacionesruta
	if(recuperarCookie("mostrarObservacionesrutaRuta")=="si"){
		$('.Cobservacionesruta').show();
		$('#CheckObservacionesruta').attr('checked', true);
	}else if(recuperarCookie("mostrarObservacionesrutaRuta")=="no"){
		$('.Cobservacionesruta').hide();
		$('#CheckObservacionesruta').attr('checked', false);
	}
	//Mostrar u Ocultar Observacionessalida
	if(recuperarCookie("mostrarObservacionessalidaRuta")=="si"){
		$('.Cobservacionessalida').show();
		$('#CheckObservacionessalida').attr('checked', true);
	}else if(recuperarCookie("mostrarObservacionessalidaRuta")=="no"){
		$('.Cobservacionessalida').hide();
		$('#CheckObservacionessalida').attr('checked', false);
	}
	//Mostrar u Ocultar Autorizada
	if(recuperarCookie("mostrarAutorizadaRuta")=="si"){
		$('.Cautorizada').show();
		$('#CheckAutorizada').attr('checked', true);
	}else if(recuperarCookie("mostrarAutorizadaRuta")=="no"){
		$('.Cautorizada').hide();
		$('#CheckAutorizada').attr('checked', false);
	}
	//Mostrar u Ocultar Composicion
	if(recuperarCookie("mostrarComposicionRuta")=="si"){
		$('.Ccomposicion').show();
		$('#CheckComposicion').attr('checked', true);
	}
	if(recuperarCookie("mostrarComposicionRuta")=="no"){
		$('.Ccomposicion').hide();
		$('#CheckComposicion').attr('checked', false);
	}
	
	//Elegir el tipo de vista
	if(recuperarCookie("tipoVistaRuta")=="tabla"){
		$('.tipoLista').show();
		$('.tipoTabla').hide();
		tipoVista="tabla";
	}else{
		$('.tipoLista').hide();
		$('.tipoTabla').show();
		tipoVista="lista";
	}
	$( ".tipoTabla" ).click(function() {
    	crearCookie("tipoVistaRuta", "tabla");
		tipoVista="tabla";
		$(".tipoLista").show();
		$(".tipoTabla").hide();
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$( ".tipoLista" ).click(function() {
    	crearCookie("tipoVistaRuta", "lista");
		tipoVista="lista";
		$(".tipoLista").hide();
		$(".tipoTabla").show();
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});

}

	
$(document).ready(function() {
	$("#cajaBuscar").focus();
	$("#loading").hide();
	comprobarReglas();
	//load_tablas(campoOrden,orden,cantidadamostrar,paginacion,busqueda,tipoVista);
	
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
		crearCookie("campoOrdenRuta", campoOrden);
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$("#cantidadamostrar").change(function(){
		cantidadamostrar = this.value;
		crearCookie("cantidadamostrarRuta", cantidadamostrar);
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$( "#asc" ).click(function() {
    	if ($( "#asc" ).is(':checked')){
			crearCookie("ordenRuta", "asc");
			orden="ASC"
			load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
		}
	});
	$( "#desc" ).click(function() {
    	if ($( "#desc" ).is(':checked')){
			crearCookie("ordenRuta", "desc");
			orden="DESC"
			load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
		}
	});
	$( "#CheckSerie" ).click(function() {
    	if ($( "#CheckSerie" ).is(':checked')){
			crearCookie("mostrarSerieRuta", "si");
			$('.Cserie').show();
		}else{
			crearCookie("mostrarSerieRuta", "no");
			$('.Cserie').hide();
		}	
	});
	$( "#CheckFolio" ).click(function() {
    	if ($( "#CheckFolio" ).is(':checked')){
			crearCookie("mostrarFolioRuta", "si");
			$('.Cfolio').show();
		}else{
			crearCookie("mostrarFolioRuta", "no");
			$('.Cfolio').hide();
		}	
	});
	$( "#CheckNombre" ).click(function() {
    	if ($( "#CheckNombre" ).is(':checked')){
			crearCookie("mostrarNombreRuta", "si");
			$('.Cnombre').show();
		}else{
			crearCookie("mostrarNombreRuta", "no");
			$('.Cnombre').hide();
		}	
	});
	$( "#CheckFecha" ).click(function() {
    	if ($( "#CheckFecha" ).is(':checked')){
			crearCookie("mostrarFechaRuta", "si");
			$('.Cfecha').show();
		}else{
			crearCookie("mostrarFechaRuta", "no");
			$('.Cfecha').hide();
		}	
	});
	$( "#CheckIdempleado" ).click(function() {
    	if ($( "#CheckIdempleado" ).is(':checked')){
			crearCookie("mostrarIdempleadoRuta", "si");
			$('.Cidempleado').show();
		}else{
			crearCookie("mostrarIdempleadoRuta", "no");
			$('.Cidempleado').hide();
		}	
	});
	$( "#CheckObservacionesruta" ).click(function() {
    	if ($( "#CheckObservacionesruta" ).is(':checked')){
			crearCookie("mostrarObservacionesrutaRuta", "si");
			$('.Cobservacionesruta').show();
		}else{
			crearCookie("mostrarObservacionesrutaRuta", "no");
			$('.Cobservacionesruta').hide();
		}	
	});
	$( "#CheckObservacionessalida" ).click(function() {
    	if ($( "#CheckObservacionessalida" ).is(':checked')){
			crearCookie("mostrarObservacionessalidaRuta", "si");
			$('.Cobservacionessalida').show();
		}else{
			crearCookie("mostrarObservacionessalidaRuta", "no");
			$('.Cobservacionessalida').hide();
		}	
	});
	$( "#CheckAutorizada" ).click(function() {
    	if ($( "#CheckAutorizada" ).is(':checked')){
			crearCookie("mostrarAutorizadaRuta", "si");
			$('.Cautorizada').show();
		}else{
			crearCookie("mostrarAutorizadaRuta", "no");
			$('.Cautorizada').hide();
		}	
	});
	$( "#CheckComposicion" ).click(function() {
    	if ($( "#CheckComposicion" ).is(':checked')){
			crearCookie("mostrarComposicionRuta", "si");
			$('.Ccomposicion').show();
		}else{
			crearCookie("mostrarComposicionRuta", "no");
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
	
	$("#botonFiltrar").click(function() {
		    $("#filtroavanzado").val("Si");
			load_tablas(campoOrden,orden,cantidadamostrar,paginacion,busqueda,tipoVista);
	});
	
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

function cancelarRuta(idruta,no){
	var autorizacion = $(".Cautorizada"+no).html();
	$("#loading").show();
	$.ajax({
		url: 'cancelarRuta.php',
		type: "POST",
		data: "submit=&idruta="+idruta+"&autorizacion="+autorizacion, //Pasamos los datos en forma de array
		success: function(mensaje){
			$("#loading").hide();
			mostrarMensaje(mensaje);
			load_tablas(campoOrden,orden,cantidadamostrar,paginacion,busqueda,tipoVista);
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