<?php 
include_once("../../conexion/Conexion.class.php");

class Usuario{
 //constructor	
 	var $con;
 	function __construct(){
 		$this->con=new Conexion;
	}
	function armarConsulta($condicion,$papelera){
		if ($condicion!=""){
			$consulta="WHERE ((usuarios.nombre LIKE '%".$condicion."%') OR (usuarios.usuario LIKE '%".$condicion."%'))AND usuarios.idusuario <>'0'";
		}else{
			$consulta="WHERE usuarios.idusuario <>'0'";
		}
		return $consulta;
	}function comprobarCampo($campo, $valor, $tipoGuardado){
		if($this->con->conectar()==true){
			//print_r($listaCampos);
			$resultado=mysqli_query($this->con->conect,"SELECT COUNT( * ) AS contador from usuarios WHERE $campo = '$valor'");
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

	function guardar($nombre,$email,$foto,$usuario,$contrasena,$estado,$idperfil,$empresa,$controlaracceso,$horainicio,$horafin,$idregistrorelacionado,$tablarelacionada,$bitacora,$idsucursal){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['usuarios']['guardar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		$idusuario=$this->con->generarClave(2); /*Sincronizacion 1 */
		
		if($this->con->conectar()==true){
			if($this->comprobarCampo("usuario",$usuario, "nuevo")){
				return "usuarioExiste";
			}else{
				if(mysqli_query($this->con->conect,"INSERT INTO usuarios (idusuario, nombre, email, foto, usuario, contrasena, estado, idperfil, empresa, controlaracceso, horainicio, horafin, idregistrorelacionado, tablarelacionada, bitacora,idsucursal) VALUES ('$idusuario','$nombre','$email','$foto','$usuario','$contrasena','$estado','$idperfil','$empresa','$controlaracceso','$horainicio','$horafin','$idregistrorelacionado','$tablarelacionada','$bitacora','$idsucursal')")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="agreg&oacute; un nuevo registro en la tabla usuarios ";
						$this->registrarBitacora("guardar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
		}
	}
	
	function actualizar($nombre,$email,$foto,$usuario,$contrasena,$estado,$idperfil,$empresa,$controlaracceso,$horainicio,$horafin,$idregistrorelacionado,$tablarelacionada,$bitacora,$idusuario,$idsucursal){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['usuarios']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			if($this->comprobarCampo("usuario",$usuario, "modificar")){
				return "usuarioExiste";
			}else{
				if(mysqli_query($this->con->conect,"UPDATE usuarios SET nombre='$nombre', email='$email', foto='$foto', usuario='$usuario', contrasena='$contrasena', estado='$estado', idperfil='$idperfil', empresa='$empresa', controlaracceso='$controlaracceso', horainicio='$horainicio', horafin='$horafin', idregistrorelacionado='$idregistrorelacionado', tablarelacionada='$tablarelacionada', bitacora='$bitacora' , idsucursal='$idsucursal' WHERE idusuario='$idusuario'")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="modific&oacute; el registro ID: $idusuario, de la tabla usuarios ";
						$this->registrarBitacora("modificar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
		}
	}
	
	function modificarDatos($nombre,$email,$foto,$idusuario){

		if($this->con->conectar()==true){
			if(mysqli_query($this->con->conect,"UPDATE usuarios SET nombre='$nombre', email='$email', foto='$foto' WHERE idusuario='$idusuario'")){
				//BITACORA
				if ($_SESSION['bitacora']=="si"){
					$descripcionB="modific&oacute; sus datos: $idusuario, de la tabla usuarios ";
					$this->registrarBitacora("modificar",$descripcionB);
				}
				return "exito";
			}else{
				return "fracaso";
			}
		}
	}
	
	function modificarContrasena($contrasena1,$contrasena2,$idusuario){

		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT COUNT( * ) AS contador from usuarios WHERE contrasena='$contrasena1' AND idusuario='$idusuario'");
			if ($resultado){
				$extractor = mysqli_fetch_array($resultado);
				$numero_filas=$extractor["contador"];
				if ($numero_filas=="0"){
					return "errorCoincidencia";
				}else{
					if(mysqli_query($this->con->conect,"UPDATE usuarios SET contrasena='$contrasena2' WHERE idusuario='$idusuario'")){
						//BITACORA
						if ($_SESSION['bitacora']=="si"){
							$descripcionB="modific&oacute; su contrase&ntilde;a: $idusuario, de la tabla usuarios ";
							$this->registrarBitacora("modificar",$descripcionB);
						}
						return "exito";
					}else{
						return "fracaso";
					}
				}
				
			}else{
				return "errorCoincidencia";
			}
		}
	}
	
	function bloquear($id,$estado){
		if($this->con->conectar()==true){
			//print_r($campos);
			return mysqli_query($this->con->conect,"UPDATE usuarios SET estado ='$estado' WHERE idusuario = $id");
		}
	}
	
	function cambiarEstatus($idusuario,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['usuarios']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			if(mysqli_query($this->con->conect,"UPDATE usuarios SET estatus ='$estatus' WHERE idusuario = '$idusuario'")){
				//BITACORA
				if ($_SESSION['bitacora']=="si"){
					$descripcionB="alter&oacute; el estatus del registro a: $estatus, de la tabla usuarios ";
					$this->registrarBitacora("modificar",$descripcionB);
				}
				return "exito";
			}else{
				return "fracaso";
			}
		}
	}
	
	function mostrarIndividual($idusuario){
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,"SELECT * FROM usuarios WHERE idusuario='$idusuario'");
		}
	}
	
	function contar($condicion, $papelera){
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT 
					usuarios.idusuario,
					usuarios.nombre,
					usuarios.email,
					usuarios.foto,
					usuarios.usuario,
					usuarios.contrasena,
					usuarios.estado,
					usuarios.idperfil,
					usuarios.empresa,
					usuarios.controlaracceso,
					usuarios.horainicio,
					usuarios.horafin,
					usuarios.idregistrorelacionado,
					usuarios.tablarelacionada,
					usuarios.bitacora,
					perfiles.nombre AS nombreperfiles,
					perfiles.color AS colorperfiles
					FROM usuarios 
					INNER JOIN perfiles ON usuarios.idperfil=perfiles.idperfil
					$where");
					
			//$extractor = mysqli_fetch_array($resultado);
			$numero_filas=mysqli_num_rows($resultado);
			return $numero_filas;
		}
	}
	
	function mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['usuarios']['consultar'])){
			return "denegado";
			exit;
		}
		
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		$consulta = "SELECT 
					usuarios.idusuario,
					usuarios.nombre,
					usuarios.email,
					usuarios.foto,
					usuarios.usuario,
					usuarios.contrasena,
					usuarios.estado,
					usuarios.idperfil,
					usuarios.empresa,
					usuarios.controlaracceso,
					usuarios.horainicio,
					usuarios.horafin,
					usuarios.idregistrorelacionado,
					usuarios.tablarelacionada,
					usuarios.bitacora,
					perfiles.nombre AS nombreperfiles,
					perfiles.color AS colorperfiles,
					sucursales.nombre AS nombresucursal
					FROM usuarios 
					INNER JOIN perfiles ON usuarios.idperfil=perfiles.idperfil
					INNER JOIN sucursales ON usuarios.idsucursal=sucursales.idsucursal
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
			return mysqli_query($this->con->conect,"SELECT * FROM usuarios $condicion");
		}
	}
	
	function consultaLibre($condicion){
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,$condicion);
		}
	}
	
	function obtenerConfiguracion($campo){
		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT $campo FROM configuracion WHERE 1");
			if ($resultado){
				$extractor = mysqli_fetch_array($resultado);
				$valorCampo=$extractor["$campo"];
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
		$modulo="usuarios";
		mysqli_query($this->con->conect,"INSERT INTO bitacora (hora,fecha,idusuario,modulo,accion,descripcion) VALUES ('$hora','$fecha','$idusuario','$modulo','$accion','$descripcion')");
	}
	
	function eliminar($ids, $tipoEliminacion){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['usuarios']['eliminar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			if ($tipoEliminacion=='falsa'){
				//REQUIERE CAMPO 'estatus' EN LA TABLA
				if (mysqli_query($this->con->conect,"UPDATE usuarios SET estatus ='eliminado' WHERE idusuario IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; falsamente los registros: $ids, de la tabla usuarios ";
						$this->registrarBitacora("eliminarFalsa",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
			if ($tipoEliminacion=='real'){
				if(mysqli_query($this->con->conect,"DELETE FROM usuarios WHERE idusuario IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; los registros: $ids, de la tabla usuarios ";
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