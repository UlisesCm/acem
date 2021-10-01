// JavaScript Document

function validarFormatoFecha(campo) { //  dd/mm/aaaa
      var RegExPattern = /^\d{2}\/\d{2}\/\d{4}$/;
      if ((campo.match(RegExPattern)) && (campo!='')) {
            return true;
      } else {
            return false;
      }
}

function validarRFC(campo) {
	  var longitud=campo.length;
	  if (longitud==13){
		  var RegExPattern = '^(([A-Z]|[a-z]|\s){1})(([A-Z]|[a-z]){3})([0-9]{6})((([A-Z]|[a-z]|[0-9]){3}))';
		  if ((campo.match(RegExPattern)) && (campo!='')) {
            return true;
		  } else {
			return false;
		  }
	  }else if(longitud==12){
		  var RegExPattern = '^(([A-Z]|[a-z]){3})([0-9]{6})((([A-Z]|[a-z]|[0-9]){3}))';
		  if ((campo.match(RegExPattern)) && (campo!='')) {
            return true;
		  } else {
			return false;
		  }
	  }else{
		  return false;
	  }
}

function validarRFCMoral(campo) {
	  var longitud=campo.length;
	  if(longitud==12){
		  var RegExPattern = '^(([A-Z]|[a-z]){3})([0-9]{6})((([A-Z]|[a-z]|[0-9]){3}))';
		  if ((campo.match(RegExPattern)) && (campo!='')) {
            return true;
		  } else {
			return false;
		  }
	  }else{
		  return false;
	  }
}

function validarRFCFisica(campo) {
	  var longitud=campo.length;
	  if (longitud==13){
		  var RegExPattern = '^(([A-Z]|[a-z]|\s){1})(([A-Z]|[a-z]){3})([0-9]{6})((([A-Z]|[a-z]|[0-9]){3}))';
		  if ((campo.match(RegExPattern)) && (campo!='')) {
            return true;
		  } else {
			return false;
		  }
	  }else{
		  return false;
	  }
}


function validarCURP(campo) {
	var longitud=campo.length;
	var RegExPattern = '^[A-Z]{1}[AEIOU]{1}[A-Z]{2}[0-9]{2}(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[HM]{1}(AS|BC|BS|CC|CS|CH|CL|CM|DF|DG|GT|GR|HG|JC|MC|MN|MS|NT|NL|OC|PL|QT|QR|SP|SL|SR|TC|TS|TL|VZ|YN|ZS|NE)[B-DF-HJ-NP-TV-Z]{3}[0-9A-Z]{1}[0-9]{1}$';
	if ((campo.match(RegExPattern)) && (campo!='')) {
    	return true;
	} else {
		return false;
	}  
}

function decimalValido(campo){
	campo.replace(/^-?[0-9]+([.][0-9]*)?$/,'');
	campo=removerPunto(campo);
	return campo;
}


function soloNumeros(e,id)
    {
        var teclaPulsada=window.event ? window.event.keyCode:e.which;
        var valor=$("#"+id).val();
        if(teclaPulsada==45 && valor.indexOf("-")==-1)
        {
            $("#"+id).val(valor);
        }
        if(teclaPulsada==13 || (teclaPulsada==46 && valor.indexOf(".")==-1))
        {
            return true;
        }
        return /\d/.test(String.fromCharCode(teclaPulsada));
    }
	
function checarDecimal(e, field) {
  key = e.keyCode ? e.keyCode : e.which
  if (key == 8) return true
  if (key > 47 && key < 58) {
    if (field.value == "") return true
    regexp = /.[0-9]{10}$/
    return !(regexp.test(field.value))
  }
  if (key == 46) {
    if (field.value == "") return false
    regexp = /^[0-9]+$/
    return regexp.test(field.value)
  }
  return false
}





//Codigo complemento de las funciones de validacion

(function(a){a.fn.permitirCaracteres=function(b){a(this).on({keypress:function(a){var c=a.which,d=a.keyCode,e=		String.fromCharCode(c).toLowerCase(),f=b;
(-1!=f.indexOf(e)||9==d||37!=c&&37==d||39==d&&39!=c||8==d||46==d&&46!=c)&&161!=c||a.preventDefault()}})}})(jQuery);

function removerPunto(cadenaAnalizar) {
	   var cadena;
	   cadena="";
	   var encontrado;
	   encontrado=false;
	   for (var i = 0; i< cadenaAnalizar.length; i++) {
			 var caracter = cadenaAnalizar.charAt(i);
			 if( caracter == ".") {
					if (encontrado==false){
						cadena=cadena+caracter;
					}
					encontrado=true;
			 }else{
				 	cadena=cadena+caracter;
			 }
			  
		}
		return cadena;
	}