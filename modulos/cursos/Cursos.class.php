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
			$consulta = "WHERE ((cursos.nombre LIKE '%" . $condicion . "%') OR (cursos.nombre LIKE '%" . $condicion . "%'))AND cursos.idcurso <>'0'";
			// $consulta="WHERE ((usuarios.nombre LIKE '%".$condicion."%') OR (usuarios.usuario LIKE '%".$condicion."%'))AND usuarios.idusuario <>'0'";
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
		$nombre, // Datos generales del curso
		$categoria,
		$icono,
		$descripcion,
		$contadorLecciones, // Lecciones
		$aTipoLecciones,
		$aInputLecciones,
		$aTextareaLecciones,
		$aInputArchivo,
		$contadorExamen, // Examen
		$nombreExamen,
		$aValorPregunta,
		$aTipoPregunta,
		$aTextareaPregunta,
		$aInputPregunta,
		$aContadorRespuestas, // PREGUNTAS
		$aRadioRespuesta,
		$aaInputRespuesta,
		$aaCheckboxRespuesta
	) {
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

					/* GUARDAR LECCION */ ////////////////////////////////////////////////////////////////////////////////////////////////
					/* FALTA GUARDAR ARCHIVOS */
					$valorTemp1 = $contadorLecciones+1;
					$valorTemp2 = 100/$valorTemp1;
					$valor= ceil($valorTemp2);
					for ($i = 0; $i <= $contadorLecciones; $i++) {
						$contenido = "";
						$orden = 0;
						// $iddetallecurso = $this->con->generarClave(2);
						$idleccion = $this->con->generarClave(2);
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
/* 							cargarArchivo($aRecurso[$i], $aExtencionRecurso[$i], $aRecursoTemporal[$i], $aRecursoExtencion[$i], "jpg", "leccion", 500, 500, "archivo", "center");
								$contenido = $aRecurso[$i];
								$tipo = $aTipoLecciones[$i]; */
								$contenido = $aInputArchivo[$i];
								$tipo = $aTipoLecciones[$i];
								break;
							case 'video':
/* 							cargarArchivo($aRecurso[$i], $aExtencionRecurso[$i], $aRecursoTemporal[$i], $aRecursoExtencion[$i], "mp4", "leccion", 0, 0, "archivo", "center");
								$contenido = $aRecurso[$i];
								$tipo = $aTipoLecciones[$i]; */
								$contenido = $aInputArchivo[$i];
								$tipo = $aTipoLecciones[$i];
								break;
							case 'documento':
/* 							cargarArchivo($aRecurso[$i], $aExtencionRecurso[$i], $aRecursoTemporal[$i], $aRecursoExtencion[$i], "pdf", "leccion", 0, 0, "archivo", "center");
								$contenido = $aRecurso[$i];
								$tipo = $aTipoLecciones[$i]; */
								$contenido = $aInputArchivo[$i];
								$tipo = $aTipoLecciones[$i];
								break;

							default:
								$contenido = "_eliminado";
								$tipo = "_eliminado";
								break;
						}
						$orden = $i + 1;
						if ($contenido != "_eliminado" && $tipo != "_eliminado") {
							mysqli_query($this->con->conect, "INSERT INTO lecciones (idleccion,tipo,contenido,orden,idcurso,valor) VALUES ('$idleccion','$tipo','$contenido','$orden','$idcurso','$valor')");
						}
					}

					/* GUARDAR EXMANEN */ ////////////////////////////////////////////////////////////////////////////////////////////////
					$nombreExamen;
					$idexamen = $this->con->generarClave(2);
					mysqli_query($this->con->conect, "INSERT INTO examenes (idexamen,idcurso,nombreExamen) VALUES ('$idexamen','$idcurso','$nombreExamen')");

					/* GUARDAR PREGUNTAS */ ////////////////////////////////////////////////////////////////////////////////////////////////
					for ($x = 0; $x <= $contadorExamen; $x++) {

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
								$radio = $aRadioRespuesta[$x];
								for ($y = 0; $y <= $contador; $y++) {
									$radioTemporal = "radio" . $x . $y;
									$idrespuesta = $this->con->generarClave(2);
									$respuesta = $aInputRespuesta[$y];
									if ($radio == $radioTemporal) {
										$correcto = "on";
									} else {
										$correcto = "off";
									}
									if ($respuesta != "_eliminado") {
										mysqli_query($this->con->conect, "INSERT INTO respuestas (idrespuesta, idpregunta, respuesta, correcto) VALUES ('$idrespuesta','$idpregunta','$respuesta','$correcto')");
									}
								}
								break;

							case 'casilla':
								$pregunta = $aInputPregunta[$x];
								$tipoPregunta = $aTipoPregunta[$x];
								$autoCalificar = "SI";
								$contador = $aContadorRespuestas[$x];
								for ($y = 0; $y <= $contador; $y++) {
									$idrespuesta = $this->con->generarClave(2);
									$respuesta = $aInputRespuesta[$y];
									$correcto = $aCheckboxRespuesta[$y];
									if ($respuesta != "_eliminado") {
										mysqli_query($this->con->conect, "INSERT INTO respuestas (idrespuesta, idpregunta, respuesta, correcto) VALUES ('$idrespuesta','$idpregunta','$respuesta','$correcto')");
									}
								}
								break;

							case 'practica':
								$pregunta = $aTextareaPregunta[$x];
								$tipoPregunta = $aTipoPregunta[$x];
								$autoCalificar = "NO";
								break;

							default:
								$pregunta = "_eliminado";
								$tipoPregunta = "_eliminado";
								break;
						}
						if ($contenido != "_eliminado" && $aTipoPregunta[$x] != "_eliminado" && $pregunta != "_eliminado") {
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

	function guardarInscribir($curso, $docente, $alumno)
	{
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['empleados']['guardar'])) {
			return "denegado";
			exit;
		}
		//Avance Cursos
		$idavancecurso = $this->con->generarClave(2); //se genera aqui
		if ($curso) {
			$idcurso = $curso; //se traen de id curso
		} else {
			$idcurso = 000;
		}
		if ($alumno) {
			$idalumno = $alumno; //se trae desde variables de session
		} else {
			$idalumno = 000;
		}
		$iddocente = $docente; // se trae de docente
		$iddetalleexamen = ""; // Se genera aqui
		$avance = ""; // se deja asi
		$fechainicio = date('d-m-Y'); // se genera aqui
		$fechafin = ""; //se deja asi
		$finalizado = false; // se genera aqui
		date_default_timezone_set('America/Mexico_City');
		$horainicio = round((time()/60)/60);
		//Detalle Examenes
		$examen = mysqli_query($this->con->conect, "SELECT * FROM examenes WHERE idcurso='$idcurso'");
		$extractor = mysqli_fetch_array($examen);
		// $idexamen = $extractor["idexamen"]; // Se trae desde idcurso
		// $iddetalleexamen; //se genera aqui
		// $calificacion = ""; // Deja asi
		// $examenPDF = ""; // temporalmente asi

		$resultados = mysqli_query($this->con->conect, "SELECT * FROM lecciones WHERE idcurso = '$idcurso'");
		foreach ($resultados as $resultado) {
			$idleccion = $resultado["idleccion"];
			$iddetalleleccion = $this->con->generarClave(2);
			$visto = "NO";
			mysqli_query($this->con->conect, "INSERT INTO detallelecciones (iddetalleleccion, idavancecurso, idleccion, visto) VALUES ('$iddetalleleccion', '$idavancecurso', '$idleccion', '$visto')");
		}

		/////FIN  DE PERMISOS////////
		$avancecursos = mysqli_query($this->con->conect, "INSERT INTO avancecursos (idavancecurso, idcurso, idalumno, iddocente, iddetalleexamen, avance, fechainicio, fechafin, finalizado, horainicio) VALUES ('$idavancecurso','$idcurso','$idalumno','$iddocente','$iddetalleexamen','$avance','$fechainicio','$fechafin','$finalizado','$horainicio')");
		if ($this->con->conectar() == true) {
			if ($avancecursos) {
				if ($_SESSION['bitacora'] == "si") {
					$descripcionB = "agreg&oacute; un nuevo registro en la tabla empleados ";
					$this->registrarBitacora("guardar", $descripcionB);
				}
				return "exito";
			} else {
				return "fracaso";
			}
		}
	}


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

	function mostrarDocente($idempleado)
	{
		if ($this->con->conectar() == true) {
			return mysqli_query($this->con->conect, "SELECT * FROM empleados WHERE idempleado='$idempleado'");
		}
	}
	
	function mostrarIndiceLeccion($idavancecurso)
	{
		if ($this->con->conectar() == true) {
			return mysqli_query($this->con->conect, "SELECT indiceleccion FROM avancecursos WHERE idavancecurso='$idavancecurso'");
		}
	}
	function aumentarIndiceLeccion($idavancecurso, $indice)
	{
		if ($this->con->conectar() == true ) {
			$consulta = "UPDATE avancecursos SET indiceleccion ='$indice' WHERE idavancecurso ='$idavancecurso'";
			mysqli_query($this->con->conect, $consulta);
		}
	}

	function mostrarIndividual($idcurso)
	{
		if ($this->con->conectar() == true) {
			return mysqli_query($this->con->conect, "SELECT * FROM cursos WHERE idcurso='$idcurso'");
		}
	}

	function mostrarIndividualAlumno($idusuario)
	{
		if ($this->con->conectar() == true) {
			return mysqli_query($this->con->conect, "SELECT nombre FROM usuarios WHERE idusuario='$idusuario'");
		}
	}

	function mostrarIndividualAvance($idavancecurso)
	{
		if ($this->con->conectar() == true) {
			return mysqli_query($this->con->conect, "SELECT * FROM avancecursos WHERE idavancecurso='$idavancecurso'");
		}
	}

	function reiniciarLecciones($duracion, $horainicio, $idavancecurso)
	{
		date_default_timezone_set('America/Mexico_City');
		$horaactual = round((time()/60)/60);
		$horacomparacion = $horainicio + $duracion;

		if ($horacomparacion <= $horaactual) {
			mysqli_query($this->con->conect, "DELETE FROM avancecursos WHERE idavancecurso ='$idavancecurso'");
			mysqli_query($this->con->conect, "DELETE FROM detallelecciones WHERE idavancecurso ='$idavancecurso'");
			return false;
		} else {
			return true;
		}
	}

	function mostrarIndividualLeccion($idleccion)
	{
		if ($this->con->conectar() == true) {
			return mysqli_query($this->con->conect, "SELECT * FROM leccion WHERE idleccion='$idleccion'");
		}
	}

	function mostrarIndividualPregunta($idpregunta)
	{
		if ($this->con->conectar() == true) {
			return mysqli_query($this->con->conect, "SELECT * FROM preguntas WHERE idpregunta = '$idpregunta'");
		}
	}

	function mostrarExamen($idcurso)
	{
		if ($this->con->conectar() == true) {
			return mysqli_query($this->con->conect, "SELECT * FROM examenes WHERE idcurso='$idcurso'");
		}
	}

	
	function mostrarPreguntas($idexamen)
	{
		if ($this->con->conectar() == true) {
			return mysqli_query($this->con->conect, "SELECT * FROM preguntas WHERE idexamen = '$idexamen'");
		}
	}

	function mostrarPreguntas2($idpregunta)
	{
		if ($this->con->conectar() == true) {
			return mysqli_query($this->con->conect, "SELECT * FROM preguntas WHERE idpregunta = '$idpregunta'");
		}
	}
	
	function mostrarDetallePreguntas($iddetalleexamen )
	{
		if ($this->con->conectar() == true) {
			return mysqli_query($this->con->conect, "SELECT * FROM detallepreguntas WHERE iddetalleexamen  = '$iddetalleexamen '");
		}
	}

	function mostrarRespuestas($idpregunta)
	{
		if ($this->con->conectar() == true) {
			return mysqli_query($this->con->conect, "SELECT * FROM respuestas WHERE idpregunta = '$idpregunta'");
		}
	}

	function mostrarDetalleRespuestas($iddetallepregunta)
	{
		if ($this->con->conectar() == true) {
			return mysqli_query($this->con->conect, "SELECT * FROM detallerespuestas WHERE iddetallepregunta = '$iddetallepregunta'");
		}
	}

	function mostrarDetalleRespuestas2($idrespuesta)
	{
		if ($this->con->conectar() == true) {
			return mysqli_query($this->con->conect, "SELECT * FROM detallerespuestas WHERE idrespuesta = '$idrespuesta'");
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

	function mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera, $categorias, $cursosBusqueda)
	{
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cursos']['consultar'])) {
			return "denegado";
			exit;
		}

		$consultarCategoria = "";
		if ($categorias != "todos") {
			$consultarCategoria = "AND cursos.categoria='$categorias'";
		} else {
			$consultarCategoria = "";
		}

		$consultarCursos = "";
		if ($cursosBusqueda != "") {
			$consultarCursos = "AND cursos.nombre LIKE '%" . $cursosBusqueda . "%'";
		} else {
			$consultarCursos = "";
		}
		$condicion = trim($condicion);

		$join = "LEFT OUTER JOIN avancecursos ON cursos.idcurso = avancecursos.idcurso";
		$where = "
			WHERE avancecursos.idavancecurso IS null
			$consultarCategoria
			$consultarCursos
		";

		$consulta = "SELECT cursos.idcurso, cursos.nombre, cursos.categoria, cursos.icono, cursos.descripcion
					FROM cursos
					$join
					$where
					ORDER BY $campoOrden $orden
					LIMIT $inicial, $cantidadamostrar
					";
		if ($this->con->conectar() == true) {
			return $resultado = mysqli_query($this->con->conect, $consulta);
		}
	}

	function obtenerHora($idcurso)
	{
		$consulta = "SELECT * FROM `cursos` WHERE idcurso = '$idcurso'";
		return mysqli_query($this->con->conect, $consulta);
	}

	function mostrarTodoCursos( $campoOrden, $orden, $inicial, $cantidadamostrar, $categorias, $cursosBusqueda)
	{
			/////PERMISOS////////////////
			if (!isset($_SESSION['permisos']['cursos']['consultar'])) {
				return "denegado";
				exit;
			}
	
			$consultarCategoria = "";
			if ($categorias != "todos") {
				$consultarCategoria = "AND cursos.categoria='$categorias'";
			} else {
				$consultarCategoria = "";
			}
	
			$consultarCursos = "";
			if ($cursosBusqueda != "") {
				$consultarCursos = "AND cursos.nombre LIKE '%" . $cursosBusqueda . "%'";
			} else {
				$consultarCursos = "";
			}
	
			$where = "";
	
			$consulta = "SELECT *
						FROM cursos
						$where
						ORDER BY $campoOrden $orden
						LIMIT $inicial, $cantidadamostrar
						";
			if ($this->con->conectar() == true) {
				return $resultado = mysqli_query($this->con->conect, $consulta);
			}
	}

	function mostrarMisCursos($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera, $categorias, $cursosTerminados)
	{
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cursos']['consultar'])) {
			return "denegado";
			exit;
		}
		$idalumno = $_SESSION['idusuario'];

		$consultarCategoria = "";
		if ($categorias != "todos") {
			$consultarCategoria = "AND cursos.categoria='$categorias'";
		} else {
			$consultarCategoria = "";
		}

		if ($cursosTerminados == false) {
			$consultaTerminados = "AND avancecursos.finalizado = 0";
		} else {
			$consultaTerminados = "";
		}

		$where = "
			WHERE idalumno='$idalumno'
			$consultarCategoria
			$consultaTerminados
		";

		$consulta = "SELECT * 
		FROM `avancecursos` 
		INNER JOIN cursos ON avancecursos.idcurso=cursos.idcurso 
		$where
		-- ORDER BY $campoOrden $orden
		-- LIMIT $inicial, $cantidadamostrar
		";

		if ($this->con->conectar() == true) {
			return mysqli_query($this->con->conect, $consulta);
		}
	}

	function mostrarDetalleExamen($iddetalleexamen)
	{
		$consulta = "SELECT * FROM `detalleexamenes` WHERE iddetalleexamen = '$iddetalleexamen'";
		return mysqli_query($this->con->conect, $consulta);
	}


	function mostrarAlumno($idalumno)
	{
		$consulta = "SELECT * FROM `usuarios` WHERE idusuario = '$idalumno'";
		return mysqli_query($this->con->conect, $consulta);
	}

	function mostrarEvaluaciones($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera, $categorias, $cursosTerminados)
	{
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cursos']['consultar'])) {
			return "denegado";
			exit;
		}
		$iddocente = $_SESSION['idusuario'];

		$consultarCategoria = "";
		if ($categorias != "todos") {
			$consultarCategoria = "AND cursos.categoria='$categorias'";
		} else {
			$consultarCategoria = "";
		}

		if ($cursosTerminados == false) {
			$consultaTerminados = "AND detalleexamenes.calificacion = 0";
		} else {
			$consultaTerminados = "";
		}

		$examenEnviado = "AND avancecursos.iddetalleexamen <> 0";

		$where = "
			WHERE iddocente='2482121472328'
			$consultarCategoria
			$consultaTerminados
			$examenEnviado
		";

		$consulta = "SELECT * 
		FROM `avancecursos` 
		INNER JOIN cursos ON avancecursos.idcurso=cursos.idcurso
		INNER JOIN examenes ON avancecursos.idcurso=examenes.idcurso 
		INNER JOIN detalleexamenes ON avancecursos.iddetalleexamen=detalleexamenes.iddetalleexamen 
		$where
		";

		if ($this->con->conectar() == true) {
			return mysqli_query($this->con->conect, $consulta);
		}
	}

	function navegacionCurso($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera, $idcurso)
	{
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cursos']['consultar'])) {
			return "denegado";
			exit;
		}

		$where = "
			WHERE idcurso='$idcurso'
		";
		$order = "ORDER BY `lecciones`.`orden` ASC";

		//SELECT * FROM lecciones INNER JOIN detallelecciones ON lecciones.idleccion = detallelecciones.idleccion WHERE idcurso = "3202120211140"
		//SELECT * FROM `detallelecciones` INNER JOIN lecciones ON detallelecciones.idleccion = lecciones.idleccion WHERE idcurso='3202120211140'
		$consulta = "SELECT * 
		FROM `detallelecciones` 
		INNER JOIN lecciones ON detallelecciones.idleccion=lecciones.idleccion
		$where
		$order
		";

		if ($this->con->conectar() == true) {
			return mysqli_query($this->con->conect, $consulta);
		}
	}

	function mostrarLeccion($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera, $idcurso, $ordenLeccion)
	{
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cursos']['consultar'])) {
			return "denegado";
			exit;
		}

		$where = "
		WHERE lecciones.idcurso = '$idcurso'
		AND lecciones.orden = '$ordenLeccion'
		";

		$consulta = "SELECT * 
		FROM lecciones INNER JOIN detallelecciones 
		ON lecciones.idleccion = detallelecciones.idleccion
		$where
		";

		if ($this->con->conectar() == true) {
			return mysqli_query($this->con->conect, $consulta);
		}
	}

	function mostrarLeccion2($idcurso)
	{
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cursos']['consultar'])) {
			return "denegado";
			exit;
		}
		$consulta = "SELECT * FROM lecciones WHERE lecciones.idcurso = '$idcurso'";
	
		if ($this->con->conectar() == true) {
			return mysqli_query($this->con->conect, $consulta);
		}
	}

	function siguienteLeccion($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera, $idcurso, $ordenLeccion)
	{
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cursos']['consultar'])) {
			return "denegado";
			exit;
		}

		$siguienteLeccion = $ordenLeccion + 1;
		$where = "
			WHERE lecciones.idcurso = '$idcurso'
			AND lecciones.orden = '$siguienteLeccion'
		";

		$consulta = "SELECT * 
		FROM lecciones INNER JOIN detallelecciones 
		ON lecciones.idleccion = detallelecciones.idleccion
		$where
		";
		if ($this->con->conectar() == true) {
			return mysqli_query($this->con->conect, $consulta);
		}
	}

	function anteriorLeccion($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera, $idcurso, $ordenLeccion)
	{
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cursos']['consultar'])) {
			return "denegado";
			exit;
		}

		$siguienteLeccion = $ordenLeccion - 1;
		$where = "
			WHERE lecciones.idcurso = '$idcurso'
			AND lecciones.orden = '$siguienteLeccion'
		";

		$consulta = "SELECT * 
		FROM lecciones INNER JOIN detallelecciones 
		ON lecciones.idleccion = detallelecciones.idleccion
		$where
		";
		if ($this->con->conectar() == true) {
			return mysqli_query($this->con->conect, $consulta);
		}
	}

	function mostrarExamen2($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera, $iddetalleleccion)
	{
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cursos']['consultar'])) {
			return "denegado";
			exit;
		}

		$where = "
			WHERE detallelecciones.iddetalleleccion ='$iddetalleleccion'
		";

		$consulta = "SELECT * 
		FROM lecciones INNER JOIN detallelecciones 
		ON lecciones.idleccion = detallelecciones.idleccion
		$where
		";
		if ($this->con->conectar() == true) {
			return mysqli_query($this->con->conect, $consulta);
		}
	}

	function cambiarVisto($iddetalleleccion)
	{
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cursos']['modificar'])) {
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		$consulta = "UPDATE detallelecciones SET visto ='SI' WHERE iddetalleleccion ='$iddetalleleccion'";

		if ($this->con->conectar() == true) {
			return mysqli_query($this->con->conect, $consulta);
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

	function agregarAvance($valor, $idavancecurso)
	{
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cursos']['modificar'])) {
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		mysqli_query($this->con->conect, "UPDATE avancecursos SET avance = avance+'$valor' WHERE idavancecurso = '$idavancecurso'");
	}

	function mostrarAvance($idavancecurso)
	{
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cursos']['consultar'])) {
			return "denegado";
			exit;
		}

		$where = "
			WHERE avancecursos.idavancecurso = '$idavancecurso'
		";

		$consulta = "SELECT avance,iddetalleexamen,iddocente,indiceleccion FROM avancecursos
		$where
		";
		if ($this->con->conectar() == true) {
			return mysqli_query($this->con->conect, $consulta);
		}
	}


	function enviarExamen($idexamen,$arregloPregunta,$arregloRespuesta,$arregloRespuestasAlumno,$arregloTipo,$contadorPreguntas,$total, $contadorRespuestas, $arregloContadorRespuesta, $idavancecurso)
	{
		$contadorTotal = 1;
		// DETALLE EXAMEN //////////////////////////////////////////////////////////////////
		$iddetalleexamen = $this->con->generarClave(2);
		// $idexamen = "";
		$calificacion = 0;
		$examenpdf = "";
		$fechafin = date('d-m-Y'); 
		$consultaExamen = "INSERT INTO detalleexamenes (iddetalleexamen,idexamen,calificacion,examenpdf) VALUES ('$iddetalleexamen','$idexamen','$calificacion','$examenpdf')";
		mysqli_query($this->con->conect, $consultaExamen);
		for ($i=0; $i < $contadorPreguntas; $i++) { 
			//Detalle de Preguntas /////////////////////////////////////////////////////////////
			$calificacionPregunta = 0;
			$iddetallepregunta = $this->con->generarClave(2);
			$idpregunta = $arregloPregunta[$contadorTotal]; 
			$consultaPregunta = "INSERT INTO detallepreguntas (iddetallepregunta,iddetalleexamen,idpregunta,calificacion ) VALUES ('$iddetallepregunta','$iddetalleexamen','$idpregunta','$calificacionPregunta')";
			mysqli_query($this->con->conect, $consultaPregunta);	

			for ($j=0; $j < $arregloContadorRespuesta[$i+1]; $j++) {
				// DETALLE RESPUESTAS //////////////////////////////////////////////
				$iddetallerespuesta	= $this->con->generarClave(2);
				// $iddetallepregunta = "";
				// $idrespuesta = $arregloRespuesta[$contadorTotal];
				$respuesta = $arregloRespuestasAlumno[$contadorTotal];
				if ($arregloTipo[$contadorTotal] == "multiple") {
					$idpreguntaTemp = $arregloPregunta[$contadorTotal];
					$consultaRadio = "SELECT idrespuesta FROM respuestas WHERE idpregunta = '$idpreguntaTemp' AND respuesta = '$respuesta'";
					$peticionRadio = mysqli_query($this->con->conect, $consultaRadio);
					$filasRadio = mysqli_fetch_array($peticionRadio);
					$idrespuesta = $filasRadio['idrespuesta'];
				} else {
					$idrespuesta = $arregloRespuesta[$contadorTotal];
				}
				$consultaRespuesta = "INSERT INTO detallerespuestas (iddetallerespuesta,iddetallepregunta,idrespuesta,respuesta ) VALUES ('$iddetallerespuesta','$iddetallepregunta','$idrespuesta','$respuesta')";
				mysqli_query($this->con->conect, $consultaRespuesta);
				$contadorTotal++;
			}
		}
		$actualizarAvance = "UPDATE avancecursos SET iddetalleexamen='$iddetalleexamen', fechafin='$fechafin', finalizado='1' WHERE idavancecurso='$idavancecurso'";
		mysqli_query($this->con->conect, $actualizarAvance);
	}

	function enviarCalificacion($contadorCalificaciones, $arregloCalificacion, $arregloIdRespuestas, $calificacionMaxima ,$iddetalleexamen, $nombrePDF)
	{
		$sumaCalificacion = 0;
		for ($i=1; $i <= $contadorCalificaciones ; $i++) { 
			$calificacion = $arregloCalificacion[$i];
			$idpregunta = $arregloIdRespuestas[$i];
			$actualizarCalificacion = "UPDATE detallepreguntas SET calificacion='$calificacion' WHERE idpregunta='$idpregunta'";
			mysqli_query($this->con->conect, $actualizarCalificacion);
			$sumaCalificacion = $sumaCalificacion + $calificacion;
		}
		$calculoCalificacion = round(($sumaCalificacion/$calificacionMaxima)*100);
		if ($calculoCalificacion == 0) {
			$calculoCalificacion = 1;
		}
		$actualizarDetalleExamenes = "UPDATE detalleexamenes SET calificacion='$calculoCalificacion', examenpdf='$nombrePDF' WHERE iddetalleexamen='$iddetalleexamen'";
		mysqli_query($this->con->conect, $actualizarDetalleExamenes);
		return $calculoCalificacion;
	}
	
	function modificarLeccion($contadorLecciones, $aIdLecciones, $aContenidoLecciones)
	{
		for ($i=0; $i < $contadorLecciones; $i++) { 
			$idleccion = $aIdLecciones[$i+1];
			$contenido = $aContenidoLecciones[$i];
			$consulta = "UPDATE lecciones SET contenido='$contenido' WHERE idleccion='$idleccion'";
			mysqli_query($this->con->conect, $consulta);
		}
	}

	function modificarPregunta($contadorPreguntas, $aIdPreguntas, $aContenidoPreguntas)
	{
		for ($i=0; $i < $contadorPreguntas; $i++) { 
			$idpregunta = $aIdPreguntas[$i+1];
			$pregunta = $aContenidoPreguntas[$i];
			$consulta = "UPDATE preguntas SET pregunta='$pregunta' WHERE idpregunta='$idpregunta'";
			mysqli_query($this->con->conect, $consulta);
		}
	}

	function modificarRespuesta($contadorRespuestas, $aIdRespuestas, $aContenidoRespuestas, $aRespuestasCorrecto)
	{
		for ($i=0; $i < $contadorRespuestas; $i++) { 
			$idrespuesta = $aIdRespuestas[$i+1];
			$respuesta = $aContenidoRespuestas[$i];
			$correcto = $aRespuestasCorrecto[$i];
			$consulta = "UPDATE respuestas SET respuesta='$respuesta', correcto='$correcto' WHERE idrespuesta='$idrespuesta'";
			mysqli_query($this->con->conect, $consulta);
		}
	}

	function modificarNombreExamen($idexamen, $nombreExamen)
	{
			$consulta = "UPDATE examenes SET nombreExamen='$nombreExamen' WHERE idexamen='$idexamen'";
			mysqli_query($this->con->conect, $consulta);
	}
}



/* 
:::102218460900
:::102218460981
:::102218461014
:::102218461017
:::102218461027
:::102218461048
*/
