// JS MODULA Autor: Armando Viera Rodriguez 2016
function vaciarCampos() {
  $("#cnombre").focus();
}
$(document).ready(function () {
  let contadorLeccion = 0;
  let contadorExamen = 0;
  /* Mostrar y Ocultar tipo de Leccion y Examen */
  contenidoLecciones();
  contenidoExamen();

  //crear Lecciones
  $("#agregar-leccion").click(() => {
    contadorLeccion++;
    // console.log("contador Leccion aumentado a: "+contadorLeccion)
    crearLeccion(contadorLeccion);
    contenidoLecciones(contadorLeccion);
  });

  $("#agregar-pregunta").click(() => {
    contadorExamen++;
    // console.log("contador aumentado a: "+contadorExamen)
    crearPregunta(contadorExamen);
  });

  /* SOLUCION PROV - crear un input hidden y manipularlo cada que haya cambios y ejecutar un solo change que cambie todos los selects */
  $("#ctipoLeccion").change(() => {
    contenidoLecciones(contador);
  });

  $("#ctipopregunta").change(() => {
    contenidoExamen();
  });

  $("#panel_alertas").hide();
  $(".loading").hide();
  //$("#panel_alertas").delay(8000).hide(600);

  $("#botonGuardar").click(function () {
    if (Spry.Widget.Form.validate(formulario)) {
      if (validar()) {
        var variables = $("#formulario").serialize();
        guardar(variables);
      }
    }
  });
  $(".botonSave").click(function () {
    if (Spry.Widget.Form.validate(formulario)) {
      if (validar()) {
        var variables = $("#formulario").serialize();
        guardar(variables);
      }
    }
  });
  $(".botonBuscar").click(function () {
    var busqueda = $.trim($("#cajaBuscar").val());
    //if(busqueda!=""){
    buscar(busqueda);
    //}
  });

  $("#cajaBuscar").keypress(function (event) {
    var keycode = event.keyCode ? event.keyCode : event.which;
    if (keycode == "13") {
      var busqueda = $.trim($("#cajaBuscar").val());
      //if(busqueda!=""){
      buscar(busqueda);
      //}
    }
  });

  $(".botonNormal").click(function () {
    $("#panel_alertas").stop(false, true);
  });

  $(".close").click(function () {
    $("#panel_alertas").stop(false, true);
    $("#panel_alertas").hide();
  });
});

function validar() {
  var estado = true;
  var mensaje = "";

  if (estado == false) {
    mostrarMensaje(mensaje);
  }
  return estado;
}

//**************************AJAX*******************************
// Autor: Armando Viera Rodríguez
// Onixbm 2016

/* Funcion en flecha para ocultar y mostrar el input de contenidos. */
const contenidoLecciones = (index) => {
  let select, textArea, input, documento;
  console.log(index);

  if (index === 0 || !index) {
    select = $("#ctipoLeccion");
    textArea = $("#contenidoTextArea");
    input = $("#contenidoInput");
    documento = $("#contenidoArchivo");
    console.log(index);
    console.log("DENTRO DEL IF");
  } else {
    select = $("#ctipoLeccion" + index);
    textArea = $("#contenidoTextArea" + index);
    input = $("#contenidoInput" + index);
    documento = $("#contenidoArchivo" + index);
    console.log("FUERA DEL IF");
    console.log(index);
  }

  textArea.show();
  input.hide();
  documento.hide();

  switch (select.val()) {
    case "texto":
      textArea.show();
      input.hide();
      documento.hide();
      // console.log("se esta mostrando Texto")
      break;

    case "enlace":
      input.show();
      textArea.hide();
      documento.hide();
      // console.log("se esta mostrando enlace")
      break;

    case "imagen":
      documento.show();
      input.hide();
      textArea.hide();
      // console.log("se esta mostrando imagen")
      break;

    case "video":
      documento.show();
      input.hide();
      textArea.hide();
      // console.log("se esta mostrando video")
      break;

    case "documento":
      documento.show();
      input.hide();
      textArea.hide();
      // console.log("se esta mostrando documento")
      break;

    default:
      textArea.show();
      input.hide();
      documento.hide();
      // console.log("se esta mostrando default")
      break;
  }
};

const contenidoExamen = () => {
  const checkbox = $("#respuesta-checkbox");
  const select = $("#ctipopregunta");
  const textarea = $("#textarea-pregunta");
  const input = $("#input-pregunta");

  checkbox.hide();
  textarea.hide();
  input.show();

  switch (select.val()) {
    case "abierta":
      checkbox.hide();
      input.show();
      textarea.hide();
      break;

    case "multiple":
      checkbox.show();
      input.show();
      textarea.hide();
      break;

    case "practica":
      checkbox.hide();
      input.hide();
      textarea.show();
      break;

    default:
      break;
  }
};

