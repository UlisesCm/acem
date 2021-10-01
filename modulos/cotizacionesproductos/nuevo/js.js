// JS MODULA Autor: Armando Viera Rodriguez 2016

var FILAS = 0;
var FILASOTROS = 0;

var vecesMap=false;


var marker;          //variable del marcador
//Funcion principal
initMap = function () 
{
	//usamos la API para geolocalizar el usuario
    var longitud=19.40503465287001;
	var latitud=-102.04849538421627;
	setMapa(longitud,latitud);  //pasamos las coordenadas al metodo para crear el mapa
	document.getElementById("ccoordenadas").value =longitud+","+latitud;	
}

function setMapa (longitud,latitud){  
	var geocoder = new google.maps.Geocoder();
	var map = new google.maps.Map(document.getElementById('map'),{
        zoom: 16,
        center:new google.maps.LatLng(longitud,latitud),
	});
	var calle=$("#autocalle").val(), numero=$("#autonoexterior").val(), codigopostal=$("#ccp").val(), ciudad=$("#autociudad").val(), estado=$("#estado_ajax").val();
	var direccion=ciudad+", "+estado+", "+calle+" "+numero+", "+codigopostal
	geocoder.geocode({'address': direccion}, function(results, status) {
	if (status === 'OK') {
		var resultados = results[0].geometry.location,
		latitud = resultados.lat(),
		longitud = resultados.lng();
		map.setCenter(results[0].geometry.location);
		var marker = new google.maps.Marker({
			map: map,
			draggable: true,
			animation: google.maps.Animation.DROP,
			position: results[0].geometry.location
		});	
	}else{
		var mensajeError = "";
		if (status === "ZERO_RESULTS") {
			mensajeError = "No hubo resultados para la dirección ingresada.";
		}else if(status === "OVER_QUERY_LIMIT" || status === "REQUEST_DENIED" || status === "UNKNOWN_ERROR"){
			mensajeError = "Error general del mapa.";
		}else if(status === "INVALID_REQUEST"){
			mensajeError = "Error de la web. Contacte con Name Agency.";
		}
			alert(mensajeError);
		}
			
		marker.addListener('click', toggleBounce);
      	marker.addListener( 'dragend', function (event) {
			//escribimos las coordenadas de la posicion actual del marcador dentro del input #ccoordenadas
			document.getElementById("ccoordenadas").value = this.getPosition().lat()+","+ this.getPosition().lng();
		});
	});
    //Creamos el marcador en el mapa con sus propiedades
    //para nuestro obetivo tenemos que poner el atributo draggable en true
    //position pondremos las mismas coordenas que obtuvimos en la geolocalización
      
    //agregamos un evento al marcador junto con la funcion callback al igual que el evento dragend que indica 
    //cuando el usuario a soltado el marcador 
}

//callback al hacer clic en el marcador lo que hace es quitar y poner la animacion BOUNCE
function toggleBounce() {
  if (marker.getAnimation() !== null) {
    marker.setAnimation(null);
  } else {
    marker.setAnimation(google.maps.Animation.BOUNCE);
  }
}

// Carga de la libreria de google maps
function vaciarcamposdomicilio(){
	$("#autocalle").val("");
	$("#autonoexterior").val("");
	$("#cnointerior").val("");
	$("#autonombrecomercial").val("");
	$("#autocolonia").val("");
	$("#ccp").val("");
	$("#autociudad").val("");
	$("#creferencia").val("");
	$("#cobservacionesdomicilio").val("");
}
function vaciarCampos(){
		$("#cserie").val("");
		$("#cfolio").val("");
		$("#cserieotros").val("");
		$("#cfoliootros").val("");
		$("#csubtotal").val("");
		$("#cimpuestos").val("");
		$("#ctotal").val("");
		$("#ccostodeventa").val("");
		$("#cutilidad").val("");
		$("#cenviaradomicilio").val("");
		$("#cprioridad").val("");
		$("#cdomicilioentrega").val("");
		$("#ccoordenadas").val("");
		$("#peso").val("");
		$("#cobservaciones").val("");
		$("#cestadoentrega").val("");
		$("#autoidcliente").val("");
	    $("#cantidad").focus();
		$("#telefono").val("");
		$("#autoidproducto").val("");
		$("#cobservacionesotros").val("");
		$("#cprioridad").val("BAJA");
		$('#botonMostrar').hide(500);
		//tabla productos
		FILAS = 0;
		$("#filas").html("");
		$("#listaSalida").val("");
		//tabla
		FILASOTROS = 0;
		$("#filasotros").html("");
		$("#listaSalidaOtros").val("");
		$("#csubtotalotros").val("0");
		$("#cimpuestosotros").val("0");
		$("#cmontootros").val("0");
		agregarFilaOtros();//para que empieze con una fila agregada por default
		//$("#botonOtros").collapse('hide');
		//$(".collapse").collapse('hide');
		//TOTALES
		TotalesaCero();
		TotalesaCeroOtros();
		//FOLIOS
		obtenerSerie();
		obtenerFolio();
		obtenerSerieOtros();
		obtenerFolioOtros();
		//domicilios
		vaciarcamposdomicilio();
		 $("#cantidad").focus();
		 $("#botonOtros").click();
}


function llenarDatosFijos(){
	$("#cestadopago").val("NO PAGADO");
	$("#cestadofacturacion").val("NO FACTURADO");
	$("#cestadoentrega").val("EN ESPERA");
	$("#cenviaradomicilio").val("ENTREGA EN SUCURSAL");
	$("#ccoordenadas").val("0");
}

function abrirModal(){
	/*
	//ABRIR EL FORMULARIO MODAL CON LOS PRODUCTOS*/
	$("#modalconsultaproductos").modal();
	/*$.ajax({
		url: 'consultardetalles.php',
		type: "POST",
		data: "submit=&id="+0, //Pasamos los datos en forma de array
		success: function(mensaje){
			$("#contenidoModal").html(mensaje);
		}
	});

	return false;
	*/
}

function abrirModalDomicilio(id){
	$("#modal").modal();
	if (vecesMap==false){
		var longitud=19.40503465287001;
		var latitud=-102.04849538421627;
		setMapa(longitud,latitud);
		vecesMap=false;
	}
}

function mostrarobjetosdomicilio(seleccion){
	if (seleccion == "NUEVO") {
        //MOSTRAR OBJETOS PARA ALTA DE DOMICILIO
		$(".panelDomicilioAlta").show(500);
    }
	else{
		//OCULTAR OBJETOS PARA ALTA DE DOMICILIO
		$(".panelDomicilioAlta").hide(500);
	}
}



