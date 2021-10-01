// JS MODULA Autor: Armando Viera Rodriguez 2016
function vaciarCampos(){
	consultarSaldoSucursal("efectivo","lefectivo");
	consultarSaldoSucursal("tarjetadedebito","ltarjetadedebito");
	consultarSaldoSucursal("tarjetadecredito","ltarjetadecredito");
	consultarSaldoSucursal("cheques","lcheques");
	consultarSaldoSucursal("transferencias","ltransferencias");
	consultarSaldoSucursal("depositos","ldepositos");
	consultarSaldoSucursal("notasdecredito","lnotasdecredito");
	load_tablas();
	//cajas de texto
	$("#billetes1000").val(0);
	$("#billetes500").val(0);
	$("#billetes200").val(0);
	$("#billetes100").val(0);
	$("#billetes50").val(0);
	$("#billetes20").val(0);
	$("#monedas10").val(0);
	$("#monedas5").val(0);
	$("#monedas2").val(0);
	$("#monedas1").val(0);
	$("#monedas50c").val(0);
	//etiquetas
	$("#lbilletes1000").html(0);
	$("#lbilletes500").html(0);
	$("#lbilletes200").html(0);
	$("#lbilletes100").html(0);
	$("#lbilletes50").html(0);
	$("#lbilletes20").html(0);
	$("#lmonedas10").html(0);
	$("#lmonedas5").html(0);
	$("#lmonedas2").html(0);
	$("#lmonedas1").html(0);
	$("#lmonedas50c").html(0);
	
	//totales
	$("#sumaEfectivo").val(0);
	$("#ldiferencia").html(0);
	
	
	//etiquetas restantes
	$("#lefectivorestante").html(0);
	$("#ltarjetadedebitorestante").html(0);
	$("#ltarjetadecreditorestante").html(0);
	$("#lchequesrestante").html(0);
	$("#ltransferenciasrestante").html(0);
	$("#ldepositosrestante").html(0);
	$("#lnotasdecreditorestante").html(0);
	$("#ltotalrestante").html(0);
	
	//etiquetas total
	$("#lefectivototal").html(0);
	$("#ltarjetadedebitototal").html(0);
	$("#ltarjetadecreditototal").html(0);
	$("#lchequestotal").html(0);
	$("#ltransferenciastotal").html(0);
	$("#ldepositostotal").html(0);
	$("#lnotasdecreditototal").html(0);
	$("#ltotaltotal").html(0);
	$("#totalaentregar").val(0);
	
}

function calcularConteo(idcampo,valor) {
	campo=$("#"+idcampo).val();
	
	if (campo=="" || campo==0){
		$("#"+idcampo).val(0);
	}
	cantidad= parseInt ($("#"+idcampo).val());
	var total=cantidad*valor;
	$("#l"+idcampo).html("$ "+total);
	
	var dinero=0;
	var billetes1000=parseInt ($("#billetes1000").val())*1000;
	var billetes500=parseInt ($("#billetes500").val())*500;
	var billetes200=parseInt ($("#billetes200").val())*200;
	var billetes100=parseInt ($("#billetes100").val())*100;
	var billetes50=parseInt ($("#billetes50").val())*50;
	var billetes20=parseInt ($("#billetes20").val())*20;
	var monedas10=parseInt ($("#monedas10").val())*10;
	var monedas5=parseInt ($("#monedas5").val())*5;
	var monedas2=parseInt ($("#monedas2").val())*2;
	var monedas1=parseInt ($("#monedas1").val())*1;
	var monedas50c=parseInt ($("#monedas50c").val())*0.5;
	
	dinero=billetes1000+billetes500+billetes200+billetes100+billetes50+billetes20+monedas10+monedas5+monedas2+monedas1+monedas50c;
	$("#sumaEfectivo").val(dinero);
	/*dineroTeorico=parseFloat ($("#totalEfectivo").val());
	diferencia=dinero-dineroTeorico;
	diferencia=diferencia.toFixed(2);
	$("#diferencia").val(diferencia);
	if (diferencia < 0){
		$("#ldiferencia").html("<span style='color:red'>$ "+diferencia+"</span>");
	}
	if (diferencia >= 0){
		$("#ldiferencia").html("<span style='color:green'>$ "+diferencia+"</span>");
	}*/
	
	$("#ldiferencia").html(parseFloat($("#ctotalefectivo").val())- parseFloat($("#sumaEfectivo").val()));
	$("#diferencia").val(parseFloat($("#ctotalefectivo").val())- parseFloat($("#sumaEfectivo").val()));
	var diferencia = parseFloat($("#ldiferencia").html());
	if (diferencia != 0){
		$("#ldiferencia").html("<span style='color:red'>$ "+diferencia+"</span>");
	}
	else{
		$("#ldiferencia").html("<span style='color:green'>$ "+diferencia+"</span>");
	}
}