const crearLeccion = (index) => {
  const original = document.getElementById("nodo-padre-leccion");
  const destino = document.getElementById("padre-lecciones");
  const nuevo = original.cloneNode(true);

  const nuevoId = "nodo-padre-leccion" + index;
  nuevo.id = nuevoId;

  destino.appendChild(nuevo);

  //acceso al primer div.
  let cloneChild = document.getElementById(nuevoId).childNodes;
  let divPrincipal = "div-principal" + index;
  cloneChild[1].id = divPrincipal;
  //acceso a los div hijos y cambio de id a text area, Input y archivo
  let cloneChild2 = document.getElementById(divPrincipal).childNodes;
  let divSelect = cloneChild2[5].id + index;
  cloneChild2[5].id = divSelect; // DIV SELECT
  cloneChild2[9].id = cloneChild2[9].id + index; //TEXT AREA
  cloneChild2[13].id = cloneChild2[13].id + index; // CONTENIDO INPUT
  cloneChild2[17].id = cloneChild2[17].id + index; // CONTENIDO ARCHIVO

  //Accesso al div del select
  let cloneChild3 = document.getElementById(divSelect).childNodes;
  cloneChild3[1].id = "ctipoLeccion" + index;
  cloneChild3[1].setAttribute("onChange", `contenidoLecciones(${index});`);
  console.log(nuevo);
};

const crearPregunta = (index) => {
  const original = document.getElementById("nodo-padre-examen");
  const destino = document.getElementById("padre-examen");
  const nuevo = original.cloneNode(true);

  const nuevoId = "nodo-padre-examen" + index;
  nuevo.id = nuevoId;

  destino.appendChild(nuevo);

  let cloneChild = document.getElementById(nuevoId).childNodes;
  let primerDiv = cloneChild[3].id + index;
  let divRespuesta = cloneChild[7].id + index;
  cloneChild[7].id = divRespuesta;
  cloneChild[3].id = primerDiv;

  let cloneChild2 = document.getElementById(primerDiv).childNodes;
  let divSelect = cloneChild2[3].id + index;
  let divPregunta = cloneChild2[7].id + index;

  cloneChild2[3].id = divSelect;
  cloneChild2[7].id = divPregunta;

  let cloneChild3 = document.getElementById(divSelect).childNodes;
  let select = cloneChild3[1].id + index;
  cloneChild3[1].id = select;

  let cloneChild4 = document.getElementById(divPregunta).childNodes;
  let inputPregunta = cloneChild4[1].id + index;
  let textAreaPregunta = cloneChild4[3].id + index;
  cloneChild4[1].id = inputPregunta;
  cloneChild4[3].id = textAreaPregunta;

  let cloneChild5 = document.getElementById(divRespuesta).childNodes;
  let divInputRespuesta = cloneChild5[3].id + index;
  cloneChild5[3].id = divInputRespuesta;

  let cloneChild6 = document.getElementById(divInputRespuesta).childNodes;
  let inputRespuesta = cloneChild6[1].id + index;

  cloneChild6[1].id = inputRespuesta;
  console.log(inputRespuesta);
};

function buscar(busqueda) {
  location.href =
    "../consultar/vista.php?link=vista&busqueda=" +
    busqueda +
    "&n1=cursos&n2=consultarcursos";
}

function guardar(variables) {
  $("#botonGuardar").hide();
  $("#botonSave").hide();
  $("#loading").show();
  $.ajax({
    url: "guardar.php",
    type: "POST",
    data: "submit=&" + variables, //Pasamos los datos en forma de array seralizado desde la funcion de envio
    success: function (mensaje) {
      $("#botonGuardar").show();
      $("#botonSave").show();
      $("#loading").hide();
      mostrarMensaje(mensaje);
    },
  });
  return false;
}

function mostrarMensaje(mensaje) {
  //alert(mensaje);
  var cadena = $.trim(mensaje); //Limpia la cadena regresada desde php
  var res = cadena.split("@"); //Separa la cadena en cada @ y convierte las partes en un array
  if (res[0] == "exito") {
    //Si la primer frase contiene la palabra "exito"
    $("#panel_alertas")
      .removeClass()
      .addClass("alert alert-success alert-dismissable");
    $("#notificacionTitulo").html("<i class='icon fa fa-check'></i>" + res[1]);
    $("#notificacionContenido").html(res[2]);
    vaciarCampos();
  } else if (res[0] == "fracaso") {
    $("#panel_alertas")
      .removeClass()
      .addClass("alert alert-error alert-dismissable");
    $("#notificacionTitulo").html("<i class='icon fa fa-ban'></i>" + res[1]);
    $("#notificacionContenido").html(res[2]);
  } else if (res[0] == "aviso") {
    $("#panel_alertas")
      .removeClass()
      .addClass("alert alert-warning alert-dismissable");
    $("#notificacionTitulo").html(
      "<i class='icon fa fa-warning'></i>" + res[1]
    );
    $("#notificacionContenido").html(res[2]);
  } else {
    $("#panel_alertas")
      .removeClass()
      .addClass("alert alert-error alert-dismissable");
    $("#notificacionTitulo").html("Operaci&oacute;n fallida");
    $("#notificacionContenido").html(
      "<i class='icon fa fa-ban'></i> No se han resivido datos de respuesta desde el servidor [003]"
    );
  }
  $("#panel_alertas").stop(false, true);
  $("#panel_alertas").fadeIn("slow");
  var $contenedor = $("body");
  $("html,body").animate({ scrollTop: 0 }, 1000);
  $("#panel_alertas").delay(6000).fadeOut("slow");
}
