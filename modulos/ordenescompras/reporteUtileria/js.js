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
	
function checarCeros(id,idtotal) {
	var campo=$("#"+id).val();
	campo=$.trim(campo);
	if (campo=="" || campo==0 || campo=="."){
		$("#"+id).val("0.00");
	}
	var cant=0;
	var cost=0;
	var peso=0;
	var total=0;
	var totalpeso=0;
	cant=parseFloat ($("#cant"+idtotal).val());
	cost= parseFloat ($("#cost"+idtotal).val());
	peso= parseFloat ($("#pesoteoricounitario"+idtotal).html());
	var total=cant*cost;
	var totalpeso=cant*peso;
	
	if (peso!=0){
		totalpeso=cant/peso;
	}else{
		totalpeso=cant;
	}
	$("#monto"+idtotal).text("$"+new Intl.NumberFormat("en-IN").format(total.toFixed(2)));
	$("#unidades"+idtotal).val(totalpeso.toFixed(2));
	recorrerTabla("tablaSalida","listaSalida");
}

function calcularKilos(id,idtotal) {
	var campo=$("#"+id).val();
	campo=$.trim(campo);
	if (campo=="" || campo==0 || campo=="."){
		$("#"+id).val("0.00");
	}
	var cant=0;
	var cost=0;
	var peso=0;
	var total=0;
	var totalpeso=0;
	campo=parseFloat (campo)
	cant=parseFloat ($("#cant"+idtotal).val());
	cost= parseFloat ($("#cost"+idtotal).val());
	peso= parseFloat ($("#pesoteoricounitario"+idtotal).html());

	cant=campo*peso;
	var total=cant*cost;
	var totalpeso=cant*peso;
	
	if (peso!=0){
		totalpeso=cant/peso;
		var total=cant*cost;
		$("#monto"+idtotal).text("$"+new Intl.NumberFormat("en-IN").format(total.toFixed(2)));
		$("#cant"+idtotal).val(cant.toFixed(2));
	}else{
		var total=campo*cost;
		$("#monto"+idtotal).text("$"+new Intl.NumberFormat("en-IN").format(total.toFixed(2)));
		$("#cant"+idtotal).val(campo.toFixed(2));
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
				nuevaFila=nuevaFila+"<input value='"+elementos[con]+"' name='cant"+FILAS+"' type='text' class='caja' id='cant"+FILAS+"' onblur=\"checarCeros('cant"+FILAS+"','"+FILAS+"')\" onkeyup=\"permitirDecimal('cant"+FILAS+"');\" onfocus=\"activarValidacion('cant"+FILAS+"');\" />";
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==6){ //costo
				nuevaFila=nuevaFila+"<td>";
				nuevaFila=nuevaFila+"<input value='"+elementos[con]+"' name='cost"+FILAS+"' type='text' class='caja' id='cost"+FILAS+"' onblur=\"checarCeros('cost"+FILAS+"','"+FILAS+"')\" onkeyup=\"permitirDecimal('cost"+FILAS+"');\" onfocus=\"activarValidacion('cost"+FILAS+"');\" />";
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==7){//Monto
				nuevaFila=nuevaFila+"<td id='monto"+FILAS+"'>";
					nuevaFila=nuevaFila+elementos[con]; 
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==8){//Peso teorico unitario
				nuevaFila=nuevaFila+"<td id='pesoteoricounitario"+FILAS+"'>";
					nuevaFila=nuevaFila+elementos[con]; 
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==9){//Peso teorico total
				nuevaFila=nuevaFila+"<td class='unidades'>";
				nuevaFila=nuevaFila+"<input value='"+elementos[con]+"' name='unidades"+FILAS+"' type='text' class='caja' id='unidades"+FILAS+"' onblur=\"calcularKilos('unidades"+FILAS+"','"+FILAS+"')\" onkeyup=\"permitirDecimal('unidades"+FILAS+"');\" onfocus=\"activarValidacion('unidades"+FILAS+"');\" />";
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==10){ //minimo
				nuevaFila=nuevaFila+"<td style='display:none'>";
				nuevaFila=nuevaFila+"<input value='"+elementos[con]+"' name='minimo"+FILAS+"' type='text' class='caja' id='minimo"+FILAS+"' onblur=\"checarCeros('minimo"+FILAS+"','"+FILAS+"')\" onkeyup=\"permitirDecimal('minimo"+FILAS+"');\" onfocus=\"activarValidacion('minimo"+FILAS+"');\" />";
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==11){ //ubicacion
				nuevaFila=nuevaFila+"<td style='display:none'>";
				nuevaFila=nuevaFila+"<input value='"+elementos[con]+"' name='ubicacion"+FILAS+"' type='text' class='caja' id='ubicacion"+FILAS+"' onblur=\"checarCeros('ubicacion"+FILAS+"','"+FILAS+"')\" />";
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==12){ //idsucursal
				nuevaFila=nuevaFila+"<td class='idsucursal' id='idsucursal"+FILAS+"' style='display:none'>";
					nuevaFila=nuevaFila+elementos[con]; 
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==13){ //nombresucursal
				nuevaFila=nuevaFila+"<td class='nombresucursal' id='nombresucursal"+FILAS+"'>";
					nuevaFila=nuevaFila+elementos[con]; 
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==14){ //idproveedor
				nuevaFila=nuevaFila+"<td class='idproveedor' style='display:none' id='idproveedor"+FILAS+"'>";
					nuevaFila=nuevaFila+elementos[con]; 
				nuevaFila=nuevaFila+"</td>";
			}
			if (con==15){ //nombreproveedor
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
			
			if (index==7){
				monto=$("#monto"+no).val();
			}
			if (index==8){
				pesoteoricounitario=$("#pesoteoricounitario"+no).val();
			}
			if (index==9){
				
				pesoteorico=$("#unidades"+no).val();
				if ($("#unidades"+no).val()==0){
					$("#unidades"+no).css('color', 'red');
				}else{
					$("#unidades"+no).css('color', 'blue');
				}	
			}
			if (index==10){
				minimo=$("#minimo"+no).val();
			}
			if (index==11){
				ubicacion=$("#ubicacion"+no).val();
			}
			if (index==12){
				idsucursal=$(valor).html();
			}
			if (index==14){
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
	var pesoTotal=0;
	var idrequisicion;
	var cadena;
	cadena="";
	$('#'+tabla+' tbody tr').each(function () {
		$(this).find('td').each(function (index,valor) {

			if (index==1){
				idrequisicion=$(valor).html();
				//alert(idrequisicion);
			}
			if (index==7){
				pesoTotal=pesoTotal+parseFloat($(valor).html());
			}
			//$(valor).css("background-color", "#ECF8E0");
		})
		cadena=cadena+idrequisicion+",";
	})
	cadena = cadena.substring(0,cadena.length-1);
	$("#"+lista).val(cadena);
	$("#totalKilos").html(pesoTotal+" "+"Ton.");
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
	var idproductoV, idproductoV, codigoproductoV, nombreproductoV, unidadV, cantidadV, costoV, idsucursalV, nombresucursalV, idproveedorV, nombreproveedorV, pesoteoricounitarioV, pesoteoricoV, montoV;
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
				idsucursalV= $(this).parent("tr").children(".idsucursal").html();
				nombresucursalV=$(this).parent("tr").children(".nombresucursal").html();
				idproveedorV=$(this).parent("tr").children(".idproveedor").html();
				nombreproveedorV=$(this).parent("tr").children(".nombreproveedor").html();
				pesoteoricounitarioV=$(this).parent("tr").children(".pesoteoricounitario").html();
				pesoteoricoV= $(this).parent("tr").children(".unidades").find("input").val();
				montoV=$(this).parent("tr").children(".monto").html();
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
	FILAS=0;
}
$(document).ready(function() {
	
	$("#panel_alertas").hide();
	llenarSelectAlmacen("");
	llenarSelectProveedores("");
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
	
	$("#botonGuardar").click(function() {
				if (validar()){
					var variables=$("#formulario").serialize();
					
					guardar(variables);
				}
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
	
	$("#idsucursal_ajax").change(function(event){  
           llenarSelectRequisiciones("");
 	}); 
	
	$("#idproveedor_ajax").change(function(event){  
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
				llenarSelectRequisiciones("");
			}
		});
		return false;
}

function llenarSelectRequisiciones(condicion){
		$("#idrequisicion_ajax").html("<option value='1'>cargando...</option>");
		var idproveedor=$("#idproveedor_ajax").val();
		var idsucursal=$("#idsucursal_ajax").val();
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


function guardarDesactivado(variables){
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

function procesarA(variables){
		
		var idrequisicion=$("#idrequisicion_ajax").val();
		var parametrocotizacion=$("#cparametrocotizacion").val();
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
