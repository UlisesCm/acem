<?php 
include_once("../../conexion/Conexion.class.php");

class Proveedor{
 //constructor	
 	var $con;
 	function __construct(){
 		$this->con=new Conexion;
	}
	function armarConsulta($condicion,$papelera){
		if ($condicion!=""){
			if($papelera){
				$consulta="WHERE ((proveedores.nombre LIKE '%".$condicion."%')) AND proveedores.estatus ='eliminado'";
			}else{
				$consulta="WHERE ((proveedores.nombre LIKE '%".$condicion."%')) AND proveedores.estatus <>'eliminado'";
			}
		}else{
			if($papelera){
				$consulta="WHERE proveedores.estatus ='eliminado'";
			}else{
				$consulta="WHERE proveedores.estatus <>'eliminado'";
			}
		}
		return $consulta;
	}
	function comprobarCampo($campo, $valor, $tipoGuardado){
		if($this->con->conectar()==true){
			//print_r($listaCampos);
			$resultado=mysqli_query($this->con->conect,"SELECT COUNT( * ) AS contador from proveedores WHERE $campo = '$valor'");
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
	
	function comprobarProductoProveedor($idproducto,$idproveedor){
		if($this->con->conectar()==true){
			//print_r($listaCampos);
			$resultado=mysqli_query($this->con->conect,"SELECT clave FROM productosproveedores WHERE idproducto='$idproducto' AND  idproveedor='$idproveedor'");
			if(mysqli_num_rows($resultado)!=0){
				$extractor = mysqli_fetch_array($resultado);
				$clave=$extractor['clave'];
				return $clave;
			}else{
				return "null";
			}
		}
	}

	function guardar($nombre,$rfc,$nivelcalidad,$nivelexistencia,$tiemporespuesta,$tipoprontopago,$prontopagofactura,$prontopagorecepcion,$email,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['proveedores']['guardar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		$idproveedor=$this->con->generarClave(2); /*Sincronizacion 1 */
		
		if($this->con->conectar()==true){
			if($this->comprobarCampo("nombre",$nombre, "nuevo")){
				return "nombreExiste";
			}else{
				if(mysqli_query($this->con->conect,"INSERT INTO proveedores (idproveedor, nombre, rfc, nivelcalidad, nivelexistencia, tiemporespuesta, tipoprontopago, prontopagofactura, prontopagorecepcion, email, estatus) VALUES ('$idproveedor','$nombre','$rfc','$nivelcalidad','$nivelexistencia','$tiemporespuesta','$tipoprontopago','$prontopagofactura','$prontopagorecepcion','$email','$estatus')")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="agreg&oacute; un nuevo registro en la tabla proveedores ";
						$this->registrarBitacora("guardar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
		}
	}
	
	function actualizar($nombre,$rfc,$nivelcalidad,$nivelexistencia,$tiemporespuesta,$tipoprontopago,$prontopagofactura,$prontopagorecepcion,$estatus,$email,$idproveedor){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['proveedores']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			if($this->comprobarCampo("nombre",$nombre, "modificar")){
				return "nombreExiste";
			}else{
				if(mysqli_query($this->con->conect,"UPDATE proveedores SET nombre='$nombre', nivelcalidad='$nivelcalidad', nivelexistencia='$nivelexistencia', tiemporespuesta='$tiemporespuesta', email='$email', estatus='$estatus', rfc='$rfc', tipoprontopago='$tipoprontopago', prontopagofactura='$prontopagofactura', prontopagorecepcion='$prontopagorecepcion' WHERE idproveedor='$idproveedor'")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="modific&oacute; el registro ID: $idproveedor, de la tabla proveedores ";
						$this->registrarBitacora("modificar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
		}
	}
	
	function bloquear($idproveedor){
		
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['proveedores']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			return mysqli_query($this->con->conect,"UPDATE proveedores SET estatus ='bloqueado' WHERE idproveedor = '$idproveedor'");
		}
	}
	
	function cambiarEstatus($idproveedor,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['proveedores']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			if(mysqli_query($this->con->conect,"UPDATE proveedores SET estatus ='$estatus' WHERE idproveedor = '$idproveedor'")){
				//BITACORA
				if ($_SESSION['bitacora']=="si"){
					$descripcionB="alter&oacute; el estatus del registro a: $estatus, de la tabla proveedores ";
					$this->registrarBitacora("modificar",$descripcionB);
				}
				return "exito";
			}else{
				return "fracaso";
			}
		}
	}
	
	function mostrarIndividual($idproveedor){
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,"SELECT * FROM proveedores WHERE idproveedor='$idproveedor'");
		}
	}
	
	function contar($condicion, $papelera){
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT 
					proveedores.idproveedor,
					proveedores.nombre,
					proveedores.nivelcalidad,
					proveedores.nivelexistencia,
					proveedores.tiemporespuesta,
					proveedores.estatus
					FROM proveedores 
					$where");
					
			//$extractor = mysqli_fetch_array($resultado);
			$numero_filas=mysqli_num_rows($resultado);
			return $numero_filas;
		}
	}
	
	function mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['proveedores']['consultar'])){
			return "denegado";
			exit;
		}
		
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		$consulta = "SELECT 
					proveedores.idproveedor,
					proveedores.nombre,
					proveedores.nivelcalidad,
					proveedores.nivelexistencia,
					proveedores.tiemporespuesta,
					proveedores.estatus
					FROM proveedores 
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
			return mysqli_query($this->con->conect,"SELECT * FROM proveedores $condicion");
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
		$modulo="proveedores";
		mysqli_query($this->con->conect,"INSERT INTO bitacora (hora,fecha,idusuario,modulo,accion,descripcion,idcontrol,tablacontrol,clasificacion,extra) VALUES ('$hora','$fecha','$idusuario','$modulo','$accion','$descripcion')");
	}
	
