// JS MODULA Autor: Armando Viera Rodriguez 2020

// JavaScript Document
var orden, campoOrden, cantidadamostrar, paginacion;
orden="DESC";
campoOrden="idprecio";
iniciar="0";
cantidadamostrar="20";
paginacion=0;




function actualizarDato2(campo,valor,idprecio){
	$.ajax({
		url: 'guardar.php',
		type: "POST",
		data: "submit=&campo="+campo+"&valor="+valor+"&idprecio="+idprecio, //Pasamos los datos en forma de array seralizado desde la funcion de envio
		success: function(mensaje){
			$("#"+campo).css("color","#096");
		}
	});
}

function actualizarDato(componente,campo,idprecio){
		var valor=$.trim($("#"+componente).val());
		if (valor=="" || valor=="."){
			valor=0;
			$("#"+componente).val(0)
		}
		$("#"+componente).css("color","#FC0");
		
		
		var costo=parseFloat($("#costo"+idprecio).val());
		var procentajeutilidad=parseFloat($("#porcentajeutilidad"+idprecio).val());
		var utilidad=costo*(procentajeutilidad/100);
		var precio=costo+utilidad;
		var porcentajedescuento=parseFloat($("#porcentajedescuento"+idprecio).val());
		var descuento=precio*(porcentajedescuento/100);
		
		$.ajax({
			url: 'guardar.php',
			type: "POST",
			data: "submit=&campo="+campo+"&valor="+valor+"&idprecio="+idprecio, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#botonGuardar").show();
				$(".loading").hide();
				$("#"+componente).css("color","#096");
				
				if (campo=="porcentajeutilidad" || campo=="porcentajedescuento"){
					precio=costo+utilidad-descuento;
					$("#precio"+idprecio).val(precio);
					actualizarDato2("precio",precio,idprecio);
				}
				
				if (campo=="precio"){
					precio=parseFloat($("#precio"+idprecio).val());
					procentajeutilidad=(precio/costo);
					procentajeutilidad=(procentajeutilidad*100)-100;
					$("#porcentajeutilidad"+idprecio).val(procentajeutilidad);
					actualizarDato2("porcentajeutilidad",procentajeutilidad,idprecio);
				}
				
				//mostrarMensaje(mensaje);
			}
		});
		return false;
}


