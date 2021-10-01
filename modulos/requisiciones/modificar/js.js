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
			$("#ncontenidoneto").val(respuesta.contenidoneto);
			agregarProducto();
       });
}

function agregarProducto(){
			var idproductoV=$("#cidproducto").val();
			var idproductoV=$("#nidproducto").val();
			var codigoproductoV=$("#ccodigoproducto").val();
			var nombreproductoV=$("#nnombreproducto").val();
			var unidadV=$("#nunidad").val();
			var cantidadV=$("#ncantidad").val();
			var costoV=$("#ncosto").val();
			var costo2V=0;
			var montoV=costoV*cantidadV;
			var clasificacionV=$("#nclasificacion").val();
			var stockminimoV=$("#nstockminimo").val();
			var stockmaximoV=$("#nstockmaximo").val();
			var pesoteoricounitarioV=parseFloat ($("#npesoteorico").val());
			var pesoteoricoV=pesoteoricounitarioV*cantidadV;
			var pesorealV=$("#npesoreal").val();
			var existenciasV=$("#nexistencias").val();
			
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
						variables[7]=costo2V;
						variables[8]=montoV;
						variables[9]=pesoteoricounitarioV;
						variables[10]=pesorealV;
						variables[11]=pesoteoricoV;
						variables[12]=existenciasV;
						variables[13]=stockminimoV;
						variables[14]=stockmaximoV;
						variables[15]=clasificacionV;
						
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
		source: function(request, response){
			 $.ajax({
				url: "../componentes/buscarProductoNombre.php",
			 	dataType: "json",
				data: {
					term : request.term,
					idproveedor : $("#idproveedor").val()
				},
				success: function(data) {
					response(data);
				}
			}); 
		},
		autoFocus:true,
		select:function(event,ui){ 
        	$('#cidproducto').val(ui.item.id);
			$('#nunidad').val(ui.item.unidad);
			$('#ncosto').val(ui.item.costo);
			$('#consultaidproducto').val(ui.item.consulta);
			$('#nnombreproducto').val(ui.item.consulta);
			$('#ccodigoproducto').val(ui.item.codigo);
			$("#nidproducto").val(ui.item.idproducto);
			$("#nexistencias").val(ui.item.existencias);
			$("#npesoteorico").val(ui.item.pesoteorico);
			$("#nclasificacion").val(ui.item.clasificacion);
			$("#nstockminimo").val(ui.item.stockminimo);
			$("#nstockmaximo").val(ui.item.stockmaximo);
			$("#npesoreal").val(ui.item.pesoreal);
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
			agregarProducto();
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

function calcular(campo,id) {
	valor=$("#"+campo+id).val();
	valor=$.trim(valor);
	if (valor=="" || valor==0 || valor=="."){
		$("#"+campo+id).val("0.00");
	}
	if ($("#"+campo+id).val()==0){
		$("#"+campo+id).css("color","#F00");
	}else{
		$("#"+campo+id).css("color","#00F");
	}
	if (campo=="cant"){
		var cant=parseFloat ($("#cant"+id).val());
		var cost= parseFloat ($("#cost"+id).val());
		var montototal=cant*cost;
		
		var pesounitario= parseFloat ($("#pesoteoricounitario"+id).html());
		var pesoreal= parseFloat ($("#pesoreal"+id).html());
		var pesototal=0;
		//alert(pesounitario);
		if (pesoreal!=0){
			if (pesoreal<=pesounitario){
				pesototal=cant*pesoreal;
			}else{
				pesototal=cant*pesounitario;
			}
		}else if (pesounitario!=0){
			pesototal=cant*pesounitario;
		}else{
			pesototal=cant;
		}
		$("#monto"+id).text("$"+new Intl.NumberFormat("en-IN").format(montototal.toFixed(4)));
		if (pesounitario!=0 || pesoreal!=0){
			$("#pesoteorico"+id).val(pesototal.toFixed(4));
		}
	}
	
	if (campo=="cost"){
		var cant=parseFloat ($("#cant"+id).val());
		var cost= parseFloat ($("#cost"+id).val());
		var montototal=cant*cost;
		var pesounitario= parseFloat ($("#pesoteoricounitario"+id).html());
		var pesoreal= parseFloat ($("#pesoreal"+id).html());
		var cost2=0;
		if (pesoreal!=0){
			if (pesoreal<=pesounitario){
				cost2=cost/pesoreal;
			}else{
				cost2=cost/pesounitario;
			}
		}else if (pesounitario!=0){
			cost2=cost/pesounitario;
		}else{
			cost2=cost;
		}
		
		$("#monto"+id).text("$"+new Intl.NumberFormat("en-IN").format(montototal.toFixed(4)));
		if (pesounitario!=0 && pesoreal!=0){
			$("#cost2"+id).val(cost2.toFixed(4));
		}
	}
	
	if (campo=="cost2"){
		var cant=parseFloat ($("#cant"+id).val());
		var cost2= parseFloat ($("#cost2"+id).val());
		var pesounitario= parseFloat ($("#pesoteoricounitario"+id).html());
		var pesoreal= parseFloat ($("#pesoreal"+id).html());
		var cost=0;
		if (pesoreal!=0){
			if (pesoreal<=pesounitario){
				cost=cost2*pesoreal;
			}else{
				cost=cost2*pesounitario;
			}
		}else if (pesounitario!=0){
			cost=cost2*pesounitario;
		}else{
			cost=cost2;
		}
		var montototal=cant*cost;
		
		$("#monto"+id).text("$"+new Intl.NumberFormat("en-IN").format(montototal.toFixed(4)));
		$("#cost"+id).val(cost.toFixed(4));
	}
	
	if (campo=="pesoteorico"){
		var pesototal=parseFloat ($("#pesoteorico"+id).val());
		var cost2= parseFloat ($("#cost2"+id).val());
		
		var pesounitario= parseFloat ($("#pesoteoricounitario"+id).html());
		var pesoreal= parseFloat ($("#pesoreal"+id).html());
		var cant=0;
		if (pesoreal!=0){
			if (pesoreal<=pesounitario){
				cant=pesototal/pesoreal;
			}else{
				cant=pesototal/pesounitario;
			}
		}else if (pesounitario!=0){
			cant=pesototal/pesounitario;
		}else{
			cant=pesototal;
		}
		
		var montototal=pesototal*cost2;
		
		$("#monto"+id).text("$"+new Intl.NumberFormat("en-IN").format(montototal.toFixed(4)));
		$("#cant"+id).val(cant.toFixed(4));
	}
	
	recorrerTabla("tablaSalida","listaSalida");
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
			if (con==0){ //No
				nuevaFila=nuevaFila+"<td style='display:none'>";
				nuevaFila=nuevaFila+FILAS;
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==1){ // idproducto
				nuevaFila=nuevaFila+"<td style='display:none'>";
				nuevaFila=nuevaFila+elementos[con];
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==2){ // codigo
				nuevaFila=nuevaFila+"<td style='display:none'>";
				nuevaFila=nuevaFila+elementos[con];
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==3){ //nombre
				nuevaFila=nuevaFila+"<td class=\"columnaIzquierda\" style=\"border-left: 10px solid #909;\">";
					nuevaFila=nuevaFila+elementos[con]; 
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==4){ //unidad
				nuevaFila=nuevaFila+"<td>";
					nuevaFila=nuevaFila+elementos[con]; 
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==5){ //cantidad
				nuevaFila=nuevaFila+"<td>";
				nuevaFila=nuevaFila+"<input value='"+elementos[con]+"' name='cant"+FILAS+"' type='text' class='caja' id='cant"+FILAS+"' onblur=\"checarCeros('cant"+FILAS+"','"+FILAS+"')\" onkeyup=\"permitirDecimal('cant"+FILAS+"');\" onfocus=\"activarValidacion('cant"+FILAS+"');\" />";
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==6){ //costo pieza
				nuevaFila=nuevaFila+"<td>";
				nuevaFila=nuevaFila+"<input value='"+elementos[con]+"' name='cost"+FILAS+"' type='text' class='caja' id='cost"+FILAS+"' onblur=\"checarCeros('cost"+FILAS+"','"+FILAS+"')\" onkeyup=\"permitirDecimal('cost"+FILAS+"');\" onfocus=\"activarValidacion('cost"+FILAS+"');\" />";
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==7){ //costo kilo
				nuevaFila=nuevaFila+"<td>";
				nuevaFila=nuevaFila+"<input value='"+elementos[con]+"' name='cost2"+FILAS+"' type='text' class='caja' id='cost2"+FILAS+"' onblur=\"checarCeros2('cost2"+FILAS+"','"+FILAS+"')\" onkeyup=\"permitirDecimal('cost2"+FILAS+"');\" onfocus=\"activarValidacion('cost2"+FILAS+"');\" />";
				nuevaFila=nuevaFila+"</td>";
			}
			
			if (con==8){//Monto
				nuevaFila=nuevaFila+"<td id='monto"+FILAS+"'>";
					nuevaFila=nuevaFila+elementos[con]; 
				nuevaFila=nuevaFila+"</td>";
			}
			
			if (con==9){//Peso teorico unitario
				nuevaFila=nuevaFila+"<td id='monto"+FILAS+"'>";
					nuevaFila=nuevaFila+elementos[con]; 
				nuevaFila=nuevaFila+"</td>";
			}
			
			if (con==10){//Peso real
				nuevaFila=nuevaFila+"<td id='pesoteoricounitario"+FILAS+"'>";
					nuevaFila=nuevaFila+elementos[con]; 
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==11){//Peso teorico
				nuevaFila=nuevaFila+"<td>";
					nuevaFila=nuevaFila+"<input value='"+elementos[con]+"' name='pesoteorico"+FILAS+"' type='text' class='caja' id='pesoteorico"+FILAS+"' onblur=\"checarCeros2('pesoteorico"+FILAS+"','"+FILAS+"')\" onkeyup=\"permitirDecimal('pesoteorico"+FILAS+"');\" onfocus=\"activarValidacion('pesoteorico"+FILAS+"');\" />";
				nuevaFila=nuevaFila+"</td>";
			}
			
			if (con==12){ //Existencias
				nuevaFila=nuevaFila+"<td id='existancias"+FILAS+"'>";
					nuevaFila=nuevaFila+elementos[con]; 
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==13){ //Stock minimo
				nuevaFila=nuevaFila+"<td>";
					nuevaFila=nuevaFila+elementos[con]; 
				nuevaFila=nuevaFila+"</td>";
			}
			
			if (con==14){ //Stock maximo
				nuevaFila=nuevaFila+"<td id='stockmaximo"+FILAS+"'>";
					nuevaFila=nuevaFila+elementos[con]; 
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==15){ //Clasificacion
				nuevaFila=nuevaFila+"<td>";
					nuevaFila=nuevaFila+elementos[con]; 
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
	var no, idproducto, cantidad, costo, minimo, ubicacion, total=0, totalCosto=0, peso=0;
	var cadena;
	cadena="";
	$('#'+tabla+' tbody tr').each(function () {
		$(this).find('td').each(function (index,valor) {
			if (index==0){ //Numero
				no=$(valor).html();
			}
			if (index==1){ //Idproducto
				idproducto=$(valor).html();
			}
			if (index==5){
				cantidad=$("#cant"+no).val();
				if ($("#cant"+no).val()==0){
					$("#cant"+no).css('color', 'red');
				}else{
					$("#cant"+no).css('color', 'blue');
				}
				var stockMaximo=parseFloat($("#stockmaximo"+no).html());
				var existencias=parseFloat($("#existancias"+no).html());
				var totalAcumulado=parseFloat($("#cant"+no).val())+existencias;
				if (totalAcumulado > stockMaximo){
					$("#cant"+no).css('color', 'red');
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
			if (index==10){
				peso=peso+parseFloat($("#pesoteorico"+no).val());
			}
			//$(valor).css("background-color", "#ECF8E0");
		})
		if (cantidad!=0){
			cadena=cadena+idproducto+":::"+cantidad+":::"+costo+":::";
		}
	})
	$("#"+lista).val(cadena);
	$("#totalLista").html(total);
	$("#pesototal").val(peso);
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
	FILAS=0;
}
$(document).ready(function() {
	
	$("#panel_alertas").hide();
	llenarSelectSucursal(idsucursalSeleccionado,"");
	cargarTabla();
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
	
//**************************AJAX*******************************
// Autor: Armando Viera Rodríguez
// Onixbm 2016

function buscar (busqueda){
	location.href='../consultar/vista.php?link=vista&busqueda='+busqueda+'&n1=movimientos&n2=consultarmovimientos';
}

function llenarSelectSucursal(seleccionado,condicion){
		$("#idsucursal_ajax").html("<option value='1'>cargando...</option>");
		$.ajax({
			url: '../componentes/llenarSelectAlmacen.php',
			type: "POST",
			data: "submit=&condicion="+condicion+"&seleccionado="+seleccionado, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#idsucursal_ajax").html(mensaje);
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

function cargarTabla(){
		$("#botonGuardar").hide();
		$("#botonSave").hide();
		$("#loading").show();
		var idrequisicion=$("#cidrequisicion").val();
		$.ajax({
			url: 'consultardetalles.php',
			type: "POST",
			data: "submit=&idrequisicion="+idrequisicion, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#botonGuardar").show();
				$("#botonSave").show();
				$("#loading").hide();
				$("#filas").html(mensaje);
				recorrerTabla("tablaSalida","listaSalida");
			}
		});
		return false;
}

function mostrarMensaje(mensaje){
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
