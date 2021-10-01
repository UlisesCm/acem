<?php 
include_once("../../conexion/Conexion.class.php");

class Sucursal{
 //constructor	
 	var $con;
 	function __construct(){
 		$this->con=new Conexion;
	}
	function armarConsulta($condicion,$papelera){
		if ($condicion!=""){
			if($papelera){
				$consulta="WHERE ((sucursales.idsucursal LIKE '%".$condicion."%') OR (sucursales.nombre LIKE '%".$condicion."%') OR (sucursales.calle LIKE '%".$condicion."%') OR (sucursales.ciudad LIKE '%".$condicion."%') OR (sucursales.estado LIKE '%".$condicion."%'))AND sucursales.estatus ='eliminado'";
			}else{
				$consulta="WHERE ((sucursales.idsucursal LIKE '%".$condicion."%') OR (sucursales.nombre LIKE '%".$condicion."%') OR (sucursales.calle LIKE '%".$condicion."%') OR (sucursales.ciudad LIKE '%".$condicion."%') OR (sucursales.estado LIKE '%".$condicion."%'))AND sucursales.estatus <>'eliminado'";
			}
		}else{
			if($papelera){
				$consulta="WHERE sucursales.estatus ='eliminado'";
			}else{
				$consulta="WHERE sucursales.estatus <>'eliminado'";
			}
		}
		return $consulta;
	}
	function comprobarCampo($campo, $valor, $tipoGuardado){
		if($this->con->conectar()==true){
			//print_r($listaCampos);
			$resultado=mysqli_query($this->con->conect,"SELECT COUNT( * ) AS contador from sucursales WHERE $campo = '$valor' ");
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

	function guardar($nombre,$calle,$numero,$colonia,$cp,$ciudad,$estado,$coordenadas,$telefonocontacto,$licenciassa,$serie,$folio,$idcuentacorreo,$archivofirma,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['sucursales']['guardar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		$validar = "fracaso";
		
		$idsucursal=$this->con->generarClave(2); /*Sincronizacion 1 */
		
		if($this->con->conectar()==true){
			$this->con->conect->autocommit(false); //INICO DE TRANSACCION
			
			if($this->comprobarCampo("nombre",$nombre, "nuevo")){
				return "nombreExiste";
			}else{
				$varConsulta = "INSERT INTO sucursales (idsucursal, nombre, calle, numero, colonia, cp, ciudad, estado, coordenadas, telefonocontacto, licenciassa, serie, folio, idcuentacorreo, archivofirma, efectivo, tarjetadedebito, tarjetadecredito, cheques, transferencias, depositos, notasdecredito, estatus) VALUES ('$idsucursal','$nombre','$calle','$numero','$colonia','$cp','$ciudad','$estado', '$coordenadas', '$telefonocontacto','$licenciassa','$serie','$folio','$idcuentacorreo','$archivofirma','0','0','0','0','0','0','0','$estatus')";
				
				if(mysqli_query($this->con->conect,$varConsulta)){
					if ($this->crearTablas($this->con->conect,$idsucursal)){
						if ($this->guardarFolios("A","1",$idsucursal,"activo")){
							$this->con->conect->commit();
							$validar="exito";
						}else{
							$this->con->conect->rollback();
							$validar="fracaso";
							exit;
						}
						
					}else{
						$this->con->conect->rollback();
						$validar="fracaso";
						exit;
					}
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="agreg&oacute; un nuevo registro en la tabla sucursales ";
						$this->registrarBitacora("guardar",$descripcionB);
					}
				}else{
					$validar="fracaso";
				}
			} //Fin de comprobar campo
		}else{
			$validar="fracaso";
		}
		return $validar;
	}
	
	function actualizar($nombre,$calle,$numero,$colonia,$cp,$ciudad,$estado,$coordenadas,$telefonocontacto,$licenciassa,$serie,$folio,$idcuentacorreo,$archivofirma,$estatus,$idsucursal){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['sucursales']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			if($this->comprobarCampo("nombre",$nombre, "modificar")){
				return "nombreExiste";
			}else{
				if(mysqli_query($this->con->conect,"UPDATE sucursales SET nombre='$nombre', calle='$calle', numero='$numero', colonia='$colonia', cp='$cp', ciudad='$ciudad', estado='$estado', coordenadas='$coordenadas', telefonocontacto='$telefonocontacto', licenciassa='$licenciassa', serie='$serie', folio='$folio', idcuentacorreo='$idcuentacorreo', archivofirma='$archivofirma', estatus='$estatus' WHERE idsucursal='$idsucursal'")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="modific&oacute; el registro ID: $idsucursal, de la tabla sucursales ";
						$this->registrarBitacora("modificar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
		}
	}
	
	function bloquear($idsucursal){
		
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['sucursales']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			return mysqli_query($this->con->conect,"UPDATE sucursales SET estatus ='bloqueado' WHERE idsucursal = '$idsucursal'");
		}
	}
	
	function cambiarEstatus($idsucursal,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['sucursales']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			if(mysqli_query($this->con->conect,"UPDATE sucursales SET estatus ='$estatus' WHERE idsucursal = '$idsucursal'")){
				//BITACORA
				if ($_SESSION['bitacora']=="si"){
					$descripcionB="alter&oacute; el estatus del registro a: $estatus, de la tabla sucursales ";
					$this->registrarBitacora("modificar",$descripcionB);
				}
				return "exito";
			}else{
				return "fracaso";
			}
		}
	}
	
	function mostrarIndividual($idsucursal){
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,"SELECT * FROM sucursales WHERE idsucursal='$idsucursal'");
		}
	}
	
