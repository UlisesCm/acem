<?php
include("../../../../modulos/cursos/Cursos.class.php");

function disenohtmlcss($idavancecurso)
{
  
  $Ocursos = new Cursos;
  $resultadoAvance = $Ocursos->mostrarIndividualAvance($idavancecurso);
  $filasAvance = mysqli_fetch_array($resultadoAvance);
  $iddetalleexamen = $filasAvance['iddetalleexamen'];
  $resultado = $Ocursos->mostrarDetallePreguntas($iddetalleexamen);
  $resultadoAlumno = $Ocursos->mostrarIndividualAlumno($filasAvance['idalumno']);
  $filasAlumno = mysqli_fetch_array($resultadoAlumno);
  $cadenaCalificaciones = "";
  $alumno = $filasAlumno['nombre'];
  $contenidoTemp = "";

  while ($filas = mysqli_fetch_array($resultado)) {
    $resultadoPregunta2 = $Ocursos->mostrarPreguntas2($filas['idpregunta']);
		$filaPregunta = mysqli_fetch_array($resultadoPregunta2);
		$resultadoRespuesta2 = $Ocursos->mostrarDetalleRespuestas($filas['iddetallepregunta']);
		$filaRespuesta = mysqli_fetch_array($resultadoRespuesta2);
 

    $contenidoPregunta = '
      <h1> 
        '.$filaPregunta['pregunta'].'
        <small>'.$filaPregunta['tipopregunta'].' - '.$filaPregunta['valor'].'puntos</small>
      </h1>
    ';
    switch ($filaPregunta['tipopregunta']) {
      case 'abierta':
        $contenidoRespuestaTemp='
        <textarea class="form-control" name="" id="" cols="100" rows="3" disabled>'.$filaRespuesta['respuesta'].'</textarea>
        ';
      break;

      case 'casilla':
        $respuestas = $Ocursos->mostrarRespuestas($filas['idpregunta']);
				$cantidadRespuestas = mysqli_num_rows($respuestas);
				$operacion = $filaPregunta['valor']/$cantidadRespuestas;
				$respuestasTemp = 0;
        $contenidoRespuestaTemp = "";
        while ($filasRespuestas = mysqli_fetch_array($respuestas)) {
          $respuestas2 = $Ocursos->mostrarDetalleRespuestas2($filasRespuestas['idrespuesta']);
					$filasDetallesRespuestas = mysqli_fetch_array($respuestas2);
          $checked ="";
          if ($filasRespuestas['respuesta'] == $filasDetallesRespuestas['respuesta']) {
          $checked="checked";
          }
          $contenidoRespuestaTemp = $contenidoRespuestaTemp.'
          <div class="margen-lateral-texto contenedor alineacion-center ">
            <div class="col-md-3">
              <p class="margin-right">
                '.$filasRespuestas['respuesta'].'
              </p>
              <input 
                type="checkbox" 
                name="'.$filasRespuestas['idrespuesta'].'" 
                id="'.$filasRespuestas['idrespuesta'].'" 
                value="'.$filasRespuestas['respuesta'].'"
                '.$checked.'
                disabled
              >
            </div>
          </div>
          ';
          if (($filasRespuestas['correcto'] == "on") && ($filasRespuestas['respuesta'] == $filasDetallesRespuestas['respuesta'])) {
            $respuestasTemp = $respuestasTemp + $operacion;
          }
          if (($filasRespuestas['correcto'] == "off") && ($filasRespuestas['respuesta'] != $filasDetallesRespuestas['respuesta'])) {
            $respuestasTemp = $respuestasTemp + $operacion;
          }
        }
        $calificacionTemp = round($respuestasTemp);
      break;

      case 'multiple':
        $respuestas = $Ocursos->mostrarRespuestas($filas['idpregunta']);
        $contenidoRespuestaTemp = "";
        while ($filasRespuestas = mysqli_fetch_array($respuestas)) {
          $respuestas2 = $Ocursos->mostrarDetalleRespuestas2($filasRespuestas['idrespuesta']);
					$filasDetallesRespuestas = mysqli_fetch_array($respuestas2);
          $checked ="";
          if ($filasRespuestas['respuesta'] == $filasDetallesRespuestas['respuesta']) {
          $checked="checked";
          }
          $contenidoRespuestaTemp = $contenidoRespuestaTemp.'
          <div class="margen-lateral-texto contenedor alineacion-center">
            <div class="col-md-3">
							<p class="margin-right">
								'.$filasRespuestas['respuesta'].'
							</p>
						</div>
            <input 
            type="radio" 
            name="'.$filasRespuestas['idrespuesta'].'"
            id="'.$filasRespuestas['idrespuesta'].'"
            value="'.$filasRespuestas['respuesta'].'"
            '.$checked.'
            disabled
          >
          </div>
          ';
          if (($filasRespuestas['correcto'] == "on") && ($filasRespuestas['respuesta'] == $filasDetallesRespuestas['respuesta'])) {
            $calificacionTemp = $filaPregunta['valor'];
          }
        }
      break;
      case 'practica':
      break;
      
      default:
        break;
    }


    $contenidoGeneral = '
    <div class="margen-lateral-texto">
    '.$contenidoPregunta.'
    '.$contenidoRespuestaTemp.'
    </div>
    ';
    $contenidoTemp = $contenidoTemp.$contenidoGeneral;
  }

  

  $contenido = '
  <body>'.$contenidoTemp.'</body>';

  return $contenido; 
  
}

function headerpdf($nombreExamen, $nombreAlumno, $calificacionFinal)
{

    $headeridsenodos = '
      <header>
        <div>
          <h1>'.$nombreExamen.' </h1>
          <h2>'.$nombreAlumno.' </h2>
          <h2> Calificacion:'.$calificacionFinal.' </h2>
        </div>
      </header>';
  return $headeridsenodos;
}


function Footer()
{
  $footer = '
  <div>
    <h1> Footer PDF</h1>
  </div>';

  return $footer;
}