function CargarProductoDesdeModal(idproducto,nombre){
	//alert("idprod= "+idproducto + " nombre= " + nombre);
	$("#autoidproducto").val(nombre);
	//LLAMAR CON AJAX AL ARCHIVO BUSCARPRODUCTONOMBRE PARA QUE DEVUELVA EL ARREGLO EN JASON CON LOS ARREGLOS DE CADA ATRIBUTO DEL PRODUCTO SELECCIONADO Y ASI ENVIARLOS AL PROCEDIMIENTO AGREGAR FILA
	 $.ajax({
			url: '../componentes/buscarProductoNombre.php',
			type: "GET",
			//crossDomain: true,//para acceder a un archivo que no está en la misma locación
			dataType: 'json',
			data: "submit=&term="+nombre, //Pasamos los datos en forma de array seralizado desde la funcion de envio
		}).done(function(respuesta){
			$.each(respuesta,function(i,item){
				if(validarDuplicado("tablaSalida",item.id,1) == true){//VALIDA QUE NO ESTÉ EL PRODUCTO YA CARGADO EN LA LISTA
				 //CARGAR EL PRODUCTO A LA TABLA
        			$('#cidproducto').val(item.id);
					$('#consultaidproducto').val(item.consulta);
			
			        variables=new Array();
					variables[0]=0; //Nueva fila
					variables[1]=$("#cidproducto").val();
					variables[2]=item.claveproducto;
					variables[3]=item.consulta;//nombreproducto
					variables[4]=1;
					variables[5]=item.precios;
					variables[6]=item.IDListas;
					variables[7]=item.IDvaloresimpuestos;
					variables[8]=item.costopromedio;
					variables[9]=item.pesoteorico;
					agregarFila("tablaSalida", variables, "listaSalida");
				}
			});
		});
		return false;
	
}

function FiltrarProductos(variables){
		$("#loading").show();
		$.ajax({
			url: 'consultardetalles.php',
			type: "POST",
			data: "submit=&"+variables, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#loading").hide();
				$("#tab_1").html(mensaje);
			}
		});
		return false;
}

