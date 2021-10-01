// JS MODULA Autor: Armando Viera Rodriguez 2016
// JavaScript Document

// FUNCIONES DE LLENADO DE TABLA DE INFERIOR
var FILAS=0;
var CONDICION="";

function llenarProducto(){
	$.ajax({
           url:'../componentes/Producto.php',
           type:'POST',
           dataType:'json',
           data:{ termino:$('#autoidproducto').val()}
        }).done(function(respuesta){
            $("#cidproducto").val(respuesta.id);
			$("#ccodigoproducto").val(respuesta.codigo);
			$("#nunidad").val(respuesta.unidad);
			$("#nnombreproducto").val(respuesta.nombre);
			$("#ncosto").val(respuesta.costocompra);
			agregarProducto();
       });
}

function agregarProducto(){
			var idproductoV=$("#cidproducto").val();
			var codigoproductoV=$("#ccodigoproducto").val();
			var nombreproductoV=$("#nnombreproducto").val();
			var unidadV=$("#nunidad").val();
			var cantidadV=$("#ncantidad").val();
			var costoV=$("#ncosto").val();
			var minimoV=$("#nminimo").val();
			var ubicacionV=$("#nubicacion").val();
			
				if (idproductoV!=""){
					if(cantidadV=="" || cantidadV=="." || cantidadV=="0"){
						mostrarMensaje("fracaso@Ingrese la cantidad@<p>Es necesario proporcionar la cantidad de productos que van a entrar</p>");
						$("#ncantidad").focus();
					}else{
						variables=new Array();
						variables[0]=0; //Nueva fila
						variables[1]=idproductoV;
						variables[2]=codigoproductoV;
						variables[3]=nombreproductoV;
						variables[4]=unidadV;
						variables[5]=cantidadV;
						variables[6]=costoV;
						variables[7]=minimoV;
						variables[8]=ubicacionV;
						if (contarFilas(idproductoV, cantidadV)==false){
							agregarFila("tablaSalida", variables, "listaSalida");
						}else{
							recorrerTabla("tablaSalida","listaSalida");
						}
						$("#cidproducto").val("");
						$("#autoidproducto").val("");
						$("#autoidproducto").focus();
						document.getElementById('playerq').play();
					}
				}else{
					mostrarMensaje("fracaso@Seleccione un producto@<p>El producto que intenta ingresar no existe en la base de datos</p>");
					$("#cidproducto").val("");
					$("#autoidproducto").val("")
					$("#autoidproducto").focus();
					document.getElementById('player').play();
				}
}

$(document).ready(function() {
	
	//AUTOCOMPLETAR
	$("#autoidproducto").autocomplete({
        source: "../componentes/buscarProductoNombre.php",
		autoFocus:true,
		select:function(event,ui){ 
        	$('#cidproducto').val(ui.item.id);
			$('#nunidad').val(ui.item.unidad);
			$('#ncosto').val(ui.item.costo);
			$('#consultaidproducto').val(ui.item.consulta);
			$('#nnombreproducto').val(ui.item.consulta);
			$('#ccodigoproducto').val(ui.item.codigo);
			$("#nidproducto").val(ui.item.idproducto);
    	},
		search: function (event, ui) {
			$("#cidproducto").val("");
			$("#consultaidproducto").val($("#autoidproducto").val());
		},
		
        minLength: 1
    });
	// FIN AUTOCOMPLETAR
	
	
	$("#autoidproducto").keypress(function(event){ 
		var keycode = (event.keyCode ? event.keyCode : event.which); 
      	if(keycode == '13'){
			agregarProducto();
		}
    });
	// FIN AUTOCOMPLETAR
	
	$("#botonAgregarFila").click(function() {
			llenarProducto();
	}); 
	
	$("#ncantidad").keypress(function(){
		return checarDecimal(event, this);
	});
	
	$("#ncosto").keypress(function(){
		return checarDecimal(event, this);
	});
	
	$("#nminimo").keypress(function(){
		return checarDecimal(event, this);
	});
	
	$(document).on("click",".eliminarFila",function(){
		var parent = $(this).parents().get(0);
		$(parent).remove();
		recorrerTabla("tablaSalida","listaSalida"); // Crea la cadena de productos que se enviara a timbrado
	});
	
	//FIN DE FUNCIONES DE LLANDO DE TABLA DE INFERIOR
});

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
	
