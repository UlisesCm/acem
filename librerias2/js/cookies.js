//Elaborado por Armando Viera Rodríguez

  function crearCookie(nombre, valor){
	var tiempo = 604800000; //7 días
    var fecha = new Date();
    fecha.setTime(fecha.getTime() + tiempo);
    document.cookie = nombre + ' = ' + escape(valor) + ((tiempo == null) ? '' : '; expires = ' + fecha.toGMTString()) + '; path=/';
  }

  function recuperarCookie(nombre){
    var nombreCookie, valorCookie, cookie = null, cookies = document.cookie.split(';');
    for (i=0; i<cookies.length; i++){
      valorCookie = cookies[i].substr(cookies[i].indexOf('=') + 1);
      nombreCookie = cookies[i].substr(0,cookies[i].indexOf('=')).replace(/^\s+|\s+$/g, '');
      if (nombreCookie == nombre)
        cookie = unescape(valorCookie);
    }
    return cookie;
  }

function comprobarCookie(clave) {
    var clave = obtenerCookie(clave);
    if (clave!="") {
        return true;
    }else{
        return false;
    }
}

function obtenerCookie(clave) {
    var name = clave + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
    }
    return "";
}