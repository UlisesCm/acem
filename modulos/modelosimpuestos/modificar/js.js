// FUNCIONES DE LLENADO DE TABLA DE INFERIOR
var FILAS=0;
var CONDICION="";

$(document).ready(function() {

$("#botonAgregarFila").click(function() {
			var tipoV=$("#ctipo").val();
			var claveimpuestoV=$("#cimpuesto").val();
			var impuestoV=$('#cimpuesto option:selected').html();
			var factorV=$("#cfactor").val();
			var valorV=$.trim($("#cvalor").val());
			
			
			if (tipoV!="" &&  impuestoV!="" && factorV!=""){ // TODAS LAS REGLAS DE VALIDACION DE IMPUESTOS DEL SAT VAN AQUÍ
				if(valorV=="" || valorV=="." || valorV<0){
					mostrarMensaje("fracaso@Revise el valor del impuesto@<p>Es necesario que el valor corresponda a un numero valido</p>");
					$("#cvalor").focus();
				}else{
					variables=new Array();
					variables[0]=0; //Nueva fila
					variables[1]=claveimpuestoV; //Nueva fila
					variables[2]=impuestoV;
					variables[3]=tipoV;
					variables[4]=factorV;
					variables[5]=valorV;
					if (contarFilas(claveimpuestoV, tipoV)==false){
						agregarFila("tablaSalida", variables, "listaSalida");
					}else{
						mostrarMensaje("fracaso@Impuesto agregado recientemente@<p>No es posible agregar el impuesto nuevamente por que ya existe</p>");
					}
					$("#cvalor").val("");
					$("#cimpuesto").focus();
				}
			}else{
				mostrarMensaje("fracaso@Seleccione un impuesto@<p>El impuesto que intenta ingresar no existe en la base de datos</p>");
				$("#cimpuesto").focus();
			}
	}); 
	
	
	
	$("#cvalor").keypress(function(){
		return checarDecimal(event, this);
	});
	
	$(document).on("click",".eliminarFila",function(){
		var parent = $(this).parents().get(0);
		$(parent).remove();
		recorrerTabla("tablaSalida","listaSalida"); // Crea la cadena de recursos que se enviara a timbrado
	});
	
});

function calcularTotal(){
	var ntotal=0;
	var ndesvio=$("#ndesvio").val();
	var ncantidad=$("#ncantidad").val();
	var nfactor=$("#nfactor").val();
	var ncosto=$("#ncosto").val();
	ntotal=(ncantidad/nfactor)*ncosto;
	ndesvio=(ndesvio*ntotal)/100;
	ntotal=ntotal+ndesvio;
	ntotal=ntotal.toFixed(2);
	return ntotal;
}
//FIN DE FUNCIONES DE LLANDO DE TABLA DE INFERIOR

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
	if (campo=="" || campo==0 || campo=="."){
		$("#"+id).val("0.00");
	}
	
	var ntotal=0;
	var ndesvio=$("#desvio"+idtotal).val();
	var ncantidad=$("#cantidad"+idtotal).val();
	var nfactor=$("#factor"+idtotal).val();
	var ncosto=$("#costo"+idtotal).val();
	ntotal=(ncantidad/nfactor)*ncosto;
	ndesvio=(ndesvio*ntotal)/100;
	ntotal=ntotal+ndesvio;
	ntotal=ntotal.toFixed(2);
	if (ntotal=="NaN"){
		$("#"+id).val("0.00");
		checarCeros(id,idtotal);
		return 0;
	}
	
	$("#total"+idtotal).text(ntotal);
	
	recorrerTabla("tablaSalida","listaSalida");
}
	
function redibujarTabla(id,idtotal) {
	recorrerTabla("tablaSalida","listaSalida");
}
	
