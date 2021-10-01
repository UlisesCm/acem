// JS MODULA Autor: Armando Viera Rodriguez 2016
// JavaScript Document

// FUNCIONES DE LLENADO DE TABLA DE INFERIOR
var FILAS=0;
var CONDICION="";


function seleccionarProveedor(idfila,costo,idproveedor,nombreproveedor){
	$("#cost"+idfila).val(costo);
	$("#idproveedor"+idfila).html(idproveedor);
	$("#nombreproveedor"+idfila).html(nombreproveedor);
}

function abrirModal(idproducto,idfila){
	$("#modal").modal();
	$.ajax({
		url: 'consultardetalles.php',
		type: "POST",
		data: "submit=&id="+idproducto+"&idfila="+idfila, //Pasamos los datos en forma de array
		success: function(mensaje){
			$("#contenidoModal").html(mensaje);
		}
	});
	return false;
}

function llenarProducto(){
	$.ajax({
           url:'../componentes/Producto.php',
           type:'POST',
           dataType:'json',
           data:{ termino:$('#autoidproducto').val()}
        }).done(function(respuesta){
            $("#cidproducto").val(respuesta.id);
			$("#ccodigoproducto").val(respuesta.codigo);
			$("#nunidad").val(respuesta.unidad);
			$("#nnombreproducto").val(respuesta.nombre);
			$("#ncosto").val(respuesta.costocompra);
			$("#ncontenidoneto").val(respuesta.contenidoneto);
			$("#npesoteorico").val(respuesta.pesoteorico);
			agregarProducto();
       });
}