function calcularDiferencia(idcampo) {
	/*campo=$("#"+idcampo).val();
	if (campo=="" || campo==0){
		$("#"+idcampo).val(0);
	}
	var dinero=0;
	dinero=parseFloat ($("#sumaEfectivo").val());
	dineroTeorico=parseFloat ($("#totalEfectivo").val());
	diferencia=dinero-dineroTeorico;
	diferencia=diferencia.toFixed(2);
	$("#diferencia").val(diferencia);
	if (diferencia < 0){
		$("#ldiferencia").html("<span style='color:red'>$ "+diferencia+"</span>");
	}
	if (diferencia >= 0){
		$("#ldiferencia").html("<span style='color:green'>$ "+diferencia+"</span>");
	}*/
	
	$("#ldiferencia").html(parseFloat($("#ctotalefectivo").val())- parseFloat($("#sumaEfectivo").val()));
	
	
	var diferencia = parseFloat($("#ldiferencia").html());
	if (diferencia != 0){
		$("#ldiferencia").html("<span style='color:red'>$ "+diferencia+"</span>");
	}
	else{
		$("#ldiferencia").html("<span style='color:green'>$ "+diferencia+"</span>");
	}
}

function seleccionarTodoEfectivo(){
	if ($("#seleccionartodoefectivo").prop("checked")==true){
		$(".checkEfectivo").prop("checked", "checked");
	}else{
		$(".checkEfectivo").prop("checked", "");
	}   
	recorrerTablaEfectivo("tablaEfectivo","listaSalidaEfectivo");
}

function recorrerTablaEfectivo(tabla,lista){
	var id;
	var cadena;
	var total = 0;
	var no=-1;
	cadena="";
	$('#'+tabla+' tbody tr').each(function () {
		$(this).find('td').each(function (index,valor) {
			if (index==1){
				id=$(valor).html();
			}
			if (index==3 ){//total
				if ($("#checkefectivo"+no).prop("checked")==true){
					total = parseFloat(total)+ parseFloat($("#totalefectivo"+no).html());
					cadena=cadena+id+",";
				}
			}
		})
		no++;
		
	})
	
	$("#ctotalefectivo").val(total);
	
	
	calcularTotales();
	
	$("#"+lista).val(cadena);
}

function seleccionarTodoCheques(){
	if ($("#seleccionartodocheques").prop("checked")==true){
		$(".checkCheques").prop("checked", "checked");
	}else{
		$(".checkCheques").prop("checked", "");
	}   
	recorrerTablaCheques("tablaCheques","listaSalidaCheques");
}

function recorrerTablaCheques(tabla,lista){
	var id;
	var cadena;
	var total = 0;
	var no=-1;
	cadena="";
	$('#'+tabla+' tbody tr').each(function () {
		$(this).find('td').each(function (index,valor) {
			if (index==1){
				id=$(valor).html();
			}
			if (index==3 ){//total
				if ($("#checkcheques"+no).prop("checked")==true){
					total = parseFloat(total)+ parseFloat($("#totalcheques"+no).html());
					cadena=cadena+id+",";
				}
			}
		})
		no++;
		
	})
	
	$("#ctotalcheque").val(total);
	
	
	calcularTotales();
	
	$("#"+lista).val(cadena);
}