	function contar($condicion, $papelera){
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT 
					sucursales.idsucursal,
					sucursales.nombre,
					sucursales.calle,
					sucursales.numero,
					sucursales.colonia,
					sucursales.cp,
					sucursales.ciudad,
					sucursales.estado,
					sucursales.telefonocontacto,
					sucursales.licenciassa,
					sucursales.serie,
					sucursales.folio,
					sucursales.idcuentacorreo,
					sucursales.archivofirma,
					sucursales.estatus,
					cuentascorreo.usuario AS usuariocuentascorreo
					FROM sucursales 
					INNER JOIN cuentascorreo ON sucursales.idcuentacorreo=cuentascorreo.idcuentacorreo
					$where");
					
			//$extractor = mysqli_fetch_array($resultado);
			$numero_filas=mysqli_num_rows($resultado);
			return $numero_filas;
		}
	}
	
	function mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['sucursales']['consultar'])){
			return "denegado";
			exit;
		}
		
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		$consulta = "SELECT 
					sucursales.idsucursal,
					sucursales.nombre,
					sucursales.calle,
					sucursales.numero,
					sucursales.colonia,
					sucursales.cp,
					sucursales.ciudad,
					sucursales.estado,
					sucursales.telefonocontacto,
					sucursales.licenciassa,
					sucursales.serie,
					sucursales.folio,
					sucursales.idcuentacorreo,
					sucursales.archivofirma,
					sucursales.estatus,
					cuentascorreo.usuario AS usuariocuentascorreo
					FROM sucursales 
					INNER JOIN cuentascorreo ON sucursales.idcuentacorreo=cuentascorreo.idcuentacorreo
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
			return mysqli_query($this->con->conect,"SELECT * FROM sucursales $condicion");
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
		$modulo="sucursales";
		mysqli_query($this->con->conect,"INSERT INTO bitacora (hora,fecha,idusuario,modulo,accion,descripcion,idcontrol,tablacontrol,clasificacion,extra) VALUES ('$hora','$fecha','$idusuario','$modulo','$accion','$descripcion')");
	}
	
	function eliminar($ids, $tipoEliminacion){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['sucursales']['eliminar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			if ($tipoEliminacion=='falsa'){
				//REQUIERE CAMPO 'estatus' EN LA TABLA
				if (mysqli_query($this->con->conect,"UPDATE sucursales SET estatus ='eliminado' WHERE idsucursal IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; falsamente los registros: $ids, de la tabla sucursales ";
						$this->registrarBitacora("eliminarFalsa",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
			if ($tipoEliminacion=='real'){
				if(mysqli_query($this->con->conect,"DELETE FROM sucursales WHERE idsucursal IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; los registros: $ids, de la tabla sucursales ";
						$this->registrarBitacora("eliminar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
		}
	}
	
	function guardarFolios($serie,$folioactual,$idsucursal,$estatus){
		$validar=false;
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['sucursales']['guardar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		$idfolio=$this->con->generarClave(1); /*Sincronizacion 1 */
		if($this->con->conectar()==true){
			$idfolio=$idfolio+1;
			$asignacion="PRODUCTOS";
			$nuevaSerie=$serie."P";
			if(mysqli_query($this->con->conect,"INSERT INTO folios (idfolio, serie, folioactual, asignacion, idsucursal, estatus) VALUES ('$idfolio','$nuevaSerie','$folioactual','$asignacion','$idsucursal','$estatus')")){
				$idfolio=$idfolio+1;
				$asignacion="SERVICIOS";
				$nuevaSerie=$serie."S";
				if(mysqli_query($this->con->conect,"INSERT INTO folios (idfolio, serie, folioactual, asignacion, idsucursal, estatus) VALUES ('$idfolio','$nuevaSerie','$folioactual','$asignacion','$idsucursal','$estatus')")){
					$idfolio=$idfolio+1;
					$asignacion="OTROS";
					$nuevaSerie=$serie."O";
					if(mysqli_query($this->con->conect,"INSERT INTO folios (idfolio, serie, folioactual, asignacion, idsucursal, estatus) VALUES ('$idfolio','$nuevaSerie','$folioactual','$asignacion','$idsucursal','$estatus')")){
						$idfolio=$idfolio+1;
						$asignacion="RUTAS";
						$nuevaSerie=$serie."R";
						if(mysqli_query($this->con->conect,"INSERT INTO folios (idfolio, serie, folioactual, asignacion, idsucursal, estatus) VALUES ('$idfolio','$nuevaSerie','$folioactual','$asignacion','$idsucursal','$estatus')")){
							$validar=true;
						}
					}
				}
					
			}
		}
		return $validar;
	}
	
	
	function crearTablas($conexion,$idsucursal){
		
		$consulta="
		CREATE TABLE IF NOT EXISTS `cotizacionesotros$idsucursal` (
		  `idcotizacionesotros` bigint(11) NOT NULL,
		  `serie` varchar(10) NOT NULL,
		  `folio` varchar(10) NOT NULL,
		  `fecha` date NOT NULL,
		  `tipo` varchar(13) NOT NULL,
		  `monto` decimal(20,12) NOT NULL,
		  `idcliente` bigint(11) NOT NULL,
		  `idsucursal` bigint(11) NOT NULL,
		  `idempleado` bigint(20) NOT NULL,
		  `idusuario` bigint(20) NOT NULL,
		  `observaciones` varchar(200) NOT NULL,
		  `estatus` varchar(15) NOT NULL,
		  PRIMARY KEY (`idcotizacionesotros`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;

		
		CREATE TABLE IF NOT EXISTS `cotizacionesproductos$idsucursal` (
		  `idcotizacionproducto` bigint(20) NOT NULL,
		  `serie` varchar(10) NOT NULL,
		  `folio` varchar(10) NOT NULL,
		  `fecha` date NOT NULL,
		  `hora` time NOT NULL,
		  `estadopago` varchar(10) NOT NULL,
		  `estadofacturacion` varchar(25) NOT NULL,
		  `tipo` varchar(10) NOT NULL,
		  `subtotal` decimal(20,12) NOT NULL,
		  `impuestos` decimal(20,12) NOT NULL,
		  `total` decimal(20,12) NOT NULL,
		  `costodeventa` decimal(20,12) NOT NULL,
		  `utilidad` decimal(20,12) NOT NULL,
		  `idcliente` bigint(20) NOT NULL,
		  `idusuario` bigint(20) NOT NULL,
		  `idempleado` bigint(20) NOT NULL,
		  `idsucursal` bigint(20) NOT NULL,
		  `enviaradomicilio` varchar(20) NOT NULL,
		  `fechaentrega` date NOT NULL,
		  `horaentregainicio` time NOT NULL,
		  `horaentregafin` time NOT NULL,
		  `prioridad` varchar(5) NOT NULL,
		  `iddomicilio` bigint(20) NOT NULL,
		  `observaciones` varchar(200) NOT NULL,
		  `estadoentrega` varchar(15) NOT NULL,
		  `estadoentregaanterior` varchar(15) NOT NULL,
		  `ordenentrega` int(11) NOT NULL,
		  `estadocredito` varchar(13) NOT NULL,
		  `descripcioncredito` varchar(20) NOT NULL,
		  `idruta` bigint(20) NOT NULL,
		  `idrutaanterior` bigint(20) NOT NULL,
		  `observacionesentrega` varchar(200) NOT NULL,
		  `estadoliquidacion` varchar(12) NOT NULL,
		  `observacionesliquidacion` varchar(200) NOT NULL,
		  `envio` varchar(13) NOT NULL,
		  `estatus` varchar(15) NOT NULL,
		  PRIMARY KEY (`idcotizacionproducto`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;		
		
		
		CREATE TABLE IF NOT EXISTS `detallecotizacionesotros$idsucursal` (
		  `iddetallecotizacionotros` bigint(20) NOT NULL,
		  `idcliente` bigint(11) NOT NULL,
		  `fecha` date NOT NULL,
		  `cantidad` decimal(10,4) NOT NULL,
		  `concepto` varchar(100) NOT NULL,
		  `unidad` varchar(30) NOT NULL,
		  `numeroservicio` int(4) NOT NULL,
		  `totalservicios` int(4) NOT NULL,
		  `idcotizacionotros` bigint(11) NOT NULL,
		  `precio` decimal(20,12) NOT NULL,
		  `impuestos` decimal(20,12) NOT NULL,
		  `total` decimal(20,12) NOT NULL,
		  `idmodeloimpuestos` bigint(11) NOT NULL,
		  `estadopago` varchar(15) NOT NULL,
		  `estadofacturacion` varchar(15) NOT NULL,
		  `factura` varchar(30) NOT NULL,
		  `estatus` varchar(15) NOT NULL,
		  PRIMARY KEY (`iddetallecotizacionotros`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;
		
		
		CREATE TABLE IF NOT EXISTS `detallecotizacionesproductos$idsucursal` (
		  `iddetallecotizacion` bigint(20) NOT NULL,
		  `subfolio` int(11) NOT NULL,
		  `idproducto` bigint(20) NOT NULL,
		  `cantidad` decimal(20,12) NOT NULL,
		  `costo` decimal(20,12) NOT NULL,
		  `precio` decimal(20,12) NOT NULL,
		  `subtotal` decimal(20,12) NOT NULL,
		  `impuestos` decimal(20,12) NOT NULL,
		  `total` decimal(20,12) NOT NULL,
		  `utilidad` decimal(20,12) NOT NULL,
		  `idcotizacionproducto` bigint(20) NOT NULL,
		  `pesounitario` decimal(20,12) NOT NULL,
		  `cantidadentregada` decimal(20,12) NOT NULL,
		  `cfdiingreso` varchar(50) NOT NULL COMMENT 'Si contiene el UUID se tomara como FACTURADA. Si se encuentra vacio se entendera que no esta facturado el detalle de venta o que ha sido cancelada la factura',
		  `cfdiegreso` varchar(50) NOT NULL COMMENT 'Si contiene el UUID se tomara como NOTA DE CREDITO. Si se encuentra vacio se entendera que no esta facturado el detalle de venta o que ha sido cancelada la nota de credito',
		  PRIMARY KEY (`iddetallecotizacion`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;

		
		
		CREATE TABLE IF NOT EXISTS `inventario$idsucursal` (
		  `idinventario` bigint(20) NOT NULL,
		  `idproducto` bigint(20) NOT NULL,
		  `existencia` decimal(20,12) NOT NULL,
		  `promedio` decimal(20,12) NOT NULL,
		  `saldo` decimal(20,12) NOT NULL,
		  `minimo` decimal(20,12) NOT NULL,
		  `ubicacion` varchar(50) NOT NULL,
		  `estado` varchar(50) NOT NULL,
		  PRIMARY KEY (`idinventario`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;

		
		
		CREATE TABLE IF NOT EXISTS `kardex$idsucursal` (
		  `idkardex` bigint(20) NOT NULL,
		  `idproducto` bigint(20) NOT NULL,
		  `fechamovimiento` datetime NOT NULL,
		  `descripcion` varchar(300) NOT NULL,
		  `observaciones` text NOT NULL,
		  `entrada` decimal(20,12) NOT NULL,
		  `salida` decimal(20,12) NOT NULL,
		  `existencia` decimal(20,12) NOT NULL,
		  `costounitario` decimal(20,12) NOT NULL,
		  `promedio` decimal(20,12) NOT NULL,
		  `debe` decimal(20,12) NOT NULL,
		  `haber` decimal(20,12) NOT NULL,
		  `saldo` decimal(20,12) NOT NULL,
		  `idmovimiento` bigint(20) NOT NULL,
		  `idreferencia` bigint(20) NOT NULL,
		  `estatus` varchar(15) NOT NULL,
		  PRIMARY KEY (`idkardex`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;
		
		CREATE TABLE IF NOT EXISTS `movimientos$idsucursal` (
		  `idmovimiento` bigint(20) NOT NULL,
		  `tipo` varchar(20) NOT NULL,
		  `concepto` varchar(300) NOT NULL,
		  `fechamovimiento` date NOT NULL,
		  `hora` time NOT NULL,
		  `numerocomprobante` varchar(20) NOT NULL,
		  `tabla` varchar(50) NOT NULL,
		  `idreferencia` bigint(20) NOT NULL,
		  `comentarios` varchar(500) NOT NULL,
		  `estado` varchar(15) NOT NULL,
		  `estatus` varchar(15) NOT NULL,
		  PRIMARY KEY (`idmovimiento`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;
		
		CREATE TABLE IF NOT EXISTS `pagos$idsucursal` (
		  `idpago` bigint(20) NOT NULL,
		  `idreferencia` bigint(20) NOT NULL,
		  `tablareferencia` varchar(40) NOT NULL,
		  `idcliente` bigint(20) NOT NULL,
		  `idcaja` bigint(20) NOT NULL,
		  `fechapago` date NOT NULL,
		  `formapago` varchar(100) NOT NULL,
		  `monto` decimal(20,12) NOT NULL,
		  `descripcion` varchar(300) NOT NULL,
		  `estadopago` varchar(20) NOT NULL,
		  `uuidpago` varchar(100) NOT NULL,
		  `uuidfactura` varchar(100) NOT NULL,
		  `corte` varchar(9) NOT NULL,
		  `idcortedecaja` bigint(20) NOT NULL,
		  PRIMARY KEY (`idpago`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;
		";
		
		//echo $consulta;
		
		$resultado=mysqli_multi_query($conexion,$consulta);
		if ($resultado){
			return true;
		}else{
			
			return false;
		}
	}
}
?>