// JavaScript Document
var orden, campoOrden, cantidadamostrar, paginacion;
orden="DESC";
campoOrden="idcotizacionproducto";
iniciar="0";
cantidadamostrar="20";
paginacion=0;
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
	if(recuperarCookie("campoOrdenCotizacionproducto")!=null){
		campoOrden=recuperarCookie("campoOrdenCotizacionproducto");
		 $("#campoOrden option[value="+campoOrden+"]").attr("selected",true);
	}else{
		campoOrden="idcotizacionproducto";
		$("#campoOrden option[value="+campoOrden+"]").attr("selected",true);
	}
	
	//Identificar el numero de elementos para mostrar
	if(recuperarCookie("cantidadamostrarCotizacionproducto")!=null){
		cantidadamostrar=recuperarCookie("cantidadamostrarCotizacionproducto");
		 $("#cantidadamostrar option[value="+cantidadamostrar+"]").attr("selected",true);
	}else{
		cantidadamostrar="20";
		$("#cantidadamostrar option[value="+cantidadamostrar+"]").attr("selected",true);
		
	}
	
	//Identificar el tipo de orden
	if(recuperarCookie("ordenCotizacionproducto")=="asc"){
		orden="ASC"
		$('#asc').attr('checked', true);
		$('#desc').attr('checked', false);
	}else if(recuperarCookie("ordenCotizacionproducto")=="desc"){
		orden="DESC"
		$('#asc').attr('checked', false);
		$('#desc').attr('checked', true);
	}else{
		orden="DESC"
		$('#asc').attr('checked', false);
		$('#desc').attr('checked', true);
	}
	//Mostrar u Ocultar Idcotizacionproducto
	if(recuperarCookie("mostrarIdcotizacionproductoCotizacionproducto")=="si"){
		$('.Cidcotizacionproducto').show();
		$('#CheckIdcotizacionproducto').attr('checked', true);
	}else if(recuperarCookie("mostrarIdcotizacionproductoCotizacionproducto")=="no"){
		$('.Cidcotizacionproducto').hide();
		$('#CheckIdcotizacionproducto').attr('checked', false);
	}
	//Mostrar u Ocultar Serie
	if(recuperarCookie("mostrarSerieCotizacionproducto")=="si"){
		$('.Cserie').show();
		$('#CheckSerie').attr('checked', true);
	}else if(recuperarCookie("mostrarSerieCotizacionproducto")=="no"){
		$('.Cserie').hide();
		$('#CheckSerie').attr('checked', false);
	}
	//Mostrar u Ocultar Folio
	if(recuperarCookie("mostrarFolioCotizacionproducto")=="si"){
		$('.Cfolio').show();
		$('#CheckFolio').attr('checked', true);
	}else if(recuperarCookie("mostrarFolioCotizacionproducto")=="no"){
		$('.Cfolio').hide();
		$('#CheckFolio').attr('checked', false);
	}
	//Mostrar u Ocultar Fecha
	if(recuperarCookie("mostrarFechaCotizacionproducto")=="si"){
		$('.Cfecha').show();
		$('#CheckFecha').attr('checked', true);
	}else if(recuperarCookie("mostrarFechaCotizacionproducto")=="no"){
		$('.Cfecha').hide();
		$('#CheckFecha').attr('checked', false);
	}
	//Mostrar u Ocultar Hora
	if(recuperarCookie("mostrarHoraCotizacionproducto")=="si"){
		$('.Chora').show();
		$('#CheckHora').attr('checked', true);
	}else if(recuperarCookie("mostrarHoraCotizacionproducto")=="no"){
		$('.Chora').hide();
		$('#CheckHora').attr('checked', false);
	}
	//Mostrar u Ocultar Estadopago
	if(recuperarCookie("mostrarEstadopagoCotizacionproducto")=="si"){
		$('.Cestadopago').show();
		$('#CheckEstadopago').attr('checked', true);
	}else if(recuperarCookie("mostrarEstadopagoCotizacionproducto")=="no"){
		$('.Cestadopago').hide();
		$('#CheckEstadopago').attr('checked', false);
	}
	//Mostrar u Ocultar Estadofacturacion
	if(recuperarCookie("mostrarEstadofacturacionCotizacionproducto")=="si"){
		$('.Cestadofacturacion').show();
		$('#CheckEstadofacturacion').attr('checked', true);
	}else if(recuperarCookie("mostrarEstadofacturacionCotizacionproducto")=="no"){
		$('.Cestadofacturacion').hide();
		$('#CheckEstadofacturacion').attr('checked', false);
	}
	//Mostrar u Ocultar Tipo
	if(recuperarCookie("mostrarTipoCotizacionproducto")=="si"){
		$('.Ctipo').show();
		$('#CheckTipo').attr('checked', true);
	}else if(recuperarCookie("mostrarTipoCotizacionproducto")=="no"){
		$('.Ctipo').hide();
		$('#CheckTipo').attr('checked', false);
	}
	//Mostrar u Ocultar Subtotal
	if(recuperarCookie("mostrarSubtotalCotizacionproducto")=="si"){
		$('.Csubtotal').show();
		$('#CheckSubtotal').attr('checked', true);
	}else if(recuperarCookie("mostrarSubtotalCotizacionproducto")=="no"){
		$('.Csubtotal').hide();
		$('#CheckSubtotal').attr('checked', false);
	}
	//Mostrar u Ocultar Impuestos
	if(recuperarCookie("mostrarImpuestosCotizacionproducto")=="si"){
		$('.Cimpuestos').show();
		$('#CheckImpuestos').attr('checked', true);
	}else if(recuperarCookie("mostrarImpuestosCotizacionproducto")=="no"){
		$('.Cimpuestos').hide();
		$('#CheckImpuestos').attr('checked', false);
	}
	//Mostrar u Ocultar Total
	if(recuperarCookie("mostrarTotalCotizacionproducto")=="si"){
		$('.Ctotal').show();
		$('#CheckTotal').attr('checked', true);
	}else if(recuperarCookie("mostrarTotalCotizacionproducto")=="no"){
		$('.Ctotal').hide();
		$('#CheckTotal').attr('checked', false);
	}
	//Mostrar u Ocultar Idcliente
	if(recuperarCookie("mostrarIdclienteCotizacionproducto")=="si"){
		$('.Cidcliente').show();
		$('#CheckIdcliente').attr('checked', true);
	}else if(recuperarCookie("mostrarIdclienteCotizacionproducto")=="no"){
		$('.Cidcliente').hide();
		$('#CheckIdcliente').attr('checked', false);
	}
	//Mostrar u Ocultar Idusuario
	if(recuperarCookie("mostrarIdusuarioCotizacionproducto")=="si"){
		$('.Cidusuario').show();
		$('#CheckIdusuario').attr('checked', true);
	}else if(recuperarCookie("mostrarIdusuarioCotizacionproducto")=="no"){
		$('.Cidusuario').hide();
		$('#CheckIdusuario').attr('checked', false);
	}
	//Mostrar u Ocultar Idempleado
	if(recuperarCookie("mostrarIdempleadoCotizacionproducto")=="si"){
		$('.Cidempleado').show();
		$('#CheckIdempleado').attr('checked', true);
	}else if(recuperarCookie("mostrarIdempleadoCotizacionproducto")=="no"){
		$('.Cidempleado').hide();
		$('#CheckIdempleado').attr('checked', false);
	}
	//Mostrar u Ocultar Enviaradomicilio
	if(recuperarCookie("mostrarEnviaradomicilioCotizacionproducto")=="si"){
		$('.Cenviaradomicilio').show();
		$('#CheckEnviaradomicilio').attr('checked', true);
	}else if(recuperarCookie("mostrarEnviaradomicilioCotizacionproducto")=="no"){
		$('.Cenviaradomicilio').hide();
		$('#CheckEnviaradomicilio').attr('checked', false);
	}
	//Mostrar u Ocultar Fechaentrega
	if(recuperarCookie("mostrarFechaentregaCotizacionproducto")=="si"){
		$('.Cfechaentrega').show();
		$('#CheckFechaentrega').attr('checked', true);
	}else if(recuperarCookie("mostrarFechaentregaCotizacionproducto")=="no"){
		$('.Cfechaentrega').hide();
		$('#CheckFechaentrega').attr('checked', false);
	}
	//Mostrar u Ocultar Horaentregainicio
	if(recuperarCookie("mostrarHoraentregainicioCotizacionproducto")=="si"){
		$('.Choraentregainicio').show();
		$('#CheckHoraentregainicio').attr('checked', true);
	}else if(recuperarCookie("mostrarHoraentregainicioCotizacionproducto")=="no"){
		$('.Choraentregainicio').hide();
		$('#CheckHoraentregainicio').attr('checked', false);
	}
	//Mostrar u Ocultar Horaentregafin
	if(recuperarCookie("mostrarHoraentregafinCotizacionproducto")=="si"){
		$('.Choraentregafin').show();
		$('#CheckHoraentregafin').attr('checked', true);
	}else if(recuperarCookie("mostrarHoraentregafinCotizacionproducto")=="no"){
		$('.Choraentregafin').hide();
		$('#CheckHoraentregafin').attr('checked', false);
	}
	//Mostrar u Ocultar Prioridad
	if(recuperarCookie("mostrarPrioridadCotizacionproducto")=="si"){
		$('.Cprioridad').show();
		$('#CheckPrioridad').attr('checked', true);
	}else if(recuperarCookie("mostrarPrioridadCotizacionproducto")=="no"){
		$('.Cprioridad').hide();
		$('#CheckPrioridad').attr('checked', false);
	}
	//Mostrar u Ocultar Domicilioentrega
	if(recuperarCookie("mostrarDomicilioentregaCotizacionproducto")=="si"){
		$('.Cdomicilioentrega').show();
		$('#CheckDomicilioentrega').attr('checked', true);
	}else if(recuperarCookie("mostrarDomicilioentregaCotizacionproducto")=="no"){
		$('.Cdomicilioentrega').hide();
		$('#CheckDomicilioentrega').attr('checked', false);
	}
	//Mostrar u Ocultar Coordenadas
	if(recuperarCookie("mostrarCoordenadasCotizacionproducto")=="si"){
		$('.Ccoordenadas').show();
		$('#CheckCoordenadas').attr('checked', true);
	}else if(recuperarCookie("mostrarCoordenadasCotizacionproducto")=="no"){
		$('.Ccoordenadas').hide();
		$('#CheckCoordenadas').attr('checked', false);
	}
	//Mostrar u Ocultar Observaciones
	if(recuperarCookie("mostrarObservacionesCotizacionproducto")=="si"){
		$('.Cobservaciones').show();
		$('#CheckObservaciones').attr('checked', true);
	}else if(recuperarCookie("mostrarObservacionesCotizacionproducto")=="no"){
		$('.Cobservaciones').hide();
		$('#CheckObservaciones').attr('checked', false);
	}
	//Mostrar u Ocultar Estadoentrega
	if(recuperarCookie("mostrarEstadoentregaCotizacionproducto")=="si"){
		$('.Cestadoentrega').show();
		$('#CheckEstadoentrega').attr('checked', true);
	}else if(recuperarCookie("mostrarEstadoentregaCotizacionproducto")=="no"){
		$('.Cestadoentrega').hide();
		$('#CheckEstadoentrega').attr('checked', false);
	}
	//Mostrar u Ocultar Composicion
	if(recuperarCookie("mostrarComposicionCotizacionproducto")=="si"){
		$('.Ccomposicion').show();
		$('#CheckComposicion').attr('checked', true);
	}
	if(recuperarCookie("mostrarComposicionCotizacionproducto")=="no"){
		$('.Ccomposicion').hide();
		$('#CheckComposicion').attr('checked', false);
	}
	
	//Elegir el tipo de vista
	if(recuperarCookie("tipoVistaCotizacionproducto")=="tabla"){
		$('.tipoLista').show();
		$('.tipoTabla').hide();
		tipoVista="tabla";
	}else{
		$('.tipoLista').hide();
		$('.tipoTabla').show();
		tipoVista="lista";
	}
	$( ".tipoTabla" ).click(function() {
    	crearCookie("tipoVistaCotizacionproducto", "tabla");
		tipoVista="tabla";
		$(".tipoLista").show();
		$(".tipoTabla").hide();
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$( ".tipoLista" ).click(function() {
    	crearCookie("tipoVistaCotizacionproducto", "lista");
		tipoVista="lista";
		$(".tipoLista").hide();
		$(".tipoTabla").show();
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});

}

	
$(document).ready(function() {
	$("#cajaBuscar").focus();
	comprobarReglas();
	if($("#idruta").val()!=""){
	    load_tablas(campoOrden,orden,cantidadamostrar,paginacion,busqueda,tipoVista);
	}
	
	if($("#cidcliente").val()!=""){//cargar la consulta de contizaciones pendientes de este cliente
	    load_tablas(campoOrden,orden,cantidadamostrar,paginacion,busqueda,tipoVista);
		llenarSelectDomicilio($("#cidcliente").val());
	}
	else{
		$("#loading").hide();
		//NO CARGAR POR DEFAULT LA CONSULTA
		 //load_tablas(campoOrden,orden,cantidadamostrar,paginacion,busqueda,tipoVista);
	}
	llenarSelectSucursal(idsucursalseleccionada);
	llenarSelectZona("");
	
	
	
	//AUTOCOMPLETAR
	$( "#autoidcliente" ).autocomplete({
        source: "../componentes/buscarCliente.php",
		autoFocus:true,
		select:function(event,ui){ 
        	$('#cidcliente').val(ui.item.id);
			$('#consultaidcliente').val(ui.item.consulta);
			llenarSelectDomicilio(ui.item.id);
    	},
		search: function (event, ui) {
			$("#cidcliente").val("");
			$("#consultaidcliente").val($("#autoidcliente").val());
			llenarSelectDomicilio(0);
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
					llenarSelectDomicilio(ui.item.id);
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
			            llenarSelectDomicilio(respuesta.id);
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
		crearCookie("campoOrdenCotizacionproducto", campoOrden);
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$("#cantidadamostrar").change(function(){
		cantidadamostrar = this.value;
		crearCookie("cantidadamostrarCotizacionproducto", cantidadamostrar);
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$( "#asc" ).click(function() {
    	if ($( "#asc" ).is(':checked')){
			crearCookie("ordenCotizacionproducto", "asc");
			orden="ASC"
			load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
		}
	});
	$( "#desc" ).click(function() {
    	if ($( "#desc" ).is(':checked')){
			crearCookie("ordenCotizacionproducto", "desc");
			orden="DESC"
			load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
		}
	});
	$( "#CheckIdcotizacionproducto" ).click(function() {
    	if ($( "#CheckIdcotizacionproducto" ).is(':checked')){
			crearCookie("mostrarIdcotizacionproductoCotizacionproducto", "si");
			$('.Cidcotizacionproducto').show();
		}else{
			crearCookie("mostrarIdcotizacionproductoCotizacionproducto", "no");
			$('.Cidcotizacionproducto').hide();
		}	
	});
	$( "#CheckSerie" ).click(function() {
    	if ($( "#CheckSerie" ).is(':checked')){
			crearCookie("mostrarSerieCotizacionproducto", "si");
			$('.Cserie').show();
		}else{
			crearCookie("mostrarSerieCotizacionproducto", "no");
			$('.Cserie').hide();
		}	
	});
	$( "#CheckFolio" ).click(function() {
    	if ($( "#CheckFolio" ).is(':checked')){
			crearCookie("mostrarFolioCotizacionproducto", "si");
			$('.Cfolio').show();
		}else{
			crearCookie("mostrarFolioCotizacionproducto", "no");
			$('.Cfolio').hide();
		}	
	});
	$( "#CheckFecha" ).click(function() {
    	if ($( "#CheckFecha" ).is(':checked')){
			crearCookie("mostrarFechaCotizacionproducto", "si");
			$('.Cfecha').show();
		}else{
			crearCookie("mostrarFechaCotizacionproducto", "no");
			$('.Cfecha').hide();
		}	
	});
	$( "#CheckHora" ).click(function() {
    	if ($( "#CheckHora" ).is(':checked')){
			crearCookie("mostrarHoraCotizacionproducto", "si");
			$('.Chora').show();
		}else{
			crearCookie("mostrarHoraCotizacionproducto", "no");
			$('.Chora').hide();
		}	
	});
	$( "#CheckEstadopago" ).click(function() {
    	if ($( "#CheckEstadopago" ).is(':checked')){
			crearCookie("mostrarEstadopagoCotizacionproducto", "si");
			$('.Cestadopago').show();
		}else{
			crearCookie("mostrarEstadopagoCotizacionproducto", "no");
			$('.Cestadopago').hide();
		}	
	});
	$( "#CheckEstadofacturacion" ).click(function() {
    	if ($( "#CheckEstadofacturacion" ).is(':checked')){
			crearCookie("mostrarEstadofacturacionCotizacionproducto", "si");
			$('.Cestadofacturacion').show();
		}else{
			crearCookie("mostrarEstadofacturacionCotizacionproducto", "no");
			$('.Cestadofacturacion').hide();
		}	
	});
	$( "#CheckTipo" ).click(function() {
    	if ($( "#CheckTipo" ).is(':checked')){
			crearCookie("mostrarTipoCotizacionproducto", "si");
			$('.Ctipo').show();
		}else{
			crearCookie("mostrarTipoCotizacionproducto", "no");
			$('.Ctipo').hide();
		}	
	});
	$( "#CheckSubtotal" ).click(function() {
    	if ($( "#CheckSubtotal" ).is(':checked')){
			crearCookie("mostrarSubtotalCotizacionproducto", "si");
			$('.Csubtotal').show();
		}else{
			crearCookie("mostrarSubtotalCotizacionproducto", "no");
			$('.Csubtotal').hide();
		}	
	});
	$( "#CheckImpuestos" ).click(function() {
    	if ($( "#CheckImpuestos" ).is(':checked')){
			crearCookie("mostrarImpuestosCotizacionproducto", "si");
			$('.Cimpuestos').show();
		}else{
			crearCookie("mostrarImpuestosCotizacionproducto", "no");
			$('.Cimpuestos').hide();
		}	
	});
	$( "#CheckTotal" ).click(function() {
    	if ($( "#CheckTotal" ).is(':checked')){
			crearCookie("mostrarTotalCotizacionproducto", "si");
			$('.Ctotal').show();
		}else{
			crearCookie("mostrarTotalCotizacionproducto", "no");
			$('.Ctotal').hide();
		}	
	});
	$( "#CheckIdcliente" ).click(function() {
    	if ($( "#CheckIdcliente" ).is(':checked')){
			crearCookie("mostrarIdclienteCotizacionproducto", "si");
			$('.Cidcliente').show();
		}else{
			crearCookie("mostrarIdclienteCotizacionproducto", "no");
			$('.Cidcliente').hide();
		}	
	});
	$( "#CheckIdusuario" ).click(function() {
    	if ($( "#CheckIdusuario" ).is(':checked')){
			crearCookie("mostrarIdusuarioCotizacionproducto", "si");
			$('.Cidusuario').show();
		}else{
			crearCookie("mostrarIdusuarioCotizacionproducto", "no");
			$('.Cidusuario').hide();
		}	
	});
	$( "#CheckIdempleado" ).click(function() {
    	if ($( "#CheckIdempleado" ).is(':checked')){
			crearCookie("mostrarIdempleadoCotizacionproducto", "si");
			$('.Cidempleado').show();
		}else{
			crearCookie("mostrarIdempleadoCotizacionproducto", "no");
			$('.Cidempleado').hide();
		}	
	});
	$( "#CheckEnviaradomicilio" ).click(function() {
    	if ($( "#CheckEnviaradomicilio" ).is(':checked')){
			crearCookie("mostrarEnviaradomicilioCotizacionproducto", "si");
			$('.Cenviaradomicilio').show();
		}else{
			crearCookie("mostrarEnviaradomicilioCotizacionproducto", "no");
			$('.Cenviaradomicilio').hide();
		}	
	});
	$( "#CheckFechaentrega" ).click(function() {
    	if ($( "#CheckFechaentrega" ).is(':checked')){
			crearCookie("mostrarFechaentregaCotizacionproducto", "si");
			$('.Cfechaentrega').show();
		}else{
			crearCookie("mostrarFechaentregaCotizacionproducto", "no");
			$('.Cfechaentrega').hide();
		}	
	});
	$( "#CheckHoraentregainicio" ).click(function() {
    	if ($( "#CheckHoraentregainicio" ).is(':checked')){
			crearCookie("mostrarHoraentregainicioCotizacionproducto", "si");
			$('.Choraentregainicio').show();
		}else{
			crearCookie("mostrarHoraentregainicioCotizacionproducto", "no");
			$('.Choraentregainicio').hide();
		}	
	});
	$( "#CheckHoraentregafin" ).click(function() {
    	if ($( "#CheckHoraentregafin" ).is(':checked')){
			crearCookie("mostrarHoraentregafinCotizacionproducto", "si");
			$('.Choraentregafin').show();
		}else{
			crearCookie("mostrarHoraentregafinCotizacionproducto", "no");
			$('.Choraentregafin').hide();
		}	
	});
	$( "#CheckPrioridad" ).click(function() {
    	if ($( "#CheckPrioridad" ).is(':checked')){
			crearCookie("mostrarPrioridadCotizacionproducto", "si");
			$('.Cprioridad').show();
		}else{
			crearCookie("mostrarPrioridadCotizacionproducto", "no");
			$('.Cprioridad').hide();
		}	
	});
	$( "#CheckDomicilioentrega" ).click(function() {
    	if ($( "#CheckDomicilioentrega" ).is(':checked')){
			crearCookie("mostrarDomicilioentregaCotizacionproducto", "si");
			$('.Cdomicilioentrega').show();
		}else{
			crearCookie("mostrarDomicilioentregaCotizacionproducto", "no");
			$('.Cdomicilioentrega').hide();
		}	
	});
	$( "#CheckCoordenadas" ).click(function() {
    	if ($( "#CheckCoordenadas" ).is(':checked')){
			crearCookie("mostrarCoordenadasCotizacionproducto", "si");
			$('.Ccoordenadas').show();
		}else{
			crearCookie("mostrarCoordenadasCotizacionproducto", "no");
			$('.Ccoordenadas').hide();
		}	
	});
	$( "#CheckObservaciones" ).click(function() {
    	if ($( "#CheckObservaciones" ).is(':checked')){
			crearCookie("mostrarObservacionesCotizacionproducto", "si");
			$('.Cobservaciones').show();
		}else{
			crearCookie("mostrarObservacionesCotizacionproducto", "no");
			$('.Cobservaciones').hide();
		}	
	});
	$( "#CheckEstadoentrega" ).click(function() {
    	if ($( "#CheckEstadoentrega" ).is(':checked')){
			crearCookie("mostrarEstadoentregaCotizacionproducto", "si");
			$('.Cestadoentrega').show();
		}else{
			crearCookie("mostrarEstadoentregaCotizacionproducto", "no");
			$('.Cestadoentrega').hide();
		}	
	});
	$( "#CheckComposicion" ).click(function() {
    	if ($( "#CheckComposicion" ).is(':checked')){
			crearCookie("mostrarComposicionCotizacionproducto", "si");
			$('.Ccomposicion').show();
		}else{
			crearCookie("mostrarComposicionCotizacionproducto", "no");
			$('.Ccomposicion').hide();
		}
	});
	
	$(".botonBuscar").click(function() {
		var busqueda=$.trim( $("#cajaBuscar").val());
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,busqueda,tipoVista);
	});
	
	$("#botonFiltrar").click(function() {
		    $("#filtroavanzado").val("Si");
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
	
	if($("#idruta").val()!=""){
	   variables = $("#formularioconsultaruta").serialize();
	}
	
	xmlhttp.open("POST","consultar.php?campoOrden="+campoOrden+"&orden="+orden+"&cantidadamostrar="+cantidadamostrar+"&paginacion="+paginacion+"&busqueda="+busqueda+"&tipoVista="+tipoVista+"&papelera="+papelera+"&"+variables, true);
	
	
	xmlhttp.send();
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

function llenarSelectZona(condicion){
		$("#idzona_ajax").html("<option value='1'>cargando...</option>");
		$.ajax({
			url: '../componentes/llenarSelectZona.php',
			type: "POST",
			data: "submit=&condicion="+condicion, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#idzona_ajax").html(mensaje);
			}
		});
		return false;
}

function llenarSelectDomicilio(condicion){
		$("#iddomicilio_ajax").html("<option value='1'>cargando...</option>");
		$.ajax({
			url: '../componentes/llenarSelectDomicilioVista.php',
			type: "POST",
			data: "submit=&condicion="+condicion, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#iddomicilio_ajax").html(mensaje);
			}
		});
		return false;
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
	$("#salida").html(mensaje);//PARA REVISAR CONSULTAS SQL 
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