function seleccionarTodoTarjetadedebito(){
	if ($("#seleccionartodotarjetadedebito").prop("checked")==true){
		$(".checkTarjetadedebito").prop("checked", "checked");
	}else{
		$(".checkTarjetadedebito").prop("checked", "");
	}   
	recorrerTablaTarjetadedebito("tablaTarjetadedebito","listaSalidaTarjetadedebito");
}

function recorrerTablaTarjetadedebito(tabla,lista){
	var id;
	var cadena;
	var total = 0;
	var no=-1;
	cadena="";
	$('#'+tabla+' tbody tr').each(function () {
		$(this).find('td').each(function (index,valor) {
			if (index==1){
				id=$(valor).html();
			}
			if (index==4 ){//total
				if ($("#checktarjetadedebito"+no).prop("checked")==true){
					total = parseFloat(total)+ parseFloat($("#totaltarjetadedebito"+no).html());
					cadena=cadena+id+",";
				}
			}
		})
		no++;
		
	})
	$("#ctotaltarjetadedebito").val(total);
	
	
	calcularTotales();
	
	$("#"+lista).val(cadena);
}

function seleccionarTodoTarjetadecredito(){
	if ($("#seleccionartodotarjetadecredito").prop("checked")==true){
		$(".checkTarjetadecredito").prop("checked", "checked");
	}else{
		$(".checkTarjetadecredito").prop("checked", "");
	}   
	recorrerTablaTarjetadecredito("tablaTarjetadecredito","listaSalidaTarjetadecredito");
}

function recorrerTablaTarjetadecredito(tabla,lista){
	var id;
	var cadena;
	var total = 0;
	var no=-1;
	cadena="";
	$('#'+tabla+' tbody tr').each(function () {
		$(this).find('td').each(function (index,valor) {
			if (index==1){
				id=$(valor).html();
			}
			if (index==3 ){//total
				if ($("#checktarjetadecredito"+no).prop("checked")==true){
					total = parseFloat(total)+ parseFloat($("#totaltarjetadecredito"+no).html());
					cadena=cadena+id+",";
				}
			}
		})
		no++;
		
	})
	
	$("#ctotaltarjetacredito").val(total);
	
	
	calcularTotales();
	
	$("#"+lista).val(cadena);
}

function seleccionarTodoTransferencias(){
	if ($("#seleccionartodotransferencias").prop("checked")==true){
		$(".checkTransferencias").prop("checked", "checked");
	}else{
		$(".checkTransferencias").prop("checked", "");
	}   
	recorrerTablaTransferencias("tablaTransferencias","listaSalidaTransferencias");
}

function recorrerTablaTransferencias(tabla,lista){
	var id;
	var cadena;
	var total = 0;
	var no=-1;
	cadena="";
	$('#'+tabla+' tbody tr').each(function () {
		$(this).find('td').each(function (index,valor) {
			if (index==1){
				id=$(valor).html();
			}
			if (index==3 ){//total
				if ($("#checktransferencias"+no).prop("checked")==true){
					total = parseFloat(total)+ parseFloat($("#totaltransferencias"+no).html());
					cadena=cadena+id+",";
				}
			}
		})
		no++;
		
	})
	
	$("#ctotaltransferencia").val(total);
	
	
	calcularTotales();
	
	$("#"+lista).val(cadena);
}

function seleccionarTodoDepositos(){
	if ($("#seleccionartododepositos").prop("checked")==true){
		$(".checkDepositos").prop("checked", "checked");
	}else{
		$(".checkDepositos").prop("checked", "");
	}   
	recorrerTablaDepositos("tablaDepositos","listaSalidaDepositos");
}

function recorrerTablaDepositos(tabla,lista){
	var id;
	var cadena;
	var total = 0;
	var no=-1;
	cadena="";
	$('#'+tabla+' tbody tr').each(function () {
		$(this).find('td').each(function (index,valor) {
			if (index==1){
				id=$(valor).html();
			}
			if (index==3 ){//total
				if ($("#checkdepositos"+no).prop("checked")==true){
					total = parseFloat(total)+ parseFloat($("#totaldepositos"+no).html());
					cadena=cadena+id+",";
				}
			}
		})
		no++;
		
	})
	
	$("#ctotaldeposito").val(total);
	
	
	calcularTotales();
	
	$("#"+lista).val(cadena);
}

