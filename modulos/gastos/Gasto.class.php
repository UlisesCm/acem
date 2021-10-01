<?php 
include_once("../../conexion/Conexion.class.php");

class Gasto{
 //constructor	
 	var $con;
 	function __construct(){
 		$this->con=new Conexion;
	}
	function armarConsulta($condicion,$papelera){
		if ($condicion!=""){
			if($papelera){
				$consulta="WHERE ((gastos.total LIKE '%".$condicion."%')) AND gastos.estatus ='eliminado'";
			}else{
				$consulta="WHERE ((gastos.total LIKE '%".$condicion."%')) AND gastos.estatus <>'eliminado'";
			}
		}else{
			if($papelera){
				$consulta="WHERE gastos.estatus ='eliminado'";
			}else{
				$consulta="WHERE gastos.estatus <>'eliminado'";
			}
		}
		return $consulta;
	}
	function comprobarCampo($campo, $valor, $tipoGuardado){
		if($this->con->conectar()==true){
			//print_r($listaCampos);
			$resultado=mysqli_query($this->con->conect,"SELECT COUNT( * ) AS contador from gastos WHERE $campo = '$valor'");
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
	
	function descomponerArreglo($elementosPorVuelta,$elementoSeleccionado, $arreglo){
		$totalElementos= count($arreglo);
		if ($totalElementos!=1){
			$con=0;
			$totalVueltas=$totalElementos/$elementosPorVuelta;
			while($con<$totalVueltas){
				$array[$con]= $arreglo[$elementoSeleccionado];
				$elementoSeleccionado=$elementoSeleccionado+$elementosPorVuelta;
				$con++;
			}
			return $array;
		}else{
			return $arreglo;
		}
		
	}
	
	function guardarRetiro($fecha,$descripcion,$monto,$cheque,$beneficiario,$idcuenta,$estatus,$conexion){
		$validar=true;
		$idretiro=$this->con->generarClave(2); /*Sincronizacion 1 */
		$this->globalIdRetiro = $idretiro;
		$consultaDet = "INSERT INTO retiros (idretiro, fecha, descripcion, monto, cheque, beneficiario, idcuenta, estatus) VALUES ('$idretiro','$fecha','$descripcion','$monto','$cheque','$beneficiario','$idcuenta','$estatus')";
		//echo $consultaDet;
		if(!mysqli_query($conexion,$consultaDet)){
			$validar=false;
		}
		return $validar;
	}
	
	function guardarGasto($idsucursal,$lista,$estatus,$conexion){
		//GUARDAR LOS GASTOS
			$arregloId=$this->descomponerArreglo(13,0,$lista);
			$arreglofechafactura=$this->descomponerArreglo(13,1,$lista);//parametros (el numero de campos que completan el primer registro, la posición del arreglo que va a tomar, la lista)
			$arreglofechavencimiento=$this->descomponerArreglo(13,2,$lista);
			$arregloidcuentaprincipal=$this->descomponerArreglo(13,3,$lista);
			$arregloidcuentasecundaria=$this->descomponerArreglo(13,4,$lista);
			$arreglodescripcion=$this->descomponerArreglo(13,5,$lista);
			$arregloidproveedor=$this->descomponerArreglo(13,6,$lista);
			$arreglobeneficiario=$this->descomponerArreglo(13,7,$lista);
			$arreglofactura=$this->descomponerArreglo(13,8,$lista);
			$arregloidmodeloimpuestos=$this->descomponerArreglo(13,9,$lista);
			$arreglosubtotal=$this->descomponerArreglo(13,10,$lista);
			$arregloimpuestosFila=$this->descomponerArreglo(13,11,$lista);
			$arreglototal=$this->descomponerArreglo(13,12,$lista);
			$con=0;//PROBLEMA CON CON
			$validar=true;
			while ($con < count($arregloId)){
				$idgasto=$this->con->generarClave(2); /*Sincronizacion 1 */
				//FALTA AGREGAR EL ID DE LA SUCURSAL SELECCIONADA AL NOMBRE DE LA TABLA GASTOS UNA VEZ QUE SEAN DINAMICAS
				$consultaDet = "INSERT INTO gastos (idgasto, fechafactura, fechavencimiento, idcuentaprincipal, idcuentasecundaria, descripcion, idproveedor, beneficiario, factura, idmodeloimpuestos, subtotal, impuestos, total, autorizado, idretiro, estatus) VALUES ('$idgasto','$arreglofechafactura[$con]','$arreglofechavencimiento[$con]','$arregloidcuentaprincipal[$con]','$arregloidcuentasecundaria[$con]','$arreglodescripcion[$con]','$arregloidproveedor[$con]','$arreglobeneficiario[$con]','$arreglofactura[$con]','$arregloidmodeloimpuestos[$con]','$arreglosubtotal[$con]','$arregloimpuestosFila[$con]','$arreglototal[$con]','NO AUTORIZADO','0','$estatus')";
				//echo $consultaDet;
				if(!mysqli_query($conexion,$consultaDet)){
					$validar=false;
				}
				$con++;
			}
			
		return $validar;
	}

	function guardar($idsucursal,$lista,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['gastos']['guardar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		//$this->globalIdRetiro = 0;
		$validar = "fracaso";
		if($this->con->conectar()==true){
			 $this->con->conect->autocommit(false); //INICO DE TRANSACCION
			 
			 //if($this->guardarRetiro($fecha,$descripcion,$monto,$cheque,$beneficiario,$idcuenta,$estatus,$this->con->conect)){//guarda el retiro
			 
			     if($this->guardarGasto($idsucursal,$lista,$estatus,$this->con->conect)){//guarda el gasto
			    	 //FINALIZAR TRANSACCION
					 $this->con->conect->commit(); //COMMIT EN CASO DE QUE TODAS LAS TRANSACCIONES TENGAN EXITO
				     $validar = "exito";
				 
					 //BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="agreg&oacute; un nuevo registro en la tabla gastos ";
						$this->registrarBitacora("guardar",$descripcionB);
				     }
				 }
				 else{
					  $this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASE
				       $validar = "fracaso";
				 }
			 /*}
			 else{
				 $this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASE
				 $validar = "fracaso";
			 }*/
			
		}
		return $validar;
	}
	
	function actualizar($idcuentaprincipal,$idcuentasecundaria,$descripcion,$idproveedor,$factura,$idmodeloimpuestos,$subtotal,$impuestos,$total,$idretiro,$estatus,$idgasto){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['gastos']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			
				if(mysqli_query($this->con->conect,"UPDATE gastos SET idcuentaprincipal='$idcuentaprincipal', idcuentasecundaria='$idcuentasecundaria', descripcion='$descripcion', idproveedor='$idproveedor', factura='$factura', idmodeloimpuestos='$idmodeloimpuestos', subtotal='$subtotal', impuestos='$impuestos', total='$total', idretiro='$idretiro', estatus='$estatus' WHERE idgasto='$idgasto'")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="modific&oacute; el registro ID: $idgasto, de la tabla gastos ";
						$this->registrarBitacora("modificar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			
		}
	}
	
	function bloquear($idgasto){
		
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['gastos']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			return mysqli_query($this->con->conect,"UPDATE gastos SET estatus ='bloqueado' WHERE idgasto = '$idgasto'");
		}
	}
	
	function cambiarEstatus($idgasto,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['gastos']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			if(mysqli_query($this->con->conect,"UPDATE gastos SET estatus ='$estatus' WHERE idgasto = '$idgasto'")){
				//BITACORA
				if ($_SESSION['bitacora']=="si"){
					$descripcionB="alter&oacute; el estatus del registro a: $estatus, de la tabla gastos ";
					$this->registrarBitacora("modificar",$descripcionB);
				}
				return "exito";
			}else{
				return "fracaso";
			}
		}
	}
	
	function mostrarIndividual($idgasto){
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,"SELECT * FROM gastos WHERE idgasto='$idgasto'");
		}
	}
	
	function contar($condicion, $papelera){
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		if($this->con->conectar()==true){
			$resultado=mysqli_query($this->con->conect,"SELECT 
					gastos.idgasto,
					gastos.idcuentaprincipal,
					gastos.idcuentasecundaria,
					gastos.descripcion,
					gastos.idproveedor,
					gastos.factura,
					gastos.idmodeloimpuestos,
					gastos.subtotal,
					gastos.impuestos,
					gastos.total,
					gastos.idretiro,
					gastos.estatus,
					cuentasprincipales.idcuentaprincipal AS idcuentaprincipalcuentasprincipales,
					cuentassecundarias.idcuentasecundaria AS idcuentasecundariacuentassecundarias,
					proveedores.idproveedor AS idproveedorproveedores,
					retiros.idretiro AS idretiroretiros,
					modelosimpuestos.idmodeloimpuestos AS idmodeloimpuestosmodelosimpuestos
					FROM gastos 
					INNER JOIN cuentasprincipales ON gastos.idcuentaprincipal=cuentasprincipales.idcuentaprincipal
					INNER JOIN cuentassecundarias ON gastos.idcuentasecundaria=cuentassecundarias.idcuentasecundaria
					INNER JOIN proveedores ON gastos.idproveedor=proveedores.idproveedor
					INNER JOIN retiros ON gastos.idretiro=retiros.idretiro
					INNER JOIN modelosimpuestos ON gastos.idmodeloimpuestos=modelosimpuestos.idmodeloimpuestos
					$where");
					
			//$extractor = mysqli_fetch_array($resultado);
			$numero_filas=mysqli_num_rows($resultado);
			return $numero_filas;
		}
	}
	
	function mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['gastos']['consultar'])){
			return "denegado";
			exit;
		}
		
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		$consulta = "SELECT 
					gastos.idgasto,
					gastos.fechafactura,
					gastos.fechavencimiento,
					gastos.idcuentaprincipal,
					gastos.idcuentasecundaria,
					gastos.descripcion,
					gastos.idproveedor,
					gastos.beneficiario,
					gastos.factura,
					gastos.idmodeloimpuestos,
					gastos.subtotal,
					gastos.impuestos,
					gastos.total,
					gastos.autorizado,
					gastos.idretiro,
					gastos.estatus,
					cuentasprincipales.nombre AS nombrecuentaprincipal,
					cuentassecundarias.nombre AS nombrecuentasecundaria,
					proveedores.nombre AS nombreproveedor,
					modelosimpuestos.nombre AS nombremodeloimpuestos,
					modelosimpuestos.idmodeloimpuestos AS idmodeloimpuestosmodelosimpuestos
					FROM gastos 
					INNER JOIN cuentasprincipales ON gastos.idcuentaprincipal=cuentasprincipales.idcuentaprincipal
					INNER JOIN cuentassecundarias ON gastos.idcuentasecundaria=cuentassecundarias.idcuentasecundaria
					INNER JOIN proveedores ON gastos.idproveedor=proveedores.idproveedor
					INNER JOIN modelosimpuestos ON gastos.idmodeloimpuestos=modelosimpuestos.idmodeloimpuestos
					$where
					ORDER BY $campoOrden $orden
					LIMIT $inicial, $cantidadamostrar
					";
		if($this->con->conectar()==true){
			return $resultado=mysqli_query($this->con->conect,$consulta);
		}
	}
	
	function ObtenerDatosRetiro($idretiro){
		$DatosRetiro="";
		if($idretiro==0){//no se ha retirado
			$DatosRetiro="NO RETIRADO";
		}
		else{//hacer la consulta de los detalles
		    if($this->con->conectar()==true){
				$varConsulta = "SELECT 
				retiros.fecha, 
				retiros.descripcion, 
				retiros.monto, 
				retiros.cheque, 
				cuentasbancarias.cuenta AS cuentabancaria, 
				cuentasbancarias.banco AS bancocuenta 
				FROM retiros 
				INNER JOIN cuentasbancarias ON retiros.idcuenta = cuentasbancarias.idcuenta 
				WHERE idretiro='$idretiro' ";
				//echo $varConsulta;
				$resultado=mysqli_query($this->con->conect,$varConsulta);
				if ($resultado){
					$extractor = mysqli_fetch_array($resultado);
					$DatosRetiro="FECHA:".$extractor["fecha"]." MONTO:".$extractor["monto"]." BANCO:".$extractor["bancocuenta"]." CUENTA:".$extractor["cuentabancaria"]."";
					return $DatosRetiro;
				}else{
					$DatosRetiro = "ERROR DE CONSULTA";
					return $DatosRetiro;
				}
			}else{
				$DatosRetiro = "ERROR DE CONEXIÓN";
				return $DatosRetiro;
			}
		}
		
		return $DatosRetiro;
	}
	function consultaGeneral($condicion){
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,"SELECT * FROM gastos $condicion");
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
		$modulo="gastos";
		mysqli_query($this->con->conect,"INSERT INTO bitacora (hora,fecha,idusuario,modulo,accion,descripcion,idcontrol,tablacontrol,clasificacion,extra) VALUES ('$hora','$fecha','$idusuario','$modulo','$accion','$descripcion')");
	}
	
	function eliminar($ids, $tipoEliminacion){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['gastos']['eliminar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			if ($tipoEliminacion=='falsa'){
				//REQUIERE CAMPO 'estatus' EN LA TABLA
				if (mysqli_query($this->con->conect,"UPDATE gastos SET estatus ='eliminado' WHERE idgasto IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; falsamente los registros: $ids, de la tabla gastos ";
						$this->registrarBitacora("eliminarFalsa",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
			if ($tipoEliminacion=='real'){
				if(mysqli_query($this->con->conect,"DELETE FROM gastos WHERE idgasto IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; los registros: $ids, de la tabla gastos ";
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