// Elementos del DOM

const subirDocumento = async (index) => {
  const $inputArchivos = document.querySelector("#inputArchivos" + index);
  // const $btnEnviar = document.querySelector("#btnEnviar" + index);
  const input = document.getElementById("inputArchivoText" + index);
  const btnEnviar = document.getElementById("btnEnviar" + index);
  // $btnEnviar.addEventListener("click", async () => {
  const archivosParaSubir = $inputArchivos.files;
  if (archivosParaSubir.length <= 0) {
    // Si no hay archivos, no continuamos
    return;
  }
  // Preparamos el formdata
  const formData = new FormData();
  // Agregamos cada archivo a "archivos[]". Los corchetes son importantes
  for (const archivo of archivosParaSubir) {
    formData.append("archivos[]", archivo);
  }
  // Los enviamos
  // $estado.textContent = "Enviando archivos...";
  const respuestaRaw = await fetch("./subirArchivos/guardarArchivos.php", {
    method: "POST",
    body: formData,
  });
  const respuesta = await respuestaRaw.json();
  // Puedes manejar la respuesta como tú quieras
  // Finalmente limpiamos el campo
  $inputArchivos.value = null;

  btnEnviar.value = "Subido";
  btnEnviar.setAttribute("class", "btn btn-primary margen-5");
  // console.log(btnEnviar)
  input.value = respuesta;
  // $estado.textContent = "Archivos enviados";
  // });
};
