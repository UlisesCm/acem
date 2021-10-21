<?php
include_once("../../conexion/Conexion.class.php");
include_once('../../../librerias/php/thumb.php');
class Cursos
{
	//constructor	
	var $con;
	function __construct()
	{
		$this->con = new Conexion;
	}
	function armarConsulta($condicion, $papelera)
	{
		if ($condicion != "") {
			$consulta = "WHERE cursos.idcurso <>'0'";
		} else {
			$consulta = "WHERE cursos.idcurso <>'0'";
		}
		return $consulta;
	}
	function comprobarCampo($campo, $valor, $tipoGuardado)
	{
		if ($this->con->conectar() == true) {
			//print_r($listaCampos);
			$resultado = mysqli_query($this->con->conect, "SELECT COUNT( * ) AS contador from cursos WHERE $campo = '$valor'");
			if ($resultado) {
				$extractor = mysqli_fetch_array($resultado);
				$numero_filas = $extractor["contador"];
				if ($tipoGuardado == 'nuevo') {
					if ($numero_filas == "0") {
						return false;
					} else {
						return true;
					}
				}
				if ($tipoGuardado == 'modificar') {
					if ($numero_filas == "1" or $numero_filas == "0") {
						return false;
					} else {
						return true;
					}
				}
			} else {
				return false;
			}
		}
	}

