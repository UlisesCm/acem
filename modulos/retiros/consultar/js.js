// JavaScript Document
var orden, campoOrden, cantidadamostrar, paginacion;
orden="DESC";
campoOrden="idgasto";
iniciar="0";
cantidadamostrar="20";
paginacion=0;
function seleccionarTodoCompras(){
	if ($("#seleccionartodocompra").prop("checked")==true){
		$(".checkCompras").prop("checked", "checked");
	}else{
		$(".checkCompras").prop("checked", "");
	}   
	recorrerTablaCompras("tablaCompras","listaSalida");
}

function recorrerTablaCompras(tabla,lista){
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
			if (index==7 ){//total
				if ($("#checkcompras"+no).prop("checked")==true){
					total = parseFloat(total)+ parseFloat($("#totalcompras"+no).html());
					cadena=cadena+id+":::";
				}
			}
		})
		no++;
		
	})
	
	$("#ctotalcompras").val(total);
	
	
	calcularTotales();
	
	$("#"+lista).val(cadena);
	//$("#TablaServicios").tablesorter(); 
	//$("#TablaServicios").tablesorter( {sortList: [[5,0]]} ); 
    //$("#TablaServicios").sortTable("");
	//sortTable(5);
	//$("#TablaServicios").sortTable("number", {column: 5, reverse: false});
}
function calcularTotales(){
	//sumar a total a pagar
	$("#ltotalaretirar").html((parseFloat($("#ctotalcompras").val())+parseFloat($("#ctotalgastos").val())).toFixed(2));
	$("#ctotalRetiro").val(parseFloat($("#ctotalcompras").val()) + parseFloat($("#ctotalgastos").val()));
}


function seleccionarTodoGastos(){
	if ($("#seleccionartodogasto").prop("checked")==true){
		$(".checkGastos").prop("checked", "checked");
	}else{
		$(".checkGastos").prop("checked", "");
	}   
	recorrerTablaGastos("tablaGastos","listaSalidaGastos");
}

