// JS MODULA Autor: Armando Viera Rodriguez 2016
function vaciarCampos(){
		$("#climitecredito").val("");
		$("#cdiascredito").val("");
		$("#cnombrecontacto").val("");
		$("#ccorreocontacto").val("");
		$("#ctelefonocontacto").val("");
	$("#cnombre").focus();
}
$(document).ready(function() {
	
	$("#panel_alertas").hide();
	$(".loading").hide();
	//$("#panel_alertas").delay(8000).hide(600);
	
	
	//AUTOCOMPLETAR
	$( "#autorfc" ).autocomplete({
        source: "../componentes/buscarClienteRFC.php",
		autoFocus:true,
		select:function(event,ui){ 
        	$('#crfc').val(ui.item.id);
			$('#consultarfc').val(ui.item.consulta);
    	},
		search: function (event, ui) {
			$("#crfc").val("");
			$("#consultarfc").val($("#autorfc").val());
		},
		change: function (event, ui) {
			$.ajax({
            	url:'../componentes/ClienteRFC.php',
            	type:'POST',
            	dataType:'json',
				/*En caso de generar una descripció "label" compuesta por dos o mas datos
				en el archivo buscarX.php será necesario cambiar el termino 
				$('#autoX').val() por $('#consultaX').val()*/
            	data:{ termino:$('#autorfc').val()}
        		}).done(function(respuesta){
            		$("#crfc").val(respuesta.id);
        	});
		},
        minLength: 1
    });
	// FIN AUTOCOMPLETAR
	//AUTOCOMPLETAR
	$( "#autonombre" ).autocomplete({
        source: "../componentes/buscarCliente.php",
		autoFocus:true,
		select:function(event,ui){ 
        	$('#cnombre').val(ui.item.id);
			$('#consultanombre').val(ui.item.consulta);
    	},
		search: function (event, ui) {
			$("#cnombre").val("");
			$("#consultanombre").val($("#autonombre").val());
		},
		change: function (event, ui) {
			$.ajax({
            	url:'../componentes/Cliente.php',
            	type:'POST',
            	dataType:'json',
				/*En caso de generar una descripció "label" compuesta por dos o mas datos
				en el archivo buscarX.php será necesario cambiar el termino 
				$('#autoX').val() por $('#consultaX').val()*/
            	data:{ termino:$('#autonombre').val()}
        		}).done(function(respuesta){
            		$("#cnombre").val(respuesta.id);
        	});
		},
        minLength: 1
    });
	// FIN AUTOCOMPLETAR
	//AUTOCOMPLETAR
	$( "#autonic" ).autocomplete({
        source: "../componentes/buscarClienteNIC.php",
		autoFocus:true,
		select:function(event,ui){ 
        	$('#cnic').val(ui.item.id);
			$('#consultanic').val(ui.item.consulta);
    	},
		search: function (event, ui) {
			$("#cnic").val("");
			$("#consultanic").val($("#autonic").val());
		},
		change: function (event, ui) {
			$.ajax({
            	url:'../componentes/ClienteNIC.php',
            	type:'POST',
            	dataType:'json',
				/*En caso de generar una descripció "label" compuesta por dos o mas datos
				en el archivo buscarX.php será necesario cambiar el termino 
				$('#autoX').val() por $('#consultaX').val()*/
            	data:{ termino:$('#autonic').val()}
        		}).done(function(respuesta){
            		$("#cnic").val(respuesta.id);
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
	
	$(".close").click(function(){ 
		$("#panel_alertas").stop(false, true);
		$("#panel_alertas").hide();
 	});
	
	
$("#climitecredito").keypress(function(){
	return checarDecimal(event, this);
});
				$('#cdiascredito').permitirCaracteres('0123456789');
				
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
	location.href='../consultar/vista.php?link=vista&busqueda='+busqueda+'&n1=clientes&n2=consultarclientes';
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
