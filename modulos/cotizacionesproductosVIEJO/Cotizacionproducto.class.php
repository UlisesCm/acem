<?php 
include_once("../../conexion/Conexion.class.php");

include_once("../../movimientos/Movimiento.class.php");

include_once("../../folios/Folio.class.php");

class Cotizacionproducto{
 //constructor	
 	var $con;
 	function __construct(){
 		$this->con=new Conexion;
	}
	function armarConsulta($condicion,$papelera){
		$cotizacionesproductos = "cotizacionesproductos" . $_SESSION["idsucursal"];
		if ($condicion!=""){
			if($papelera){
				$consulta="WHERE ((cotizacionesproductos.serie LIKE '%".$condicion."%') OR ($cotizacionesproductos.folio LIKE '%".$condicion."%') OR ($cotizacionesproductos.fecha LIKE '%".$condicion."%') OR ($cotizacionesproductos.hora LIKE '%".$condicion."%') OR ($cotizacionesproductos.estadopago LIKE '%".$condicion."%') OR ($cotizacionesproductos.estadofacturacion LIKE '%".$condicion."%') OR ($cotizacionesproductos.tipo LIKE '%".$condicion."%') OR ($cotizacionesproductos.subtotal LIKE '%".$condicion."%') OR ($cotizacionesproductos.impuestos LIKE '%".$condicion."%') OR ($cotizacionesproductos.total LIKE '%".$condicion."%') OR ($cotizacionesproductos.idcliente LIKE '%".$condicion."%') OR ($cotizacionesproductos.idusuario LIKE '%".$condicion."%') OR ($cotizacionesproductos.idempleado LIKE '%".$condicion."%') OR ($cotizacionesproductos.enviaradomicilio LIKE '%".$condicion."%') OR ($cotizacionesproductos.prioridad LIKE '%".$condicion."%') OR ($cotizacionesproductos.domicilioentrega LIKE '%".$condicion."%') OR ($cotizacionesproductos.observaciones LIKE '%".$condicion."%') OR ($cotizacionesproductos.estadoentrega LIKE '%".$condicion."%'))AND $cotizacionesproductos.estatus ='eliminado'";
			}else{
				$consulta="WHERE (($cotizacionesproductos.serie LIKE '%".$condicion."%') OR ($cotizacionesproductos.folio LIKE '%".$condicion."%') OR ($cotizacionesproductos.fecha LIKE '%".$condicion."%') OR ($cotizacionesproductos.hora LIKE '%".$condicion."%') OR ($cotizacionesproductos.estadopago LIKE '%".$condicion."%') OR ($cotizacionesproductos.estadofacturacion LIKE '%".$condicion."%') OR ($cotizacionesproductos.tipo LIKE '%".$condicion."%') OR ($cotizacionesproductos.subtotal LIKE '%".$condicion."%') OR ($cotizacionesproductos.impuestos LIKE '%".$condicion."%') OR ($cotizacionesproductos.total LIKE '%".$condicion."%') OR ($cotizacionesproductos.idcliente LIKE '%".$condicion."%') OR ($cotizacionesproductos.idusuario LIKE '%".$condicion."%') OR ($cotizacionesproductos.idempleado LIKE '%".$condicion."%') OR ($cotizacionesproductos.enviaradomicilio LIKE '%".$condicion."%') OR ($cotizacionesproductos.prioridad LIKE '%".$condicion."%') OR ($cotizacionesproductos.domicilioentrega LIKE '%".$condicion."%') OR ($cotizacionesproductos.observaciones LIKE '%".$condicion."%') OR ($cotizacionesproductos.estadoentrega LIKE '%".$condicion."%'))AND $cotizacionesproductos.estatus <>'eliminado'";
			}
		}else{
			if($papelera){
				$consulta="WHERE $cotizacionesproductos.estatus ='eliminado'";
			}else{
				$consulta="WHERE $cotizacionesproductos.estatus <>'eliminado'";
			}
		}
		return $consulta;
	}
	function comprobarCampo($campo, $valor, $tipoGuardado){
		$cotizacionesproductos = "cotizacionesproductos" . $_SESSION["idsucursal"];
		if($this->con->conectar()==true){
			//print_r($listaCampos);
			$resultado=mysqli_query($this->con->conect,"SELECT COUNT( * ) AS contador from $cotizacionesproductos WHERE $campo = '$valor'");
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
	
	function guardarCliente($cliente,$nombrecomercial,$estatus,$conexion){
		$validar=true;
		$this->globalIdCliente = $this->con->generarClave(2); /*Sincronizacion 1 */
		$consultaDet = "INSERT INTO clientes (idcliente, rfc, nombre, nic, limitecredito, diascredito, saldo, nombrecontacto, correocontacto, telefonocontacto, autorizardosis, autorizarproductos,comentarios, estatus) VALUES ('$this->globalIdCliente','-','$cliente','$nombrecomercial','0','0','0','-','-','-','-','-','-','$estatus')";
		//echo $consultaDet;
		if(!mysqli_query($conexion,$consultaDet)){
			$validar=false;
		}
		return $validar;
	}
	
	function guardarDomicilio($idgirocomercial,$tipovialidad,$calle,$noexterior,$nointerior,$colonia,$cp,$idzona,$nombrecomercial,$idsucursal,$idvendedor,$enviaradomicilio,$coordenadas,$ciudad, $estado, $referencia,$observacionesdomicilio,$estatus,$conexion){
		$validar=true;
		if($enviaradomicilio=="ENVIO A DOMICILIO"){//SOLAMENTE SI ES ENVIO A DOMICILIO CONTINUAR CON EL ALTA DEL DOMICILIO SI NO QUIERE DECIR QUE SE DIO DE ALTA UN CLIENTE NUEVO PERO SIN DOMICILIO DE ENTREGA
			$this->globalIdDomicilio=$this->con->generarClave(2); /*Sincronizacion 1 */
			$consultaDet = "INSERT INTO domicilios (iddomicilio, idcliente, tipovialidad, calle, noexterior, nointerior, nombrecomercial, colonia, cp, ciudad, estado, idzona, coordenadas, referencia, observaciones, idsucursal, idgirocomercial, validardosis, idempleado, estatus) VALUES ('$this->globalIdDomicilio','$this->globalIdCliente','$tipovialidad','$calle','$noexterior','$nointerior','$nombrecomercial','$colonia','$cp','$ciudad','$estado','$idzona','$coordenadas','$referencia','$observacionesdomicilio','$idsucursal','$idgirocomercial','NO','$idvendedor','$estatus')";
			//echo $consultaDet;
			if(!mysqli_query($conexion,$consultaDet)){
				$validar=false;
			}
		}
		return $validar;
	}
	
	
	function guardarCotizacion($serie,$folio,$fecha,$hora,$estadopago,$estadofacturacion,$tipo,$subtotal,$impuestos,$total,$costodeventa,$utilidad,$idusuario,$idempleado, $idsucursal,$enviaradomicilio,$fechaentrega,$horaentregainicio,$horaentregafin,$prioridad,$observaciones,$estadoentrega,$estatus,$conexion){
		$validar=true;
		$this->globalIdCotizacion=$this->con->generarClave(2); /*Sincronizacion 1 */
		if($this->globalIdDomicilio == "SELECCIONE DOMICILIO..."){
			$this->globalIdDomicilio=0;//ES ENTREGA EN SUCURSAL SIN DOMICILIO SELECCIONADO
		}
		//CONSULTA Y ACTUALIZA VARIABLE FOLIO 
		$Ofolio = new Folio;
		$folio=$Ofolio->obtenerFolio("PRODUCTOS");
		//INCREMENTAR EL FOLIO
		 if(!mysqli_query($conexion,"UPDATE Folios SET folioactual = folioactual + 1 WHERE idsucursal = '$idsucursal' AND asignacion = 'PRODUCTOS' AND estatus = 'activo'")){
			$validar=false;
		 }
		 
		 $ordenentrega = 0; 
		 $estadocredito = "NO AUTORIZADO"; 
		 $idruta = 0;
		 $observacionesentrega = "";
		 $estadoliquidacion = "NO LIQUIDADO";
		 $observacionesliquidacion = "";
		 $descripcioncredito ="";
		 if($enviaradomicilio=="ENTREGA EN SUCURSAL"){
		   $envio = "SIN ENVIO";
		 }
		 else{
		   $envio = "ENVIO REGULAR";
		 }
		 
		$cotizacionesproductos = "cotizacionesproductos" . $_SESSION["idsucursal"];
		$consultaDet = "INSERT INTO $cotizacionesproductos (idcotizacionproducto, serie, folio, fecha, hora, estadopago, estadofacturacion, tipo, subtotal, impuestos, total, costodeventa, utilidad, idcliente, idusuario, idempleado, idsucursal, enviaradomicilio, fechaentrega, horaentregainicio, horaentregafin, prioridad, iddomicilio, observaciones, estadoentrega, estadoentregaanterior, ordenentrega, estadocredito,descripcioncredito, idruta, idrutaanterior, observacionesentrega, estadoliquidacion, observacionesliquidacion, envio, estatus) VALUES ('$this->globalIdCotizacion','$serie','$folio','$fecha','$hora','$estadopago','$estadofacturacion','$tipo','$subtotal','$impuestos','$total','$costodeventa','$utilidad','$this->globalIdCliente','$idusuario','$idempleado', '$idsucursal','$enviaradomicilio','$fechaentrega','$horaentregainicio','$horaentregafin','$prioridad','$this->globalIdDomicilio','$observaciones','$estadoentrega', '', '$ordenentrega', '$estadocredito', '$descripcioncredito', '$idruta', '0', '$observacionesentrega', '$estadoliquidacion', '$observacionesliquidacion', '$envio', '$estatus')";
		//echo $consultaDet;
		if(!mysqli_query($conexion,$consultaDet)){
			$validar=false;
		}
		
		//INCREMENTAR SALDO CLIENTE
		if(!mysqli_query($conexion,"UPDATE clientes SET saldo = saldo+$total WHERE idcliente = '$this->globalIdCliente'")){
			$validar=false;
		}
		return $validar;
	}
	
	
	function guardarDetalles($lista,$idsucursal,$dividirventa,$montodivision,$asignacion,$conexion){
			//GUARDAR LOS DETALLES DE LA COTIZACI??N
			$arregloId=$this->descomponerArreglo(10,0,$lista);
			$arregloCantidad=$this->descomponerArreglo(10,1,$lista);//parametros (el numero de campos que completan el primer registro, la posici??n del arreglo que va a tomar, la lista)
			$arregloCostoProm=$this->descomponerArreglo(10,2,$lista);
			$arregloPrecio=$this->descomponerArreglo(10,3,$lista);
			$arregloPrecioNeto=$this->descomponerArreglo(10,4,$lista);
			$arregloImporte=$this->descomponerArreglo(10,5,$lista);
			$arregloImporteNeto=$this->descomponerArreglo(10,6,$lista);
			$arregloImpuestos=$this->descomponerArreglo(10,7,$lista);
			$arregloUtilidad=$this->descomponerArreglo(10,8,$lista);
			$arregloPesoTeorico=$this->descomponerArreglo(10,9,$lista);
			$con=0;
			$validar=true;
			//$totaldeservicios = count($arregloId);
			$importeacumulado = 0;
			$cantidadmaxima = 0;
			$consultarSiguienteProducto = true;
			$subfolio = 1;
			$conaux=1;
			while ($con < count($arregloId)){
				if($consultarSiguienteProducto == true){
					//SOLO CARGAR DATOS NUEVOS SI ES NUEVO PRODUCTO SI EL CICLO DIO LA VUELTA CON LA BANDERA EN FALSE SIGNIFICA QUE UAN NO SE TERMINA DE REGISTAR EL PRODUCTO PASADO
					$idproducto=$arregloId[$con];
					$cantidad=$arregloCantidad[$con];
				    $cantidadfija=$arregloCantidad[$con];
					$costoprom=$arregloCostoProm[$con];
					$precio = $arregloPrecio[$con];
					$precioneto=$arregloPrecioNeto[$con];
					$importe = $arregloImporte[$con];
					$importeneto=$arregloImporteNeto[$con];
					$impuestos = $arregloImpuestos[$con];
					$utilidad =$arregloUtilidad[$con];
					$pesoteorico =$arregloPesoTeorico[$con];
				}
				
				//$numservicio = $con + 1;
				
				//CHECAR SI SE VA A DIVIDIR LA VENTA POR MONTOS
				
				if($dividirventa=="SI"){
					//revisar el registro de detalles e ir acumulando hasta un paso antes de que se generen mas de $montodivision
					if((($cantidad * $precioneto) + $importeacumulado) > $montodivision){//3000+0 > 2000 0.67*1500=1005
						//ES MAYOR A 2000 POR LO TANTO SE REQUIERE PARTIR ESTE PRODUCTO PARA PODER HACER EL REGISTRO
						$break = false;
						while($cantidad > 0 && $break != true){//2 > 0
							//calcular el valor minimo e ir acumulando hasta que cantidad sea igual a cero
							$cantidadmaxima = $cantidadmaxima + 0.01;
							
							$importenetomaximoprueba = ($precioneto) * $cantidadmaxima; // precio neto unitario lo multiplico por la minima cantidad posible de venta 1500 * 0.01 = 15 hasta 1.33 * 1500 = 1995
							
							if(($importenetomaximoprueba + $importeacumulado) > 2000){//15 > 3000
								//SI SE LOGRO SOBREPASAR LOS 2000 ENTONCES SE DEBE REGISTRAR LA ULTIMA SUMA CONOCIDA QUE NO SOBREPASE Y LO TENEMOS EN LA VARIABLE $importenetomaximo  QUE AUN NO SE HA ACTUALIZADO
								//HACER EL REGISTRO EN LA BASE DE DATOS Y CONTINUAR
								
								 
								//$importenetomaximo;//SE DEBERIA REGISTRAR 1995 Y SOBRAR EN CANTIDAD  0.67
								//INSERT $importenetomaximo
								//INSERTAR LOS DETALLES PARCIALES LIGADOS AL SUBFOLIO QUE CORRESPONDA
								//********$cantidadfija = $cantidadfija - $cantidad;
								//$cantidadmaxima = $cantidadfija - $cantidad;
								$cantidadmaxima = $cantidadmaxima - 0.01;//seria la cantidad  que multiplicada por el precio aun no sobrepasa los 2000
								//$cantidad = $cantidad + 0.01;//le recuperamos el ultimo
								//$cantidadfija = $cantidadfija - $cantidadmaxima;
								
								$iddetallecotizacionproductos=$this->con->generarClave(1).$con.$conaux; /*Sincronizacion 1 */
								
								//AJUSTAR VALOR DE VARIABLES SEG??N LA CANTIDAD QUE VA A REGISTRARSE
								//$costoprom= ($costoprom/$cantidadfija) * $cantidad;//costoprom que tiene 
								//$precio=0;
								$importe=$cantidadmaxima*$precio;//se registra en importa la cantidad fraccionada que se va a registrar multiplicada por el precio sin impuestos para obtener el subtotal
								$impuestos=$importe * 0.16;//AQUI TENGO QUE AGREGAR TODO EL MODELO IMPUESTOS
								$utilidad=($precio-$costoprom)* $cantidadmaxima;
								$pesoteoricoaux=($pesoteorico/$cantidadfija) * $cantidadmaxima;// defini un auxiliar porque pesoteorico n odebe perder su valor para poder sacar la division
							
						
								$conaux = $conaux +1;
								$detallecotizacionesproductos = "detallecotizacionesproductos" . $_SESSION["idsucursal"];
								$consultaDet = "INSERT INTO $detallecotizacionesproductos (iddetallecotizacion, subfolio, idproducto, cantidad, costo, precio, subtotal, impuestos, total, utilidad, idcotizacionproducto, pesounitario, cantidadentregada) VALUES ('$iddetallecotizacionproductos','$subfolio','$idproducto','$cantidadmaxima','$costoprom','$precio','$importe','$impuestos','$importenetomaximo','$utilidad','$this->globalIdCotizacion','$pesoteoricoaux','0')";
								//echo "1:".$consultaDet;
								if(!mysqli_query($conexion,$consultaDet)){
									$validar=false;
								}
								$cantidadmaxima = 0;
								$importeacumulado = 0;//DEVOLVEMOS EL IMPORTE ACUMULADO A 0 YA QUE SE LLEGO AL LIMITE Y SE COMENZARA A ACUMULAR NUEVAMENTE
					            $subfolio = $subfolio + 1;//SE CAMBIA EL SUBFOLIO YA QUE REGISTRAMOS EL LIMITE
								
								//ROMPER CICLO
								$break = true;
							}
							else{
								//NO SE LOGRO SOBREPASAR LOS 2000 CONTINUAMOS ACUMULANDO EL IMPORTE MAXIMO Y DECRECIENDO LA CANTIDAD QUE RESTA 
								$importenetomaximo = ($precioneto) * $cantidadmaxima; //precio neto unitario lo multiplico por la minima cantidad posible de venta 1500 * 0.01 = 15
								$cantidad = $cantidad - 0.01;
							}
						}//fin ciclo $cantidad > 0
						
						if($cantidad > 0 ){//si sobro cantidad por rapartir no consultar siguiente producto sobra 0.67
							$consultarSiguienteProducto = false;
						}
						
					}
					else{//EL IMPORTE QUE SE INTENTA AGREGAR MAS EL IMPORTE ACUMULADO FUERON MENORES POR LO TANTO DEBEMOS REGISTRAR LO QUE ESTA EN EVALUACI??N CONTINUAR CON EL SIGUIENTE PRODUCTO SIN OLVIDAR ACUMULAR LO QUE LLEVAMOS DE ESTE SUBFOLIO
					    
						//ACUMULAR EL MONTO QUE NO LEGG?? A LOS 2000 PARA CONSIDERARLO SUMANDOLO CON EL PROXIMO PRODUCTO
					    $importeacumulado = $importeacumulado + ($cantidad * $precioneto); //0.67 * 1500 = 1005//lo acumulo proque podrian ahcerse varios registros si ncambiar subfolio hasta que se acumulen 2000
					    
						//INSERT CON EL SUBFOLIO ACTUAL HASTA QUE VUELVA A SOBREPASAR LOS 2000 Y SE GENERE OTRO SUBFOLIO
						
						$importeparcial = ($cantidad * $precioneto); //EL IMPORTE PARACIAL PODRIA SER TAMBIEN UN IMPORTE COMPLETO EN CASO DE QUE EL PRODUCTO NI SI QUIERA SOBREPASE LOS 2000 LLEGARIA COMPLETO A REGISTRARSE PERO DE NO SER ASI ES LA CANTIDAD QUE SOBRO DLE REGISTRO ANTERIOR POR EL PRECIO NETO
						//INSERTAR LOS DETALLES PARCIALES LIGADOS AL SUBFOLIO QUE CORRESPONDA
						$iddetallecotizacionproductos=$this->con->generarClave(2).$con; /*Sincronizacion 1 */
						//AJUSTAR VALOR DE VARIABLES SEG??N LA CANTIDAD QUE VA A REGISTRARSE
						//$costoprom= ($costoprom/$cantidadfija) * $cantidad;//costoprom que tiene 
						//$precio=0;
						$importe=$cantidad*$precio;//se registra en importa la cantidad fraccionada que se va a registrar multiplicada por el precio sin impuestos para obtener el subtotal
						$impuestos=$importe * 0.16;//AQUI TENGO QUE AGREGAR TODO EL MODELO IMPUESTOS
						$utilidad=($precio-$costoprom)* $cantidad;
						$pesoteoricoaux=($pesoteorico/$cantidadfija) * $cantidad;// defini un auxiliar porque pesoteorico n odebe perder su valor para poder sacar la division
						
						$detallecotizacionesproductos = "detallecotizacionesproductos" . $_SESSION["idsucursal"];
						$consultaDet = "INSERT INTO $detallecotizacionesproductos (iddetallecotizacion, subfolio, idproducto, cantidad, costo, precio, subtotal, impuestos, total, utilidad, idcotizacionproducto, pesounitario, cantidadentregada) VALUES ('$iddetallecotizacionproductos','$subfolio','$idproducto','$cantidad','$costoprom','$precio','$importe','$impuestos','$importeparcial ','$utilidad','$this->globalIdCotizacion','$pesoteoricoaux','0')";
						//echo "2:".$consultaDet;
						if(!mysqli_query($conexion,$consultaDet)){
							$validar=false;
					    }
						//MARCAR ETA VARIABLE PARA QUE SE CONSULTE EL SIGUIENTE PRODUCTO O EN SU DEFECTO TERMINE EL CICLO
						$consultarSiguienteProducto = true;
					}
				}
				else{
					//INSERTAR LOS DETALLES COMPLETOS TODOS LIGADOS AL SUBFOLIO 1
					$iddetallecotizacionproductos=$this->con->generarClave(3).$con; /*Sincronizacion 1 */
					
					$detallecotizacionesproductos = "detallecotizacionesproductos" . $_SESSION["idsucursal"];
					$consultaDet = "INSERT INTO $detallecotizacionesproductos (iddetallecotizacion, subfolio, idproducto, cantidad, costo, precio, subtotal, impuestos, total, utilidad, idcotizacionproducto, pesounitario, cantidadentregada) VALUES ('$iddetallecotizacionproductos','1','$idproducto','$cantidad','$costoprom','$precio','$importe','$impuestos','$importeneto','$utilidad','$this->globalIdCotizacion','$pesoteorico','0')";
					//echo "3:".$consultaDet;
					if(!mysqli_query($conexion,$consultaDet)){
						$validar=false;
					}
				}
				if($consultarSiguienteProducto == true){
					//SOLO AVANZAR EN LSO REGISTROS SI YA SE TERMINO DE REGISTRAR TODO EL PRODUCTO EN EVALUACI??N
				  $con++;
				}
		   }
		 
		return $validar;
	}//FIN WHILE ARREGLOID
	
	function guardarCotizacionOtros($serie,$folio,$fecha,$tipo,$monto,$idsucursal,$idempleado,$observaciones,$estatus,$conexion){
		$validar=true;
		if($monto > 0){//REGISTRAR COTIZACION DE OTROS
			$this->globalIdCotizacionOtros=$this->con->generarClave(2); /*Sincronizacion 1 */
			
			//CONSULTA Y ACTUALIZA VARIABLE FOLIO 
			$Ofolio = new Folio;
			$folio=$Ofolio->obtenerFolio("OTROS");
			//INCREMENTAR EL FOLIO
			 if(!mysqli_query($conexion,"UPDATE Folios SET folioactual = folioactual + 1 WHERE idsucursal = '$idsucursal' AND asignacion = 'OTROS' AND estatus = 'activo'")){
				$validar=false;
			 }
		 
			$cotizacionesotros = "cotizacionesotros" . $_SESSION["idsucursal"];
			$consultaDet = "INSERT INTO $cotizacionesotros (idcotizacionesotros, serie, folio, fecha, tipo, monto, idcliente, idsucursal, idempleado, observaciones, estatus) VALUES ('$this->globalIdCotizacionOtros','$serie','$folio','$fecha','EN PRODUCTOS','$monto','$this->globalIdCliente','$idsucursal','$idempleado','$observaciones','$estatus')";
			//echo $consultaDet;
			if(!mysqli_query($conexion,$consultaDet)){
				$validar=false;
			}
			
			//INCREMENTAR SALDO CLIENTE
			if(!mysqli_query($conexion,"UPDATE clientes SET saldo = saldo+$monto WHERE idcliente = '$this->globalIdCliente'")){
				$validar=false;
			}
		}
		return $validar;
	}
	
	function guardarDetallesOtros($lista,$estatus,$idsucursal,$idmodeloimpuestos,$monto,$asignacion,$conexion){
		$validar=true;
		if($monto > 0){//REGISTRAR COTIZACION DE OTROS
			//GUARDAR LOS DETALLES DE LA COTIZACI??N
			$arregloId=$this->descomponerArreglo(8,0,$lista);
			$arregloFecha=$this->descomponerArreglo(8,1,$lista);//parametros (el numero de campos que completan el primer registro, la posici??n del arreglo que va a tomar, la lista)
			$arregloCantidad=$this->descomponerArreglo(8,2,$lista);
			$arregloConcepto=$this->descomponerArreglo(8,3,$lista);
			$arregloUnidad=$this->descomponerArreglo(8,4,$lista);
			$arregloPrecio=$this->descomponerArreglo(8,5,$lista);
			$arregloImporte=$this->descomponerArreglo(8,6,$lista);
			$arregloImpuestos=$this->descomponerArreglo(8,7,$lista);
			$con=0;
			
			$totaldeservicios = count($arregloId);
			while ($con < count($arregloId)){
				$fecha=$arregloFecha[$con];
                $fechaFormateada = date("Y-m-d", strtotime($fecha));
				$cantidad=$arregloCantidad[$con];
				$concepto=$arregloConcepto[$con];
				$unidad = $arregloUnidad[$con];
				$precio=$arregloPrecio[$con];
				$totalFila = $arregloImporte[$con];
				$Impuestos =$arregloImpuestos[$con];
				$iddetallecotizacionotros=$this->con->generarClave(1).$con; /*Sincronizacion 1 */
				
				$numservicio = $con + 1;
				
				$detallecotizacionesotros = "detallecotizacionesotros" . $_SESSION["idsucursal"];
				$consultaDet = "INSERT INTO $detallecotizacionesotros (iddetallecotizacionotros, idcliente, fecha, cantidad, concepto, unidad, numeroservicio, totalservicios, idcotizacionotros, precio, impuestos, total, idmodeloimpuestos, estadopago, estadofacturacion, factura, estatus) VALUES ('$iddetallecotizacionotros','$this->globalIdCliente','$fechaFormateada','$cantidad','$concepto','$unidad','$numservicio','$totaldeservicios','$this->globalIdCotizacionOtros','$precio','$Impuestos','$totalFila','$idmodeloimpuestos','NO PAGADO','NO FACTURADO','-','$estatus')";
				//echo $consultaDet;
				if(!mysqli_query($conexion,$consultaDet)){
					$validar=false;
				}
				$con++;
		   }
		   //INCREMENTAR EL FOLIO
		   if(!mysqli_query($conexion,"UPDATE Folios SET folioactual = folioactual + 1 WHERE idsucursal = '$idsucursal' AND asignacion = '$asignacion' AND estatus = 'activo'")){
			  $validar=false;
		   }
		}
		return $validar;
	}
	

function guardar($clienteSeleccionado,$domicilioSeleccionado,$cliente,$idgirocomercial,$tipovialidad,$calle,$noexterior,$nointerior,$colonia,$cp,$idzona,$nombrecomercial,$serie,$folio,$fecha,$hora,$estadopago,$estadofacturacion,$tipo,$subtotal,$impuestos,$total,$costodeventa,$utilidad,$observaciones,$idcliente,$idusuario,$idempleado,$idsucursal,$iddomicilio,$enviaradomicilio,$fechaentrega,$horaentregainicio,$horaentregafin,$prioridad,$coordenadas,$ciudad, $estado, $referencia,$observacionesdomicilio,$estadoentrega,$estatus,$lista,$dividirventa,$montodivision,$serieotros,$foliootros,$fechaotros,$tipootros,$montootros,$observacionesotros,$listaOtros,$impuestosotros,$subtotalotros,$idmodeloimpuestosotros,$estatusotros){
		
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cotizacionesproductos']['guardar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		//asigmanos los valores de las id de cliente y domicilio a las variables globales puede que vengan con valor o no pero a medida que se avanza en las funciones se les da valor para guardar las ids correctas
		$this->globalIdCliente = $idcliente;
		$this->globalIdDomicilio = $iddomicilio;
		$this->globalIdCotizacion = 0;
		$this->globalIdCotizacionOtros = 0;
		
		$validar = "fracaso";
		if($this->con->conectar()==true){
				$this->con->conect->autocommit(false); //INICO DE TRANSACCION
				
				//REVISAR SI VA A TENER QUE GUARDARSE EL CLIENTE CON SU DOMICILIO Y SU PRIMER CONTACTO PARA ALMACENARLO Y LUEGO USAR ESOS ID PARA LIGARLOS A LA COTIZACI??N
				if($clienteSeleccionado==false){
					//NO SE SELECCIONO CLIENTE ASI QUE DEBEMOS GUARDARLO COMO NUEVO EN LA BASE DE DATOS JUNTO CON EL DOMICILIO Y CONTACTO
					if($this->guardarCliente($cliente,$cliente,$estatus,$this->con->conect)){//guarda el cliente nuevo
					   
							if($this->guardarDomicilio($idgirocomercial,$tipovialidad,$calle,$noexterior,$nointerior,$colonia,$cp,$idzona,$nombrecomercial,$idsucursal,$idempleado,$enviaradomicilio,$coordenadas,$ciudad, $estado, $referencia,$observacionesdomicilio,$estatus,$this->con->conect)){//guarda domicilio nuevo
							
								if($this->guardarCotizacion($serie,$folio,$fecha,$hora,$estadopago,$estadofacturacion,$tipo,$subtotal,$impuestos,$total,$costodeventa,$utilidad,$idusuario,$idempleado, $idsucursal,$enviaradomicilio,$fechaentrega,$horaentregainicio,$horaentregafin,$prioridad,$observaciones,$estadoentrega,$estatus,$this->con->conect)){//guarda la cotizaci??n
									
									if($this->guardarDetalles($lista,$idsucursal,$dividirventa,$montodivision,'PRODUCTOS',$this->con->conect)){//guarda los detalles de la cotizaci??n*/
										
										$Omovimiento = new Movimiento();
										if($Omovimiento->guardarRef("salida","VENTA",$fecha,$hora,$serie."-".$folio,$idsucursal,"cotizacionesproductos",$this->globalIdCotizacion,"","PENDIENTE","activo",$lista,$this->con->conect)){
											if($this->guardarCotizacionOtros($serieotros,$foliootros,$fechaotros,$tipootros,$montootros,$idsucursal,$idempleado,$observacionesotros,$estatusotros,$this->con->conect)){//guarda la cotizaci??n
												 if($this->guardarDetallesOtros($listaOtros,$estatusotros,$idsucursal,$idmodeloimpuestosotros,$montootros,'OTROS',$this->con->conect)){//guarda los detalles de la cotizaci??n*/
													//FINALIZAR TRANSACCION
													$this->con->conect->commit(); //COMMIT EN CASO DE QUE TODAS LAS TRANSACCIONES TENGAN EXITO
													$validar = "exito";
													
													//DEBERIAN IR LOS REGISTROS DE TODAS LAS BITACORAS AQUI
													//BITACORA
													if ($_SESSION['bitacora']=="si" and $validar == "exito"){
														$descripcionB="agreg&oacute; un nuevo registro en la tabla cotizacionesproductos ";
														$this->registrarBitacora("guardar",$descripcionB);
													}
												}
												else{//GUARDARDETALLESOTROS
													$this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASE
													$validar = "fracaso";
												}
											}
											else{//GUARDARCOTIZACI??NOTROS
												$this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASE
												$validar = "fracaso";
											}
										}
										else{//GUARDARSALIDA DE PRODUCTOS
											$this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASE
											$validar = "fracaso";
										}
									}
									else{//GUARDARDETALLES
										$this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASE
										$validar = "fracaso";
									}
								}
								else{//GUARDARCOTIZACION
									$this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASE
									$validar = "fracaso";
								}
							}//GUARDARDOMICILIO
							else{
								$this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASE
								$validar = "fracaso";
							}
					}//GUARDARCLIENTE
					else{
						$this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASE
						$validar = "fracaso";
					}
					
				}
				else{
					//SE SELECCIONO CLIENTE REVISAR SI TAMBIEN SE SELECCIONO DOMICILIO O SI VA A SER DOMICILIO NUEVO
					if($domicilioSeleccionado==false){
						//NO SE SELECCIONO DOMICILIO ENTONCES DARLO DE ALTA Y LIGARLO AL CLIENTE SELECCIONADO
						
						if($this->guardarDomicilio($idgirocomercial,$tipovialidad,$calle,$noexterior,$nointerior,$colonia,$cp,$idzona,$nombrecomercial,$idsucursal,$idempleado,$enviaradomicilio,$coordenadas,$ciudad, $estado, $referencia,$observacionesdomicilio,$estatus,$this->con->conect)){//guarda domicilio nuevo
							
							if($this->guardarCotizacion($serie,$folio,$fecha,$hora,$estadopago,$estadofacturacion,$tipo,$subtotal,$impuestos,$total,$costodeventa,$utilidad,$idusuario,$idempleado, $idsucursal,$enviaradomicilio,$fechaentrega,$horaentregainicio,$horaentregafin,$prioridad,$observaciones,$estadoentrega,$estatus,$this->con->conect)){//guarda la cotizaci??n
									
									if($this->guardarDetalles($lista,$idsucursal,$dividirventa,$montodivision,'PRODUCTOS',$this->con->conect)){//guarda los detalles de la cotizaci??n*/
									
									      if($this->guardarCotizacionOtros($serieotros,$foliootros,$fechaotros,$tipootros,$montootros,$idsucursal,$idempleado,$observacionesotros,$estatusotros,$this->con->conect)){//guarda la cotizaci??n
											  $Omovimiento = new Movimiento();
											  if($Omovimiento->guardarRef("salida","VENTA",$fecha,$hora,$serie."-".$folio,$idsucursal,"cotizacionesproductos",$this->globalIdCotizacion,"","PENDIENTE","activo",$lista,$this->con->conect)){
												  if($this->guardarDetallesOtros($listaOtros,$estatusotros,$idsucursal,$idmodeloimpuestosotros,$montootros,'OTROS',$this->con->conect)){//guarda los detalles de la cotizaci??n*/
														$this->con->conect->commit(); //COMMIT EN CASO DE QUE TODAS LAS TRANSACCIONES TENGAN EXITO
														$validar = "exito";
														
														//DEBERIAN IR LOS REGISTROS DE TODAS LAS BITACORAS AQUI
														//BITACORA
														if ($_SESSION['bitacora']=="si" and $validar == "exito"){
															$descripcionB="agreg&oacute; un nuevo registro en la tabla cotizaciones ";
															$this->registrarBitacora("guardar",$descripcionB);
														}
													 }
													else{//GUARDARDETALLESOTROS
														$this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASE
														$validar = "fracaso";
													}
												}
												else{//GUARDARCOTIZACIONOTROS
													$this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASE
													$validar = "fracaso";
												}
										}
										else{//GUARDARMOVIMIENTOSALIDAALMACEN
											$this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASE
											$validar = "fracaso";
										}
								}
								else{//GUARDARDETALLES
									$this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASE
									$validar = "fracaso";
								}
							}
							else{//GUARDARCOTIZACION
								$this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASE
								$validar = "fracaso";
							}
						}//GUARDARDOMICILIO
						else{
							$this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASE
							$validar = "fracaso";
						}
						
					}
					else{
					  //SE SELECCIONO DOMICILIO GUARDAR LA COTIZACION CON EL CLIENTE Y DOMICILIO SELECCIONADO
					      if($this->guardarCotizacion($serie,$folio,$fecha,$hora,$estadopago,$estadofacturacion,$tipo,$subtotal,$impuestos,$total,$costodeventa,$utilidad,$idusuario,$idempleado, $idsucursal,$enviaradomicilio,$fechaentrega,$horaentregainicio,$horaentregafin,$prioridad,$observaciones,$estadoentrega,$estatus,$this->con->conect)){//guarda la cotizaci??n
									//REVISION DE ARREGLO Y VARIABLES ListaSalida en HTML debe estar visible
								//var_dump ($lista);
								//echo "lista".$lista,"tipo".$tipo,"estatus".$estatus,"idsucursal".$idsucursal,"idmodelo".$idmodeloimpuestos;
								if($this->guardarDetalles($lista,$idsucursal,$dividirventa,$montodivision,'PRODUCTOS',$this->con->conect)){//guarda los detalles de la cotizaci??n
								
									$Omovimiento = new Movimiento();
									if($Omovimiento->guardarRef("salida","VENTA",$fecha,$hora,$serie."-".$folio,$idsucursal,"cotizacionesproductos",$this->globalIdCotizacion,"","PENDIENTE","activo",$lista,$this->con->conect)){
										if($this->guardarCotizacionOtros($serieotros,$foliootros,$fechaotros,$tipootros,$montootros,$idsucursal,$idempleado,$observacionesotros,$estatusotros,$this->con->conect)){//guarda la cotizaci??n
											 if($this->guardarDetallesOtros($listaOtros,$estatusotros,$idsucursal,$idmodeloimpuestosotros,$montootros,'OTROS',$this->con->conect)){//guarda los detalles de la cotizaci??n*/
												$this->con->conect->commit(); //COMMIT EN CASO DE QUE TODAS LAS TRANSACCIONES TENGAN EXITO
												$validar = "exito";
												
												//DEBERIAN IR LOS REGISTROS DE TODAS LAS BITACORAS AQUI
												//BITACORA
												if ($_SESSION['bitacora']=="si" and $validar == "exito"){
													$descripcionB="agreg&oacute; un nuevo registro en la tabla cotizaciones ";
													$this->registrarBitacora("guardar",$descripcionB);
												}
											}
											else{//GUARDARDETALLESOTROS
												$this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASE
												$validar = "fracaso";
											}
										}
										else{//GUARDARCOTIZACIONOTROS
											$this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASE
											$validar = "fracaso";
										}
								    }
									else{//GUARDARMOVIMIENTOSALIDAALMACEN
										$this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASE
										$validar = "fracaso";
									}
								}
								else{//GUARDARDETALLES
									$this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASE
									$validar = "fracaso";
								}
							}
							else{//GUARDARCOTIZACION
								$this->con->conect->rollback(); //ROLLBACK EN CASO DE QUE ALGUNA TRANSACCION FRACASE
								$validar = "fracaso";
							}
					}//fin else
				}//fin if $clienteSeleccionado==false
		}//fin If conectar
		return $validar;
	}
	
	function actualizar($serie,$folio,$fecha,$hora,$estadopago,$estadofacturacion,$tipo,$subtotal,$impuestos,$total,$costodeventa,$utilidad,$idcliente,$idusuario,$idempleado,$enviaradomicilio,$fechaentrega,$horaentregainicio,$horaentregafin,$prioridad,$iddomicilio,$coordenadas,$observaciones,$estadoentrega,$estatus,$idcotizacionproducto){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cotizacionesproductos']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			if($this->comprobarCampo("idcotizacionproducto",$idcotizacionproducto, "modificar")){
				return "idcotizacionproductoExiste";
			}else{
				
				$cotizacionesproductos = "cotizacionesproductos" . $_SESSION["idsucursal"];
				$consultaDet = "UPDATE $cotizacionesproductos SET serie='$serie', folio='$folio', fecha='$fecha', hora='$hora', estadopago='$estadopago', estadofacturacion='$estadofacturacion', tipo='$tipo', subtotal='$subtotal', impuestos='$impuestos', total='$total', costodeventa='$costodeventa', utilidad='$utilidad', idcliente='$idcliente', idusuario='$idusuario', idempleado='$idempleado', enviaradomicilio='$enviaradomicilio', fechaentrega='$fechaentrega', horaentregainicio='$horaentregainicio', horaentregafin='$horaentregafin', prioridad='$prioridad', iddomicilio='$iddomicilio', observaciones='$observaciones', estadoentrega='$estadoentrega', estatus='$estatus' WHERE idcotizacionproducto='$idcotizacionproducto'";
				//echo $consultaDet;
				if(mysqli_query($this->con->conect,$consultaDet)){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="modific&oacute; el registro ID: $idcotizacionproducto, de la tabla cotizacionesproductos ";
						$this->registrarBitacora("modificar",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
		}
	}
	
	function bloquear($idcotizacionproducto){
		
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cotizacionesproductos']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			$cotizacionesproductos = "cotizacionesproductos" . $_SESSION["idsucursal"];
			return mysqli_query($this->con->conect,"UPDATE $cotizacionesproductos SET estatus ='bloqueado' WHERE idcotizacionproducto = '$idcotizacionproducto'");
		}
	}
	
	function cambiarEstatus($idcotizacionproducto,$estatus){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cotizacionesproductos']['modificar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		
		if($this->con->conectar()==true){
			//REQUIERE CAMPO 'estatus' EN LA TABLA
			$cotizacionesproductos = "cotizacionesproductos" . $_SESSION["idsucursal"];
			if(mysqli_query($this->con->conect,"UPDATE $cotizacionesproductos SET estatus ='$estatus' WHERE idcotizacionproducto = '$idcotizacionproducto'")){
				//BITACORA
				if ($_SESSION['bitacora']=="si"){
					$descripcionB="alter&oacute; el estatus del registro a: $estatus, de la tabla cotizacionesproductos ";
					$this->registrarBitacora("modificar",$descripcionB);
				}
				return "exito";
			}else{
				return "fracaso";
			}
		}
	}
	
	function autorizaSalida($idcotizacionproducto,$observaciones){
		
		if($this->con->conectar()==true){
			$cotizacionesproductos = "cotizacionesproductos" . $_SESSION["idsucursal"];
			$consultaDet = "UPDATE $cotizacionesproductos SET estadoentrega='ENTREGADO', observaciones='$observaciones' WHERE idcotizacionproducto='$idcotizacionproducto'";
			if(mysqli_query($this->con->conect,$consultaDet)){
				return "exito";
			}else{
				return "fracaso";
			}
		}
	}
	
	function mostrarIndividual($idcotizacionproducto){
		$cotizacionesproductos = "cotizacionesproductos" . $_SESSION["idsucursal"];
		if($this->con->conectar()==true){
			return mysqli_query($this->con->conect,"SELECT 
			        $cotizacionesproductos.idcotizacionproducto,
					$cotizacionesproductos.serie,
					$cotizacionesproductos.folio,
					$cotizacionesproductos.fecha,
					$cotizacionesproductos.hora,
					$cotizacionesproductos.estadopago,
					$cotizacionesproductos.estadofacturacion,
					$cotizacionesproductos.tipo,
					$cotizacionesproductos.subtotal,
					$cotizacionesproductos.impuestos,
					$cotizacionesproductos.total,
					$cotizacionesproductos.costodeventa,
					$cotizacionesproductos.utilidad,
					$cotizacionesproductos.idcliente,
					$cotizacionesproductos.idusuario,
					$cotizacionesproductos.idempleado,
					$cotizacionesproductos.enviaradomicilio,
					$cotizacionesproductos.fechaentrega,
					$cotizacionesproductos.horaentregainicio,
					$cotizacionesproductos.horaentregafin,
					$cotizacionesproductos.prioridad,
					$cotizacionesproductos.iddomicilio,
					$cotizacionesproductos.observaciones,
					$cotizacionesproductos.estadoentrega,
					$cotizacionesproductos.estadoentrega,
					$cotizacionesproductos.observacionesentrega,
					$cotizacionesproductos.estadocredito,
					$cotizacionesproductos.descripcioncredito,
					$cotizacionesproductos.estadoliquidacion,
					$cotizacionesproductos.estatus,
					domicilios.tipovialidad AS tipovialidad,
					domicilios.calle AS calle,
					domicilios.noexterior AS noexterior,
					domicilios.nointerior AS nointerior,
					domicilios.colonia AS colonia,
					domicilios.ciudad AS ciudad,
					domicilios.estado AS estado,
					domicilios.cp AS cp,
					domicilios.coordenadas AS coordenadas,
					usuarios.nombre AS usuario,
					empleados.nombre AS vendedor,
					clientes.nombre AS cliente
					FROM $cotizacionesproductos 
					INNER JOIN usuarios ON $cotizacionesproductos.idusuario=usuarios.idusuario
					INNER JOIN empleados ON $cotizacionesproductos.idempleado=empleados.idempleado
					INNER JOIN clientes ON $cotizacionesproductos.idcliente=clientes.idcliente
					INNER JOIN domicilios ON $cotizacionesproductos.iddomicilio=domicilios.iddomicilio
		            WHERE idcotizacionproducto='$idcotizacionproducto'");
		}
	}
	
	
	function mostrar($campoOrden, $orden, $inicial, $cantidadamostrar, $condicion, $papelera){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cotizacionesproductos']['consultar'])){
			return "denegado";
			exit;
		}
		$cotizacionesproductos = "cotizacionesproductos" . $_SESSION["idsucursal"];
		$condicion= trim($condicion);
		$where=$this->armarConsulta($condicion,$papelera);
		
		
		$consulta = "SELECT 
		            SQL_CALC_FOUND_ROWS
					$cotizacionesproductos.idcotizacionproducto,
					$cotizacionesproductos.serie,
					$cotizacionesproductos.folio,
					$cotizacionesproductos.fecha,
					$cotizacionesproductos.hora,
					$cotizacionesproductos.estadopago,
					$cotizacionesproductos.estadofacturacion,
					$cotizacionesproductos.tipo,
					$cotizacionesproductos.subtotal,
					$cotizacionesproductos.impuestos,
					$cotizacionesproductos.total,
					$cotizacionesproductos.costodeventa,
					$cotizacionesproductos.utilidad,
					$cotizacionesproductos.idcliente,
					$cotizacionesproductos.idusuario,
					$cotizacionesproductos.idempleado,
					$cotizacionesproductos.enviaradomicilio,
					$cotizacionesproductos.fechaentrega,
					$cotizacionesproductos.horaentregainicio,
					$cotizacionesproductos.horaentregafin,
					$cotizacionesproductos.prioridad,
					$cotizacionesproductos.iddomicilio,
					$cotizacionesproductos.observaciones,
					$cotizacionesproductos.estadoentrega,
					$cotizacionesproductos.estadoentrega,
					$cotizacionesproductos.observacionesentrega,
					$cotizacionesproductos.estadocredito,
					$cotizacionesproductos.descripcioncredito,
					$cotizacionesproductos.estadoliquidacion,
					$cotizacionesproductos.estatus,
					domicilios.tipovialidad AS tipovialidad,
					domicilios.calle AS calle,
					domicilios.noexterior AS noexterior,
					domicilios.nointerior AS nointerior,
					domicilios.colonia AS colonia,
					domicilios.ciudad AS ciudad,
					domicilios.estado AS estado,
					domicilios.cp AS cp,
					usuarios.nombre AS usuario,
					empleados.nombre AS vendedor,
					clientes.nombre AS cliente
					FROM $cotizacionesproductos 
					INNER JOIN usuarios ON $cotizacionesproductos.idusuario=usuarios.idusuario
					INNER JOIN empleados ON $cotizacionesproductos.idempleado=empleados.idempleado
					INNER JOIN clientes ON $cotizacionesproductos.idcliente=clientes.idcliente
					INNER JOIN domicilios ON $cotizacionesproductos.iddomicilio=domicilios.iddomicilio
					$where
					ORDER BY $campoOrden $orden
					LIMIT $inicial, $cantidadamostrar
					";
					//echo $consulta;
		if($this->con->conectar()==true){
			$resultado1 = mysqli_query($this->con->conect,$consulta);
			$resultado2 =  mysqli_query($this->con->conect,"SELECT FOUND_ROWS() AS contador");
			$extractor = mysqli_fetch_assoc($resultado2);
			return array ($resultado1,$extractor["contador"]);
		}
	}
	
	function mostrarRuta($campoOrden, $orden, $inicial, $cantidadamostrar, $busqueda, $papelera, $idruta){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cotizacionesproductos']['consultar'])){
			return "denegado";
			exit;
		}
		$cotizacionesproductos = "cotizacionesproductos" . $_SESSION["idsucursal"];
		
		$where="";
		$where="WHERE $cotizacionesproductos.idruta = $idruta";
		
		$consulta = "SELECT 
					SQL_CALC_FOUND_ROWS
					$cotizacionesproductos.idcotizacionproducto,
					$cotizacionesproductos.serie,
					$cotizacionesproductos.folio,
					$cotizacionesproductos.fecha,
					$cotizacionesproductos.hora,
					$cotizacionesproductos.estadopago,
					$cotizacionesproductos.estadofacturacion,
					$cotizacionesproductos.tipo,
					$cotizacionesproductos.subtotal,
					$cotizacionesproductos.impuestos,
					$cotizacionesproductos.total,
					$cotizacionesproductos.costodeventa,
					$cotizacionesproductos.utilidad,
					$cotizacionesproductos.idcliente,
					$cotizacionesproductos.idusuario,
					$cotizacionesproductos.idempleado,
					$cotizacionesproductos.enviaradomicilio,
					$cotizacionesproductos.fechaentrega,
					$cotizacionesproductos.horaentregainicio,
					$cotizacionesproductos.horaentregafin,
					$cotizacionesproductos.prioridad,
					$cotizacionesproductos.iddomicilio,
					$cotizacionesproductos.observaciones,
					$cotizacionesproductos.estadoentrega,
					$cotizacionesproductos.estadoentrega,
					$cotizacionesproductos.observacionesentrega,
					$cotizacionesproductos.estadocredito,
					$cotizacionesproductos.descripcioncredito,
					$cotizacionesproductos.estadoliquidacion,
					$cotizacionesproductos.estatus,
					domicilios.tipovialidad AS tipovialidad,
					domicilios.calle AS calle,
					domicilios.noexterior AS noexterior,
					domicilios.nointerior AS nointerior,
					domicilios.colonia AS colonia,
					domicilios.ciudad AS ciudad,
					domicilios.estado AS estado,
					domicilios.cp AS cp,
					usuarios.nombre AS usuario,
					empleados.nombre AS vendedor,
					clientes.nombre AS cliente
					FROM $cotizacionesproductos 
					INNER JOIN usuarios ON $cotizacionesproductos.idusuario=usuarios.idusuario
					INNER JOIN empleados ON $cotizacionesproductos.idempleado=empleados.idempleado
					INNER JOIN clientes ON $cotizacionesproductos.idcliente=clientes.idcliente
					INNER JOIN domicilios ON $cotizacionesproductos.iddomicilio=domicilios.iddomicilio
					$where
					GROUP BY $cotizacionesproductos.idcotizacionproducto 
					ORDER BY $cotizacionesproductos.ordenentrega ASC 
					";
		
					//echo $consulta; //REVISAR CONSULTA
		/*if($this->con->conectar()==true){
			return $resultado=mysqli_query($this->con->conect,$consulta);
		}*/
		
		if($this->con->conectar()==true){
			$resultado1 = mysqli_query($this->con->conect,$consulta);
			$resultado2 =  mysqli_query($this->con->conect,"SELECT FOUND_ROWS() AS contador");
			$extractor = mysqli_fetch_assoc($resultado2);
			//echo $extractor["contador"];
			return array ($resultado1,$extractor["contador"]);
		}
	}
	
	function mostrarA($campoOrden, $orden, $inicial, $cantidadamostrar, $busqueda, $papelera, $idcliente,$iddomicilio,$idzona,$idsucursal,$tipo,$filtrarfecha,$fechainicio,$fechafin,$excel=""){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cotizacionesproductos']['consultar'])){
			return "denegado";
			exit;
		}
		$condicion= trim($busqueda);
		//$where=$this->armarConsulta($condicion,$papelera);
		
		$cotizacionesproductos = "cotizacionesproductos" . $_SESSION["idsucursal"];
		
		$consultaCliente = "";
		$consultaDomicilio = "";
		$consultaZona = "";
		$consultaSucursal = "";
		$consultaEstado = "";
		$consultaFecha = "";
		$consultaEstatus = "";
		$limites = "";
		
		if ($idcliente!=""){
			$consultaCliente=" AND $cotizacionesproductos.idcliente='$idcliente'";
		}
		
		if ($iddomicilio!="" && $iddomicilio!="TODOS"){
			$consultaDomicilio=" AND $cotizacionesproductos.iddomicilio='$iddomicilio'";
		}
		
		/*if ($idzona!="TODAS"){
			$consultaZona=" AND domicilios.idzona='$idzona'";
		}*/
		if ($idsucursal!="TODAS"){
			$consultaSucursal=" AND $cotizacionesproductos.idsucursal='$idsucursal'";
		}
		
		if ($tipo!=""){
			$consultaEstado=" AND $cotizacionesproductos.tipo='$tipo'";
		}
		
		if ($filtrarfecha=="SI"){
			$consultaFecha=" AND $cotizacionesproductos.fecha >= '$fechainicio' AND $cotizacionesproductos.fecha <= '$fechafin' ";
		}else{
			$consultaFecha="";
		}
		
		if($papelera){
				$consultaEstatus="AND $cotizacionesproductos.estatus ='eliminado'";
		}else{
				$consultaEstatus="AND $cotizacionesproductos.estatus <>'eliminado'";
		}
		
		//$SoloAceptados = "AND cotizaciones.estado ='ACEPTADA' ";
		
		if($excel!="SI"){
			$limites="LIMIT $inicial, $cantidadamostrar";
		}
		
		$where="";
		$where="WHERE $cotizacionesproductos.idcotizacionproducto<>0 
		$consultaCliente
		$consultaDomicilio
		$consultaZona
		$consultaSucursal
		$consultaEstado
		$consultaFecha
		$consultaEstatus";
		
		$consulta = "SELECT 
					SQL_CALC_FOUND_ROWS
					$cotizacionesproductos.idcotizacionproducto,
					$cotizacionesproductos.serie,
					$cotizacionesproductos.folio,
					$cotizacionesproductos.fecha,
					$cotizacionesproductos.hora,
					$cotizacionesproductos.estadopago,
					$cotizacionesproductos.estadofacturacion,
					$cotizacionesproductos.tipo,
					$cotizacionesproductos.subtotal,
					$cotizacionesproductos.impuestos,
					$cotizacionesproductos.total,
					$cotizacionesproductos.costodeventa,
					$cotizacionesproductos.utilidad,
					$cotizacionesproductos.idcliente,
					$cotizacionesproductos.idusuario,
					$cotizacionesproductos.idempleado,
					$cotizacionesproductos.enviaradomicilio,
					$cotizacionesproductos.fechaentrega,
					$cotizacionesproductos.horaentregainicio,
					$cotizacionesproductos.horaentregafin,
					$cotizacionesproductos.prioridad,
					$cotizacionesproductos.iddomicilio,
					$cotizacionesproductos.observaciones,
					$cotizacionesproductos.estadoentrega,
					$cotizacionesproductos.observacionesentrega,
					$cotizacionesproductos.estadocredito,
					$cotizacionesproductos.descripcioncredito,
					$cotizacionesproductos.estadoliquidacion,
					$cotizacionesproductos.estatus,
					domicilios.tipovialidad AS tipovialidad,
					domicilios.calle AS calle,
					domicilios.noexterior AS noexterior,
					domicilios.nointerior AS nointerior,
					domicilios.colonia AS colonia,
					domicilios.ciudad AS ciudad,
					domicilios.estado AS estado,
					domicilios.cp AS cp,
					usuarios.nombre AS usuario,
					empleados.nombre AS vendedor,
					clientes.nombre AS cliente
					FROM $cotizacionesproductos 
					INNER JOIN usuarios ON $cotizacionesproductos.idusuario=usuarios.idusuario
					INNER JOIN empleados ON $cotizacionesproductos.idempleado=empleados.idempleado
					INNER JOIN clientes ON $cotizacionesproductos.idcliente=clientes.idcliente
					INNER JOIN domicilios ON $cotizacionesproductos.iddomicilio=domicilios.iddomicilio
					$where
					GROUP BY $cotizacionesproductos.idcotizacionproducto 
					ORDER BY $campoOrden $orden
					$limites
					";
		
					//echo $consulta; //REVISAR CONSULTA
		/*if($this->con->conectar()==true){
			return $resultado=mysqli_query($this->con->conect,$consulta);
		}*/
		
		if($this->con->conectar()==true){
			$resultado1 = mysqli_query($this->con->conect,$consulta);
			$resultado2 =  mysqli_query($this->con->conect,"SELECT FOUND_ROWS() AS contador");
			$extractor = mysqli_fetch_assoc($resultado2);
			//echo $extractor["contador"];
			return array ($resultado1,$extractor["contador"]);
		}
	}
	
