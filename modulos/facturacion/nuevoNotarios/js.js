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
	
	if (tipoVista=="codigobarras"){
		URLblur="../componentes/ProductoCB.php";
		URLauto="../componentes/buscarProductoCB.php";
	}else{
		URLblur="../componentes/ProductoNombre.php";
		URLauto="../componentes/buscarProductoNombre.php";
	}
	
	$( "#autoidproducto" ).autocomplete({
        source: URLauto,
		autoFocus:true,
		select:function(event,ui){
        	$('#cidproducto').val(ui.item.id);
			$('#consultaidproducto').val(ui.item.consulta);
			$.ajax({
            	url:'../componentes/Producto.php',
            	type:'POST',
            	dataType:'json',
            	data:{ termino:$('#cidproducto').val()}
        		}).done(function(respuesta){
            		$("#cidproducto").val(respuesta.id);
					if ($("#ctipocomprobante").val()=="E"){
						$("#ccodigoproducto").val("84111506");
					}else{
						$("#ccodigoproducto").val(respuesta.codigo);
					}
					if ($("#ctipocomprobante").val()=="E"){
						$("#nunidad").val("ACT");
					}else{
						$("#nunidad").val(respuesta.unidad);
					}
					$("#nnombreproducto").val(respuesta.nombre);
					$("#nprecio").val(respuesta.precio);
					$("#ndescuento").val(respuesta.descuento);
					$("#niva").val(respuesta.iva);
					$("#nieps").val(respuesta.ieps);
					$("#ntasaiva").val(respuesta.tasaiva);
					$("#ntasaieps").val(respuesta.tasaieps);
					$("#nombreProducto").html(respuesta.nombre);
					//alert(respuesta.codigocategoria);
					//buscarPrecios();
					//$("#botonAgregarFila").click();
        	});
			
    	},
		search: function (event, ui) {
			$("#cidproducto").val("");
			$("#consultaidproducto").val($("#autoidproducto").val());
			$("#nombreProducto").html("");
		},
		
        minLength: 1
    });
	// FIN AUTOCOMPLETAR
	
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
	
	function buscarPrecios(){
		var idproducto= $("#cidproducto").val();
		$("#cprecios_ajax").html("<div class='loading'>Cargando...</div>");
		$.ajax({
			url: '../componentes/llenarSelectPrecios.php',
			type: "POST",
			data: "submit=&idproducto="+idproducto, //Pasamos los datos en forma de array
			success: function(respuesta){
				$("#cprecios_ajax").html(respuesta);
			}
		});	
	}
	
	
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
	$("#autoidproducto").blur(function(){
		if ($("#cidproducto").val()==""){
			$("#nombreProducto").html(""); 
			$.ajax({
					url:URLblur,
					type:'POST',
					dataType:'json',
					/*En caso de generar una descripció "label" compuesta por dos o mas datos
					en el archivo buscarX.php será necesario cambiar el termino 
					$('#autoX').val() por $('#consultaX').val()*/
					data:{ termino:$('#autoidproducto').val()}
					}).done(function(respuesta){
						$("#cidproducto").val(respuesta.id);
						if ($("#ctipocomprobante").val()=="E"){
							$("#ccodigoproducto").val("84111506");
						}else{
							$("#ccodigoproducto").val(respuesta.codigo);
						}
						if ($("#ctipocomprobante").val()=="E"){
							$("#nunidad").val("ACT");
						}else{
							$("#nunidad").val(respuesta.unidad);
						}
						$("#nnombreproducto").val(respuesta.nombre);
						$("#nprecio").val(respuesta.precio);
						$("#ndescuento").val(respuesta.descuento);
						$("#niva").val(respuesta.iva);
						$("#nieps").val(respuesta.ieps);
						$("#ntasaiva").val(respuesta.tasaiva);
						$("#ntasaieps").val(respuesta.tasaieps);
						$("#nombreProducto").html(respuesta.nombre);
						//alert(respuesta.codigocategoria);
						buscarPrecios();
				});
		}
 	});
	
	
	
	//AUTOCOMPLETAR
	$( "#autoidcliente" ).autocomplete({
        source: "../componentes/buscarCliente.php",
		autoFocus:true,
		select:function(event,ui){ 
        	$('#cidcliente').val(ui.item.id);
			$('#consultaidcliente').val(ui.item.consulta);
			$('#tcliente').html(ui.item.consulta);
			$("#cuso option[value="+ ui.item.uso +"]").attr("selected",true);
			$("#cuso").val(ui.item.uso);
			$("#listaSalida2").val("");
			$("#tablaSalida2").html("");
			FILAS2=0;
			
    	},
		search: function (event, ui) {
			$("#cidcliente").val("");
			$("#consultaidcliente").val($("#autoidcliente").val());
			$('#tcliente').html($("#autoidcliente").val());
			$("#cuso").val("P01");
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
					$("#cuso").val(respuesta.uso);
        	});
		},
        minLength: 1
    });
	// FIN AUTOCOMPLETAR
	
	$("#botonAgregarFila").click(function() {
			var idproductoV=$("#cidproducto").val();
			var nombreproductoV=$("#nnombreproducto").val();
			var cantidadV=$("#ncantidad").val();
			var unidadV=$("#nunidad").val();
			var descuentoV=$("#ndescuento").val();
			
			var cantidadV=$("#ncantidad").val();
			cantidadV=parseFloat (cantidadV);
			cantidadV=cantidadV.toFixed(6);
			
			var precioV=$("#nprecio").val();
			precioV=parseFloat (precioV);
			precioV=precioV.toFixed(6);
			
			
			var montoV=precioV*cantidadV;
			montoV=parseFloat (montoV);
			montoV=montoV.toFixed(DECIMALES);
			
			descuentoV=parseFloat (descuentoV);
			descuentoV=descuentoV.toFixed(6);
			
			var descuentoTV=descuentoV*cantidadV;
			descuentoTV=parseFloat (descuentoV);
			descuentoTV=descuentoTV.toFixed(DECIMALES);
			

			
			
			if (idproductoV!=""){
				if(cantidadV=="" || cantidadV=="." || cantidadV=="0"){
					mostrarMensaje("fracaso@Ingrese la cantidad@<p>Es necesario proporcionar la cantidad de productos que va a facturar</p>");
					$("#ncantidad").focus();
				}else{
					
					variables=new Array();
					variables[0]=0; //No. de filfa
					variables[1]=idproductoV;
					variables[2]=nombreproductoV;
					variables[3]=unidadV;
					variables[4]=cantidadV;
					variables[5]=precioV;
					variables[6]=montoV;
					variables[7]=descuentoV;
					variables[8]=descuentoTV;
					
					agregarFila("tablaSalida", variables, "listaSalida");
					
					recalcularTotal();
					
					
					$("#ncantidad").val(1);
					$("#nprecio").val(0);
					$("#ndescuento").val(0);
					$("#nunidad").val("");
					$("#cidproducto").val("");
					$("#autoidproducto").val("");
					$("#nombreProducto").html("");
					$("#autoidproducto").focus();
				}
			}else{
				mostrarMensaje("fracaso@Seleccione un producto@<p>El producto que intenta ingresar no existe en la base de datos</p>");
				$("#autoidproducto").focus();
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
	
	
	$(document).on("click",".eliminarFila",function(){
		var parent = $(this).parents().get(0);
		$(parent).remove();
		recorrerTabla("tablaSalida","listaSalida"); // Crea la cadena de productos que se enviara a timbrado
		recalcularTotal();
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
	recalcularTotal();
	
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
			if (con==0){ // No. Fila
				nuevaFila=nuevaFila+"<td style='display:none'>";
				nuevaFila=nuevaFila+FILAS;
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==1){ // ID
				nuevaFila=nuevaFila+"<td style='display:none'>";
					nuevaFila=nuevaFila+elementos[con];
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==2){ // Concepto
				nuevaFila=nuevaFila+"<td class=\"columnaIzquierda\" style=\"border-left: 10px solid #25c274;\">";
				nuevaFila=nuevaFila+elementos[con];
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==3){ //Unidad
				nuevaFila=nuevaFila+"<td id='unidad"+FILAS+"'>";
				nuevaFila=nuevaFila+elementos[con];
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==4){ // Cantidad
				nuevaFila=nuevaFila+"<td>";
				nuevaFila=nuevaFila+"<input value='"+elementos[con]+"' name='cant"+FILAS+"' type='text' class='caja' id='cant"+FILAS+"' onblur=\"checarCeros('cant"+FILAS+"','"+FILAS+"')\" onkeypress=\"return soloNumeros(event,'cant"+FILAS+"');\" />";
				nuevaFila=nuevaFila+"</td>";
			}
			
			if (con==5){ // Precio
				nuevaFila=nuevaFila+"<td id='precio"+FILAS+"'>";
				nuevaFila=nuevaFila+elementos[con];
				nuevaFila=nuevaFila+"</td>";
			}
			
			if (con==6){ // Monto total
				nuevaFila=nuevaFila+"<td id='total"+FILAS+"'>";
				nuevaFila=nuevaFila+elementos[con];
				nuevaFila=nuevaFila+"</td>";
			}
			
			
			if (con==7){ // Descuento Unitario
				nuevaFila=nuevaFila+"<td id='descuento"+FILAS+"' style='display:none'>";
				nuevaFila=nuevaFila+elementos[con];
				nuevaFila=nuevaFila+"</td>";
			}
			
			
			if (con==8){ // Descuento Total
				nuevaFila=nuevaFila+"<td id='descuentoT"+FILAS+"'>";
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
	var no, idproducto, cantidad, estiloDescripcion, unidad, precio, ieps, tasaieps, totalieps, iva, tasaiva, totaliva, monto, cantidadTicket, montoTicket, descripcionTicket, cadenaTicket;
	var cadena;
	var subtotal=0, total=0, sumaiva=0, sumaieps=0;
	var incluyeiva=false, incluyeieps=false;
	cadena="";
	$("#filasTicket").html("");
	$("#ccambio").val(0);
	$("#lcambio").html("$0.00");
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
	$('#'+tabla+' tbody tr').each(function () {
		$(this).find('td').each(function (index,valor) {
			if (index==0){
				no=$(valor).html();
			}
			if (index==1){
				idproducto=$(valor).html();
			}
			if (index==2){
				descripcionTicket="<td align='left'><div"+estiloDescripcion+">"+$(valor).html()+"</div></td>";
			}
			if (index==3){
				unidad=$(valor).html();
			}
			if (index==4){
				cantidad=$("#cant"+no).val();
				if ($("#cant"+no).val()==0){
					$("#cant"+no).css('color', 'red');
				}else{
					$("#cant"+no).css('color', 'blue');
				}
				cantidadTicket="<td align='center'>"+cantidad+"</td>";
					
			}
			if (index==5){
				precio=$(valor).html();
			}
			
			if (index==6){
				monto= parseFloat ($(valor).html());
				subtotal=subtotal+monto;
				montoTicket="<td align='right'>$"+monto+"</td>";
			}
			
			if (index==7){
				descuento=$(valor).html();
			}
			if (index==8){
				descuentoT=$(valor).html();
			}
		})
		cadena=cadena+idproducto+":::"+cantidad+":::"+precio+":::"+descuento+":::";
	})
	$("#"+lista).val(cadena);
	
	
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
		recalcularTotal();
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
			$("#cuso").val("P01");
			var cp=$("#idalmacen_ajax").val();
			obtenerFolio(cp);
		}
		if ($(this).val()=="E"){
			$("#cuso").val("G02");
			$("#cmetodopago").val("PUE");
			$("#cmetodopago").prop("disabled",true);
			var cp=$("#idalmacen_ajax").val();
			obtenerFolio(cp);
			$("#cserie").val($("#cserie").val()+"E");
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
		recalcularTotal();
 	});
	
	$("#cimpuestocedular").click(function(){ 
		recalcularTotal();
 	});
	
	$("#ctasaish").change(function(){ 
		recalcularTotal();
 	});
	
	$("#ctasaimpuestocedular").change(function(){ 
		recalcularTotal();
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
				$("#cserie").val(mensaje);
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
			url: 'guardar.php',
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


function vistaPrevia(variables){
		$(".cargando").show();
		$.ajax({
			url: 'vistaPrevia.php',
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
		$("#notificacionContenido").html("<i class='icon fa fa-ban'></i> No se han resivido datos de respuesta desde el servidor [003]");
	}
	
}