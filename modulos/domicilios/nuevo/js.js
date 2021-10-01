// JS MODULA Autor: Armando Viera Rodriguez 2019
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
	var calle=$("#autocalle").val(), numero=$("#autonoexterior").val(), codigopostal=$("#ccp").val(), ciudad=$("#autociudad").val(), estado=$("#estado_ajax").val();
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

// Carga de la libreria de google maps



function vaciarCampos(){
		$("#cnointerior").val("");
		$("#ccp").val("");
		$("#creferencia").val("");
		$("#cobservaciones").val("");
		$("#ccontactoservicio").val("");
		$("#cemailservicio").val("");
		$("#ctelefonoservicio").val("");
		$("#ccontactocobranza").val("");
		$("#cemailcobranza").val("");
		$("#ctelefonocobranza").val("");
		$("#ccontactofacturacion").val("");
		$("#cemailfacturacion").val("");
		$("#ctelefonofacturacion").val("");
	$("#cidcliente").focus();
}

function abrirModal(id){
	$("#modal").modal();
	if (vecesMap==false){
		var longitud=19.40503465287001;
		var latitud=-102.04849538421627;
		setMapa(longitud,latitud);
		vecesMap=true;
	}
}


$(document).ready(function() {

	$(".campo_contactos").hide();
	$("#panel_alertas").hide();
	$(".loading").hide();

	llenarChecksContactos("");

	$("#autoidcliente").change(function(){
		$(".campo_contactos").hide();
		console.log($("#autoidcliente").val());
		if($("#autoidcliente").val() == ""){
			$(".campo_contactos").hide();
		} else{
			$(".campo_contactos").show();
			llenarChecksContactos($("#autoidcliente").val());
		}
	});
	
	//$("#panel_alertas").delay(8000).hide(600);
	
	$("#autoidcliente").focus();
	
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
	
	//BLUR
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
	//AUTOCOMPLETAR
	$( "#autocalle" ).autocomplete({
        source: "../componentes/buscarCalle.php",
		autoFocus:true,
		select:function(event,ui){ 
        	$('#ccalle').val(ui.item.id);
			$('#consultacalle').val(ui.item.consulta);
    	},
		search: function (event, ui) {
			$("#ccalle").val("");
			$("#consultacalle").val($("#autocalle").val());
		},
		change: function (event, ui) {
			$.ajax({
            	url:'../componentes/Calle.php',
            	type:'POST',
            	dataType:'json',
				/*En caso de generar una descripció "label" compuesta por dos o mas datos
				en el archivo buscarX.php será necesario cambiar el termino 
				$('#autoX').val() por $('#consultaX').val()*/
            	data:{ termino:$('#autocalle').val()}
        		}).done(function(respuesta){
            		$("#ccalle").val(respuesta.id);
        	});
		},
		create: function (event,ui){
               $(this).data('ui-autocomplete')._renderItem = function (ul, item) {
                return $('<li>')
                    .append('<a>' + item.consulta  + '</a>')
                    .appendTo(ul);
			   }
        },
        minLength: 1
    })
	
	// FIN AUTOCOMPLETAR
	//AUTOCOMPLETAR
	$( "#autonoexterior" ).autocomplete({
        source: "../componentes/buscarNoexterior.php",
		autoFocus:true,
		select:function(event,ui){ 
        	$('#cnoexterior').val(ui.item.id);
			$('#consultanoexterior').val(ui.item.consulta);
    	},
		search: function (event, ui) {
			$("#cnoexterior").val("");
			$("#consultanoexterior").val($("#autonoexterior").val());
		},
		change: function (event, ui) {
			$.ajax({
            	url:'../componentes/Noexterior.php',
            	type:'POST',
            	dataType:'json',
				/*En caso de generar una descripció "label" compuesta por dos o mas datos
				en el archivo buscarX.php será necesario cambiar el termino 
				$('#autoX').val() por $('#consultaX').val()*/
            	data:{ termino:$('#autonoexterior').val()}
        		}).done(function(respuesta){
            		$("#cnoexterior").val(respuesta.id);
        	});
		},
        minLength: 1
    });
	// FIN AUTOCOMPLETAR
	//AUTOCOMPLETAR
	$( "#autonombrecomercial" ).autocomplete({
        source: "../componentes/buscarNombrecomercial.php",
		autoFocus:true,
		select:function(event,ui){ 
        	$('#cnombrecomercial').val(ui.item.id);
			$('#consultanombrecomercial').val(ui.item.consulta);
    	},
		search: function (event, ui) {
			$("#cnombrecomercial").val("");
			$("#consultanombrecomercial").val($("#autonombrecomercial").val());
		},
		change: function (event, ui) {
			$.ajax({
            	url:'../componentes/Nombrecomercial.php',
            	type:'POST',
            	dataType:'json',
				/*En caso de generar una descripció "label" compuesta por dos o mas datos
				en el archivo buscarX.php será necesario cambiar el termino 
				$('#autoX').val() por $('#consultaX').val()*/
            	data:{ termino:$('#autonombrecomercial').val()}
        		}).done(function(respuesta){
            		$("#cnombrecomercial").val(respuesta.id);
        	});
		},
        minLength: 1
    });
	// FIN AUTOCOMPLETAR
	//AUTOCOMPLETAR
	$( "#autocolonia" ).autocomplete({
        source: "../componentes/buscarColonia.php",
		autoFocus:true,
		select:function(event,ui){ 
        	$('#ccolonia').val(ui.item.id);
			$('#consultacolonia').val(ui.item.consulta);
    	},
		search: function (event, ui) {
			$("#ccolonia").val("");
			$("#consultacolonia").val($("#autocolonia").val());
		},
		change: function (event, ui) {
			$.ajax({
            	url:'../componentes/Colonia.php',
            	type:'POST',
            	dataType:'json',
				/*En caso de generar una descripció "label" compuesta por dos o mas datos
				en el archivo buscarX.php será necesario cambiar el termino 
				$('#autoX').val() por $('#consultaX').val()*/
            	data:{ termino:$('#autocolonia').val()}
        		}).done(function(respuesta){
            		$("#ccolonia").val(respuesta.id);
        	});
		},
        minLength: 1
    });
	// FIN AUTOCOMPLETAR
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
	llenarSelectEstado("");
	llenarSelectZona("");
	llenarSelectSucursal("");
	llenarSelectGirocomercial("");
	llenarSelectEmpleado("");
	
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
	
	
	$("#autociudad").blur(function(){
		verificarCampo("ciudades","nombre",$(this).val(),"ciudades","&idestado=0");
 	});
	
	$('#ccp').permitirCaracteres('0123456789');
				
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
	location.href='../consultar/vista.php?link=vista&busqueda='+busqueda+'&n1=domicilios&n2=consultardomicilios';
}

function llenarSelectEstado(condicion){
		$("#estado_ajax").html("<option value='1'>cargando...</option>");
		$.ajax({
			url: '../componentes/llenarSelectEstado.php',
			type: "POST",
			data: "submit=&condicion="+condicion, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#estado_ajax").html(mensaje);
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
function llenarSelectGirocomercial(condicion){
		$("#idgirocomercial_ajax").html("<option value='1'>cargando...</option>");
		$.ajax({
			url: '../componentes/llenarSelectGirocomercial.php',
			type: "POST",
			data: "submit=&condicion="+condicion, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#idgirocomercial_ajax").html(mensaje);
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
function guardar(variables){
		$("#botonGuardar").hide();
		$("#botonSave").hide();
		$("#loading").show();
		$.ajax({
			url: 'guardar.php',
			type: "POST",
			data: "submit=&"+variables, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#botonGuardar").show();
				$("#botonSave").show();
				$("#loading").hide();
				mostrarMensaje(mensaje);
			}
		});
		return false;
}

function llenarChecksContactos(condicion){
		var idcliente=$("#cidcliente").val();
		$("#servicios_ajax").html("Cargando contactos...");
		$.ajax({
			url: '../componentes/llenarChecksContactos.php',
			type: "POST",
			data: "submit=&idcliente="+idcliente, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#contactos_ajax").html(mensaje);
			}
		});
		return false;
}


function verificarCampo(tabla,campo,valor,directorioClase,otrosCamposGuardado){
	if ($.trim(valor)){
		$.ajax({
			url: '../componentes/verificarCampo.php',
			type: "POST",
			data: "submit=&tabla="+tabla+"&campo="+campo+"&valor="+valor, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			
			success: function(mensaje){
				if(mensaje=="noexiste"){
					var encoded = "¿Desea restaurar el registro?";
					var decoded = $("<div/>").html(encoded).text();
					var pregunta = confirm("El registro "+ valor +" no existe en la base de datos ¿Desea darlo de alta?");
					if (pregunta){
						$.ajax({
							url: '../../'+directorioClase+'/nuevo/guardar.php',
							type: "POST",
							data:  "submit=&"+campo+"="+valor+otrosCamposGuardado, //Pasamos los datos en forma de array seralizado desde la funcion de envio
							success: function(mensaje){
								//mostrarMensaje(mensaje);
							}
						});
					}
				} // Fin si no existe el registro en la base de datos
			} //Fin de success
		});
	}
}



function mostrarMensaje(mensaje){
	//alert(mensaje);
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
