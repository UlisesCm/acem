<?php 
include_once("../../conexion/Conexion.class.php");

class Cortedecaja{
 //constructor	
 	var $con;
 	function __construct(){
 		$this->con=new Conexion;
	}
	function armarConsulta($condicion,$papelera){
		if ($condicion!=""){
			$consulta="WHERE ((cortesdecaja.fecha LIKE '%".$condicion."%') OR (cortesdecaja.total LIKE '%".$condicion."%') OR (cortesdecaja.idsucursal LIKE '%".$condicion."%'))AND cortesdecaja.estatus <>'eliminado'";
		}else{
			$consulta="WHERE cortesdecaja.estatus <>'eliminado'";
		}
		return $consulta;
	}function comprobarCampo($campo, $valor, $tipoGuardado){
		if($this->con->conectar()==true){
			//print_r($listaCampos);
			$resultado=mysqli_query($this->con->conect,"SELECT COUNT( * ) AS contador from cortesdecaja WHERE $campo = '$valor'");
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

	function guardar($fecha,$hora,$total,$idsucursal,$archivo,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cortesdecaja']['guardar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		$idcortedecaja=$this->con->generarClave(2); /*Sincronizacion 1 */
		
		if($this->con->conectar()==true){
			if($this->comprobarCampo("idcortedecaja",$idcortedecaja, "nuevo")){
				return "idcortedecajaExiste";
			}else{
				if(mysqli_query($this->con->conect,"INSERT INTO cortesdecaja (idcortedecaja, fecha, hora, total, idsucursal, archivo, estatus) VALUES ('$idcortedecaja','$fecha','$hora','$total','$idsucursal','$archivo','$estatus')")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="agreg&oacute; un nuevo registro en la tabla cortesdecaja ";
						$this->registrarBitacora("guardar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
		}
	}
	
	function actualizar($fecha,$hora,$total,$idsucursal,$archivo,$estatus,$idcortedecaja){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cortesdecaja']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			if($this->comprobarCampo("idcortedecaja",$idcortedecaja, "modificar")){
				return "idcortedecajaExiste";
			}else{
				if(mysqli_query($this->con->conect,"UPDATE cortesdecaja SET fecha='$fecha', hora='$hora', total='$total', idsucursal='$idsucursal', archivo='$archivo', estatus='$estatus' WHERE idcortedecaja='$idcortedecaja'")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="modific&oacute; el registro ID: $idcortedecaja, de la tabla cortesdecaja ";
						$this->registrarBitacora("modificar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
		}
	}
	
	function bloquear($idcortedecaja){
		
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cortesdecaja']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			return mysqli_query($this->con->conect,"UPDATE cortesdecaja SET estatus ='bloqueado' WHERE idcortedecaja = '$idcortedecaja'");
		}
	}
	
	function cambiarEstatus($idcortedecaja,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cortesdecaja']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			if(mysqli_query($this->con->conect,"UPDATE cortesdecaja SET estatus ='$estatus' WHERE idcortedecaja = '$idcortedecaja'")){
				//BITACORA
				if ($_SESSION['bitacora']=="si"){
					$descripcionB="alter&oacute; el estatus del registro a: $estatus, de la tabla cortesdecaja ";
					$this->registrarBitacora("modificar",$descripcionB);
				}
				return "exito";
			}else{
				return "fracaso";
			}
		}
	}
	
	function mostrarIndividual($idcortedecaja){
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,"SELECT * FROM cortesdecaja WHERE idcortedecaja='$idcortedecaja'");
		}
	}
	
	function contar($condicion, $papelera){
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT 
					cortesdecaja.idcortedecaja,
					cortesdecaja.fecha,
					cortesdecaja.hora,
					cortesdecaja.total,
					cortesdecaja.idsucursal,
					cortesdecaja.archivo,
					cortesdecaja.estatus,
					Sucursales.idsucursal AS idsucursalSucursales
					FROM cortesdecaja 
					INNER JOIN Sucursales ON cortesdecaja.idsucursal=Sucursales.idsucursal
					$where");
					
			//$extractor = mysqli_fetch_array($resultado);
			$numero_filas=mysqli_num_rows($resultado);
			return $numero_filas;
		}
	}
	
