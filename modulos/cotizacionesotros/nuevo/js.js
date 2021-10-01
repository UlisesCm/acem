// JS MODULA Autor: Armando Viera Rodriguez 2016

var FILAS = 0;

function vaciarCampos(){
		$("#cidcotizacionesotros").val("");
		$("#cserie").val("");
		$("#cfolio").val("");
		$("#cidcliente").val("");
		$("#autoidcliente").val("");
		$("#ctipo").val("");
		$("#cobservaciones").val("");
		//tabla
		FILAS = 0;
		$("#filas").html("");
		$("#listaSalida").val("");
		$("#csubtotal").val("0");
		$("#cimpuestos").val("0");
		$("#cmonto").val("0");
		agregarFila();//para que empieze con una fila agregada por default
	    //RECONSULTAR SERIE Y FOLIO
		obtenerSerie();
	    obtenerFolio();
		
	    $("#autoidcliente").focus();
}
		
		
$(document).ready(function() {
	
	$("#panel_alertas").hide();
	$(".loading").hide();
	//$("#panel_alertas").delay(8000).hide(600);
	
	obtenerSerie();
	obtenerFolio();
	//llenarSelectCliente("");
	llenarSelectSucursal("");
	llenarSelectEmpleado("");
	llenarSelectModeloimpuestos("");
	agregarFila();//para que empieze con una fila agregada por default
	
	//AUTOCOMPLETAR
	$( "#autoidcliente" ).autocomplete({
		
        source: "../componentes/buscarCliente.php",
		autoFocus:true,
		select:function(event,ui){
        	$('#cidcliente').val(ui.item.id);
			$('#consultaidcliente').val(ui.item.consulta);
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
	// FIN AUTOCOMPLETAR
	
	//AUTOCOMPLETAR
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
	
	
	
	
	
	$("#botonAceptar").click(function() {
			//if (Spry.Widget.Form.validate(formulario)){
				//if (validar()){
					//$("#cestado").val("ACEPTADA");
					var variables=$("#formulario").serialize();
					guardar(variables);
				//}
			//}
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
	
	 $("#idmodeloimpuestos_ajax").change(function(event){  
	   recorrerTabla('TablaServicios','listaSalida');
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


	
	
$(document).on("click",".eliminarFila",function(){
		var parent = $(this).parents().get(0);
		$(parent).remove();
		recorrerTabla("TablaServicios","listaSalida"); // Crea la cadena de productos que se enviara a timbrado
	});

function agregarFila(tabla, elementos, lista){
		//$("#ncantidad").val("1");
		var fechaActual = new Date();
		var dia = fechaActual.getDate();
		var mes = fechaActual.getMonth()+1;
		var anio = fechaActual.getFullYear();
		if (mes<10){
			mes="0"+mes;
		}
		if (dia<10){
			dia="0"+dia;
		}
		fechaActual = anio+"-"+mes+"-"+dia;
		FILAS=FILAS+1;
        var nuevaFila="<tr>";
		
				nuevaFila=nuevaFila+"<td style='display:none'>";
				nuevaFila=nuevaFila+FILAS;

				nuevaFila=nuevaFila+"<td id='lfecha"+FILAS+"'>";
				nuevaFila=nuevaFila+"<input name='fecha"+FILAS+"' type='date' class='caja' id='fecha"+FILAS+"' value= '"+fechaActual+"' onblur=\"recorrerTabla('TablaServicios','listaSalida')\"/>";
				nuevaFila=nuevaFila+"</td>";
		
				nuevaFila=nuevaFila+"<td>";
				nuevaFila=nuevaFila+"<input value='"+0+"' name='cantidad"+FILAS+"' type='text' class='caja' id='cantidad"+FILAS+"' onblur=\"checarCeros('cantidad"+FILAS+"','"+FILAS+"','TablaServicios')\" onkeypress=\"return soloNumeros(event,'cantidad"+FILAS+"');\" />";
				nuevaFila=nuevaFila+"</td>";
				
				nuevaFila=nuevaFila+"<td>";
				nuevaFila=nuevaFila+"<input name='servicio"+FILAS+"' type='text' class='caja' id='servicio"+FILAS+"' onblur=\"recorrerTabla('TablaServicios','listaSalida')\"/>";
				nuevaFila=nuevaFila+"</td>";
				
				nuevaFila=nuevaFila+"<td>";
				nuevaFila=nuevaFila+"<input name='unidad"+FILAS+"' type='text' class='caja' id='unidad"+FILAS+"' onblur=\"recorrerTabla('TablaServicios','listaSalida')\"/>";
				nuevaFila=nuevaFila+"</td>";
			
				nuevaFila=nuevaFila+"<td>";
				nuevaFila=nuevaFila+"<input value='"+0+"' name='precio"+FILAS+"' type='text' class='caja' id='precio"+FILAS+"' onblur=\"checarCeros('precio"+FILAS+"','"+FILAS+"','TablaServicios')\" onkeypress=\"return soloNumeros(event,'precio"+FILAS+"');\" />";
				nuevaFila=nuevaFila+"</td>";
			
				nuevaFila=nuevaFila+"<td id='limporte"+FILAS+"' name='limporte"+FILAS+"'>";
				nuevaFila=nuevaFila+"0.00";
				nuevaFila=nuevaFila+"</td>";
		
				nuevaFila=nuevaFila+"<td style='display:none' id='limpuestos"+FILAS+"' name='limpuestos"+FILAS+"'>";
				nuevaFila=nuevaFila+"0.00";
				nuevaFila=nuevaFila+"</td>";
		
		nuevaFila=nuevaFila+"<td title='Eliminar Fila' class='eliminarFila'><a class='btn btn-default btn-xs'><i class='fa fa-trash-o text-green'></i><a></td>";
		nuevaFila=nuevaFila+"</tr>"
		$("#filas").append(nuevaFila); //Coloca la fila al final de la tabla
		//$("#"+tabla).prepend(nuevaFila); //Coloca la fila al inicio de la tabla
		recorrerTabla('TablaServicios','listaSalida');
		
}

function recorrerTabla(tabla,lista){
	var no,fecha,servicio,precio,cantidad,importe,totalFila,unidad;
	var cadena;
	var subtotal=0, total=0, impuestos =0;
	cadena="";
	$('#'+tabla+' tbody tr').each(function () {
		$(this).find('td').each(function (index,valor) {
			if (index==0){
				no=$(valor).html();
			}
			if (index==1){
				fecha=$("#fecha"+no).val();
			}
			if (index==2){
				cantidad=$(valor).html();
			}
			if (index==3){
				servicio=$("#servicio"+no).val();
			}
			if (index==4){
				unidad=$("#unidad"+no).val();
			}
			if (index==5){
				precio=$("#precio"+no).val();//obtener el precio base para calculo de impuestos
				cantidad=$("#cantidad"+no).val();//obtener la cantidad para calculo de importe
				importe = precio * cantidad;
				$("#limporte"+no).html(importe);//asignar la suma de la cantida por el precio unitario a la celda importe de la fila
				
				impuestosFila=calcularImpuestosFila(importe,no);//calcular y asignar el valro del impuesto de esta fila
				totalFila = importe + impuestosFila;
				//alert(no);
				if ($("#precio"+no).val()==0){
					$("#precio"+no).css('color', 'red');
				}else{
					$("#precio"+no).css('color', 'blue');
					subtotal = parseFloat(subtotal) + parseFloat(importe);
					$("#csubtotal").val(subtotal);
				}
			}
		})
		cadena=cadena+no+":::"+fecha+":::"+cantidad+":::"+servicio+":::"+unidad+":::"+precio+":::"+totalFila+":::"+impuestosFila+":::";
	})
	
	calcularImpuestosyTotal();
	$("#"+lista).val(cadena);
	//$("#TablaServicios").tablesorter(); 
	//$("#TablaServicios").tablesorter( {sortList: [[5,0]]} ); 
    //$("#TablaServicios").sortTable("");
	//sortTable(5);
	//$("#TablaServicios").sortTable("number", {column: 5, reverse: false});
}

function calcularImpuestosFila(precio,no){
	var impuestocalculado = 0;
	if(precio ==""){
		$("#limpuestos"+no).html(impuestocalculado);//aignar 0 a la celda de impuestos que se va recorriendo
	}
	else{
		//consultaTasaImpuesto($("#idmodeloimpuestos_ajax").val());//envío el valor que quiero revisar en la base de datos que se irá pro la variable condicion
		//recibir resultado de función en arreglo de tasas hacer un ciclo por cada tasa multiplicar el importe y enviar resultado acumulado a caja de texto cimpuestos, el resultado de esta función lo arroja a la caja cTasas
		
		var impuestos=$("#idmodeloimpuestos_ajax").find('option:selected').attr("impuestos");
		var aimpuestos = impuestos.split(',');
		for(i=0; i<aimpuestos.length; i++){
			var aimpuesto = aimpuestos[i].split(':');
			//if()//Si es iva o ipes
			impuestocalculado = impuestocalculado + (precio * parseFloat(aimpuesto[1]));
		}
		$("#limpuestos"+no).html(impuestocalculado);//aignar la suma de los impuestos calculados
	}
	return impuestocalculado;
}

function calcularImpuestosyTotal(){
	if($("#csubtotal").val()==""){
		$("#csubtotal").val(0);
	}
	else{
		//consultaTasaImpuesto($("#idmodeloimpuestos_ajax").val());//envío el valor que quiero revisar en la base de datos que se irá pro la variable condicion
		//recibir resultado de función en arreglo de tasas hacer un ciclo por cada tasa multiplicar el importe y enviar resultado acumulado a caja de texto cimpuestos, el resultado de esta función lo arroja a la caja cTasas
		
		var impuestos=$("#idmodeloimpuestos_ajax").find('option:selected').attr("impuestos");
		var aimpuestos = impuestos.split(',');
		var impuestocalculado = 0;
		for(i=0; i<aimpuestos.length; i++){
			var aimpuesto = aimpuestos[i].split(':');
			//if()//Si es iva o ipes
			impuestocalculado = impuestocalculado + (parseFloat($("#csubtotal").val() * parseFloat(aimpuesto[1])));
		}
		
		$("#cimpuestos").val(impuestocalculado);
		$("#cmonto").val(parseFloat($("#csubtotal").val()) + parseFloat($("#cimpuestos").val()));
	}
}

function checarCeros(id,idtotal,campofuente) {
	campo=$("#"+id).val();
	campo=$.trim(campo);
	if (campo=="" || campo==0 || campo=="."){
		$("#"+id).val("0.00");
	}
	recorrerTabla('TablaServicios','listaSalida',campofuente);
}

//**************************AJAX*******************************
// Autor: Armando Viera Rodríguez
// Onixbm 2016

function buscar (busqueda){
	location.href='../consultar/vista.php?link=vista&busqueda='+busqueda+'&n1=cotizacionesotros&n2=consultarcotizacionesotros';
}

function obtenerSerie(){
		$("#cserie").val("Cargando...");
		$("#lserie").html("Cargando...");
		$.ajax({
			url: '../componentes/obtenerSerie.php',
			type: "POST",
			data: "", //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#cserie").val(mensaje);
				$("#lserie").html(mensaje);
			}
		});
		return false;
}

function obtenerFolio(){
		$("#cfolio").val("Cargando...");
		$.ajax({
			url: '../componentes/obtenerFolio.php',
			type: "POST",
			data: "", //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#cfolio").val(mensaje);
				$("#lfolio").html(mensaje);
			}
		});
		return false;
}

function llenarSelectCliente(condicion){
		$("#idcliente_ajax").html("<option value='1'>cargando...</option>");
		$.ajax({
			url: '../componentes/llenarSelectCliente.php',
			type: "POST",
			data: "submit=&condicion="+condicion, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#idcliente_ajax").html(mensaje);
			}
		});
		return false;
}
function llenarSelectSucursal(condicion){
		$("#idsucursal_ajax").html("<option value='1'>cargando...</option>");
		$.ajax({
			url: '../componentes/llenarSelectSucursal.php',
			type: "POST",
			data: "submit=&condicion="+condicion, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#idsucursal_ajax").html(mensaje);
			}
		});
		return false;
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
		$("#loading").show();
		$.ajax({
			url: 'guardar.php',
			type: "POST",
			data: "submit=&"+variables, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#botonGuardar").show();
				$("#loading").hide();
				mostrarMensaje(mensaje);
			}
		});
		return false;
}

function mostrarMensaje(mensaje){
	//alert(mensaje);
	var cadena= $.trim(mensaje); //Limpia la cadena regresada desde php
	$("#Mensaje").html(mensaje);
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