	function mostrarFacturacion($campoOrden, $orden, $inicial, $cantidadamostrar, $busqueda, $papelera, $idcliente,$iddomicilio,$idzona,$idsucursal,$tipo,$filtrarfecha,$fechainicio,$fechafin,$excel=""){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cotizacionesproductos']['consultar'])){
			return "denegado";
			exit;
		}
		$condicion= trim($busqueda);
		//$where=$this->armarConsulta($condicion,$papelera);
		
		$cotizacionesproductos = "cotizacionesproductos" . $_SESSION["idsucursal"];
		$detallecotizacionesproductos = "detallecotizacionesproductos" . $_SESSION["idsucursal"];
		
		$consultaCliente = "";
		$consultaDomicilio = "";
		$consultaZona = "";
		$consultaSucursal = "";
		$consultaEstado = "";
		$consultaFecha = "";
		$consultaEstatus = "";
		$limites = "";
		
		if ($idcliente!=""){
			$consultaCliente=" AND $cotizacionesproductos.idcliente='$idcliente'";
		}
		
		if ($iddomicilio!="" && $iddomicilio!="TODOS"){
			$consultaDomicilio=" AND $cotizacionesproductos.iddomicilio='$iddomicilio'";
		}
		
		/*if ($idzona!="TODAS"){
			$consultaZona=" AND domicilios.idzona='$idzona'";
		}*/
		if ($idsucursal!="TODAS"){
			$consultaSucursal=" AND $cotizacionesproductos.idsucursal='$idsucursal'";
		}
		