	function mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cortesdecaja']['consultar'])){
			return "denegado";
			exit;
		}
		
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		$consulta = "SELECT 
					cortesdecaja.idcortedecaja,
					cortesdecaja.fecha,
					cortesdecaja.hora,
					cortesdecaja.total,
					cortesdecaja.idsucursal,
					cortesdecaja.archivo,
					cortesdecaja.estatus,
					Sucursales.nombre AS nombresucursal
					FROM cortesdecaja 
					INNER JOIN Sucursales ON cortesdecaja.idsucursal=Sucursales.idsucursal
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
			return mysqli_query($this->con->conect,"SELECT * FROM cortesdecaja $condicion");
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
		$modulo="cortesdecaja";
		mysqli_query($this->con->conect,"INSERT INTO bitacora (hora,fecha,idusuario,modulo,accion,descripcion,idcontrol,tablacontrol,clasificacion,extra) VALUES ('$hora','$fecha','$idusuario','$modulo','$accion','$descripcion')");
	}
	
	function eliminar($ids, $tipoEliminacion){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cortesdecaja']['eliminar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			if ($tipoEliminacion=='falsa'){
				//REQUIERE CAMPO 'estatus' EN LA TABLA
				if (mysqli_query($this->con->conect,"UPDATE cortesdecaja SET estatus ='eliminado' WHERE idcortedecaja IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; falsamente los registros: $ids, de la tabla cortesdecaja ";
						$this->registrarBitacora("eliminarFalsa",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
			if ($tipoEliminacion=='real'){
				if(mysqli_query($this->con->conect,"DELETE FROM cortesdecaja WHERE idcortedecaja IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; los registros: $ids, de la tabla cortesdecaja ";
						$this->registrarBitacora("eliminar",$descripcionB);
					}
					//actualizaciones de los saldos
					//consultar todos los pagos que tengan el idcortedecaja y porcada pago subir el saldo de la forma de pago correspondiente
					$Pagos = "pagos".$_SESSION['idsucursal'];
					$resultado=mysqli_query($this->con->conect,"SELECT * from $Pagos WHERE idcortedecaja IN ($ids)");
					//echo "SELECT * from $Pagos WHERE idcortedecaja IN ($ids)";
					$idsucursal = $_SESSION['idsucursal'];
					while ($filas=mysqli_fetch_array($resultado)) { 
						$formadepago = $filas['formapago'];
						if($formadepago=="EFECTIVO"){
							$formadepago="efectivo";
						}
						if($formadepago=="TARJETA DE DEBITO"){
							$formadepago="tarjetadedebito";
						}
						if($formadepago=="TARJETA DE CREDITO"){
							$formadepago="tarjetadecredito";
						}
						if($formadepago=="CHEQUE"){
							$formadepago="cheques";
						}
						if($formadepago=="TRANSFERENCIA"){
							$formadepago="transferencias";
						}
						if($formadepago=="DEPOSITO"){
							$formadepago="depositos";
						}
						if($formadepago=="NOTA DE CREDITO"){
							$formadepago="notasdecredito";
						}
						$montopago = $filas['monto'];
						$consultaDet = "UPDATE Sucursales SET $formadepago = $formadepago+$montopago WHERE idsucursal = $idsucursal";
						//echo $consultaDet;
						if(!mysqli_query($this->con->conect,$consultaDet)){
							return "fracaso";;
						}
						
					}
					
					//actualizaciones de los pagos
					$Pagos = "Pagos".$_SESSION['idsucursal'];
					$consultaDet = "UPDATE $Pagos SET corte = 'PENDIENTE', idcortedecaja = 0 WHERE idcortedecaja IN ($ids)";
					//echo $consultaDet;
					if(!mysqli_query($this->con->conect,$consultaDet)){
						return "fracaso";;
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