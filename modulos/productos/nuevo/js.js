// JS MODULA Autor: Armando Viera Rodriguez 2020
var arregloCampo=[];
var arregloOrden=[];
var arregloCaracteristicas=[];
var descproducto="";
var codproducto="";

function vaciarCampos(){
		$("#cnombre").val("");
		$("#ccodigo").val("");
		$("#cpesoteorico").val("");
		$("#ctipo").val("");
		$("#cdescripcion").val("");
		$("#cclave").val("");
		$("#cnombre").focus();
}
$(document).ready(function() {
	
	$("#panel_alertas").hide();
	$(".loading").hide();
	llenarArbol("");
	//$("#panel_alertas").delay(8000).hide(600);
	
	//AUTOCOMPLETAR
	$( "#autoidcategoria" ).autocomplete({
        source: "../componentes/buscarCategoria.php",
		autoFocus:true,
		select:function(event,ui){ 
        	$('#cidcategoria').val(ui.item.id);
			$('#consultaidcategoria').val(ui.item.consulta);
    	},
		search: function (event, ui) {
			$("#cidcategoria").val("");
			$("#consultaidcategoria").val($("#autoidcategoria").val());
		},
		change: function (event, ui) {
			$.ajax({
            	url:'../componentes/Categoria.php',
            	type:'POST',
            	dataType:'json',
				/*En caso de generar una descripció "label" compuesta por dos o mas datos
				en el archivo buscarX.php será necesario cambiar el termino 
				$('#autoX').val() por $('#consultaX').val()*/
            	data:{ termino:$('#autoidcategoria').val()}
        		}).done(function(respuesta){
            		$("#cidcategoria").val(respuesta.id);
        	});
		},
        minLength: 1
    });
	// FIN AUTOCOMPLETAR
	
	llenarSelectModeloimpuestos("");
	llenarSelectUnidad("");
	llenarChecksProveedores("");
	
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
	$("#ccosto").keypress(function(){
		return checarDecimal(event, this);
	});
	
	
});
function activarCaja(id){
	$("#caja"+id).toggleClass("cajaActiva");
	if ($("#clave"+id).is(':visible')){
		$("#clave"+id).hide();
		$("#clave"+id).prop( "disabled", true );
	}else{
		$("#clave"+id).show();
		$("#clave"+id).prop( "disabled", false );
	}
}

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
	location.href='../consultar/vista.php?link=vista&busqueda='+busqueda+'&n1=productos&n2=consultarproductos';
}

function llenarSelectModeloimpuestos(condicion){
		$("#idmodeloimpuestos_ajax").html("<option value='1'>cargando...</option>");
		$.ajax({
			url: '../componentes/llenarSelectModeloimpuestos.php',
			type: "POST",
			data: "submit=&condicion="+condicion, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#idmodeloimpuestos_ajax").html(mensaje);
			}
		});
		return false;
}
function llenarSelectCategoria(condicion){
		$("#idcategoria_ajax").html("<option value='1'>cargando...</option>");
		$.ajax({
			url: '../componentes/llenarSelectCategoria.php',
			type: "POST",
			data: "submit=&condicion="+condicion, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#idcategoria_ajax").html(mensaje);
			}
		});
		return false;
}
function llenarSelectUnidad(condicion){
		$("#idunidad_ajax").html("<option value='1'>cargando...</option>");
		$.ajax({
			url: '../componentes/llenarSelectUnidad.php',
			type: "POST",
			data: "submit=&condicion="+condicion, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#idunidad_ajax").html(mensaje);
			}
		});
		return false;
}

function llenarChecksProveedores(condicion){
		$("#proveedores_ajax").html("Cargando proveedores...");
		$.ajax({
			url: '../componentes/llenarChecksProveedores.php',
			type: "POST",
			data: "submit=&condicion="+condicion, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#proveedores_ajax").html(mensaje);
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
//////FUNCIONES DEL LLENADO DEL ARBOL DE FAMILIAS Y CONFIGURACION DE CAMPOS

function llenarArbol(variables){
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
					
					var nombre=$(".jstree-clicked").parent().attr("descripcion");
					var codigo=$(".jstree-clicked").parent().attr("codigo");
					var campos=$(".jstree-clicked").parent().attr("campos");
					var idfamilia=$(".jstree-clicked").parent().attr("idfamilia");

					if (idfamilia){
						$('#cidfamilia').val(idfamilia);
					}
					if (nombre){
						$("#cnombre").val(nombre);
						descproducto=nombre;
					}
					if (codigo){
						$("#ccodigo").val(codigo);
						codproducto=codigo;
					}
					limpiarCampos();
					ocultarCampos();
					if (campos){
						mostrarCampos(campos);
					}
				})
			}
		});
		return false;
}


