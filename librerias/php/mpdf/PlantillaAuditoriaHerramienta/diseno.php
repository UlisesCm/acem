<?php

function disenohtmlcss()
{

  $contenido = '<body>
  <h1> Prueba CONTENIDO PDF </h1>
  </body>';

  return $contenido;
  
}

function headerpdf()
{

    $headeridsenodos = '
      <header>
        <div>
          <h1> NOMBRE DEL EXAMEN </h1>
          <h2> ALUMNO </h2>
          <h2> Calificacion </h2>
        </div>
      </header>';
  
  return $headeridsenodos;
}


function Footer()
{
  $footer = '
  <div>
    <h1> Docente</h1>
    <h1> Fecha y Hora</h1>
  </div>';

  return $footer;
}
