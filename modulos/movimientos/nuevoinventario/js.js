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
	$("#autoidproducto").keypress(function(event){ 
		var keycode = (event.keyCode ? event.keyCode : event.which); 
      	if(keycode == '13'){
			llenarProducto();
		}
    });
	// FIN AUTOCOMPLETAR
	
	//AUTOCOMPLETAR
	$("#cpass").keypress(function(event){ 
		var keycode = (event.keyCode ? event.keyCode : event.which); 
      	if(keycode == '13'){
			if (validarConfirmacion()){
					if (validar()){
						var variables=$("#formulario").serialize();
						guardar(variables);
					}
			}else{
				$("#modal-confirmacion").modal();
			}
		}
    });
	// FIN AUTOCOMPLETAR
	
	$("#botonAgregarFila").click(function() {
		if ($("#cidproducto").val()==0 || $("#cidproducto").val()==""){
			llenarProducto();
		}	
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
				nuevaFila=nuevaFila+"<td class=\"columnaIzquierda\" style=\"border-left: 10px solid #25c274;\">";
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
			if (con==6){
				nuevaFila=nuevaFila+"<td>";
				nuevaFila=nuevaFila+"<input value='"+elementos[con]+"' name='cost"+FILAS+"' type='text' class='caja' id='cost"+FILAS+"' onblur=\"checarCeros('cost"+FILAS+"','"+FILAS+"')\" onkeyup=\"permitirDecimal('cost"+FILAS+"');\" onfocus=\"activarValidacion('cost"+FILAS+"');\" />";
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==7){
				nuevaFila=nuevaFila+"<td>";
				nuevaFila=nuevaFila+"<input value='"+elementos[con]+"' name='minimo"+FILAS+"' type='text' class='caja' id='minimo"+FILAS+"' onblur=\"checarCeros('minimo"+FILAS+"','"+FILAS+"')\" onkeyup=\"permitirDecimal('minimo"+FILAS+"');\" onfocus=\"activarValidacion('minimo"+FILAS+"');\" />";
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==8){
				nuevaFila=nuevaFila+"<td>";
				nuevaFila=nuevaFila+"<input value='"+elementos[con]+"' name='ubicacion"+FILAS+"' type='text' class='caja' id='ubicacion"+FILAS+"' onblur=\"checarCeros('ubicacion"+FILAS+"','"+FILAS+"')\" />";
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
	var no, idproducto, cantidad, costo, minimo, ubicacion, total=0, totalCosto=0;
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
			if (index==6){
				costo=$("#cost"+no).val();
				if ($("#cost"+no).val()==0){
					$("#cost"+no).css('color', 'red');
				}else{
					$("#cost"+no).css('color', 'blue');
				}
				totalCosto=parseFloat(costo*cantidad)+totalCosto;
			}
			if (index==7){
				minimo=$("#minimo"+no).val();
			}
			if (index==8){
				ubicacion=$("#ubicacion"+no).val();
			}
			//$(valor).css("background-color", "#ECF8E0");
		})
		cadena=cadena+idproducto+":::"+cantidad+":::"+costo+":::"+minimo+":::"+ubicacion+":::";
	})
	$("#"+lista).val(cadena);
	$("#totalLista").html(total);
	totalCosto2=totalCosto.toFixed(2);
	$("#totalLista2").html("$"+totalCosto2);
}
//FIN DE FUNCIONES DE LLANDO DE TABLA DE INFERIOR






function vaciarCampos(){
	$("#cnumerocomprobante").val("");
	$("#ccomentarios").val("");
	$("#cconcepto").focus();
	$("#filas").html("");
	$("#listaSalida").val("");
	$("#totalLista").html("0");
	$("#cpass").val("");
	$("#csupervisor").val("");
	FILAS=0;
}
$(document).ready(function() {
	
	$("#panel_alertas").hide();
	llenarSelectAlmacen("");
	llenarSelectProveedores("");
	$(".loading").hide();
	//$("#panel_alertas").delay(8000).hide(600);
	
	$("#cconcepto").change(function() {
		//Inicializamos valores
		$(".EB").show();
		$(".COMPRA").hide();
		$("#botonProcesar").hide();
		$("ajax_resultado").html("");
		
		if ($(this).val()=="TRASPASO"){
			$(".EB").hide();
			$("#botonProcesar").show();
		}
		if ($(this).val()=="CONSIGNACION A CLIENTE"){
			$(".EB").hide();
			$("#botonProcesar").show();
		}
		if ($(this).val()=="CONSIGNACION A VENDEDOR"){
			$(".EB").hide();
			$("#botonProcesar").show();
		}
		if ($(this).val()=="ORDEN DE COMPRA"){
			$(".EB").show();
			$(".COMPRA").show();
		}
		
	});
	
	$("#botonProcesar").click(function() {
			var variables=$("#formulario").serialize();
			procesar(variables);
	});
	
	$("#botonContinuar").click(function() {
				$("#modal-confirmacion").modal();
				$("#cpass").focus();
	});
	
	$("#botonGuardar").click(function() {
		if (validarConfirmacion()){
				if (validar()){
					var variables=$("#formulario").serialize();
					guardar(variables);
				}
		}else{
			$("#modal-confirmacion").modal();
		}
	});
	$(".botonSave").click(function() {
		if (validarConfirmacion()){
				if (validar()){
					var variables=$("#formulario").serialize();
					guardar(variables);
				}
		}else{
			$("#modal-confirmacion").modal();
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
	
	
	
	$("#ncantidad").keypress(function(event){  
       var keycode = (event.keyCode ? event.keyCode : event.which); 
      	if(keycode == '13'){  
        	llenarProducto();
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

function validarConfirmacion(){
	var estado=false;
	var pass=$("#cpass").val();
	if (pass=="mia8701"){
		$("#csupervisor").val("Andrei");
		estado=true;
		var mensaje="";
	}else if(pass=="go3569"){
		$("#csupervisor").val("Diego");
		estado=true;
		var mensaje="";
	}else{
		alert("La contraseña no es correcta");
		$("#cpass").val("");
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
		$("#idalmacen_ajax").html("<option value='1'>cargando...</option>");
		$.ajax({
			url: '../componentes/llenarSelectAlmacen.php',
			type: "POST",
			data: "submit=&condicion="+condicion, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#idalmacen_ajax").html(mensaje);
			}
		});
		return false;
}

function llenarSelectProveedores(condicion){
		$("#idproveedor_ajax").html("<option value='1'>cargando...</option>");
		$.ajax({
			url: '../componentes/llenarSelectProveedor.php',
			type: "POST",
			data: "submit=&condicion="+condicion, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#idproveedor_ajax").html(mensaje);
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

function procesar(variables){
		$("#botonGuardar").hide();
		$("#botonProcesar").hide();
		$("#botonSave").hide();
		$("#loading").show();
		$(".tablita").hide();
		$.ajax({
			url: 'procesar.php',
			type: "POST",
			data: "submit=&"+variables, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#botonGuardar").show();
				$("#botonProcesar").show();
				$("#botonSave").show();
				$("#loading").hide();
				$("#ajax_resultado").html(mensaje);
				if (mensaje.substring(0,8)!="<!--x-->"){
					$(".tablita").show();
				}
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
