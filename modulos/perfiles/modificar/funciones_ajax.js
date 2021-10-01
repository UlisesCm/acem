// Autor: Armando Viera Rodríguez
// Onixbm 2014

function buscar (busqueda){
	location.href='../consultar/vista.php?link=vista&busqueda='+busqueda;
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




function mostrarMensaje(mensaje){
	//alert(mensaje);
	var cadena= $.trim(mensaje); //Limpia la cadena regresada desde php
	var res=cadena.split("@"); //Separa la cadena en cada @ y convierte las partes en un array
	if (res[0]=="exito"){ //Si la primer frase contiene la palabra "exito"
		$("#panel_alertas").removeClass().addClass("avisoBien");
		$("#imagenNotificacion").removeClass().addClass("notificacionBien");
		$("#notificacionTitulo").html(res[1]);
		$("#notificacionContenido").html(res[2]);
	}else if (res[0]=="fracaso"){
		$("#panel_alertas").removeClass().addClass("avisoMal");
		$("#imagenNotificacion").removeClass().addClass("notificacionMal");
		$("#notificacionTitulo").html(res[1]);
		$("#notificacionContenido").html(res[2]);
	}else if (res[0]=="aviso"){
		$("#panel_alertas").removeClass().addClass("avisoAviso");
		$("#imagenNotificacion").removeClass().addClass("notificacionAviso");
		$("#notificacionTitulo").html(res[1]);
		$("#notificacionContenido").html(res[2]);
	}else{
		$("#panel_alertas").removeClass().addClass("avisoMal");
		$("#imagenNotificacion").removeClass().addClass("notificacionMal");
		$("#notificacionTitulo").html("Operaci&oacute;n fallida");
		$("#notificacionContenido").html("No se han resivido datos de respuesta desde el servidor [003]");
	}
	$("#panel_alertas").stop(false, true);
	$("#panel_alertas").fadeIn("slow");
	$("#panel_alertas").delay(5000).fadeOut("slow");
}