		if ($tipo!=""){
			$consultaEstado=" AND $cotizacionesproductos.tipo='$tipo'";
		}
		
		if ($filtrarfecha=="SI"){
			$consultaFecha=" AND $cotizacionesproductos.fecha >= '$fechainicio' AND $cotizacionesproductos.fecha <= '$fechafin' ";
		}else{
			$consultaFecha="";
		}
		
		if($papelera){
				$consultaEstatus="AND $cotizacionesproductos.estatus ='eliminado'";
		}else{
				$consultaEstatus="AND $cotizacionesproductos.estatus <>'eliminado'";
		}
		
		//$SoloAceptados = "AND cotizaciones.estado ='ACEPTADA' ";
		
		if($excel!="SI"){
			$limites="LIMIT $inicial, $cantidadamostrar";
		}
		
		$where="";
		$where="WHERE $cotizacionesproductos.idcotizacionproducto<>0 
		$consultaCliente
		$consultaDomicilio
		$consultaZona
		$consultaSucursal
		$consultaEstado
		$consultaFecha
		$consultaEstatus";
		
		$consulta = "SELECT 
					SQL_CALC_FOUND_ROWS
					SUM($detallecotizacionesproductos.total) AS TotalDetalles,
					$detallecotizacionesproductos.iddetallecotizacion,
					$detallecotizacionesproductos.subfolio,
					$cotizacionesproductos.idcotizacionproducto,
					$cotizacionesproductos.serie,
					$cotizacionesproductos.folio,
					$cotizacionesproductos.fecha,
					$cotizacionesproductos.hora,
					$cotizacionesproductos.estadopago,
					$cotizacionesproductos.estadofacturacion,
					$cotizacionesproductos.tipo,
					$cotizacionesproductos.total,
					$cotizacionesproductos.idcliente,
					$cotizacionesproductos.estadoliquidacion,
					$cotizacionesproductos.estatus,
					clientes.nombre AS cliente
					FROM $detallecotizacionesproductos
					