function agregarFila(tabla, elementos,lista){
		FILAS=FILAS+1;
        var nuevaFila="<tr>";
		var con=0;
		while (con < elementos.length){
			if (con==0){
				nuevaFila=nuevaFila+"<td style='display:none'>";
				nuevaFila=nuevaFila+FILAS;
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==1){
				nuevaFila=nuevaFila+"<td class=\"columnaIzquierda\" style=\"border-left: 10px solid #25c274;\" align='center'>";
				nuevaFila=nuevaFila+elementos[con];
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==2){
				nuevaFila=nuevaFila+"<td align='center'>";
					nuevaFila=nuevaFila+elementos[con]; 
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==3){
				nuevaFila=nuevaFila+"<td align='center'>";
					nuevaFila=nuevaFila+elementos[con]; 
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==4){
				nuevaFila=nuevaFila+"<td align='center'>";
					nuevaFila=nuevaFila+elementos[con]; 
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==5){
				nuevaFila=nuevaFila+"<td align='center'>";
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


function contarFilas(claveimpuesto, tipo){
	var no, clave, tipok;
	tabla="tablaSalida";
	var encontrado1=false, encontrado2=false; resultado=false;
	$('#'+tabla+' tbody tr').each(function () {
		$(this).find('td').each(function (index,valor) {
			
			if (index==0){
				no=$(valor).html();
			}
			if (index==1){
				clave=$(valor).html();
				//alert(claveimpuesto+"-"+clave);
				if (clave==claveimpuesto){
					encontrado1=true;
				}
			}
			
			if (index==3){
				tipok=$(valor).html();
				if (tipok==tipo){
					encontrado2=true;
				}
			}
			
			if(encontrado1==true && encontrado2==true){
				resultado=true;
			}
			encontrado1==false;
			encontrado2=false;
		})
	})
	return resultado;
}


function recorrerTabla(tabla,lista){
	var cno, cclaveimpuesto, cimpuesto, ctipo, cfactor, cvalor;
	var cadena;
	cadena="";
	$('#'+tabla+' tbody tr').each(function () {
		$(this).find('td').each(function (index,valor) {
			if (index==0){
				cno=$(valor).html();
			}
			if (index==1){
				cclaveimpuesto=$(valor).text();
			}
			if (index==2){
				cimpuesto=$(valor).text();
					
			}
			if (index==3){
				ctipo=$(valor).text();
					
			}
			if (index==4){
				cfactor=$(valor).html();
					
			}
			if (index==5){
				cvalor=$(valor).html();
					
			}
			
			//$(valor).css("background-color", "#ECF8E0");
		})
		cadena=cadena+cclaveimpuesto+":::"+cimpuesto+":::"+ctipo+":::"+cfactor+":::"+cvalor+":::";
	})
	$("#"+lista).val(cadena);
	//$("#totalLista").html(total);
}
//FIN DE FUNCIONES DE LLANDO DE TABLA DE INFERIOR

// JS MODULA Autor: Armando Viera Rodriguez 2016
function vaciarCampos(){
	$("#cnombre").focus();
}

$(document).ready(function() {
	
	$("#panel_alertas").hide();
	$(".loading").hide();
	llenarTabla($("#cidmodeloimpuestos").val());
	//$("#panel_alertas").delay(8000).hide(600);
	
	
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
	
	
});

function validar(){
	var estado=true;
	var mensaje="";
	
	if (estado==false){
		mostrarMensaje(mensaje);
	}
	return estado;
}// Autor: Armando Viera Rodríguez
// Onixbm 2016

function buscar (busqueda){
	location.href='../consultar/vista.php?link=vista&busqueda='+busqueda+'&n1=modelosimpuestos&n2=consultarmodelosimpuestos';
}

function guardar(variables){
		$("#botonGuardar").hide();
		$(".loading").show();
		$.ajax({
			url: 'guardar.php',
			type: "POST",
			data: "submit=&"+variables, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#botonGuardar").show();
				$(".loading").hide();
				mostrarMensaje(mensaje);
			}
		});
		return false;
}

function llenarTabla(id){
		$("#filas").html("<div class='loading'>Cargando...</div>");
		$.ajax({
			url: 'consultarDetalle.php',
			type: "POST",
			data: "submit=&id="+id, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(respuesta){
				$("#filas").html(respuesta);
				recorrerTabla("tablaSalida","listaSalida");
			}
		});
		return false;
}


function mostrarMensaje(mensaje){
	//alert(mensaje);
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