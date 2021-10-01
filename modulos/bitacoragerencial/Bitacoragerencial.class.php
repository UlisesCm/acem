<?php 
include_once("../../conexion/Conexion.class.php");

class Bitacoragerencial{
 //constructor	
 	var $con;
 	function __construct(){
 		$this->con=new Conexion;
	}
	function armarConsulta($condicion,$papelera){
		if ($condicion!=""){
			if($papelera){
				$consulta="WHERE ((bitacoragerencial.fecha LIKE '%".$condicion."%') OR (bitacoragerencial.evento LIKE '%".$condicion."%') OR (bitacoragerencial.idusuario LIKE '%".$condicion."%') OR (bitacoragerencial.idsucursal LIKE '%".$condicion."%'))AND bitacoragerencial.estatus ='eliminado'";
			}else{
				$consulta="WHERE ((bitacoragerencial.fecha LIKE '%".$condicion."%') OR (bitacoragerencial.evento LIKE '%".$condicion."%') OR (bitacoragerencial.idusuario LIKE '%".$condicion."%') OR (bitacoragerencial.idsucursal LIKE '%".$condicion."%'))AND bitacoragerencial.estatus <>'eliminado'";
			}
		}else{
			if($papelera){
				$consulta="WHERE bitacoragerencial.estatus ='eliminado'";
			}else{
				$consulta="WHERE bitacoragerencial.estatus <>'eliminado'";
			}
		}
		return $consulta;
	}
	function comprobarCampo($campo, $valor, $tipoGuardado){
		if($this->con->conectar()==true){
			//print_r($listaCampos);
			$resultado=mysqli_query($this->con->conect,"SELECT COUNT( * ) AS contador from bitacoragerencial WHERE $campo = '$valor'");
			if ($resultado){
				$extractor = mysqli_fetch_array($resultado);
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

	function guardar($fecha,$evento,$idusuario,$idsucursal,$archivo,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['bitacoragerencial']['guardar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		$idbitacoragerencial=$this->con->generarClave(2); /*Sincronizacion 1 */
		
		if($this->con->conectar()==true){
			
				if(mysqli_query($this->con->conect,"INSERT INTO bitacoragerencial (idbitacoragerencial, fecha, evento, idusuario, idsucursal, archivo, estatus) VALUES ('$idbitacoragerencial','$fecha','$evento','$idusuario','$idsucursal','$archivo','$estatus')")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="agreg&oacute; un nuevo registro en la tabla bitacoragerencial ";
						$this->registrarBitacora("guardar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			
		}
	}
	
	function actualizar($fecha,$evento,$idusuario,$idsucursal,$archivo,$estatus,$idbitacoragerencial){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['bitacoragerencial']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			
				if(mysqli_query($this->con->conect,"UPDATE bitacoragerencial SET fecha='$fecha', evento='$evento', idusuario='$idusuario', idsucursal='$idsucursal', archivo='$archivo', estatus='$estatus' WHERE idbitacoragerencial='$idbitacoragerencial'")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="modific&oacute; el registro ID: $idbitacoragerencial, de la tabla bitacoragerencial ";
						$this->registrarBitacora("modificar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			
		}
	}
	
	function bloquear($idbitacoragerencial){
		
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['bitacoragerencial']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			return mysqli_query($this->con->conect,"UPDATE bitacoragerencial SET estatus ='bloqueado' WHERE idbitacoragerencial = '$idbitacoragerencial'");
		}
	}
	
	function cambiarEstatus($idbitacoragerencial,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['bitacoragerencial']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			if(mysqli_query($this->con->conect,"UPDATE bitacoragerencial SET estatus ='$estatus' WHERE idbitacoragerencial = '$idbitacoragerencial'")){
				//BITACORA
				if ($_SESSION['bitacora']=="si"){
					$descripcionB="alter&oacute; el estatus del registro a: $estatus, de la tabla bitacoragerencial ";
					$this->registrarBitacora("modificar",$descripcionB);
				}
				return "exito";
			}else{
				return "fracaso";
			}
		}
	}
	
	function mostrarIndividual($idbitacoragerencial){
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,"SELECT * FROM bitacoragerencial WHERE idbitacoragerencial='$idbitacoragerencial'");
		}
	}
	
	function contar($condicion, $papelera){
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT 
					bitacoragerencial.idbitacoragerencial,
					bitacoragerencial.fecha,
					bitacoragerencial.evento,
					bitacoragerencial.idusuario,
					bitacoragerencial.idsucursal,
					bitacoragerencial.archivo,
					bitacoragerencial.estatus,
					usuarios.idusuario AS idusuariousuarios,
					sucursales.idsucursal AS idsucursalsucursales
					FROM bitacoragerencial 
					INNER JOIN usuarios ON bitacoragerencial.idusuario=usuarios.idusuario
					INNER JOIN sucursales ON bitacoragerencial.idsucursal=sucursales.idsucursal
					$where");
					
			//$extractor = mysqli_fetch_array($resultado);
			$numero_filas=mysqli_num_rows($resultado);
			return $numero_filas;
		}
	}
	
	function mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['bitacoragerencial']['consultar'])){
			return "denegado";
			exit;
		}
		
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		$consulta = "SELECT 
					bitacoragerencial.idbitacoragerencial,
					bitacoragerencial.fecha,
					bitacoragerencial.evento,
					bitacoragerencial.idusuario,
					bitacoragerencial.idsucursal,
					bitacoragerencial.archivo,
					bitacoragerencial.estatus,
					usuarios.nombre AS nombreusuario,
					sucursales.nombre AS nombresucursal
					FROM bitacoragerencial 
					INNER JOIN usuarios ON bitacoragerencial.idusuario=usuarios.idusuario
					INNER JOIN sucursales ON bitacoragerencial.idsucursal=sucursales.idsucursal
					$where
					ORDER BY $campoOrden $orden
					LIMIT $inicial, $cantidadamostrar
					";
		if($this->con->conectar()==true){
			return $resultado=mysqli_query($this->con->conect,$consulta);
		}
	}
	function consultaGeneral($condicion){
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,"SELECT * FROM bitacoragerencial $condicion");
		}
	}
	
	function consultaLibre($condicion){
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,$condicion);
		}
	}
	
	function obtenerConfiguracion($campo){
		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT $campo FROM configuracion WHERE concepto='$campo' ");
			if ($resultado){
				$extractor = mysqli_fetch_array($resultado);
				$valorCampo=$extractor["valor"];
				return $valorCampo;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	function registrarBitacora($accion,$descripcion,$idcontrol="",$tablacontrol="",$clasificacion="",$extra=""){
		$idusuario=$_SESSION['idusuario'];
		$usuario=$_SESSION['usuario'];
		$descripcion="El usuario $usuario ".$descripcion;
		$hora=date('H:i');
		$fecha=date('Y-m-d');
		$modulo="bitacoragerencial";
		mysqli_query($this->con->conect,"INSERT INTO bitacora (hora,fecha,idusuario,modulo,accion,descripcion,idcontrol,tablacontrol,clasificacion,extra) VALUES ('$hora','$fecha','$idusuario','$modulo','$accion','$descripcion')");
	}
	
	function eliminar($ids, $tipoEliminacion){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['bitacoragerencial']['eliminar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			if ($tipoEliminacion=='falsa'){
				//REQUIERE CAMPO 'estatus' EN LA TABLA
				if (mysqli_query($this->con->conect,"UPDATE bitacoragerencial SET estatus ='eliminado' WHERE idbitacoragerencial IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; falsamente los registros: $ids, de la tabla bitacoragerencial ";
						$this->registrarBitacora("eliminarFalsa",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
			if ($tipoEliminacion=='real'){
				if(mysqli_query($this->con->conect,"DELETE FROM bitacoragerencial WHERE idbitacoragerencial IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; los registros: $ids, de la tabla bitacoragerencial ";
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