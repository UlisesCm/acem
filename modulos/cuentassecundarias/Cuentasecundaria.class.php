<?php 
include_once("../../conexion/Conexion.class.php");

class Cuentasecundaria{
 //constructor	
 	var $con;
 	function __construct(){
 		$this->con=new Conexion;
	}
	function armarConsulta($condicion,$papelera){
		if ($condicion!=""){
			if($papelera){
				$consulta="WHERE ((cuentassecundarias.nombre LIKE '%".$condicion."%')) AND cuentassecundarias.estatus ='eliminado'";
			}else{
				$consulta="WHERE ((cuentassecundarias.nombre LIKE '%".$condicion."%')) AND cuentassecundarias.estatus <>'eliminado'";
			}
		}else{
			if($papelera){
				$consulta="WHERE cuentassecundarias.estatus ='eliminado'";
			}else{
				$consulta="WHERE cuentassecundarias.estatus <>'eliminado'";
			}
		}
		return $consulta;
	}
	function comprobarCampo($campo, $valor, $tipoGuardado){
		if($this->con->conectar()==true){
			//print_r($listaCampos);
			$resultado=mysqli_query($this->con->conect,"SELECT COUNT( * ) AS contador from cuentassecundarias WHERE $campo = '$valor'");
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

	function guardar($nombre,$idcuentaprincipal,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cuentassecundarias']['guardar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		$idcuentasecundaria=$this->con->generarClave(2); /*Sincronizacion 1 */
		
		if($this->con->conectar()==true){
			if($this->comprobarCampo("nombre",$nombre, "nuevo")){
				return "nombreExiste";
			}else{
				$varConsulta ="INSERT INTO cuentassecundarias (idcuentasecundaria, nombre, idcuentaprincipal, estatus) VALUES ('$idcuentasecundaria','$nombre','$idcuentaprincipal','$estatus')";
				//echo $varConsulta;
				if(mysqli_query($this->con->conect,$varConsulta)){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="agreg&oacute; un nuevo registro en la tabla cuentassecundarias ";
						$this->registrarBitacora("guardar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
		}
	}
	
	function actualizar($nombre,$idcuentaprincipal,$estatus,$idcuentasecundaria){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cuentassecundarias']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			if($this->comprobarCampo("nombre",$nombre, "modificar")){
				return "nombreExiste";
			}else{
				if(mysqli_query($this->con->conect,"UPDATE cuentassecundarias SET nombre='$nombre', idcuentaprincipal='$idcuentaprincipal', estatus='$estatus' WHERE idcuentasecundaria='$idcuentasecundaria'")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="modific&oacute; el registro ID: $idcuentasecundaria, de la tabla cuentassecundarias ";
						$this->registrarBitacora("modificar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
		}
	}
	
	function bloquear($idcuentasecundaria){
		
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cuentassecundarias']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			return mysqli_query($this->con->conect,"UPDATE cuentassecundarias SET estatus ='bloqueado' WHERE idcuentasecundaria = '$idcuentasecundaria'");
		}
	}
	
	function cambiarEstatus($idcuentasecundaria,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cuentassecundarias']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			if(mysqli_query($this->con->conect,"UPDATE cuentassecundarias SET estatus ='$estatus' WHERE idcuentasecundaria = '$idcuentasecundaria'")){
				//BITACORA
				if ($_SESSION['bitacora']=="si"){
					$descripcionB="alter&oacute; el estatus del registro a: $estatus, de la tabla cuentassecundarias ";
					$this->registrarBitacora("modificar",$descripcionB);
				}
				return "exito";
			}else{
				return "fracaso";
			}
		}
	}
	
	function mostrarIndividual($idcuentasecundaria){
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,"SELECT * FROM cuentassecundarias WHERE idcuentasecundaria='$idcuentasecundaria'");
		}
	}
	
	function contar($condicion, $papelera){
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT 
					cuentassecundarias.idcuentasecundaria,
					cuentassecundarias.nombre,
					cuentassecundarias.idcuentaprincipal,
					cuentassecundarias.estatus,
					cuentasprincipales.nombre AS nombrecuentasprincipales,
					cuentasprincipales.tipo AS tipocuentasprincipales
					FROM cuentassecundarias 
					INNER JOIN cuentasprincipales ON cuentassecundarias.idcuentaprincipal=cuentasprincipales.idcuentaprincipal
					$where");
					
			//$extractor = mysqli_fetch_array($resultado);
			$numero_filas=mysqli_num_rows($resultado);
			return $numero_filas;
		}
	}
	
	function mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cuentassecundarias']['consultar'])){
			return "denegado";
			exit;
		}
		
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		$consulta = "SELECT 
					cuentassecundarias.idcuentasecundaria,
					cuentassecundarias.nombre,
					cuentassecundarias.idcuentaprincipal,
					cuentassecundarias.estatus,
					cuentasprincipales.nombre AS nombrecuentasprincipales,
					cuentasprincipales.tipo AS tipocuentasprincipales
					FROM cuentassecundarias 
					INNER JOIN cuentasprincipales ON cuentassecundarias.idcuentaprincipal=cuentasprincipales.idcuentaprincipal
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
			return mysqli_query($this->con->conect,"SELECT * FROM cuentassecundarias $condicion");
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
		$modulo="cuentassecundarias";
		mysqli_query($this->con->conect,"INSERT INTO bitacora (hora,fecha,idusuario,modulo,accion,descripcion,idcontrol,tablacontrol,clasificacion,extra) VALUES ('$hora','$fecha','$idusuario','$modulo','$accion','$descripcion')");
	}
	
	function eliminar($ids, $tipoEliminacion){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cuentassecundarias']['eliminar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			if ($tipoEliminacion=='falsa'){
				//REQUIERE CAMPO 'estatus' EN LA TABLA
				if (mysqli_query($this->con->conect,"UPDATE cuentassecundarias SET estatus ='eliminado' WHERE idcuentasecundaria IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; falsamente los registros: $ids, de la tabla cuentassecundarias ";
						$this->registrarBitacora("eliminarFalsa",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
			if ($tipoEliminacion=='real'){
				if(mysqli_query($this->con->conect,"DELETE FROM cuentassecundarias WHERE idcuentasecundaria IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; los registros: $ids, de la tabla cuentassecundarias ";
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