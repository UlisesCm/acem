<?php 
include_once("../../conexion/Conexion.class.php");

class Folio{
 //constructor	
 	var $con;
 	function __construct(){
 		$this->con=new Conexion;
	}
	function armarConsulta($condicion,$papelera){
		if ($condicion!=""){
			if($papelera){
				$consulta="WHERE folios.estatus ='eliminado'";
			}else{
				$consulta="WHERE folios.estatus <>'eliminado'";
			}
		}else{
			if($papelera){
				$consulta="WHERE folios.estatus ='eliminado'";
			}else{
				$consulta="WHERE folios.estatus <>'eliminado'";
			}
		}
		return $consulta;
	}
	function comprobarCampo($idsucursal, $asignacion, $tipoGuardado){
		if($this->con->conectar()==true){
			//print_r($listaCampos);
			$resultado=mysqli_query($this->con->conect,"SELECT COUNT( * ) AS contador from sucursales WHERE idsucursal = '$idsucursal' AND asignacion = '$asignacion' ");
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
	
	function obtenerSerie($asignacion){
			if($this->con->conectar()==true){
				$idsucursal=$_SESSION["idsucursal"];
				$resultado=mysqli_query($this->con->conect,"SELECT serie FROM folios WHERE asignacion ='$asignacion' AND idsucursal = '$idsucursal' ");
				if ($resultado){
					$extractor = mysqli_fetch_array($resultado);
					$valorCampo=$extractor["serie"];
					return $valorCampo;
				}else{
					return false;
				}
			}else{
				return false;
			}
	}

	function obtenerFolio($asignacion){
			if($this->con->conectar()==true){
				$idsucursal=$_SESSION["idsucursal"];
				$resultado=mysqli_query($this->con->conect,"SELECT folioactual FROM folios WHERE asignacion ='$asignacion' AND idsucursal = '$idsucursal' ");
				if ($resultado){
					$extractor = mysqli_fetch_array($resultado);
					$valorCampo=$extractor["folioactual"];
					return $valorCampo;
				}else{
					return false;
				}
			}else{
				return false;
			}
	}

	function guardar($serie,$folioactual,$asignacion,$idsucursal,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['folios']['guardar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		$idfolio=$this->con->generarClave(2); /*Sincronizacion 1 */
		
		if($this->con->conectar()==true){
			if($this->comprobarCampo($idsucursal, $asignacion, "nuevo")){
				return "asignacionExiste";
			}else if($this->comprobarCampo("idsucursal",$idsucursal, "nuevo")){
				return "idsucursalExiste";
			}else{
				if(mysqli_query($this->con->conect,"INSERT INTO folios (idfolio, serie, folioactual, asignacion, idsucursal, estatus) VALUES ('$idfolio','$serie','$folioactual','$asignacion','$idsucursal','$estatus')")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="agreg&oacute; un nuevo registro en la tabla folios ";
						$this->registrarBitacora("guardar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
		}
	}
	
	function actualizar($serie,$folioactual,$asignacion,$idsucursal,$estatus,$idfolio){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['folios']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			if($this->comprobarCampo($idsucursal, $asignacion, "modificar")){
				return "asignacionExiste";
			}else if($this->comprobarCampo("idsucursal",$idsucursal, "modificar")){
				return "idsucursalExiste";
			}else{
				if(mysqli_query($this->con->conect,"UPDATE folios SET serie='$serie', folioactual='$folioactual', asignacion='$asignacion', idsucursal='$idsucursal', estatus='$estatus' WHERE idfolio='$idfolio'")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="modific&oacute; el registro ID: $idfolio, de la tabla folios ";
						$this->registrarBitacora("modificar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
		}
	}
	
	function bloquear($idfolio){
		
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['folios']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			return mysqli_query($this->con->conect,"UPDATE folios SET estatus ='bloqueado' WHERE idfolio = '$idfolio'");
		}
	}
	
	function cambiarEstatus($idfolio,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['folios']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			if(mysqli_query($this->con->conect,"UPDATE folios SET estatus ='$estatus' WHERE idfolio = '$idfolio'")){
				//BITACORA
				if ($_SESSION['bitacora']=="si"){
					$descripcionB="alter&oacute; el estatus del registro a: $estatus, de la tabla folios ";
					$this->registrarBitacora("modificar",$descripcionB);
				}
				return "exito";
			}else{
				return "fracaso";
			}
		}
	}
	
	function mostrarIndividual($idfolio){
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,"SELECT * FROM folios WHERE idfolio='$idfolio'");
		}
	}
	
	function contar($condicion, $papelera){
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT 
					folios.idfolio,
					folios.serie,
					folios.folioactual,
					folios.asignacion,
					folios.idsucursal,
					folios.estatus,
					sucursales.nombre AS nombresucursal,
					sucursales.idsucursal AS idsucursalsucursales
					FROM folios 
					INNER JOIN sucursales ON folios.idsucursal=sucursales.idsucursal
					$where");
					
			//$extractor = mysqli_fetch_array($resultado);
			$numero_filas=mysqli_num_rows($resultado);
			return $numero_filas;
		}
	}
	
	function mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['folios']['consultar'])){
			return "denegado";
			exit;
		}
		
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		$consulta = "SELECT 
					folios.idfolio,
					folios.serie,
					folios.folioactual,
					folios.asignacion,
					folios.idsucursal,
					folios.estatus,
					sucursales.nombre AS nombresucursal,
					sucursales.idsucursal AS idsucursalsucursales
					FROM folios 
					INNER JOIN sucursales ON folios.idsucursal=sucursales.idsucursal
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
			return mysqli_query($this->con->conect,"SELECT * FROM folios $condicion");
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
		$modulo="folios";
		mysqli_query($this->con->conect,"INSERT INTO bitacora (hora,fecha,idusuario,modulo,accion,descripcion,idcontrol,tablacontrol,clasificacion,extra) VALUES ('$hora','$fecha','$idusuario','$modulo','$accion','$descripcion')");
	}
	
	function eliminar($ids, $tipoEliminacion){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['folios']['eliminar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			if ($tipoEliminacion=='falsa'){
				//REQUIERE CAMPO 'estatus' EN LA TABLA
				if (mysqli_query($this->con->conect,"UPDATE folios SET estatus ='eliminado' WHERE idfolio IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; falsamente los registros: $ids, de la tabla folios ";
						$this->registrarBitacora("eliminarFalsa",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
			if ($tipoEliminacion=='real'){
				if(mysqli_query($this->con->conect,"DELETE FROM folios WHERE idfolio IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; los registros: $ids, de la tabla folios ";
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