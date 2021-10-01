// JS MODULA Autor: Armando Viera Rodriguez 2016
function vaciarCampos(){
	$("#cfotoI").val("");
	$("#cfoto").val("");
	$("#cnombre").val("");
	$("#cemail").val("");
	$("#cusuario").val("");
	$("#ccontrasena").val("");
	$("#cnombre").focus();
}

function fileinput(nombre){
	$('#c'+nombre).val($('#c'+nombre+'I').val());
}
$(document).ready(function() {



		$(".tipo").click(function(evento){
			var valor = $(this).val();
			if(valor == 'Tecnico'){
				$("#Tecnico").css("display", "block");
				$("#Empleado").css("display", "none");
				$("#Cliente").css("display", "none");
	LimpiarCampos();
			}

	if (valor == 'Empleado') {
		$("#Tecnico").css("display", "none");
		$("#Empleado").css("display", "block");
		$("#Cliente").css("display", "none");
	LimpiarCampos();
	}

	if (valor == 'Cliente') {
		$("#Tecnico").css("display", "none");
		$("#Empleado").css("display", "none");
			$("#Cliente").css("display", "block");
	LimpiarCampos();
	}



	});

	$("#panel_alertas").hide();
	$(".loading").hide();
	//$("#panel_alertas").delay(8000).hide(600);


Autollenadocamporelacionempleados(idregistrorelacionado,tablarelacionada);

	//AUTOCOMPLETAR CLIENTE
	$( "#autoidcliente" ).autocomplete({
				source: "../componentes/buscarCliente.php",
		autoFocus:true,
		select:function(event,ui){
					$('#cidcliente').val(ui.item.id);
			$('#consultaidcliente').val(ui.item.consulta);
		//	alert(ui.item.id);

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
	// FIN AUTOCOMPLETAR CLIENTE

	//AUTOCOMPLETAR CLIENTE
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
	//fin funciones miguel filtro CLIENTE


	//AUTOCOMPLETAR EMPLEADO
	$( "#autoidempleado" ).autocomplete({
				source: "../componentes/buscarEmpleado.php",
		autoFocus:true,
		select:function(event,ui){
					$('#cidempleado').val(ui.item.id);
			$('#consultaidempleado').val(ui.item.consulta);
		//	alert(ui.item.id);

			},
		search: function (event, ui) {
			$("#cidempleado").val("");
			$("#consultaidempleado").val($("#autoidempleado").val());

		},

		change: function (event, ui) {
			$.ajax({
							url:'../componentes/Empleado.php',
							type:'POST',
							dataType:'json',
				/*En caso de generar una descripció "label" compuesta por dos o mas datos
				en el archivo buscarX.php será necesario cambiar el termino
				$('#autoX').val() por $('#consultaX').val()*/
							data:{ termino:$('#autoidempleado').val()}
						}).done(function(respuesta){
								$("#cidempleado").val(respuesta.id);

					});
		},
				minLength: 1
		});
	// FIN AUTOCOMPLETAR EMPLEADO

	//AUTOCOMPLETAR EMPLEADO
	$("#autoidempleado").blur(function(){
		if($("#autoidempleado").val()==""){
			$("#cidempleado").val("");
		}
		if ($("#cidempleado").val()==""){
			$("#consultaidempleado").html("");
			$.ajax({
					url:'../componentes/Empleado.php',
					type:'POST',
					dataType:'json',
					/*En caso de generar una descripció "label" compuesta por dos o mas datos
					en el archivo buscarX.php será necesario cambiar el termino
					$('#autoX').val() por $('#consultaX').val()*/
					data:{ termino:$('#autoidempleado').val()}
					}).done(function(respuesta){
						$('#cidempleado').val(respuesta.id);
									$('#consultaidempleado').val(respuesta.id);

				});
		}
	});
	//fin funciones miguel filtro empleado



	//AUTOCOMPLETAR tecnicos
	$( "#autoidtecnico" ).autocomplete({
				source: "../componentes/buscarTecnico.php",
		autoFocus:true,
		select:function(event,ui){
					$('#cidtecnico').val(ui.item.id);
			$('#consultaidtecnico').val(ui.item.consulta);
			//alert(ui.item.id);

			},
		search: function (event, ui) {
			$("#cidtecnico").val("");
			$("#consultaidtecnico").val($("#autoidtecnico").val());

		},

		change: function (event, ui) {
			$.ajax({
							url:'../componentes/Tecnico.php',
							type:'POST',
							dataType:'json',
				/*En caso de generar una descripció "label" compuesta por dos o mas datos
				en el archivo buscarX.php será necesario cambiar el termino
				$('#autoX').val() por $('#consultaX').val()*/
							data:{ termino:$('#autoidtecnico').val()}
						}).done(function(respuesta){
								$("#cidtecnico").val(respuesta.id);

					});
		},
				minLength: 1
		});
	// FIN AUTOCOMPLETAR

	//AUTOCOMPLETAR
	$("#autoidtecnico").blur(function(){
		if($("#autoidtecnico").val()==""){
			$("#cidtecnico").val("");
		}
		if ($("#cidtecnico").val()==""){
			$("#consultaidtecnico").html("");
			$.ajax({
					url:'../componentes/Tecnico.php',
					type:'POST',
					dataType:'json',
					/*En caso de generar una descripció "label" compuesta por dos o mas datos
					en el archivo buscarX.php será necesario cambiar el termino
					$('#autoX').val() por $('#consultaX').val()*/
					data:{ termino:$('#autoidtecnico').val()}
					}).done(function(respuesta){
						$('#cidtecnico').val(respuesta.id);
									$('#consultaidtecnico').val(respuesta.id);

				});
		}
	});
	//fin funciones miguel filtro


	llenarSelectSucursal(idsucursalSeleccionado,idsucursalSeleccionado);
	llenarSelectPerfil(idperfilSeleccionado,idperfilSeleccionado);

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
	location.href='../consultar/vista.php?link=vista&busqueda='+busqueda+'&n1=usuarios&n2=consultarusuarios';
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
function guardar(variables){
		var formData = new FormData($("#formulario")[0]);
		$("#botonGuardar").hide();
		$(".loading").show();
		$.ajax({
			url: 'guardar.php',
			type: "POST",
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			success: function(mensaje){
				$("#botonGuardar").show();
				$(".loading").hide();
				mostrarMensaje(mensaje);
			}
		});
		return false;
}

function LimpiarCampos(){
	$("#autoidcliente").val("");
	$("#cidcliente").val("");
	$("#consultaidcliente").val("");
	$("#cidempleado").val("");
	$("#consultaidempleado").val("");
	$("#autoidempleado").val("");
	$("#cidtecnico").val("");
	$("#consultaidtecnico").val("");
	$("#autoidtecnico").val("");
}

// Función que permite autollenar los 3 campos de la relación del usuario con empleado,tecnico o cliente.
function Autollenadocamporelacionempleados(idregistrorelacionado,tabla){
var campobuscar="";
var directorio="";

	if (tabla=="tecnicos") {
		campobuscar='idtecnico'; //campo a buscar en la consulta sql
		tabla='Tecnico'; // nombre de la tabla
		directorio='tecnicos';  // nombre de la carpeta del modulo
	}

	if (tabla=="empleados") {
		campobuscar='idempleado'; //campo a buscar en la consulta sql
		tabla='Empleado'; // nombre de la tabla
			directorio='empleados'; // nombre de la carpeta del modulo
	}

	if (tabla=="clientes") {
		campobuscar='idcliente'; //campo a buscar en la consulta sql
		tabla='Cliente';	// nombre de la tabla
		directorio='clientes'; // nombre de la carpeta del modulo
	}
	// $("#cidtecnico").val(idregistrorelacionado);

		$.ajax({
			url: '../componentes/AutoLlenadoModificarRelacionUsuarios.php',
			type: "POST",
			data: "submit=&idregistrorelacionado="+idregistrorelacionado+"&tabla="+tabla+"&campobuscar="+campobuscar+"&directorio="+directorio, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
$("#auto"+campobuscar).val(mensaje);
$("#consulta"+campobuscar).val(mensaje);
$("#c"+campobuscar).val(idregistrorelacionado);
			//	alert(mensaje);
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