function seleccionarTodoNotasdecredito(){
	if ($("#seleccionartodonotasdecredito").prop("checked")==true){
		$(".checkNotasdecredito").prop("checked", "checked");
	}else{
		$(".checkNotasdecredito").prop("checked", "");
	}   
	recorrerTablaNotasdecredito("tablaNotasdecredito","listaSalidaNotasdecredito");
}

function recorrerTablaNotasdecredito(tabla,lista){
	var id;
	var cadena;
	var total = 0;
	var no=-1;
	cadena="";
	$('#'+tabla+' tbody tr').each(function () {
		$(this).find('td').each(function (index,valor) {
			if (index==1){
				id=$(valor).html();
			}
			if (index==3 ){//total
				if ($("#checknotasdecredito"+no).prop("checked")==true){
					total = parseFloat(total)+ parseFloat($("#totalnotasdecredito"+no).html());
					cadena=cadena+id+",";
				}
			}
		})
		no++;
		
	})
	
	$("#ctotalnotasdecredito").val(total);
	
	
	calcularTotales();
	
	$("#"+lista).val(cadena);
}

function calcularTotales(){
	//sumar a total a pagar
	//$("#ltotalaretirar").html((parseFloat($("#ctotalcompras").val())+parseFloat($("#ctotalgastos").val())).toFixed(2));
	
	//totales a entregar
	$("#lefectivototal").html(parseFloat($("#ctotalefectivo").val()));
	$("#ltarjetadedebitototal").html(parseFloat($("#ctotaltarjetadedebito").val()));
	$("#ltarjetadecreditototal").html(parseFloat($("#ctotaltarjetacredito").val()));
	$("#lchequestotal").html(parseFloat($("#ctotalcheque").val()));
	$("#ltransferenciastotal").html(parseFloat($("#ctotaltransferencia").val()));
	$("#ldepositostotal").html(parseFloat($("#ctotaldeposito").val()));
	$("#lnotasdecreditototal").html(parseFloat($("#ctotalnotadecredito").val()));
	
	$("#ltotaltotal").html(parseFloat($("#ctotalefectivo").val()) + parseFloat($("#ctotaltarjetadedebito").val()) + parseFloat($("#ctotaltarjetacredito").val()) + parseFloat($("#ctotalcheque").val()) + parseFloat($("#ctotaltransferencia").val()) + parseFloat($("#ctotaldeposito").val()) + parseFloat($("#ctotalnotadecredito").val()));
	
	
	$("#totalaentregar").val($("#ltotaltotal").html());
	
	//totales restantes en caja
	$("#lefectivorestante").html(parseFloat($("#lefectivo").html()) - parseFloat($("#ctotalefectivo").val()));
	$("#ltarjetadedebitorestante").html(parseFloat($("#ltarjetadedebito").html()) - parseFloat($("#ctotaltarjetadedebito").val()));
	$("#ltarjetadecreditorestante").html(parseFloat($("#ltarjetadecredito").html()) - parseFloat($("#ctotaltarjetacredito").val()));
	$("#lchequesrestante").html(parseFloat($("#lcheques").html()) - parseFloat($("#ctotalcheque").val()));
	$("#ltransferenciasrestante").html(parseFloat($("#ltransferencias").html()) - parseFloat($("#ctotaltransferencia").val()));
	$("#ldepositosrestante").html(parseFloat($("#ldepositos").html()) - parseFloat($("#ctotaldeposito").val()));
	$("#lnotasdecreditorestante").html(parseFloat($("#lnotasdecredito").html()) - parseFloat($("#ctotalnotadecredito").val()));
	
	
	$("#ltotalrestante").html(parseFloat($("#lefectivorestante").html()) + parseFloat($("#ltarjetadedebitorestante").html()) + parseFloat($("#ltarjetadecreditorestante").html()) + parseFloat($("#lchequesrestante").html()) + parseFloat($("#ltransferenciasrestante").html()) + parseFloat($("#ldepositosrestante").html()) + parseFloat($("#lnotasdecreditorestante").html()));
	
	$("#ldiferencia").html(parseFloat($("#ctotalefectivo").val())- parseFloat($("#sumaEfectivo").val()));
	$("#diferencia").val(parseFloat($("#ctotalefectivo").val())- parseFloat($("#sumaEfectivo").val()));
	
	var diferencia = parseFloat($("#ldiferencia").html());
	if (diferencia != 0){
		$("#ldiferencia").html("<span style='color:red'>$ "+diferencia+"</span>");
	}
	else{
		$("#ldiferencia").html("<span style='color:green'>$ "+diferencia+"</span>");
	}
}

