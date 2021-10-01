<?php 
include_once("../../conexion/Conexion.class.php");

class Cuentasbancarias{
 //constructor	
 	var $con;
 	function __construct(){
 		$this->con=new Conexion;
	}
	function armarConsulta($condicion,$papelera){
		if ($condicion!=""){
			if($papelera){
				$consulta="WHERE ((cuentasbancarias.cuenta LIKE '%".$condicion."%') OR (cuentasbancarias.banco LIKE '%".$condicion."%') OR (cuentasbancarias.saldo LIKE '%".$condicion."%'))AND cuentasbancarias.estatus ='eliminado'";
			}else{
				$consulta="WHERE ((cuentasbancarias.cuenta LIKE '%".$condicion."%') OR (cuentasbancarias.banco LIKE '%".$condicion."%') OR (cuentasbancarias.saldo LIKE '%".$condicion."%'))AND cuentasbancarias.estatus <>'eliminado'";
			}
		}else{
			if($papelera){
				$consulta="WHERE cuentasbancarias.estatus ='eliminado'";
			}else{
				$consulta="WHERE cuentasbancarias.estatus <>'eliminado'";
			}
		}
		return $consulta;
	}
	function comprobarCampo($campo, $valor, $tipoGuardado){
		if($this->con->conectar()==true){
			//print_r($listaCampos);
			$resultado=mysqli_query($this->con->conect,"SELECT COUNT( * ) AS contador from cuentasbancarias WHERE $campo = '$valor'");
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

	function guardar($cuenta,$banco,$saldo,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cuentasbancarias']['guardar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		$idcuenta=$this->con->generarClave(2); /*Sincronizacion 1 */
		
		if($this->con->conectar()==true){
			
				if(mysqli_query($this->con->conect,"INSERT INTO cuentasbancarias (idcuenta, cuenta, banco, saldo, estatus) VALUES ('$idcuenta','$cuenta','$banco','$saldo','$estatus')")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="agreg&oacute; un nuevo registro en la tabla cuentasbancarias ";
						$this->registrarBitacora("guardar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			
		}
	}
	
	function actualizar($cuenta,$banco,$saldo,$estatus,$idcuenta){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cuentasbancarias']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			
				if(mysqli_query($this->con->conect,"UPDATE cuentasbancarias SET cuenta='$cuenta', banco='$banco', saldo='$saldo', estatus='$estatus' WHERE idcuenta='$idcuenta'")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="modific&oacute; el registro ID: $idcuenta, de la tabla cuentasbancarias ";
						$this->registrarBitacora("modificar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			
		}
	}
	
	function bloquear($idcuenta){
		
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cuentasbancarias']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			return mysqli_query($this->con->conect,"UPDATE cuentasbancarias SET estatus ='bloqueado' WHERE idcuenta = '$idcuenta'");
		}
	}
	
	function cambiarEstatus($idcuenta,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cuentasbancarias']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			if(mysqli_query($this->con->conect,"UPDATE cuentasbancarias SET estatus ='$estatus' WHERE idcuenta = '$idcuenta'")){
				//BITACORA
				if ($_SESSION['bitacora']=="si"){
					$descripcionB="alter&oacute; el estatus del registro a: $estatus, de la tabla cuentasbancarias ";
					$this->registrarBitacora("modificar",$descripcionB);
				}
				return "exito";
			}else{
				return "fracaso";
			}
		}
	}
	
	function mostrarIndividual($idcuenta){
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,"SELECT * FROM cuentasbancarias WHERE idcuenta='$idcuenta'");
		}
	}
	
	function contar($condicion, $papelera){
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT 
					cuentasbancarias.idcuenta,
					cuentasbancarias.cuenta,
					cuentasbancarias.banco,
					cuentasbancarias.saldo,
					cuentasbancarias.estatus
					FROM cuentasbancarias 
					$where");
					
			//$extractor = mysqli_fetch_array($resultado);
			$numero_filas=mysqli_num_rows($resultado);
			return $numero_filas;
		}
	}
	
	function mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cuentasbancarias']['consultar'])){
			return "denegado";
			exit;
		}
		
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		$consulta = "SELECT 
					cuentasbancarias.idcuenta,
					cuentasbancarias.cuenta,
					cuentasbancarias.banco,
					cuentasbancarias.saldo,
					cuentasbancarias.estatus
					FROM cuentasbancarias 
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
			return mysqli_query($this->con->conect,"SELECT * FROM cuentasbancarias $condicion");
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
		$modulo="cuentasbancarias";
		mysqli_query($this->con->conect,"INSERT INTO bitacora (hora,fecha,idusuario,modulo,accion,descripcion,idcontrol,tablacontrol,clasificacion,extra) VALUES ('$hora','$fecha','$idusuario','$modulo','$accion','$descripcion')");
	}
	
	function eliminar($ids, $tipoEliminacion){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cuentasbancarias']['eliminar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			if ($tipoEliminacion=='falsa'){
				//REQUIERE CAMPO 'estatus' EN LA TABLA
				if (mysqli_query($this->con->conect,"UPDATE cuentasbancarias SET estatus ='eliminado' WHERE idcuenta IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; falsamente los registros: $ids, de la tabla cuentasbancarias ";
						$this->registrarBitacora("eliminarFalsa",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
			if ($tipoEliminacion=='real'){
				if(mysqli_query($this->con->conect,"DELETE FROM cuentasbancarias WHERE idcuenta IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; los registros: $ids, de la tabla cuentasbancarias ";
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