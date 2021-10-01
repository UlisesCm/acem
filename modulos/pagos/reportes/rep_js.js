// JavaScript Document
var orden, campoOrden, cantidadamostrar, paginacion;
orden="DESC";
campoOrden="idventa";
iniciar="0";
cantidadamostrar="20";
paginacion=0;

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


function seleccionarTodo(){
	if ($("#seleccionarTodo").prop("checked")==true){
		$(".checkEliminar").prop("checked", "checked");
	}else{
		$(".checkEliminar").prop("checked", "");
	}   
}
function eliminarIndividual(id) {
	var encoded = "¿Desea borrar el registro?";
	var decoded = $("<div/>").html(encoded).text();
    var pregunta = confirm(decoded);
	if (pregunta){
		eliminar_individual(id);
	}
}
function comprobarReglas(){
	$(".checksEliminar").hide();
	//Identificar el campo de ordenamiento
	if(recuperarCookie("campoOrdenVenta")!=null){
		campoOrden=recuperarCookie("campoOrdenVenta");
		 $("#campoOrden option[value="+campoOrden+"]").attr("selected",true);
	}else{
		campoOrden="idventa";
		$("#campoOrden option[value="+campoOrden+"]").attr("selected",true);
	}
	
	//Identificar el numero de elementos para mostrar
	if(recuperarCookie("cantidadamostrarVenta")!=null){
		cantidadamostrar=recuperarCookie("cantidadamostrarVenta");
		 $("#cantidadamostrar option[value="+cantidadamostrar+"]").attr("selected",true);
	}else{
		cantidadamostrar="20";
		$("#cantidadamostrar option[value="+cantidadamostrar+"]").attr("selected",true);
		
	}
	
	//Identificar el tipo de orden
	if(recuperarCookie("ordenVenta")=="asc"){
		orden="ASC"
		$('#asc').attr('checked', true);
		$('#desc').attr('checked', false);
	}else if(recuperarCookie("ordenVenta")=="desc"){
		orden="DESC"
		$('#asc').attr('checked', false);
		$('#desc').attr('checked', true);
	}else{
		orden="DESC"
		$('#asc').attr('checked', false);
		$('#desc').attr('checked', true);
	}
	//Mostrar u Ocultar Idventa
	if(recuperarCookie("mostrarIdventaVenta")=="si"){
		$('.Cidventa').show();
		$('#CheckIdventa').attr('checked', true);
	}else if(recuperarCookie("mostrarIdventaVenta")=="no"){
		$('.Cidventa').hide();
		$('#CheckIdventa').attr('checked', false);
	}
	//Mostrar u Ocultar Fecha
	if(recuperarCookie("mostrarFechaVenta")=="si"){
		$('.Cfecha').show();
		$('#CheckFecha').attr('checked', true);
	}else if(recuperarCookie("mostrarFechaVenta")=="no"){
		$('.Cfecha').hide();
		$('#CheckFecha').attr('checked', false);
	}
	//Mostrar u Ocultar Hora
	if(recuperarCookie("mostrarHoraVenta")=="si"){
		$('.Chora').show();
		$('#CheckHora').attr('checked', true);
	}else if(recuperarCookie("mostrarHoraVenta")=="no"){
		$('.Chora').hide();
		$('#CheckHora').attr('checked', false);
	}
	//Mostrar u Ocultar Formapago
	if(recuperarCookie("mostrarFormapagoVenta")=="si"){
		$('.Cformapago').show();
		$('#CheckFormapago').attr('checked', true);
	}else if(recuperarCookie("mostrarFormapagoVenta")=="no"){
		$('.Cformapago').hide();
		$('#CheckFormapago').attr('checked', false);
	}
	//Mostrar u Ocultar Efectivo
	if(recuperarCookie("mostrarEfectivoVenta")=="si"){
		$('.Cefectivo').show();
		$('#CheckEfectivo').attr('checked', true);
	}else if(recuperarCookie("mostrarEfectivoVenta")=="no"){
		$('.Cefectivo').hide();
		$('#CheckEfectivo').attr('checked', false);
	}
	//Mostrar u Ocultar Credito
	if(recuperarCookie("mostrarCreditoVenta")=="si"){
		$('.Ccredito').show();
		$('#CheckCredito').attr('checked', true);
	}else if(recuperarCookie("mostrarCreditoVenta")=="no"){
		$('.Ccredito').hide();
		$('#CheckCredito').attr('checked', false);
	}
	//Mostrar u Ocultar Tarjeta
	if(recuperarCookie("mostrarTarjetaVenta")=="si"){
		$('.Ctarjeta').show();
		$('#CheckTarjeta').attr('checked', true);
	}else if(recuperarCookie("mostrarTarjetaVenta")=="no"){
		$('.Ctarjeta').hide();
		$('#CheckTarjeta').attr('checked', false);
	}
	//Mostrar u Ocultar Referencia
	if(recuperarCookie("mostrarReferenciaVenta")=="si"){
		$('.Creferencia').show();
		$('#CheckReferencia').attr('checked', true);
	}else if(recuperarCookie("mostrarReferenciaVenta")=="no"){
		$('.Creferencia').hide();
		$('#CheckReferencia').attr('checked', false);
	}
	//Mostrar u Ocultar Subtotal
	if(recuperarCookie("mostrarSubtotalVenta")=="si"){
		$('.Csubtotal').show();
		$('#CheckSubtotal').attr('checked', true);
	}else if(recuperarCookie("mostrarSubtotalVenta")=="no"){
		$('.Csubtotal').hide();
		$('#CheckSubtotal').attr('checked', false);
	}
	//Mostrar u Ocultar Iva
	if(recuperarCookie("mostrarIvaVenta")=="si"){
		$('.Civa').show();
		$('#CheckIva').attr('checked', true);
	}else if(recuperarCookie("mostrarIvaVenta")=="no"){
		$('.Civa').hide();
		$('#CheckIva').attr('checked', false);
	}
	//Mostrar u Ocultar Ieps
	if(recuperarCookie("mostrarIepsVenta")=="si"){
		$('.Cieps').show();
		$('#CheckIeps').attr('checked', true);
	}else if(recuperarCookie("mostrarIepsVenta")=="no"){
		$('.Cieps').hide();
		$('#CheckIeps').attr('checked', false);
	}
	//Mostrar u Ocultar Total
	if(recuperarCookie("mostrarTotalVenta")=="si"){
		$('.Ctotal').show();
		$('#CheckTotal').attr('checked', true);
	}else if(recuperarCookie("mostrarTotalVenta")=="no"){
		$('.Ctotal').hide();
		$('#CheckTotal').attr('checked', false);
	}
	//Mostrar u Ocultar Estado
	if(recuperarCookie("mostrarEstadoVenta")=="si"){
		$('.Cestado').show();
		$('#CheckEstado').attr('checked', true);
	}else if(recuperarCookie("mostrarEstadoVenta")=="no"){
		$('.Cestado').hide();
		$('#CheckEstado').attr('checked', false);
	}
	//Mostrar u Ocultar Idcliente
	if(recuperarCookie("mostrarIdclienteVenta")=="si"){
		$('.Cidcliente').show();
		$('#CheckIdcliente').attr('checked', true);
	}else if(recuperarCookie("mostrarIdclienteVenta")=="no"){
		$('.Cidcliente').hide();
		$('#CheckIdcliente').attr('checked', false);
	}
	//Mostrar u Ocultar Idcaja
	if(recuperarCookie("mostrarIdcajaVenta")=="si"){
		$('.Cidcaja').show();
		$('#CheckIdcaja').attr('checked', true);
	}else if(recuperarCookie("mostrarIdcajaVenta")=="no"){
		$('.Cidcaja').hide();
		$('#CheckIdcaja').attr('checked', false);
	}
	//Mostrar u Ocultar Idempleado
	if(recuperarCookie("mostrarIdempleadoVenta")=="si"){
		$('.Cidempleado').show();
		$('#CheckIdempleado').attr('checked', true);
	}else if(recuperarCookie("mostrarIdempleadoVenta")=="no"){
		$('.Cidempleado').hide();
		$('#CheckIdempleado').attr('checked', false);
	}
	//Mostrar u Ocultar Idalmacen
	if(recuperarCookie("mostrarIdalmacenVenta")=="si"){
		$('.Cidalmacen').show();
		$('#CheckIdalmacen').attr('checked', true);
	}else if(recuperarCookie("mostrarIdalmacenVenta")=="no"){
		$('.Cidalmacen').hide();
		$('#CheckIdalmacen').attr('checked', false);
	}
	//Mostrar u Ocultar Composicion
	if(recuperarCookie("mostrarComposicionVenta")=="si"){
		$('.Ccomposicion').show();
		$('#CheckComposicion').attr('checked', true);
	}
	if(recuperarCookie("mostrarComposicionVenta")=="no"){
		$('.Ccomposicion').hide();
		$('#CheckComposicion').attr('checked', false);
	}
	
	//Elegir el tipo de vista
	if(recuperarCookie("tipoVistaVenta")=="tabla"){
		$('.tipoLista').show();
		$('.tipoTabla').hide();
		tipoVista="tabla";
	}else{
		$('.tipoLista').hide();
		$('.tipoTabla').show();
		tipoVista="lista";
	}
	$( ".tipoTabla" ).click(function() {
    	crearCookie("tipoVistaVenta", "tabla");
		tipoVista="tabla";
		$(".tipoLista").show();
		$(".tipoTabla").hide();
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$( ".tipoLista" ).click(function() {
    	crearCookie("tipoVistaVenta", "lista");
		tipoVista="lista";
		$(".tipoLista").hide();
		$(".tipoTabla").show();
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	
	$( "#botonFitrar" ).click(function() {
    	//alert("hola");
	});

}

	
$(document).ready(function() {
	$("#cajaBuscar").focus();
	comprobarReglas();
	llenarSelectAlmacen("");
	load_tablas(campoOrden,orden,cantidadamostrar,paginacion,busqueda,tipoVista);
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
	$( "#autorfccliente" ).autocomplete({
        source: "../componentes/buscarRFCCliente.php",
		autoFocus:true,
		select:function(event,ui){ 
        	$('#crfccliente').val(ui.item.id);
			$('#consultarfccliente').val(ui.item.consulta);
    	},
		search: function (event, ui) {
			$("#crfccliente").val("");
			$("#consultarfccliente").val($("#autorfccliente").val());
		},
		change: function (event, ui) {
			$.ajax({
            	url:'../componentes/RFCCliente.php',
            	type:'POST',
            	dataType:'json',
				/*En caso de generar una descripció "label" compuesta por dos o mas datos
				en el archivo buscarX.php será necesario cambiar el termino 
				$('#autoX').val() por $('#consultaX').val()*/
            	data:{ termino:$('#autorfccliente').val()}
        		}).done(function(respuesta){
            		$("#crfccliente").val(respuesta.id);
        	});
		},
        minLength: 1
    });
	// FIN AUTOCOMPLETAR
	
	
	$(".botonEliminar").click(function() {
		$("#barraPaginacion").hide();
		$(".cajaBorrar").show();
		$(".herramientasIndividuales").hide();
		$(".checksEliminar").show();
	});
	
	$(".botonCancelarBorrar").click(function() {
		$(".herramientasIndividuales").show();
		$("#barraPaginacion").show();
		$(".cajaBorrar").hide();
		$(".checksEliminar").hide();
	});
	
	$(".botonBorrar").click(function() {
		var pregunta = confirm("¿Desea borrar esta información?")
		if (pregunta){
			$(".herramientasIndividuales").show("slow");
			$("#barraPaginacion").show("slow");
			$(".cajaBorrar").hide();
			$(".checksEliminar").hide("slow");
			var valores = [];
			var todos = document.getElementsByName("registroEliminar[]");
			for(var i = 0; i < todos.length; i++){
				if (todos[i].checked){
					valores.push(todos[i].value);
				}
			}
			eliminar_registros(valores);
		}else{
			$(".herramientasIndividuales").show("slow");
			$("#barraPaginacion").show("slow");
			$(".cajaBorrar").hide();
			$(".checksEliminar").hide("slow");
		}
	});
	
	$("#campoOrden").change(function(){
		campoOrden = this.value;
		crearCookie("campoOrdenVenta", campoOrden);
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$("#cantidadamostrar").change(function(){
		cantidadamostrar = this.value;
		crearCookie("cantidadamostrarVenta", cantidadamostrar);
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$( "#asc" ).click(function() {
    	if ($( "#asc" ).is(':checked')){
			crearCookie("ordenVenta", "asc");
			orden="ASC"
			load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
		}
	});
	$( "#desc" ).click(function() {
    	if ($( "#desc" ).is(':checked')){
			crearCookie("ordenVenta", "desc");
			orden="DESC"
			load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
		}
	});
	$( "#CheckIdventa" ).click(function() {
    	if ($( "#CheckIdventa" ).is(':checked')){
			crearCookie("mostrarIdventaVenta", "si");
			$('.Cidventa').show();
		}else{
			crearCookie("mostrarIdventaVenta", "no");
			$('.Cidventa').hide();
		}	
	});
	$( "#CheckFecha" ).click(function() {
    	if ($( "#CheckFecha" ).is(':checked')){
			crearCookie("mostrarFechaVenta", "si");
			$('.Cfecha').show();
		}else{
			crearCookie("mostrarFechaVenta", "no");
			$('.Cfecha').hide();
		}	
	});
	$( "#CheckHora" ).click(function() {
    	if ($( "#CheckHora" ).is(':checked')){
			crearCookie("mostrarHoraVenta", "si");
			$('.Chora').show();
		}else{
			crearCookie("mostrarHoraVenta", "no");
			$('.Chora').hide();
		}	
	});
	$( "#CheckFormapago" ).click(function() {
    	if ($( "#CheckFormapago" ).is(':checked')){
			crearCookie("mostrarFormapagoVenta", "si");
			$('.Cformapago').show();
		}else{
			crearCookie("mostrarFormapagoVenta", "no");
			$('.Cformapago').hide();
		}	
	});
	$( "#CheckEfectivo" ).click(function() {
    	if ($( "#CheckEfectivo" ).is(':checked')){
			crearCookie("mostrarEfectivoVenta", "si");
			$('.Cefectivo').show();
		}else{
			crearCookie("mostrarEfectivoVenta", "no");
			$('.Cefectivo').hide();
		}	
	});
	$( "#CheckCredito" ).click(function() {
    	if ($( "#CheckCredito" ).is(':checked')){
			crearCookie("mostrarCreditoVenta", "si");
			$('.Ccredito').show();
		}else{
			crearCookie("mostrarCreditoVenta", "no");
			$('.Ccredito').hide();
		}	
	});
	$( "#CheckTarjeta" ).click(function() {
    	if ($( "#CheckTarjeta" ).is(':checked')){
			crearCookie("mostrarTarjetaVenta", "si");
			$('.Ctarjeta').show();
		}else{
			crearCookie("mostrarTarjetaVenta", "no");
			$('.Ctarjeta').hide();
		}	
	});
	$( "#CheckReferencia" ).click(function() {
    	if ($( "#CheckReferencia" ).is(':checked')){
			crearCookie("mostrarReferenciaVenta", "si");
			$('.Creferencia').show();
		}else{
			crearCookie("mostrarReferenciaVenta", "no");
			$('.Creferencia').hide();
		}	
	});
	$( "#CheckSubtotal" ).click(function() {
    	if ($( "#CheckSubtotal" ).is(':checked')){
			crearCookie("mostrarSubtotalVenta", "si");
			$('.Csubtotal').show();
		}else{
			crearCookie("mostrarSubtotalVenta", "no");
			$('.Csubtotal').hide();
		}	
	});
	$( "#CheckIva" ).click(function() {
    	if ($( "#CheckIva" ).is(':checked')){
			crearCookie("mostrarIvaVenta", "si");
			$('.Civa').show();
		}else{
			crearCookie("mostrarIvaVenta", "no");
			$('.Civa').hide();
		}	
	});
	$( "#CheckIeps" ).click(function() {
    	if ($( "#CheckIeps" ).is(':checked')){
			crearCookie("mostrarIepsVenta", "si");
			$('.Cieps').show();
		}else{
			crearCookie("mostrarIepsVenta", "no");
			$('.Cieps').hide();
		}	
	});
	$( "#CheckTotal" ).click(function() {
    	if ($( "#CheckTotal" ).is(':checked')){
			crearCookie("mostrarTotalVenta", "si");
			$('.Ctotal').show();
		}else{
			crearCookie("mostrarTotalVenta", "no");
			$('.Ctotal').hide();
		}	
	});
	$( "#CheckEstado" ).click(function() {
    	if ($( "#CheckEstado" ).is(':checked')){
			crearCookie("mostrarEstadoVenta", "si");
			$('.Cestado').show();
		}else{
			crearCookie("mostrarEstadoVenta", "no");
			$('.Cestado').hide();
		}	
	});
	$( "#CheckIdcliente" ).click(function() {
    	if ($( "#CheckIdcliente" ).is(':checked')){
			crearCookie("mostrarIdclienteVenta", "si");
			$('.Cidcliente').show();
		}else{
			crearCookie("mostrarIdclienteVenta", "no");
			$('.Cidcliente').hide();
		}	
	});
	$( "#CheckIdcaja" ).click(function() {
    	if ($( "#CheckIdcaja" ).is(':checked')){
			crearCookie("mostrarIdcajaVenta", "si");
			$('.Cidcaja').show();
		}else{
			crearCookie("mostrarIdcajaVenta", "no");
			$('.Cidcaja').hide();
		}	
	});
	$( "#CheckIdempleado" ).click(function() {
    	if ($( "#CheckIdempleado" ).is(':checked')){
			crearCookie("mostrarIdempleadoVenta", "si");
			$('.Cidempleado').show();
		}else{
			crearCookie("mostrarIdempleadoVenta", "no");
			$('.Cidempleado').hide();
		}	
	});
	$( "#CheckIdalmacen" ).click(function() {
    	if ($( "#CheckIdalmacen" ).is(':checked')){
			crearCookie("mostrarIdalmacenVenta", "si");
			$('.Cidalmacen').show();
		}else{
			crearCookie("mostrarIdalmacenVenta", "no");
			$('.Cidalmacen').hide();
		}	
	});
	$( "#CheckComposicion" ).click(function() {
    	if ($( "#CheckComposicion" ).is(':checked')){
			crearCookie("mostrarComposicionVenta", "si");
			$('.Ccomposicion').show();
		}else{
			crearCookie("mostrarComposicionVenta", "no");
			$('.Ccomposicion').hide();
		}
	});
	
	$(".botonBuscar").click(function() {
		var busqueda=$.trim( $("#cajaBuscar").val());
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,busqueda,tipoVista);
	});
	
	$("#botonFiltrar").click(function() {
		var busqueda=$.trim( $("#cajaBuscar").val());
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,busqueda,tipoVista);
		var valor=$("#cestadopago").val();
		if (valor=="CON REP"){
			$(".botonFacturar").hide();
		}
		if (valor=="SIN REP"){
			$(".botonFacturar").show();
		}
		if (valor=="TODOS"){
			$(".botonFacturar").hide();
		}
	});
	
	$(".botonExportar").click(function() {
		var busqueda=$.trim( $("#cajaBuscar").val());
		exportar(campoOrden,orden,cantidadamostrar,paginacion,busqueda,tipoVista);
	});
	
	$(".botonFacturar").click(function() {
		var busqueda=$.trim( $("#cajaBuscar").val());
		facturar(campoOrden,orden,cantidadamostrar,paginacion,busqueda,tipoVista);
	});
	
	 $("#cajaBuscar").keypress(function(event){  
      	var keycode = (event.keyCode ? event.keyCode : event.which); 
      	if(keycode == '13'){  
      		var busqueda=$.trim( $("#cajaBuscar").val());
      		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,busqueda,tipoVista);
			$("#cajaBuscar").val("");
			$("#cajaBuscar").focus();
      	}     
 	}); 
	
	$(".botonNormal").click(function(){ 
		$("#panel_alertas").stop(false, true);
 	});
	
	/*Importante*/
	$('.dropdown-menu').on('click', function(e){
        if($(this).hasClass('dropdown-menu-form')){
            e.stopPropagation();
        }
	});
	
	$(".close").click(function(){ 
		$("#panel_alertas").stop(false, true);
		$("#panel_alertas").hide();
 	});
	
	/*Fin de Importante*/
	
});

//***********************AJAX*********************

// Autor: Armando Viera Rodríguez
// Onixbm 2014
function load_tablas (campoOrden, orden, cantidadamostrar, paginacion, busqueda, tipoVista){
	//alert (orden);
	//alert (campoOrden);
	//alert (limit);
	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById("muestra_contenido_ajax").innerHTML=xmlhttp.responseText;
			comprobarReglas();
			$("#loading").hide();
		}
		else{
			$("#loading").show();
		}
	}
	var idcliente, idalmacen, tipo, ticket, fitlarfecha, fechainicio, fechafin, clasificacion, formapago;
	idcliente=$("#cidcliente").val();
	idalmacen=$("#idalmacen_ajax").val();
	tipo=$("#ctipo").val();
	ticket=$("#cticket").val();
	filtrarfecha=$("#cfiltrarfecha").val();
	fechainicio=$("#cfechainicio").val();
	fechafin=$("#cfechafin").val();
	clasificacion=$("#cclasificacion").val();
	formapago=$("#cformapago").val();
	diacobro=$("#cdiacobro").val();
	facturada=$("#cfacturada").val();
	domicilio=$("#cdomicilio").val();
	rfccliente=$("#crfccliente").val();
	estadopago=$("#cestadopago").val();
	xmlhttp.open("POST","rep_consultar.php?campoOrden="+campoOrden+"&orden="+orden+"&cantidadamostrar="+cantidadamostrar+"&paginacion="+paginacion+"&busqueda="+busqueda+"&tipoVista="+tipoVista+"&papelera="+papelera+"&idcliente="+idcliente+"&idalmacen="+idalmacen+"&ticket="+ticket+"&tipo="+tipo+"&filtrarfecha="+filtrarfecha+"&fechainicio="+fechainicio+"&fechafin="+fechafin+"&clasificacion="+clasificacion+"&formapago="+formapago+"&diacobro="+diacobro+"&facturada="+facturada+"&domicilio="+domicilio+"&estadopago="+estadopago+"&rfccliente="+rfccliente, true);
	xmlhttp.send();
}

function exportar(campoOrden, orden, cantidadamostrar, paginacion, busqueda, tipoVista){
	var idcliente, idalmacen, tipo, ticket, fitlarfecha, fechainicio, fechafin, clasificacion, formapago;
	idcliente=$("#cidcliente").val();
	idalmacen=$("#idalmacen_ajax").val();
	tipo=$("#ctipo").val();
	ticket=$("#cticket").val();
	filtrarfecha=$("#cfiltrarfecha").val();
	fechainicio=$("#cfechainicio").val();
	fechafin=$("#cfechafin").val();
	clasificacion=$("#cclasificacion").val();
	formapago=$("#cformapago").val();
	diacobro=$("#cdiacobro").val();
	facturada=$("#cfacturada").val();
	domicilio=$("#cdomicilio").val();
	rfccliente=$("#crfccliente").val();
	estadopago=$("#cestadopago").val();
	window.open("general_excel.php?campoOrden="+campoOrden+"&orden="+orden+"&cantidadamostrar="+cantidadamostrar+"&paginacion="+paginacion+"&busqueda="+busqueda+"&tipoVista="+tipoVista+"&papelera="+papelera+"&idcliente="+idcliente+"&idalmacen="+idalmacen+"&ticket="+ticket+"&tipo="+tipo+"&filtrarfecha="+filtrarfecha+"&fechainicio="+fechainicio+"&fechafin="+fechafin+"&clasificacion="+clasificacion+"&formapago="+formapago+"&diacobro="+diacobro+"&facturada="+facturada+"&domicilio="+domicilio+"&estadopago="+estadopago+"&rfccliente="+rfccliente);
}

function facturar(campoOrden, orden, cantidadamostrar, paginacion, busqueda, tipoVista){
	var idcliente, idalmacen, tipo, ticket, fitlarfecha, fechainicio, fechafin, clasificacion, formapago;
	idcliente=$("#cidcliente").val();
	idalmacen=$("#idalmacen_ajax").val();
	tipo=$("#ctipo").val();
	ticket=$("#cticket").val();
	filtrarfecha=$("#cfiltrarfecha").val();
	fechainicio=$("#cfechainicio").val();
	fechafin=$("#cfechafin").val();
	clasificacion=$("#cclasificacion").val();
	formapago=$("#cformapago").val();
	diacobro=$("#cdiacobro").val();
	facturada=$("#cfacturada").val();
	domicilio=$("#cdomicilio").val();
	rfccliente=$("#crfccliente").val();
	estadopago=$("#cestadopago").val();
	window.open("rep_facturar.php?campoOrden="+campoOrden+"&orden="+orden+"&cantidadamostrar="+cantidadamostrar+"&paginacion="+paginacion+"&busqueda="+busqueda+"&tipoVista="+tipoVista+"&papelera="+papelera+"&idcliente="+idcliente+"&idalmacen="+idalmacen+"&ticket="+ticket+"&tipo="+tipo+"&filtrarfecha="+filtrarfecha+"&fechainicio="+fechainicio+"&fechafin="+fechafin+"&clasificacion="+clasificacion+"&formapago="+formapago+"&diacobro="+diacobro+"&facturada="+facturada+"&domicilio="+domicilio+"&estadopago="+estadopago+"&rfccliente="+rfccliente);
}

function eliminar_registros(ids){
		
		$.ajax({
			url: '../eliminar/eliminar.php',
			type: "POST",
			data: {ids:ids}, //Pasamos los datos en forma de array
			success: function(mensaje){
				mostrarMensaje(mensaje,ids,"eliminar");
			}
		});
		return false;
}

function eliminar_individual(id){
		$.ajax({
			url: '../eliminar/eliminar.php',
			type: "POST",
			data: "submit=&ids="+id, //Pasamos los datos en forma de array
			success: function(mensaje){
				mostrarMensaje(mensaje,id,"eliminar");
			}
		});
		return false;
}

function restaurar_individual(id){
		$.ajax({
			url: '../eliminar/restaurar.php',
			type: "POST",
			data: "submit=&ids="+id, //Pasamos los datos en forma de array
			success: function(mensaje){
				mostrarMensaje(mensaje,id,"eliminar");
			}
		});
		return false;
}

function mostrarMensaje(mensaje,ids, accion){
	var cadena= $.trim(mensaje); //Limpia la cadena regresada desde php
	var res=cadena.split("@"); //Separa la cadena en cada @ y convierte las partes en un array
	if (res[0]=="exito"){ //Si la primer frase contiene la palabra "exito"
		$("#panel_alertas").removeClass().addClass("alert alert-success alert-dismissable");
		$("#notificacionTitulo").html("<i class='icon fa fa-check'></i>"+res[1]);
		$("#notificacionContenido").html(res[2]);
		if(accion=="eliminar"){
			ocultar_registros_eliminados(ids);
		}
		$(".checkEliminar").attr('checked', false);
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
		$("#notificacionContenido").html("<i class='icon fa fa-ban'></i>No se han resivido datos de respuesta desde el servidor [003]");
	}
	$("#panel_alertas").stop(false, true);
	$("#panel_alertas").fadeIn("slow");
	$("#panel_alertas").delay(5000).fadeOut("slow");
}
function ocultar_registros_eliminados(ids){
	if (ids.length){
		for(var i = 0; i < ids.length; i++){
			$("#iregistro"+ids[i]).hide("slow");
		}
	}
	else{
		$("#iregistro"+ids).hide("slow");
	}
}