function seleccionarTodo(){
	if ($("#seleccionarTodo").prop("checked")==true){
		$(".checkEliminar").prop("checked", "checked");
	}else{
		$(".checkEliminar").prop("checked", "");
	}   
}
function eliminarIndividual(id) {
	var encoded = "¿Desea borrar el registro?";
	var decoded = $("<div/>").html(encoded).text();
    var pregunta = confirm(decoded);
	if (pregunta){
		eliminar_individual(id);
	}
}
function comprobarReglas(){
	$(".checksEliminar").hide();
	//Identificar el campo de ordenamiento
	if(recuperarCookie("campoOrdenPrecios")!=null){
		campoOrden=recuperarCookie("campoOrdenPrecios");
		 $("#campoOrden option[value="+campoOrden+"]").attr("selected",true);
	}else{
		campoOrden="idprecio";
		$("#campoOrden option[value="+campoOrden+"]").attr("selected",true);
	}
	
	//Identificar el numero de elementos para mostrar
	if(recuperarCookie("cantidadamostrarPrecios")!=null){
		cantidadamostrar=recuperarCookie("cantidadamostrarPrecios");
		 $("#cantidadamostrar option[value="+cantidadamostrar+"]").attr("selected",true);
	}else{
		cantidadamostrar="20";
		$("#cantidadamostrar option[value="+cantidadamostrar+"]").attr("selected",true);
		
	}
	
	//Identificar el tipo de orden
	if(recuperarCookie("ordenPrecios")=="asc"){
		orden="ASC"
		$('#asc').attr('checked', true);
		$('#desc').attr('checked', false);
	}else if(recuperarCookie("ordenPrecios")=="desc"){
		orden="DESC"
		$('#asc').attr('checked', false);
		$('#desc').attr('checked', true);
	}else{
		orden="DESC"
		$('#asc').attr('checked', false);
		$('#desc').attr('checked', true);
	}
	//Mostrar u Ocultar Idprecio
	if(recuperarCookie("mostrarIdprecioPrecios")=="si"){
		$('.Cidprecio').show();
		$('#CheckIdprecio').attr('checked', true);
	}else if(recuperarCookie("mostrarIdprecioPrecios")=="no"){
		$('.Cidprecio').hide();
		$('#CheckIdprecio').attr('checked', false);
	}
	//Mostrar u Ocultar Idreferencia
	if(recuperarCookie("mostrarIdreferenciaPrecios")=="si"){
		$('.Cidreferencia').show();
		$('#CheckIdreferencia').attr('checked', true);
	}else if(recuperarCookie("mostrarIdreferenciaPrecios")=="no"){
		$('.Cidreferencia').hide();
		$('#CheckIdreferencia').attr('checked', false);
	}
	//Mostrar u Ocultar Descripcion
	if(recuperarCookie("mostrarDescripcionPrecios")=="si"){
		$('.Cdescripcion').show();
		$('#CheckDescripcion').attr('checked', true);
	}else if(recuperarCookie("mostrarDescripcionPrecios")=="no"){
		$('.Cdescripcion').hide();
		$('#CheckDescripcion').attr('checked', false);
	}
	//Mostrar u Ocultar Preciopublico
	if(recuperarCookie("mostrarPreciopublicoPrecios")=="si"){
		$('.Cpreciopublico').show();
		$('#CheckPreciopublico').attr('checked', true);
	}else if(recuperarCookie("mostrarPreciopublicoPrecios")=="no"){
		$('.Cpreciopublico').hide();
		$('#CheckPreciopublico').attr('checked', false);
	}
	//Mostrar u Ocultar Comisiongeneral
	if(recuperarCookie("mostrarComisiongeneralPrecios")=="si"){
		$('.Ccomisiongeneral').show();
		$('#CheckComisiongeneral').attr('checked', true);
	}else if(recuperarCookie("mostrarComisiongeneralPrecios")=="no"){
		$('.Ccomisiongeneral').hide();
		$('#CheckComisiongeneral').attr('checked', false);
	}
	//Mostrar u Ocultar Comisionreferenciado
	if(recuperarCookie("mostrarComisionreferenciadoPrecios")=="si"){
		$('.Ccomisionreferenciado').show();
		$('#CheckComisionreferenciado').attr('checked', true);
	}else if(recuperarCookie("mostrarComisionreferenciadoPrecios")=="no"){
		$('.Ccomisionreferenciado').hide();
		$('#CheckComisionreferenciado').attr('checked', false);
	}
	//Mostrar u Ocultar Comisionmaster
	if(recuperarCookie("mostrarComisionmasterPrecios")=="si"){
		$('.Ccomisionmaster').show();
		$('#CheckComisionmaster').attr('checked', true);
	}else if(recuperarCookie("mostrarComisionmasterPrecios")=="no"){
		$('.Ccomisionmaster').hide();
		$('#CheckComisionmaster').attr('checked', false);
	}
	//Mostrar u Ocultar Precioproveedor
	if(recuperarCookie("mostrarPrecioproveedorPrecios")=="si"){
		$('.Cprecioproveedor').show();
		$('#CheckPrecioproveedor').attr('checked', true);
	}else if(recuperarCookie("mostrarPrecioproveedorPrecios")=="no"){
		$('.Cprecioproveedor').hide();
		$('#CheckPrecioproveedor').attr('checked', false);
	}
	//Mostrar u Ocultar Composicion
	if(recuperarCookie("mostrarComposicionPrecios")=="si"){
		$('.Ccomposicion').show();
		$('#CheckComposicion').attr('checked', true);
	}
	if(recuperarCookie("mostrarComposicionPrecios")=="no"){
		$('.Ccomposicion').hide();
		$('#CheckComposicion').attr('checked', false);
	}
	
	//Elegir el tipo de vista
	if(recuperarCookie("tipoVistaPrecios")=="tabla"){
		$('.tipoLista').show();
		$('.tipoTabla').hide();
		tipoVista="tabla";
	}else{
		$('.tipoLista').hide();
		$('.tipoTabla').show();
		tipoVista="lista";
	}
	$( ".tipoTabla" ).click(function() {
    	crearCookie("tipoVistaPrecios", "tabla");
		tipoVista="tabla";
		$(".tipoLista").show();
		$(".tipoTabla").hide();
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$( ".tipoLista" ).click(function() {
    	crearCookie("tipoVistaPrecios", "lista");
		tipoVista="lista";
		$(".tipoLista").hide();
		$(".tipoTabla").show();
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});

}

function vaciarCampos(){
	$("#cnombre").focus();
}

$(document).ready(function() {
	comprobarReglas();
	load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	llenarArbol("");
	$("#panel_alertas").hide();
	$(".loading").hide();
	//$("#panel_alertas").delay(8000).hide(600);
	
	$(".botonEliminar").click(function() {
		$("#barraPaginacion").hide();
		$(".cajaBorrar").show();
		$(".herramientasIndividuales").hide();
		$(".checksEliminar").show();
	});
	
	$(".botonCancelarBorrar").click(function() {
		$(".herramientasIndividuales").show();
		$("#barraPaginacion").show();
		$(".cajaBorrar").hide();
		$(".checksEliminar").hide();
	});
	
	$(".botonBorrar").click(function() {
		var pregunta = confirm("¿Desea borrar esta información?")
		if (pregunta){
			$(".herramientasIndividuales").show("slow");
			$("#barraPaginacion").show("slow");
			$(".cajaBorrar").hide();
			$(".checksEliminar").hide("slow");
			var valores = [];
			var todos = document.getElementsByName("registroEliminar[]");
			for(var i = 0; i < todos.length; i++){
				if (todos[i].checked){
					valores.push(todos[i].value);
				}
			}
			eliminar_registros(valores);
		}else{
			$(".herramientasIndividuales").show("slow");
			$("#barraPaginacion").show("slow");
			$(".cajaBorrar").hide();
			$(".checksEliminar").hide("slow");
		}
	});
	
	$("#campoOrden").change(function(){
		campoOrden = this.value;
		crearCookie("campoOrdenListaprecios", campoOrden);
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$("#cantidadamostrar").change(function(){
		cantidadamostrar = this.value;
		crearCookie("cantidadamostrarListaprecios", cantidadamostrar);
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$( "#asc" ).click(function() {
    	if ($( "#asc" ).is(':checked')){
			crearCookie("ordenListaprecios", "asc");
			orden="ASC"
			load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
		}
	});
	$( "#desc" ).click(function() {
    	if ($( "#desc" ).is(':checked')){
			crearCookie("ordenListaprecios", "desc");
			orden="DESC"
			load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
		}
	});
	$( "#CheckIdlistaprecios" ).click(function() {
    	if ($( "#CheckIdlistaprecios" ).is(':checked')){
			crearCookie("mostrarIdlistapreciosListaprecios", "si");
			$('.Cidlistaprecios').show();
		}else{
			crearCookie("mostrarIdlistapreciosListaprecios", "no");
			$('.Cidlistaprecios').hide();
		}	
	});
	$( "#CheckNombre" ).click(function() {
    	if ($( "#CheckNombre" ).is(':checked')){
			crearCookie("mostrarNombreListaprecios", "si");
			$('.Cnombre').show();
		}else{
			crearCookie("mostrarNombreListaprecios", "no");
			$('.Cnombre').hide();
		}	
	});
	$( "#CheckComposicion" ).click(function() {
    	if ($( "#CheckComposicion" ).is(':checked')){
			crearCookie("mostrarComposicionListaprecios", "si");
			$('.Ccomposicion').show();
		}else{
			crearCookie("mostrarComposicionListaprecios", "no");
			$('.Ccomposicion').hide();
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
	
	$(".botonSincronizar").click(function() {
			if (validar()){
				var variables=$("#formulario").serialize();
				sincronizar(variables);
			}
	});
	
	/*Importante*/
	$('.dropdown-menu').on('click', function(e){
        if($(this).hasClass('dropdown-menu-form')){
            e.stopPropagation();
        }
	});
	
	$(".botonCondicionar").click(function(){ 
		$("#modal").modal();
 	});
	
	$(".botonCargar").click(function(){ 
		$("#modal2").modal();
 	});
	
	$("#botonActualizarPrecios").click(function(){ 
		if (validar()){
			var variables=$("#formularioFamilias").serialize();
			actualizarPrecios(variables);
		}
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


function buscar (busqueda){
	load_tablas(campoOrden,orden,cantidadamostrar,paginacion,busqueda,tipoVista);
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

function actualizarPrecios(variables){
		$("#botonActualizarPrecios").hide();
		$("#loading2").show();
		$.ajax({
			url: 'actualizarPrecios.php',
			type: "POST",
			data: "submit=&"+variables, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#botonActualizarPrecios").show();
				$("#loading2").hide();
				alert(mensaje);
				load_tablas(campoOrden,orden,cantidadamostrar,paginacion,busqueda,tipoVista);
			}
		});
		return false;
}

function sincronizar(variables){
		$("#botonGuardar").hide();
		$(".loading").show();
		$.ajax({
			url: 'sincronizar.php',
			type: "POST",
			data: "submit=&"+variables, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#botonGuardar").show();
				$(".loading").hide();
				mostrarMensaje(mensaje);
				load_tablas(campoOrden,orden,cantidadamostrar,paginacion,busqueda,tipoVista);
			}
		});
		return false;
}


function llenarArbol(variables){
		$("#arbol_ajax").jstree('destroy');
	    $("#arbol_ajax").html("");
		$("#loading").show();
		$.ajax({
			url: '../componentes/llenarArbol.php',
			type: "POST",
			data: "submit=&"+variables, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#loading").hide();
				$("#arbol_ajax").html(mensaje);
				$('#arbol_ajax').jstree();
				$('#arbol_ajax').on('changed.jstree', function (e, data) {
					var nombre=$(".jstree-clicked").parent().attr("nombre");
					var idfamilia=$(".jstree-clicked").parent().attr("idfamilia");
					if (nombre){
						$('#familia').val(nombre);
					}
					if (idfamilia){
						$('#cidfamilia').val(idfamilia);
					}
				})
			}
		});
		return false;
}

function load_tablas (campoOrden, orden, cantidadamostrar, paginacion, busqueda, tipoVista){
	//alert (orden);
	//alert (campoOrden);
	//alert (limit);
	var idlistaprecios=$("#cidlistaprecios").val();
	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById("muestra_contenido_ajax").innerHTML=xmlhttp.responseText;
			comprobarReglas();
			$("#loading").hide();
		}
		else{
			$("#loading").show();
		}
	}
	xmlhttp.open("POST","consultar.php?campoOrden="+campoOrden+"&orden="+orden+"&cantidadamostrar="+cantidadamostrar+"&paginacion="+paginacion+"&busqueda="+busqueda+"&tipoVista="+tipoVista+"&papelera="+papelera+"&idlistaprecios="+idlistaprecios, true);
	xmlhttp.send();
}

function eliminar_individual(id){
		$.ajax({
			url: '../eliminar/eliminar.php',
			type: "POST",
			data: "submit=&ids="+id, //Pasamos los datos en forma de array
			success: function(mensaje){
				mostrarMensaje(mensaje,id,"eliminar");
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