	function guardar(
		$nombre,// Datos generales del curso
		$categoria,
		$icono,
		$descripcion,
		$contadorLecciones,// Lecciones
		$aTipoLecciones,
		$aInputLecciones,
		$aTextareaLecciones,
		$aRecursoTemporal,
		$aRecursoNombre,
		$aExtencionRecurso,
		$aRecurso,
		$aRecursoExtencion,
		$contadorExamen,// Examen
		$nombreExamen,
		$aValorPregunta,
		$aTipoPregunta,
		$aTextareaPregunta,
		$aInputPregunta,
		$aContadorRespuestas,// PREGUNTAS
		$aaInputRespuesta,
		$aaCheckboxRespuesta
		)
	{
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cursos']['guardar'])) {
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		$idcurso = $this->con->generarClave(2); /*Sincronizacion 1 */
		if ($this->con->conectar() == true) {
			if ($this->comprobarCampo("nombre", $nombre, "nuevo")) {
				return "nombreExiste";
			} else {
				if (mysqli_query($this->con->conect, "INSERT INTO cursos (idcurso, nombre, categoria, icono, descripcion) VALUES ('$idcurso','$nombre','$categoria','$icono','$descripcion')")) {
					
					/* GUARDAR LECCION */////////////////////////////////////////////////////////////////////////////////////////////////
					/* FALTA GUARDAR ARCHIVOS */
					for ($i = 0; $i <= $contadorLecciones; $i++) {	
						$contenido = "";
						$iddetallecurso = $this->con->generarClave(2);
						switch ($aTipoLecciones[$i]) {
							case 'texto':
								$contenido = $aTextareaLecciones[$i];
								$tipo = $aTipoLecciones[$i];
								break;

							case 'enlace':
								$contenido = $aInputLecciones[$i];
								// $contenido = "si entra al case";
								$tipo = $aTipoLecciones[$i];
								// $tipo = "si entra al case";
								break;

							case 'imagen':
								cargarArchivo($aRecurso[$i],$aExtencionRecurso[$i], $aRecursoTemporal[$i], $aRecursoExtencion[$i],"jpg","detallecurso",500, 500,"archivo","center");
								$contenido = $aRecurso[$i];
								$tipo = $aTipoLecciones[$i];
								break;
							case 'video':
								cargarArchivo($aRecurso[$i],$aExtencionRecurso[$i], $aRecursoTemporal[$i], $aRecursoExtencion[$i],"mp4","detallecurso",0,0,"archivo","center");
								$contenido = $aRecurso[$i];
								$tipo = $aTipoLecciones[$i];
								break;
							case 'documento':
								cargarArchivo($aRecurso[$i],$aExtencionRecurso[$i], $aRecursoTemporal[$i], $aRecursoExtencion[$i],"pdf","detallecurso",0,0,"archivo","center");
								$contenido = $aRecurso[$i];
								$tipo = $aTipoLecciones[$i];
								break;

							default:
								$contenido = "default";
								// $contenido = "";
								$tipo = "default";
								// $tipo = $aTipoLecciones[$i];
								break;
							}
								if ($contenido != "eliminado") {
									mysqli_query($this->con->conect, "INSERT INTO detallecurso (iddetallecurso,tipo,contenido,idcurso) VALUES ('$iddetallecurso','$tipo','$contenido','$idcurso')");
								} 
					}

					/* GUARDAR EXMANEN */////////////////////////////////////////////////////////////////////////////////////////////////
					$nombreExamen;
					$idexamen = $this->con->generarClave(2);
					mysqli_query($this->con->conect, "INSERT INTO examenes (idexamen,idcurso,nombreExamen) VALUES ('$idexamen','$idcurso','$nombreExamen')");

					/* GUARDAR PREGUNTAS */////////////////////////////////////////////////////////////////////////////////////////////////
					for ($x=0; $x <= $contadorExamen; $x++) {
						$aInputRespuesta = $aaInputRespuesta[$x];
						$aCheckboxRespuesta = $aaCheckboxRespuesta[$x];
						$valorPregunta = $aValorPregunta[$x];
						$pregunta = "";
						$autoCalificar = "NO";
						$idpregunta = $this->con->generarClave(2);
						switch ($aTipoPregunta[$x]) {
							case 'abierta':
								$pregunta = $aInputPregunta[$x];
								$tipoPregunta = $aTipoPregunta[$x];
								$autoCalificar = "NO";
								break;

							case 'multiple':
								$pregunta = $aInputPregunta[$x];
								$tipoPregunta = $aTipoPregunta[$x];
								$autoCalificar = "SI";
								$contador = $aContadorRespuestas[$x];
								for ($y=0; $y <= $contador; $y++) {
									$iddetallesrespuesta = $this->con->generarClave(2);
									$respuesta = $aInputRespuesta[$y];
									$correcto = $aCheckboxRespuesta[$y];
									mysqli_query($this->con->conect, "INSERT INTO detallesrespuestas (iddetallesrespuesta, idpregunta, respuesta, correcto) VALUES ('$iddetallesrespuesta','$idpregunta','$respuesta','$correcto')");
								}
								break;

							case 'practica':
								$pregunta = $aTextareaPregunta[$x];
								$tipoPregunta = $aTipoPregunta[$x];
								$autoCalificar = "NO";
								break;
							
							default:
							$pregunta = "sindatos";
							$tipoPregunta = "sindatos";
								break;
						}
						if ($contenido != "eliminado" && $aTipoPregunta[$x] != "sindatos" && $pregunta != "sindatos") {
							mysqli_query($this->con->conect, "INSERT INTO preguntas (idpregunta,idexamen,tipopregunta,pregunta,valor,autocalificar) VALUES ('$idpregunta','$idexamen','$tipoPregunta','$pregunta','$valorPregunta','$autoCalificar')");
						} 
					}

					//BITACORA
					if ($_SESSION['bitacora'] == "si") {
						$descripcionB = "agreg&oacute; un nuevo registro en la tabla cursos ";
						$this->registrarBitacora("guardar", $descripcionB);
					}
					return "exito";
				} else {
					return "fracaso";
				}
			}
		}
	}

/* 	function guardarLeccion($ContadorLecciones, $aTipoLecciones, $aInputLecciones, $aTextareaLecciones)
	{
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cursos']['guardar'])) {
			return "denegado";
			exit;
		}
		$contenido = "";
		for ($i = 0; $i <= $ContadorLecciones; $i++) {
			$iddetallecurso = $this->con->generarClave(2);
			switch ($aTipoLecciones[$i]) {

				case 'texto':
					$contenido = $aTextareaLecciones[$i];
					$tipo = $aTipoLecciones[$i];
					break;

				case 'enlace':
					$contenido = $aInputLecciones[$i];
					$tipo = $aTipoLecciones[$i];
					break;

				case 'imagen':
					$contenido = "";
					$tipo = $aTipoLecciones[$i];
					break;
				case 'video':
					$contenido = "";
					$tipo = $aTipoLecciones[$i];
					break;
				case 'documento':
					$contenido = "";
					$tipo = $aTipoLecciones[$i];
					break;

				default:
					$contenido = "";
					$tipo = $aTipoLecciones[$i];
					break;
			}
			if ($this->con->conectar() == true) {
				mysqli_query($this->con->conect, "INSERT INTO detallecurso (iddetallecurso,tipo,contenido) VALUES ('$iddetallecurso','$tipo','$contenido')");
			}
		}
	} */


	function actualizar($nombre, $categoria, $icono, $idcurso)
	{
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cursos']['modificar'])) {
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////

		if ($this->con->conectar() == true) {
			if ($this->comprobarCampo("nombre", $nombre, "modificar")) {
				return "nombreExiste";
			} else {
				if (mysqli_query($this->con->conect, "UPDATE cursos SET nombre='$nombre', categoria='$categoria', icono='$icono' WHERE idcurso='$idcurso'")) {
					//BITACORA
					if ($_SESSION['bitacora'] == "si") {
						$descripcionB = "modific&oacute; el registro ID: $idcurso, de la tabla cursos ";
						$this->registrarBitacora("modificar", $descripcionB);
					}
					return "exito";
				} else {
					return "fracaso";
				}
			}
		}
	}

