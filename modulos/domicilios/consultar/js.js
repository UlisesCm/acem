// JavaScript Document
var orden, campoOrden, cantidadamostrar, paginacion;
orden="DESC";
campoOrden="iddomicilio";
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
	
	//Inicializa las columnas Ocultas por defecto
	
	if (comprobarCookie("mostrarContactocobranzaDomicilio")==false){
		$('.Ccontactocobranza').hide();
		$('#CheckContactocobranza').attr('checked', false);
	}
	
	
	//Identificar el campo de ordenamiento
	
	if(recuperarCookie("campoOrdenDomicilio")!=null){
		campoOrden=recuperarCookie("campoOrdenDomicilio");
		 $("#campoOrden option[value="+campoOrden+"]").attr("selected",true);
	}else{
		campoOrden="iddomicilio";
		$("#campoOrden option[value="+campoOrden+"]").attr("selected",true);
	}
	
	//Identificar el numero de elementos para mostrar
	if(recuperarCookie("cantidadamostrarDomicilio")!=null){
		cantidadamostrar=recuperarCookie("cantidadamostrarDomicilio");
		 $("#cantidadamostrar option[value="+cantidadamostrar+"]").attr("selected",true);
	}else{
		cantidadamostrar="20";
		$("#cantidadamostrar option[value="+cantidadamostrar+"]").attr("selected",true);
		
	}
	
	//Identificar el tipo de orden
	if(recuperarCookie("ordenDomicilio")=="asc"){
		orden="ASC"
		$('#asc').attr('checked', true);
		$('#desc').attr('checked', false);
	}else if(recuperarCookie("ordenDomicilio")=="desc"){
		orden="DESC"
		$('#asc').attr('checked', false);
		$('#desc').attr('checked', true);
	}else{
		orden="DESC"
		$('#asc').attr('checked', false);
		$('#desc').attr('checked', true);
	}
	//Mostrar u Ocultar Idcliente
	if(recuperarCookie("mostrarIdclienteDomicilio")=="si"){
		$('.Cidcliente').show();
		$('#CheckIdcliente').attr('checked', true);
	}else if(recuperarCookie("mostrarIdclienteDomicilio")=="no"){
		$('.Cidcliente').hide();
		$('#CheckIdcliente').attr('checked', false);
	}
	//Mostrar u Ocultar Nombrecomercial
	if(recuperarCookie("mostrarNombrecomercialDomicilio")=="si"){
		$('.Cnombrecomercial').show();
		$('#CheckNombrecomercial').attr('checked', true);
	}else if(recuperarCookie("mostrarNombrecomercialDomicilio")=="no"){
		$('.Cnombrecomercial').hide();
		$('#CheckNombrecomercial').attr('checked', false);
	}else{ /////////INVISIBLE POR DEFECTO
		$('.Cnombrecomercial').hide();
		$('#CheckNombrecomercial').attr('checked', false);
	}
	//Mostrar u Ocultar Tipovialidad
	if(recuperarCookie("mostrarTipovialidadDomicilio")=="si"){
		$('.Ctipovialidad').show();
		$('#CheckTipovialidad').attr('checked', true);
	}else if(recuperarCookie("mostrarTipovialidadDomicilio")=="no"){
		$('.Ctipovialidad').hide();
		$('#CheckTipovialidad').attr('checked', false);
	}
	//Mostrar u Ocultar Calle
	if(recuperarCookie("mostrarCalleDomicilio")=="si"){
		$('.Ccalle').show();
		$('#CheckCalle').attr('checked', true);
	}else if(recuperarCookie("mostrarCalleDomicilio")=="no"){
		$('.Ccalle').hide();
		$('#CheckCalle').attr('checked', false);
	}
	//Mostrar u Ocultar Noexterior
	if(recuperarCookie("mostrarNoexteriorDomicilio")=="si"){
		$('.Cnoexterior').show();
		$('#CheckNoexterior').attr('checked', true);
	}else if(recuperarCookie("mostrarNoexteriorDomicilio")=="no"){
		$('.Cnoexterior').hide();
		$('#CheckNoexterior').attr('checked', false);
	}
	//Mostrar u Ocultar Nointerior
	if(recuperarCookie("mostrarNointeriorDomicilio")=="si"){
		$('.Cnointerior').show();
		$('#CheckNointerior').attr('checked', true);
	}else if(recuperarCookie("mostrarNointeriorDomicilio")=="no"){
		$('.Cnointerior').hide();
		$('#CheckNointerior').attr('checked', false);
	}
	//Mostrar u Ocultar Colonia
	if(recuperarCookie("mostrarColoniaDomicilio")=="si"){
		$('.Ccolonia').show();
		$('#CheckColonia').attr('checked', true);
	}else if(recuperarCookie("mostrarColoniaDomicilio")=="no"){
		$('.Ccolonia').hide();
		$('#CheckColonia').attr('checked', false);
	}
	//Mostrar u Ocultar Cp
	if(recuperarCookie("mostrarCpDomicilio")=="si"){
		$('.Ccp').show();
		$('#CheckCp').attr('checked', true);
	}else if(recuperarCookie("mostrarCpDomicilio")=="no"){
		$('.Ccp').hide();
		$('#CheckCp').attr('checked', false);
	}
	//Mostrar u Ocultar Ciudad
	if(recuperarCookie("mostrarCiudadDomicilio")=="si"){
		$('.Cciudad').show();
		$('#CheckCiudad').attr('checked', true);
	}else if(recuperarCookie("mostrarCiudadDomicilio")=="no"){
		$('.Cciudad').hide();
		$('#CheckCiudad').attr('checked', false);
	}
	//Mostrar u Ocultar Estado
	if(recuperarCookie("mostrarEstadoDomicilio")=="si"){
		$('.Cestado').show();
		$('#CheckEstado').attr('checked', true);
	}else if(recuperarCookie("mostrarEstadoDomicilio")=="no"){
		$('.Cestado').hide();
		$('#CheckEstado').attr('checked', false);
	}
	//Mostrar u Ocultar Idzona
	if(recuperarCookie("mostrarIdzonaDomicilio")=="si"){
		$('.Cidzona').show();
		$('#CheckIdzona').attr('checked', true);
	}else if(recuperarCookie("mostrarIdzonaDomicilio")=="no"){
		$('.Cidzona').hide();
		$('#CheckIdzona').attr('checked', false);
	}
	//Mostrar u Ocultar Coordenadas
	if(recuperarCookie("mostrarCoordenadasDomicilio")=="si"){
		$('.Ccoordenadas').show();
		$('#CheckCoordenadas').attr('checked', true);
	}else if(recuperarCookie("mostrarCoordenadasDomicilio")=="no"){
		$('.Ccoordenadas').hide();
		$('#CheckCoordenadas').attr('checked', false);
	}
	//Mostrar u Ocultar Referencia
	if(recuperarCookie("mostrarReferenciaDomicilio")=="si"){
		$('.Creferencia').show();
		$('#CheckReferencia').attr('checked', true);
	}else if(recuperarCookie("mostrarReferenciaDomicilio")=="no"){
		$('.Creferencia').hide();
		$('#CheckReferencia').attr('checked', false);
	}else{ /////////INVISIBLE POR DEFECTO
		$('.Creferencia').hide();
		$('#CheckReferencia').attr('checked', false);
	}
	//Mostrar u Ocultar Observaciones
	if(recuperarCookie("mostrarObservacionesDomicilio")=="si"){
		$('.Cobservaciones').show();
		$('#CheckObservaciones').attr('checked', true);
	}else if(recuperarCookie("mostrarObservacionesDomicilio")=="no"){
		$('.Cobservaciones').hide();
		$('#CheckObservaciones').attr('checked', false);
	}else{ /////////INVISIBLE POR DEFECTO
		$('.Cobservaciones').hide();
		$('#CheckObservaciones').attr('checked', false);
	}
	//Mostrar u Ocultar Idsucursal
	if(recuperarCookie("mostrarIdsucursalDomicilio")=="si"){
		$('.Cidsucursal').show();
		$('#CheckIdsucursal').attr('checked', true);
	}else if(recuperarCookie("mostrarIdsucursalDomicilio")=="no"){
		$('.Cidsucursal').hide();
		$('#CheckIdsucursal').attr('checked', false);
	}
	//Mostrar u Ocultar Idgirocomercial
	if(recuperarCookie("mostrarIdgirocomercialDomicilio")=="si"){
		$('.Cidgirocomercial').show();
		$('#CheckIdgirocomercial').attr('checked', true);
	}else if(recuperarCookie("mostrarIdgirocomercialDomicilio")=="no"){
		$('.Cidgirocomercial').hide();
		$('#CheckIdgirocomercial').attr('checked', false);
	}
	
	//Mostrar u Ocultar Idempleado
	if(recuperarCookie("mostrarIdempleadoDomicilio")=="si"){
		$('.Cidempleado').show();
		$('#CheckIdempleado').attr('checked', true);
	}else if(recuperarCookie("mostrarIdempleadoDomicilio")=="no"){
		$('.Cidempleado').hide();
		$('#CheckIdempleado').attr('checked', false);
	}else{ /////////INVISIBLE POR DEFECTO
		$('.Cidempleado').hide();
		$('#CheckIdempleado').attr('checked', false);
	}
	//Mostrar u Ocultar Composicion
	if(recuperarCookie("mostrarComposicionDomicilio")=="si"){
		$('.Ccomposicion').show();
		$('#CheckComposicion').attr('checked', true);
	}
	if(recuperarCookie("mostrarComposicionDomicilio")=="no"){
		$('.Ccomposicion').hide();
		$('#CheckComposicion').attr('checked', false);
	}
	
	//Elegir el tipo de vista
	if(recuperarCookie("tipoVistaDomicilio")=="tabla"){
		$('.tipoLista').show();
		$('.tipoTabla').hide();
		tipoVista="tabla";
	}else{
		$('.tipoLista').hide();
		$('.tipoTabla').show();
		tipoVista="lista";
	}
	$( ".tipoTabla" ).click(function() {
    	crearCookie("tipoVistaDomicilio", "tabla");
		tipoVista="tabla";
		$(".tipoLista").show();
		$(".tipoTabla").hide();
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$( ".tipoLista" ).click(function() {
    	crearCookie("tipoVistaDomicilio", "lista");
		tipoVista="lista";
		$(".tipoLista").hide();
		$(".tipoTabla").show();
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});

}



$(document).ready(function() {
	$("#cajaBuscar").focus();
	comprobarReglas();
	load_tablas(campoOrden,orden,cantidadamostrar,paginacion,busqueda,tipoVista);
	
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
		crearCookie("campoOrdenDomicilio", campoOrden);
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$("#cantidadamostrar").change(function(){
		cantidadamostrar = this.value;
		crearCookie("cantidadamostrarDomicilio", cantidadamostrar);
		load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
	});
	$( "#asc" ).click(function() {
    	if ($( "#asc" ).is(':checked')){
			crearCookie("ordenDomicilio", "asc");
			orden="ASC"
			load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
		}
	});
	$( "#desc" ).click(function() {
    	if ($( "#desc" ).is(':checked')){
			crearCookie("ordenDomicilio", "desc");
			orden="DESC"
			load_tablas(campoOrden,orden,cantidadamostrar,paginacion,"",tipoVista);
		}
	});
	$( "#CheckIdcliente" ).click(function() {
    	if ($( "#CheckIdcliente" ).is(':checked')){
			crearCookie("mostrarIdclienteDomicilio", "si");
			$('.Cidcliente').show();
		}else{
			crearCookie("mostrarIdclienteDomicilio", "no");
			$('.Cidcliente').hide();
		}	
	});
	$( "#CheckNombrecomercial" ).click(function() {
    	if ($( "#CheckNombrecomercial" ).is(':checked')){
			crearCookie("mostrarNombrecomercialDomicilio", "si");
			$('.Cnombrecomercial').show();
		}else{
			crearCookie("mostrarNombrecomercialDomicilio", "no");
			$('.Cnombrecomercial').hide();
		}	
	});
	$( "#CheckTipovialidad" ).click(function() {
    	if ($( "#CheckTipovialidad" ).is(':checked')){
			crearCookie("mostrarTipovialidadDomicilio", "si");
			$('.Ctipovialidad').show();
		}else{
			crearCookie("mostrarTipovialidadDomicilio", "no");
			$('.Ctipovialidad').hide();
		}	
	});
	$( "#CheckCalle" ).click(function() {
    	if ($( "#CheckCalle" ).is(':checked')){
			crearCookie("mostrarCalleDomicilio", "si");
			$('.Ccalle').show();
		}else{
			crearCookie("mostrarCalleDomicilio", "no");
			$('.Ccalle').hide();
		}	
	});
	$( "#CheckNoexterior" ).click(function() {
    	if ($( "#CheckNoexterior" ).is(':checked')){
			crearCookie("mostrarNoexteriorDomicilio", "si");
			$('.Cnoexterior').show();
		}else{
			crearCookie("mostrarNoexteriorDomicilio", "no");
			$('.Cnoexterior').hide();
		}	
	});
	$( "#CheckNointerior" ).click(function() {
    	if ($( "#CheckNointerior" ).is(':checked')){
			crearCookie("mostrarNointeriorDomicilio", "si");
			$('.Cnointerior').show();
		}else{
			crearCookie("mostrarNointeriorDomicilio", "no");
			$('.Cnointerior').hide();
		}	
	});
	$( "#CheckColonia" ).click(function() {
    	if ($( "#CheckColonia" ).is(':checked')){
			crearCookie("mostrarColoniaDomicilio", "si");
			$('.Ccolonia').show();
		}else{
			crearCookie("mostrarColoniaDomicilio", "no");
			$('.Ccolonia').hide();
		}	
	});
	$( "#CheckCp" ).click(function() {
    	if ($( "#CheckCp" ).is(':checked')){
			crearCookie("mostrarCpDomicilio", "si");
			$('.Ccp').show();
		}else{
			crearCookie("mostrarCpDomicilio", "no");
			$('.Ccp').hide();
		}	
	});
	$( "#CheckCiudad" ).click(function() {
    	if ($( "#CheckCiudad" ).is(':checked')){
			crearCookie("mostrarCiudadDomicilio", "si");
			$('.Cciudad').show();
		}else{
			crearCookie("mostrarCiudadDomicilio", "no");
			$('.Cciudad').hide();
		}	
	});
	$( "#CheckEstado" ).click(function() {
    	if ($( "#CheckEstado" ).is(':checked')){
			crearCookie("mostrarEstadoDomicilio", "si");
			$('.Cestado').show();
		}else{
			crearCookie("mostrarEstadoDomicilio", "no");
			$('.Cestado').hide();
		}	
	});
	$( "#CheckIdzona" ).click(function() {
    	if ($( "#CheckIdzona" ).is(':checked')){
			crearCookie("mostrarIdzonaDomicilio", "si");
			$('.Cidzona').show();
		}else{
			crearCookie("mostrarIdzonaDomicilio", "no");
			$('.Cidzona').hide();
		}	
	});
	$( "#CheckCoordenadas" ).click(function() {
    	if ($( "#CheckCoordenadas" ).is(':checked')){
			crearCookie("mostrarCoordenadasDomicilio", "si");
			$('.Ccoordenadas').show();
		}else{
			crearCookie("mostrarCoordenadasDomicilio", "no");
			$('.Ccoordenadas').hide();
		}	
	});
	$( "#CheckReferencia" ).click(function() {
    	if ($( "#CheckReferencia" ).is(':checked')){
			crearCookie("mostrarReferenciaDomicilio", "si");
			$('.Creferencia').show();
		}else{
			crearCookie("mostrarReferenciaDomicilio", "no");
			$('.Creferencia').hide();
		}	
	});
	$( "#CheckObservaciones" ).click(function() {
    	if ($( "#CheckObservaciones" ).is(':checked')){
			crearCookie("mostrarObservacionesDomicilio", "si");
			$('.Cobservaciones').show();
		}else{
			crearCookie("mostrarObservacionesDomicilio", "no");
			$('.Cobservaciones').hide();
		}	
	});
	$( "#CheckIdsucursal" ).click(function() {
    	if ($( "#CheckIdsucursal" ).is(':checked')){
			crearCookie("mostrarIdsucursalDomicilio", "si");
			$('.Cidsucursal').show();
		}else{
			crearCookie("mostrarIdsucursalDomicilio", "no");
			$('.Cidsucursal').hide();
		}	
	});
	$( "#CheckIdgirocomercial" ).click(function() {
    	if ($( "#CheckIdgirocomercial" ).is(':checked')){
			crearCookie("mostrarIdgirocomercialDomicilio", "si");
			$('.Cidgirocomercial').show();
		}else{
			crearCookie("mostrarIdgirocomercialDomicilio", "no");
			$('.Cidgirocomercial').hide();
		}	
	});
	$( "#CheckContactoservicio" ).click(function() {
    	if ($( "#CheckContactoservicio" ).is(':checked')){
			crearCookie("mostrarContactoservicioDomicilio", "si");
			$('.Ccontactoservicio').show();
		}else{
			crearCookie("mostrarContactoservicioDomicilio", "no");
			$('.Ccontactoservicio').hide();
		}	
	});
	$( "#CheckEmailservicio" ).click(function() {
    	if ($( "#CheckEmailservicio" ).is(':checked')){
			crearCookie("mostrarEmailservicioDomicilio", "si");
			$('.Cemailservicio').show();
		}else{
			crearCookie("mostrarEmailservicioDomicilio", "no");
			$('.Cemailservicio').hide();
		}	
	});
	$( "#CheckTelefonoservicio" ).click(function() {
    	if ($( "#CheckTelefonoservicio" ).is(':checked')){
			crearCookie("mostrarTelefonoservicioDomicilio", "si");
			$('.Ctelefonoservicio').show();
		}else{
			crearCookie("mostrarTelefonoservicioDomicilio", "no");
			$('.Ctelefonoservicio').hide();
		}	
	});
	$( "#CheckContactocobranza" ).click(function() {
    	if ($( "#CheckContactocobranza" ).is(':checked')){
			crearCookie("mostrarContactocobranzaDomicilio", "si");
			$('.Ccontactocobranza').show();
		}else{
			crearCookie("mostrarContactocobranzaDomicilio", "no");
			$('.Ccontactocobranza').hide();
		}	
	});
	$( "#CheckEmailcobranza" ).click(function() {
    	if ($( "#CheckEmailcobranza" ).is(':checked')){
			crearCookie("mostrarEmailcobranzaDomicilio", "si");
			$('.Cemailcobranza').show();
		}else{
			crearCookie("mostrarEmailcobranzaDomicilio", "no");
			$('.Cemailcobranza').hide();
		}	
	});
	$( "#CheckTelefonocobranza" ).click(function() {
    	if ($( "#CheckTelefonocobranza" ).is(':checked')){
			crearCookie("mostrarTelefonocobranzaDomicilio", "si");
			$('.Ctelefonocobranza').show();
		}else{
			crearCookie("mostrarTelefonocobranzaDomicilio", "no");
			$('.Ctelefonocobranza').hide();
		}	
	});
	$( "#CheckContactofacturacion" ).click(function() {
    	if ($( "#CheckContactofacturacion" ).is(':checked')){
			crearCookie("mostrarContactofacturacionDomicilio", "si");
			$('.Ccontactofacturacion').show();
		}else{
			crearCookie("mostrarContactofacturacionDomicilio", "no");
			$('.Ccontactofacturacion').hide();
		}	
	});
	$( "#CheckEmailfacturacion" ).click(function() {
    	if ($( "#CheckEmailfacturacion" ).is(':checked')){
			crearCookie("mostrarEmailfacturacionDomicilio", "si");
			$('.Cemailfacturacion').show();
		}else{
			crearCookie("mostrarEmailfacturacionDomicilio", "no");
			$('.Cemailfacturacion').hide();
		}	
	});
	$( "#CheckTelefonofacturacion" ).click(function() {
    	if ($( "#CheckTelefonofacturacion" ).is(':checked')){
			crearCookie("mostrarTelefonofacturacionDomicilio", "si");
			$('.Ctelefonofacturacion').show();
		}else{
			crearCookie("mostrarTelefonofacturacionDomicilio", "no");
			$('.Ctelefonofacturacion').hide();
		}	
	});
	$( "#CheckIdempleado" ).click(function() {
    	if ($( "#CheckIdempleado" ).is(':checked')){
			crearCookie("mostrarIdempleadoDomicilio", "si");
			$('.Cidempleado').show();
		}else{
			crearCookie("mostrarIdempleadoDomicilio", "no");
			$('.Cidempleado').hide();
		}	
	});
	$( "#CheckComposicion" ).click(function() {
    	if ($( "#CheckComposicion" ).is(':checked')){
			crearCookie("mostrarComposicionDomicilio", "si");
			$('.Ccomposicion').show();
		}else{
			crearCookie("mostrarComposicionDomicilio", "no");
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