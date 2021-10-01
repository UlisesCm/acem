<?php 
include_once("../../conexion/Conexion.class.php");

class Cuentacorreo{
 //constructor	
 	var $con;
 	function __construct(){
 		$this->con=new Conexion;
	}
	function armarConsulta($condicion,$papelera){
		if ($condicion!=""){
			if($papelera){
				$consulta="WHERE ((cuentascorreo.idcuentacorreo LIKE '%".$condicion."%') OR (cuentascorreo.usuario LIKE '%".$condicion."%'))AND cuentascorreo.estatus ='eliminado'";
			}else{
				$consulta="WHERE ((cuentascorreo.idcuentacorreo LIKE '%".$condicion."%') OR (cuentascorreo.usuario LIKE '%".$condicion."%'))AND cuentascorreo.estatus <>'eliminado'";
			}
		}else{
			if($papelera){
				$consulta="WHERE cuentascorreo.estatus ='eliminado'";
			}else{
				$consulta="WHERE cuentascorreo.estatus <>'eliminado'";
			}
		}
		return $consulta;
	}
	function comprobarCampo($campo, $valor, $tipoGuardado){
		if($this->con->conectar()==true){
			//print_r($listaCampos);
			$resultado=mysqli_query($this->con->conect,"SELECT COUNT( * ) AS contador from cuentascorreo WHERE $campo = '$valor'");
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

	function guardar($usuario,$contrasena,$servidorsmtp,$servidorpop,$puertosmtp,$puertopop,$autenticacionssl,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cuentascorreo']['guardar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		$idcuentacorreo=$this->con->generarClave(2); /*Sincronizacion 1 */
		
		if($this->con->conectar()==true){
			if($this->comprobarCampo("usuario",$usuario, "nuevo")){
				return "usuarioExiste";
			}else{
				if(mysqli_query($this->con->conect,"INSERT INTO cuentascorreo (idcuentacorreo, usuario, contrasena, servidorsmtp, servidorpop, puertosmtp, puertopop, autenticacionssl, estatus) VALUES ('$idcuentacorreo','$usuario','$contrasena','$servidorsmtp','$servidorpop','$puertosmtp','$puertopop','$autenticacionssl','$estatus')")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="agreg&oacute; un nuevo registro en la tabla cuentascorreo ";
						$this->registrarBitacora("guardar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
		}
	}
	
	function actualizar($usuario,$contrasena,$servidorsmtp,$servidorpop,$puertosmtp,$puertopop,$autenticacionssl,$estatus,$idcuentacorreo){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cuentascorreo']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			if($this->comprobarCampo("usuario",$usuario, "modificar")){
				return "usuarioExiste";
			}else{
				if(mysqli_query($this->con->conect,"UPDATE cuentascorreo SET usuario='$usuario', contrasena='$contrasena', servidorsmtp='$servidorsmtp', servidorpop='$servidorpop', puertosmtp='$puertosmtp', puertopop='$puertopop', autenticacionssl='$autenticacionssl', estatus='$estatus' WHERE idcuentacorreo='$idcuentacorreo'")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="modific&oacute; el registro ID: $idcuentacorreo, de la tabla cuentascorreo ";
						$this->registrarBitacora("modificar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
		}
	}
	
	function bloquear($idcuentacorreo){
		
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cuentascorreo']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			return mysqli_query($this->con->conect,"UPDATE cuentascorreo SET estatus ='bloqueado' WHERE idcuentacorreo = '$idcuentacorreo'");
		}
	}
	
	function cambiarEstatus($idcuentacorreo,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cuentascorreo']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			if(mysqli_query($this->con->conect,"UPDATE cuentascorreo SET estatus ='$estatus' WHERE idcuentacorreo = '$idcuentacorreo'")){
				//BITACORA
				if ($_SESSION['bitacora']=="si"){
					$descripcionB="alter&oacute; el estatus del registro a: $estatus, de la tabla cuentascorreo ";
					$this->registrarBitacora("modificar",$descripcionB);
				}
				return "exito";
			}else{
				return "fracaso";
			}
		}
	}
	
	function mostrarIndividual($idcuentacorreo){
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,"SELECT * FROM cuentascorreo WHERE idcuentacorreo='$idcuentacorreo'");
		}
	}
	
	function contar($condicion, $papelera){
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT 
					cuentascorreo.idcuentacorreo,
					cuentascorreo.usuario,
					cuentascorreo.contrasena,
					cuentascorreo.servidorsmtp,
					cuentascorreo.servidorpop,
					cuentascorreo.puertosmtp,
					cuentascorreo.puertopop,
					cuentascorreo.autenticacionssl,
					cuentascorreo.estatus
					FROM cuentascorreo 
					$where");
					
			//$extractor = mysqli_fetch_array($resultado);
			$numero_filas=mysqli_num_rows($resultado);
			return $numero_filas;
		}
	}
	
	function mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cuentascorreo']['consultar'])){
			return "denegado";
			exit;
		}
		
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		$consulta = "SELECT 
					cuentascorreo.idcuentacorreo,
					cuentascorreo.usuario,
					cuentascorreo.contrasena,
					cuentascorreo.servidorsmtp,
					cuentascorreo.servidorpop,
					cuentascorreo.puertosmtp,
					cuentascorreo.puertopop,
					cuentascorreo.autenticacionssl,
					cuentascorreo.estatus
					FROM cuentascorreo 
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
			return mysqli_query($this->con->conect,"SELECT * FROM cuentascorreo $condicion");
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
		$modulo="cuentascorreo";
		mysqli_query($this->con->conect,"INSERT INTO bitacora (hora,fecha,idusuario,modulo,accion,descripcion,idcontrol,tablacontrol,clasificacion,extra) VALUES ('$hora','$fecha','$idusuario','$modulo','$accion','$descripcion')");
	}
	
	function eliminar($ids, $tipoEliminacion){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cuentascorreo']['eliminar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			if ($tipoEliminacion=='falsa'){
				//REQUIERE CAMPO 'estatus' EN LA TABLA
				if (mysqli_query($this->con->conect,"UPDATE cuentascorreo SET estatus ='eliminado' WHERE idcuentacorreo IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; falsamente los registros: $ids, de la tabla cuentascorreo ";
						$this->registrarBitacora("eliminarFalsa",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
			if ($tipoEliminacion=='real'){
				if(mysqli_query($this->con->conect,"DELETE FROM cuentascorreo WHERE idcuentacorreo IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; los registros: $ids, de la tabla cuentascorreo ";
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