function checarCeros(id,idtotal) {
	campo=$("#"+id).val();
	campo=$.trim(campo);
	if (campo=="" || campo==0 || campo=="."){
		$("#"+id).val("0.00");
	}
	var cant=0;
	var cost=0;
	var total=0;
	cant=parseFloat ($("#cant"+idtotal).val());
	cost= parseFloat ($("#cost"+idtotal).val());
	var total=cant*cost;
	$("#total"+idtotal).text(total.toFixed(2));
	recorrerTabla("tablaSalida","listaSalida");
}
	
function redibujarTabla(id,idtotal) {
	recorrerTabla("tablaSalida","listaSalida");
}
	
function agregarFila(tabla, elementos,lista){
		$("#ncantidad").val("1");
		FILAS=FILAS+1;
        var nuevaFila="<tr>";
		var con=0;
		while (con < elementos.length){
			if (con==0){
				nuevaFila=nuevaFila+"<td style='display:none'>";
				nuevaFila=nuevaFila+FILAS;
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==1){
				nuevaFila=nuevaFila+"<td style='display:none'>";
					nuevaFila=nuevaFila+elementos[con];
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==2){
				nuevaFila=nuevaFila+"<td class=\"columnaIzquierda\" style=\"border-left: 10px solid #D82533;\">";
				nuevaFila=nuevaFila+elementos[con];
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==3){
				nuevaFila=nuevaFila+"<td>";
					nuevaFila=nuevaFila+elementos[con]; 
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==4){
				nuevaFila=nuevaFila+"<td>";
					nuevaFila=nuevaFila+elementos[con]; 
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==5){
				nuevaFila=nuevaFila+"<td>";
				nuevaFila=nuevaFila+"<input value='"+elementos[con]+"' name='cant"+FILAS+"' type='text' class='caja' id='cant"+FILAS+"' onblur=\"checarCeros('cant"+FILAS+"','"+FILAS+"')\" onkeyup=\"permitirDecimal('cant"+FILAS+"');\" onfocus=\"activarValidacion('cant"+FILAS+"');\" />";
				nuevaFila=nuevaFila+"</td>";
			}
			con=con+1;
		}
		nuevaFila=nuevaFila+"<td title='Eliminar Fila' class='eliminarFila'><a class='btn btn-default btn-xs'><i class='fa fa-trash-o text-green'></i><a></td>";
		nuevaFila=nuevaFila+"</tr>"
		//$("#"+tabla).append(nuevaFila); Coloca la fila al final de la tabla
		$("#"+tabla).prepend(nuevaFila); //Coloca la fila al inicio de la tabla
		recorrerTabla(tabla,lista);
}

function contarFilas(id, total){
	var no, idproducto, cantidad;
	tabla="tablaSalida";
	var encontrado=false, resultado=false;
	$('#'+tabla+' tbody tr').each(function () {
		$(this).find('td').each(function (index,valor) {
			
			if (index==0){
				no=$(valor).html();
			}
			if (index==1){
				idproducto=$(valor).html();
				if (idproducto==id){
					encontrado=true;
					resultado=true;
				}
			}
			if (index==5 && encontrado==true){
				cantidad=parseFloat ($("#cant"+no).val());
				total=parseFloat (total)+cantidad;
				$("#cant"+no).val(total);
				total=0;
			}
			encontrado==false;
		})
	})
	return resultado;
}

	
function recorrerTabla(tabla,lista){
	var no, idproducto, cantidad, total=0;
	var cadena;
	cadena="";
	$('#'+tabla+' tbody tr').each(function () {
		$(this).find('td').each(function (index,valor) {
			if (index==0){
				no=$(valor).html();
			}
			if (index==1){
				idproducto=$(valor).html();
			}
			if (index==5){
				cantidad=$("#cant"+no).val();
				if ($("#cant"+no).val()==0){
					$("#cant"+no).css('color', 'red');
				}else{
					$("#cant"+no).css('color', 'blue');
				}
				total=parseFloat(cantidad)+total;
			}
			
			//$(valor).css("background-color", "#ECF8E0");
		})
		cadena=cadena+idproducto+":::"+cantidad+":::";
	})
	$("#"+lista).val(cadena);
	$("#totalLista").html(total);
}
//FIN DE FUNCIONES DE LLANDO DE TABLA DE INFERIOR






