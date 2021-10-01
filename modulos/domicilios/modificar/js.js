// JS MODULA Autor: Armando Viera Rodriguez 2016
function vaciarCampos(){
	$("#cidcliente").focus();
}

$(document).ready(function() {
	
	$("#panel_alertas").hide();
	$(".loading").hide();
	
	llenarChecksContactos("");
	//$("#panel_alertas").delay(8000).hide(600);
	
	llenarSelectEstado(estadoSeleccionado,"");
	llenarSelectZona(idzonaSeleccionado,"");
	llenarSelectSucursal(idsucursalSeleccionado,"");
	llenarSelectGirocomercial(idgirocomercialSeleccionado,"");
	llenarSelectEmpleado(idempleadoSeleccionado,"");
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
        minLength: 1
    });
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
	
	$('#ccp').permitirCaracteres('0123456789');
				$('#ccp').permitirCaracteres('0123456789');
				
});

function validar(){
	var estado=true;
	var mensaje="";
	
	if (estado==false){
		mostrarMensaje(mensaje);
	}
	return estado;
}// Autor: Armando Viera Rodríguez
// Onixbm 2016

function buscar (busqueda){
	location.href='../consultar/vista.php?link=vista&busqueda='+busqueda+'&n1=domicilios&n2=consultardomicilios';
}

function llenarSelectEstado(seleccionado,condicion){
		$("#estado_ajax").html("<option value='1'>cargando...</option>");
		$.ajax({
			url: '../componentes/llenarSelectEstado.php',
			type: "POST",
			data: "submit=&condicion="+condicion+"&seleccionado="+seleccionado, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#estado_ajax").html(mensaje);
			}
		});
		return false;
}
function llenarSelectZona(seleccionado,condicion){
		$("#idzona_ajax").html("<option value='1'>cargando...</option>");
		$.ajax({
			url: '../componentes/llenarSelectZona.php',
			type: "POST",
			data: "submit=&condicion="+condicion+"&seleccionado="+seleccionado, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#idzona_ajax").html(mensaje);
			}
		});
		return false;
}
function llenarSelectSucursal(seleccionado,condicion){
		$("#idsucursal_ajax").html("<option value='1'>cargando...</option>");
		$.ajax({
			url: '../componentes/llenarSelectSucursal.php',
			type: "POST",
			data: "submit=&condicion="+condicion+"&seleccionado="+seleccionado, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#idsucursal_ajax").html(mensaje);
			}
		});
		return false;
}
function llenarSelectGirocomercial(seleccionado,condicion){
		$("#idgirocomercial_ajax").html("<option value='1'>cargando...</option>");
		$.ajax({
			url: '../componentes/llenarSelectGirocomercial.php',
			type: "POST",
			data: "submit=&condicion="+condicion+"&seleccionado="+seleccionado, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#idgirocomercial_ajax").html(mensaje);
			}
		});
		return false;
}
function llenarSelectEmpleado(seleccionado,condicion){
		$("#idempleado_ajax").html("<option value='1'>cargando...</option>");
		$.ajax({
			url: '../componentes/llenarSelectEmpleado.php',
			type: "POST",
			data: "submit=&condicion="+condicion+"&seleccionado="+seleccionado, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#idempleado_ajax").html(mensaje);
			}
		});
		return false;
}
function guardar(variables){
		$("#botonGuardar").hide();
		$(".loading").show();
		$.ajax({
			url: 'guardar.php',
			type: "POST",
			data: "submit=&"+variables, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#botonGuardar").show();
				$(".loading").hide();
				mostrarMensaje(mensaje);
			}
		});
		return false;
}

function llenarChecksContactos(condicion){
		var idcliente=$("#cidcliente").val();
		var iddomicilio=$("#ciddomicilio").val();
		$("#servicios_ajax").html("Cargando contactos...");
		$.ajax({
			url: '../componentes/llenarChecksContactos.php',
			type: "POST",
			data: "submit=&idcliente="+idcliente+"&iddomicilio="+iddomicilio, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#contactos_ajax").html(mensaje);
			}
		});
		return false;
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