function recorrerTablaGastos(tabla,lista){
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
			if (index==13){//total
				if ($("#checkgastos"+no).prop("checked")==true){
					total = parseFloat(total)+ parseFloat($("#totalgastos"+no).html());
					cadena=cadena+id+":::";
				}
			}
		})
		no++;
	})
	
	$("#ctotalgastos").val(total);
	
	
	calcularTotales();
		
	$("#"+lista).val(cadena);
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
	if(recuperarCookie("campoOrdenGasto")!=null){
		campoOrden=recuperarCookie("campoOrdenGasto");
		 $("#campoOrden option[value="+campoOrden+"]").attr("selected",true);
	}else{
		campoOrden="idgasto";
		$("#campoOrden option[value="+campoOrden+"]").attr("selected",true);
	}
	
	//Identificar el numero de elementos para mostrar
	if(recuperarCookie("cantidadamostrarGasto")!=null){
		cantidadamostrar=recuperarCookie("cantidadamostrarGasto");
		 $("#cantidadamostrar option[value="+cantidadamostrar+"]").attr("selected",true);
	}else{
		cantidadamostrar="20";
		$("#cantidadamostrar option[value="+cantidadamostrar+"]").attr("selected",true);
		
	}
	
	//Identificar el tipo de orden
	if(recuperarCookie("ordenGasto")=="asc"){
		orden="ASC"
		$('#asc').attr('checked', true);
		$('#desc').attr('checked', false);
	}else if(recuperarCookie("ordenGasto")=="desc"){
		orden="DESC"
		$('#asc').attr('checked', false);
		$('#desc').attr('checked', true);
	}else{
		orden="DESC"
		$('#asc').attr('checked', false);
		$('#desc').attr('checked', true);
	}
	//Mostrar u Ocultar Idcuentaprincipal
	if(recuperarCookie("mostrarIdcuentaprincipalGasto")=="si"){
		$('.Cidcuentaprincipal').show();
		$('#CheckIdcuentaprincipal').attr('checked', true);
	}else if(recuperarCookie("mostrarIdcuentaprincipalGasto")=="no"){
		$('.Cidcuentaprincipal').hide();
		$('#CheckIdcuentaprincipal').attr('checked', false);
	}
	//Mostrar u Ocultar Idcuentasecundaria
	if(recuperarCookie("mostrarIdcuentasecundariaGasto")=="si"){
		$('.Cidcuentasecundaria').show();
		$('#CheckIdcuentasecundaria').attr('checked', true);
	}else if(recuperarCookie("mostrarIdcuentasecundariaGasto")=="no"){
		$('.Cidcuentasecundaria').hide();
		$('#CheckIdcuentasecundaria').attr('checked', false);
	}
	//Mostrar u Ocultar Descripcion
	if(recuperarCookie("mostrarDescripcionGasto")=="si"){
		$('.Cdescripcion').show();
		$('#CheckDescripcion').attr('checked', true);
	}else if(recuperarCookie("mostrarDescripcionGasto")=="no"){
		$('.Cdescripcion').hide();
		$('#CheckDescripcion').attr('checked', false);
	}
	//Mostrar u Ocultar Idproveedor
	if(recuperarCookie("mostrarIdproveedorGasto")=="si"){
		$('.Cidproveedor').show();
		$('#CheckIdproveedor').attr('checked', true);
	}else if(recuperarCookie("mostrarIdproveedorGasto")=="no"){
		$('.Cidproveedor').hide();
		$('#CheckIdproveedor').attr('checked', false);
	}
	//Mostrar u Ocultar Factura
	if(recuperarCookie("mostrarFacturaGasto")=="si"){
		$('.Cfactura').show();
		$('#CheckFactura').attr('checked', true);
	}else if(recuperarCookie("mostrarFacturaGasto")=="no"){
		$('.Cfactura').hide();
		$('#CheckFactura').attr('checked', false);
	}
	//Mostrar u Ocultar Idmodeloimpuestos
	if(recuperarCookie("mostrarIdmodeloimpuestosGasto")=="si"){
		$('.Cidmodeloimpuestos').show();
		$('#CheckIdmodeloimpuestos').attr('checked', true);
	}else if(recuperarCookie("mostrarIdmodeloimpuestosGasto")=="no"){
		$('.Cidmodeloimpuestos').hide();
		$('#CheckIdmodeloimpuestos').attr('checked', false);
	}
	//Mostrar u Ocultar Subtotal
	if(recuperarCookie("mostrarSubtotalGasto")=="si"){
		$('.Csubtotal').show();
		$('#CheckSubtotal').attr('checked', true);
	}else if(recuperarCookie("mostrarSubtotalGasto")=="no"){
		$('.Csubtotal').hide();
		$('#CheckSubtotal').attr('checked', false);
	}
	//Mostrar u Ocultar Impuestos
	if(recuperarCookie("mostrarImpuestosGasto")=="si"){
		$('.Cimpuestos').show();
		$('#CheckImpuestos').attr('checked', true);
	}else if(recuperarCookie("mostrarImpuestosGasto")=="no"){
		$('.Cimpuestos').hide();
		$('#CheckImpuestos').attr('checked', false);
	}
	//Mostrar u Ocultar Total
	if(recuperarCookie("mostrarTotalGasto")=="si"){
		$('.Ctotal').show();
		$('#CheckTotal').attr('checked', true);
	}else if(recuperarCookie("mostrarTotalGasto")=="no"){
		$('.Ctotal').hide();
		$('#CheckTotal').attr('checked', false);
	}
	//Mostrar u Ocultar Composicion
	if(recuperarCookie("mostrarComposicionGasto")=="si"){
		$('.Ccomposicion').show();
		$('#CheckComposicion').attr('checked', true);
	}
	if(recuperarCookie("mostrarComposicionGasto")=="no"){
		$('.Ccomposicion').hide();
		$('#CheckComposicion').attr('checked', false);
	}
	
	//Elegir el tipo de vista
	if(recuperarCookie("tipoVistaGasto")=="tabla"){
		$('.tipoLista').show();
		$('.tipoTabla').hide();
		tipoVista="tabla";
	}else{
		$('.tipoLista').hide();
		$('.tipoTabla').show();
		tipoVista="lista";
	}
	$( ".tipoTabla" ).click(function() {
    	crearCookie("tipoVistaGasto", "tabla");
		tipoVista="tabla";
		$(".tipoLista").show();
		$(".tipoTabla").hide();
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$( ".tipoLista" ).click(function() {
    	crearCookie("tipoVistaGasto", "lista");
		tipoVista="lista";
		$(".tipoLista").hide();
		$(".tipoTabla").show();
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});

}

function RegistrarRetiros(){
	//asigno los valores del os objetos en el formulari ode vista a objetos ocultos en el formulario que está en consultar para uqe los valores se vayan tmb en la variable variables
	$("#cfechaconsulta").val($("#cfecha").val());
	$("#cidcuenta_ajaxconsulta").val($("#idcuenta_ajax").val());
	$("#cchequeconsulta").val($("#ccheque").val());
	$("#cdescripcionconsulta").val($("#cdescripcion").val());
	var variables=$("#formulario").serialize();
	guardar(variables);
}
	
$(document).ready(function() {
	$("#cajaBuscar").focus();
	comprobarReglas();
	load_tablas(campoOrden,orden,cantidadamostrar,paginacion,busqueda,tipoVista);
	
	llenarSelectCuentasbancarias("");
	
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
		crearCookie("campoOrdenGasto", campoOrden);
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$("#cantidadamostrar").change(function(){
		cantidadamostrar = this.value;
		crearCookie("cantidadamostrarGasto", cantidadamostrar);
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$( "#asc" ).click(function() {
    	if ($( "#asc" ).is(':checked')){
			crearCookie("ordenGasto", "asc");
			orden="ASC"
			load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
		}
	});
	$( "#desc" ).click(function() {
    	if ($( "#desc" ).is(':checked')){
			crearCookie("ordenGasto", "desc");
			orden="DESC"
			load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
		}
	});
	$( "#CheckIdcuentaprincipal" ).click(function() {
    	if ($( "#CheckIdcuentaprincipal" ).is(':checked')){
			crearCookie("mostrarIdcuentaprincipalGasto", "si");
			$('.Cidcuentaprincipal').show();
		}else{
			crearCookie("mostrarIdcuentaprincipalGasto", "no");
			$('.Cidcuentaprincipal').hide();
		}	
	});
	$( "#CheckIdcuentasecundaria" ).click(function() {
    	if ($( "#CheckIdcuentasecundaria" ).is(':checked')){
			crearCookie("mostrarIdcuentasecundariaGasto", "si");
			$('.Cidcuentasecundaria').show();
		}else{
			crearCookie("mostrarIdcuentasecundariaGasto", "no");
			$('.Cidcuentasecundaria').hide();
		}	
	});
	$( "#CheckDescripcion" ).click(function() {
    	if ($( "#CheckDescripcion" ).is(':checked')){
			crearCookie("mostrarDescripcionGasto", "si");
			$('.Cdescripcion').show();
		}else{
			crearCookie("mostrarDescripcionGasto", "no");
			$('.Cdescripcion').hide();
		}	
	});
	$( "#CheckIdproveedor" ).click(function() {
    	if ($( "#CheckIdproveedor" ).is(':checked')){
			crearCookie("mostrarIdproveedorGasto", "si");
			$('.Cidproveedor').show();
		}else{
			crearCookie("mostrarIdproveedorGasto", "no");
			$('.Cidproveedor').hide();
		}	
	});
	$( "#CheckFactura" ).click(function() {
    	if ($( "#CheckFactura" ).is(':checked')){
			crearCookie("mostrarFacturaGasto", "si");
			$('.Cfactura').show();
		}else{
			crearCookie("mostrarFacturaGasto", "no");
			$('.Cfactura').hide();
		}	
	});
	$( "#CheckIdmodeloimpuestos" ).click(function() {
    	if ($( "#CheckIdmodeloimpuestos" ).is(':checked')){
			crearCookie("mostrarIdmodeloimpuestosGasto", "si");
			$('.Cidmodeloimpuestos').show();
		}else{
			crearCookie("mostrarIdmodeloimpuestosGasto", "no");
			$('.Cidmodeloimpuestos').hide();
		}	
	});
	$( "#CheckSubtotal" ).click(function() {
    	if ($( "#CheckSubtotal" ).is(':checked')){
			crearCookie("mostrarSubtotalGasto", "si");
			$('.Csubtotal').show();
		}else{
			crearCookie("mostrarSubtotalGasto", "no");
			$('.Csubtotal').hide();
		}	
	});
	$( "#CheckImpuestos" ).click(function() {
    	if ($( "#CheckImpuestos" ).is(':checked')){
			crearCookie("mostrarImpuestosGasto", "si");
			$('.Cimpuestos').show();
		}else{
			crearCookie("mostrarImpuestosGasto", "no");
			$('.Cimpuestos').hide();
		}	
	});
	$( "#CheckTotal" ).click(function() {
    	if ($( "#CheckTotal" ).is(':checked')){
			crearCookie("mostrarTotalGasto", "si");
			$('.Ctotal').show();
		}else{
			crearCookie("mostrarTotalGasto", "no");
			$('.Ctotal').hide();
		}	
	});
	$( "#CheckComposicion" ).click(function() {
    	if ($( "#CheckComposicion" ).is(':checked')){
			crearCookie("mostrarComposicionGasto", "si");
			$('.Ccomposicion').show();
		}else{
			crearCookie("mostrarComposicionGasto", "no");
			$('.Ccomposicion').hide();
		}
	});
	
	$(".botonBuscar").click(function() {
		var busqueda=$.trim( $("#cajaBuscar").val());
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
	
	xmlhttp.open("POST","consultar.php?campoOrden="+campoOrden+"&orden="+orden+"&cantidadamostrar="+cantidadamostrar+"&paginacion="+paginacion+"&busqueda="+busqueda+"&tipoVista="+tipoVista+"&papelera="+papelera, true);
	xmlhttp.send();
}

function guardar(variables){
		$("#botonAceptar").hide();
		$(".loading").show();
		$.ajax({
			url: 'guardar.php',
			type: "POST",
			data: "submit=&"+variables, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#botonAceptar").show();
				$(".loading").hide();
				mostrarMensaje(mensaje);
				load_tablas(campoOrden,orden,cantidadamostrar,paginacion,busqueda,tipoVista);
			}
		});
		return false;
}

function llenarSelectCuentasbancarias(condicion){
		$("#idcuenta_ajax").html("<option value='1'>cargando...</option>");
		$.ajax({
			url: '../componentes/llenarSelectCuentasbancarias.php',
			type: "POST",
			data: "submit=&condicion="+condicion, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#idcuenta_ajax").html(mensaje);
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
	var cadena= $.trim(mensaje); //Limpia la cadena regresada desde php
	$("#salida").html(mensaje);
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