function CotizacionesPendientes(idcliente){
	$("#loading").show();
		$.ajax({
			url: 'consultarcotizacionespendientes.php',
			type: "POST",
			data: "submit=&idcliente="+idcliente, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#loading").hide();
	            var cadena= $.trim(mensaje);
				$("#idcotizacionespendientes").val(cadena);
	            if($("#idcotizacionespendientes").val()=="Si"){
				//MENSAJE
					$("#panel_alertas").removeClass().addClass("alert alert-error alert-dismissable");
					$("#notificacionTitulo").html("<i class='icon fa fa-ban'></i>"+"EL CLIENTE SELECCIONADO TIENE COTIZACIONES PENDIENTES");
					$("#notificacionContenido").html("Si desea verlas de clic en el botón [Mostrar cotizaciones pendientes]");
					$("#panel_alertas").stop(false, true);
					$("#panel_alertas").fadeIn("slow");
					var $contenedor=$("body");
					$("html,body").animate({scrollTop:0},1000);
					$("#panel_alertas").delay(6000).fadeOut("slow");
					$('#botonMostrar').show(500);
				}	
				else{
					$('#botonMostrar').hide(500);
				}
			}
		});
}
//original
$(document).ready(function() {
	
	$(".campo_contactos").hide();

	$("#panel_alertas").hide();
	$(".loading").hide();

	$("#autoidcliente").change(()=>{
		$(".campo_contactos").hide();
		if($("#autoidcliente").val() == "" || $("#autoidcliente").val() == null){
			$(".campo_contactos").hide();
		} else{
			$(".campo_contactos").show();
			llenarChecksContactos($("#autoidcliente").val());
		}
	})
	//$("#panel_alertas").delay(8000).hide(600);
	
	obtenerSerie();
	obtenerFolio();
	obtenerSerieOtros();
	obtenerFolioOtros();
	agregarFilaOtros();//para que empieze con una fila agregada por default en OTROS
	llenarSelectSucursal("");
	
	llenarSelectModeloimpuestos("");
	llenarDatosFijos();
	
	llenarSelectEstado("");
	llenarSelectZona("");
	llenarSelectGirocomercial("");
	
	 $("#autoidcliente").focus();

	 
	
	 
	 eliminarCotizacionesViejas(7);//el parametro es el número de dias de antiguedad con los que una cotización se considera aún nueva antes de eso todo se borra
	
	//AUTOCOMPLETAR
	$( "#autoidcliente" ).autocomplete({
        source: "../componentes/buscarCliente.php",
		autoFocus:true,
		select:function(event,ui){ 
        	$('#cidcliente').val(ui.item.id);
			$('#consultaidcliente').val(ui.item.consulta);
			$('#telefono').val(ui.item.telefono);
			//$('#cantidad').focus();//eso afecta al filtro de clientes se borra el id al seleccioanr cliente y provoca que se guarde otra vez el cliente
			//mostrar alerta si es que tiene cotizaciones pendientes
			
			CotizacionesPendientes(ui.item.id)
			
    	},
		search: function (event, ui) {
			$("#cidcliente").val("");
			$("#telefono").val("");
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
					
					llenarSelectDomicilio("");
					$(".panelDomicilioAlta").hide(500);
					vaciarcamposdomicilio();
	                llenarChecksContactos("");
        	});
		},
        minLength: 1
    });
	// FIN AUTOCOMPLETAR
	
	//BLUR
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
	
	
   
	
	
		$( "#autoidproducto" ).autocomplete({
        source: "../componentes/buscarProductoNombre.php",
		autoFocus:true,
		select:function(event,ui){
			if(validarDuplicado("tablaSalida",ui.item.id,1) == true){//VALIDA QUE NO ESTÉ EL PRODUCTO YA CARGADO EN LA LISTA
				 //CARGAR EL PRODUCTO A LA TABLA
        			$('#cidproducto').val(ui.item.id);
					$('#consultaidproducto').val(ui.item.consulta);
			
			        variables=new Array();
					variables[0]=0; //Nueva fila
					variables[1]=$("#cidproducto").val();
					variables[2]=ui.item.claveproducto;
					variables[3]=ui.item.consulta;//nombreproducto
					variables[4]=1;
					variables[5]=ui.item.precios;
					variables[6]=ui.item.IDListas;
					variables[7]=ui.item.IDvaloresimpuestos;
					variables[8]=ui.item.costopromedio;
					variables[9]=ui.item.pesoteorico;
					
					agregarFila("tablaSalida", variables, "listaSalida");
					$("#cidproducto").val("");
					$("#autoidproducto").val("");
					$("#nombreProducto").html("");
					$("#cantidad").focus();
			}
			
    	},
		search: function (event, ui) {
			$("#cidproducto").val("");
			$("#consultaidproducto").val($("#autoidproducto").val());
			$("#nombreProducto").html("");
			$("#etiquetaProducto").html("Producto (Consultando...)");
		},
		response: function(event, ui) {
       		$("#etiquetaProducto").html("Producto");
   		},
        minLength: 1
    });
	// FIN AUTOCOMPLETAR
	
	
	//AUTOCOMPLETAR
	$("#autoidproducto").blur(function(){
		if ($("#cidproducto").val()==""){
			$("#nombreProducto").html(""); 
			$.ajax({
					url:'../componentes/ProductoNombre.php',
					type:'POST',
					dataType:'json',
					/*En caso de generar una descripció "label" compuesta por dos o mas datos
					en el archivo buscarX.php será necesario cambiar el termino 
					$('#autoX').val() por $('#consultaX').val()*/
					data:{ termino:$('#autoidproducto').val()}
					}).done(function(respuesta){
						$("#cidproducto").val(respuesta.id);
						$("#ccodigoproducto").val(respuesta.codigo);
						$("#nunidad").val(respuesta.unidad);
						$("#nnombreproducto").val(respuesta.nombre);
						$("#nprecio").val(respuesta.precio);
						$("#niva").val(respuesta.iva);
						$("#nieps").val(respuesta.ieps);
						$("#ntasaiva").val(respuesta.tasaiva);
						$("#ntasaieps").val(respuesta.tasaieps);
						$("#nombreProducto").html(respuesta.nombre);
						//buscarPrecios();
				});
		}
 	});
	
	$(document).on("click",".eliminarFila",function(){
		var parent = $(this).parents().get(0);
		$(parent).remove();
		TotalesaCero();
		recorrerTabla("tablaSalida","listaSalida",'');
	});
	
	$(document).on("click",".eliminarFilaOtros",function(){
		var parent = $(this).parents().get(0);
		$(parent).remove();
		TotalesaCeroOtros();
		recorrerTablaOtros('TablaServicios','listaSalidaOtros','CantidadOtros');
	});
	
	llenarSelectUsuario("");
	llenarSelectEmpleado("");
	
	
	$("#dividirVenta").click(function() {
		if ($(this).is(":checked")){
			$(".panelDivision").show();
		}else{
			$(".panelDivision").hide();
		}
	});
	
	$("#botonMostrar").click(function() {
		MuestraCotizacionesPendientes($('#cidcliente').val(),$('#autoidcliente').val());
	});
	
	$("#botonCatalogo").click(function() {
		abrirModal();
	});
	
	$("#enviarDomicilio").click(function() {
		if ($(this).is(":checked")){
			$("#cenviaradomicilio").val("ENVIO A DOMICILIO");
			$(".panelDomicilio").show(500);
			$("#domicilioentrega").focus();
			/*if($("#cidcliente").val()==0){//NO HAY CLIENTE SELECCIONADO
			  $(".panelDomicilioAlta").show(500);//MOSTRAR OBJETOS PARA DOMICILIO NUEVO
			}*/
		}else{
			$(".panelDomicilio").hide(500);
			$(".panelDomicilioAlta").hide(500);
			$("#cenviaradomicilio").val("ENTREGA EN SUCURSAL");
		}
	});
	
	$("#botonGuardar").click(function() {
			if (Spry.Widget.Form.validate(formulario)){
				if (validar()){
					$("#ctipo").val("COTIZACION");
					var variables=$("#formulario").serialize();
					guardar(variables);
				}
			}
	});
	
	$("#botonAceptar").click(function() {
			if (Spry.Widget.Form.validate(formulario)){
				if (validar()){
					$("#ctipo").val("VENTA");
					var variables=$("#formulario").serialize();
					guardar(variables);
				}
			}
	});
	
	
	
	$("#botonFiltrarModal").click(function() {
					var variables=$("#formulariofiltrar").serialize();
					FiltrarProductos(variables);
			
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
	
	$("#botonOtros").click(function() {
		
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
	
	 $("#cantidad").blur(function(event){  
	    if(validateDecimal($("#cantidad").val())){
		}
		else{
			 $("#cantidad").val("0");
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
	   recorrerTablaOtros('TablaServicios','listaSalidaOtros','CantidadOtros');//puse CantidadOtros para cuando cambien el impuesto sea como si hubieran cambiado la cantidad y se calculen los montos en la tabla
 	});
	
});

function validateDecimal(valor) {
    var RE = /^\d*\.?\d*$/;
    if (RE.test(valor)) {
        return true;
    } else {
        return false;
    }
}

function validateDecimal2Digitos(valor) {
    var RE = /^\d*(\.\d{1})?\d{0,1}$/;
    if (RE.test(valor)) {
        return true;
    } else {
        return false;
    }
}

function agregarFilaOtros(tabla, elementos, lista){
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
		FILASOTROS=FILASOTROS+1;
        var nuevaFila="<tr>";
		
				nuevaFila=nuevaFila+"<td style='display:none'>";
				nuevaFila=nuevaFila+FILASOTROS;

				nuevaFila=nuevaFila+"<td id='lfecha"+FILASOTROS+"'>";
				nuevaFila=nuevaFila+"<input name='fecha"+FILASOTROS+"' type='date' class='caja' id='fecha"+FILASOTROS+"' value= '"+fechaActual+"' onblur=\"recorrerTablaOtros('TablaServicios','listaSalidaOtros','FechaOtros')\"/>";
				nuevaFila=nuevaFila+"</td>";
		
				nuevaFila=nuevaFila+"<td>";
				nuevaFila=nuevaFila+"<input value='"+0+"' name='cantidad"+FILASOTROS+"' type='text' style='text-align: right;' class='caja' id='cantidad"+FILASOTROS+"' onblur=\"checarCerosOtros('cantidad"+FILASOTROS+"','"+FILASOTROS+"','CantidadOtros')\" onkeypress=\"return soloNumeros(event,'cantidad"+FILASOTROS+"');\" />";
				nuevaFila=nuevaFila+"</td>";
				
				nuevaFila=nuevaFila+"<td>";
				nuevaFila=nuevaFila+"<select name='servicio"+FILASOTROS+"' class='caja' id='servicio"+FILASOTROS+"' onblur=\"recorrerTablaOtros('TablaServicios','listaSalidaOtros','DescripcionOtros')\"> "+'<option value="CORTE">CORTE</option> <option value="DOBLÉS">DOBLÉS</option> <option value="FLETE">FLETE</option>'+" </select>";
				nuevaFila=nuevaFila+"</td>";
				
				nuevaFila=nuevaFila+"<td>";
				nuevaFila=nuevaFila+"<input name='unidad"+FILASOTROS+"' type='text' value='SERVICIO' class='caja' id='unidad"+FILASOTROS+"' onblur=\"recorrerTablaOtros('TablaServicios','listaSalidaOtros','UnidadOtros')\"/>";
				nuevaFila=nuevaFila+"</td>";
			
				nuevaFila=nuevaFila+"<td>";
				nuevaFila=nuevaFila+"<input value='"+0+"' name='precio"+FILASOTROS+"' type='text' style='text-align: right;' class='caja' id='precio"+FILASOTROS+"' onblur=\"checarCerosOtros('precio"+FILASOTROS+"','"+FILASOTROS+"','PrecioOtros')\" onkeypress=\"return soloNumeros(event,'precio"+FILASOTROS+"');\" />";
				nuevaFila=nuevaFila+"</td>";
			
			    nuevaFila=nuevaFila+"<td>";
				nuevaFila=nuevaFila+"<input value='"+0+"' name='limporteotros"+FILASOTROS+"' type='text' style='text-align: right;' class='caja' id='limporteotros"+FILASOTROS+"' onblur=\"checarCerosOtros('limporteotros"+FILASOTROS+"','"+FILASOTROS+"','ImporteOtros')\" onkeypress=\"return soloNumeros(event,'limporteotros"+FILASOTROS+"');\" />";
				nuevaFila=nuevaFila+"</td>";
				
				 nuevaFila=nuevaFila+"<td>";
				nuevaFila=nuevaFila+"<input value='"+0+"' name='limportenetootros"+FILASOTROS+"' type='text' style='text-align: right;' class='caja' id='limportenetootros"+FILASOTROS+"' onblur=\"checarCerosOtros('limportenetootros"+FILASOTROS+"','"+FILASOTROS+"','ImporteNetoOtros')\" onkeypress=\"return soloNumeros(event,'limportenetootros"+FILASOTROS+"');\" />";
				nuevaFila=nuevaFila+"</td>";
				
				nuevaFila=nuevaFila+"<td style='display:none;' id='limpuestos"+FILASOTROS+"' name='limpuestos"+FILASOTROS+"'>";
				nuevaFila=nuevaFila+"0.00";
				nuevaFila=nuevaFila+"</td>";
		
		nuevaFila=nuevaFila+"<td title='Eliminar Fila' class='eliminarFilaOtros'><a class='btn btn-default btn-xs'><i class='fa fa-trash-o text-green'></i><a></td>";
		nuevaFila=nuevaFila+"</tr>"
		$("#filasotros").prepend(nuevaFila); // append Coloca la fila al final de la tabla
		//$("#"+tabla).prepend(nuevaFila); //Coloca la fila al inicio de la tabla
		recorrerTablaOtros('TablaServicios','listaSalidaOtros');
}

function recorrerTablaOtros(tabla,lista,campoFuente){
	var no,fecha,servicio,precio,cantidad,importe,totalFila,unidad,impuestosFila,importeNetoFila;
	var cadena;
	var subtotal=0, total=0, impuestos =0;
	cadena="";
	$('#'+tabla+' tbody tr').each(function () {
		$(this).find('td').each(function (index,valor) {
			if (index==0){
				no=$(valor).html();
			}
			fecha=$("#fecha"+no).val();
			if (index==1  && campoFuente == "FechaOtros"){//fecha
				fecha=$("#fecha"+no).val();
				unidad=$("#unidad"+no).val();
			    servicio=$("#servicio"+no).val();
				cantidad=$("#cantidad"+no).val();//obtener la cantidad para calculo de importe
				//analizar la columna precio importe e importe neto para ver si tienen valores y hacer la accion correspondiente según la modificación a cantidad
				precio=$("#precio"+no).val();//obtener el precio base para calculo de impuestos
				importe = precio * cantidad;
				$("#limporteotros"+no).val(importe);//asignar la suma de la cantida por el precio unitario a la celda importe de la fila
				
				impuestosFila=calcularImpuestosFila(importe,no);//calcular y asignar el valro del impuesto de esta fila
				totalFila = importe + impuestosFila;
				$("#limportenetootros"+no).val(totalFila);
				//alert(no);
				if ($("#precio"+no).val()==0){
					$("#cantidad"+no).css('color', 'red');
					$("#precio"+no).css('color', 'red');
					$("#limporteotros"+no).css('color', 'red');
					$("#limportenetootros"+no).css('color', 'red');
					subtotal = parseFloat(subtotal) + parseFloat(importe);
					$("#csubtotalotros").val(subtotal);
					$("#lsubtotalotros").html(subtotal.toFixed(2));
				}else{
					$("#cantidad"+no).css('color', 'blue');
					$("#precio"+no).css('color', 'blue');
					$("#limporteotros"+no).css('color', 'blue');
					$("#limportenetootros"+no).css('color', 'blue');
					subtotal = parseFloat(subtotal) + parseFloat(importe);
					$("#csubtotalotros").val(subtotal);
					$("#lsubtotalotros").html(subtotal.toFixed(2));
				}
			}
			if (index==2 && campoFuente == "CantidadOtros"){//cantidad
				fecha=$("#fecha"+no).val();
				unidad=$("#unidad"+no).val();
			    servicio=$("#servicio"+no).val();
				cantidad=$("#cantidad"+no).val();//obtener la cantidad para calculo de importe
				//analizar la columna precio importe e importe neto para ver si tienen valores y hacer la accion correspondiente según la modificación a cantidad
				precio=$("#precio"+no).val();//obtener el precio base para calculo de impuestos
				importe = precio * cantidad;
				$("#limporteotros"+no).val(importe);//asignar la suma de la cantida por el precio unitario a la celda importe de la fila
				
				impuestosFila=calcularImpuestosFila(importe,no);//calcular y asignar el valro del impuesto de esta fila
				totalFila = importe + impuestosFila;
				$("#limportenetootros"+no).val(totalFila);
				
				if ($("#cantidad"+no).val()==0){
					$("#cantidad"+no).css('color', 'red');
					$("#precio"+no).css('color', 'red');
					$("#limporteotros"+no).css('color', 'red');
					$("#limportenetootros"+no).css('color', 'red');
					subtotal = parseFloat(subtotal) + parseFloat(importe);
					$("#csubtotalotros").val(subtotal);
					$("#lsubtotalotros").html(subtotal.toFixed(2));
				}else{
					$("#cantidad"+no).css('color', 'blue');
					$("#precio"+no).css('color', 'blue');
					$("#limporteotros"+no).css('color', 'blue');
					$("#limportenetootros"+no).css('color', 'blue');
					subtotal = parseFloat(subtotal) + parseFloat(importe);
					$("#csubtotalotros").val(subtotal);
					$("#lsubtotalotros").html(subtotal.toFixed(2));
				}
			}
			if (index==3   && campoFuente == "DescripcionOtros"){//Descripcion
				fecha=$("#fecha"+no).val();
				unidad=$("#unidad"+no).val();
			    servicio=$("#servicio"+no).val();
				cantidad=$("#cantidad"+no).val();//obtener la cantidad para calculo de importe
				//analizar la columna precio importe e importe neto para ver si tienen valores y hacer la accion correspondiente según la modificación a cantidad
				precio=$("#precio"+no).val();//obtener el precio base para calculo de impuestos
				importe = precio * cantidad;
				$("#limporteotros"+no).val(importe);//asignar la suma de la cantida por el precio unitario a la celda importe de la fila
				
				impuestosFila=calcularImpuestosFila(importe,no);//calcular y asignar el valro del impuesto de esta fila
				totalFila = importe + impuestosFila;
				$("#limportenetootros"+no).val(totalFila);
				//alert(no);
				if ($("#cantidad"+no).val()==0){
					$("#cantidad"+no).css('color', 'red');
					$("#precio"+no).css('color', 'red');
					$("#limporteotros"+no).css('color', 'red');
					$("#limportenetootros"+no).css('color', 'red');
					subtotal = parseFloat(subtotal) + parseFloat(importe);
					$("#csubtotalotros").val(subtotal);
					$("#lsubtotalotros").html(subtotal.toFixed(2));
				}else{
					$("#cantidad"+no).css('color', 'blue');
					$("#precio"+no).css('color', 'blue');
					$("#limporteotros"+no).css('color', 'blue');
					$("#limportenetootros"+no).css('color', 'blue');
					subtotal = parseFloat(subtotal) + parseFloat(importe);
					$("#csubtotalotros").val(subtotal);
					$("#lsubtotalotros").html(subtotal.toFixed(2));
				}
			}
			if (index==4  && campoFuente == "UnidadOtros"){//Unidad
				fecha=$("#fecha"+no).val();
				unidad=$("#unidad"+no).val();
			    servicio=$("#servicio"+no).val();
				cantidad=$("#cantidad"+no).val();//obtener la cantidad para calculo de importe
				//analizar la columna precio importe e importe neto para ver si tienen valores y hacer la accion correspondiente según la modificación a cantidad
				precio=$("#precio"+no).val();//obtener el precio base para calculo de impuestos
				importe = precio * cantidad;
				$("#limporteotros"+no).val(importe);//asignar la suma de la cantida por el precio unitario a la celda importe de la fila
				
				impuestosFila=calcularImpuestosFila(importe,no);//calcular y asignar el valro del impuesto de esta fila
				totalFila = importe + impuestosFila;
				$("#limportenetootros"+no).val(totalFila);
				
				if ($("#cantidad"+no).val()==0){
					$("#cantidad"+no).css('color', 'red');
					$("#precio"+no).css('color', 'red');
					$("#limporteotros"+no).css('color', 'red');
					$("#limportenetootros"+no).css('color', 'red');
					subtotal = parseFloat(subtotal) + parseFloat(importe);
					$("#csubtotalotros").val(subtotal);
					$("#lsubtotalotros").html(subtotal.toFixed(2));
				}else{
					$("#cantidad"+no).css('color', 'blue');
					$("#precio"+no).css('color', 'blue');
					$("#limporteotros"+no).css('color', 'blue');
					$("#limportenetootros"+no).css('color', 'blue');
					subtotal = parseFloat(subtotal) + parseFloat(importe);
					$("#csubtotalotros").val(subtotal);
					$("#lsubtotalotros").html(subtotal.toFixed(2));
				}
			}
			if (index==5  && campoFuente == "PrecioOtros"){//precio
				fecha=$("#fecha"+no).val();
				unidad=$("#unidad"+no).val();
			    servicio=$("#servicio"+no).val();
				precio=$("#precio"+no).val();//obtener el precio base para calculo de impuestos
				cantidad=$("#cantidad"+no).val();//obtener la cantidad para calculo de importe
				importe = precio * cantidad;
				$("#limporteotros"+no).val(importe);//asignar la suma de la cantida por el precio unitario a la celda importe de la fila
				
				impuestosFila=calcularImpuestosFila(importe,no);//calcular y asignar el valro del impuesto de esta fila
				totalFila = importe + impuestosFila;
				$("#limportenetootros"+no).val(totalFila);
				
				if ($("#precio"+no).val()==0){
					$("#cantidad"+no).css('color', 'red');
					$("#precio"+no).css('color', 'red');
					$("#limporteotros"+no).css('color', 'red');
					$("#limportenetootros"+no).css('color', 'red');
					subtotal = parseFloat(subtotal) + parseFloat(importe);
					$("#csubtotalotros").val(subtotal);
					$("#lsubtotalotros").html(subtotal.toFixed(2));
				}else{
					$("#cantidad"+no).css('color', 'blue');
					$("#precio"+no).css('color', 'blue');
					$("#limporteotros"+no).css('color', 'blue');
					$("#limportenetootros"+no).css('color', 'blue');
					subtotal = parseFloat(subtotal) + parseFloat(importe);
					$("#csubtotalotros").val(subtotal);
					$("#lsubtotalotros").html(subtotal.toFixed(2));
				}
			}
			if (index==6  && campoFuente == "ImporteOtros"){//dividir la cantidad de importe total sin impuestos de la final entre la cantidad y ponerlo en precio unitario
			    fecha=$("#fecha"+no).val();
				unidad=$("#unidad"+no).val();
			    servicio=$("#servicio"+no).val();
				cantidad= $("#cantidad"+no).val();
				importe = $("#limporteotros"+no).val();
				precio = importe / cantidad;
				$("#precio"+no).val(precio);
				cantidad=$("#cantidad"+no).val();//obtener la cantidad para calculo de importe
				importe = precio * cantidad;
				//$("#limporteotros"+no).val(importe);//asignar la suma de la cantida por el precio unitario a la celda importe de la fila
				
				impuestosFila=calcularImpuestosFila(importe,no);//calcular y asignar el valro del impuesto de esta fila
				totalFila = importe + impuestosFila;
				$("#limportenetootros"+no).val(totalFila);
				
				if ($("#limporteotros"+no).val()==0){
					$("#cantidad"+no).css('color', 'red');
					$("#precio"+no).css('color', 'red');
					$("#limporteotros"+no).css('color', 'red');
					$("#limportenetootros"+no).css('color', 'red');
					subtotal = parseFloat(subtotal) + parseFloat(importe);
					$("#csubtotalotros").val(subtotal);
					$("#lsubtotalotros").html(subtotal.toFixed(2));
				}else{
					$("#cantidad"+no).css('color', 'blue');
					$("#precio"+no).css('color', 'blue');
					$("#limporteotros"+no).css('color', 'blue');
					$("#limportenetootros"+no).css('color', 'blue');
					subtotal = parseFloat(subtotal) + parseFloat(importe);
					$("#csubtotalotros").val(subtotal);
					$("#lsubtotalotros").html(subtotal.toFixed(2));
				}
			}
			if (index==7 && campoFuente == "ImporteNetoOtros"){
				fecha=$("#fecha"+no).val();
				unidad=$("#unidad"+no).val();
			    servicio=$("#servicio"+no).val();
				cantidad=$("#cantidad"+no).val();//obtener la cantidad para calculo de importe
				importeNetoFila=$("#limportenetootros"+no).val();//obtener el importe final para calculo de impuestos
				
				impuestosFila =desglosarImpuestosFila(importeNetoFila,no);//desglosar el valor del impuesto de esta fila
				importe = importeNetoFila - impuestosFila;
				$("#limporteotros"+no).val(importe);
				precio = importe / cantidad;
				
				$("#precio"+no).val(precio);
				//cantidad=$("#cantidad"+no).val();//obtener la cantidad para calculo de importe
				//importe = precio * cantidad;
				//$("#limporteotros"+no).val(importe);//asignar la suma de la cantida por el precio unitario a la celda importe de la fila
				
				//impuestosFila=calcularImpuestosFila(importe,no);//calcular y asignar el valro del impuesto de esta fila
				totalFila = importeNetoFila;
				//$("#limportenetootros"+no).val(totalFila);
				//alert(no);
				if ($("#limportenetootros"+no).val()==0){
					$("#cantidad"+no).css('color', 'red');
					$("#precio"+no).css('color', 'red');
					$("#limporteotros"+no).css('color', 'red');
					$("#limportenetootros"+no).css('color', 'red');
					subtotal = parseFloat(subtotal) + parseFloat(importe);
					$("#csubtotalotros").val(subtotal);
					$("#lsubtotalotros").html(subtotal.toFixed(2));
				}else{
					$("#cantidad"+no).css('color', 'blue');
					$("#precio"+no).css('color', 'blue');
					$("#limporteotros"+no).css('color', 'blue');
					$("#limportenetootros"+no).css('color', 'blue');
					subtotal = parseFloat(subtotal) + parseFloat(importe);
					$("#csubtotalotros").val(subtotal);
					$("#lsubtotalotros").html(subtotal.toFixed(2));
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

function desglosarImpuestosFila(importe,no){
	var impuestodesglosado = 0;
	if(importe ==""){
		$("#limpuestos"+no).html(impuestodesglosado);//aignar 0 a la celda de impuestos que se va recorriendo
	}
	else{
		//consultaTasaImpuesto($("#idmodeloimpuestos_ajax").val());//envío el valor que quiero revisar en la base de datos que se irá pro la variable condicion
		//recibir resultado de función en arreglo de tasas hacer un ciclo por cada tasa multiplicar el importe y enviar resultado acumulado a caja de texto cimpuestos, el resultado de esta función lo arroja a la caja cTasas
		
		var impuestos=$("#idmodeloimpuestos_ajax").find('option:selected').attr("impuestos");
		var aimpuestos = impuestos.split(',');
		for(i=0; i<aimpuestos.length; i++){
			var aimpuesto = aimpuestos[i].split(':');
			//if()//Si es iva o ipes
			impuestodesglosado = impuestodesglosado + (importe - (importe / (1 + parseFloat(aimpuesto[1]))));
		}
		$("#limpuestos"+no).html(impuestodesglosado);//aignar la suma de los impuestos calculados
	}
	return impuestodesglosado;
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

function TotalesaCero(){
	$("#lsubtotal").html(0.00);
	$("#csubtotal").val(0.00);
	$("#limpuestos").html(0.00);
	$("#civa").val(0.00);
	$("#ltotal").html(0.00);
	$("#ctotal").val(0.00);
}
function TotalesaCeroOtros(){
	$("#lsubtotalotros").html(0.00);
	$("#csubtotalotros").val(0.00);
	$("#limpuestosotros").html(0.00);
	$("#cimpuestosotros").val(0.00);
	$("#ltotalotros").html(0.00);
	$("#cmontootros").val(0.00);
}

function validar(){
	var estado=true;
	var mensaje="";
	
	if (estado==false){
		mostrarMensaje(mensaje);
	}
	return estado;
}

function agregarFila(tabla, elementos,lista){
		FILAS=FILAS+1;
        var nuevaFila="<tr>";
		var con=0;
		while (con <= 7){
			if (con==0){
				nuevaFila=nuevaFila+"<td style='display:none'>";
				nuevaFila=nuevaFila+FILAS;
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==1){//ID
				nuevaFila=nuevaFila+"<td style='display:none'>";
				nuevaFila=nuevaFila+elementos[con];
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==2){//CLAVE
				nuevaFila=nuevaFila+"<td>";
				nuevaFila=nuevaFila+elementos[con];
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==3){//PRODUCTO
				nuevaFila=nuevaFila+"<td class=\"columnaIzquierda\" style=\"border-left: 10px solid #25c274;\">";
				nuevaFila=nuevaFila+elementos[con];
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==4){//CANTIDAD
				if($("#cantidad").val()==""){
					$("#cantidad").val("1");
				}
				nuevaFila=nuevaFila+"<td>";
				nuevaFila=nuevaFila+"<input value='"+$("#cantidad").val()+"' name='cant"+FILAS+"' type='text' style='text-align:right' class='caja' id='cant"+FILAS+"' onblur=\"checarCeros('cant"+FILAS+"','"+FILAS+"')\" onkeypress=\"return soloNumeros(event,'cant"+FILAS+"');\" />";
				nuevaFila=nuevaFila+"</td>";
			}
			
			if (con==5){//LISTAS DE PRECIOS
				
				var con2=0;
				var precios = elementos[con];//arreglo de precios
				var IDsListas = elementos[6];//arreglo de listas de precios
				var valoresimpuestos = elementos[7];//arreglo de las tasas de los impuestos relacionados a este producto
				var costopromedio = elementos[8];
				var pesoteorico = elementos[9];
				nuevaFila=nuevaFila+"<td id='precioR"+FILAS+"'>";
				nuevaFila=nuevaFila+'<div class="row">';
				
				while(con2 < precios.length){
					var PrecioPublico = precios[con2];
					var Impuestos = CalculaImpuestos(PrecioPublico,valoresimpuestos);
					var Tasas = SumaTasas(valoresimpuestos);
					var PrecioNeto = parseFloat(PrecioPublico) + parseFloat(Impuestos);
					//PrecioNeto = PrecioNeto.toFixed(2);
					nuevaFila=nuevaFila+"<div class='col-md-2 colprecio2'><input class='precios"+IDsListas[con2]+"' id='prec1"+FILAS+"' style='text-align:right' type='radio' name='preciok"+FILAS+"' precio='"+PrecioPublico+"' costopromedio = '"+costopromedio+"' pesoteorico = '"+pesoteorico+"' tasas = '"+Tasas+"' value='"+PrecioNeto+"' onclick=\"checarCeros('prec1"+FILAS+"','"+FILAS+"');CerosAColumnaPrecioUnitario('tablaSalida','"+FILAS+"')\"/>&nbsp;$"+PrecioNeto.toFixed(2)+"</div>";
					con2++;
				}
				
				nuevaFila=nuevaFila+'</div>';
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==6){//PRECIO FIJO
				nuevaFila=nuevaFila+"<td>";
				nuevaFila=nuevaFila+"<input value='"+0.00+"' name='importe"+FILAS+"' type='text' style='text-align:right' class='caja' id='importe"+FILAS+"' onblur=\"checarCeros('importe"+FILAS+"','"+FILAS+"')\" onkeypress=\"return soloNumeros(event,'importe"+FILAS+"');\" />";
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==7){//IMPORTE
			    nuevaFila=nuevaFila+"<td id='limporte"+FILAS+"' name='limporte"+FILAS+"'>";
				nuevaFila=nuevaFila+"0.00";
				nuevaFila=nuevaFila+"</td>";
			}
			con=con+1;
		}
		nuevaFila=nuevaFila+"<td title='Eliminar Fila' class='eliminarFila'><a class='btn btn-default btn-xs'><i class='fa fa-trash-o text-green'></i><a></td>"; 
		nuevaFila=nuevaFila+"</tr>"
		$("#"+tabla).prepend(nuevaFila);//append Coloca la fila al final de la tabla
		$("#cantidad").val("");
		$("#autoidproducto").val("");
		$("#cantidad").focus();
		//$("#"+tabla).prepend(nuevaFila); //Coloca la fila al inicio de la tabla
		recorrerTabla(tabla,lista);
}

function SumaTasas(valoresimpuestos){
	con = 0;
	var SumaTasas = 0;
	while(con < valoresimpuestos.length){
	   var valorimpuesto = valoresimpuestos[con];
	   SumaTasas = SumaTasas + valorimpuesto;
	   con = con+1;	
	}
	
	return SumaTasas;
}

function CalculaImpuestos(PrecioPublico,valoresimpuestos){
	con = 0;
	var MontoImpuestos = 0;
	while(con < valoresimpuestos.length){
		var valorimpuesto = valoresimpuestos[con];
		MontoImpuestos = MontoImpuestos + (PrecioPublico * valorimpuesto);
		con=con+1;
	}
	return MontoImpuestos;
}

function marcarTodosPrecios(listaPrecios){
	$(".precios"+listaPrecios).prop("checked", true);
	//poner en ceros todos los precios unitarios editados
	CerosAColumnaPrecioUnitario("tablaSalida",1000);
	recorrerTabla("tablaSalida","listaSalida");
}

function CerosAColumnaPrecioUnitario(tabla,columna){
	if(columna ==1000){//ceros a todas
		   $('#'+tabla+' tbody tr').each(function () {
				$(this).find('td').each(function (index,valor) {
					if (index==0){
						no=$(valor).html();
					}
					if (index==7){
					   $("#importe"+no).val($("input:radio[name=preciok"+no+"]:checked").val());
					}
				})
			})
	}
	else{//cero a columna seleccionada
	     $("#importe"+columna).val($("input:radio[name=preciok"+columna+"]:checked").val());
		 recorrerTabla("tablaSalida","listaSalida");
	}
}
function validarDuplicado(tabla,idbusqueda,columna){
	var validar = true;
	var idencontrado = 0;
	$('#'+tabla+' tbody tr').each(function () {
		$(this).find('td').each(function (index,valor) {
			if (index==columna){//
				idencontrado =$(valor).html();
				if(idencontrado == idbusqueda){//el ID ya se encuentra en la tabla
					//MENSAJE
					$("#panel_alertas").removeClass().addClass("alert alert-error alert-dismissable");
					$("#notificacionTitulo").html("<i class='icon fa fa-ban'></i>"+"EL PRODUCTO YA SE ENCUENTRA AGREGADO A LA LISTA");
					$("#notificacionContenido").html("No se permite agregar mas de una vez el mismo producto en la lista");
					$("#panel_alertas").stop(false, true);
					$("#panel_alertas").fadeIn("slow");
					var $contenedor=$("body");
					$("html,body").animate({scrollTop:0},1000);
					$("#panel_alertas").delay(6000).fadeOut("slow");
					validar = false;
				}
			}
		})
	})
	return validar;
}
	
	

function recorrerTabla(tabla,lista){
	var no, idproducto,cantidad,precio,costopromedio,precioNeto,importe=0,importeNeto,impuestos=0,pesoteorico,utilidad,subtotal=0,sumaimpuestos=0,total=0,costodeventa=0,sumautilidad=0,pesoteoricototal=0;
	var cadena="";
	$('#'+tabla+' tbody tr').each(function () {
		$(this).find('td').each(function (index,valor) {
			if (index==0){
				no=$(valor).html();
			}
			if (index==1){
				idproducto=$(valor).html();
			}
			if (index==3){
				cantidad=$("#cant"+no).val();
				if ($("#cant"+no).val()==0){
					$("#cant"+no).css('color', 'red');
				}else{
					$("#cant"+no).css('color', 'blue');
				}
			}
			
			if($("#importe"+no).val() == 0){//Tomar el precioNeto de los options
					//alert("la caja de texto está en cero");
				precioNeto=$("input:radio[name=preciok"+no+"]:checked").val();//OBTIENE LA PROPIEDAD VAL POR DEFECTO
				precio=$("input:radio[name=preciok"+no+"]:checked").attr("precio");//OBTENER EL VALOR DE UN ATRIBUTO
				costopromedio=$("input:radio[name=preciok"+no+"]:checked").attr("costopromedio");//OBTENER EL VALOR DE UN ATRIBUTO
				pesoteorico=$("input:radio[name=preciok"+no+"]:checked").attr("pesoteorico");//OBTENER EL VALOR DE UN ATRIBUTO
			}
			else{//Tomar el precioNeto de la caja de texto
			     //alert("la caja de texto NO está en cero");
				precioNeto=$("#importe"+no).val();//OBTIENE LA PROPIEDAD VAL POR DEFECTO
				SumTasas=$("input:radio[name=preciok"+no+"]").attr("tasas");//OBTENER EL VALOR DE UN ATRIBUTO
				precio=(parseFloat($("#importe"+no).val()) / (parseFloat(SumTasas) + 1));//DESGLOZAR LOS IMPUESTOS DE ESTE RODUCTO PARA LLEGAR A ESTE VALOR
				costopromedio=$("input:radio[name=preciok"+no+"]").attr("costopromedio");//OBTENER EL VALOR DE UN ATRIBUTO
				pesoteorico=$("input:radio[name=preciok"+no+"]").attr("pesoteorico");//OBTENER EL VALOR DE UN ATRIBUTO
			}
			if (index==5){
				if($("input:radio[name=preciok"+no+"]:checked").is(':checked')){
					
				}
			}
		})
		//VALIDAR QUE precio cantidad precio Neto tengan valor si no poner cero
		if (typeof precio === "undefined") {
			precio = 0;
		}
		if (typeof cantidad === "undefined") {
			cantidad = 0;
		}
		if (typeof precioNeto === "undefined") {
			precioNeto = 0;
		}
		importe = parseFloat(cantidad * precio);
		importeNeto = parseFloat(cantidad * precioNeto);
		impuestos = parseFloat(importeNeto - importe);
		utilidad = parseFloat((cantidad * precio) - (cantidad * costopromedio));
		pesoteorico = parseFloat(cantidad * pesoteorico);
		pesoteoricototal = parseFloat(pesoteoricototal + pesoteorico);
		
		//CALCULAR IMPORTE DE LA FILA
		if(importeNeto > 0){
		$("#limporte"+no).html(importeNeto);
		}
		else{
			$("#limporte"+no).html(0.00);
		}
		
		//ARMAR CADENA
		cadena=cadena+idproducto+":::"+cantidad+":::"+costopromedio+":::"+precio+":::"+precioNeto+":::"+importe+":::"+importeNeto+":::"+impuestos+":::"+utilidad+":::"+pesoteorico+":::";
		
		//TOTALES
		subtotal = parseFloat(subtotal + importe);
		sumaimpuestos = parseFloat(sumaimpuestos + impuestos);
		if(subtotal > 0){
			$("#lsubtotal").html("$"+subtotal.toFixed(2));
			//$("#tsubtotal").html("$"+subtotal.toFixed(2));
			$("#csubtotal").val(subtotal);//sin redondear para guardar
			
			$("#limpuestos").html("$"+sumaimpuestos.toFixed(2));
			//$("#tiva").html("$"+sumaimpuestos.toFixed(2));
			$("#cimpuestos").val(sumaimpuestos);//sin redondear para guardar
			
			
			total=parseFloat(subtotal+sumaimpuestos);
			$("#ltotal").html("$"+total.toFixed(2));
			//$("#ttotal").html("$"+total.toFixed(2));
			$("#ctotal").val(total);//sin redondear para guardar
			
			//costosyutilidades
			costodeventa = parseFloat(costodeventa) + parseFloat(cantidad * costopromedio);
			$("#ccostodeventa").val(costodeventa);
			sumautilidad = parseFloat(sumautilidad) + parseFloat(utilidad);
			$("#cutilidad").val(sumautilidad);//sumautilidad
		}
		else{
			TotalesaCero();
		}
	})
	$("#peso").val(pesoteoricototal);
	$("#"+lista).val(cadena);
}

function checarCeros(id,idtotal) {
	
	var cant=$("#cant"+idtotal).val();
	var precio=$("input:radio[name=preciok"+idtotal+"]:checked").val();

	preciocompleto=precio;
	var totalcompleto=cant*preciocompleto;
	$("#totalR"+idtotal).text(totalcompleto.toFixed(2));
	
	var total=cant*precio;
	$("#total"+idtotal).text(total.toFixed(2));
	recorrerTabla("tablaSalida","listaSalida");
}

function checarCerosOtros(id,idtotal,campofuente) {
	campo=$("#"+id).val();
	campo=$.trim(campo);
	if (campo=="" || campo==0 || campo=="."){
		$("#"+id).val("0.00");
	}
	recorrerTablaOtros('TablaServicios','listaSalidaOtros',campofuente);
}

//**************************AJAX*******************************
// Autor: Armando Viera Rodríguez
// Onixbm 2016

function buscar (busqueda){
	location.href='../consultar/vista.php?link=vista&busqueda='+busqueda+'&n1=cotizacionesproductos&n2=consultarcotizacionesproductos';
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

function obtenerSerieOtros(){
		$("#cserieotros").val("Cargando...");
		$("#lserieotros").html("Cargando...");
		$.ajax({
			url: '../componentes/obtenerSerieOtros.php',
			type: "POST",
			data: "", //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#cserieotros").val(mensaje);
				$("#lserieotros").html(mensaje);
			}
		});
		return false;
}

function obtenerFolioOtros(){
		$("#cfoliootros").val("Cargando...");
		$.ajax({
			url: '../componentes/obtenerFolioOtros.php',
			type: "POST",
			data: "", //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#cfoliootros").val(mensaje);
				$("#lfoliootros").html(mensaje);
			}
		});
		return false;
}

function llenarSelectUsuario(condicion){
		$("#idusuario_ajax").html("<option value='1'>cargando...</option>");
		$.ajax({
			url: '../componentes/llenarSelectUsuario.php',
			type: "POST",
			data: "submit=&condicion="+condicion, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#idusuario_ajax").html(mensaje);
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

function MuestraCotizacionesPendientes(idcliente,cliente){
	//REVISAR SI HAY COTIZACIONES PENDIENTES Y DE SER ASÍ MOSTRARLAS
		window.open('../consultar/vista.php?n1='+"ventas"+'&n2='+"cotizacionesproductos"+'&n3='+"consultarcotizacionesproductos"+'&idcliente='+idcliente+'&cliente='+cliente+'&tipo="COTIZACION"', '_blank');
	
}

function llenarSelectDomicilio(condicion){
		var idcliente=$("#cidcliente").val();
		$("#iddomicilio_ajax").html("<option value='1'>cargando...</option>");
		$.ajax({
			url: '../componentes/llenarSelectDomicilio.php',
			type: "POST",
			data: "submit=&idcliente="+idcliente, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#iddomicilio_ajax").html(mensaje);
			}
		});
		return false;
}

function llenarChecksContactos(condicion){
		var idcliente=$("#cidcliente").val();
		$("#servicios_ajax").html("Cargando contactos...");
		$.ajax({
			url: '../componentes/llenarChecksContactos.php',
			type: "POST",
			data: "submit=&idcliente="+idcliente, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#contactos_ajax").html(mensaje);
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


function llenarSelectEstado(condicion){
		$("#estado_ajax").html("<option value='1'>cargando...</option>");
		$.ajax({
			url: '../componentes/llenarSelectEstado.php',
			type: "POST",
			data: "submit=&condicion="+condicion, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#estado_ajax").html(mensaje);
			}
		});
		return false;
}
function llenarSelectZona(condicion){
		$("#idzona_ajax").html("<option value='1'>cargando...</option>");
		$.ajax({
			url: '../componentes/llenarSelectZonaNuevo.php',
			type: "POST",
			data: "submit=&condicion="+condicion, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#idzona_ajax").html(mensaje);//Modal
				$("#idzona_ajax2").html(mensaje);
			}
		});
		return false;
}

function llenarSelectGirocomercial(condicion){
		$("#idgirocomercial_ajax").html("<option value='1'>cargando...</option>");
		$.ajax({
			url: '../componentes/llenarSelectGirocomercial.php',
			type: "POST",
			data: "submit=&condicion="+condicion, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#idgirocomercial_ajax").html(mensaje);
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

/*function guardar(variables){
	   //alert(variables);
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
}*/

function eliminarCotizacionesViejas(dias){
		$.ajax({
			url: '../eliminar/eliminarauto.php',
			type: "POST",
			data: "submit=&dias="+dias, //Pasamos los datos en forma de array
			success: function(mensaje){
				//mostrarMensaje(mensaje);NO SE MUESTRA MENSAJE YA QUE TRABAJARA EN SEGUNDO PLANO
			}
		});
		return false;
}

function mostrarMensaje(mensaje){
	//alert(mensaje);
	$("#salida").html(mensaje);//PARA REVISAR CONSULTAS SQL 
	var cadena= $.trim(mensaje); //Limpia la cadena regresada desde php
	var res=cadena.split("@"); //Separa la cadena en cada @ y convierte las partes en un array
	if (res[0]=="exito"){ //Si la primer frase contiene la palabra "exito"
		$("#panel_alertas").removeClass().addClass("alert alert-success alert-dismissable");
		$("#notificacionTitulo").html("<i class='icon fa fa-check'></i>"+res[1]);
		$("#notificacionContenido").html(res[2]);
		vaciarCampos();
		llenarDatosFijos();
		$(".panelDomicilio").hide(500);
		$(".panelDomicilioAlta").hide(500);
		$("#cenviaradomicilio").val("ENTREGA EN SUCURSAL");
		document.getElementById("enviarDomicilio").checked = false;
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
