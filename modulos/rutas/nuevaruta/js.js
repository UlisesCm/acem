// JavaScript Document
var FILAS=0;
var noCeldaCoordenada= -1;
var iddomicilioactualizar = 0;
var orden, campoOrden, cantidadamostrar, paginacion;
orden="DESC";
campoOrden="idcotizacionproducto";
iniciar="0";
cantidadamostrar="20";
paginacion=0;

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
			  
		
		document.getElementById('botonGenerarRutaTabla').addEventListener('click', function() {
			 $("#tipoRuta").val("TABLA");
			  destinos=[];
			  destinos=obtenerListaCoordenadas("tablaOrden");
			  var optimizar=false;
			  mostrarRuta(directionsService, directionsRenderer, inicio, destinos, fin, optimizar);
        });
		
		document.getElementById('botonGenerarRutaDistancia').addEventListener('click', function() {
			 $("#tipoRuta").val("OPTIMA");
			  destinos=[];
			  destinos=obtenerListaCoordenadas("tablaOrden");
			  var optimizar=true;
			  mostrarRuta(directionsService, directionsRenderer, inicio, destinos, fin, optimizar);
        });
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
			  
			var coor="";
			for (var i = 0; i < route.legs.length; i++) {
              var routeSegment = i + 1;
			  if(i!=0 && i!= route.legs.length){
			  	coor += route.legs[i].start_location.lat().toFixed(3)+"," +route.legs[i].start_location.lng().toFixed(3)+":::";
			  }
              segmentos += '<b>Segmentos de ruta: ' + routeSegment +
                  '</b><br>';
              segmentos += route.legs[i].start_address + ' <b>a</b> ';
              segmentos += route.legs[i].end_address + '<br>';
              segmentos += route.legs[i].distance.text + '<br>';
			  segmentos += route.legs[i].duration.text + '<br><br>';
			  distancia=distancia+route.legs[i].distance.value;
			  tiempo=tiempo+route.legs[i].duration.value;
            }
			$("#listaSalidaOptima").val(coor);
			
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
	setMapa("","","","","","",0,"",longitud,latitud);  //pasamos las coordenadas al metodo para crear el mapa
	document.getElementById("ccoordenadas").value =longitud+","+latitud;	
}

