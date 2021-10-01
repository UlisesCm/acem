// JS MODULA Autor: Armando Viera Rodriguez 2016
function vaciarCampos(){
	$("#cfecha").focus();
}

function permitirDecimal(id) {
	campo=$("#"+id).val();
	campo=decimalValido(campo);
	$("#"+id).val(campo);
}

function activarValidacion(id){
	$("#"+id).permitirCaracteres('0123456789.');
	campo=$("#"+id).val();
	if (campo=="0.00"){
		$("#"+id).val("");
	}
}

function actualizarDato(componente,id,iddetalleauditoria){
		var valor=$.trim($("#"+componente).val());
		if (valor=="" || valor=="."){
			valor=0;
			$("#"+componente).val(0);
			
		}else{
			valor = parseFloat(valor);
		}
		$("#"+componente).css("color","#FC0");
		
		
		var existencia=parseFloat($("#existencia"+id).html());
		var diferencia=existencia-valor;
		var color="#096";
		if (diferencia > 0){
			color="#C33";
		}
		if (diferencia < 0){
			color="#FC0";
		}
		
		$.ajax({
			url: '../componentes/guardarDetalle.php',
			type: "POST",
			data: "submit=&conteo="+valor+"&iddetalleauditoria="+iddetalleauditoria, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#"+componente).css("color","#096");
				$("#diferencia"+id).html(diferencia);
				$("#diferencia"+id).css("color",color);
				//mostrarMensaje(mensaje);
			}
		});
		return false;
}

$(document).ready(function() {
	
	$("#panel_alertas").hide();
	$(".loading").hide();
	cargarDetalles(idauditoria);
	//$("#panel_alertas").delay(8000).hide(600);
	
	
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
	$("#botonAjustar").click(function() {
		ajustarInventario();
	});
	
	
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
	location.href='../consultar/vista.php?link=vista&busqueda='+busqueda+'&n1=auditorias&n2=consultarauditorias';
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

function cargarDetalles(idauditoria){
		$("#botonGuardar").hide();
		//$(".botonSave").hide();
		$("#loading").show();
		$("#botonAjustar").hide();
		$.ajax({
			url: '../componentes/consultardetalles.php',
			type: "POST",
			data: "submit=&idauditoria="+idauditoria, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				//$("#botonGuardar").show();
				//$("#botonSave").show();
				$("#botonAjustar").show();
				$("#loading").hide();
				//mostrarMensaje(mensaje);
				$("#filas").html(mensaje);
			}
		});
		return false;
}

function ajustarInventario(idauditoria){
		var idauditoria=$("#cidauditoria").val();
		$("#botonGuardar").hide();
		$(".botonSave").hide();
		$("#loading").show();
		$("#botonAjustar").hide();
		$.ajax({
			url: '../componentes/ajustarInventario.php',
			type: "POST",
			data: "submit=&idauditoria="+idauditoria, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				//$("#botonGuardar").show();
				//$("#botonSave").show();
				$("#botonAjustar").show();
				$("#loading").hide();
				mostrarMensaje(mensaje);
				cargarDetalles(idauditoria);
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