	function eliminar($ids, $tipoEliminacion){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['proveedores']['eliminar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			if ($tipoEliminacion=='falsa'){
				//REQUIERE CAMPO 'estatus' EN LA TABLA
				if (mysqli_query($this->con->conect,"UPDATE proveedores SET estatus ='eliminado' WHERE idproveedor IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; falsamente los registros: $ids, de la tabla proveedores ";
						$this->registrarBitacora("eliminarFalsa",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
			if ($tipoEliminacion=='real'){
				if(mysqli_query($this->con->conect,"DELETE FROM proveedores WHERE idproveedor IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; los registros: $ids, de la tabla proveedores ";
						$this->registrarBitacora("eliminar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
		}
	}
	
	
	
	////Funciones de listas de precios de compra
	
	function mostrarPrecios($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera, $idproveedor){
		
		$condicion= trim($condicion);
		if ($condicion!=""){
			$where="WHERE ((productos.nombre LIKE '%".$condicion."%') AND precioscompra.idproveedor='$idproveedor')";
		}else{
			$where="WHERE precioscompra.idproveedor='$idproveedor'";
		}
		
		$consulta = "SELECT 
					SQL_CALC_FOUND_ROWS
					precioscompra.idpreciocompra,
					precioscompra.idproducto,
					precioscompra.idproveedor,
					precioscompra.claveproductoproveedor,
					precioscompra.precio1,
					precioscompra.condicioncantidad1,
					precioscompra.condicionpeso1,
					precioscompra.precio2,
					precioscompra.condicioncantidad2,
					precioscompra.condicionpeso2,
					precioscompra.precio3,
					precioscompra.condicioncantidad3,
					precioscompra.condicionpeso3,
					precioscompra.precio4,
					precioscompra.condicioncantidad4,
					precioscompra.condicionpeso4,
					productos.nombre AS nombreproducto,
					productos.codigo AS codigoproducto
					FROM precioscompra
					INNER JOIN productos ON productos.idproducto=precioscompra.idproducto 
					$where
					ORDER BY $campoOrden $orden
					LIMIT $inicial, $cantidadamostrar
					";
					
		if($this->con->conectar()==true){
			$resultado1=mysqli_query($this->con->conect,$consulta);
			$resultado2=mysqli_query($this->con->conect,"SELECT FOUND_ROWS() AS contador");
			$extractor = mysqli_fetch_assoc($resultado2);
			return array($resultado1,$extractor["contador"]);
		}
	}
	
	function comprobarSincronizacion($idreferencia, $idproveedor){
		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT COUNT(*) AS contador from precioscompra WHERE idproducto = '$idreferencia' AND idproveedor='$idproveedor'");
			if ($resultado){
				$extractor = mysqli_fetch_array($resultado);
				$numero_filas=$extractor["contador"];
					if ($numero_filas=="0"){
						return false;
					}else{
						return true;
					}
			}else{
				return false;
			}
		}
	}
	
	function sincronizar($idproveedor){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['listasprecios']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT
			productos.idproducto,
			productos.costo,
			productos.nombre,
			productosproveedores.idproveedor
			FROM productos
			INNER JOIN productosproveedores ON productosproveedores.idproducto=productos.idproducto
			WHERE productos.estatus <> 'eliminado' AND productosproveedores.idproveedor='$idproveedor'");
			while ($filas=mysqli_fetch_array($resultado)) { 
				$idreferencia=$filas['idproducto'];
				$costo=$filas['costo'];
				$nombre=$filas['nombre'];
				//mysqli_query($this->con->conect,"UPDATE precios SET descripcion='$nombre' WHERE idproveedor='$idproveedor' AND idreferencia='$idreferencia'");
				if($this->comprobarSincronizacion($idreferencia,$idproveedor)==false){
					//echo $descripcion;
					mysqli_query($this->con->conect,"INSERT INTO precioscompra (idproducto, idproveedor, claveproductoproveedor,precio1,condicioncantidad1,condicionpeso1,precio2,condicioncantidad2,condicionpeso2,precio3,condicioncantidad3,condicionpeso3,precio4,condicioncantidad4,condicionpeso4) VALUES ('$idreferencia','$idproveedor','','$costo','0','0','0','0','0','0','0','0','0','0','0')");
				}
			}
			return "exito";
		}else{
			return "fracaso";
		}
	}
	
	function actualizarDato($campo,$valor,$idpreciocompra){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['listasprecios']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			if(mysqli_query($this->con->conect,"UPDATE precioscompra SET $campo='$valor' WHERE idpreciocompra='$idpreciocompra'")){
				//BITACORA
				if ($_SESSION['bitacora']=="si"){
					$descripcionB="modific&oacute; el registro ID: $idlistaprecios, de la tabla listasprecios ";
					$this->registrarBitacora("modificar",$descripcionB);
				}
				return "exito";
			}else{
				return "fracaso";
			}
			
		}
	}
}
?>