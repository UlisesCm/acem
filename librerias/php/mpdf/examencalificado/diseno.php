<?php

function disenohtmlcss()
{

  $contenido = '<body>
  <h1> Prueba CONTENIDO PDF </h1>
  </body>';

  return $contenido;
  
}

function headerpdf($nombreExamen)
{

    $headeridsenodos = '
      <header>
        <div>
          <h1>'.$nombreExamen.' </h1>
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
