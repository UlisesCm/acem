<?php 
include_once("../../conexion/Conexion.class.php");

class Bitacoracontrol{
 //constructor	
 	var $con;
 	function __construct(){
 		$this->con=new Conexion;
	}
	function armarConsulta($condicion,$papelera){
		if ($condicion!=""){
			$consulta="WHERE ((bitacoracontrol.idregistro LIKE '%".$condicion."%') OR (bitacoracontrol.fecha LIKE '%".$condicion."%'))AND bitacoracontrol.idbitacoracontrol <>'0'";
		}else{
			$consulta="WHERE bitacoracontrol.idbitacoracontrol <>'0'";
		}
		return $consulta;
	}function comprobarCampo($campo, $valor, $tipoGuardado){
		if($this->con->conectar()==true){
			//print_r($listaCampos);
			$resultado=mysql_query("SELECT COUNT( * ) AS contador from bitacoracontrol WHERE $campo = '$valor'");
			if ($resultado){
				$extractor = mysql_fetch_array($resultado);
				$numero_filas=$extractor["contador"];
				if ($tipoGuardado=='nuevo'){
					if ($numero_filas=="0"){
						return false;
					}else{
						return true;
					}
				}
				if ($tipoGuardado=='modificar'){
					if ($numero_filas=="1" or $numero_filas=="0"){
						return false;
					}else{
						return true;
					}
				}
			}else{
				return false;
			}
		}
	}