	function bloquear($idcurso)
	{

		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cursos']['modificar'])) {
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////

		if ($this->con->conectar() == true) {
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			return mysqli_query($this->con->conect, "UPDATE cursos SET estatus ='bloqueado' WHERE idcurso = '$idcurso'");
		}
	}

	function cambiarEstatus($idcurso, $estatus)
	{
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cursos']['modificar'])) {
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////

		if ($this->con->conectar() == true) {
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			if (mysqli_query($this->con->conect, "UPDATE cursos SET estatus ='$estatus' WHERE idcurso = '$idcurso'")) {
				//BITACORA
				if ($_SESSION['bitacora'] == "si") {
					$descripcionB = "alter&oacute; el estatus del registro a: $estatus, de la tabla cursos ";
					$this->registrarBitacora("modificar", $descripcionB);
				}
				return "exito";
			} else {
				return "fracaso";
			}
		}
	}

	function mostrarIndividual($idcurso)
	{
		if ($this->con->conectar() == true) {
			return mysqli_query($this->con->conect, "SELECT * FROM cursos WHERE idcurso='$idcurso'");
		}
	}

	function contar($condicion, $papelera)
	{
		$condicion = trim($condicion);
		$where = $this->armarConsulta($condicion, $papelera);

		if ($this->con->conectar() == true) {
			$resultado = mysqli_query($this->con->conect, "SELECT 
					cursos.idcurso,
					cursos.nombre,
					cursos.categoria,
					cursos.icono
					FROM cursos 
					$where");

			//$extractor = mysqli_fetch_array($resultado);
			$numero_filas = mysqli_num_rows($resultado);
			return $numero_filas;
		}
	}

	function mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera)
	{
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cursos']['consultar'])) {
			return "denegado";
			exit;
		}

		$condicion = trim($condicion);
		$where = $this->armarConsulta($condicion, $papelera);

		$consulta = "SELECT 
					cursos.idcurso,
					cursos.nombre,
					cursos.categoria,
					cursos.icono
					FROM cursos 
					$where
					ORDER BY $campoOrden $orden
					LIMIT $inicial, $cantidadamostrar
					";
		if ($this->con->conectar() == true) {
			return $resultado = mysqli_query($this->con->conect, $consulta);
		}
	}
	function consultaGeneral($condicion)
	{
		if ($this->con->conectar() == true) {
			return mysqli_query($this->con->conect, "SELECT * FROM cursos $condicion");
		}
	}

	function consultaLibre($condicion)
	{
		if ($this->con->conectar() == true) {
			return mysqli_query($this->con->conect, $condicion);
		}
	}

	function obtenerConfiguracion($campo)
	{
		if ($this->con->conectar() == true) {
			$resultado = mysqli_query($this->con->conect, "SELECT $campo FROM configuracion WHERE concepto='$campo' ");
			if ($resultado) {
				$extractor = mysqli_fetch_array($resultado);
				$valorCampo = $extractor["valor"];
				return $valorCampo;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	function registrarBitacora($accion, $descripcion, $idcontrol = "", $tablacontrol = "", $clasificacion = "", $extra = "")
	{
		$idusuario = $_SESSION['idusuario'];
		$usuario = $_SESSION['usuario'];
		$descripcion = "El usuario $usuario " . $descripcion;
		$hora = date('H:i');
		$fecha = date('Y-m-d');
		$modulo = "cursos";
		mysqli_query($this->con->conect, "INSERT INTO bitacora (hora,fecha,idusuario,modulo,accion,descripcion,idcontrol,tablacontrol,clasificacion,extra) VALUES ('$hora','$fecha','$idusuario','$modulo','$accion','$descripcion')");
	}

	function eliminar($ids, $tipoEliminacion)
	{
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cursos']['eliminar'])) {
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////

		if ($this->con->conectar() == true) {
			if ($tipoEliminacion == 'falsa') {
				//REQUIERE CAMPO 'estatus' EN LA TABLA
				if (mysqli_query($this->con->conect, "UPDATE cursos SET estatus ='eliminado' WHERE idcurso IN ($ids)")) {
					//BITACORA
					if ($_SESSION['bitacora'] == "si") {
						$descripcionB = "elimin&oacute; falsamente los registros: $ids, de la tabla cursos ";
						$this->registrarBitacora("eliminarFalsa", $descripcionB);
					}
					return "exito";
				} else {
					return "fracaso";
				}
			}
			if ($tipoEliminacion == 'real') {
				if (mysqli_query($this->con->conect, "DELETE FROM cursos WHERE idcurso IN ($ids)")) {
					//BITACORA
					if ($_SESSION['bitacora'] == "si") {
						$descripcionB = "elimin&oacute; los registros: $ids, de la tabla cursos ";
						$this->registrarBitacora("eliminar", $descripcionB);
					}
					return "exito";
				} else {
					return "fracaso";
				}
			}
		}
	}
}
