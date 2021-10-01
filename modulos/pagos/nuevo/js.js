// JS MODULA Autor: Armando Viera Rodriguez 2016
function vaciarCampos(){
	$("#cidreferencia").focus();
}
$(document).ready(function() {
	
	$("#panel_alertas").hide();
	$(".loading").hide();
	$("#loading2").hide();
	//$("#panel_alertas").delay(8000).hide(600);

	load_tablas(idreferencia, tablareferencia);
	$("#cmonto").change(function(){
		if(parseFloat($("#cmonto").val()) >parseFloat($("#cmontovalidar").val())){
			$("#cmonto").val($("#cmontovalidar").val());
		}
	});
	$("#botonGuardar").click(function() {
				if (validar()){
					var variables=$("#formulario").serialize();
					guardar(variables);
				}
	});
	$(".botonSave").click(function() {
				if (validar()){
					var variables=$("#formulario").serialize();
					guardar(variables);
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
	
	
$("#cmonto").keypress(function(){
	return checarDecimal(event, this);
});
				
});

function validar(){
	var estado=true;
	var mensaje="";
	if($("#cidreferencia").val()==""){
		$("#cidreferencia").val(idreferencia);
	}
	if (estado==false){
		mostrarMensaje(mensaje);
	}
	return estado;
}

//**************************AJAX*******************************
// Autor: Armando Viera Rodríguez
// Onixbm 2016

function buscar (busqueda){
	location.href='../consultar/vista.php?link=vista&busqueda='+busqueda+'&n1=pagos&n2=consultarpagos';
}

function obtenerEstadoLiquidacion(idreferencia,tablareferencia){
	
	
}

function eliminarIndividual(id,idreferencia,tablareferencia) {
	$.ajax({
			url: 'obtieneEstadoLiquidacion.php',
			type: "POST",
			data: "submit=&idreferencia="+idreferencia+"&tablareferencia="+tablareferencia, //Pasamos los datos en forma de array
			success: function(mensaje){
				$("#cestadoliquidacion").val(mensaje);
				var encoded = "¿Desea borrar el registro?";
				var decoded = $("<div/>").html(encoded).text();
				var pregunta = confirm(decoded);
				if (pregunta){
					var tipo=$("#ctipo").val();
					var idreferencia=$("#cidreferencia").val();
					var tablareferencia=$("#ctablareferencia").val();
					estadoliquidacion = $("#cestadoliquidacion").val();
					eliminar_individual(id,tipo,idreferencia,tablareferencia,estadoliquidacion);
				}
			}
		});
		return false;
}

function eliminar_individual(id,tipo,idreferencia,tablareferencia,estadoliquidacion){
		$.ajax({
			url: '../eliminar/eliminar.php',
			type: "POST",
			data: "submit=&ids="+id+"&tipo="+tipo+"&idreferencia="+idreferencia+"&tablareferencia="+tablareferencia+"&estadoliquidacion="+estadoliquidacion, //Pasamos los datos en forma de array
			
			success: function(mensaje){
				mostrarMensaje(mensaje,id,"eliminar");
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

function actualizarDatos(){
		var idreferencia=$("#cidreferencia").val();
		var tablareferencia=$("#ctablareferencia").val();
		var idcliente=$("#cidcliente").val();
		$.ajax({
			url: 'actualizardatos.php',
			type: "POST",
			data: "submit=&idreferencia="+idreferencia+"&tablareferencia="+tablareferencia+"&idcliente="+idcliente, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				refrescarDatos(mensaje);
			}
		});
		return false;
}


function load_tablas (idreferencia, tablareferencia){
	//alert (orden);
	//alert (campoOrden);
	//alert (limit);
	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById("muestra_contenido_ajax").innerHTML=xmlhttp.responseText;
			$("#loading2").hide();
		}
		else{
			//$("#loading2").show();
		}
	}
	
	xmlhttp.open("POST","consultar.php?idreferencia="+idreferencia+"&tablareferencia="+tablareferencia, true);
	xmlhttp.send();
}


function mostrarMensaje(mensaje){
	//alert(mensaje);
	//$("#mensaje").html(mensaje);
	var cadena= $.trim(mensaje); //Limpia la cadena regresada desde php
	var res=cadena.split("@"); //Separa la cadena en cada @ y convierte las partes en un array
	if (res[0]=="exito"){ //Si la primer frase contiene la palabra "exito"
		$("#panel_alertas").removeClass().addClass("alert alert-success alert-dismissable");
		$("#notificacionTitulo").html("<i class='icon fa fa-check'></i>"+res[1]);
		$("#notificacionContenido").html(res[2]);
		load_tablas (idreferencia, tablareferencia);
		actualizarDatos();
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

function refrescarDatos(mensaje){
	var cadena= $.trim(mensaje); 
	var res=cadena.split("@");
	$("#deudageneral").html("$ "+res[0]);
	$("#totalpagado").html("$ "+res[1]);
	$("#diferencia").html("$ "+res[2]);
}
