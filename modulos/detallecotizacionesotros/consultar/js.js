// JavaScript Document
var orden, campoOrden, cantidadamostrar, paginacion;
orden="DESC";
campoOrden="iddetallecotizacionotros";
iniciar="0";
cantidadamostrar="20";
paginacion=0;

function actualizarDato2(campo,valor,iddetallecotizacionotros){
	$.ajax({
		url: 'guardar.php',
		type: "POST",
		data: "submit=&campo="+campo+"&valor="+valor+"&iddetallecotizacionotros="+iddetallecotizacionotros, //Pasamos los datos en forma de array seralizado desde la funcion de envio
		success: function(mensaje){
			$("#"+componente).css("color","#096");
		}
	});
}

function actualizarDato(cantidad,componente,campo,iddetallecotizacionotros,idmodeloimpuestos){
		var valor=$("#"+componente).val();
		var cantidad=$("#"+cantidad).html();
		$("#"+componente).css("color","#FC0");
		
		var precio=parseFloat($("#precio"+iddetallecotizacionotros).val());
		
		$.ajax({
			url: 'guardar.php',
			type: "POST",
			data: "submit=&campo="+campo+"&valor="+valor+"&iddetallecotizacionotros="+iddetallecotizacionotros+"&idmodeloimpuestos="+idmodeloimpuestos+"&cantidad="+cantidad, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#botonGuardar").show();
				$(".loading").hide();
				$("#"+componente).css("color","#096");
				var aMensaje=mensaje.split("@"); 
				var impuestos = aMensaje[3];
				var total = aMensaje[4];
				if(total!="SeActualizoFecha"){
					$("#impuestos"+iddetallecotizacionotros).html(impuestos);
					$("#total"+iddetallecotizacionotros).html(total);
				}
				
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
function restaurarIndividual(id) {
	var encoded = "¿Desea restaurar el registro?";
	var decoded = $("<div/>").html(encoded).text();
    var pregunta = confirm(decoded);
	if (pregunta){
		restaurar_individual(id);
	}
}
function comprobarReglas(){
	$(".checksEliminar").hide();
	//Identificar el campo de ordenamiento
	if(recuperarCookie("campoOrdenDetallecotizacionotro")!=null){
		campoOrden=recuperarCookie("campoOrdenDetallecotizacionotro");
		 $("#campoOrden option[value="+campoOrden+"]").attr("selected",true);
	}else{
		campoOrden="iddetallecotizacionotros";
		$("#campoOrden option[value="+campoOrden+"]").attr("selected",true);
	}
	
	//Identificar el numero de elementos para mostrar
	if(recuperarCookie("cantidadamostrarDetallecotizacionotro")!=null){
		cantidadamostrar=recuperarCookie("cantidadamostrarDetallecotizacionotro");
		 $("#cantidadamostrar option[value="+cantidadamostrar+"]").attr("selected",true);
	}else{
		cantidadamostrar="20";
		$("#cantidadamostrar option[value="+cantidadamostrar+"]").attr("selected",true);
		
	}
	
	//Identificar el tipo de orden
	if(recuperarCookie("ordenDetallecotizacionotro")=="asc"){
		orden="ASC"
		$('#asc').attr('checked', true);
		$('#desc').attr('checked', false);
	}else if(recuperarCookie("ordenDetallecotizacionotro")=="desc"){
		orden="DESC"
		$('#asc').attr('checked', false);
		$('#desc').attr('checked', true);
	}else{
		orden="DESC"
		$('#asc').attr('checked', false);
		$('#desc').attr('checked', true);
	}
	//Mostrar u Ocultar Idcliente
	if(recuperarCookie("mostrarIdclienteDetallecotizacionotro")=="si"){
		$('.Cidcliente').show();
		$('#CheckIdcliente').attr('checked', true);
	}else if(recuperarCookie("mostrarIdclienteDetallecotizacionotro")=="no"){
		$('.Cidcliente').hide();
		$('#CheckIdcliente').attr('checked', false);
	}
	//Mostrar u Ocultar Fecha
	if(recuperarCookie("mostrarFechaDetallecotizacionotro")=="si"){
		$('.Cfecha').show();
		$('#CheckFecha').attr('checked', true);
	}else if(recuperarCookie("mostrarFechaDetallecotizacionotro")=="no"){
		$('.Cfecha').hide();
		$('#CheckFecha').attr('checked', false);
	}
	//Mostrar u Ocultar Cantidad
	if(recuperarCookie("mostrarCantidadDetallecotizacionotro")=="si"){
		$('.Ccantidad').show();
		$('#CheckCantidad').attr('checked', true);
	}else if(recuperarCookie("mostrarCantidadDetallecotizacionotro")=="no"){
		$('.Ccantidad').hide();
		$('#CheckCantidad').attr('checked', false);
	}
	//Mostrar u Ocultar Concepto
	if(recuperarCookie("mostrarConceptoDetallecotizacionotro")=="si"){
		$('.Cconcepto').show();
		$('#CheckConcepto').attr('checked', true);
	}else if(recuperarCookie("mostrarConceptoDetallecotizacionotro")=="no"){
		$('.Cconcepto').hide();
		$('#CheckConcepto').attr('checked', false);
	}
	//Mostrar u Ocultar Unidad
	if(recuperarCookie("mostrarUnidadDetallecotizacionotro")=="si"){
		$('.Cunidad').show();
		$('#CheckUnidad').attr('checked', true);
	}else if(recuperarCookie("mostrarUnidadDetallecotizacionotro")=="no"){
		$('.Cunidad').hide();
		$('#CheckUnidad').attr('checked', false);
	}
	//Mostrar u Ocultar Numeroservicio
	if(recuperarCookie("mostrarNumeroservicioDetallecotizacionotro")=="si"){
		$('.Cnumeroservicio').show();
		$('#CheckNumeroservicio').attr('checked', true);
	}else if(recuperarCookie("mostrarNumeroservicioDetallecotizacionotro")=="no"){
		$('.Cnumeroservicio').hide();
		$('#CheckNumeroservicio').attr('checked', false);
	}
	//Mostrar u Ocultar Totalservicios
	if(recuperarCookie("mostrarTotalserviciosDetallecotizacionotro")=="si"){
		$('.Ctotalservicios').show();
		$('#CheckTotalservicios').attr('checked', true);
	}else if(recuperarCookie("mostrarTotalserviciosDetallecotizacionotro")=="no"){
		$('.Ctotalservicios').hide();
		$('#CheckTotalservicios').attr('checked', false);
	}
	//Mostrar u Ocultar Idcotizacionotros
	if(recuperarCookie("mostrarIdcotizacionotrosDetallecotizacionotro")=="si"){
		$('.Cidcotizacionotros').show();
		$('#CheckIdcotizacionotros').attr('checked', true);
	}else if(recuperarCookie("mostrarIdcotizacionotrosDetallecotizacionotro")=="no"){
		$('.Cidcotizacionotros').hide();
		$('#CheckIdcotizacionotros').attr('checked', false);
	}
	//Mostrar u Ocultar Precio
	if(recuperarCookie("mostrarPrecioDetallecotizacionotro")=="si"){
		$('.Cprecio').show();
		$('#CheckPrecio').attr('checked', true);
	}else if(recuperarCookie("mostrarPrecioDetallecotizacionotro")=="no"){
		$('.Cprecio').hide();
		$('#CheckPrecio').attr('checked', false);
	}
	//Mostrar u Ocultar Impuestos
	if(recuperarCookie("mostrarImpuestosDetallecotizacionotro")=="si"){
		$('.Cimpuestos').show();
		$('#CheckImpuestos').attr('checked', true);
	}else if(recuperarCookie("mostrarImpuestosDetallecotizacionotro")=="no"){
		$('.Cimpuestos').hide();
		$('#CheckImpuestos').attr('checked', false);
	}
	//Mostrar u Ocultar Total
	if(recuperarCookie("mostrarTotalDetallecotizacionotro")=="si"){
		$('.Ctotal').show();
		$('#CheckTotal').attr('checked', true);
	}else if(recuperarCookie("mostrarTotalDetallecotizacionotro")=="no"){
		$('.Ctotal').hide();
		$('#CheckTotal').attr('checked', false);
	}
	//Mostrar u Ocultar Idmodeloimpuestos
	if(recuperarCookie("mostrarIdmodeloimpuestosDetallecotizacionotro")=="si"){
		$('.Cidmodeloimpuestos').show();
		$('#CheckIdmodeloimpuestos').attr('checked', true);
	}else if(recuperarCookie("mostrarIdmodeloimpuestosDetallecotizacionotro")=="no"){
		$('.Cidmodeloimpuestos').hide();
		$('#CheckIdmodeloimpuestos').attr('checked', false);
	}
	//Mostrar u Ocultar Estadopago
	if(recuperarCookie("mostrarEstadopagoDetallecotizacionotro")=="si"){
		$('.Cestadopago').show();
		$('#CheckEstadopago').attr('checked', true);
	}else if(recuperarCookie("mostrarEstadopagoDetallecotizacionotro")=="no"){
		$('.Cestadopago').hide();
		$('#CheckEstadopago').attr('checked', false);
	}
	//Mostrar u Ocultar Estadofacturacion
	if(recuperarCookie("mostrarEstadofacturacionDetallecotizacionotro")=="si"){
		$('.Cestadofacturacion').show();
		$('#CheckEstadofacturacion').attr('checked', true);
	}else if(recuperarCookie("mostrarEstadofacturacionDetallecotizacionotro")=="no"){
		$('.Cestadofacturacion').hide();
		$('#CheckEstadofacturacion').attr('checked', false);
	}
	//Mostrar u Ocultar Factura
	if(recuperarCookie("mostrarFacturaDetallecotizacionotro")=="si"){
		$('.Cfactura').show();
		$('#CheckFactura').attr('checked', true);
	}else if(recuperarCookie("mostrarFacturaDetallecotizacionotro")=="no"){
		$('.Cfactura').hide();
		$('#CheckFactura').attr('checked', false);
	}
	//Mostrar u Ocultar Estatus
	if(recuperarCookie("mostrarEstatusDetallecotizacionotro")=="si"){
		$('.Cestatus').show();
		$('#CheckEstatus').attr('checked', true);
	}else if(recuperarCookie("mostrarEstatusDetallecotizacionotro")=="no"){
		$('.Cestatus').hide();
		$('#CheckEstatus').attr('checked', false);
	}
	//Mostrar u Ocultar Composicion
	if(recuperarCookie("mostrarComposicionDetallecotizacionotro")=="si"){
		$('.Ccomposicion').show();
		$('#CheckComposicion').attr('checked', true);
	}
	if(recuperarCookie("mostrarComposicionDetallecotizacionotro")=="no"){
		$('.Ccomposicion').hide();
		$('#CheckComposicion').attr('checked', false);
	}
	
	//Elegir el tipo de vista
	if(recuperarCookie("tipoVistaDetallecotizacionotro")=="tabla"){
		$('.tipoLista').show();
		$('.tipoTabla').hide();
		tipoVista="tabla";
	}else{
		$('.tipoLista').hide();
		$('.tipoTabla').show();
		tipoVista="lista";
	}
	$( ".tipoTabla" ).click(function() {
    	crearCookie("tipoVistaDetallecotizacionotro", "tabla");
		tipoVista="tabla";
		$(".tipoLista").show();
		$(".tipoTabla").hide();
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$( ".tipoLista" ).click(function() {
    	crearCookie("tipoVistaDetallecotizacionotro", "lista");
		tipoVista="lista";
		$(".tipoLista").hide();
		$(".tipoTabla").show();
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});

}

	
$(document).ready(function() {
	$("#cajaBuscar").focus();
	comprobarReglas();
	
	//COMPROBAR SI HAY UN IDCOTIZACIÓN CARGADO EN EL TEXTO IDCOTICAZION DE SER VERDADERO CONSULTAR TODOS LOS SERVICIOS RELACIONADOS
	if($("#idcotizacionesotros").val()!="" || $("#iddetallecotizacionotros").val()!=""){
	    load_tablas(campoOrden,orden,cantidadamostrar,paginacion,busqueda,tipoVista);
	}
	
	//QUITO LA FUNCION load_tablas PARA QUE NO CONSULTE POR DEFAULT SI NO HASTA QUE LE DEN CLIC EN FILTRAR
	//load_tablas(campoOrden,orden,cantidadamostrar,paginacion,busqueda,tipoVista);
	$("#loading").hide();//ocultar engrane que se queda como si estuviera consultando
	
	llenarSelectSucursal(idsucursalseleccionada);
	
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
		crearCookie("campoOrdenDetallecotizacionotro", campoOrden);
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$("#cantidadamostrar").change(function(){
		cantidadamostrar = this.value;
		crearCookie("cantidadamostrarDetallecotizacionotro", cantidadamostrar);
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$( "#asc" ).click(function() {
    	if ($( "#asc" ).is(':checked')){
			crearCookie("ordenDetallecotizacionotro", "asc");
			orden="ASC"
			load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
		}
	});
	$( "#desc" ).click(function() {
    	if ($( "#desc" ).is(':checked')){
			crearCookie("ordenDetallecotizacionotro", "desc");
			orden="DESC"
			load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
		}
	});
	$( "#CheckIdcliente" ).click(function() {
    	if ($( "#CheckIdcliente" ).is(':checked')){
			crearCookie("mostrarIdclienteDetallecotizacionotro", "si");
			$('.Cidcliente').show();
		}else{
			crearCookie("mostrarIdclienteDetallecotizacionotro", "no");
			$('.Cidcliente').hide();
		}	
	});
	$( "#CheckFecha" ).click(function() {
    	if ($( "#CheckFecha" ).is(':checked')){
			crearCookie("mostrarFechaDetallecotizacionotro", "si");
			$('.Cfecha').show();
		}else{
			crearCookie("mostrarFechaDetallecotizacionotro", "no");
			$('.Cfecha').hide();
		}	
	});
	$( "#CheckCantidad" ).click(function() {
    	if ($( "#CheckCantidad" ).is(':checked')){
			crearCookie("mostrarCantidadDetallecotizacionotro", "si");
			$('.Ccantidad').show();
		}else{
			crearCookie("mostrarCantidadDetallecotizacionotro", "no");
			$('.Ccantidad').hide();
		}	
	});
	$( "#CheckConcepto" ).click(function() {
    	if ($( "#CheckConcepto" ).is(':checked')){
			crearCookie("mostrarConceptoDetallecotizacionotro", "si");
			$('.Cconcepto').show();
		}else{
			crearCookie("mostrarConceptoDetallecotizacionotro", "no");
			$('.Cconcepto').hide();
		}	
	});
	$( "#CheckUnidad" ).click(function() {
    	if ($( "#CheckUnidad" ).is(':checked')){
			crearCookie("mostrarUnidadDetallecotizacionotro", "si");
			$('.Cunidad').show();
		}else{
			crearCookie("mostrarUnidadDetallecotizacionotro", "no");
			$('.Cunidad').hide();
		}	
	});
	$( "#CheckNumeroservicio" ).click(function() {
    	if ($( "#CheckNumeroservicio" ).is(':checked')){
			crearCookie("mostrarNumeroservicioDetallecotizacionotro", "si");
			$('.Cnumeroservicio').show();
		}else{
			crearCookie("mostrarNumeroservicioDetallecotizacionotro", "no");
			$('.Cnumeroservicio').hide();
		}	
	});
	$( "#CheckTotalservicios" ).click(function() {
    	if ($( "#CheckTotalservicios" ).is(':checked')){
			crearCookie("mostrarTotalserviciosDetallecotizacionotro", "si");
			$('.Ctotalservicios').show();
		}else{
			crearCookie("mostrarTotalserviciosDetallecotizacionotro", "no");
			$('.Ctotalservicios').hide();
		}	
	});
	$( "#CheckIdcotizacionotros" ).click(function() {
    	if ($( "#CheckIdcotizacionotros" ).is(':checked')){
			crearCookie("mostrarIdcotizacionotrosDetallecotizacionotro", "si");
			$('.Cidcotizacionotros').show();
		}else{
			crearCookie("mostrarIdcotizacionotrosDetallecotizacionotro", "no");
			$('.Cidcotizacionotros').hide();
		}	
	});
	$( "#CheckPrecio" ).click(function() {
    	if ($( "#CheckPrecio" ).is(':checked')){
			crearCookie("mostrarPrecioDetallecotizacionotro", "si");
			$('.Cprecio').show();
		}else{
			crearCookie("mostrarPrecioDetallecotizacionotro", "no");
			$('.Cprecio').hide();
		}	
	});
	$( "#CheckImpuestos" ).click(function() {
    	if ($( "#CheckImpuestos" ).is(':checked')){
			crearCookie("mostrarImpuestosDetallecotizacionotro", "si");
			$('.Cimpuestos').show();
		}else{
			crearCookie("mostrarImpuestosDetallecotizacionotro", "no");
			$('.Cimpuestos').hide();
		}	
	});
	$( "#CheckTotal" ).click(function() {
    	if ($( "#CheckTotal" ).is(':checked')){
			crearCookie("mostrarTotalDetallecotizacionotro", "si");
			$('.Ctotal').show();
		}else{
			crearCookie("mostrarTotalDetallecotizacionotro", "no");
			$('.Ctotal').hide();
		}	
	});
	$( "#CheckIdmodeloimpuestos" ).click(function() {
    	if ($( "#CheckIdmodeloimpuestos" ).is(':checked')){
			crearCookie("mostrarIdmodeloimpuestosDetallecotizacionotro", "si");
			$('.Cidmodeloimpuestos').show();
		}else{
			crearCookie("mostrarIdmodeloimpuestosDetallecotizacionotro", "no");
			$('.Cidmodeloimpuestos').hide();
		}	
	});
	$( "#CheckEstadopago" ).click(function() {
    	if ($( "#CheckEstadopago" ).is(':checked')){
			crearCookie("mostrarEstadopagoDetallecotizacionotro", "si");
			$('.Cestadopago').show();
		}else{
			crearCookie("mostrarEstadopagoDetallecotizacionotro", "no");
			$('.Cestadopago').hide();
		}	
	});
	$( "#CheckEstadofacturacion" ).click(function() {
    	if ($( "#CheckEstadofacturacion" ).is(':checked')){
			crearCookie("mostrarEstadofacturacionDetallecotizacionotro", "si");
			$('.Cestadofacturacion').show();
		}else{
			crearCookie("mostrarEstadofacturacionDetallecotizacionotro", "no");
			$('.Cestadofacturacion').hide();
		}	
	});
	$( "#CheckFactura" ).click(function() {
    	if ($( "#CheckFactura" ).is(':checked')){
			crearCookie("mostrarFacturaDetallecotizacionotro", "si");
			$('.Cfactura').show();
		}else{
			crearCookie("mostrarFacturaDetallecotizacionotro", "no");
			$('.Cfactura').hide();
		}	
	});
	$( "#CheckEstatus" ).click(function() {
    	if ($( "#CheckEstatus" ).is(':checked')){
			crearCookie("mostrarEstatusDetallecotizacionotro", "si");
			$('.Cestatus').show();
		}else{
			crearCookie("mostrarEstatusDetallecotizacionotro", "no");
			$('.Cestatus').hide();
		}	
	});
	$( "#CheckComposicion" ).click(function() {
    	if ($( "#CheckComposicion" ).is(':checked')){
			crearCookie("mostrarComposicionDetallecotizacionotro", "si");
			$('.Ccomposicion').show();
		}else{
			crearCookie("mostrarComposicionDetallecotizacionotro", "no");
			$('.Ccomposicion').hide();
		}
	});
	
	$(".botonBuscar").click(function() {
		var busqueda=$.trim( $("#cajaBuscar").val());
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,busqueda,tipoVista);
	});
	
		$("#botonFiltrar").click(function() {
			load_tablas(campoOrden,orden,cantidadamostrar,paginacion,busqueda,tipoVista);
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
	var variables = $("#formulario").serialize();
	
	
	xmlhttp.open("POST","consultar.php?campoOrden="+campoOrden+"&orden="+orden+"&cantidadamostrar="+cantidadamostrar+"&paginacion="+paginacion+"&busqueda="+busqueda+"&tipoVista="+tipoVista+"&papelera="+papelera+"&"+variables, true);
	xmlhttp.send();
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