// JS MODULA Autor: Armando Viera Rodriguez 2016
function vaciarCampos(){
	$("#cnombre").focus();
}

function fileinput(nombre){
	$('#c'+nombre).val($('#c'+nombre+'I').val());
}
$(document).ready(function() {
	
	$("#panel_alertas").hide();
	$(".loading").hide();
	$(".botonSave").hide();
	//$("#panel_alertas").delay(8000).hide(600);
	
	llenarSelectPerfil(idperfilSeleccionado,"");
	
	$("#botonGuardar1").click(function() {
			if (Spry.Widget.Form.validate(formulario1)){
				if (validar1()){
					var variables=$("#formulario1").serialize();
					guardar1(variables);
				}
			}
	});
	
	$("#botonGuardar2").click(function() {
			if (Spry.Widget.Form.validate(formulario2)){
				if (validar2()){
					var variables=$("#formulario2").serialize();
					guardar2(variables);
				}
			}
	});
	
	
	$(".botonSave").click(function() {
		if ($("panel1").is(":visible")){
		}
			if (Spry.Widget.Form.validate(formulario1)){
				if (validar1()){
					var variables=$("#formulario1").serialize();
					guardar1(variables);
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
	
	
});

function validar1(){
	var estado=true;
	var mensaje="";
	
	if (estado==false){
		mostrarMensaje(mensaje);
	}
	return estado;
}

function validar2(){
	var estado=true;
	var mensaje="";
	if($("#ccontrasena2").val()!=$("#ccontrasena3").val()){
		estado=false;
		mensaje="aviso@Error de coincidencia@Las contraseñas no coinciden. Verifique que la nueva contraseña se repita correctamente.";
	}
	if (estado==false){
		mostrarMensaje(mensaje);
	}
	return estado;
}


// Autor: Armando Viera Rodríguez
// Onixbm 2016

function buscar (busqueda){
	location.href='../consultar/vista.php?link=vista&busqueda='+busqueda+'&n1=usuarios&n2=consultarusuarios';
}

function llenarSelectPerfil(seleccionado,condicion){
		$("#idperfil_ajax").html("<option value='1'>cargando...</option>");
		$.ajax({
			url: '../componentes/llenarSelectPerfil.php',
			type: "POST",
			data: "submit=&condicion="+condicion+"&seleccionado="+seleccionado, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#idperfil_ajax").html(mensaje);
			}
		});
		return false;
}
function guardar1(variables){
		var formData = new FormData($("#formulario1")[0]);
		$("#botonGuardar1").hide();
		$(".loading").show();
		$.ajax({
			url: 'guardar1.php',
			type: "POST",
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			success: function(mensaje){
				$("#botonGuardar1").show();
				$(".loading").hide();
				mostrarMensaje(mensaje);
			}
		});
		return false;
}

function guardar2(variables){
		var formData = new FormData($("#formulario2")[0]);
		$("#botonGuardar2").hide();
		$(".loading").show();
		$.ajax({
			url: 'guardar2.php',
			type: "POST",
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			success: function(mensaje){
				$("#botonGuardar2").show();
				$(".loading").hide();
				mostrarMensaje(mensaje);
			}
		});
		return false;
}






function mostrarPanel1(){
	$("#panel2").hide();
	$("#panel1").fadeIn(500);
	$("#cnombre").select();
	$("#cnombre").focus();
	
}
function mostrarPanel2(){
	$("#panel1").hide();
	$("#panel2").fadeIn(500);
	$("#ccontrasena").focus();
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