function vaciarCampos(){
	$("#cnumerocomprobante").val("");
	$("#ccomentarios").val("");
	$("#cconcepto").focus();
	$("#filas").html("");
	$("#listaSalida").val("");
	$("#totalLista").html("0");
	FILAS=0;
}
$(document).ready(function() {
	
	$("#panel_alertas").hide();
	llenarSelectAlmacen("");
	llenarSelectEmpleado("");
	$(".loading").hide();
	
	//AUTOCOMPLETAR
	$( "#autoidcliente" ).autocomplete({
        source: "../componentes/buscarCliente.php",
		autoFocus:true,
		select:function(event,ui){ 
        	$('#cidcliente').val(ui.item.id);
			$('#consultaidcliente').val(ui.item.consulta);
			$('#tcliente').html(ui.item.consulta);
    	},
		search: function (event, ui) {
			$("#cidcliente").val("");
			$("#consultaidcliente").val($("#autoidcliente").val());
			$('#tcliente').html($("#autoidcliente").val());
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
	// FIN AUTOCOMPLETAR
	
	//$("#panel_alertas").delay(8000).hide(600);
	
	
	$("#cconcepto").change(function() {
		//Inicializamos valores
		$("#seccionTraspaso").hide();
		$("#Lalmacen").html("Sucursal / Almacén:");
		$("#cnumerocomprobante").val("");
		$("#seccionTabla").show();
		$("#botonProcesar").hide();
		$("#seccionTraspasoO").show();
		$("#seccionEmpleado").hide();
		$("#seccionCliente").hide();
		$('#cnumerocomprobante').prop('readonly', false);
		
		if ($(this).val()=="TRASPASO"){
			$("#seccionTraspaso").show();
			$("#Lalmacen").html("Sucursal / Almacén Origen:");
			$("#cnumerocomprobante").val("T-"+$("#clave").val());
			$('#cnumerocomprobante').prop('readonly', true);
		}
		if ($(this).val()=="CONSIGNACION A CLIENTE"){
			$("#cnumerocomprobante").val("C-"+$("#clave").val());
			$("#seccionCliente").show();
			$('#cnumerocomprobante').prop('readonly', true);
		}
		if ($(this).val()=="M CONSIGNACION A CLIENTE"){
			$("#seccionTabla").hide();
			$("#botonProcesar").show();
			$("#seccionTraspasoO").hide();
		}
		if ($(this).val()=="CONSIGNACION A VENDEDOR"){
			$("#cnumerocomprobante").val("C-"+$("#clave").val());
			$("#seccionEmpleado").show();
			$('#cnumerocomprobante').prop('readonly', true);
		}
		if ($(this).val()=="M CONSIGNACION A VENDEDOR"){
			$("#seccionTabla").hide();
			$("#botonProcesar").show();
			$("#seccionTraspasoO").hide();
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
	
	$("#ncantidad").keypress(function(event){  
       var keycode = (event.keyCode ? event.keyCode : event.which); 
      	if(keycode == '13'){  
        	llenarProducto();
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
	
//**************************AJAX*******************************
// Autor: Armando Viera Rodríguez
// Onixbm 2016

function buscar (busqueda){
	location.href='../consultar/vista.php?link=vista&busqueda='+busqueda+'&n1=movimientos&n2=consultarmovimientos';
}

function llenarSelectAlmacen(condicion){
		$("#idsucursal_ajax").html("<option value='1'>cargando...</option>");
		$.ajax({
			url: '../componentes/llenarSelectAlmacen.php',
			type: "POST",
			data: "submit=&condicion="+condicion, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#idsucursal_ajax").html(mensaje);
				$("#idsucursaldestino_ajax").html(mensaje);
			}
		});
		return false;
}

function llenarSelectEmpleado(condicion){
		$("#idempleado_ajax").html("<option value='1'>cargando...</option>");
		$.ajax({
			url: '../componentes/llenarSelectEmpleado.php',
			type: "POST",
			data: "submit=&condicion="+condicion, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#idempleado_ajax").html(mensaje);
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

function mostrarMensaje(mensaje){
	alert(mensaje);
	$("#mensaje").html(mensaje);
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