function fileinput(nombre){
	$('#n'+nombre).val($('#c'+nombre).val());
}


$(document).ready(function() {
	
	$("#panel_alertas").hide();
	$(".loading").hide();
	$("#loading2").hide();
	//$("#panel_alertas").delay(8000).hide(600);
	
	llenarSelectEmpleado("");
	consultarSaldoSucursal("efectivo","lefectivo");
	consultarSaldoSucursal("tarjetadedebito","ltarjetadedebito");
	consultarSaldoSucursal("tarjetadecredito","ltarjetadecredito");
	consultarSaldoSucursal("cheques","lcheques");
	consultarSaldoSucursal("transferencias","ltransferencias");
	consultarSaldoSucursal("depositos","ldepositos");
	consultarSaldoSucursal("notasdecredito","lnotasdecredito");

	load_tablas();
	$("#cmonto").change(function(){
		if(parseFloat($("#cmonto").val()) >parseFloat($("#cmontovalidar").val())){
			$("#cmonto").val($("#cmontovalidar").val());
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
	
	$("#cfondocaja").keypress(function(){
		return checarDecimal(event, this);
	});
					
	$("#cfondocaja").keypress(function(){
		return checarDecimal(event, this);
	});
	
	$('.dinero').permitirCaracteres('0123456789');
	
	
	$("#cmonto").keypress(function(){
		return checarDecimal(event, this);
	});
	
	$("#botonAceptar").click(function() {
		var variables=$("#formulario").serialize();
		guardar(variables);
	});
				
});

function validar(){
	var estado=true;
	var mensaje="";
	if($("#cidreferencia").val()==""){
		$("#cidreferencia").val(idreferencia);
	}
	if (estado==false){
		mostrarMensaje(mensaje);
	}
	return estado;
}

//**************************AJAX*******************************
// Autor: Armando Viera Rodríguez
// Onixbm 2016

function buscar (busqueda){
	location.href='../consultar/vista.php?link=vista&busqueda='+busqueda+'&n1=pagos&n2=consultarpagos';
}

function obtenerEstadoLiquidacion(idreferencia,tablareferencia){
	
	
}


function guardar(variables){
	var formData = new FormData($("#formulario")[0]);
		$("#botonGuardar").hide();
		$("#botonAceptar").hide();
		$("#botonSave").hide();
		$("#loading").show();
		$.ajax({
			url: 'guardar.php',
			type: "POST",
			data: formData, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			cache: false,
			contentType: false,
			processData: false,
			success: function(mensaje){
				$("#botonGuardar").show();
				$("#botonAceptar").show();
				$("#botonSave").show();
				$("#loading").hide();
				mostrarMensaje(mensaje);
			}
		});
		return false;
}

function guardar2(variables){
	var formData = new FormData($("#formulario")[0]);
		$("#botonAceptar").hide();
		$("#loading").show();
		$.ajax({
			url: 'guardar.php',
			type: "POST",
			data: formData, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			cache: false,
			contentType: false,
			processData: false,
			success: function(mensaje){
				$("#botonAceptar").show();
				$("#loading").hide();
				mostrarMensaje(mensaje);
			}
		});
		return false;
}

function guardar3(variables){
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

function guardar(variables){
		$("#botonAceptar").hide();
		$("#loading").show();
		$.ajax({
			url: 'guardar.php',
			type: "POST",
			data: "submit=&"+variables, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#botonAceptar").show();
				$("#loading").hide();
				mostrarMensaje(mensaje);
			}
		});
		return false;
}

function llenarSelectEmpleado(condicion){
		$("#idempleadocajero_ajax").html("<option value='1'>cargando...</option>");
		$("#idempleadogerente_ajax").html("<option value='1'>cargando...</option>");
		$.ajax({
			url: '../componentes/llenarSelectEmpleado.php',
			type: "POST",
			data: "submit=&condicion="+condicion, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#idempleadocajero_ajax").html(mensaje);
				$("#idempleadogerente_ajax").html(mensaje);
			}
		});
		return false;
}

function consultarSaldoSucursal(formadepago,etiqueta){
		$("#"+etiqueta).html("$0.00");
		$.ajax({
			url: '../componentes/consultarSaldoSucursal.php',
			type: "POST",
			data: "submit=&formadepago="+formadepago, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#"+etiqueta).html(mensaje);
				$("#ltotal").html(parseFloat($("#ltotal").html()) + parseFloat($("#"+etiqueta).html()));
			}
		});
		return false;
}

function eliminarIndividual(id,idreferencia,tablareferencia) {
	$.ajax({
			url: 'obtieneEstadoLiquidacion.php',
			type: "POST",
			data: "submit=&idreferencia="+idreferencia+"&tablareferencia="+tablareferencia, //Pasamos los datos en forma de array
			success: function(mensaje){
				$("#cestadoliquidacion").val(mensaje);
				var encoded = "¿Desea borrar el registro?";
				var decoded = $("<div/>").html(encoded).text();
				var pregunta = confirm(decoded);
				if (pregunta){
					var tipo=$("#ctipo").val();
					var idreferencia=$("#cidreferencia").val();
					var tablareferencia=$("#ctablareferencia").val();
					estadoliquidacion = $("#cestadoliquidacion").val();
					eliminar_individual(id,tipo,idreferencia,tablareferencia,estadoliquidacion);
				}
			}
		});
		return false;
}

function eliminar_individual(id,tipo,idreferencia,tablareferencia,estadoliquidacion){
		$.ajax({
			url: '../eliminar/eliminar.php',
			type: "POST",
			data: "submit=&ids="+id+"&tipo="+tipo+"&idreferencia="+idreferencia+"&tablareferencia="+tablareferencia+"&estadoliquidacion="+estadoliquidacion, //Pasamos los datos en forma de array
			
			success: function(mensaje){
				mostrarMensaje(mensaje,id,"eliminar");
			}
		});
		return false;
}



function actualizarDatos(){
		var idreferencia=$("#cidreferencia").val();
		var tablareferencia=$("#ctablareferencia").val();
		var idcliente=$("#cidcliente").val();
		$.ajax({
			url: 'actualizardatos.php',
			type: "POST",
			data: "submit=&idreferencia="+idreferencia+"&tablareferencia="+tablareferencia+"&idcliente="+idcliente, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				refrescarDatos(mensaje);
			}
		});
		return false;
}


function load_tablas (){
	//alert (orden);
	//alert (campoOrden);
	//alert (limit);
	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById("muestra_contenido_ajax").innerHTML=xmlhttp.responseText;
			$("#loading2").hide();
		}
		else{
			//$("#loading2").show();
		}
	}
	var variables = $("#formulario").serialize();
	/*xmlhttp.open("POST","consultarCorte.php?campoOrden="+campoOrden+"&orden="+orden+"&cantidadamostrar="+cantidadamostrar+"&paginacion="+paginacion+"&busqueda="+busqueda+"&tipoVista="+tipoVista+"&papelera="+papelera+"&"+variables, true);
	xmlhttp.send();*/
	
	
	xmlhttp.open("POST","consultarCorte.php?"+variables, true);
	xmlhttp.send();
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
		//load_tablas (idreferencia, tablareferencia);
		//actualizarDatos();
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

function refrescarDatos(mensaje){
	var cadena= $.trim(mensaje); 
	var res=cadena.split("@");
	$("#deudageneral").html("$ "+res[0]);
	$("#totalpagado").html("$ "+res[1]);
	$("#diferencia").html("$ "+res[2]);
}
