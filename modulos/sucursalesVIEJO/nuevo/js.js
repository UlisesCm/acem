// JS MODULA Autor: Armando Viera Rodriguez 2016


var vecesMap=false;


var marker;          //variable del marcador
//Funcion principal
initMap = function () 
{
	//usamos la API para geolocalizar el usuario
    var longitud=19.40503465287001;
	var latitud=-102.04849538421627;
	setMapa(longitud,latitud);  //pasamos las coordenadas al metodo para crear el mapa
	document.getElementById("ccoordenadas").value =longitud+","+latitud;	
}

function setMapa (longitud,latitud){  
	var geocoder = new google.maps.Geocoder();
	var map = new google.maps.Map(document.getElementById('map'),{
        zoom: 16,
        center:new google.maps.LatLng(longitud,latitud),
	});
	var calle=$("#ccalle").val(), numero=$("#cnumero").val(), codigopostal=$("#ccp").val(), ciudad=$("#autociudad").val(), estado=$("#autoestado").val();
	var direccion=ciudad+", "+estado+", "+calle+" "+numero+", "+codigopostal
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

function abrirModalDomicilio(id){
	$("#modal").modal();
	if (vecesMap==false){
		var longitud=19.40503465287001;
		var latitud=-102.04849538421627;
		setMapa(longitud,latitud);
		vecesMap=true;
	}
}


function vaciarCampos(){
		$("#cnombre").val("");
		$("#ccalle").val("");
		$("#cnumero").val("");
		$("#ccolonia").val("");
		$("#ccp").val("");
		$("#ctelefonocontacto").val("");
		$("#cserie").val("");
		$("#cfolio").val("");
	$("#cnombre").focus();
}
function fileinput(nombre){
	$('#n'+nombre).val($('#c'+nombre).val());
}
$(document).ready(function() {
	
	$("#panel_alertas").hide();
	$(".loading").hide();
	//$("#panel_alertas").delay(8000).hide(600);
	
	
	//AUTOCOMPLETAR
	$( "#autociudad" ).autocomplete({
        source: "../componentes/buscarCiudad.php",
		autoFocus:true,
		select:function(event,ui){ 
        	$('#cciudad').val(ui.item.id);
			$('#consultaciudad').val(ui.item.consulta);
    	},
		search: function (event, ui) {
			$("#cciudad").val("");
			$("#consultaciudad").val($("#autociudad").val());
		},
		change: function (event, ui) {
			$.ajax({
            	url:'../componentes/Ciudad.php',
            	type:'POST',
            	dataType:'json',
				/*En caso de generar una descripció "label" compuesta por dos o mas datos
				en el archivo buscarX.php será necesario cambiar el termino 
				$('#autoX').val() por $('#consultaX').val()*/
            	data:{ termino:$('#autociudad').val()}
        		}).done(function(respuesta){
            		$("#cciudad").val(respuesta.id);
        	});
		},
        minLength: 1
    });
	// FIN AUTOCOMPLETAR
	//AUTOCOMPLETAR
	$( "#autoestado" ).autocomplete({
        source: "../componentes/buscarEstado.php",
		autoFocus:true,
		select:function(event,ui){ 
        	$('#cestado').val(ui.item.id);
			$('#consultaestado').val(ui.item.consulta);
    	},
		search: function (event, ui) {
			$("#cestado").val("");
			$("#consultaestado").val($("#autoestado").val());
		},
		change: function (event, ui) {
			$.ajax({
            	url:'../componentes/Estado.php',
            	type:'POST',
            	dataType:'json',
				/*En caso de generar una descripció "label" compuesta por dos o mas datos
				en el archivo buscarX.php será necesario cambiar el termino 
				$('#autoX').val() por $('#consultaX').val()*/
            	data:{ termino:$('#autoestado').val()}
        		}).done(function(respuesta){
            		$("#cestado").val(respuesta.id);
        	});
		},
        minLength: 1
    });
	// FIN AUTOCOMPLETAR
	llenarSelectCuentacorreo("");
	
	$("#botonGuardar").click(function() {
			if (Spry.Widget.Form.validate(formulario)){
				if (validar()){
					var variables=$("#formulario").serialize();
					guardar(variables);
				}
			}
	});
	$(".botonSave").click(function() {
			if (Spry.Widget.Form.validate(formulario)){
				if (validar()){
					var variables=$("#formulario").serialize();
					guardar(variables);
				}
			}
	});	
	$(".botonBuscar").click(function() {
		var busqueda=$.trim( $("#cajaBuscar").val());
		//if(busqueda!=""){
        	buscar(busqueda);
		//}
	});
	
	 $("#cajaBuscar").keypress(function(event){  
       var keycode = (event.keyCode ? event.keyCode : event.which); 
      if(keycode == '13'){  
           var busqueda=$.trim( $("#cajaBuscar").val());
			//if(busqueda!=""){
        		buscar(busqueda);
			//}  
      }     
 	}); 
	
	$(".botonNormal").click(function(){ 
		$("#panel_alertas").stop(false, true);
 	});
	
	$(".close").click(function(){ 
		$("#panel_alertas").stop(false, true);
		$("#panel_alertas").hide();
 	});
	
	$('#ccp').permitirCaracteres('0123456789');
				$('#cfolio').permitirCaracteres('0123456789');
				
});

function validar(){
	var estado=true;
	var mensaje="";
	
	if (estado==false){
		mostrarMensaje(mensaje);
	}
	return estado;
}

//**************************AJAX*******************************
// Autor: Armando Viera Rodríguez
// Onixbm 2016

function buscar (busqueda){
	location.href='../consultar/vista.php?link=vista&busqueda='+busqueda+'&n1=sucursales&n2=consultarsucursales';
}

function llenarSelectCuentacorreo(condicion){
		$("#idcuentacorreo_ajax").html("<option value='1'>cargando...</option>");
		$.ajax({
			url: '../componentes/llenarSelectCuentacorreo.php',
			type: "POST",
			data: "submit=&condicion="+condicion, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#idcuentacorreo_ajax").html(mensaje);
			}
		});
		return false;
}
function guardar(variables){
		var formData = new FormData($("#formulario")[0]);
		$("#botonGuardar").hide();
		$("#botonSave").hide();
		$("#loading").show();
		$.ajax({
			url: 'guardar.php',
			type: "POST",
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			success: function(mensaje){
				$("#botonGuardar").show();
				$("#botonSave").show();
				$("#loading").hide();
				mostrarMensaje(mensaje);
			}
		});
		return false;
}

function mostrarMensaje(mensaje){
	//alert(mensaje);
	$("#salida").html(mensaje);
	var cadena= $.trim(mensaje); //Limpia la cadena regresada desde php
	var res=cadena.split("@"); //Separa la cadena en cada @ y convierte las partes en un array
	if (res[0]=="exito"){ //Si la primer frase contiene la palabra "exito"
		$("#panel_alertas").removeClass().addClass("alert alert-success alert-dismissable");
		$("#notificacionTitulo").html("<i class='icon fa fa-check'></i>"+res[1]);
		$("#notificacionContenido").html(res[2]);
		vaciarCampos();
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
		$("#notificacionContenido").html("<i class='icon fa fa-ban'></i> No se han resivido datos de respuesta desde el servidor [003]");
	}
	$("#panel_alertas").stop(false, true);
	$("#panel_alertas").fadeIn("slow");
	var $contenedor=$("body");
	$("html,body").animate({scrollTop:0},1000);
	$("#panel_alertas").delay(6000).fadeOut("slow");
}
