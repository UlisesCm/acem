// JS MODULA Autor: Armando Viera Rodriguez 2016
function vaciarCampos(){
	$("#cnombre").focus();
}
$(document).ready(function() {

	/* Mostrar y Ocultar tipo de Leccion y Examen */
	contenidoLecciones()
	contenidoExamen()

	$("#ctipoLeccion").change(()=>{
		contenidoLecciones()
	})
	$('#ctipopregunta').change(()=>{
		contenidoExamen()
	})
	var contador = 0
	//crear Lecciones
	$("#agregar-leccion").click(()=>{
		contador++
		crearLeccion(contador);
	})

	$("#panel_alertas").hide();
	$(".loading").hide();
	//$("#panel_alertas").delay(8000).hide(600);
	
	
	
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

/* Funcion en flecha para ocultar y mostrar el input de contenidos. */
const contenidoLecciones = ()=> {
	/* declaracion de variables */
	const select = $("#ctipoLeccion")
	const textArea = $("#contenidoTextArea")
	const input = $("#contenidoInput")
	const documento = $("#contenidoArchivo")

	/* asignacion de valores por defecto */
	textArea.show()
	input.hide()
	documento.hide()

	switch (select.val()) {
		case "texto":
			textArea.show()
			input.hide()
			documento.hide()
			// console.log("se esta mostrando Texto")
			break;

		case "enlace":
			input.show()
			textArea.hide()
			documento.hide()
			// console.log("se esta mostrando enlace")
			break;

		case "imagen":
			documento.show()
			input.hide()
			textArea.hide()
			// console.log("se esta mostrando imagen")
			break;

		case "video":
			documento.show()
			input.hide()
			textArea.hide()
			// console.log("se esta mostrando video")
			break;

		case "documento":
			documento.show()
			input.hide()
			textArea.hide()
			// console.log("se esta mostrando documento")
			break;
	
		default:
			textArea.show()
			input.hide()
			documento.hide()
			// console.log("se esta mostrando default")
			break;
	}
}

const contenidoExamen = ()=> {
	const checkbox = $('#respuesta-checkbox')
	const select = $('#ctipopregunta')
	const textarea = $('#textarea-pregunta')
	const input = $('#input-pregunta')

	checkbox.hide()
	textarea.hide()
	input.show()

	switch (select.val()) {
		
		case "abierta":
			checkbox.hide()
			input.show()
			textarea.hide()
			break;

		case "multiple":
			checkbox.show()
			input.show()
			textarea.hide()
			break;

		case "practica":
			checkbox.hide()
			input.hide()
			textarea.show()
			break;
	
		default:
			break;
	}
}
/* function clonarNodo(indice) {
	var original=document.getElementById("nodo_original");
	var nuevo=original.cloneNode(true);
	nuevo.id=indice;
	destino=document.getElementById("nodo_destino");
	destino.appendChild(nuevo);
   }  */
/* https://qastack.mx/programming/10126395/how-to-jquery-clone-and-change-id */

 const crearLeccion = (index)=>{
	const original = document.getElementById("nodo-padre")
	const destino = document.getElementById("padre-lecciones")
	const nuevo = original.cloneNode(true);
	nuevo.id=index
	destino.appendChild(nuevo)
	console.log(index)
	
} 

function buscar (busqueda){
	location.href='../consultar/vista.php?link=vista&busqueda='+busqueda+'&n1=cursos&n2=consultarcursos';
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
