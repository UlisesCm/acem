<?php
if (file_exists("../../conexion/Conexion.class.php")) {
    include_once("../../conexion/Conexion.class.php");
} else{
    include_once("../../modulos/conexion/Conexion.class.php");
}
class Perfil{
 //constructor	
 	var $con;
 	function __construct(){
 		$this->con=new Conexion;
	}
	function armarConsulta($condicion,$papelera){
		if ($condicion!=""){
			$consulta="WHERE ((perfiles.nombre LIKE '%".$condicion."%')) AND perfiles.idperfil <>'0'";
		}else{
			$consulta="WHERE perfiles.idperfil <>'0'";
		}
		return $consulta;
	}function comprobarCampo($campo, $valor, $tipoGuardado){
		if($this->con->conectar()==true){
			//print_r($listaCampos);
			$resultado=mysqli_query($this->con->conect,"SELECT COUNT( * ) AS contador from perfiles WHERE $campo = '$valor'");
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

	function guardar($nombre,$color){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['perfiles']['guardar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			if($this->comprobarCampo("nombre",$nombre, "nuevo")){
				return "nombreExiste";
			}else{
				$idperfil=$this->con->generarClave(2); /*Sincronizacion 1 */
				if(mysqli_query($this->con->conect,"INSERT INTO perfiles (idperfil, nombre, color) VALUES ('$idperfil','$nombre','$color')")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="agreg&oacute; un nuevo registro en la tabla perfiles ";
						$this->registrarBitacora("guardar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
		}
	}
	
	function actualizar($nombre,$color,$idperfil){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['perfiles']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			if($this->comprobarCampo("nombre",$nombre, "modificar")){
				return "nombreExiste";
			}else{
				if(mysqli_query($this->con->conect,"UPDATE perfiles SET nombre='$nombre', color='$color' WHERE idperfil='$idperfil'")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="modific&oacute; el registro ID: $idperfil, de la tabla perfiles ";
						$this->registrarBitacora("modificar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
		}
	}
	
	function bloquear($idperfil){
		
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['perfiles']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			return mysqli_query($this->con->conect,"UPDATE perfiles SET estatus ='bloqueado' WHERE idperfil = '$idperfil'");
		}
	}
	
	function cambiarEstatus($idperfil,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['perfiles']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			if(mysqli_query($this->con->conect,"UPDATE perfiles SET estatus ='$estatus' WHERE idperfil = '$idperfil'")){
				//BITACORA
				if ($_SESSION['bitacora']=="si"){
					$descripcionB="alter&oacute; el estatus del registro a: $estatus, de la tabla perfiles ";
					$this->registrarBitacora("modificar",$descripcionB);
				}
				return "exito";
			}else{
				return "fracaso";
			}
		}
	}
	
	function mostrarIndividual($idperfil){
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,"SELECT * FROM perfiles WHERE idperfil='$idperfil'");
		}
	}
	
	function contar($condicion, $papelera){
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT 
					perfiles.idperfil,
					perfiles.nombre,
					perfiles.color
					FROM perfiles 
					$where");
					
			//$extractor = mysqli_fetch_array($resultado);
			$numero_filas=mysqli_num_rows($resultado);
			return $numero_filas;
		}
	}
	
	function mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['perfiles']['consultar'])){
			return "denegado";
			exit;
		}
		
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		$consulta = "SELECT 
					perfiles.idperfil,
					perfiles.nombre,
					perfiles.color
					FROM perfiles 
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
			return mysqli_query($this->con->conect,"SELECT * FROM perfiles $condicion");
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
		$modulo="perfiles";
		mysqli_query($this->con->conect,"INSERT INTO bitacora (hora,fecha,idusuario,modulo,accion,descripcion) VALUES ('$hora','$fecha','$idusuario','$modulo','$accion','$descripcion')");
	}
	
	function eliminar($ids, $tipoEliminacion){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['perfiles']['eliminar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			if ($tipoEliminacion=='falsa'){
				//REQUIERE CAMPO 'estatus' EN LA TABLA
				if (mysqli_query($this->con->conect,"UPDATE perfiles SET estatus ='eliminado' WHERE idperfil IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; falsamente los registros: $ids, de la tabla perfiles ";
						$this->registrarBitacora("eliminarFalsa",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
			if ($tipoEliminacion=='real'){
				if(mysqli_query($this->con->conect,"DELETE FROM perfiles WHERE idperfil IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; los registros: $ids, de la tabla perfiles ";
						$this->registrarBitacora("eliminar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
		}
	}
	
	function actualizarPermisos($idperfil, $permiso){
		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT COUNT(*) AS contador from permisos WHERE idperfil = '$idperfil'");
			if ($resultado){
				$extractor = mysqli_fetch_array($resultado);
				$numero_filas=$extractor["contador"];
				if ($numero_filas=="0"){
					//Nuevo
					$idpermiso=$this->con->generarClave(2); /*Sincronizacion 1 */
					if (mysqli_query($this->con->conect,"INSERT INTO permisos (idpermiso, permiso, idperfil) VALUES ('$idpermiso','$permiso','$idperfil')")){
						return "exito";
					}else{
						return "fracaso";
					}
				}else{
					//Actualizar
					if (mysqli_query($this->con->conect,"UPDATE permisos SET permiso ='$permiso' WHERE idperfil IN ($idperfil)")){
						return "exito";
					}else{
						return "fracaso";
					}
				}
				
			}else{
				return false;
			}
		}
	}
	
	function recuperarPermisosLogin($idperfil){
		if($this->con->conectar()==true){
			//print_r($campos);
			$filas=mysqli_query($this->con->conect,"SELECT count(*) as numero_filas from permisos WHERE idperfil  = '".$idperfil."'");
			$extractor = mysqli_fetch_array($filas);
			$numero_filas=$extractor['numero_filas'];
			if ($numero_filas==0){
				return "";
			}else{
				$filas=mysqli_query($this->con->conect,"SELECT * from permisos WHERE idperfil  = '".$idperfil."'");
				$extractor = mysqli_fetch_array($filas);
				$cadena=$extractor['permiso'];
				
				$arreglo=explode("@",$cadena);
				$con=0;
				while ($con< count($arreglo)){
					$arreglo2=explode("|",$arreglo[$con]);
					$arregloEntidad=explode("/",$arreglo2[0]);
					
					
					$arreglo3=explode(",",$arreglo2[1]);
					
					$con2=0;
					while($con2<count($arreglo3)){
						
						$entidad=$arregloEntidad[0];
						$atributo=$arreglo3[$con2];
						
						$permiso[$entidad][$atributo]=$atributo;
						$con2++;
					}
					$con++;
				}
				return $permiso;
			}
			
		}
	}
	
	function recuperarPermisos($idperfil){
		if($this->con->conectar()==true){
			//print_r($campos);
			$filas=mysqli_query($this->con->conect,"SELECT count(*) as numero_filas from permisos WHERE idperfil  = '".$idperfil."'");
			$extractor = mysqli_fetch_array($filas);
			$numero_filas=$extractor['numero_filas'];
			if ($numero_filas==0){
				return "";
			}else{
				$filas=mysqli_query($this->con->conect,"SELECT * from permisos WHERE idperfil  = '".$idperfil."'");
				$extractor = mysqli_fetch_array($filas);
				$permiso=$extractor['permiso'];
				return $permiso;
			}
			
		}
	}
}
?>