					INNER JOIN $cotizacionesproductos ON $cotizacionesproductos.idcotizacionproducto=$detallecotizacionesproductos.idcotizacionproducto
					INNER JOIN clientes ON $cotizacionesproductos.idcliente=clientes.idcliente
					WHERE 1
					GROUP BY $cotizacionesproductos.folio,  $detallecotizacionesproductos.subfolio
					";
		
					//echo $consulta; //REVISAR CONSULTA
		/*if($this->con->conectar()==true){
			return $resultado=mysqli_query($this->con->conect,$consulta);
		}*/
		
		if($this->con->conectar()==true){
			$resultado1 = mysqli_query($this->con->conect,$consulta);
			$resultado2 =  mysqli_query($this->con->conect,"SELECT FOUND_ROWS() AS contador");
			$extractor = mysqli_fetch_assoc($resultado2);
			//echo $extractor["contador"];
			return array ($resultado1,$extractor["contador"]);
		}
	}
	
	function guardarTemporalSimple($idcotizacionproducto,$subfolio){
		$validar = "exito";
		if($this->con->conectar()==true){
				$this->con->conect->autocommit(false); //INICO DE TRANSACCION
				$idfacturaciontemporal=$this->con->generarClave(2);
				if(!mysqli_query($this->con->conect,"INSERT INTO facturaciontemporal (clave, idcotizacion, subfolio) VALUES ('$idfacturaciontemporal','$idcotizacionproducto','$subfolio')")){
					$this->con->conect->rollback();
					$validar="fracaso";
				}else{
					$this->con->conect->commit();
					return $idfacturaciontemporal;
				}
		}else{
			$validar="fracaso";
		}
		return $validar;
	}
	
	function mostrarPendientes($campoOrden, $orden, $inicial, $cantidadamostrar, $busqueda, $papelera, $idcliente,$iddomicilio,$idzona,$tipo,$excel=""){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cotizacionesproductos']['consultar'])){
			return "denegado";
			exit;
		}
		$condicion= trim($busqueda);
		//$where=$this->armarConsulta($condicion,$papelera);
		
		$cotizacionesproductos = "cotizacionesproductos" . $_SESSION["idsucursal"];
		
		$consultaCliente = "";
		$consultaDomicilio = "";
		$consultaZona = "";
		$consultaSucursal = "";
		$consultaEstado = "";
		$consultaFecha = "";
		$consultaEstatus = "";
		$limites = "";
		
		if ($idcliente!=""){
			$consultaCliente=" AND $cotizacionesproductos.idcliente='$idcliente'";
		}
		if ($tipo!=""){
			$consultaEstado=" AND $cotizacionesproductos.tipo='$tipo'";
		}
		
		if($papelera){
				$consultaEstatus="AND $cotizacionesproductos.estatus ='eliminado'";
		}else{
				$consultaEstatus="AND $cotizacionesproductos.estatus <>'eliminado'";
		}
		
		//$SoloAceptados = "AND cotizaciones.estado ='ACEPTADA' ";
		
		if($excel!="SI"){
			$limites="LIMIT $inicial, $cantidadamostrar";
		}
		
		$where="";
		$where="WHERE $cotizacionesproductos.idcotizacionproducto<>0 
		$consultaCliente
		$consultaDomicilio
		$consultaZona
		$consultaSucursal
		$consultaEstado
		$consultaFecha
		$consultaEstatus";
		
		$consulta = "SELECT 
					SQL_CALC_FOUND_ROWS
					$cotizacionesproductos.idcotizacionproducto,
					$cotizacionesproductos.serie,
					$cotizacionesproductos.folio,
					$cotizacionesproductos.fecha,
					$cotizacionesproductos.hora,
					$cotizacionesproductos.estadopago,
					$cotizacionesproductos.estadofacturacion,
					$cotizacionesproductos.tipo,
					$cotizacionesproductos.subtotal,
					$cotizacionesproductos.impuestos,
					$cotizacionesproductos.total,
					$cotizacionesproductos.costodeventa,
					$cotizacionesproductos.utilidad,
					$cotizacionesproductos.idcliente,
					$cotizacionesproductos.idusuario,
					$cotizacionesproductos.idempleado,
					$cotizacionesproductos.enviaradomicilio,
					$cotizacionesproductos.fechaentrega,
					$cotizacionesproductos.horaentregainicio,
					$cotizacionesproductos.horaentregafin,
					$cotizacionesproductos.prioridad,
					$cotizacionesproductos.iddomicilio,
					$cotizacionesproductos.observaciones,
					$cotizacionesproductos.estadoentrega,
					$cotizacionesproductos.estadoentrega,
					$cotizacionesproductos.observacionesentrega,
					$cotizacionesproductos.estadocredito,
					$cotizacionesproductos.descripcioncredito,
					$cotizacionesproductos.estadoliquidacion,
					$cotizacionesproductos.estatus,
					domicilios.tipovialidad AS tipovialidad,
					domicilios.calle AS calle,
					domicilios.noexterior AS noexterior,
					domicilios.nointerior AS nointerior,
					domicilios.colonia AS colonia,
					domicilios.ciudad AS ciudad,
					domicilios.estado AS estado,
					domicilios.cp AS cp,
					usuarios.nombre AS usuario,
					empleados.nombre AS vendedor,
					clientes.nombre AS cliente
					FROM $cotizacionesproductos 
					INNER JOIN usuarios ON $cotizacionesproductos.idusuario=usuarios.idusuario
					INNER JOIN empleados ON $cotizacionesproductos.idempleado=empleados.idempleado
					INNER JOIN clientes ON $cotizacionesproductos.idcliente=clientes.idcliente
					INNER JOIN domicilios ON $cotizacionesproductos.iddomicilio=domicilios.iddomicilio
					$where
					GROUP BY $cotizacionesproductos.idcotizacionproducto 
					ORDER BY $campoOrden $orden
					$limites
					";
		
					//echo $consulta; //REVISAR CONSULTA
		/*if($this->con->conectar()==true){
			return $resultado=mysqli_query($this->con->conect,$consulta);
		}*/
		
		if($this->con->conectar()==true){
			$resultado1 = mysqli_query($this->con->conect,$consulta);
			$resultado2 =  mysqli_query($this->con->conect,"SELECT FOUND_ROWS() AS contador");
			$extractor = mysqli_fetch_assoc($resultado2);
			//echo $extractor["contador"];
			return array ($resultado1,$extractor["contador"]);
		}
	}
	
	function consultaGeneral($condicion){
		if($this->con->conectar()==true){
			$cotizacionesproductos = "cotizacionesproductos" . $_SESSION["idsucursal"];
			return mysqli_query($this->con->conect,"SELECT * FROM $cotizacionesproductos $condicion");
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
		$modulo="cotizacionesproductos";
		mysqli_query($this->con->conect,"INSERT INTO bitacora (hora,fecha,idusuario,modulo,accion,descripcion,idcontrol,tablacontrol,clasificacion,extra) VALUES ('$hora','$fecha','$idusuario','$modulo','$accion','$descripcion')");
	}
	
	function eliminarauto($dias, $tipoEliminacion){
		if($this->con->conectar()==true){
			//consultar todas las cotizaci??nes con una fecha vieja mayor a los $dias que esten PENDIENTES e ir recorriendo y eliminarlas registros CABEZA solamente ya que los DETALLES nunca se podr??n acceder si no es consultando la venta completa 
			$fecha_actual = date('Y-m-j');
			$fechaMaxima = strtotime ( "-$dias day" , strtotime ( $fecha_actual ) ) ;
			$fechaMaxima = date ( 'Y-m-j' , $fechaMaxima );
			//echo $fecha_actual  . " " .$fechaMaxima . " " . $dias;
			$cotizacionesproductos = "cotizacionesproductos" . $_SESSION["idsucursal"];
			$consulta = "SELECT idcotizacionproducto, fecha FROM $cotizacionesproductos WHERE fecha<'$fechaMaxima' ";
			$resultado=mysqli_query($this->con->conect,$consulta);
			//echo $consulta;
			while ($filas=mysqli_fetch_array($resultado)) {
				$idcotizacionproducto=$filas["idcotizacionproducto"];
				if ($tipoEliminacion=='falsa'){
					//REQUIERE CAMPO 'estatus' EN LA TABLA
					if (mysqli_query($this->con->conect,"UPDATE $cotizacionesproductos SET estatus ='eliminado' WHERE idcotizacionproducto = $idcotizacionproducto AND tipo = 'COTIZACION'")){
						//BITACORA
						if ($_SESSION['bitacora']=="si"){
							$descripcionB="elimin&oacute; falsamente los registros: $ids, de la tabla cotizacionesproductos ";
							$this->registrarBitacora("eliminarFalsa",$descripcionB);
						}
						return "exito";
					}else{
						return "fracaso";
					}
				}
				if ($tipoEliminacion=='real'){
					if(mysqli_query($this->con->conect,"DELETE FROM $cotizacionesproductos WHERE idcotizacionproducto = $idcotizacionproducto AND tipo = 'COTIZACION'")){
						//BITACORA
						if ($_SESSION['bitacora']=="si"){
							$descripcionB="elimin&oacute; los registros: $ids, de la tabla cotizacionesproductos ";
							$this->registrarBitacora("eliminar",$descripcionB);
						}
						return "exito";
					}else{
						return "fracaso";
					}
				}
				
				
			}//FIN CONSULTA COTIZACIONES
		}
	}
	
	
	function eliminar($ids, $tipoEliminacion){
		/////PERMISOS////////////////
		if (!isset($_SESSION['permisos']['cotizacionesproductos']['eliminar'])){
			return "denegado";
			exit;
		}
		/////FIN  DE PERMISOS////////
		$cotizacionesproductos = "cotizacionesproductos" . $_SESSION["idsucursal"];
		if($this->con->conectar()==true){
			if ($tipoEliminacion=='falsa'){
				//REQUIERE CAMPO 'estatus' EN LA TABLA
				if (mysqli_query($this->con->conect,"UPDATE $cotizacionesproductos SET estatus ='eliminado' WHERE idcotizacionproducto IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; falsamente los registros: $ids, de la tabla cotizacionesproductos ";
						$this->registrarBitacora("eliminarFalsa",$descripcionB);
					}
					return "exito";
				}else{
					return "fracaso";
				}
			}
			if ($tipoEliminacion=='real'){
				if(mysqli_query($this->con->conect,"DELETE FROM $cotizacionesproductos WHERE idcotizacionproducto IN ($ids)")){
					//BITACORA
					if ($_SESSION['bitacora']=="si"){
						$descripcionB="elimin&oacute; los registros: $ids, de la tabla cotizacionesproductos ";
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