// JS MODULA Autor: Armando Viera Rodriguez 2016
function vaciarCampos(){
	$("#cnombre").focus();
	llenarArbol(idfamiliaSeleccionada);
}


function abrirModal(caracteristica){
	$("#modalCaracteristicas").modal();
	var caracteristicas=$("#caracteristicas"+caracteristica).val();
	$.ajax({
		url: '../componentes/llenarCaracteristicas.php',
		type: "POST",
		data: "submit=&caracteristica="+caracteristica+"&caracteristicas="+caracteristicas, //Pasamos los datos en forma de array
		success: function(mensaje){
			$("#contenidoCarac").html(mensaje);
		}
	});
	return false;
}

function colocarValores(){
	var cadena="";
	$("input[name='caracteristica[]']:checked").each(function (){
        //cada elemento seleccionado
        cadena=cadena+($(this).val())+",";
    })
	cadena=cadena.substring(0,cadena.length-1);
	caracteristica=$("#ccaracteristica").val();
	$("#caracteristicas"+caracteristica).val(cadena);
	recorrerTablaOrden("tablaOrden","ccamposrequeridos")
}

$(document).ready(function() {
	llenarArbol(idfamiliaSeleccionada);
	recuperarCaracteristicas(idfamilia);
	
	$("#panel_alertas").hide();
	$(".loading").hide();
	//$("#panel_alertas").delay(8000).hide(600);
	
	//AUTOCOMPLETAR
	$( "#autoidfamiliamadre" ).autocomplete({
        source: "../componentes/buscarFamilia.php",
		autoFocus:true,
		select:function(event,ui){ 
        	$('#cidfamiliamadre').val(ui.item.id);
			$('#consultaidfamiliamadre').val(ui.item.consulta);
    	},
		search: function (event, ui) {
			$("#cidfamiliamadre").val("");
			$("#consultaidfamiliamadre").val($("#autoidfamiliamadre").val());
		},
		change: function (event, ui) {
			$.ajax({
            	url:'../componentes/Familia.php',
            	type:'POST',
            	dataType:'json',
				/*En caso de generar una descripció "label" compuesta por dos o mas datos
				en el archivo buscarX.php será necesario cambiar el termino 
				$('#autoX').val() por $('#consultaX').val()*/
            	data:{ termino:$('#autoidfamiliamadre').val()}
        		}).done(function(respuesta){
            		$("#cidfamiliamadre").val(respuesta.id);
        	});
		},
        minLength: 1
    });
	// FIN AUTOCOMPLETAR
	
	$("#botonAceptar").click(function() {
			colocarValores("espesor");
	});
	
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
	$(".activeCampos").click(function(){ 
		recorrerTablaOrden("tablaOrden","ccamposrequeridos");
 	});
	$(".activeCampos").blur(function(){ 
		recorrerTablaOrden("tablaOrden","ccamposrequeridos");
 	});
	$("#botonFamilia").click(function(){ 
		$("#modal").modal();
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
// Onixbm 2020

function recorrerTablaOrden(tabla,lista){
	var con=1;
	var no, numeropagina, idpagina, antes, despues, propiedad, orden;
	var cadena;
	cadena="";
	$('#'+tabla+' li').each(function () {
		$(this).find('input').each(function (index,valor) {
			if (index==0){
				//$(this).find('input').val(con);
				idpagina=$(this).val();
				
				
			}
			if (index==1){
				//$(this).val(con);
				//numeropagina=$(this).val();
			}
			
			if (index==2){
				if(! $(this).prop('checked') ) { // Si no se marca como parametro requerido
					$(this).parent().children(".orden").val("");
					$(this).parent().children("small").html("");
					$(this).parents("li").children(".tools").find(".corden").prop( "checked", false );
					
					if($(this).parents("li").children(".text").find(".prop").prop( "checked")){
						if($(this).prop('checked') ) {
							$("#B"+idpagina).show();
						}else{
							$("#B"+idpagina).hide();
						}
						propiedad=$(this).parents("li").children(".text").find(".prop").val();
						orden="";
						caracteristicas=$(this).parents("li").children(".tools").find(".caracteristicas").val();
						cadena=cadena+propiedad+":::"+orden+":::"+caracteristicas+":::";
					}
				}else{ // Si se marca como parametro requerido
					$(this).parents("li").children(".text").find(".prop").prop( "checked", true );
					$(this).parent().children(".orden").val(con);
					$(this).parent().children("small").html("<i class='fa fa-file-o'></i> Orden para mostrar: <span>"+$(this).parent().children(".orden").val()+"</span>");
					if($(this).prop('checked') ) {
						$("#B"+idpagina).show();
					}else{
						$("#B"+idpagina).hide();
					}
					caracteristicas=$(this).parents("li").children(".tools").find(".caracteristicas").val();
					propiedad=$(this).parents("li").children(".text").find(".prop").val();
					orden=$(this).parent().children(".orden").val();
					cadena=cadena+propiedad+":::"+orden+":::"+caracteristicas+":::";
					
					con++;
				}
			}
			
			//$(valor).css("background-color", "#ECF8E0");
		})
		
	})
	$("#"+lista).val(cadena);
}



function recorrerTabla(tabla,lista){
	var no, idproducto, propiedad, orden, minimo, ubicacion, total=0, totalCosto=0;
	var cadena;
	cadena="";
	no=0;
	$('#'+tabla+' tbody tr').each(function () {
		$(this).find('td').each(function (index,valor) {
			if (index==0){
				if( $("#propiedad"+no).is(':checked') ) {
					propiedad=$("#propiedad"+no).val();
					cadena=cadena+propiedad+":::";
				}
			}
			if (index==1){
				if( $("#propiedad"+no).is(':checked') ) {
					orden=$("#orden"+no).val();
					cadena=cadena+orden+":::";
				}
				
			}
		})
		no=no+1;
	})
	$("#"+lista).val(cadena);
}

//**************************AJAX*******************************
// Autor: Armando Viera Rodríguez
// Onixbm 2020

function buscar (busqueda){
	location.href='../consultar/vista.php?link=vista&busqueda='+busqueda+'&n1=familias&n2=consultarfamilias';
}

function recuperarCaracteristicas(idfamilia){
		$("#botonGuardar").hide();
		$(".loading").show();
		$.ajax({
			url: '../componentes/recuperarCaracteristicas.php',
			type: "POST",
			data: "submit=&idfamilia="+idfamilia, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#botonGuardar").show();
				$(".loading").hide();
				$("#tablaOrden").html(mensaje);
				inicializarDrags();
				recorrerTablaOrden("tablaOrden","ccamposrequeridos");
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

function guardarCaracteristica(){
		$("#botonValor").hide();
		var valor=$("#cvalor").val();
		var caracteristica=$("#ccaracteristica").val();
		$.ajax({
			url: '../../caracteristicas/nuevo/guardar.php',
			type: "POST",
			data: "submit=&valor="+valor+"&caracteristica="+caracteristica, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#botonValor").show();
				var cadena= $.trim(mensaje); //Limpia la cadena regresada desde php
				var res=cadena.split("@"); //Separa la cadena en cada @ y convierte las partes en un array
				if (res[0]!="exito"){
					alert("No se ha podido guardar el valor. Es posible que ya esté repetido o ha ocurrido un error al escribir el regsitro.");
				}
				abrirModal(caracteristica);
			}
		});
		return false;
}


function seleccionarFamilia(idfamilia,nombre){
		$("#autoidfamiliamadre").val(nombre);
		$("#cidfamiliamadre").val(idfamilia);
}


function llenarArbol(variables){
		$("#arbol_ajax").jstree('destroy');
	    $("#arbol_ajax").html("");
		$("#loading").show();
		$.ajax({
			url: '../componentes/llenarArbol.php',
			type: "POST",
			data: "submit=&idfamiliaseleccionada="+variables, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#loading").hide();
				$("#arbol_ajax").html(mensaje);
				$('#arbol_ajax').jstree();
				$('#arbol_ajax').on('changed.jstree', function (e, data) {
					var nombre=$(".jstree-clicked").parent().attr("nombre");
					var idfamilia=$(".jstree-clicked").parent().attr("idfamilia");
					if (nombre){
						$('#autoidfamiliamadre').val(nombre);
					}
					if (idfamilia){
						$('#cidfamiliamadre').val(idfamilia);
					}
				})
			}
		});
		return false;
}

function inicializarDrags(){
	
  
  $(".connectedSortable .box-header, .connectedSortable .nav-tabs-custom").css("cursor", "move");
  
  //jQuery UI sortable for the todo list
  $(".todo-list").sortable({
    placeholder: "sort-highlight",
    handle: ".handle",
    forcePlaceholderSize: true,
	update: function( event, ui ) {recorrerTablaOrden("tablaOrden","ccamposrequeridos")},
    zIndex: 999999
  });

  /* The todo list plugin */
  $(".todo-list").todolist({
    onCheck: function (ele) {
      console.log("The element has been checked")
    },
    onUncheck: function (ele) {
      console.log("The element has been unchecked")
    }
  });
}

function mostrarMensaje(mensaje){
	alert(mensaje);
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