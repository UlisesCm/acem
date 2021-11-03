// JS MODULA Autor: Armando Viera Rodriguez 2016
function vaciarCampos() {
  $("#cnombre").focus();
}

function fileinput(nombre) {
  $("#n" + nombre).val($("#c" + nombre).val());
  // guardarArchivo()
}

const objetoContador = [0];

$(document).ready(function () {

  let contadorLeccion = 0;
  let contadorExamen = 0;

  /* Mostrar y Ocultar tipo de Leccion y Examen */
  contenidoLecciones(contadorLeccion);
  contenidoExamen(contadorExamen);

  //crear Lecciones
  $("#agregar-leccion").click(() => {
    contadorLeccion++;
    crearLeccion(contadorLeccion);
    contenidoLecciones(contadorLeccion);
    actualizarContadorLecciones(contadorLeccion);
  });

  $("#agregar-pregunta").click(() => {
    objetoContador.push(0);
    contadorExamen++;
    crearPregunta(contadorExamen);
    contenidoExamen(contadorExamen);
    actualizarContadorExamen(contadorExamen);
  });

  /* Llenar select */
  llenarSelectDocente("");
  $("#iddocente_ajax").change(function () {
    llenarSelectSucursalgarantias($("#iddocente_ajax").val());
  });

  $("#padre-examen").hide();
  $("#padre-lecciones").hide();
  ocultarLecciones();
  ocultarExamenes();

  $("#panel_alertas").hide();
  $(".loading").hide();
  //$("#panel_alertas").delay(8000).hide(600);
  $("#botonGuardar").click(function () {
    if (Spry.Widget.Form.validate(formulario)) {
      if (validar()) {
        var variables = $("#formulario").serialize();
        guardar(variables);
        // guardarArchivo();
      }
    }
  });

  $(".botonSave").click(function () {
    if (Spry.Widget.Form.validate(formulario)) {
      if (validar()) {
        var variables = $("#formulario").serialize();
        guardar(variables);
        // guardarArchivo();
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

  select = $("#ctipoLeccion" + index);
  textArea = $("#div-contenido-textArea" + index);
  input = $("#div-contenido-input" + index);
  documento = $("#div-contenido-archivo" + index);

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

const contenidoExamen = (index) => {
  objetoContador[index];
  let select, textarea, input, respuesta;

  select = $("#ctipopregunta" + index);
  textarea = $("#textarea-pregunta" + index);
  input = $("#input-pregunta" + index);
  respuesta = $("#div-respuesta" + index);
  labelPregunta = $("#label-pregunta" + index);
  labelPractica = $("#label-respuesta" + index);

  textarea.hide();
  input.show();
  respuesta.hide();
  labelPregunta.show();
  labelPractica.hide();
  // $("#respuesta-checkbox"+index+"0").hide()

  switch (select.val()) {
    case "abierta":
      for (let i = 0; i <= objetoContador[index]; i++) {
        $("#div-respuesta" + index + i).hide();
      }
      input.show();
      textarea.hide();
      respuesta.hide();
      labelPregunta.show();
      labelPractica.hide();
      // console.log("Examen Abierta");
      break;

    case "multiple":
      for (let i = 0; i <= objetoContador[index]; i++) {
        $("#div-respuesta" + index + i).show();
        let radioTemporal = $("#radio-respuesta" + index + i);
        let checkboxTemporal = $("#checkbox-respuesta" + index + i);
        radioTemporal.show();
        checkboxTemporal.hide();
      }
      input.show();
      textarea.hide();
      respuesta.show();
      labelPregunta.show();
      labelPractica.hide();
      break;

    case "casilla":
      for (let i = 0; i <= objetoContador[index]; i++) {
        $("#div-respuesta" + index + i).show();
        let radioTemporal = $("#radio-respuesta" + index + i);
        let checkboxTemporal = $("#checkbox-respuesta" + index + i);
        console.log(radioTemporal);
        console.log(checkboxTemporal);
        radioTemporal.hide();
        checkboxTemporal.show();
      }
      input.show();
      textarea.hide();
      respuesta.show();
      labelPregunta.show();
      labelPractica.hide();
      break;

    case "practica":
      for (let i = 0; i <= objetoContador[index]; i++) {
        $("#div-respuesta" + index + i).hide();
      }
      input.hide();
      textarea.show();
      respuesta.hide();
      labelPregunta.hide();
      labelPractica.show();
      // console.log("Examen Practica");
      break;

    default:
      textarea.hide();
      input.show();
      respuesta.hide();
      break;
  }
};

const crearLeccion = (index) => {
  /* MOVER TODOS LOS IDENTIFICADORES Y AGREGAR NAMES */
  // CAMBIE LOS ID PARA ESTANDARIZAR IDS Y NAMES ENTONCES HAY QUE CAMBIAR LA FUNCION DE OCULTAR LECCIONES
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
  let cloneChild2 = document.getElementById(divPrincipal).childNodes; //div-principal
  let divSelect = cloneChild2[5].id + index;
  let divBotonBorrar = cloneChild2[7].id + index;
  let divTextArea = cloneChild2[11].id + index;
  let divContenidoInput = cloneChild2[15].id + index;
  let divContenidoArchivo = cloneChild2[19].id + index;

  cloneChild2[5].id = divSelect; // DIV SELECT
  cloneChild2[7].id = divBotonBorrar; // DIV BOTON BORRAR
  cloneChild2[7].setAttribute("style", "display:block");
  cloneChild2[11].id = divTextArea; //DIV DEL TEXT AREA
  cloneChild2[15].id = divContenidoInput; // DIV CONTENIDO INPUT
  cloneChild2[19].id = divContenidoArchivo; // DIV CONTENIDO ARCHIVO

  //Accesso al div del select
  let cloneChild3 = document.getElementById(divSelect).childNodes; //DIV SELECT
  cloneChild3[1].id = "ctipoLeccion" + index;
  cloneChild3[1].setAttribute("name", `tipoLeccion${index}`); //agregamos atributo de name
  cloneChild3[1].setAttribute("onChange", `contenidoLecciones(${index});`); //agregamos atributo de onChange para disparar funcion contenidolecciones()
  //Acceso al div del textArea
  let cloneChild31 = document.getElementById(divTextArea).childNodes;
  let textArea = cloneChild31[3].id + index;
  cloneChild31[3].id = textArea;
  cloneChild31[3].setAttribute("name", `contenidoTextArea${index}`);
  // cloneChild31[3].setAttribute("value", `valor del Text Area ${index}`);//VALOR PARA HACER PRUEBAS
  // Accesso al div contenido Input
  let cloneChild32 = document.getElementById(divContenidoInput).childNodes;
  let divInput = cloneChild32[3].id + index;
  cloneChild32[3].id = divInput;
  /* Acceso al div input */
  let cloneChild321 = document.getElementById(divInput).childNodes;
  let input = cloneChild321[1].id + index;
  cloneChild321[1].id = input;
  cloneChild321[1].setAttribute("name", `contenidoInput${index}`);
  cloneChild321[1].setAttribute("value", `valor del Input ${index}`); //VALOR PARA HACER PRUEBAS
  // Acceso al div contenido archivo
  let cloneChild33 = document.getElementById(divContenidoArchivo).childNodes;
  let divArchivoHijo = cloneChild33[3].id + index;
  cloneChild33[3].id = divArchivoHijo;
  // Acceso al div Archivo Hijo
  let cloneChild331 = document.getElementById(divArchivoHijo).childNodes;
  let divArchivoNieto = cloneChild331[1].id + index;
  cloneChild331[1].id = divArchivoNieto;
  //Accesso al div Archivo Nieto
  let cloneChild3311 = document.getElementById(divArchivoNieto).childNodes;
  let inputArchivo1 = cloneChild3311[1].id + index;
  let inputArchivo2 = cloneChild3311[3].id + index;
  cloneChild3311[1].id = inputArchivo1;
  cloneChild3311[3].id = inputArchivo2;
  cloneChild3311[1].setAttribute("name", `recurso${index}`);
  cloneChild3311[3].setAttribute("name", `nrecurso${index}`);
  // Acceso al div de boton
  let cloneChild4 = document.getElementById(divBotonBorrar).childNodes;
  cloneChild4[1].id = cloneChild4[1].id + index;
  cloneChild4[1].setAttribute("onClick", `borrarLeccion(${index});`);
};

const crearPregunta = (index) => {
  objetoContador[index];

  const original = document.getElementById("nodo-padre-examen");
  const destino = document.getElementById("padre-examen");
  const nuevo = original.cloneNode(true);
  const nuevoId = "nodo-padre-examen" + index;
  nuevo.id = nuevoId;
  destino.appendChild(nuevo);

  let cloneChild = document.getElementById(nuevoId).childNodes;
  let primerDiv = "primer-div" + index;
  let nodoPadreRespuesta = "nodo-padre-respuesta" + index;
  cloneChild[7].id = nodoPadreRespuesta;
  cloneChild[3].id = primerDiv;

  let cloneChild2 = document.getElementById(primerDiv).childNodes; //PRIMER DIV NODO
  // console.log(cloneChild2)
  let divSelectPregunta = "div-select-pregunta" + index;
  let divBotonPregunta = "div-button-pregunta" + index;
  let divPregunta = "div-pregunta" + index;
  let divInputValor = "div-input-valor" + index;
  let labelPregunta = "label-cambiante" + index;
  cloneChild2[3].id = divSelectPregunta; //DIV SELECT ID
  cloneChild2[5].id = divBotonPregunta; // DIV PREGUNTA ID
  cloneChild2[7].id = labelPregunta; // Label que muestra respuesta o practica
  cloneChild2[9].id = divPregunta; // DIV PREGUNTA ID
  cloneChild2[13].id = divInputValor; // DIV PREGUNTA ID

  let cloneChild21 = document.getElementById(divSelectPregunta).childNodes; // DIV SELECT NODO
  // console.log(cloneChild21);
  let selectPregunta = "ctipopregunta" + index;
  cloneChild21[1].id = selectPregunta; // SELECT PREGUNTA ID
  cloneChild21[1].setAttribute("onChange", `contenidoExamen(${index});`);
  cloneChild21[1].setAttribute("name", `tipoPregunta${index}`); //se agrega atributo onchange al select

  let cloneChild22 = document.getElementById(divPregunta).childNodes; // DIV PREGUNTA NODO
  let inputPregunta = "input-pregunta" + index;
  let textAreaPregunta = "textarea-pregunta" + index;
  cloneChild22[1].id = inputPregunta;
  cloneChild22[3].id = textAreaPregunta;
  cloneChild22[1].setAttribute("name", `inputPregunta${index}`);
  cloneChild22[3].setAttribute("name", `textareaPregunta${index}`);

  let cloneChild23 = document.getElementById(divBotonPregunta).childNodes;
  let botonBorrar = "boton-borrar-pregunta" + index;
  cloneChild23[1].id = botonBorrar;
  cloneChild23[1].setAttribute("onClick", `borrarPregunta(${index});`);

  let cloneChild24 = document.getElementById(divInputValor).childNodes;
  let inputValor = "input-valor" + index;
  cloneChild24[1].id = inputValor;
  cloneChild24[1].setAttribute("name", `inputValor${index}`);

  let cloneChild25 = document.getElementById(labelPregunta).childNodes;
  // console.log(cloneChild25);
  let spanPregunta = "label-pregunta" + index;
  let spanRespuesta = "label-respuesta" + index;
  cloneChild25[1].id = spanPregunta;
  cloneChild25[3].id = spanRespuesta;

  let cloneChild3 = document.getElementById(nodoPadreRespuesta).childNodes; //PRIMER DIV
  let divRespuesta = "div-respuesta" + index;
  cloneChild3[1].id = divRespuesta;

  let cloneChild31 = document.getElementById(divRespuesta).childNodes; //DIV RESPUESTAS NODO
  let divInputRespuesta = "div-input-respuesta" + index; // DIV INPUT RESPUESTA ID
  let divCheckboxRespuesta = "div-checkbox-respuesta" + index; // DIV CHECKBOX RESPUESTA ID
  let botonAgregarRespuesta = "agregar-respuesta" + index; // BOTON AGREGAR RESPUESTA ID
  cloneChild31[3].id = divInputRespuesta;
  cloneChild31[5].id = divCheckboxRespuesta;
  cloneChild31[7].id = botonAgregarRespuesta;
  cloneChild31[7].setAttribute(
    "onClick",
    `crearRespuesta(${index}),contenidoExamen(${index});`
  );

  let cloneChild311 = document.getElementById(divInputRespuesta).childNodes;
  let inputRespuesta = "input-respuesta" + index + 0;
  cloneChild311[1].id = inputRespuesta;
  cloneChild311[1].setAttribute("name", `inputRespuesta${index}0`);

  let cloneChild312 = document.getElementById(divCheckboxRespuesta).childNodes;
  let radio = "radio-respuesta" + index + 0;
  let checkbox = "checkbox-respuesta" + index + 0;
  cloneChild312[1].id = checkbox;
  cloneChild312[3].id = radio;
  cloneChild312[1].setAttribute("name", `checkboxRespuesta${index}0`);
  cloneChild312[3].setAttribute("name", `radioRespuesta${index}`);
  cloneChild312[3].setAttribute("value", `radio${index}0`);
};

const crearRespuesta = (index) => {
  objetoContador[index] = objetoContador[index] + 1;
  actualizarContadorRespuesta(objetoContador);

  const original = document.getElementById("div-respuesta");
  const destino = document.getElementById("nodo-padre-respuesta" + index);
  const nuevo = original.cloneNode(true);

  destino.appendChild(nuevo);
  const nuevoId = "div-respuesta" + index + objetoContador[index];
  nuevo.id = nuevoId;

  let cloneChild = document.getElementById(nuevoId).childNodes;
  let divInputRespuesta = "div-input-respuesta" + index + objetoContador[index]; // DIV INPUT RESPUESTA ID
  let divCheckboxRespuesta =
    "div-checkbox-respuesta" + index + objetoContador[index]; // DIV CHECKBOX RESPUESTA ID
  let botonAgregarRespuesta =
    "agregar-respuestas" + index + objetoContador[index];
  let botonBorrarRespuesta = "borrar-respuesta" + index + objetoContador[index];
  cloneChild[3].id = divInputRespuesta;
  cloneChild[5].id = divCheckboxRespuesta;
  cloneChild[7].id = botonAgregarRespuesta;
  cloneChild[9].id = botonBorrarRespuesta;
  cloneChild[9].setAttribute(
    "onclick",
    `borrarRespuesta(${index},${objetoContador[index]});`
  );
  cloneChild[9].setAttribute("style", "display:block");
  document.getElementById(botonAgregarRespuesta).remove();

  let cloneChild1 = document.getElementById(divInputRespuesta).childNodes;
  let inputRespuesta = "input-respuesta" + index + objetoContador[index];
  cloneChild1[1].id = inputRespuesta;
  cloneChild1[1].setAttribute(
    "name",
    `inputRespuesta${index}${objetoContador[index]}`
  );
  cloneChild1[1].setAttribute(
    "value",
    `inputRespuesta${index}${objetoContador[index]}`
  );

  let cloneChild2 = document.getElementById(divCheckboxRespuesta).childNodes;
  let radio = "radio-respuesta" + index + objetoContador[index];
  let checkbox = "checkbox-respuesta" + index + objetoContador[index];
  // console.log(checkbox);
  cloneChild2[1].id = checkbox;
  cloneChild2[3].id = radio;
  cloneChild2[1].setAttribute(
    "name",
    `checkboxRespuesta${index}${objetoContador[index]}`
  );
  cloneChild2[3].setAttribute("name", `radioRespuesta${index}`);
  cloneChild2[3].setAttribute("value", `radio${index}${objetoContador[index]}`);

  // CONTADOR DINAMICO PARA CONTAR EL NUMERO DE RESPUESTAS
  // console.log(objetoContador)
};

const borrarRespuesta = (indexPregunta, indexRespuesta) => {
  let elemento = "div-respuesta" + indexPregunta + indexRespuesta;
  document.getElementById(elemento).remove();
};

const borrarLeccion = (index) => {
  let elemento = "nodo-padre-leccion" + index;
  document.getElementById(elemento).remove();
};

const borrarPregunta = (index) => {
  let elemento = "nodo-padre-examen" + index;
  document.getElementById(elemento).remove();
};

const ocultarLecciones = () => {
  $("#padre-lecciones").hide(200);
  $("#ocultarLeccion").hide();
  $("#mostrarLeccion").show();
  $("#agregar-leccion").hide();
};

const mostrarLecciones = () => {
  $("#padre-lecciones").show(200);
  $("#ocultarLeccion").show();
  $("#mostrarLeccion").hide();
  $("#agregar-leccion").show();
};

const ocultarExamenes = () => {
  $("#padre-examen").hide(200);
  $("#ocultarExamen").hide();
  $("#mostrarExamen").show();
  $("#agregar-pregunta").hide();
};

const mostrarExamenes = () => {
  $("#padre-examen").show(200);
  $("#ocultarExamen").show();
  $("#mostrarExamen").hide();
  $("#agregar-pregunta").show();
};

const actualizarContadorLecciones = (index) => {
  $("#input-contador-lecciones").val(index);
};

const actualizarContadorExamen = (index) => {
  $("#input-contador-examen").val(index);
};

const actualizarContadorRespuesta = (index) => {
  $("#input-contador-respuesta").val(index);
};

const guardarArchivo = () => {
  var formData = new FormData($("#formulario-recurso0")[0]);
  $("#botonGuardar").hide();
  $("#botonSave").hide();
  $("#loading").show();
  $.ajax({
    url: "guardararchivoscurso.php",
    type: "POST",
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
    success: function (mensaje) {
      $("#botonGuardar").show();
      $("#botonSave").show();
      $("#loading").hide();
      console.log(mensaje);
    },
  });
  return false;
};

const guardarInscribir = (variables) => {
  $("#botonGuardar").hide();
  $("#botonSave").hide();
  $("#loading").show();
  $.ajax({
    url: "guardarInscribir.php",
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

const llenarSelectDocente = (condicion) => {
  $("#iddocente_ajax").html("<option value='1'>cargando...</option>");
  $.ajax({
    url: "../componentes/llenarSelectDocente.php",
    type: "POST",
    data: "submit=&condicion=" + condicion, //Pasamos los datos en forma de array seralizado desde la funcion de envio
    success: function (mensaje) {
      $("#iddocente_ajax").html(mensaje);
    },
  });
  return false;
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