	function guardar($fecha,$hora,$idusuario,$modulo,$accion,$descripcion,$idregistro,$tabla){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['bitacoracontrol']['guardar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		$idSync=$this->con->generarClave(2); /*Sincronizacion 1 */
		
		if($this->con->conectar()==true){
			
				if(mysqli_query($this->con->conect,"INSERT INTO bitacoracontrol (idbitacoracontrol, fecha, hora, idusuario, modulo, accion, descripcion, idregistro, tabla) VALUES ('$idSync', '$fecha','$hora','$idusuario','$modulo','$accion','$descripcion','$idregistro','$tabla')")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="agreg&oacute; un nuevo registro en la tabla bitacoracontrol ";
						$this->registrarBitacora("guardar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			
		}
	}
	
	function actualizar($fecha,$hora,$idusuario,$modulo,$accion,$descripcion,$idregistro,$tabla,$idbitacoracontrol){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['bitacoracontrol']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			
				if(mysql_query("UPDATE bitacoracontrol SET fecha='$fecha', hora='$hora', idusuario='$idusuario', modulo='$modulo', accion='$accion', descripcion='$descripcion', idregistro='$idregistro', tabla='$tabla' WHERE idbitacoracontrol='$idbitacoracontrol'")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="modific&oacute; el registro ID: $idbitacoracontrol, de la tabla bitacoracontrol ";
						$this->registrarBitacora("modificar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			
		}
	}
	
	function bloquear($idbitacoracontrol){
		
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['bitacoracontrol']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			return mysql_query("UPDATE bitacoracontrol SET estatus ='bloqueado' WHERE idbitacoracontrol = '$idbitacoracontrol'");
		}
	}
	
	function cambiarEstatus($idbitacoracontrol,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['bitacoracontrol']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			if(mysql_query("UPDATE bitacoracontrol SET estatus ='$estatus' WHERE idbitacoracontrol = '$idbitacoracontrol'")){
				//BITACORA
				if ($_SESSION['bitacora']=="si"){
					$descripcionB="alter&oacute; el estatus del registro a: $estatus, de la tabla bitacoracontrol ";
					$this->registrarBitacora("modificar",$descripcionB);
				}
				return "exito";
			}else{
				return "fracaso";
			}
		}
	}
	
	function mostrarIndividual($idbitacoracontrol){
		if($this->con->conectar()==true){
			return mysql_query("SELECT * FROM bitacoracontrol WHERE idbitacoracontrol='$idbitacoracontrol'");
		}
	}
	
	function contar($condicion, $papelera, $idalmacen, $idusuario, $filtrarfecha="", $fechainicio="", $fechafin="", $clasificacion=""){
		$condicion= trim($condicion);
		$consultaFecha="";
		$consultaAlmacen="";
		$consultaClasificacion="";
		$consultaUsuario="";
		
		if ($filtrarfecha=="SI"){
			$consultaFecha=" AND bitacoracontrol.fecha >= '$fechainicio' AND bitacoracontrol.fecha <= '$fechafin' ";
		}
		if ($idusuario!=""){
			$consultaUsuario=" AND bitacoracontrol.idusuario='$idusuario'";
		}
		if ($idalmacen!=""){
			$consultaAlmacen=" AND bitacoracontrol.idalmacen='$idalmacen'";
		}
		if ($clasificacion!=""){
			$consultaClasificacion=" AND bitacoracontrol.accion='$clasificacion'";
		}
		
		$consultaCondicion="AND ((usuarios.nombre LIKE '%".$condicion."%') OR (bitacoracontrol.accion LIKE '%".$condicion."%'))";
		
		$where="WHERE bitacoracontrol.idbitacoracontrol <>'0' $consultaAlmacen $consultaUsuario $consultaFecha $consultaClasificacion $consultaCondicion";
		
		
		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT 
					bitacoracontrol.idbitacoracontrol,
					bitacoracontrol.fecha,
					bitacoracontrol.hora,
					bitacoracontrol.idusuario,
					bitacoracontrol.modulo,
					bitacoracontrol.accion,
					bitacoracontrol.descripcion,
					bitacoracontrol.idregistro,
					bitacoracontrol.tabla,
					usuarios.nombre AS nombreusuarios,
					almacenes.nombre AS nombrealmacen
					FROM bitacoracontrol 
					INNER JOIN usuarios ON bitacoracontrol.idusuario=usuarios.idusuario
					INNER JOIN almacenes ON bitacoracontrol.idalmacen=almacenes.idalmacen
					$where");
					
			//$extractor = mysql_fetch_array($resultado);
			$numero_filas=mysqli_num_rows($resultado);
			return $numero_filas;
		}
	}
	
	function mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera, $idalmacen, $idusuario, $filtrarfecha="", $fechainicio="", $fechafin="", $clasificacion=""){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['bitacoracontrol']['consultar'])){
			return "denegado";
			exit;
		}
		$consultaFecha="";
		$consultaAlmacen="";
		$consultaClasificacion="";
		$consultaUsuario="";
		
		if ($filtrarfecha=="SI"){
			$consultaFecha=" AND bitacoracontrol.fecha >= '$fechainicio' AND bitacoracontrol.fecha <= '$fechafin' ";
		}
		if ($idusuario!=""){
			$consultaUsuario=" AND bitacoracontrol.idusuario='$idusuario'";
		}
		if ($idalmacen!=""){
			$consultaAlmacen=" AND bitacoracontrol.idalmacen='$idalmacen'";
		}
		if ($clasificacion!=""){
			$consultaClasificacion=" AND bitacoracontrol.accion='$clasificacion'";
		}
		$consultaCondicion="AND ((usuarios.nombre LIKE '%".$condicion."%') OR (bitacoracontrol.accion LIKE '%".$condicion."%') OR (bitacoracontrol.idregistro LIKE '%".$condicion."%'))";
		$where="WHERE bitacoracontrol.idbitacoracontrol <> '0' $consultaAlmacen $consultaUsuario $consultaFecha $consultaClasificacion $consultaCondicion";
		
		$consulta = "SELECT 
					bitacoracontrol.idbitacoracontrol,
					bitacoracontrol.fecha,
					bitacoracontrol.hora,
					bitacoracontrol.idusuario,
					bitacoracontrol.modulo,
					bitacoracontrol.accion,
					bitacoracontrol.descripcion,
					bitacoracontrol.idregistro,
					bitacoracontrol.tabla,
					usuarios.nombre AS nombreusuarios,
					almacenes.nombre AS nombrealmacen
					FROM bitacoracontrol 
					INNER JOIN usuarios ON bitacoracontrol.idusuario=usuarios.idusuario
					INNER JOIN almacenes ON bitacoracontrol.idalmacen=almacenes.idalmacen
					$where
					ORDER BY $campoOrden $orden, bitacoracontrol.hora DESC
					LIMIT $inicial, $cantidadamostrar
					";
		if($this->con->conectar()==true){
			return $resultado=mysqli_query($this->con->conect,$consulta);
		}
	}
	function consultaGeneral($condicion){
		if($this->con->conectar()==true){
			return mysql_query("SELECT * FROM bitacoracontrol $condicion");
		}
	}
	
	function consultaLibre($condicion){
		if($this->con->conectar()==true){
			return mysql_query($condicion);
		}
	}
	
	function obtenerConfiguracion($campo){
		if($this->con->conectar()==true){
			$resultado=mysql_query("SELECT $campo FROM configuracion WHERE 1");
			if ($resultado){
				$extractor = mysql_fetch_array($resultado);
				$valorCampo=$extractor["$campo"];
				return $valorCampo;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	function obtenerCampo($idcampo, $valorCampo, $campo, $tabla){
		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT $campo FROM $tabla WHERE $idcampo='$valorCampo'");
			if ($resultado){
				$extractor = mysqli_fetch_array($resultado);
				$valorCampo=$extractor[0];
				return $valorCampo;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	function registrarBitacora($accion,$descripcion){
		$idusuario=$_SESSION['idusuario'];
		$usuario=$_SESSION['usuario'];
		$descripcion="El usuario $usuario ".$descripcion;
		$hora=date('H:i');
		$fecha=date('Y-m-d');
		$modulo="bitacoracontrol";
		mysql_query("INSERT INTO bitacora (hora,fecha,idusuario,modulo,accion,descripcion) VALUES ('$hora','$fecha','$idusuario','$modulo','$accion','$descripcion')");
	}
	
	function eliminar($ids, $tipoEliminacion){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['bitacoracontrol']['eliminar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			if ($tipoEliminacion=='falsa'){
				//REQUIERE CAMPO 'estatus' EN LA TABLA
				if (mysqli_query($this->con->conect,"UPDATE bitacoracontrol SET estatus ='eliminado' WHERE idbitacoracontrol IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; falsamente los registros: $ids, de la tabla bitacoracontrol ";
						$this->registrarBitacora("eliminarFalsa",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
			if ($tipoEliminacion=='real'){
				if(mysqli_query($this->con->conect,"DELETE FROM bitacoracontrol WHERE idbitacoracontrol IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; los registros: $ids, de la tabla bitacoracontrol ";
						$this->registrarBitacora("eliminar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
		}
	}
}
?>