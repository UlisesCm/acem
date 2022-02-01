<?php

function disenohtmlcss($idtrabajador)
{

  $numero_campos = 0;
  $nombreempleado = '';
  $datosconsultatecnico = '';
  $celdas = '';
  $tipoempleado = '';

  /* $OAsignacionherramientas = new Asignacionherramientas;
$resultado=$OAsignacionherramientas->ObtenerDatosTablaSQL($idtrabajador); */


  /* while ($filas=mysqli_fetch_array($resultado)) {
    $tipoempleado=$filas['tipo'];
    $fechaNfecha=date_create($filas['fecha']);
    $nuevaFecha= date_format($fechaNfecha, 'd/m/Y');

      // code...

    $celdas=$celdas.'<tr>
    <td class="desc">'.$filas['folio'].'</td>
      <td class="desc">'.$filas['marca'].'</td>
      <td class="desc">'.$filas['descripcion'].'</td>
      <td class="desc">'.$nuevaFecha.'</td>
      <td class="desc">'.$filas['condicion'].'</td>
      <td class="desc">'.$filas['cantidad'].'</td>
      <td class="desc">'.$filas['unidad'].'</td>
      <td class="desc"><center><input type="checkbox" id="cbox2" value="second_checkbox"></center></td>
    </tr>';
} */


  /* $OAsignacionherramientasdos = new Asignacionherramientas;
  $nombreempleado=$OAsignacionherramientasdos->obtenerEmpleado($idtrabajador,$tipoempleado); */




  $contenido = '<body>
  <div id="detalles" class="clearfix">
    <div id="Datosgenerales">
    <div id="">Reporte asignación de herramientas</div>
    <div class="notice">Técnico: ' . $nombreempleado . ' </div>
      <div class="notice">Fecha: ' . date("d") . "-" . date("m") . "-" . date("Y") . ' </div>
    </div>
    </div>
  </div>


  <div id="posicion">

        <table>
      <thead>
  <tr>
  <th class="desc">FOLIO</th>
    <th class="desc">MARCA</th>
    <th class="desc">DESCRIPCIÓN</th>
    <th class="desc">FECHA ASIGNACIÓN</th>
    <th class="desc">CONDICIÓN</th>
    <th class="desc">CANTIDAD</th>
    <th class="desc">OBSERVACIONES</th>
    <th class="desc"></th>
  </tr>
  </thead>
  <tbody>

  ' . $celdas . '
  </tbody>
</table>



<br><br><br>

<div class="cajaprincipalfirma">
<div id="detalles" class="clearfix">

<div class="cajafirmaizquierda">
      <div id="firmizquierda">
      <div id=""><div id="">Técnico
        <div id="firmaclientetextocentrado1"><br><br>' . $nombreempleado . '</div></div></div>
          <div id="lineadefirma"></div>
        <div id="firmaclientetextocentrado1">Nombre y firma</div>
      </div>
</div>


<div class="cajafirmaderecha">
      <div id="firmderecha">
      <div id=""><div id="">Auditor
        <div id="firmaclientetextocentrado1"><br><br>' . $_SESSION["nombreusuario"] . '</div></div></div>
        <div id="lineadefirma"></div>
      <div id="firmaclientetextocentrado1">Nombre y firma</div></div>
</div>
</div>
</div>


</div>
  </body>';

  return $contenido;
}

function headerpdf()
{
  $nombresucursal = '';

  $telefonosucursal = '';
  $numerosucursal = '';

  $callesucursal = '';
  $coloniasucursal = '';
  $codigopostal = '';
  $ciudadsucursal = '';
  $estadosucursal = '';



  while ($filas = mysqli_fetch_array($respuesta)) {
    $headeridsenodos = '
      <header class="">
      <div class="cajaheader">
        <div class="cajaheaderizquierda">
        <div id="logo">
          <img src="../../../librerias/php/mpdf/Logo_Fumylim.jpg">
        </div>
        </div>

        <div class="cajaheadercentro">
        &nbsp;
        <div id="corporativo">
        <div>CORPORATIVO FUMYLIM</div>
      <div>VALLE DE LOS CROTOS NO. 1651</div>
      <div>COL. JARDINES DEL VALLE. CP. 45138</div>
      <div>ZAPOPAN, JALISCO. TEL. 33 1561 6893</div>
      FUMYLIM@FUMYLIM.COM.MX
        </div>
        </div>

        <div class="cajaheaderderecha">
        <div id="empresa">
        <h2 class="name">' . $filas['NOMBRESUCURSAL'] . ' &nbsp;&nbsp;</h2>
        <div>' . $filas['CALLESUCURSAL'] . ' #' . $filas['NUMEROSUCURSAL'] . ' &nbsp;&nbsp;</div>
        <div>' . $filas['COLONIASUCURSAL'] . ' CP. ' . $filas['CODIGOPOSTALSUCURSAL'] . ' &nbsp;&nbsp;</div>
        <div>' . $filas['CIUDADSUCURSLA'] . ', ' . $filas['ESTADOSUCURSAL'] . ' Tel. ' . $filas['TELEFONOSUCURSAL'] . ' &nbsp;&nbsp;</div>

        </div>
        </div>


        </div>
        </header>';
  }



  return $headeridsenodos;
}


function Footer()
{
  $footer = '<div style="text-align: left;">{DATE j-m-Y}&nbsp;{DATE H:i:s}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fumipaq® Software & Sourcing  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pagina: {PAGENO}/{nbpg}</div>';

  return $footer;
}
