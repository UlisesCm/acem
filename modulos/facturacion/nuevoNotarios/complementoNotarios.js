// FUNCIONES DE LLANDO DE TABLA DE EINMUEBLES
$(document).ready(function() {

	$('#PorcentajeEnajenante').hide();
	$('#PorcentajeAdquiriente').hide();
	$('#Lporcentaje').hide();
	$('#LporcentajeAdquiriente').hide();

		
	$("#botonAgregarInmueble").click(function() {
			var TipoInmueble=$("#TipoInmueble").val();
			var calleInmueble=$("#calleInmueble").val();
			var numeroExteriorInmueble=$("#numeroExteriorInmueble").val();
			var numeroInteriorInmueble=$("#numeroInteriorInmueble").val();
			var ColoniaInmueble=$("#ColoniaInmueble").val();
			var LocalidadInmueble=$("#LocalidadInmueble").val();
			var ReferenciaInmueble=$("#ReferenciaInmueble").val();
			var MunicipioInmueble=$("#MunicipioInmueble").val();
			var EstadoInmueble=$("#EstadoInmueble").val();
			var PaisInmueble=$("#PaisInmueble").val();
			var CPInmueble=$("#CPInmueble").val();
			
			if (TipoInmueble=="" || calleInmueble=="" || MunicipioInmueble=="" || EstadoInmueble=="" || PaisInmueble=="" || CPInmueble==""){
				mostrarMensaje("fracaso@Faltan datos importantes@No se puede agregar el inmueble, revise los datos. Los siguientes campos son obligatorios: Tipo, Calle, Municipio, Estado, Pa&iacute;s, C.P.");
			}else{
				var longitud=$("#CPInmueble").val().length;
				if (longitud!=5){
					mostrarMensaje("fracaso@C&oacute;digo Postal Incorrecto@El C&oacute;digo Postal debe contener 5 d&iacute;gitos");
				}else{
					agregarFilaInmuebles(TipoInmueble,calleInmueble,numeroExteriorInmueble,numeroInteriorInmueble,ColoniaInmueble,LocalidadInmueble,ReferenciaInmueble,MunicipioInmueble,EstadoInmueble,PaisInmueble,CPInmueble);
				}
			}
			recorrerTablaInmuebles(); //Crea la lista de productos en formato de cadena para enviar a timbrado
	}); 
	
	function agregarFilaInmuebles(TipoInmueble,calleInmueble,numeroExteriorInmueble,numeroInteriorInmueble,ColoniaInmueble,LocalidadInmueble,ReferenciaInmueble,MunicipioInmueble,EstadoInmueble,PaisInmueble,CPInmueble){
            var nuevaFila="<tr>";
			nuevaFila=nuevaFila+"<td>"+TipoInmueble+"</td><td>"+calleInmueble+"</td><td>"+numeroExteriorInmueble+"</td><td class='oculto'>"+numeroInteriorInmueble+"</td><td class='oculto'>"+ColoniaInmueble+"</td><td class='oculto'>"+LocalidadInmueble+"</td><td class='oculto'>"+ReferenciaInmueble+"</td><td>"+MunicipioInmueble+"</td><td>"+EstadoInmueble+"</td><td>"+PaisInmueble+"</td><td>"+CPInmueble+"</td><td class='eliminarInmueble' title='Eliminar fila'><i class='fa fa-delete'></i></td>";
			nuevaFila=nuevaFila+"</tr>"
            $("#tablaInmueble").append(nuevaFila);
	}
	
	$(document).on("click",".eliminarInmueble",function(){
		var parent = $(this).parents().get(0);
		$(parent).remove();
		recorrerTablaInmuebles(); // Crea la cadena de productos que se enviara a timbrado
	});
	
	
	//FIN DE FUNCIONES DE LLANDO DE TABLA DE INMUEBLES
	
	
	
	// FUNCIONES DE LLENADO DE TABLA DE ENAJENANTES
	
	$("#botonAgregarEnajenante").click(function() {
		$("#CurpEnajenante").val($("#CurpEnajenante").val().toUpperCase());
		$("#RfcEnajenante").val($("#RfcEnajenante").val().toUpperCase());
		
			var NombreEnajenante=$("#NombreEnajenante").val();
			var PaternoEnajenante=$("#PaternoEnajenante").val();
			var MaternoEnajenante=$("#MaternoEnajenante").val();
			var RfcEnajenante=$("#RfcEnajenante").val();
			var CurpEnajenante=$("#CurpEnajenante").val();
			
			var PorcentajeEnajenante=$("#PorcentajeEnajenante").val();
			if (validarCURP(CurpEnajenante)==true){
				if (validarRFCFisica(RfcEnajenante)==true){
					if (NombreEnajenante=="" || PaternoEnajenante=="" || RfcEnajenante=="" || CurpEnajenante==""){
						mostrarMensaje("fracaso@Faltan valores@No se puede agregar el enajenante, revise los datos");
					}else{
						if ($( "#CheckSociedad" ).is(':checked')){
							if (PorcentajeEnajenante==""){
								mostrarMensaje("fracaso@Faltan valores@No se puede agregar el enajenante. Debe especificar el porcentaje");
							}else{
								agregarFilaEnajenante(NombreEnajenante,PaternoEnajenante,MaternoEnajenante,RfcEnajenante,CurpEnajenante,PorcentajeEnajenante);
							}
						}else{
							if (contarFilas("tablaEnajenante")>1){
								mostrarMensaje("fracaso@Error l&oacute;gico@Para agregar dos o m&aacute;s enajenantes debe marcar la casilla de Copropiedad o Sociedad Conyugal, y especif&iacute;car el porcentaje de cada enajenante");
							}else{
								agregarFilaEnajenante(NombreEnajenante,PaternoEnajenante,MaternoEnajenante,RfcEnajenante,CurpEnajenante,100);
							}
						}
						recorrerTablaEnajenantes(); //Crea la lista de productos en formato de cadena para enviar a timbrado
						
					}
				}else{//Fin de validar RFC
					mostrarMensaje("fracaso@RFC incorrecto@Revice el RFC del enajenante. El Enjanenante debe ser una Persona F&iacute;sica");
				}
			}else{//Fin de validar CURP
					mostrarMensaje("fracaso@CURP incorrecta@Revice la CURP del enajenante");
			}
	}); 
	
	function agregarFilaEnajenante(NombreEnajenante,PaternoEnajenante,MaternoEnajenante,RfcEnajenante,CurpEnajenante,PorcentajeEnajenante){
            var nuevaFila="<tr>";
			nuevaFila=nuevaFila+"<td>"+NombreEnajenante+"</td><td>"+PaternoEnajenante+"</td><td>"+MaternoEnajenante+"</td><td>"+RfcEnajenante+"</td><td>"+CurpEnajenante+"</td><td>"+PorcentajeEnajenante+"</td><td class='eliminarEnajenante' title='Eliminar fila'></td>";
			nuevaFila=nuevaFila+"</tr>"
            $("#tablaEnajenante").append(nuevaFila);
	}
	
	$(document).on("click",".eliminarEnajenante",function(){
		var parent = $(this).parents().get(0);
		$(parent).remove();
		recorrerTablaEnajenantes(); // Crea la cadena de productos que se enviara a timbrado
	});
	
	$( "#CheckSociedad" ).click(function() {
        	if ($( "#CheckSociedad" ).is(':checked')){
				$('#PorcentajeEnajenante').show();
				$('#Lporcentaje').show();
			}else{
				var filas=0;
				filas=contarFilasNetas("tablaEnajenante");
				if (filas>1){
					$("#CheckSociedad").prop("checked", "checked");
					mostrarMensaje("aviso@Operaci&oacute;n no permitida@Para desmarcar la opci&oacute;n de sociedad conyugal debe de haber solo un enajenante en la lista");
				}else{
					$('#PorcentajeEnajenante').hide();
					$('#Lporcentaje').hide();
				}
			}
	});
	//FIN DE FUNCIONES DE LLANDO DE TABLA DE ENAJENANTES
	
	
	
	
	// FUNCIONES DE LLENADO DE TABLA DE ADQUIRIENTES
	
	$("#botonAgregarAdquiriente").click(function() {
		$("#CurpAdquiriente").val($("#CurpAdquiriente").val().toUpperCase());
		$("#RfcAdquiriente").val($("#RfcAdquiriente").val().toUpperCase());
		
			var NombreAdquiriente=$("#NombreAdquiriente").val();
			var PaternoAdquiriente=$("#PaternoAdquiriente").val();
			var MaternoAdquiriente=$("#MaternoAdquiriente").val();
			var RfcAdquiriente=$("#RfcAdquiriente").val();
			var CurpAdquiriente=$("#CurpAdquiriente").val();
			
			var PorcentajeAdquiriente=$("#PorcentajeAdquiriente").val();
			
			
			
			if (validarRFC(RfcAdquiriente)==true){
				if (RfcAdquiriente.length==12){//Si es persona moral
					PaternoAdquiriente="";
					MaternoAdquiriente="";
					CurpAdquiriente="";
					if (NombreAdquiriente==""){
						mostrarMensaje("fracaso@Faltan valores@No se puede agregar el adquiriente, ingrese el nombre de la persona moral (Razón Social)");
					}else{
						if ($( "#CheckSociedadAdquiriente" ).is(':checked')){
							if (PorcentajeAdquiriente==""){
								mostrarMensaje("fracaso@Faltan valores@No se puede agregar el adquiriente. Debe especificar el porcentaje");
							}else{
								agregarFilaAdquiriente(NombreAdquiriente,PaternoAdquiriente,MaternoAdquiriente,RfcAdquiriente,CurpAdquiriente,PorcentajeAdquiriente);
							}
						}else{
							if (contarFilas("tablaAdquiriente")>1){
								mostrarMensaje("fracaso@Error l&oacute;gico@Para agregar dos o m&aacute;s adquirientes debe marcar la casilla de Copropiedad o Sociedad Conyugal, y especif&iacute;car el porcentaje de cada adquiriente");
							}else{
								agregarFilaAdquiriente(NombreAdquiriente,PaternoAdquiriente,MaternoAdquiriente,RfcAdquiriente,CurpAdquiriente,100);
							}
						}
						recorrerTablaAdquirientes(); //Crea la lista de productos en formato de cadena para enviar a timbrado
					}
					
				}else{ //Si es persona fisica
				
					if (validarCURP(CurpAdquiriente)==true){
						if (NombreAdquiriente=="" || PaternoAdquiriente=="" || RfcAdquiriente=="" || CurpAdquiriente==""){
							mostrarMensaje("fracaso@Faltan valores@No se puede agregar el adquiriente, revise los datos");
						}else{
							if ($( "#CheckSociedadAdquiriente" ).is(':checked')){
								if (PorcentajeAdquiriente==""){
									mostrarMensaje("fracaso@Faltan valores@No se puede agregar el adquiriente. Debe especificar el porcentaje");
								}else{
									agregarFilaAdquiriente(NombreAdquiriente,PaternoAdquiriente,MaternoAdquiriente,RfcAdquiriente,CurpAdquiriente,PorcentajeAdquiriente);
								}
							}else{
								if (contarFilas("tablaAdquiriente")>1){
									mostrarMensaje("fracaso@Error l&oacute;gico@Para agregar dos o m&aacute;s adquirientes debe marcar la casilla de Copropiedad o Sociedad Conyugal, y especif&iacute;car el porcentaje de cada adquiriente");
								}else{
									agregarFilaAdquiriente(NombreAdquiriente,PaternoAdquiriente,MaternoAdquiriente,RfcAdquiriente,CurpAdquiriente,100);
								}
							}
							recorrerTablaAdquirientes(); //Crea la lista de productos en formato de cadena para enviar a timbrado
							
						}
					}else{//Fin de validar CURP
						mostrarMensaje("fracaso@CURP incorrecta@Revice la CURP del adquiriente");
					}
					
				}
			}else{//Fin de validar RFC
				mostrarMensaje("fracaso@RFC incorrecto@Revice el RFC del adquiriente");
			}
			
			
	}); 
	
	function agregarFilaAdquiriente(NombreAdquiriente,PaternoAdquiriente,MaternoAdquiriente,RfcAdquiriente,CurpAdquiriente,PorcentajeAdquiriente){
            var nuevaFila="<tr>";
			nuevaFila=nuevaFila+"<td>"+NombreAdquiriente+"</td><td>"+PaternoAdquiriente+"</td><td>"+MaternoAdquiriente+"</td><td>"+RfcAdquiriente+"</td><td>"+CurpAdquiriente+"</td><td>"+PorcentajeAdquiriente+"</td><td class='eliminarAdquiriente' title='Eliminar fila'></td>";
			nuevaFila=nuevaFila+"</tr>"
            $("#tablaAdquiriente").append(nuevaFila);
	}
	
	$(document).on("click",".eliminarAdquiriente",function(){
		var parent = $(this).parents().get(0);
		$(parent).remove();
		recorrerTablaAdquirientes(); // Crea la cadena de productos que se enviara a timbrado
	});
	
	$( "#CheckSociedadAdquiriente" ).click(function() {
        	if ($( "#CheckSociedadAdquiriente" ).is(':checked')){
				$('#PorcentajeAdquiriente').show();
				$('#LporcentajeAdquiriente').show();
			}else{
				var filas=0;
				filas=contarFilasNetas("tablaAdquiriente");
				if (filas>1){
					$("#CheckSociedadAdquiriente").prop("checked", "checked");
					mostrarMensaje("aviso@Operaci&oacute;n no permitida@Para desmarcar la opci&oacute;n de sociedad conyugal debe de haber solo un adquiriente en la lista");
				}else{
					$('#PorcentajeAdquiriente').hide();
					$('#LporcentajeAdquiriente').hide();
				}
			}
	});
	//FIN DE FUNCIONES DE LLANDO DE TABLA DE ADQUIRIENTES
});







