<?php 
include_once("../../conexion/Conexion.class.php");

class Configuracion{
 //constructor	
 	var $con;
 	function __construct(){
 		$this->con=new Conexion;
	}
	function armarConsulta($condicion,$papelera){
		if ($condicion!=""){
			$consulta="WHERE configuracion.idconfiguracion <>'0'";
		}else{
			$consulta="WHERE configuracion.idconfiguracion <>'0'";
		}
		return $consulta;
	}function comprobarCampo($campo, $valor, $tipoGuardado){
		if($this->con->conectar()==true){
			//print_r($listaCampos);
			$resultado=mysqli_query($this->con->conect,"SELECT COUNT( * ) AS contador from configuracion WHERE $campo = '$valor'");
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

	function guardar($cabeceraimpresion,$pieimpresion,$separadorimpresion,$descripcioncompletaimpresion){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['configuracion']['guardar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			
				if(mysqli_query($this->con->conect,"INSERT INTO configuracion ( cabeceraimpresion, pieimpresion, separadorimpresion, descripcioncompletaimpresion) VALUES ('$cabeceraimpresion','$pieimpresion','$separadorimpresion','$descripcioncompletaimpresion')")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="agreg&oacute; un nuevo registro en la tabla configuracion ";
						$this->registrarBitacora("guardar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			
		}
	}
	
	function actualizar($cabeceraimpresion,$pieimpresion,$separadorimpresion,$descripcioncompletaimpresion,$tipoempresa,$logoticket,$nombreproducticket,$modeloticket,$generoticket,$cbticket,$mostrarlogo,$idconfiguracion){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['configuracion']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			
				if(mysqli_query($this->con->conect,"UPDATE configuracion SET cabeceraimpresion='$cabeceraimpresion', pieimpresion='$pieimpresion', separadorimpresion='$separadorimpresion', descripcioncompletaimpresion='$descripcioncompletaimpresion', tipoempresa='$tipoempresa', logoticket='$logoticket', nombreproducticket='$nombreproducticket', modeloticket='$modeloticket', generoticket='$generoticket', cbticket='$cbticket', mostrarlogo='$mostrarlogo' WHERE idconfiguracion='$idconfiguracion'")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="modific&oacute; el registro ID: $idconfiguracion, de la tabla configuracion ";
						$this->registrarBitacora("modificar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			
		}
	}
	
	function bloquear($idconfiguracion){
		
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['configuracion']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			return mysqli_query($this->con->conect,"UPDATE configuracion SET estatus ='bloqueado' WHERE idconfiguracion = '$idconfiguracion'");
		}
	}
	
	function cambiarEstatus($idconfiguracion,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['configuracion']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			if(mysqli_query($this->con->conect,"UPDATE configuracion SET estatus ='$estatus' WHERE idconfiguracion = '$idconfiguracion'")){
				//BITACORA
				if ($_SESSION['bitacora']=="si"){
					$descripcionB="alter&oacute; el estatus del registro a: $estatus, de la tabla configuracion ";
					$this->registrarBitacora("modificar",$descripcionB);
				}
				return "exito";
			}else{
				return "fracaso";
			}
		}
	}
	
	function mostrarIndividual($idconfiguracion){
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,"SELECT * FROM configuracion WHERE idconfiguracion='$idconfiguracion'");
		}
	}
	
	function contar($condicion, $papelera){
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT 
					configuracion.idconfiguracion,
					configuracion.cabeceraimpresion,
					configuracion.pieimpresion,
					configuracion.separadorimpresion,
					configuracion.descripcioncompletaimpresion
					FROM configuracion 
					$where");
					
			//$extractor = mysqli_fetch_array($resultado);
			$numero_filas=mysqli_num_rows($resultado);
			return $numero_filas;
		}
	}
	