function agregarProducto(){
			var idproductoV=$("#cidproducto").val();
			var idproductoV=$("#nidproducto").val();
			var codigoproductoV=$("#ccodigoproducto").val();
			var nombreproductoV=$("#nnombreproducto").val();
			var unidadV=$("#nunidad").val();
			var cantidadV=parseFloat ($("#ncantidad").val());
			var costoV=parseFloat ($("#ncosto").val());
			var minimoV=$("#nminimo").val();
			var ubicacionV=$("#nubicacion").val();
			var contenidonetoV=$("#ncontenidoneto").val();
			var idsucursalV=$("#idsucursal_ajax").val();
			var nombresucursalV= $('select[id="idsucursal_ajax"] option:selected').text();
			var precio1V=$("#nprecio1").val();
			var idproveedorV=$("#nidproveedor").val();
			var nombreproveedorV=$("#nnombreproveedor").val();
			var pesoteoricounitarioV=parseFloat ($("#npesoteorico").val());
			var pesoteoricoV=pesoteoricounitarioV*cantidadV;
			var montoV=costoV*cantidadV;
			
				if (idproductoV!=""){
					if(cantidadV=="" || cantidadV=="." || cantidadV=="0"){
						mostrarMensaje("fracaso@Ingrese la cantidad@<p>Es necesario proporcionar la cantidad de productos que van a entrar</p>");
						$("#ncantidad").focus();
					}else{
						variables=new Array();
						
						variables[0]=0; //Nueva fila
						variables[1]=idproductoV;
						variables[2]=codigoproductoV;
						variables[3]=nombreproductoV;
						variables[4]=unidadV;
						variables[5]=cantidadV;
						variables[6]=costoV;
						variables[7]=montoV;
						variables[8]=pesoteoricounitarioV;
						variables[9]=pesoteoricoV;
						variables[10]=0;
						variables[11]=0;
						variables[12]=idsucursalV;
						variables[13]=nombresucursalV;
						variables[14]=idproveedorV;
						variables[15]=nombreproveedorV;
						
						if (contarFilas(idproductoV, idsucursalV, cantidadV)==false){
							agregarFila("tablaSalida", variables, "listaSalida");
						}else{
							recorrerTabla("tablaSalida","listaSalida");
						}
						$("#cidproducto").val("");
						$("#autoidproducto").val("");
						$("#autoidproducto").focus();
						document.getElementById('playerq').play();
					}
				}else{
					mostrarMensaje("fracaso@Seleccione un producto@<p>El producto que intenta ingresar no existe en la base de datos</p>");
					$("#cidproducto").val("");
					$("#autoidproducto").val("")
					$("#autoidproducto").focus();
					document.getElementById('player').play();
				}
}
$(document).ready(function() {

	//AUTOCOMPLETAR
	$("#autoidproducto").autocomplete({
        source: "../componentes/buscarProductoNombre.php",
		autoFocus:true,
		select:function(event,ui){ 
        	$('#cidproducto').val(ui.item.id);
			$('#nunidad').val(ui.item.unidad);
			$('#ncosto').val(ui.item.costo);
			$('#consultaidproducto').val(ui.item.consulta);
			$('#nnombreproducto').val(ui.item.consulta);
			$('#ccodigoproducto').val(ui.item.codigo);
			$("#nidproducto").val(ui.item.idproducto);
			$("#nprecio1").val(ui.item.precio1);
			$("#nidproveedor").val(ui.item.idproveedor);
			$("#nnombreproveedor").val(ui.item.nombreproveedor);
			$("#npesoteorico").val(ui.item.pesoteorico);
    	},
		search: function (event, ui) {
			$("#cidproducto").val("");
			$("#consultaidproducto").val($("#autoidproducto").val());
		},
		
        minLength: 1
    });
	// FIN AUTOCOMPLETAR
	
	
	$("#autoidproducto").keypress(function(event){ 
		var keycode = (event.keyCode ? event.keyCode : event.which); 
      	if(keycode == '13'){
			agregarProducto();
		}
    });
	// FIN AUTOCOMPLETAR
	
	$("#botonAgregarFila").click(function() {
			agregarProducto();
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
	
	$("#idproveedor_ajax").change(function(){
		$.when(comprobarProveedor("tablaSalida","listaSalida")).then(recorrerTabla("tablaSalida","listaSalida"));
	});
	
	$(document).on("click",".eliminarFila",function(){
		var parent = $(this).parents().get(0);
		$(parent).remove();
		recorrerTabla("tablaSalida","listaSalida"); // Crea la cadena de productos
	});
	
	$(document).on("click",".eliminarFilaR",function(){
		var idsucursal=$(this).parent("tr").children(".idsucursal").html();
		var pregunta = confirm("Esta acción eliminará de la lista todos los productos cuyas requisiciones correspondan a la misma sucursal ¿Desea continuar?");
		if (pregunta){
			removerFilas("tablaSalida","listaSalida",idsucursal); // Elimina las filas de la taba de requisiciones y de productos de acuardo con el idsucursal
		}
		
	});
	//FIN DE FUNCIONES DE LLANDO DE TABLA DE INFERIOR
});

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
	
function calcular(campo,id) {
	valor=$("#"+campo+id).val();
	valor=$.trim(valor);
	if (valor=="" || valor==0 || valor=="."){
		$("#"+campo+id).val("0.00");
	}
	if ($("#"+campo+id).val()==0){
		$("#"+campo+id).css("color","#F00");
	}else{
		$("#"+campo+id).css("color","#00F");
	}
	if (campo=="cant"){
		var cant=parseFloat ($("#cant"+id).val());
		var cost= parseFloat ($("#cost"+id).val());
		var montototal=cant*cost;
		
		var pesounitario= parseFloat ($("#pesoteoricounitario"+id).html());
		var pesoreal= parseFloat ($("#pesoreal"+id).html());
		var pesototal=0;
		if (pesoreal!=0){
			pesototal=cant*pesoreal;
		}else if (pesounitario!=0){
			pesototal=cant*pesounitario;
		}else{
			pesototal=cant;
		}
		$("#monto"+id).text("$"+new Intl.NumberFormat("en-IN").format(montototal.toFixed(4)));
		if (pesounitario!=0 && pesoreal!=0){
			$("#pesoteorico"+id).val(pesototal.toFixed(4));
		}
	}
	
	if (campo=="cost"){
		var cant=parseFloat ($("#cant"+id).val());
		var cost= parseFloat ($("#cost"+id).val());
		var montototal=cant*cost;
		var pesounitario= parseFloat ($("#pesoteoricounitario"+id).html());
		var pesoreal= parseFloat ($("#pesoreal"+id).html());
		var cost2=0;
		if (pesoreal!=0){
			cost2=cost/pesoreal;
		}else if (pesounitario!=0){
			cost2=cost/pesounitario;
		}else{
			cost2=cost;
		}
		
		$("#monto"+id).text("$"+new Intl.NumberFormat("en-IN").format(montototal.toFixed(4)));
		if (pesounitario!=0 && pesoreal!=0){
			$("#cost2"+id).val(cost2.toFixed(4));
		}
	}
	
	if (campo=="cost2"){
		var cant=parseFloat ($("#cant"+id).val());
		var cost2= parseFloat ($("#cost2"+id).val());
		var pesounitario= parseFloat ($("#pesoteoricounitario"+id).html());
		var pesoreal= parseFloat ($("#pesoreal"+id).html());
		var cost=0;
		if (pesoreal!=0){
			cost=cost2*pesoreal;
		}else if (pesounitario!=0){
			cost=cost2*pesounitario;
		}else{
			cost=cost2;
		}
		var montototal=cant*cost;
		
		$("#monto"+id).text("$"+new Intl.NumberFormat("en-IN").format(montototal.toFixed(4)));
		$("#cost"+id).val(cost.toFixed(4));
	}
	
	if (campo=="pesoteorico"){
		var pesototal=parseFloat ($("#pesoteorico"+id).val());
		var cost2= parseFloat ($("#cost2"+id).val());
		
		var pesounitario= parseFloat ($("#pesoteoricounitario"+id).html());
		var pesoreal= parseFloat ($("#pesoreal"+id).html());
		var cant=0;
		if (pesoreal!=0){
			cant=pesototal/pesoreal;
		}else if (pesounitario!=0){
			cant=pesototal/pesounitario;
		}else{
			cant=pesototal;
		}
		
		var montototal=pesototal*cost2;
		
		$("#monto"+id).text("$"+new Intl.NumberFormat("en-IN").format(montototal.toFixed(4)));
		$("#cant"+id).val(cant.toFixed(4));
	}
	
	recorrerTabla("tablaSalida","listaSalida");
}

	
function redibujarTabla(id,idtotal) {
	recorrerTabla("tablaSalida","listaSalida");
}
	
function agregarFila(tabla, elementos,lista){
		$("#ncantidad").val("1");
		FILAS=FILAS+1;
        var nuevaFila="<tr ondblclick='abrirModal(\""+elementos[1]+"\",\""+FILAS+"\");'>";
		var con=0;
		while (con < elementos.length){
			var pesounitario=elementos[9];
			var pesoreal=elementos[10];
			var habilitar="";
			if (pesounitario==0 && pesoreal==0){
				habilitar='disabled="disabled"';
			}
			if (con==0){
				nuevaFila=nuevaFila+"<td style='display:none'>";
				nuevaFila=nuevaFila+FILAS;
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==1){ //idproducto
				nuevaFila=nuevaFila+"<td style='display:none'>";
				nuevaFila=nuevaFila+elementos[con];
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==2){ //codigo
				nuevaFila=nuevaFila+"<td style='display:none'>";
				nuevaFila=nuevaFila+elementos[con];
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==3){ //nombreproducto
				nuevaFila=nuevaFila+"<td class=\"columnaIzquierda\" style=\"border-left: 10px solid #909;\">";
					nuevaFila=nuevaFila+elementos[con]; 
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==4){ //unidad
				nuevaFila=nuevaFila+"<td>";
					nuevaFila=nuevaFila+elementos[con]; 
				nuevaFila=nuevaFila+"</td>";
			}
				
			if (con==5){ //cantidad
				nuevaFila=nuevaFila+"<td class='cantidad'>";
				nuevaFila=nuevaFila+"<input value='"+elementos[con]+"' name='cant"+FILAS+"' type='text' class='caja' id='cant"+FILAS+"' onblur=\"calcular('cant','"+FILAS+"')\" onkeyup=\"permitirDecimal('cant"+FILAS+"');\" onfocus=\"activarValidacion('cant"+FILAS+"');\" />";
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==6){ //costo
				nuevaFila=nuevaFila+"<td>";
				nuevaFila=nuevaFila+"<input value='"+elementos[con]+"' name='cost"+FILAS+"' type='text' class='caja' id='cost"+FILAS+"' onblur=\"calcular('cost','"+FILAS+"')\" onkeyup=\"permitirDecimal('cost"+FILAS+"');\" onfocus=\"activarValidacion('cost"+FILAS+"');\" />";
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==7){ //costo kilos
				nuevaFila=nuevaFila+"<td>";
				nuevaFila=nuevaFila+"<input value='"+elementos[con]+"' name='cost2"+FILAS+"' type='text' class='caja' id='cost2"+FILAS+"' onblur=\"calcular('cost2','"+FILAS+"')\" onkeyup=\"permitirDecimal2('cost2"+FILAS+"');\" onfocus=\"activarValidacion('cost2"+FILAS+"');\" "+habilitar+"/>";
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==8){//Monto
				nuevaFila=nuevaFila+"<td id='monto"+FILAS+"'>";
					nuevaFila=nuevaFila+elementos[con]; 
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==9){//Peso teorico unitario
				nuevaFila=nuevaFila+"<td id='pesoteoricounitario"+FILAS+"'>";
					nuevaFila=nuevaFila+elementos[con]; 
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==10){//Peso real
				nuevaFila=nuevaFila+"<td id='pesoreal"+FILAS+"'>";
					nuevaFila=nuevaFila+elementos[con]; 
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==11){//Peso teorico
				nuevaFila=nuevaFila+"<td>";
				nuevaFila=nuevaFila+"<input value='"+elementos[con]+"' name='pesoteorico"+FILAS+"' type='text' class='caja' id='pesoteorico"+FILAS+"' onblur=\"calcular('pesoteorico','"+FILAS+"')\" onkeyup=\"permitirDecimal('pesoteorico"+FILAS+"');\" onfocus=\"activarValidacion('pesoteorico"+FILAS+"');\" "+habilitar+"/>";
				
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==12){ //existencias
				nuevaFila=nuevaFila+"<td>";
				nuevaFila=nuevaFila+elementos[con]; 
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==13){ //stockminimo
				nuevaFila=nuevaFila+"<td>";
				nuevaFila=nuevaFila+elementos[con]; 
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==14){ //stockmaximo
				nuevaFila=nuevaFila+"<td>";
				nuevaFila=nuevaFila+elementos[con]; 
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==15){ //idsucursal
				nuevaFila=nuevaFila+"<td class='idsucursal' id='idsucursal"+FILAS+"' style='display:none'>";
					nuevaFila=nuevaFila+elementos[con]; 
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==16){ //nombresucursal
				nuevaFila=nuevaFila+"<td class='nombresucursal' id='nombresucursal"+FILAS+"'>";
					nuevaFila=nuevaFila+elementos[con]; 
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==17){ //idproveedor
				nuevaFila=nuevaFila+"<td class='idproveedor' style='display:none' id='idproveedor"+FILAS+"'>";
					nuevaFila=nuevaFila+elementos[con]; 
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==18){ //nombreproveedor
				nuevaFila=nuevaFila+"<td class='nombreproveedor' id='nombreproveedor"+FILAS+"'>";
					nuevaFila=nuevaFila+elementos[con]; 
				nuevaFila=nuevaFila+"</td>";
			}
			con=con+1;
		}
		nuevaFila=nuevaFila+"<td title='Eliminar Fila' class='eliminarFila'><a class='btn btn-default btn-xs'><i class='fa fa-trash-o text-green'></i><a></td>";
		nuevaFila=nuevaFila+"<td title='Elegir proveedor' width='30'><a class='btn btn-default btn-xs' onclick='abrirModal(\""+elementos[1]+"\",\""+FILAS+"\");'><i class='fa fa-industry text-blue'></i></a></td>";
		nuevaFila=nuevaFila+"</tr>"
		//$("#"+tabla).append(nuevaFila); Coloca la fila al final de la tabla
		$("#"+tabla).prepend(nuevaFila); //Coloca la fila al inicio de la tabla
		recorrerTabla(tabla,lista);
		
}


function contarFilas(id, idsucursalV, total){
	var no, idproducto, cantidad, idsucursal;
	tabla="tablaSalida";
	var encontrado=false, resultado=false;
	$('#'+tabla+' tbody tr').each(function () {
		$(this).find('td').each(function (index,valor) {
			
			if (index==0){
				no=$(valor).html();
			}
			if (index==1){
				idsucursal= $(this).parent("tr").children(".idsucursal").html();
				idproducto=$(valor).html();
				if (idproducto==id && idsucursal==idsucursalV){
					encontrado=true;
					resultado=true;
				}
			}
			if (index==5 && encontrado==true){
				cantidad=parseFloat ($("#cant"+no).val());
				total=parseFloat (total)+cantidad;
				$("#cant"+no).val(total);
				total=0;
			}
			
			encontrado==false;
		})
	})
	return resultado;
}



function comprobarProveedor(tabla,lista){
	var idproveedorseleccionado=$("#idproveedor_ajax").val();
	var no, idproducto,idproveedor;
	$('#'+tabla+' tbody tr').each(function() {
		$(this).find('td').each(function (index,valor) {
			if (index==0){
				no=$(valor).html();
			}
			if (index==1){
				idproducto=$(valor).html();
				idproveedor=colocarProveedor(idproducto,idproveedorseleccionado, no);
				
				if (idproveedor==0){
					$(valor).css("background-color", "#ECF8E0");
				}
			}
			
			//$(valor).css("background-color", "#ECF8E0");
		})
	})
	
}



function recorrerTabla(tabla,lista){
	
	var no, idproducto, cantidad, costo, monto, pesoteorico, minimo, ubicacion, total=0, totalCosto=0, idproveedor, idsucursal;
	var cadena;
	cadena="";
	$('#'+tabla+' tbody tr').each(function () {
		$(this).find('td').each(function (index,valor) {
			if (index==0){
				no=$(valor).html();
			}
			if (index==1){
				idproducto=$(valor).html();
			}
			if (index==5){
				cantidad=$("#cant"+no).val();
				if ($("#cant"+no).val()==0){
					$("#cant"+no).css('color', 'red');
				}else{
					$("#cant"+no).css('color', 'blue');
				}
				total=parseFloat(cantidad)+total;	
			}
			if (index==6){
				costo=$("#cost"+no).val();
				if ($("#cost"+no).val()==0){
					$("#cost"+no).css('color', 'red');
				}else{
					$("#cost"+no).css('color', 'blue');
				}
				totalCosto=parseFloat(costo*cantidad)+totalCosto;
			}
			
			
			if (index==15){
				idsucursal=$(valor).html();
			}
			
			if (index==17){
				idproveedor=$(valor).html();
			}
			
			//$(valor).css("background-color", "#ECF8E0");
		})
		
		cadena=cadena+idproducto+":::"+cantidad+":::"+costo+":::"+idsucursal+":::"+idproveedor+":::";
	})
	$("#"+lista).val(cadena);
	$("#totalLista").html(total);
	totalCosto2=totalCosto.toFixed(2);
	$("#totalLista2").html("$"+totalCosto2);
}

function recorrerTablaRequisiciones(tabla,lista){
	
	var idrequisicion;
	var cadena;
	cadena="";
	$('#'+tabla+' tbody tr').each(function () {
		$(this).find('td').each(function (index,valor) {

			if (index==1){
				idrequisicion=$(valor).html();
			}
			//$(valor).css("background-color", "#ECF8E0");
		})
		cadena=cadena+idrequisicion+",";
	})
	cadena = cadena.substring(0,cadena.length-1);
	$("#"+lista).val(cadena);
}

function compararFilas(id, idsucursalV, total){
	var no, idproducto, cantidad, idsucursal;
	tabla="tablaSalida";
	var encontrado=false, resultado=false;
	$('#'+tabla+' tbody tr').each(function () {
		$(this).find('td').each(function (index,valor) {
			
			if (index==1){
				idsucursal= $(this).parent("tr").children(".idsucursal").html();
				if (idproducto==id && idsucursal==idsucursalV){
					encontrado=true;
					resultado=true;
				}
			}
			if (index==5 && encontrado==true){
				cantidad=parseFloat ($(this).parent("tr").children(".cantidad").find("input").val());
				total=parseFloat (total)+cantidad;
				
				$(this).parent("tr").children(".cantidad").find("input").val(total);
				total=0;
			}
			
			encontrado=false;
		})
	})
	return resultado;
}

function contarFilasP(){
	var idproductoV, idproductoV, codigoproductoV, nombreproductoV, unidadV, cantidadV, costoV, idsucursalV, nombresucursalV, idproveedorV, nombreproveedorV, pesoteoricounitarioV, pesoteoricoV, montoV, existenciasV, stockminimoV, stockmaximoV;
	tabla="tablaSalidaP";
	variables=new Array();
	var total=0;
						
	var encontrado=false, resultado=false;
	$('#'+tabla+' tbody tr').each(function () {
		$(this).find('td').each(function (index,valor) {
			
			if (index==1){
				idproductoV=$(valor).html();
				codigoproductoV=$(this).parent("tr").children(".codigoproducto").html();
				nombreproductoV=$(this).parent("tr").children(".nombreproducto").html();
				unidadV= $(this).parent("tr").children(".nombreunidad").html();
				cantidadV= $(this).parent("tr").children(".cantidad").find("input").val();
				costoV= $(this).parent("tr").children(".costo").find("input").val();
				costo2V= $(this).parent("tr").children(".costo2").find("input").val();
				idsucursalV= $(this).parent("tr").children(".idsucursal").html();
				nombresucursalV=$(this).parent("tr").children(".nombresucursal").html();
				idproveedorV=$(this).parent("tr").children(".idproveedor").html();
				nombreproveedorV=$(this).parent("tr").children(".nombreproveedor").html();
				pesoteoricounitarioV=$(this).parent("tr").children(".pesoteoricounitario").html();
				pesorealV=$(this).parent("tr").children(".pesoreal").html();
				pesoteoricoV=$(this).parent("tr").children(".pesoteorico").html();
				existenciasV=$(this).parent("tr").children(".existencias").html();
				stockminimoV=$(this).parent("tr").children(".stockminimo").html();
				stockmaximoV=$(this).parent("tr").children(".stockmaximo").html();
				montoV=$(this).parent("tr").children(".monto").html();
				variables[0]=0; //Nueva fila
				variables[1]=idproductoV;
				variables[2]=codigoproductoV;
				variables[3]=nombreproductoV;
				variables[4]=unidadV;
				variables[5]=cantidadV;
				variables[6]=costoV;
				variables[7]=costo2V;
				variables[8]=montoV;
				variables[9]=pesoteoricounitarioV;
				variables[10]=pesorealV;
				variables[11]=pesoteoricoV;
				variables[12]=existenciasV;
				variables[13]=stockminimoV;
				variables[14]=stockmaximoV;
				variables[15]=idsucursalV;
				variables[16]=nombresucursalV;
				variables[17]=idproveedorV;
				variables[18]=nombreproveedorV;
				
				if (compararFilas(idproductoV,idsucursalV,cantidadV)){ //Si existe
					encontrado=true;
					resultado=true;
				}else{
					agregarFila("tablaSalida", variables, "listaSalida");
				}
			}
			if (index==5 && encontrado==true){
				cantidad=parseFloat ($(this).parent("tr").children(".cantidad").find("input").val());
				total=parseFloat (total)+cantidad;
				$(this).parent("tr").children(".cantidad").find("input").val(total);
				total=0;
			}
			$(this).remove();
			encontrado==false;
		})
	})
	return resultado;
}
//FIN DE FUNCIONES DE LLANDO DE TABLA DE INFERIOR



function removerFilas(tabla,lista,idsucursal){
	var no, idproducto, cantidad, costo, minimo, ubicacion, total=0, totalCosto=0, idsucursalV;
	var cadena;
	cadena="";
	$('#tablaSalida tbody tr').each(function () {
		$(this).find('td').each(function (index,valor) {
			if (index==12){
				idsucursalV=$(valor).html();
				if(idsucursalV==idsucursal){
					$(this).parent("tr").remove();
				}
			}
			
		})
	})
	$('#tablaRequisiciones tbody tr').each(function () {
		$(this).find('td').each(function (index,valor) {
			if (index==4){
				idsucursalV=$(valor).html();
				if(idsucursalV==idsucursal){
					var idrequisicion=$(this).parent("tr").children(".idrequisicion").html();
					var fecha=$(this).parent("tr").children(".fecha").html();
					var sucursal=$(this).parent("tr").children(".sucursal").html();
					var descripcion=sucursal+" ("+fecha+")";
					var o = new Option(descripcion, idrequisicion);
					$("#idrequisicion_ajax").prepend(o);
					$(this).parent("tr").remove();
				}
			}
			
		})
	})
	recorrerTabla(tabla,lista);
	recorrerTablaRequisiciones("tablaRequisiciones","listaRequisiciones");
}
//FIN DE FUNCIONES DE LLANDO DE TABLA DE INFERIOR


function vaciarCampos(){
	$("#cnumerocomprobante").val("");
	$("#ccomentarios").val("");
	$("#cconcepto").focus();
	$("#filas").html("");
	$("#listaSalida").val("");
	$("#totalLista").html("0");
	obtenerSerie();
	obtenerFolio();
	FILAS=0;
}
$(document).ready(function() {
	
	$("#panel_alertas").hide();
	obtenerSerie();
	obtenerFolio();
	llenarSelectAlmacen("");
	llenarSelectProveedores("");
	llenarSelectRequisiciones("");
	$(".loading").hide();
	//$("#panel_alertas").delay(8000).hide(600);
	
	$("#cconcepto").change(function() {
		//Inicializamos valores
		$(".EB").show();
		$(".COMPRA").hide();
		$("#botonProcesar").hide();
		$("ajax_resultado").html("");
		
		if ($(this).val()=="TRASPASO"){
			$(".EB").hide();
			$("#botonProcesar").show();
		}
		if ($(this).val()=="CONSIGNACION A CLIENTE"){
			$(".EB").hide();
			$("#botonProcesar").show();
		}
		if ($(this).val()=="CONSIGNACION A VENDEDOR"){
			$(".EB").hide();
			$("#botonProcesar").show();
		}
		if ($(this).val()=="ORDEN DE COMPRA"){
			$(".EB").show();
			$(".COMPRA").show();
		}
		
	});
	
	$("#botonProcesar").click(function() {
			var variables=$("#formulario").serialize();
			procesarA(variables);
	});
	
	$("#botonGuardar2").click(function() {
				if (validar()){
					var variables=$("#formulario").serialize();
					guardar(variables,"descartar");
				}
	});
	
	$("#botonGuardar").click(function() {
				if (validar()){
					var variables=$("#formulario").serialize();
					guardar(variables,"normal");
				}
	});
	$(".botonSave").click(function() {
				if (validar()){
					var variables=$("#formulario").serialize();
					guardar(variables,"normal");
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
	
	$("#idsucursal_ajax2").change(function(event){  
           llenarSelectRequisiciones("");
 	}); 
	
	$("#idproveedor_ajax2").change(function(event){  
           llenarSelectRequisiciones("");
 	}); 
	
	$("#ncantidad").keypress(function(event){  
       var keycode = (event.keyCode ? event.keyCode : event.which); 
      	if(keycode == '13'){  
        	llenarProducto();
      	}     
 	}); 
	
	$(".botonNormal").click(function(){ 
		$("#panel_alertas").stop(false, true);
 	});
	
	$(".close").click(function(){ 
		$("#panel_alertas").stop(false, true);
		$("#panel_alertas").hide();
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
	location.href='../consultar/vista.php?link=vista&busqueda='+busqueda+'&n1=movimientos&n2=consultarmovimientos';
}

function llenarSelectAlmacen(condicion){
		$("#idsucursal_ajax").html("<option value='1'>cargando...</option>");
		$.ajax({
			url: '../componentes/llenarSelectSucursal.php',
			type: "POST",
			data: "submit=&condicion="+condicion, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#idsucursal_ajax").html(mensaje);
				$("#idsucursal_ajax2").html(mensaje);
			}
		});
		return false;
}

function llenarSelectProveedores(condicion){
		$("#idproveedor_ajax").html("<option value='1'>cargando...</option>");
		$.ajax({
			url: '../componentes/llenarSelectProveedor.php',
			type: "POST",
			data: "submit=&condicion="+condicion, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#idproveedor_ajax").html(mensaje);
				$("#idproveedor_ajax2").html(mensaje);
				llenarSelectRequisiciones("");
			}
		});
		return false;
}

function llenarSelectRequisiciones(condicion){
		$("#idrequisicion_ajax").html("<option value='1'>cargando...</option>");
		var idproveedor=$("#idproveedor_ajax2").val();
		var idsucursal=$("#idsucursal_ajax2").val();
		var listaRequisiciones=$("#listaRequisiciones").val();
		
		$.ajax({
			url: '../componentes/llenarSelectRequisicion.php',
			type: "POST",
			data: "submit=&condicion="+condicion+"&idproveedor="+idproveedor+"&idsucursal="+idsucursal+"&listaRequisiciones="+listaRequisiciones, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#idrequisicion_ajax").html(mensaje);
			}
		});
		return false;
}


function colocarProveedor(idproducto,idproveedor, control){
		$("#botonGuardar").hide();
		$("#botonSave").hide();
		$("#loading").show();
		$.ajax({
			url: '../componentes/colocarProveedor.php',
			type: "POST",
			data: "submit=&idproducto="+idproducto+"&idproveedor="+idproveedor, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				mensaje=$.trim(mensaje);
				var cadena= $.trim(mensaje); //Limpia la cadena regresada desde php
				var res=cadena.split("@"); //Separa la cadena en cada @ y convierte las partes en un array
				$("#botonGuardar").show();
				$("#botonSave").show();
				$("#loading").hide();
				
				$("#idproveedor"+control).html(res[0]);
				$("#nombreproveedor"+control).html(res[1]);
				if (res[0]==0){
					$("#nombreproveedor"+control).css("color","#F00");
				}else{
					$("#nombreproveedor"+control).css("color","#000");
				}
			}
		});
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

function guardar(variables, modo){
		$("#botonGuardar").hide();
		$("#botonSave").hide();
		$("#loading").show();
		$.ajax({
			url: 'guardar.php',
			type: "POST",
			data: "submit=&"+variables+"&modo="+modo, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#botonGuardar").show();
				$("#botonSave").show();
				$("#loading").hide();
				mostrarMensaje(mensaje);
			}
		});
		return false;
}

function procesarA(variables){
		
		var idrequisicion=$("#idrequisicion_ajax").val();
		var parametrocotizacion=$("#cparametrocotizacion").val();
		var idproveedor=$('#idrequisicion_ajax option:selected').attr('prov');
		if (idrequisicion!=null){
			
			$("#botonGuardar").hide();
			$("#botonProcesar").hide();
			$("#botonSave").hide();
			$("#loading").show();
			$(".tablita").hide();
		
			$.ajax({
				url: 'procesarA.php',
				type: "POST",
				data: "submit=&"+variables, //Pasamos los datos en forma de array seralizado desde la funcion de envio
				success: function(mensaje){
					$("#botonGuardar").show();
					$("#botonProcesar").show();
					$("#botonSave").show();
					$("#loading").hide();
					$("#filasRequisiciones").prepend(mensaje);
					recorrerTablaRequisiciones("tablaRequisiciones","listaRequisiciones");
					procesarB(idrequisicion,parametrocotizacion);
					$("#idproveedor_ajax").val(idproveedor);
					$(".PROVEEDOR").show();
					$("#idrequisicion_ajax option[value='"+idrequisicion+"']").remove();
					if (mensaje.substring(0,8)!="<!--x-->"){
						$(".tablita").show();
					}
				}
			});
		}
		return false;
}

function procesarB(idrequisicion,parametrocotizacion){
		$("#botonGuardar").hide();
		$("#botonProcesar").hide();
		$("#botonSave").hide();
		$("#loading").show();
		$(".tablita").hide();
		
		
		$.ajax({
			url: 'procesarB.php',
			type: "POST",
			data: "submit=&idrequisicion="+idrequisicion+"&parametrocotizacion="+parametrocotizacion, //Pasamos los datos en forma de array seralizado desde la funcion de envio
			success: function(mensaje){
				$("#botonGuardar").show();
				$("#botonProcesar").show();
				$("#botonSave").show();
				$("#loading").hide();
				$("#filasP").html(mensaje);
				contarFilasP();
				$("#idrequisicion_ajax option[value='"+idrequisicion+"']").remove();
				if (mensaje.substring(0,8)!="<!--x-->"){
					$(".tablita").show();
				}
			}
		});
		return false;
}

function mostrarMensaje(mensaje){
	//alert(mensaje);
	$("#mensaje").html(mensaje);
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
