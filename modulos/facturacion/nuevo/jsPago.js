// JS MODULA Autor: Armando Viera Rodriguez 2016
// FUNCIONES DE LLENADO DE TABLA DE INFERIOR
var DECIMALES=2;
var FILAS=0;
var FILAS2=0;
var CONDICION="";
var tipoVista="codigobarras";
var URLblur,URLauto;

function comprobarReglas(){
	//Elegir el tipo de vista
	if(recuperarCookie("tipoBusquedaProductos")=="descripcion"){
		$('.tipoDescripcion').show();
		$('.tipoCB').hide();
		tipoVista="descripcion";
	}else{
		$('.tipoDescripcion').hide();
		$('.tipoCB').show();
		tipoVista="codigobarras";
	}
}

function fileinput(nombre){
	$('#n'+nombre).val($('#c'+nombre).val());
}

$(document).ready(function() {
	
	$( ".tipoCB" ).click(function() {
    	crearCookie("tipoBusquedaProductos", "descripcion");
		tipoVista="descripcion";
		$(".tipoDescripcion").show();
		$(".tipoCB").hide();
		comprobarReglas();
	});
	$( ".tipoDescripcion" ).click(function() {
    	crearCookie("tipoBusquedaProductos", "codigobarras");
		tipoVista="codigobarras";
		$(".tipoDescripcion").hide();
		$(".tipoCB").show();
		comprobarReglas();
	});
	
	comprobarReglas();

	
	//AUTOCOMPLETAR
	$( "#autofoliointerno" ).autocomplete({
		 source: function(request, response) {
                $.ajax({
                  url: "../componentes/buscarFacturacion.php",
                  data: { term: $("#autofoliointerno").val() , receptor: $('#autoidcliente').val() },
                  dataType: "json",
                  type: "GET",
                  success: function(data){
                      response(data);
                  }
                });
        },
			  
		autoFocus:true,
		select:function(event,ui){ 
        	$('#cfoliointerno').val(ui.item.id);
			$('#consultafoliointerno').val(ui.item.consulta);
			$("#nuuid").val(ui.item.uuid);
    	},
		search: function (event, ui) {
			$("#cfoliointerno").val("");
			$("#consultafoliointerno").val($("#autofoliointerno").val());
			$("#nuuid").val("");
		},
        minLength: 1
    });
	// FIN AUTOCOMPLETAR
	
	//AUTOCOMPLETAR
	$( "#autoidfacturacion" ).autocomplete({
		 source: function(request, response) {
                $.ajax({
                  url: "../componentes/buscarFacturacionPago.php",
                  data: { term: $("#autoidfacturacion").val() , receptor: $('#autoidcliente').val() },
                  dataType: "json",
                  type: "GET",
                  success: function(data){
                      response(data);
                  }
                });
        },
			  
		autoFocus:true,
		select:function(event,ui){ 
        	$('#cidfacturacion').val(ui.item.id);
			//$('#consultafoliointerno').val(ui.item.consulta);
			$("#uuid").val(ui.item.uuid);
			$("#nmoneda").val(ui.item.moneda);
			$("#ntipocambio").val(ui.item.tipocambio);
			$("#nnumparcialidad").val(ui.item.numparcialidad);
			$("#nmontototal").val(ui.item.montototal);
			$("#nsaldoanterior").val(ui.item.saldoanterior);
			$("#nfoliof").val(ui.item.consulta);
			$("#descripcionFactura").html(ui.item.label);
    	},
		search: function (event, ui) {
			$("#cidfacturacion").val("");
			//$("#consultafoliointerno").val($("#autofoliointerno").val());
			$("#uuid").val("");
			$("#descripcionFactura").html("");
		},
        minLength: 1
    });
	// FIN AUTOCOMPLETAR
	
	
	
	
	
	
	//AUTOCOMPLETAR
	$( "#autoidcliente" ).autocomplete({
        source: "../componentes/buscarCliente.php",
		autoFocus:true,
		select:function(event,ui){ 
        	$('#cidcliente').val(ui.item.id);
			$('#consultaidcliente').val(ui.item.consulta);
			$('#tcliente').html(ui.item.consulta);
			//$("#cuso option[value="+ ui.item.uso +"]").attr("selected",true);
			//$("#cuso").val(ui.item.uso);
			$("#listaSalida2").val("");
			$("#tablaSalida2").html("");
			FILAS2=0;
			
    	},
		search: function (event, ui) {
			$("#cidcliente").val("");
			$("#consultaidcliente").val($("#autoidcliente").val());
			$('#tcliente').html($("#autoidcliente").val());
			//$("#cuso").val("P01");
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
					//$("#cuso option[value="+ respuesta.uso +"]").attr("selected",true);
					//$("#cuso").val(respuesta.uso);
        	});
		},
        minLength: 1
    });
	// FIN AUTOCOMPLETAR
	
	$("#botonAgregarFila").click(function() {
			var uuidV=$("#uuid").val();
			var folioV=$("#nfoliof").val();
			var monedaV=$("#nmoneda").val();
			var tipocambioV=$("#ntipocambio").val();
			var metodopagoV="PPD";
			var numparcialidadV=$("#nnumparcialidad").val();
			var saldoanteriorV=$("#nsaldoanterior").val();
			var montototalV=$("#nmontototal").val();
			var montopagoV=$("#nmonto").val();
			
			
			
			if (uuidV!=""){
				if(montopagoV=="" || montopagoV=="." || montopagoV=="0" || tipocambioV=="" || tipocambioV=="." || tipocambioV=="0"){
					mostrarMensaje("fracaso@Ingrese el pago@<p>Es necesario proporcionar el monto del pago y el tipo de cambio. Debe ser mayor a cero</p>");
					$("#nmonto").focus();
				}else{
					
					saldoanteriorV=parseFloat (saldoanteriorV);
					montototalV=parseFloat (montototalV);
					montopagoV=parseFloat (montopagoV);
					var saldoinsolutoV=saldoanteriorV-montopagoV;
					if (saldoinsolutoV<0){
						mostrarMensaje("fracaso@Pago incorrecto@<p>El total del pago supera el monto de la factura</p>");
					}else{
						variables=new Array();
						variables[0]=0; //No. de filfa
						variables[1]=uuidV;
						variables[2]=folioV;
						variables[3]=monedaV;
						variables[4]=tipocambioV;
						variables[5]=metodopagoV;
						variables[6]=numparcialidadV;
						variables[7]=saldoanteriorV;
						variables[8]=montopagoV;
						variables[9]=saldoinsolutoV;
						
						agregarFila("tablaSalida", variables, "listaSalida");
						
						//recalcularTotal();
						
						
						$("#uuid").val("");
						$("#nfoliof").val("");
						$("#nmoneda").val("");
						$("#ntipocambio").val("");
						$("#nnumparcialidad").val("");
						$("#nsaldoanterior").val("");
						$("#nmontototal").val("");
						$("#nmonto").val("");
						$("#autoidfacturacion").val("");
						$("#autoidfacturacion").focus();
					}
				}
			}else{
				mostrarMensaje("fracaso@Seleccione la factura a pagar@<p>La factura que intenta ingresar no existe en la base de datos</p>");
				$("#autoidfacturacion").focus();
			}
	}); 
	
	
	$("#botonAgregarFila2").click(function() {
			var descripcionRelacion=$("#autofoliointerno").val();
			var uuid=$("#nuuid").val();
			
			if (uuid!=""){
					variables=new Array();
					variables[0]=0; //No. de filfa
					variables[1]=descripcionRelacion;
					variables[2]=uuid;
					
					agregarFila2("tablaSalida2", variables, "listaSalida2");

					$("#nuuid").val("");
					$("#autofoliointerno").val("");
					$("#cfoliointerno").val("");
					$("#consultafoliointerno").val("");
					$("#autofoliointerno").focus();
				
			}else{
				mostrarMensaje("fracaso@Seleccione un CFDI@<p>Debe seleccionar un CFDI de la lista. La lista mostrará los CFDIs relacionados con el cliente seleccionado</p>");
				$("#autofoliointerno").focus();
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
	
	$("#autoidcliente").focus(function(){
		$(this).select();
	});
	$("#ctipocambio").focus(function(){
		$(this).select();
	});
	
	$("#cefectivo").focus(function(){
		$(this).select();
	});
	$("#ctarjetadebito").focus(function(){
		$(this).select();
	});
	$("#ctarjetacredito").focus(function(){
		$(this).select();
	});
	$("#ctransferencia").focus(function(){
		$(this).select();
	});
	$("#ccheque").focus(function(){
		$(this).select();
	});
	$("#csaldoafavor").focus(function(){
		$(this).select();
	});
	$("#cmonedero").focus(function(){
		$(this).select();
	});
	$("#idalmacen_ajax").change(function(){
		var cp=$("#idalmacen_ajax").val();
		obtenerSerie(cp);
		obtenerFolio(cp);
	});
	
	$("#botonCargar").click(function() {
		cargarCep();
	});
	
	
	$(document).on("click",".eliminarFila",function(){
		var parent = $(this).parents().get(0);
		$(parent).remove();
		recorrerTabla("tablaSalida","listaSalida"); // Crea la cadena de productos que se enviara a timbrado
		//recalcularTotal();
	});
	
	$(document).on("click",".eliminarFila2",function(){
		var parent = $(this).parents().get(0);
		$(parent).remove();
		recorrerTabla("tablaSalida2","listaSalida2"); // Crea la cadena de productos que se enviara a timbrado
	});
	//FIN DE FUNCIONES DE LLANDO DE TABLA DE INFERIOR
});

function calcularCambio() {
	total=$("#ctotal").val();
	pago=$("#cefectivo").val();
	cambio=pago-total;
	$("#ccambio").val(cambio);
	
	$("#tpago").html(pago);
	$("#tcambio").html(cambio);
	$("#lcambio").html("$"+cambio);
}

function ponerReferencia() {
	$("#treferencia").html($("#creferencia").val());
}

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
	var ultimo=campo.slice(-1);
	if (ultimo=="."){
		campo=campo.substr(0,campo.length-1);
		$("#"+id).val(campo);
	}
	if (campo=="" || campo==0 || campo=="."){
		$("#"+id).val("0.00");
	}
	var cant=0;
	var precio=0;
	var total=0;
	var descuento=0;
	
	cant=parseFloat ($("#cant"+idtotal).val());
	precio= parseFloat ($("#precio"+idtotal).text());
	descuento= parseFloat ($("#descuento"+idtotal).text());
	
	var total=cant*precio;
	var descuentoT=cant*descuento;
	
	$("#total"+idtotal).text(total.toFixed(DECIMALES));
	$("#descuentoT"+idtotal).text(descuentoT.toFixed(DECIMALES));
	
	recorrerTabla("tablaSalida","listaSalida");
	//recalcularTotal();
	
}



	
function redibujarTabla(id,idtotal) {
	recorrerTabla("tablaSalida","listaSalida");
}
										
										
	
