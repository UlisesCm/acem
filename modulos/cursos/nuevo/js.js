// JS MODULA Autor: Armando Viera Rodriguez 2016
function vaciarCampos() {
  $("#cnombre").focus();
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
  });

  $("#agregar-pregunta").click(() => {
    objetoContador.push(0)
    contadorExamen++;
    crearPregunta(contadorExamen);
    contenidoExamen(contadorExamen);
  });

  /* $("#agregar-respuesta").click(() => {
    contadorRespuesta++
    crearRespuesta(contadorRespuesta)
  }); */

  $("#ctipoLeccion").change(() => {
    contenidoLecciones(contadorLeccion);
  });

  $("#ctipopregunta").change(() => {
    contenidoExamen(contadorExamen);
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

  if (index === 0 || !index) {
    select = $("#ctipoLeccion");
    textArea = $("#contenidoTextArea");
    input = $("#contenidoInput");
    documento = $("#contenidoArchivo");
  } else {
    select = $("#ctipoLeccion" + index);
    textArea = $("#contenidoTextArea" + index);
    input = $("#contenidoInput" + index);
    documento = $("#contenidoArchivo" + index);
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

const contenidoExamen = (index) => {
  let select, textarea, input, respuesta;
  if (index === 0 || !index) {
    select = $("#ctipopregunta");
    textarea = $("#textarea-pregunta");
    input = $("#input-pregunta");
    respuesta = $("#div-respuesta");
  } else {
    select = $("#ctipopregunta" + index);
    textarea = $("#textarea-pregunta" + index);
    input = $("#input-pregunta" + index);
    respuesta = $("#div-respuesta" + index);
  }

  // console.log("se esta manipulando: " + index);
  textarea.hide();
  input.show();
  respuesta.hide();

  switch (select.val()) {
    case "abierta":
      input.show();
      textarea.hide();
      respuesta.hide();
      // console.log("Examen Abierta");
      break;

    case "multiple":
      input.show();
      textarea.hide();
      respuesta.show();
      // console.log("Examen Multiple");
      break;

    case "practica":
      input.hide();
      textarea.show();
      respuesta.hide();
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
  //   console.log(nuevo);
};

const crearPregunta = (index) => {
  
  /* ERROR CON LOS IDENTIFICADORES EL "DIV-RESPUESTA SIEMPRE MUESTRA 0" Y LOS OTROS COMPONENTES JALAN MAL EL INDEX */
  const original = document.getElementById("nodo-padre-examen");
  const destino = document.getElementById("padre-examen");
  const nuevo = original.cloneNode(true);

  const nuevoId = "nodo-padre-examen" + index;
  nuevo.id = nuevoId;

  destino.appendChild(nuevo);

  let cloneChild = document.getElementById(nuevoId).childNodes;
  let primerDiv = cloneChild[3].id + index;
  let nodoPadreRespuesta = cloneChild[7].id + index;
  cloneChild[7].id = nodoPadreRespuesta;
  cloneChild[3].id = primerDiv;

  let cloneChild2 = document.getElementById(primerDiv).childNodes; //PRIMER DIV NODO
  let divSelect = cloneChild2[3].id + index
  let divPregunta = cloneChild2[7].id + index
  cloneChild2[3].id = divSelect //DIV SELECT ID
  cloneChild2[7].id = divPregunta // DIV PREGUNTA ID

  let cloneChild21 = document.getElementById(divSelect).childNodes // DIV SELECT NODO
  let selectPregunta = cloneChild21[1].id + index
  cloneChild21[1].id = selectPregunta // SELECT PREGUNTA ID
  cloneChild21[1].setAttribute("onChange", `contenidoExamen(${index});`); //se agrega atributo onchange al select
  

  let cloneChild22 = document.getElementById(divPregunta).childNodes; // DIV PREGUNTA NODO
  let inputPregunta = cloneChild22[1].id + index
  let textAreaPregunta = cloneChild22[3].id + index

  cloneChild22[1].id = inputPregunta
  cloneChild22[3].id = textAreaPregunta

  let cloneChild3 = document.getElementById(nodoPadreRespuesta).childNodes; //PRIMER DIV
  let divRespuesta = cloneChild3[1].id + index;
  cloneChild3[1].id = divRespuesta;

  let cloneChild31 = document.getElementById(divRespuesta).childNodes; //DIV RESPUESTAS NODO
  let divInputRespuesta = cloneChild31[3].id + index; // DIV INPUT RESPUESTA ID
  let divCheckboxRespuesta = cloneChild31[5].id + index; // DIV CHECKBOX RESPUESTA ID
  let botonAgregarRespuesta = cloneChild31[7].id + index; // BOTON AGREGAR RESPUESTA ID
  cloneChild31[7].setAttribute("onClick", `crearRespuesta(${index});`);
  // cloneChild31[7].setAttribute("onClick", `funcionBoton(${index})`);

  cloneChild31[3].id = divInputRespuesta;
  cloneChild31[5].id = divCheckboxRespuesta;
  cloneChild31[7].id = botonAgregarRespuesta;

  let cloneChild311 = document.getElementById(divInputRespuesta).childNodes;
  let inputRespuesta = cloneChild311[1].id + index
  cloneChild311[1].id = inputRespuesta;
  
  let cloneChild312 = document.getElementById(divCheckboxRespuesta).childNodes;
  let checkbox = cloneChild312[1].id + index;
  cloneChild312[1].id = checkbox
  
};

const crearRespuesta = (index) => {
  objetoContador[index] = objetoContador[index]+1
  const original = document.getElementById("div-respuesta");
  const destino = document.getElementById("nodo-padre-respuesta");
  const nuevo = original.cloneNode(true);

  destino.appendChild(nuevo);

  const nuevoId = "div-respuesta" + index /* + objetoContador[index] */;
  nuevo.id = nuevoId;
  console.log(nuevo.id)

  let cloneChild = document.getElementById(nuevoId).childNodes;
  let divInputRespuesta = cloneChild[3].id + objetoContador[index] ; // DIV INPUT RESPUESTA ID
  let divCheckboxRespuesta = cloneChild[5].id + objetoContador[index]; // DIV CHECKBOX RESPUESTA ID
  let botonAgregarRespuesta = cloneChild[7].id + objetoContador[index];
  /* let divInputRespuesta = cloneChild[3].id + index ; // DIV INPUT RESPUESTA ID
  let divCheckboxRespuesta = cloneChild[5].id + index; // DIV CHECKBOX RESPUESTA ID
  let botonAgregarRespuesta = cloneChild[7].id + index ; */
  cloneChild[3].id = divInputRespuesta;
  cloneChild[5].id = divCheckboxRespuesta;
  cloneChild[7].id = botonAgregarRespuesta;
   
  /* console.log(divCheckboxRespuesta) 
  console.log(botonAgregarRespuesta)  */

  // document.getElementById(botonAgregarRespuesta).remove()

  let cloneChild1 = document.getElementById(divInputRespuesta).childNodes;
  let inputRespuesta = cloneChild1[1].id + index
  cloneChild1[1].id = inputRespuesta;
  
  let cloneChild2 = document.getElementById(divCheckboxRespuesta).childNodes;
  let checkbox = cloneChild2[1].id + index;
  cloneChild2[1].id = checkbox

  // CONTADOR DINAMICO PARA CONTAR EL NUMERO DE RESPUESTAS
  // console.log(objetoContador)

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