function recorrerTablaInmuebles(){
	var TipoInmueble, calleInmueble, numeroExteriorInmueble, numeroInteriorInmueble, ColoniaInmueble, LocalidadInmueble, ReferenciaInmueble, MunicipioInmueble, EstadoInmueble, PaisInmueble, CPInmueble;
	var cadena;
	cadena="";
	$('#tablaInmueble tbody tr').each(function () {
            $(this).find('td').each(function (index2) {
                switch (index2) {
                      case 0:
                          TipoInmueble = $(this).html();
                          break;
                      case 1:
                          calleInmueble = $(this).html();
                          break;
                      case 2:
                          numeroExteriorInmueble = $(this).html();
                          break;
					  case 3:
                          numeroInteriorInmueble = $(this).html();
                          break;
					  case 4:
                          ColoniaInmueble = $(this).html();
                          break;
					  case 5:
                          LocalidadInmueble = $(this).html();
                          break;
					  case 6:
                          ReferenciaInmueble = $(this).html();
                          break;
					  case 7:
                          MunicipioInmueble = $(this).html();
                          break;
					  case 8:
                          EstadoInmueble = $(this).html();
                          break;
						  
					  case 9:
                          PaisInmueble = $(this).html();
                          break;
						  
					  case 10:
                          CPInmueble = $(this).html();
                          break;
                  }
				  $(this).css("background-color", "#ECF8E0");
            })
			
			cadena=cadena+TipoInmueble+':::'+calleInmueble+':::'+numeroExteriorInmueble+':::'+numeroInteriorInmueble+':::'+ColoniaInmueble+":::"+LocalidadInmueble+":::"+ReferenciaInmueble+':::'+MunicipioInmueble+':::'+EstadoInmueble+':::'+PaisInmueble+":::"+CPInmueble+":::";
			
        })
		$("#listaInmuebles").val(cadena);
}