	function mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['configuracion']['consultar'])){
			return "denegado";
			exit;
		}
		
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		$consulta = "SELECT 
					configuracion.idconfiguracion,
					configuracion.cabeceraimpresion,
					configuracion.pieimpresion,
					configuracion.separadorimpresion,
					configuracion.descripcioncompletaimpresion
					FROM configuracion 
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
			return mysqli_query($this->con->conect,"SELECT * FROM configuracion $condicion");
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
		$modulo="configuracion";
		mysqli_query($this->con->conect,"INSERT INTO bitacora (hora,fecha,idusuario,modulo,accion,descripcion) VALUES ('$hora','$fecha','$idusuario','$modulo','$accion','$descripcion')");
	}
	
	function eliminar($ids, $tipoEliminacion){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['configuracion']['eliminar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			if ($tipoEliminacion=='falsa'){
				//REQUIERE CAMPO 'estatus' EN LA TABLA
				if (mysqli_query($this->con->conect,"UPDATE configuracion SET estatus ='eliminado' WHERE idconfiguracion IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; falsamente los registros: $ids, de la tabla configuracion ";
						$this->registrarBitacora("eliminarFalsa",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
			if ($tipoEliminacion=='real'){
				if(mysqli_query($this->con->conect,"DELETE FROM configuracion WHERE idconfiguracion IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; los registros: $ids, de la tabla configuracion ";
						$this->registrarBitacora("eliminar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
		}
	}
	
	
	function sincronizar($idalmacen){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['configuracion']['sincronizar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			if ($this->detenerTriggers()=="exito"){
						if($this->con->conectar()==true){
							$resultado=mysqli_query($this->con->conect,"SELECT * FROM sinc WHERE estado='pendiente'");
						}
						if ($resultado){
							while ($filas=mysqli_fetch_array($resultado)) {
								$sentencia=$filas['sentencia'];
								echo $sentencia."</br>";
							}
							return "exito";
						}else{
							return "fracaso".$resultado2;
						}
					
				
			}else{
				return "fracasoDetenerTriggers";
			}
				
			
		}
	}
	
	
	
	function detenerTriggers(){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['configuracion']['sincronizar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
				$consulta="DROP TRIGGER IF EXISTS `actualizaralmacenes`;
DROP TRIGGER IF EXISTS `eliminaralmacenes`;
DROP TRIGGER IF EXISTS `nuevoalmacenes`;
DROP TRIGGER IF EXISTS `actualizarcaja`;
DROP TRIGGER IF EXISTS `eliminarcaja`;
DROP TRIGGER IF EXISTS `nuevocaja`;
DROP TRIGGER IF EXISTS `actualizarcaptacion`;
DROP TRIGGER IF EXISTS `eliminarcaptacion`;
DROP TRIGGER IF EXISTS `nuevocaptacion`;
DROP TRIGGER IF EXISTS `actualizarcategorias`;
DROP TRIGGER IF EXISTS `eliminarcategorias`;
DROP TRIGGER IF EXISTS `nuevocategorias`;
DROP TRIGGER IF EXISTS `actualizarclientes`;
DROP TRIGGER IF EXISTS `eliminarclientes`;
DROP TRIGGER IF EXISTS `nuevoclientes`;
DROP TRIGGER IF EXISTS `actualizarconcentrados`;
DROP TRIGGER IF EXISTS `eliminarconcentrados`;
DROP TRIGGER IF EXISTS `nuevoconcentrados`;
DROP TRIGGER IF EXISTS `actualizarconfiguracion`;
DROP TRIGGER IF EXISTS `eliminarconfiguracion`;
DROP TRIGGER IF EXISTS `nuevoconfiguracion`;
DROP TRIGGER IF EXISTS `actualizardetalledevoluciones`;
DROP TRIGGER IF EXISTS `eliminardetalledevoluciones`;
DROP TRIGGER IF EXISTS `nuevodetalledevoluciones`;
DROP TRIGGER IF EXISTS `actualizardetalleventas`;
DROP TRIGGER IF EXISTS `eliminardetalleventas`;
DROP TRIGGER IF EXISTS `nuevodetalleventas`;
DROP TRIGGER IF EXISTS `actualizardevoluciones`;
DROP TRIGGER IF EXISTS `eliminardevoluciones`;
DROP TRIGGER IF EXISTS `nuevodevoluciones`;
DROP TRIGGER IF EXISTS `actualizarempleados`;
DROP TRIGGER IF EXISTS `eliminarempleados`;
DROP TRIGGER IF EXISTS `nuevoempleados`;
DROP TRIGGER IF EXISTS `actualizarempresa`;
DROP TRIGGER IF EXISTS `eliminarempresa`;
DROP TRIGGER IF EXISTS `nuevoempresa`;
DROP TRIGGER IF EXISTS `actualizarentradas`;
DROP TRIGGER IF EXISTS `eliminarentradas`;
DROP TRIGGER IF EXISTS `nuevoentradas`;
DROP TRIGGER IF EXISTS `actualizarinventario`;
DROP TRIGGER IF EXISTS `eliminarinventario`;
DROP TRIGGER IF EXISTS `nuevoinventario`;
DROP TRIGGER IF EXISTS `actualizarkardex`;
DROP TRIGGER IF EXISTS `eliminarkardex`;
DROP TRIGGER IF EXISTS `nuevokardex`;
DROP TRIGGER IF EXISTS `actualizarmarcas`;
DROP TRIGGER IF EXISTS `eliminarmarcas`;
DROP TRIGGER IF EXISTS `nuevomarcas`;
DROP TRIGGER IF EXISTS `actualizarmovimientos`;
DROP TRIGGER IF EXISTS `eliminarmovimientos`;
DROP TRIGGER IF EXISTS `nuevomovimientos`;
DROP TRIGGER IF EXISTS `actualizarpagos`;
DROP TRIGGER IF EXISTS `eliminarpagos`;
DROP TRIGGER IF EXISTS `nuevopagos`;
DROP TRIGGER IF EXISTS `actualizarperfiles`;
DROP TRIGGER IF EXISTS `eliminarperfiles`;
DROP TRIGGER IF EXISTS `nuevoperfiles`;
DROP TRIGGER IF EXISTS `actualizarpermisos`;
DROP TRIGGER IF EXISTS `eliminarpermisos`;
DROP TRIGGER IF EXISTS `nuevopermisos`;
DROP TRIGGER IF EXISTS `actualizarpersonas`;
DROP TRIGGER IF EXISTS `eliminarpersonas`;
DROP TRIGGER IF EXISTS `nuevopersonas`;
DROP TRIGGER IF EXISTS `actualizarproductos`;
DROP TRIGGER IF EXISTS `eliminarproductos`;
DROP TRIGGER IF EXISTS `nuevoproductos`;
DROP TRIGGER IF EXISTS `actualizarsalidas`;
DROP TRIGGER IF EXISTS `eliminarsalidas`;
DROP TRIGGER IF EXISTS `nuevosalidas`;
DROP TRIGGER IF EXISTS `actualizartallas`;
DROP TRIGGER IF EXISTS `eliminartallas`;
DROP TRIGGER IF EXISTS `nuevotallas`;
DROP TRIGGER IF EXISTS `actualizarunidades`;
DROP TRIGGER IF EXISTS `eliminarunidades`;
DROP TRIGGER IF EXISTS `nuevounidades`;
DROP TRIGGER IF EXISTS `actualizarusuarios`;
DROP TRIGGER IF EXISTS `eliminarusuarios`;
DROP TRIGGER IF EXISTS `nuevousuarios`;
DROP TRIGGER IF EXISTS `actualizarventas`;
DROP TRIGGER IF EXISTS `eliminarventas`;
DROP TRIGGER IF EXISTS `nuevoventas`;
DROP TRIGGER IF EXISTS `actualizarventasajuste`;
DROP TRIGGER IF EXISTS `eliminarventasajuste`;
DROP TRIGGER IF EXISTS `nuevoventasajuste`;";
				
				if(mysqli_multi_query($this->con->conect,$consulta)){
					return "exito";
				}else{
					return "fracaso";
				}
			
		}
	}
}
?>