function agregarFila(tabla, elementos,lista){
		FILAS=FILAS+1;
        var nuevaFila="<tr>";
		var con=0;
		
		while (con < elementos.length){
			if (con==0){ // No. Fila
				nuevaFila=nuevaFila+"<td style='display:none'>";
				nuevaFila=nuevaFila+FILAS;
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==1){ // UUID
				nuevaFila=nuevaFila+"<td class=\"columnaIzquierda\" style=\"border-left: 10px solid #25c274;\">";
				nuevaFila=nuevaFila+elementos[con];
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==2){ // Folio
				nuevaFila=nuevaFila+"<td>";
					nuevaFila=nuevaFila+elementos[con];
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==3){ // Moneda
				nuevaFila=nuevaFila+"<td>";
				nuevaFila=nuevaFila+elementos[con];
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==4){ //tipocambio
				nuevaFila=nuevaFila+"<td>";
				nuevaFila=nuevaFila+elementos[con];
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==5){ //metodopago
				nuevaFila=nuevaFila+"<td>";
				nuevaFila=nuevaFila+elementos[con];
				nuevaFila=nuevaFila+"</td>";
			}
			
			if (con==6){ // numParcialidad
				nuevaFila=nuevaFila+"<td>";
				nuevaFila=nuevaFila+elementos[con];
				nuevaFila=nuevaFila+"</td>";
			}
			
			if (con==7){ // SaldoAnterior
				nuevaFila=nuevaFila+"<td>";
				nuevaFila=nuevaFila+elementos[con];
				nuevaFila=nuevaFila+"</td>";
			}
			
			
			if (con==8){ // montoPago
				nuevaFila=nuevaFila+"<td>";
				nuevaFila=nuevaFila+elementos[con];
				nuevaFila=nuevaFila+"</td>";
			}
			
			
			if (con==9){ // SaldoInsoluto
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

function agregarFila2(tabla, elementos,lista){
	FILAS2=FILAS2+1;
    var nuevaFila="<tr>";
	var con=0;
	while (con < elementos.length){
		if (con==0){ // No. Fila
			nuevaFila=nuevaFila+"<td style='display:none'>";
			nuevaFila=nuevaFila+FILAS2;
			nuevaFila=nuevaFila+"</td>";
		}
		if (con==1){ // CFDI Relacionado
			nuevaFila=nuevaFila+"<td class=\"columnaIzquierda\" style=\"border-left: 10px solid #25c274;\">";
			nuevaFila=nuevaFila+elementos[con];
			nuevaFila=nuevaFila+"</td>";
		}
		if (con==2){ //UUID
			nuevaFila=nuevaFila+"<td id='uuid"+FILAS2+"'>";
			nuevaFila=nuevaFila+elementos[con];
			nuevaFila=nuevaFila+"</td>";
		}
		con=con+1;
	}
	nuevaFila=nuevaFila+"<td title='Eliminar Fila' class='eliminarFila2'><a class='btn btn-default btn-xs'><i class='fa fa-trash-o text-green'></i><a></td>";
	nuevaFila=nuevaFila+"</tr>"
	$("#"+tabla).prepend(nuevaFila); //Coloca la fila al inicio de la tabla
	recorrerTabla2(tabla,lista);
}

function recorrerTabla2(tabla,lista){
	var no, uuid;
	var cadena="";
	$('#'+tabla+' tbody tr').each(function () {
		$(this).find('td').each(function (index,valor) {
			
			if (index==2){
				uuid=$(valor).html();
			}
		})
		cadena=cadena+uuid+":::";
	})
	$("#"+lista).val(cadena);
}
	
function recorrerTabla(tabla,lista){
	var no, uuid, folio, moneda, tipocambio, metodopago, numparcialidad, saldoanterior, montopago, saldoinsoluto;
	var cadena;
	var total=0;
	cadena="";
	//$("#filasTicket").html("");
	$('#'+tabla+' tbody tr').each(function () {
		$(this).find('td').each(function (index,valor) {
			if (index==0){
				no=$(valor).html();
			}
			if (index==1){
				uuid=$(valor).html();
			}
			if (index==2){
				folio=$(valor).html();
			}
			if (index==3){
				moneda=$(valor).html();
			}
			if (index==4){
				tipocambio=$(valor).html();
			}
			if (index==5){
				metodopago=$(valor).html();
			}
			
			if (index==6){
				numparcialidad=$(valor).html();
			}
			
			if (index==7){
				saldoanterior=$(valor).html();
			}
			if (index==8){
				montopago=parseFloat($(valor).html());
				total=total+montopago;
			}
			if (index==9){
				saldoinsoluto=$(valor).html();
			}
		})
		cadena=cadena+uuid+":::"+folio+":::"+moneda+":::"+tipocambio+":::"+metodopago+":::"+numparcialidad+":::"+saldoanterior+":::"+montopago+":::"+saldoinsoluto+":::";
		//cadena=cadena+idproducto+":::"+cantidad+":::"+precio+":::"+descuento+":::";
	})
	$("#"+lista).val(cadena);
	$("#ltotal").html("$"+total);
	$("#ctotal").val(total);
	
}
//FIN DE FUNCIONES DE LLANDO DE TABLA DE INFERIOR





function vaciarCampos(){
		var cp=$("#idalmacen_ajax").val();
		obtenerSerie(cp);
		obtenerFolio(cp);
		
		$("#creferencia").val("");
		$("#ccambio").val(0);
		$("#lcambio").html("$0.00");
		$("#cfecha").focus();
		$("#filas").html("");
		$("#filas2").html("");
		recorrerTabla("tablaSalida","listaSalida"); 
		recorrerTabla2("tablaSalida2","listaSalida2"); 
		obtenerProximoTicket($("#cidalmacen").val());
		$("#autoidcliente").val("PUBLICO EN GENERAL");
		$("#tcliente").html("PUBLICO EN GENERAL");
		$("#cidcliente").val("0");
		$("#cprecios_ajax").html("");
		$("#cefectivo").val("0");
		$("#ctarjetacredito").val("0");
		$("#ctarjetadebito").val("0");
		$("#ccheque").val("0");
		$("#ctransferencia").val("0");
		$("#csaldoafavor").val("0");
		$("#cmonedero").val("0");
		$("#creftarjetadebito").val("");
		$("#creftarjetacredito").val("");
		$("#crefcheque").val("");
		$("#creftransferencia").val("");
		$("#crefmonedero").val("");
		$("#cuso").val("P01");
		//recalcularTotal();
		FILAS=0;
		FILAS2=0;
}
$(document).ready(function() {
	
	$("#panel_alertas").hide();
	$(".loading").hide();
	//$("#panel_alertas").delay(8000).hide(600);
	
	
	llenarSelectEmpleado("");
	llenarSelectAlmacen("");
	obtenerProximoTicket($("#cidalmacen").val());
	obtenerSerie("x");
	obtenerFolio("x");
	
	/////////////////* MODULO DE FACTURACION INTEGRADO
	if (CARGA=="si"){
		if (TIPOCOMPROBANTE=="pago"){
			cargarDatos(DATOS);
			$("#cidcliente").val(IDCLIENTEPAGO);
			$("#crfccliente").val(RFCCLIENTEPAGO);
			$("#autoidcliente").val(NOMBRECLIENTEPAGO);
			$("#cfecha").val(FECHAPAGO);
			$("#cformapago").val(FORMAPAGO);
		}
	}
	/////////////////* MODULO DE FACTURACION INTEGRADO
	
	$("#botonGuardar").click(function() {
				if (validar()){
					var variables=$("#formulario").serialize();
					guardar(variables);
				}
	});
	
	$("#vistaPrevia").click(function() {
				if (validar()){
					var variables=$("#formulario").serialize();
					vistaPrevia(variables);
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
	
	$("#cprecios_ajax").change(function(){
		$("#nprecio").val($("#cprecios_ajax").val());
	});
	$("#cplazo").change(function(){
		$("#tplazo").html($("#cplazo").val());
	});
	$("#cfrecuenciapago").change(function(){
		$("#tfrecuenciapago").html($("#cfrecuenciapago").val());
	});
	$("#cdiacobro").change(function(){
		$("#tdiacobro").html($("#cdiacobro").val());
	});
	
	$("#idempleado_ajax").change(function(){
		$("#Lempleado").html($("#idempleado_ajax option:selected").text());
	});
	
	$("#cmoneda").change(function(){
		if ($(this).val()=="MXN"){
			DECIMALES = 2;
			$("#ctipocambio").val(1);
			$("#ctipocambio").prop("disabled",true);
		}
		if ($(this).val()=="USN"){
			DECIMALES = 2;
			$("#ctipocambio").prop("disabled",false);
			$("#ctipocambio").focus();
		}
		if ($(this).val()=="USD"){
			DECIMALES = 2;
			$("#ctipocambio").prop("disabled",false);
			$("#ctipocambio").focus();
		}
		if ($(this).val()=="EUR"){
			DECIMALES = 2;
			$("#ctipocambio").prop("disabled",false);
			$("#ctipocambio").focus();
		}
	});
	
	
	$("#ctipocomprobante").change(function(){
		if ($(this).val()=="I"){
			$("#cmetodopago").prop("disabled",false);
			//$("#cuso").val("P01");
			var cp=$("#idalmacen_ajax").val();
			obtenerFolio(cp);
		}
		if ($(this).val()=="P"){
			//$("#cuso").val("G02");
			$("#cmetodopago").val("PUE");
			$("#cmetodopago").prop("disabled",true);
			var cp=$("#idalmacen_ajax").val();
			obtenerFolio(cp);
			$("#cserie").val($("#cserie").val()+"P");
		}
	});
	
	$("#ctipocadena").change(function(){
		if ($(this).val()=="01"){
			$(".labelspei").show();
		}else{
			$(".labelspei").hide();
			$("#cnumoperacion").val("");
			$("#csellopago").val("");
			$("#ccertificadopago").val("");
			$("#ccadenapago").val("");
			$("#carchivo").val("");
			$("#narchivo").val("");
		}
	});
	
	$("#cformapago").change(function(){
		if ($(this).val()=="02" || $(this).val()=="03" || $(this).val()=="04" || $(this).val()=="05" || $(this).val()=="28" || $(this).val()=="29" || $(this).val()=="99"){
			$(".labelBancarizado").show();
		}else{
			$(".labelBancarizado").hide();
			$(".labelCadena").hide();
			$(".labelspei").hide();
			
			$("#crfcemisorordenante").val("");
			$("#ccuentaordenante").val("");
			$("#cbancoordenante").val("");
			$("#crfcemisorbeneficiario").val("");
			$("#ccuentabeneficiario").val("");
			$("#cnumoperacion").val("");
			$("#csellopago").val("");
			$("#ccertificadopago").val("");
			$("#ccadenapago").val("");
			$("#carchivo").val("");
			$("#narchivo").val("");
			$("#ctipocadena").val("");
		}
		if ($(this).val()=="03"){
			$(".labelCadena").show();
		}else{
			$(".labelCadena").hide();
			$(".labelspei").hide();
			$("#ctipocadena").val("").change();
		}
		
	});
	
	$(".close").click(function(){ 
		$("#panel_alertas").stop(false, true);
		$("#panel_alertas").hide();
 	});
	
	$("#cdocumentosrelacionados").click(function(){ 
		if ($(this).prop('checked') ) {
    		$(".seccionRelaciones").show();
		}else{
			$(".seccionRelaciones").hide();
			$("#filas2").html("");
			FILAS2=0;
			recorrerTabla2("tablaSalida2","listaSalida2"); 
		}
 	});
	
	$("#ceshotel").click(function(){ 
		//recalcularTotal();
 	});
	
	$("#cimpuestocedular").click(function(){ 
		//recalcularTotal();
 	});
	
	$("#ctasaish").change(function(){ 
		//recalcularTotal();
 	});
	
	$("#ctasaimpuestocedular").change(function(){ 
		//recalcularTotal();
 	});
	
	$("#cefectivo").keypress(function(){
		return checarDecimal(event, this);
	});
	$("#ctarjetadebito").keypress(function(){
		return checarDecimal(event, this);
	});
	$("#ctarjetacredito").keypress(function(){
		return checarDecimal(event, this);
	});
	$("#ccheque").keypress(function(){
		return checarDecimal(event, this);
	});
	$("#ctransferencia").keypress(function(){
		return checarDecimal(event, this);
	});
	$("#csaldoafavor").keypress(function(){
		return checarDecimal(event, this);
	});
	$("#cmonedero").keypress(function(){
		return checarDecimal(event, this);
	});
	
	$(".printer").bind("click",function(){
		$(".print").printArea("print");
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
	location.href='../consultar/vista.php?link=vista&busqueda='+busqueda+'&n1=ventas&n2=consultarventas';
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

function obtenerSerie(condicion){
		$("#cserie").val("X");
		$.ajax({
			url: '../componentes/obtenerSerie.php',
			type: "POST",
			data: "submit=&condicion="+condicion, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#cserie").val("P"+mensaje);
			}
		});
		return false;
}
function obtenerFolio(condicion){
		$("#cfolio").val(99999999);
		$.ajax({
			url: '../componentes/obtenerFolio.php',
			type: "POST",
			data: "submit=&condicion="+condicion, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#cfolio").val(mensaje);
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

function obtenerProximoTicket(condicion){
		$("#cticket").val("cargando...");
		$.ajax({
			url: '../componentes/obtenerProximoTicket.php',
			type: "POST",
			data: "submit=&condicion="+condicion, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#cticket").val(mensaje);
				$(".numticket").html(mensaje);
			}
		});
		return false;
}

function recalcularTotal(){
		var variables=$("#formulario").serialize();
		$.ajax({
			url: "recalcularTotal.php",
			type: "POST",
			data: "submit=&"+variables,
			success: function(mensaje){
				$("#totales").html(mensaje);
			}
		});
		return false;
}



function guardar(variables){
		$(".cargando").show();
		$.ajax({
			url: 'guardarPago.php',
			type: "POST",
			data: "submit=&"+variables, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#botonGuardar").show();
				$("#botonSave").show();
				$(".cargando").hide();
				mostrarMensaje(mensaje);
			}
		});
		
		return false;
}


function cargarCep(){
		var formData = new FormData($("#formulariocep")[0]);
		$("#botonCargar").hide();
		$("#loading").show();
		$.ajax({
			url: 'cargarCEP.php',
			type: "POST",
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			success: function(mensaje){
				$("#botonCargar").show();
				$("#loading").hide();
				
				var cadena= $.trim(mensaje); //Limpia la cadena regresada desde php
				var res=cadena.split("@"); //Separa la cadena en cada @ y convierte las partes en un array
				if(res[0]=="exito"){
					$("#cfecha").val(res[1]);
					$("#cnumoperacion").val(res[2]);
					$("#csellopago").val(res[3]);
					$("#ccertificadopago").val(res[4]);
					$("#ccadenapago").val(res[5]);
					//$("#crfcemisorordenante").val(res[6]);
					//$("#ccuentaordenante").val(res[7]);
					//$("#cbancoordenante").val(res[8]);
					//$("#crfcemisorbeneficiario").val(res[9]);
					//$("#ccuentabeneficiario").val(res[10]);
					//$mensaje="exito@".$fechaOperacion."@".$claveRastreo."@".$sello."@".$numeroCertificado."@".$cadenaCDA."@".$RFCOrdenante."@".$CuentaOrdenante."@".$BancoOrdenante."@".$RFCBeneficiario."@".$CuentaBeneficiario;
				}else{
					//Mostrar archivo inválido
				}
		
		
				
				//mostrarMensaje(mensaje);
			}
		});
		return false;
}


function vistaPrevia(variables){
		$(".cargando").show();
		$.ajax({
			url: 'vistaPreviaPago.php',
			type: "POST",
			data: "submit=&"+variables, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#botonGuardar").show();
				$("#botonSave").show();
				$(".cargando").hide();
				$("#modal-vistaprevia").modal();
				$("#respuestaVista").html(mensaje);
			}
		});
		
		return false;
}


/////////////////* MODULO DE FACTURACION INTEGRADO
function cargarDatos(variables){
	//alert(variables);
	$("#cformapago").val("99");
		$(".cargando").show();
		$.ajax({
			url: '../componentes/consultarDetallePagos.php',
			type: "POST",
			data: "submit=&"+variables, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(respuesta){
				$("#botonGuardar").show();
				$("#botonSave").show();
				$(".cargando").hide();
				$("#filas").html(respuesta);
				recorrerTabla("tablaSalida","listaSalida"); // Crea la cadena de productos que se enviara a timbrado
				//recalcularTotal();
			}
		});
		
		return false;
}

/////////////////* MODULO DE FACTURACION INTEGRADO


function mostrarMensaje(mensaje){
	//alert(mensaje); //Importante descomentas la línea de abajo para ver la respuesta completa para depuración
	$("#respuesta").html(mensaje);
	
	var cadena= $.trim(mensaje); //Limpia la cadena regresada desde php
	var res=cadena.split("@"); //Separa la cadena en cada @ y convierte las partes en un array
	if (res[0]=="exito"){ //Si la primer frase contiene la palabra "exito"
		$("#cpdf").val(res[3]+".pdf");
		$("#cxml").val(res[3]+".xml");
		$("#crfccliente").val(res[4]);
		$("#ccliente").val(res[5]);
		$("#modal-respuesta").modal();
		vaciarCampos();
	}else if (res[0]=="fracaso"){
		$("#panel_alertas").removeClass().addClass("alert alert-error alert-dismissable");
		$("#subtituloRespuesta").html(res[1]);
		$("#mensajeResuesta").html(res[2]);
		$("#modal-error").modal();
	}else if (res[0]=="aviso"){
		$("#panel_alertas").removeClass().addClass("alert alert-warning alert-dismissable");
		$("#notificacionTitulo").html("<i class='icon fa fa-warning'></i>"+res[1]);
		$("#notificacionContenido").html(res[2]);
	}else{
		$("#panel_alertas").removeClass().addClass("alert alert-error alert-dismissable");
		$("#notificacionTitulo").html("Operaci&oacute;n fallida");
		$("#notificacionContenido").html("<i class='icon fa fa-ban'></i> No se han recibido datos de respuesta desde el servidor [003]");
		$("#subtituloRespuesta").html("Problema de marcado. No intente volver a timbrar este comprobante, contacte a soporte tecnico para solicitar ayuda");
		$("#mensajeResuesta").html("El comprobante fue timbrado pero no es posible almacenarlo en la base de datos [004]");
		$("#modal-error").modal();
	}
	
}