// JS MODULA Autor: Armando Viera Rodriguez 2016
FILAS = 0;
function vaciarCampos(){
	$("#cidcuentaprincipal").focus();
	//tabla productos
		FILAS = 0;
		$("#filas").html("");
		$("#listaSalida").val("");
}
$(document).ready(function() {
	
	$("#panel_alertas").hide();
	$(".loading").hide();
	//$("#panel_alertas").delay(8000).hide(600);
	
	llenarSelectSucursal("");
	agregarFila();
	
	
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

function checarCeros(id,campofuente) {
	campo=$("#"+id).val();
	campo=$.trim(campo);
	if (campo=="" || campo==0 || campo=="."){
		$("#"+id).val("0.00");
	}
	recorrerTabla('TablaGastos','listaSalida',campofuente);
}

function agregarFila(){
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
				
				nuevaFila=nuevaFila+"<td id='lfechafactura"+FILAS+"'>";
				nuevaFila=nuevaFila+"<input name='fechafactura"+FILAS+"' type='date' class='caja' id='fechafactura"+FILAS+"' value= '"+fechaActual+"' onblur=\"recorrerTabla('TablaGastos','listaSalida','fechafactura')\"/>";
				nuevaFila=nuevaFila+"</td>";
				
				nuevaFila=nuevaFila+"<td id='lfechavencimiento"+FILAS+"'>";
				nuevaFila=nuevaFila+"<input name='fechavencimiento"+FILAS+"' type='date' class='caja' id='fechavencimiento"+FILAS+"' value= '"+fechaActual+"' onblur=\"recorrerTabla('TablaGastos','listaSalida','fechavencimiento')\"/>";
				nuevaFila=nuevaFila+"</td>";
				
				nuevaFila=nuevaFila+"<td>";
				nuevaFila=nuevaFila+"<select name='cuentaprincipal"+FILAS+"' class='caja' id='cuentaprincipal"+FILAS+"' onblur=\"recorrerTabla('TablaGastos','listaSalida','cuentaprincipal'),llenarSelectCuentasecundaria('',FILAS)\"> </select>";
				nuevaFila=nuevaFila+"</td>";
				
				nuevaFila=nuevaFila+"<td>";
				nuevaFila=nuevaFila+"<select name='cuentasecundaria"+FILAS+"' class='caja' id='cuentasecundaria"+FILAS+"' onblur=\"recorrerTabla('TablaGastos','listaSalida','cuentasecundaria')\"> </select>";
				nuevaFila=nuevaFila+"</td>";
				
				nuevaFila=nuevaFila+"<td>";
				nuevaFila=nuevaFila+"<input name='descripcion"+FILAS+"' type='text' value='' class='caja' id='descripcion"+FILAS+"' onblur=\"recorrerTabla('TablaGastos','listaSalida','descripcion')\"/>";
				nuevaFila=nuevaFila+"</td>";
				
				nuevaFila=nuevaFila+"<td>";
				nuevaFila=nuevaFila+"<select name='proveedor"+FILAS+"' class='caja' id='proveedor"+FILAS+"' onblur=\"recorrerTabla('TablaGastos','listaSalida','cuentasecundaria')\"></select>";
				nuevaFila=nuevaFila+"</td>";
				
				nuevaFila=nuevaFila+"<td>";
				nuevaFila=nuevaFila+"<input name='beneficiario"+FILAS+"' type='text' value='' class='caja' id='beneficiario"+FILAS+"' onblur=\"recorrerTabla('TablaGastos','listaSalida','beneficiario')\"/>";
				nuevaFila=nuevaFila+"</td>";
				
				nuevaFila=nuevaFila+"<td>";
				nuevaFila=nuevaFila+"<input name='factura"+FILAS+"' type='text' value='' class='caja' id='factura"+FILAS+"' onblur=\"recorrerTabla('TablaGastos','listaSalida','descripcion')\"/>";
				nuevaFila=nuevaFila+"</td>";
				
				nuevaFila=nuevaFila+"<td>";
				nuevaFila=nuevaFila+"<select name='modeloimpuestos"+FILAS+"' class='caja' id='modeloimpuestos"+FILAS+"' onblur=\"recorrerTabla('TablaGastos','listaSalida','cuentasecundaria')\"></select>";
				nuevaFila=nuevaFila+"</td>";
				
				nuevaFila=nuevaFila+"<td>";
				nuevaFila=nuevaFila+"<input value='"+0+"' name='subtotal"+FILAS+"' type='text' style='text-align: right;' class='caja' id='subtotal"+FILAS+"' onblur=\"recorrerTabla('TablaGastos','listaSalida','subtotal'),checarCeros('subtotal"+FILAS+"','subtotal')\" onkeypress=\"return soloNumeros(event,'subtotal"+FILAS+"');\"/>";
				nuevaFila=nuevaFila+"</td>";
				
				nuevaFila=nuevaFila+"<td id='impuestos"+FILAS+"' name='impuestos"+FILAS+"' style='text-align: right;'>";
				nuevaFila=nuevaFila+0.00;
				nuevaFila=nuevaFila+"</td>";
				
				nuevaFila=nuevaFila+"<td>";
				nuevaFila=nuevaFila+"<input value='"+0+"' name='total"+FILAS+"' type='text' style='text-align: right;' class='caja' id='total"+FILAS+"' onblur=\"recorrerTabla('TablaGastos','listaSalida','total'),checarCeros('total"+FILAS+"','total')\" onkeypress=\"return soloNumeros(event,'total"+FILAS+"');\"/>";
				nuevaFila=nuevaFila+"</td>";
				
				
				
				
		nuevaFila=nuevaFila+"<td title='Eliminar Fila' class='eliminarFila'><a class='btn btn-default btn-xs'><i class='fa fa-trash-o text-green'></i><a></td>";
		nuevaFila=nuevaFila+"</tr>"
		$("#filas").append(nuevaFila); //Coloca la fila al final de la tabla
		llenarSelectCuentaprincipal("",FILAS);
		llenarSelectProveedor("",FILAS);
		llenarSelectModeloimpuestos("",FILAS);
		//$("#"+tabla).prepend(nuevaFila); //Coloca la fila al inicio de la tabla
		//recorrerTabla('TablaGastos','listaSalida');
}

function recorrerTabla(tabla,lista,campoFuente){
	var no,fechafactura,fechavencimiento,idcuentaprincipal,idcuentasecundaria,descripcion,idproveedor,beneficiario,factura,idmodeloimpuestos,subtotal,impuestosFila,total;
	var cadena;
	var SumaTotal = 0;
	var subtotal=0, total=0, impuestos =0;
	cadena="";
	$('#'+tabla+' tbody tr').each(function () {
		$(this).find('td').each(function (index,valor) {
			if (index==0){
				no=$(valor).html();
			}
			if (index==12  && campoFuente == "total"){//cuentaprincipal
			    //consultar las cuentas secundarias
				fechafactura=$("#fechafactura"+no).val();
				fechavencimiento=$("#fechavencimiento"+no).val();
				idcuentaprincipal=$("#cuentaprincipal"+no).val();
				idcuentasecundaria=$("#cuentasecundaria"+no).val();
				descripcion=$("#descripcion"+no).val();
				idproveedor=$("#proveedor"+no).val();
				beneficiario=$("#beneficiario"+no).val();
				factura=$("#factura"+no).val();
				idmodeloimpuestos=$("#modeloimpuestos"+no).val();
				total=$("#total"+no).val();
				
				//calcular impuestos
				impuestosFila=desglosarImpuestosFila(total,no);//calcular y asignar el valro del impuesto de esta fila
				subtotal = parseFloat(total) - parseFloat(impuestosFila);
				$("#subtotal"+no).val(subtotal);
				
				//alert(no);
				if ($("#total"+no).val()==0){
					$("#subtotal"+no).css('color', 'red');
					$("#total"+no).css('color', 'red');
				}else{
					$("#subtotal"+no).css('color', 'blue');
					$("#total"+no).css('color', 'blue');
				}$("#total"+no).css('color', 'blue');
			}
			if (campoFuente != "total"){
			    //consultar las cuentas secundarias
				fechafactura=$("#fechafactura"+no).val();
				fechavencimiento=$("#fechavencimiento"+no).val();
				idcuentaprincipal=$("#cuentaprincipal"+no).val();
				idcuentasecundaria=$("#cuentasecundaria"+no).val();
				descripcion=$("#descripcion"+no).val();
				idproveedor=$("#proveedor"+no).val();
				beneficiario=$("#beneficiario"+no).val();
				factura=$("#factura"+no).val();
				idmodeloimpuestos=$("#modeloimpuestos"+no).val();
				subtotal=$("#subtotal"+no).val();
				//calcular impuestos
				impuestosFila=calcularImpuestosFila(subtotal,no);//calcular y asignar el valro del impuesto de esta fila
				totalFila = parseFloat(subtotal) + parseFloat(impuestosFila);
				$("#total"+no).val(totalFila);
				total=$("#total"+no).val();
				//alert(no);
				if ($("#total"+no).val()==0){
					$("#subtotal"+no).css('color', 'red');
					$("#total"+no).css('color', 'red');
				}else{
					$("#subtotal"+no).css('color', 'blue');
					$("#total"+no).css('color', 'blue');
				}$("#total"+no).css('color', 'blue');
			}
		})
		SumaTotal = parseFloat(SumaTotal) + parseFloat(total);
		cadena=cadena+no+":::"+fechafactura+":::"+fechavencimiento+":::"+idcuentaprincipal+":::"+idcuentasecundaria+":::"+descripcion+":::"+idproveedor+":::"+beneficiario+":::"+factura+":::"+idmodeloimpuestos+":::"+subtotal+":::"+impuestosFila+":::"+total+":::";
		
	})
	$("#ctotal").val(parseFloat(SumaTotal).toFixed(2));
	//calcularImpuestosyTotal();
		
	$("#"+lista).val(cadena);
	//$("#TablaServicios").tablesorter(); 
	//$("#TablaServicios").tablesorter( {sortList: [[5,0]]} ); 
    //$("#TablaServicios").sortTable("");
	//sortTable(5);
	//$("#TablaServicios").sortTable("number", {column: 5, reverse: false});
}

function desglosarImpuestosFila(importe,no){
	var impuestodesglosado = 0;
	if(importe ==""){
		$("#impuestos"+no).html(impuestodesglosado);//aignar 0 a la celda de impuestos que se va recorriendo
	}
	else{
		//consultaTasaImpuesto($("#idmodeloimpuestos_ajax").val());//envío el valor que quiero revisar en la base de datos que se irá pro la variable condicion
		//recibir resultado de función en arreglo de tasas hacer un ciclo por cada tasa multiplicar el importe y enviar resultado acumulado a caja de texto cimpuestos, el resultado de esta función lo arroja a la caja cTasas
		
		var impuestos=$("#modeloimpuestos"+no).find('option:selected').attr("impuestos");
		var aimpuestos = impuestos.split(',');
		for(i=0; i<aimpuestos.length; i++){
			var aimpuesto = aimpuestos[i].split(':');
			//if()//Si es iva o ipes
			impuestodesglosado = impuestodesglosado + (importe - (importe / (1 + parseFloat(aimpuesto[1]))));
		}
		$("#impuestos"+no).html(impuestodesglosado);//aignar la suma de los impuestos calculados
	}
	return impuestodesglosado;
}

function calcularImpuestosFila(subtotal,no){
	var impuestocalculado = 0;
	/*if(precio ==""){
		$("#limpuestos"+no).html(impuestocalculado);//aignar 0 a la celda de impuestos que se va recorriendo
	}
	else{*/
		//consultaTasaImpuesto($("#idmodeloimpuestos_ajax").val());//envío el valor que quiero revisar en la base de datos que se irá pro la variable condicion
		//recibir resultado de función en arreglo de tasas hacer un ciclo por cada tasa multiplicar el importe y enviar resultado acumulado a caja de texto cimpuestos, el resultado de esta función lo arroja a la caja cTasas
		var impuestos=$("#modeloimpuestos"+no).find('option:selected').attr("impuestos");
		var aimpuestos = impuestos.split(',');
		for(i=0; i<aimpuestos.length; i++){
			var aimpuesto = aimpuestos[i].split(':');
			//if()//Si es iva o ipes
			impuestocalculado = impuestocalculado + (subtotal * parseFloat(aimpuesto[1]));
		}
		$("#impuestos"+no).html(impuestocalculado);//aignar la suma de los impuestos calculados
	//}
	return impuestocalculado;
}

function calcularImpuestosyTotal(){
	if($("#csubtotalotros").val()==""){
		$("#csubtotalotros").val(0);
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
			impuestocalculado = impuestocalculado + (parseFloat($("#csubtotalotros").val() * parseFloat(aimpuesto[1])));
		}
		
		$("#cimpuestosotros").val(impuestocalculado);
		$("#limpuestosotros").html(impuestocalculado.toFixed(2));
		$("#cmontootros").val(parseFloat($("#csubtotalotros").val()) + parseFloat($("#cimpuestosotros").val()));
		var totalotros = parseFloat($("#cmontootros").val());
		$("#ltotalotros").html(totalotros.toFixed(2));
		
	}
}


//**************************AJAX*******************************
// Autor: Armando Viera Rodríguez
// Onixbm 2016

function buscar (busqueda){
	location.href='../consultar/vista.php?link=vista&busqueda='+busqueda+'&n1=gastos&n2=consultargastos';
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

function llenarSelectCuentaprincipal(condicion,no){
		$("#cuentaprincipal"+no).html("<option value='1'>cargando...</option>");
		$.ajax({
			url: '../componentes/llenarSelectCuentaprincipal.php',
			type: "POST",
			data: "submit=&condicion="+condicion, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#cuentaprincipal"+no).html(mensaje);
			}
		});
		return false;
}
function llenarSelectCuentasecundaria(condicion,no){
		condicion = $("#cuentaprincipal"+no).val();
		$("#cuentasecundaria"+no).html("<option value='1'>cargando...</option>");
		$.ajax({
			url: '../componentes/llenarSelectCuentasecundaria.php',
			type: "POST",
			data: "submit=&condicion="+condicion, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#cuentasecundaria"+no).html(mensaje);
			}
		});
		return false;
}
function llenarSelectProveedor(condicion,no){
		$("#proveedor"+no).html("<option value='1'>cargando...</option>");
		$.ajax({
			url: '../componentes/llenarSelectProveedor.php',
			type: "POST",
			data: "submit=&condicion="+condicion, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#proveedor"+no).html(mensaje);
			}
		});
		return false;
}
function llenarSelectModeloimpuestos(condicion,no){
		$("#modeloimpuestos"+no).html("<option value='1'>cargando...</option>");
		$.ajax({
			url: '../componentes/llenarSelectModeloimpuestos.php',
			type: "POST",
			data: "submit=&condicion="+condicion, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#modeloimpuestos"+no).html(mensaje);
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
	//alert(mensaje);
	//$("#salida").html(mensaje);
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