function setMapa (calle,numero,colonia,cp,ciudad,estado,no,iddomicilio,longitud,latitud){ 
	var geocoder = new google.maps.Geocoder();
	var map = new google.maps.Map(document.getElementById('map'),{
        zoom: 16,
        center:new google.maps.LatLng(longitud,latitud),
	});
	//revisar si las coordenadas son diferente de 0 en caso contrario ubicar con los datos del domicilio
	var direccion="";
	if(longitud==0){//
	//var calle=$("#autocalle").val(), numero=$("#autonoexterior").val(), codigopostal=$("#ccp").val(), ciudad=$("#autociudad").val(), estado=$("#estado_ajax").val();
	   direccion=calle+", "+numero+", "+colonia+" "+cp+", "+ciudad+", "+estado;
	}
	else{
		direccion=longitud+","+latitud;
	}
	
	
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

// Carga de la libreria de google maps
onclick="abrirModalDomicilio(CONOCIDO,S/N,-,58100,CHUCANDIRO,MICHOACÁN,4,2722017220812,19.895437912341073,-101.33101730632934);"
function abrirModalDomicilio(calle,numero,colonia,cp,ciudad,estado,no,iddomicilio,longitudActualDomSel,latitudActualDomSel){
	noCeldaCoordenada= no;
	iddomicilioactualizar = iddomicilio;
	$("#modal").modal();
	if (vecesMap==false){
		var longitud=longitudActualDomSel;
		var latitud=latitudActualDomSel;
		setMapa(calle,numero,colonia,cp,ciudad,estado,no,iddomicilio,longitudActualDomSel,latitudActualDomSel);
		//vecesMap=true;
	}
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
	if(recuperarCookie("campoOrdenCotizacionproducto")!=null){
		campoOrden=recuperarCookie("campoOrdenCotizacionproducto");
		 $("#campoOrden option[value="+campoOrden+"]").attr("selected",true);
	}else{
		campoOrden="idcotizacionproducto";
		$("#campoOrden option[value="+campoOrden+"]").attr("selected",true);
	}
	
	//Identificar el numero de elementos para mostrar
	if(recuperarCookie("cantidadamostrarCotizacionproducto")!=null){
		cantidadamostrar=recuperarCookie("cantidadamostrarCotizacionproducto");
		 $("#cantidadamostrar option[value="+cantidadamostrar+"]").attr("selected",true);
	}else{
		cantidadamostrar="20";
		$("#cantidadamostrar option[value="+cantidadamostrar+"]").attr("selected",true);
		
	}
	//Identificar el tipo de orden
	if(recuperarCookie("ordenCotizacionproducto")=="asc"){
		orden="ASC"
		$('#asc').attr('checked', true);
		$('#desc').attr('checked', false);
	}else if(recuperarCookie("ordenCotizacionproducto")=="desc"){
		orden="DESC"
		$('#asc').attr('checked', false);
		$('#desc').attr('checked', true);
	}else{
		orden="DESC"
		$('#asc').attr('checked', false);
		$('#desc').attr('checked', true);
	}
	//Mostrar u Ocultar Idcotizacionproducto
	if(recuperarCookie("mostrarIdcotizacionproductoCotizacionproducto")=="si"){
		$('.Cidcotizacionproducto').show();
		$('#CheckIdcotizacionproducto').attr('checked', true);
	}else if(recuperarCookie("mostrarIdcotizacionproductoCotizacionproducto")=="no"){
		$('.Cidcotizacionproducto').hide();
		$('#CheckIdcotizacionproducto').attr('checked', false);
	}
	//Mostrar u Ocultar Serie
	if(recuperarCookie("mostrarSerieCotizacionproducto")=="si"){
		$('.Cserie').show();
		$('#CheckSerie').attr('checked', true);
	}else if(recuperarCookie("mostrarSerieCotizacionproducto")=="no"){
		$('.Cserie').hide();
		$('#CheckSerie').attr('checked', false);
	}
	//Mostrar u Ocultar Folio
	if(recuperarCookie("mostrarFolioCotizacionproducto")=="si"){
		$('.Cfolio').show();
		$('#CheckFolio').attr('checked', true);
	}else if(recuperarCookie("mostrarFolioCotizacionproducto")=="no"){
		$('.Cfolio').hide();
		$('#CheckFolio').attr('checked', false);
	}
	//Mostrar u Ocultar Fecha
	if(recuperarCookie("mostrarFechaCotizacionproducto")=="si"){
		$('.Cfecha').show();
		$('#CheckFecha').attr('checked', true);
	}else if(recuperarCookie("mostrarFechaCotizacionproducto")=="no"){
		$('.Cfecha').hide();
		$('#CheckFecha').attr('checked', false);
	}
	//Mostrar u Ocultar Hora
	if(recuperarCookie("mostrarHoraCotizacionproducto")=="si"){
		$('.Chora').show();
		$('#CheckHora').attr('checked', true);
	}else if(recuperarCookie("mostrarHoraCotizacionproducto")=="no"){
		$('.Chora').hide();
		$('#CheckHora').attr('checked', false);
	}
	//Mostrar u Ocultar Estadopago
	if(recuperarCookie("mostrarEstadopagoCotizacionproducto")=="si"){
		$('.Cestadopago').show();
		$('#CheckEstadopago').attr('checked', true);
	}else if(recuperarCookie("mostrarEstadopagoCotizacionproducto")=="no"){
		$('.Cestadopago').hide();
		$('#CheckEstadopago').attr('checked', false);
	}
	//Mostrar u Ocultar Estadofacturacion
	if(recuperarCookie("mostrarEstadofacturacionCotizacionproducto")=="si"){
		$('.Cestadofacturacion').show();
		$('#CheckEstadofacturacion').attr('checked', true);
	}else if(recuperarCookie("mostrarEstadofacturacionCotizacionproducto")=="no"){
		$('.Cestadofacturacion').hide();
		$('#CheckEstadofacturacion').attr('checked', false);
	}
	//Mostrar u Ocultar Tipo
	if(recuperarCookie("mostrarTipoCotizacionproducto")=="si"){
		$('.Ctipo').show();
		$('#CheckTipo').attr('checked', true);
	}else if(recuperarCookie("mostrarTipoCotizacionproducto")=="no"){
		$('.Ctipo').hide();
		$('#CheckTipo').attr('checked', false);
	}
	//Mostrar u Ocultar Subtotal
	if(recuperarCookie("mostrarSubtotalCotizacionproducto")=="si"){
		$('.Csubtotal').show();
		$('#CheckSubtotal').attr('checked', true);
	}else if(recuperarCookie("mostrarSubtotalCotizacionproducto")=="no"){
		$('.Csubtotal').hide();
		$('#CheckSubtotal').attr('checked', false);
	}
	//Mostrar u Ocultar Impuestos
	if(recuperarCookie("mostrarImpuestosCotizacionproducto")=="si"){
		$('.Cimpuestos').show();
		$('#CheckImpuestos').attr('checked', true);
	}else if(recuperarCookie("mostrarImpuestosCotizacionproducto")=="no"){
		$('.Cimpuestos').hide();
		$('#CheckImpuestos').attr('checked', false);
	}
	//Mostrar u Ocultar Total
	if(recuperarCookie("mostrarTotalCotizacionproducto")=="si"){
		$('.Ctotal').show();
		$('#CheckTotal').attr('checked', true);
	}else if(recuperarCookie("mostrarTotalCotizacionproducto")=="no"){
		$('.Ctotal').hide();
		$('#CheckTotal').attr('checked', false);
	}
	//Mostrar u Ocultar Idcliente
	if(recuperarCookie("mostrarIdclienteCotizacionproducto")=="si"){
		$('.Cidcliente').show();
		$('#CheckIdcliente').attr('checked', true);
	}else if(recuperarCookie("mostrarIdclienteCotizacionproducto")=="no"){
		$('.Cidcliente').hide();
		$('#CheckIdcliente').attr('checked', false);
	}
	//Mostrar u Ocultar Idusuario
	if(recuperarCookie("mostrarIdusuarioCotizacionproducto")=="si"){
		$('.Cidusuario').show();
		$('#CheckIdusuario').attr('checked', true);
	}else if(recuperarCookie("mostrarIdusuarioCotizacionproducto")=="no"){
		$('.Cidusuario').hide();
		$('#CheckIdusuario').attr('checked', false);
	}
	//Mostrar u Ocultar Idempleado
	if(recuperarCookie("mostrarIdempleadoCotizacionproducto")=="si"){
		$('.Cidempleado').show();
		$('#CheckIdempleado').attr('checked', true);
	}else if(recuperarCookie("mostrarIdempleadoCotizacionproducto")=="no"){
		$('.Cidempleado').hide();
		$('#CheckIdempleado').attr('checked', false);
	}
	//Mostrar u Ocultar Enviaradomicilio
	if(recuperarCookie("mostrarEnviaradomicilioCotizacionproducto")=="si"){
		$('.Cenviaradomicilio').show();
		$('#CheckEnviaradomicilio').attr('checked', true);
	}else if(recuperarCookie("mostrarEnviaradomicilioCotizacionproducto")=="no"){
		$('.Cenviaradomicilio').hide();
		$('#CheckEnviaradomicilio').attr('checked', false);
	}
	//Mostrar u Ocultar Fechaentrega
	if(recuperarCookie("mostrarFechaentregaCotizacionproducto")=="si"){
		$('.Cfechaentrega').show();
		$('#CheckFechaentrega').attr('checked', true);
	}else if(recuperarCookie("mostrarFechaentregaCotizacionproducto")=="no"){
		$('.Cfechaentrega').hide();
		$('#CheckFechaentrega').attr('checked', false);
	}
	//Mostrar u Ocultar Horaentregainicio
	if(recuperarCookie("mostrarHoraentregainicioCotizacionproducto")=="si"){
		$('.Choraentregainicio').show();
		$('#CheckHoraentregainicio').attr('checked', true);
	}else if(recuperarCookie("mostrarHoraentregainicioCotizacionproducto")=="no"){
		$('.Choraentregainicio').hide();
		$('#CheckHoraentregainicio').attr('checked', false);
	}
	//Mostrar u Ocultar Horaentregafin
	if(recuperarCookie("mostrarHoraentregafinCotizacionproducto")=="si"){
		$('.Choraentregafin').show();
		$('#CheckHoraentregafin').attr('checked', true);
	}else if(recuperarCookie("mostrarHoraentregafinCotizacionproducto")=="no"){
		$('.Choraentregafin').hide();
		$('#CheckHoraentregafin').attr('checked', false);
	}
	//Mostrar u Ocultar Prioridad
	if(recuperarCookie("mostrarPrioridadCotizacionproducto")=="si"){
		$('.Cprioridad').show();
		$('#CheckPrioridad').attr('checked', true);
	}else if(recuperarCookie("mostrarPrioridadCotizacionproducto")=="no"){
		$('.Cprioridad').hide();
		$('#CheckPrioridad').attr('checked', false);
	}
	//Mostrar u Ocultar Domicilioentrega
	if(recuperarCookie("mostrarDomicilioentregaCotizacionproducto")=="si"){
		$('.Cdomicilioentrega').show();
		$('#CheckDomicilioentrega').attr('checked', true);
	}else if(recuperarCookie("mostrarDomicilioentregaCotizacionproducto")=="no"){
		$('.Cdomicilioentrega').hide();
		$('#CheckDomicilioentrega').attr('checked', false);
	}
	//Mostrar u Ocultar Coordenadas
	if(recuperarCookie("mostrarCoordenadasCotizacionproducto")=="si"){
		$('.Ccoordenadas').show();
		$('#CheckCoordenadas').attr('checked', true);
	}else if(recuperarCookie("mostrarCoordenadasCotizacionproducto")=="no"){
		$('.Ccoordenadas').hide();
		$('#CheckCoordenadas').attr('checked', false);
	}
	//Mostrar u Ocultar Observaciones
	if(recuperarCookie("mostrarObservacionesCotizacionproducto")=="si"){
		$('.Cobservaciones').show();
		$('#CheckObservaciones').attr('checked', true);
	}else if(recuperarCookie("mostrarObservacionesCotizacionproducto")=="no"){
		$('.Cobservaciones').hide();
		$('#CheckObservaciones').attr('checked', false);
	}
	//Mostrar u Ocultar Estadoentrega
	if(recuperarCookie("mostrarEstadoentregaCotizacionproducto")=="si"){
		$('.Cestadoentrega').show();
		$('#CheckEstadoentrega').attr('checked', true);
	}else if(recuperarCookie("mostrarEstadoentregaCotizacionproducto")=="no"){
		$('.Cestadoentrega').hide();
		$('#CheckEstadoentrega').attr('checked', false);
	}
	//Mostrar u Ocultar Composicion
	if(recuperarCookie("mostrarComposicionCotizacionproducto")=="si"){
		$('.Ccomposicion').show();
		$('#CheckComposicion').attr('checked', true);
	}
	if(recuperarCookie("mostrarComposicionCotizacionproducto")=="no"){
		$('.Ccomposicion').hide();
		$('#CheckComposicion').attr('checked', false);
	}
	
	//Elegir el tipo de vista
	if(recuperarCookie("tipoVistaCotizacionproducto")=="tabla"){
		$('.tipoLista').show();
		$('.tipoTabla').hide();
		tipoVista="tabla";
	}else{
		$('.tipoLista').hide();
		$('.tipoTabla').show();
		tipoVista="lista";
	}
	$( ".tipoTabla" ).click(function() {
    	crearCookie("tipoVistaCotizacionproducto", "tabla");
		tipoVista="tabla";
		$(".tipoLista").show();
		$(".tipoTabla").hide();
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$( ".tipoLista" ).click(function() {
    	crearCookie("tipoVistaCotizacionproducto", "lista");
		tipoVista="lista";
		$(".tipoLista").hide();
		$(".tipoTabla").show();
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});

}

	
$(document).ready(function() {
	inicializarDrags();
	$("#cajaBuscar").focus();
	comprobarReglas();
	$("#loading").hide();
	/*if($("#cidcliente").val()!=""){//cargar la consulta de contizaciones pendientes de este cliente
	    load_tablas(campoOrden,orden,cantidadamostrar,paginacion,busqueda,tipoVista);
		llenarSelectDomicilio($("#cidcliente").val());
	}
	else{
		$("#loading").hide();
		//NO CARGAR POR DEFAULT LA CONSULTA
		 //load_tablas(campoOrden,orden,cantidadamostrar,paginacion,busqueda,tipoVista);
	}*/
	
	
	//llenarSelectSucursal(idsucursalseleccionada);
	//llenarSelectZona("");
	obtenerSerie();
	obtenerFolio();
	llenarSelectZona("");
	llenarSelectEmpleado("");
	
	load_tablas(campoOrden,orden,cantidadamostrar,paginacion,busqueda,tipoVista);
	
	//AUTOCOMPLETAR
	$( "#autoidcliente" ).autocomplete({
        source: "../componentes/buscarCliente.php",
		autoFocus:true,
		select:function(event,ui){ 
        	$('#cidcliente').val(ui.item.id);
			$('#consultaidcliente').val(ui.item.consulta);
			llenarSelectDomicilio(ui.item.id);
    	},
		search: function (event, ui) {
			$("#cidcliente").val("");
			$("#consultaidcliente").val($("#autoidcliente").val());
			llenarSelectDomicilio(0);
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
					llenarSelectDomicilio(ui.item.id);
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
			            llenarSelectDomicilio(respuesta.id);
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
		crearCookie("campoOrdenCotizacionproducto", campoOrden);
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$("#cantidadamostrar").change(function(){
		cantidadamostrar = this.value;
		crearCookie("cantidadamostrarCotizacionproducto", cantidadamostrar);
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$( "#asc" ).click(function() {
    	if ($( "#asc" ).is(':checked')){
			crearCookie("ordenCotizacionproducto", "asc");
			orden="ASC"
			load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
		}
	});
	$( "#desc" ).click(function() {
    	if ($( "#desc" ).is(':checked')){
			crearCookie("ordenCotizacionproducto", "desc");
			orden="DESC"
			load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
		}
	});
	$( "#CheckIdcotizacionproducto" ).click(function() {
    	if ($( "#CheckIdcotizacionproducto" ).is(':checked')){
			crearCookie("mostrarIdcotizacionproductoCotizacionproducto", "si");
			$('.Cidcotizacionproducto').show();
		}else{
			crearCookie("mostrarIdcotizacionproductoCotizacionproducto", "no");
			$('.Cidcotizacionproducto').hide();
		}	
	});
	$( "#CheckSerie" ).click(function() {
    	if ($( "#CheckSerie" ).is(':checked')){
			crearCookie("mostrarSerieCotizacionproducto", "si");
			$('.Cserie').show();
		}else{
			crearCookie("mostrarSerieCotizacionproducto", "no");
			$('.Cserie').hide();
		}	
	});
	$( "#CheckFolio" ).click(function() {
    	if ($( "#CheckFolio" ).is(':checked')){
			crearCookie("mostrarFolioCotizacionproducto", "si");
			$('.Cfolio').show();
		}else{
			crearCookie("mostrarFolioCotizacionproducto", "no");
			$('.Cfolio').hide();
		}	
	});
	$( "#CheckFecha" ).click(function() {
    	if ($( "#CheckFecha" ).is(':checked')){
			crearCookie("mostrarFechaCotizacionproducto", "si");
			$('.Cfecha').show();
		}else{
			crearCookie("mostrarFechaCotizacionproducto", "no");
			$('.Cfecha').hide();
		}	
	});
	$( "#CheckHora" ).click(function() {
    	if ($( "#CheckHora" ).is(':checked')){
			crearCookie("mostrarHoraCotizacionproducto", "si");
			$('.Chora').show();
		}else{
			crearCookie("mostrarHoraCotizacionproducto", "no");
			$('.Chora').hide();
		}	
	});
	$( "#CheckEstadopago" ).click(function() {
    	if ($( "#CheckEstadopago" ).is(':checked')){
			crearCookie("mostrarEstadopagoCotizacionproducto", "si");
			$('.Cestadopago').show();
		}else{
			crearCookie("mostrarEstadopagoCotizacionproducto", "no");
			$('.Cestadopago').hide();
		}	
	});
	$( "#CheckEstadofacturacion" ).click(function() {
    	if ($( "#CheckEstadofacturacion" ).is(':checked')){
			crearCookie("mostrarEstadofacturacionCotizacionproducto", "si");
			$('.Cestadofacturacion').show();
		}else{
			crearCookie("mostrarEstadofacturacionCotizacionproducto", "no");
			$('.Cestadofacturacion').hide();
		}	
	});
	$( "#CheckTipo" ).click(function() {
    	if ($( "#CheckTipo" ).is(':checked')){
			crearCookie("mostrarTipoCotizacionproducto", "si");
			$('.Ctipo').show();
		}else{
			crearCookie("mostrarTipoCotizacionproducto", "no");
			$('.Ctipo').hide();
		}	
	});
	$( "#CheckSubtotal" ).click(function() {
    	if ($( "#CheckSubtotal" ).is(':checked')){
			crearCookie("mostrarSubtotalCotizacionproducto", "si");
			$('.Csubtotal').show();
		}else{
			crearCookie("mostrarSubtotalCotizacionproducto", "no");
			$('.Csubtotal').hide();
		}	
	});
	$( "#CheckImpuestos" ).click(function() {
    	if ($( "#CheckImpuestos" ).is(':checked')){
			crearCookie("mostrarImpuestosCotizacionproducto", "si");
			$('.Cimpuestos').show();
		}else{
			crearCookie("mostrarImpuestosCotizacionproducto", "no");
			$('.Cimpuestos').hide();
		}	
	});
	$( "#CheckTotal" ).click(function() {
    	if ($( "#CheckTotal" ).is(':checked')){
			crearCookie("mostrarTotalCotizacionproducto", "si");
			$('.Ctotal').show();
		}else{
			crearCookie("mostrarTotalCotizacionproducto", "no");
			$('.Ctotal').hide();
		}	
	});
	$( "#CheckIdcliente" ).click(function() {
    	if ($( "#CheckIdcliente" ).is(':checked')){
			crearCookie("mostrarIdclienteCotizacionproducto", "si");
			$('.Cidcliente').show();
		}else{
			crearCookie("mostrarIdclienteCotizacionproducto", "no");
			$('.Cidcliente').hide();
		}	
	});
	$( "#CheckIdusuario" ).click(function() {
    	if ($( "#CheckIdusuario" ).is(':checked')){
			crearCookie("mostrarIdusuarioCotizacionproducto", "si");
			$('.Cidusuario').show();
		}else{
			crearCookie("mostrarIdusuarioCotizacionproducto", "no");
			$('.Cidusuario').hide();
		}	
	});
	$( "#CheckIdempleado" ).click(function() {
    	if ($( "#CheckIdempleado" ).is(':checked')){
			crearCookie("mostrarIdempleadoCotizacionproducto", "si");
			$('.Cidempleado').show();
		}else{
			crearCookie("mostrarIdempleadoCotizacionproducto", "no");
			$('.Cidempleado').hide();
		}	
	});
	$( "#CheckEnviaradomicilio" ).click(function() {
    	if ($( "#CheckEnviaradomicilio" ).is(':checked')){
			crearCookie("mostrarEnviaradomicilioCotizacionproducto", "si");
			$('.Cenviaradomicilio').show();
		}else{
			crearCookie("mostrarEnviaradomicilioCotizacionproducto", "no");
			$('.Cenviaradomicilio').hide();
		}	
	});
	$( "#CheckFechaentrega" ).click(function() {
    	if ($( "#CheckFechaentrega" ).is(':checked')){
			crearCookie("mostrarFechaentregaCotizacionproducto", "si");
			$('.Cfechaentrega').show();
		}else{
			crearCookie("mostrarFechaentregaCotizacionproducto", "no");
			$('.Cfechaentrega').hide();
		}	
	});
	$( "#CheckHoraentregainicio" ).click(function() {
    	if ($( "#CheckHoraentregainicio" ).is(':checked')){
			crearCookie("mostrarHoraentregainicioCotizacionproducto", "si");
			$('.Choraentregainicio').show();
		}else{
			crearCookie("mostrarHoraentregainicioCotizacionproducto", "no");
			$('.Choraentregainicio').hide();
		}	
	});
	$( "#CheckHoraentregafin" ).click(function() {
    	if ($( "#CheckHoraentregafin" ).is(':checked')){
			crearCookie("mostrarHoraentregafinCotizacionproducto", "si");
			$('.Choraentregafin').show();
		}else{
			crearCookie("mostrarHoraentregafinCotizacionproducto", "no");
			$('.Choraentregafin').hide();
		}	
	});
	$( "#CheckPrioridad" ).click(function() {
    	if ($( "#CheckPrioridad" ).is(':checked')){
			crearCookie("mostrarPrioridadCotizacionproducto", "si");
			$('.Cprioridad').show();
		}else{
			crearCookie("mostrarPrioridadCotizacionproducto", "no");
			$('.Cprioridad').hide();
		}	
	});
	$( "#CheckDomicilioentrega" ).click(function() {
    	if ($( "#CheckDomicilioentrega" ).is(':checked')){
			crearCookie("mostrarDomicilioentregaCotizacionproducto", "si");
			$('.Cdomicilioentrega').show();
		}else{
			crearCookie("mostrarDomicilioentregaCotizacionproducto", "no");
			$('.Cdomicilioentrega').hide();
		}	
	});
	$( "#CheckCoordenadas" ).click(function() {
    	if ($( "#CheckCoordenadas" ).is(':checked')){
			crearCookie("mostrarCoordenadasCotizacionproducto", "si");
			$('.Ccoordenadas').show();
		}else{
			crearCookie("mostrarCoordenadasCotizacionproducto", "no");
			$('.Ccoordenadas').hide();
		}	
	});
	$( "#CheckObservaciones" ).click(function() {
    	if ($( "#CheckObservaciones" ).is(':checked')){
			crearCookie("mostrarObservacionesCotizacionproducto", "si");
			$('.Cobservaciones').show();
		}else{
			crearCookie("mostrarObservacionesCotizacionproducto", "no");
			$('.Cobservaciones').hide();
		}	
	});
	$( "#CheckEstadoentrega" ).click(function() {
    	if ($( "#CheckEstadoentrega" ).is(':checked')){
			crearCookie("mostrarEstadoentregaCotizacionproducto", "si");
			$('.Cestadoentrega').show();
		}else{
			crearCookie("mostrarEstadoentregaCotizacionproducto", "no");
			$('.Cestadoentrega').hide();
		}	
	});
	$( "#CheckComposicion" ).click(function() {
    	if ($( "#CheckComposicion" ).is(':checked')){
			crearCookie("mostrarComposicionCotizacionproducto", "si");
			$('.Ccomposicion').show();
		}else{
			crearCookie("mostrarComposicionCotizacionproducto", "no");
			$('.Ccomposicion').hide();
		}
	});
	
	$(".botonBuscar").click(function() {
		var busqueda=$.trim( $("#cajaBuscar").val());
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,busqueda,tipoVista);
	});
	
	$("#botonFiltrar").click(function() {
		    $("#filtroavanzado").val("Si");
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
	
	$("#idempleado_ajax").change(function(){
		var idempleado = $("#idempleado_ajax").val();
		$.ajax({
			url: '../componentes/obtenerDatosVehiculo.php',
			type: "POST",
			data: "submit=&idempleado="+idempleado, //Pasam
			success: function(mensaje){
					dato=mensaje.split(",");
					var Vehiculo=dato[0];
					var Carga=dato[1];
					$("#nombrevehiculo").val(Vehiculo);
					$("#capacidaddeCarga").val(Carga);
					recorrerTablaOrden("tablaOrden","listaSalida");//que actualice la tabla draggable
			}
		});
		return false;
	});
	
	$("#idzona_ajax").change(function(){
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,busqueda,tipoVista);
	});
	
	$(".close").click(function(){ 
		$("#panel_alertas").stop(false, true);
		$("#panel_alertas").hide();
 	});
	
	$("#botonAceptar").click(function(){
		if (validar()){
			var variables=$("#formulario").serialize();
			guardar(variables);
		}
	});
	
	$(document).on("click",".eliminarFila",function(){
		var parent = $(this).parents().get(0);
		recorrerTablaOrden("tablaOrden","listaSalida");//que actualice la tabla draggable
		$(parent).remove();
		var con =$(parent).children(".Ccon").html();
		var idcotizacionproducto=$(parent).children(".Cidcotizacionproducto").html();
		var idusuario=$(parent).children(".Cidusuario").html();
		var idempleado=$(parent).children(".Cidempleado").html();
		var folio=$(parent).children(".Cfolio").html();
		var fecha=$(parent).children(".Cfecha").html();
		var idcliente=$(parent).children(".Cidcliente").html();
		var domicilioentrega=$(parent).children(".Cdomicilioentrega").html();
		var coordenadas=$(parent).children(".Celdacoordenadas"+con+"").html();
		var fechaentrega=$(parent).children(".Cfechaentrega").html();
		var prioridad=$(parent).children(".Cprioridad").html();
		var peso=$(parent).children(".Cpeso").html();
		var total=$(parent).children(".Ctotal").html();
		var observaciones=$(parent).children(".Cobservaciones").html();
		var mapa=$(parent).children(".Cmapa").html();
		var detalles=$(parent).children(".Cdetalles").html();
		
		variables=new Array();
		variables[0]=con; //Nueva fila
		variables[1]=idcotizacionproducto;
		variables[2]=idusuario;
		variables[3]=idempleado;
		variables[4]=folio;
		variables[5]=fecha;
		variables[6]=idcliente;
		variables[7]=domicilioentrega;
		variables[8]=coordenadas;
		variables[9]=fechaentrega;
		variables[10]=prioridad;
		variables[11]=peso;
		variables[12]=total;
		variables[13]=observaciones;
		variables[14]=mapa;
		variables[15]=detalles;
		agregarFilaTablaConsulta("tablaConsulta",variables);
		//recorrerTablaOrden("tablaSalida","listaSalida"); // Crea la cadena de productos que se enviara a timbrado */
	});
	
	function agregarFilaTablaConsulta(tabla, elementos){
		FILAS=0;
		FILAS=FILAS+1;
        var nuevaFila="<tr>";
		var con=0;
		while (con < elementos.length){
			if (con==0){
				nuevaFila=nuevaFila+"<td style='display:none' class='Ccon'>";
				nuevaFila=nuevaFila+elementos[con];
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==1){ //idcotizacionproducto
				nuevaFila=nuevaFila+"<td style='display:none' class='Cidcotizacionproducto'>";
				nuevaFila=nuevaFila+elementos[con];
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==2){  //columna decorada
				nuevaFila=nuevaFila+"<td class=\"columnaIzquierda\" style=\"background:#649ad0;\">";
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==2){ //idusuario
				nuevaFila=nuevaFila+"<td style='display:none' class='Cidusuario'>";
				nuevaFila=nuevaFila+elementos[con];
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==3){  //idempelado
				nuevaFila=nuevaFila+"<td style='display:none' class='Cidempleado'>";
				nuevaFila=nuevaFila+elementos[con];
				nuevaFila=nuevaFila+"</td>";
			}
			
			if (con==4){ //folio
				nuevaFila=nuevaFila+"<td class='Cfolio'>";
					nuevaFila=nuevaFila+elementos[con]; 
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==5){ //fecha
				nuevaFila=nuevaFila+"<td class='Cfecha'>";
					nuevaFila=nuevaFila+elementos[con]; 
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==6){ //idcliente
				nuevaFila=nuevaFila+"<td class='Cidcliente'>";
					nuevaFila=nuevaFila+elementos[con]; 
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==7){ //domicilioentrega
				nuevaFila=nuevaFila+"<td class='Cdomicilioentrega'>";
					nuevaFila=nuevaFila+elementos[con]; 
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==8){ //coordenadas
					nuevaFila=nuevaFila+"<td class='Celdacoordenadas"+elementos[0]+"'>";
					nuevaFila=nuevaFila+elementos[con]; 
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==9){ //fechaentrega
				nuevaFila=nuevaFila+"<td class='Cfechaentrega'>";
					nuevaFila=nuevaFila+elementos[con]; 
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==10){ //prioridad
				nuevaFila=nuevaFila+"<td class='Cprioridad'>";
					nuevaFila=nuevaFila+elementos[con]; 
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==11){ //peso
				nuevaFila=nuevaFila+"<td class='Cpeso'>";
					nuevaFila=nuevaFila+elementos[con]; 
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==12){ //total
				nuevaFila=nuevaFila+"<td class='Ctotal'>";
					nuevaFila=nuevaFila+elementos[con]; 
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==13){ //observaciones
				nuevaFila=nuevaFila+"<td class='Cobservaciones'>";
					nuevaFila=nuevaFila+elementos[con]; 
				nuevaFila=nuevaFila+"</td>";
				
			}
			if (con==14){ //botonmapa
				nuevaFila=nuevaFila+"<td class='Cmapa'>";
					nuevaFila=nuevaFila+elementos[con]; 
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==15){ //botondetalles
				nuevaFila=nuevaFila+"<td class='Cdetalles'>";
					nuevaFila=nuevaFila+elementos[con]; 
				nuevaFila=nuevaFila+"</td>";
			}
			con=con+1;
		}
		nuevaFila=nuevaFila+"<td title='Agregar a la ruta'><a class='btn btn-success btn-xs agregarFila'><i class='fa fa-arrow-circle-down text-white'></i><a></td>";
		nuevaFila=nuevaFila+"</tr>"
		//$("#"+tabla).append(nuevaFila); Coloca la fila al final de la tabla
		$("#"+tabla).append(nuevaFila); //Coloca la fila al inicio de la tabla
		recorrerTablaOrden("tablaOrden","listaSalida");//que actualice la tabla draggable
		
}
	
	
	$(document).on("click",".agregarFila",function(){
			var parent = $(this).parents().get(1);
			$(parent).remove();
			var con =$(parent).children(".Ccon").html();
			var idcotizacionproducto=$(parent).children(".Cidcotizacionproducto").html();
			var idusuario=$(parent).children(".Cidusuario").html();
			var idempleado=$(parent).children(".Cidempleado").html();
			var folio=$(parent).children(".Cfolio").html();
			var fecha=$(parent).children(".Cfecha").html();
			var idcliente=$(parent).children(".Cidcliente").html();
			var domicilioentrega=$(parent).children(".Cdomicilioentrega").html();
			var coordenadas=$(parent).children(".Celdacoordenadas"+con+"").html();
			var fechaentrega=$(parent).children(".Cfechaentrega").html();
			var prioridad=$(parent).children(".Cprioridad").html();
			var peso=$(parent).children(".Cpeso").html();
			var total=$(parent).children(".Ctotal").html();
			var observaciones=$(parent).children(".Cobservaciones").html();
			var mapa=$(parent).children(".Cmapa").html();
			var detalles=$(parent).children(".Cdetalles").html();
			
			variables=new Array();
			variables[0]=con; //Nueva fila
			variables[1]=idcotizacionproducto;
			variables[2]=idusuario;
			variables[3]=idempleado;
			variables[4]=folio;
			variables[5]=fecha;
			variables[6]=idcliente;
			variables[7]=domicilioentrega;
			variables[8]=coordenadas;
			variables[9]=fechaentrega;
			variables[10]=prioridad;
			variables[11]=peso;
			variables[12]=total;
			variables[13]=observaciones;
			variables[14]=mapa;
			variables[15]=detalles;
			agregarFila("tablaOrden",variables,"listaSalida");
			//recorrerTablaOrden("tablaSalida","listaSalida"); // Crea la cadena de productos que se enviara a timbrado */
	});
	/*Fin de Importante*/
	
});


function agregarFila(tabla, elementos,lista){
		FILAS=0;
		FILAS=FILAS+1;
        var nuevaFila="<tr>";
		var con=0;
		while (con < elementos.length){
			if (con==0){
				nuevaFila=nuevaFila+"<td style='display:none' class='Ccon'>";
				nuevaFila=nuevaFila+elementos[con];//FILAS
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==1){ //idcotizacionproducto
				nuevaFila=nuevaFila+"<td style='display:none' class='Cidcotizacionproducto'>";
				nuevaFila=nuevaFila+elementos[con];
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==2){  //columna decorada
				nuevaFila=nuevaFila+"<td class=\"columnaIzquierda\" style=\"border-left: 10px solid #25c274;\">";
				nuevaFila=nuevaFila+"<i class=\"fa fa-sort\"></i>";
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==2){ //idusuario
				nuevaFila=nuevaFila+"<td style='display:none' class='Cidusuario'>";
				nuevaFila=nuevaFila+elementos[con];
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==3){  //idempelado
				nuevaFila=nuevaFila+"<td style='display:none' class='Cidempleado'>";
				nuevaFila=nuevaFila+elementos[con];
				nuevaFila=nuevaFila+"</td>";
			}
			
			if (con==4){ //folio
				nuevaFila=nuevaFila+"<td class='Cfolio'>";
					nuevaFila=nuevaFila+elementos[con]; 
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==5){ //fecha
				nuevaFila=nuevaFila+"<td class='Cfecha'>";
					nuevaFila=nuevaFila+elementos[con]; 
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==6){ //idcliente
				nuevaFila=nuevaFila+"<td class='Cidcliente'>";
					nuevaFila=nuevaFila+elementos[con]; 
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==7){ //domicilioentrega
				nuevaFila=nuevaFila+"<td class='Cdomicilioentrega'>";
					nuevaFila=nuevaFila+elementos[con]; 
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==8){ //coordenadas
				nuevaFila=nuevaFila+"<td class='Celdacoordenadas"+elementos[0]+"'>";
				nuevaFila=nuevaFila+elementos[con]; 
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==9){ //fechaentrega
				nuevaFila=nuevaFila+"<td class='Cfechaentrega'>";
					nuevaFila=nuevaFila+elementos[con]; 
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==10){ //prioridad
				nuevaFila=nuevaFila+"<td class='Cprioridad'>";
					nuevaFila=nuevaFila+elementos[con]; 
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==11){ //peso
				nuevaFila=nuevaFila+"<td class='Cpeso'>";
					nuevaFila=nuevaFila+elementos[con]; 
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==12){ //total
				nuevaFila=nuevaFila+"<td class='Ctotal'>";
					nuevaFila=nuevaFila+elementos[con]; 
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==13){ //observaciones
				nuevaFila=nuevaFila+"<td class='Cobservaciones'>";
					nuevaFila=nuevaFila+elementos[con]; 
				nuevaFila=nuevaFila+"</td>";
				
				nuevaFila=nuevaFila+"<td>";
				nuevaFila=nuevaFila+"<input type=\"hidden\" id=\"orden"+FILAS+"\" value=\"\" class=\"activeCampos orden\">";
                nuevaFila=nuevaFila+"<small class=\"label\" style=\"background-color:#C00\"><i class=\"fa fa-file-o\"></i> Orden: <span>1</span></small>"; 
				nuevaFila=nuevaFila+"</td>";
				
			}
			if (con==14){ //botonmapa
				nuevaFila=nuevaFila+"<td class='Cmapa'>";
					nuevaFila=nuevaFila+elementos[con]; 
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==15){ //botondetalles
				nuevaFila=nuevaFila+"<td class='Cdetalles'>";
					nuevaFila=nuevaFila+elementos[con]; 
				nuevaFila=nuevaFila+"</td>";
			}
			con=con+1;
		}
		nuevaFila=nuevaFila+"<td title='Quitar de la ruta' class='eliminarFila'><a class='btn btn-danger btn-xs'><i class='fa fa-arrow-circle-up text-white'></i><a></td>";
		nuevaFila=nuevaFila+"</tr>"
		//$("#"+tabla).append(nuevaFila); Coloca la fila al final de la tabla
		$("#"+tabla).append(nuevaFila); //Coloca la fila al inicio de la tabla
		recorrerTablaOrden(tabla,lista);
		
}

function inicializarDrags(){
  $(".connectedSortable .box-header, .connectedSortable .nav-tabs-custom").css("cursor", "move");
  $("#filas").sortable({
	update: function( event, ui ) {recorrerTablaOrden("tablaOrden","listaSalida")}
  });
}


function obtenerListaCoordenadas(tabla){
	//inicializar valores
	var idcotizacionproducto=0;
	$("#listaSalidaCoordenadas").val("");
	var coordenadas=[];
	$('#'+tabla+' tr').each(function () {
		$(this).find('td').each(function (index,valor) {
			var coordenada="";
			if (index==1){
				idcotizacionproducto = $(this).parents("tr").children(".Cidcotizacionproducto").html();
			}
			if (index==9){
				    coordenadaN=$(this).html();
					coordenada=coordenadaN.split(",");
					latitud=parseFloat(coordenada[0]);
					longitud=parseFloat(coordenada[1]);
					$("#listaSalidaCoordenadas").val($("#listaSalidaCoordenadas").val()+idcotizacionproducto+":::"+latitud.toFixed(3)+","+longitud.toFixed(3)+":::");
					coordenadas.push({location:coordenadaN,stopover: true});
			}
		})
	})
	return coordenadas;
}


function recorrerTablaOrden(tabla,lista){
	var con=1;
	var no, numeropagina, antes, despues, idcotizacionproducto, orden;
	var TotalKG=0,TotalDinero=0,CapacidaddeCarga=0,PorcentajeCargado=0;
	var ABECEDARIO = ['B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
	//inicializar valores
	$("#SpanTotalDinero").html(TotalDinero);
	$("#SpanTotalKG").html("Total cargado: "+TotalKG+" KG");
	$("#SpanProgressBar").width("0%");
	document.getElementById("infoBoxCarga").className = "info-box bg-green";
	var cadena;
	cadena="";
	$('#'+tabla+' tr').each(function () {
		$(this).find('input').each(function (index,valor) {
			if (index==0){
					$(this).parent().children(".orden").val(con);
					$(this).parent().children("small").html("<i class='fa fa-file-o'></i> Orden: <span>"+$(this).parent().children(".orden").val()+"-"+ABECEDARIO[con-1]+"</span>");
					TotalDinero=parseFloat(TotalDinero) + parseFloat($(this).parents("tr").children(".Ctotal").html());
					TotalKG=parseFloat(TotalKG)+parseFloat($(this).parents("tr").children(".Cpeso").html());
					//$("#totalDinero").val(TotalDinero);
					$("#SpanTotalDinero").html("$"+(TotalDinero).toFixed(2));
					//$("#totalKG").val(TotalKG);
					//obtener el total en kilos que soporta el vehiculo para sacar el porcentaje de carga de acuerdo a los kg cargados para asignarlo a la barra(width) y para mostrarlo en la descripción del total cargado
					
					CapacidaddeCarga =$("#capacidaddeCarga").val();
					PorcentajeCargado= parseFloat(TotalKG)*parseFloat(100)/parseFloat(CapacidaddeCarga);
					//aginarporcentajecargado a la propiedad weight y mostrarlo en la descripción total cargado
					$("#SpanNombreVehiculo").html($("#nombrevehiculo").val());
					$("#SpanCapacidaddeCarga").html("Capacidad: "+CapacidaddeCarga+" Kg.");
					$("#SpanTotalKG").html("Total cargado: "+TotalKG+" KG, "+Math.round(PorcentajeCargado)+"%");
					idcotizacionproducto=$(this).parents("tr").children(".Cidcotizacionproducto").html();
					//style="width: 0%"
					$("#SpanProgressBar").width(""+PorcentajeCargado+"%");
					//color según porcentaje
					
					if(parseFloat(PorcentajeCargado)>=0 && parseFloat(PorcentajeCargado)<=50){
						document.getElementById("infoBoxCarga").className = "info-box bg-green";
					}
					if(parseFloat(PorcentajeCargado)>50.00001 && parseFloat(PorcentajeCargado)<=75){
						document.getElementById("infoBoxCarga").className = "info-box bg-yellow";
					}
					if(parseFloat(PorcentajeCargado)>=75.00001 && parseFloat(PorcentajeCargado)<=90){
						document.getElementById("infoBoxCarga").className = "info-box bg-orange";
					}
					if(parseFloat(PorcentajeCargado)>90.00001){
						document.getElementById("infoBoxCarga").className = "info-box bg-red";
					}
					
					orden=$(this).parent().children(".orden").val();
					cadena=cadena+idcotizacionproducto+":::"+orden+":::";
					con++;
			}
		})
	})
	$("#"+lista).val(cadena);
}

function validar(){
	var estado=true;
	var mensaje="";
	
	if (estado==false){
		mostrarMensaje(mensaje);
	}
	return estado;
}

function vaciarcampos(){
	obtenerSerie();
	obtenerFolio();
	$("#nombreruta").val("");
	$("#observacionesruta").val("");
	//limpiar tabla draggable
	FILAS = 0;
	$("#filas").html("");
	$("#listaSalida").val("");
	recorrerTablaOrden("tablaOrden","listaSalida");
}

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

function obtenerSerie(){
		$("#cserie").val("Cargando...");
		$("#lserie").html("Cargando...");
		$.ajax({
			url: '../componentes/obtenerSerie.php',
			type: "POST",
			data: "", //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#cserie").val(mensaje);
				$("#lserie").html(mensaje);
			}
		});
		return false;
}

function obtenerFolio(){
		$("#cfolio").val("Cargando...");
		$.ajax({
			url: '../componentes/obtenerFolio.php',
			type: "POST",
			data: "", //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#cfolio").val(mensaje);
				$("#lfolio").html(mensaje);
			}
		});
		return false;
}

function llenarSelectZona(condicion){
		$("#idzona_ajax").html("<option value='1'>cargando...</option>");
		$.ajax({
			url: '../componentes/llenarSelectZona.php',
			type: "POST",
			data: "submit=&condicion="+condicion, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#idzona_ajax").html(mensaje);
			}
		});
		return false;
}

function guardar(variables){
		$("#botonAceptar").hide();
		$("#loading").show();
		$.ajax({
			url: 'guardar.php',
			type: "POST",
			data: "submit=&"+variables, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#botonAceptar").show();
				$("#loading").hide();
				mostrarMensaje(mensaje);
				vaciarcampos();
			}
		});
		return false;
}



function actualizarCoordenadasDomicilio(coordenadas,iddomicilio){
		$.ajax({
			url: 'guardar.php',
			type: "POST",
			data: "submit=&coordenadas="+coordenadas+"&iddomicilio="+iddomicilio,
			success: function(mensaje){
				mostrarMensaje(mensaje);
			}
		});
		return false;
}

function llenarSelectEmpleado(condicion){
		$("#idempleado_ajax").html("<option value='1'>cargando...</option>");
		$.ajax({
			url: '../componentes/llenarSelectEmpleado.php',
			type: "POST",
			data: "submit=&condicion="+condicion, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#idempleado_ajax").html(mensaje);
			}
		});
		return false;
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

function llenarSelectZona(condicion){
		$("#idzona_ajax").html("<option value='1'>cargando...</option>");
		$.ajax({
			url: '../componentes/llenarSelectZona.php',
			type: "POST",
			data: "submit=&condicion="+condicion, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#idzona_ajax").html(mensaje);
			}
		});
		return false;
}

function llenarSelectDomicilio(condicion){
		$("#iddomicilio_ajax").html("<option value='1'>cargando...</option>");
		$.ajax({
			url: '../componentes/llenarSelectDomicilioVista.php',
			type: "POST",
			data: "submit=&condicion="+condicion, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#iddomicilio_ajax").html(mensaje);
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
	//$("#salida").html(mensaje);//PARA REVISAR CONSULTAS SQL 
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