function recorrerTablaEnajenantes(){
	var NombreEnajenante,  PaternoEnajenante, MaternoEnajenante, RfcEnajenante, CurpEnajenante, PorcentajeEnajenante;
	var cadena;
	cadena="";
	$('#tablaEnajenante tbody tr').each(function () {
            $(this).find('td').each(function (index2) {
                switch (index2) {
                      case 0:
                          NombreEnajenante = $(this).html();
                          break;
                      case 1:
                          PaternoEnajenante = $(this).html();
                          break;
                      case 2:
                          MaternoEnajenante = $(this).html();
                          break;
					  case 3:
                          RfcEnajenante = $(this).html();
                          break;
					  case 4:
                          CurpEnajenante = $(this).html();
                          break;
					  case 5:
                          PorcentajeEnajenante = $(this).html();
                          break;
                  }
				  $(this).css("background-color", "#ECF8E0");
            })
			
			cadena=cadena+NombreEnajenante+':::'+PaternoEnajenante+':::'+MaternoEnajenante+':::'+RfcEnajenante+':::'+CurpEnajenante+":::"+PorcentajeEnajenante+":::";
			
        })
		$("#listaEnajenantes").val(cadena);
}

function recorrerTablaAdquirientes(){
	var NombreAdquiriente,  PaternoAdquiriente, MaternoAdquiriente, RfcAdquiriente, CurpAdquiriente, PorcentajeAdquiriente;
	var cadena;
	cadena="";
	$('#tablaAdquiriente tbody tr').each(function () {
            $(this).find('td').each(function (index2) {
                switch (index2) {
                      case 0:
                          NombreAdquiriente = $(this).html();
                          break;
                      case 1:
                          PaternoAdquiriente = $(this).html();
                          break;
                      case 2:
                          MaternoAdquiriente = $(this).html();
                          break;
					  case 3:
                          RfcAdquiriente = $(this).html();
                          break;
					  case 4:
                          CurpAdquiriente = $(this).html();
                          break;
					  case 5:
                          PorcentajeAdquiriente = $(this).html();
                          break;
                  }
				  $(this).css("background-color", "#ECF8E0");
            })
			
			cadena=cadena+NombreAdquiriente+':::'+PaternoAdquiriente+':::'+MaternoAdquiriente+':::'+RfcAdquiriente+':::'+CurpAdquiriente+":::"+PorcentajeAdquiriente+":::";
			
        })
		$("#listaAdquirientes").val(cadena);
}

function contarFilas(tabla){
	var con;
	con=0;
	$('#'+tabla+' tbody tr').each(function () {
            $(this).find('td').each(function (index2) {
                con=con+1;
            })
     })
	return con;	
}