function llenarSelect(campo,condicion){
		$("#c"+campo).html("<option value='1'>cargando...</option>");
		$.ajax({
			url: '../componentes/llenarSelect.php',
			type: "POST",
			data: "submit=&condicion="+condicion+"&campo="+campo, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#c"+campo).html(mensaje);
				agregarDescripcion();
			}
		});
		return false;
}

function mostrarCampos(campos){
	campos=campos.substring(0,campos.length-3);
	var res=campos.split(":::");
	arregloCampo=descomponerArreglo(3,0,res);
	arregloOrden=descomponerArreglo(3,1,res);
	arregloCaracteristicas=descomponerArreglo(3,2,res);
	for (i=0;i<arregloCampo.length;i++){
		$(".L"+arregloCampo[i]).show();
		llenarSelect(arregloCampo[i],arregloCaracteristicas[i]);
	}
}

function ocultarCampos(){
	$(".Lpesoteorico").hide();
	$(".Lespesor").hide();
	$(".Lancho").hide();
	$(".Lcolor").hide();
	$(".Ldiametro").hide();
	$(".Llado").hide();
	$(".Ltipo").hide();
	$(".Lmarca").hide();
	$(".Lalto").hide();
	$(".Laplicacion").hide();
	$(".Lmodelo").hide();
	$(".Lmodelo2").hide();
	$(".Llargo").hide();
	$(".Lclave").hide();
}

function limpiarCampos(){
	$(".Lancho").hide();
	$("#cancho").val("NA");
	$(".Lcolor").hide();
	$("#clargo").val("NA");
	$(".Llargo").hide();
	$("#ccolor").val("NA");
	$(".Ldiametro").hide();
	$("#cdiametro").val("NA");
	$(".Lespesor").hide();
	$("#cespesor").val("NA");
	$(".Llado").hide();
	$("#clado").val("NA");
	$(".Lpesoteorico").hide();
	$("#cpesoteorico").val("");
	$(".Ltipo").hide();
	$("#ctipo").val("");
}

function agregarDescripcion(){
	var orden=[];
	for (i=0;i<arregloCampo.length;i++){
		if(arregloOrden[i]!=""){ //Si Existe un orden para mostrar del campo
			var posicion=arregloOrden[i];
			orden[posicion]=arregloCampo[i];
		}
	}
	var cadena=descproducto;
	var cadenaCodigo=codproducto;
	var frag="";
	for (i=0;i<orden.length;i++){
		if (orden[i]){
			
			frag=$(".c"+orden[i]).val();
			if (frag!=null){
				cadena=cadena+" "+$(".c"+orden[i]).val();
			}
			
			//alert(orden[i]+": "+$(".c"+orden[i]).val());
			if($(".c"+orden[i]).find('option:selected').attr("codigo")){
				cadenaCodigo=cadenaCodigo+" "+$(".c"+orden[i]).find('option:selected').attr("codigo");
			}
		}
	}
	$("#cnombre").val(cadena);
	$("#ccodigo").val(cadenaCodigo);
}
//////FIN DE FUNCIONES DEL LLENADO DEL ARBOL DE FAMILIAS Y CONFIGURACION DE CAMPOS


function descomponerArreglo(elementosPorVuelta,elementoSeleccionado, arreglo){
	var totalElementos= arreglo.length;
	if (totalElementos!=1){
		var con=0;
		var array=[];
		var totalVueltas=totalElementos/elementosPorVuelta;
		while(con<totalVueltas){
			array[con]= arreglo[elementoSeleccionado];
			elementoSeleccionado=elementoSeleccionado+elementosPorVuelta;
			con++;
		}
		return array;
	}else{
		return arreglo;
	}
		
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
