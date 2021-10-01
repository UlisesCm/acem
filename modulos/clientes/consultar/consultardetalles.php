<?php
require("../Cliente.class.php");
$idcliente=1;
if (isset($_POST['id'])){
	$id=htmlentities(trim($_POST['id']));
	$Ocliente= new Cliente;
	$resultado=$Ocliente->mostrarIndividual($id);
	$extractor = mysqli_fetch_array($resultado);
	$rfc=$extractor["rfc"];
	$nombre=html_entity_decode($extractor["nombre"]);
	$nic=$extractor["nic"];
	$limitecredito=$extractor["limitecredito"];
	$diascredito=$extractor["diascredito"];
	$saldo=$extractor["saldo"];
	$nombrecontacto=$extractor["nombrecontacto"];
	$correocontacto=$extractor["correocontacto"];
	$telefonocontacto=$extractor["telefonocontacto"];
	$autorizardosis=strtoupper($extractor["autorizardosis"]);
	$autorizarproductos=strtoupper($extractor["autorizarproductos"]);
	$estatus=$extractor["estatus"];
	$colordosis="#F03";
	$colorproductos="#F03";
	if ($autorizardosis=="SI"){
		$colordosis="#096";
	}
	if ($autorizarproductos=="SI"){
		$colorproductos="#096";
	}
?>
			<blockquote style="font-size:14px;">
            	<p><b>Nombre del cliente:</b> <?php echo strtoupper($nombre)?></p>
                <p><b>Días de crédito:</b> <?php echo $diascredito?> | <b>Monto de crédito:</b> <?php echo "$".number_format($limitecredito,2);?></p>
                <small>Estatus:  <cite title="Source Title"><?php echo $estatus; ?></cite></small>
    		</blockquote>
            
            <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Domicilios de Servicio</a></li>
              <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Domicilios Fiscales</a></li>
              <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false">Contactos</a></li>
              <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                <b>Editar domicilios de servicio</b>
                <?php llenarDomicilios($id,$nombre,$nic);?>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
               	<b>Editar información de facturación</b>
                <?php llenarFacturacion($id,$nombre,$nic);?>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_3">
                <b>Editar contactos</b>
                <?php llenarContactos($id,$nombre,$nic);?>
              </div>
              
              
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
<?php
}

function llenarFacturacion($idcliente,$nombre,$nic){
	$Ocliente=new Cliente;
	$resultado=$Ocliente->consultaLibre(" SELECT
					*
					FROM datosfiscales
					WHERE estatus <> 'eliminado' AND idcliente='$idcliente'");
	
	?>
    	<table class="table table-hover table-bordered">
        	<tr>
                <th class="columnaDecorada" style="background:#2ea737;"></th>
				<th class="Ccodmicilio">Domicilio</th>
				<th class="Cformapago">Forma de pago</th>
				<th class="Cmetodopago">Método de pago</th>
				<th class="Cuso">Uso de CFDI</th>
				
                <th width="40" class="sticky-column"></th>
      		</tr>
    <?php
	while ($filas=mysqli_fetch_array($resultado)) { ?>
      		<tr id="iregistro<?php echo $filas['iddatofiscal'] ?>">
                <td class="columnaDecorada" style="background:#2ea737;"></td>
				<td class="Ctipovialidad"><i><small><?php echo $filas['domiciliocompleto']; ?></small></i></td>
				<td class="Ccalle"><?php echo $filas['formapago']; ?></td>
				<td class="Cnoexterior"><?php echo $filas['metodopago']; ?></td>
				<td class="Cnointerior"><?php echo $filas['usocfdi']; ?></td>
				
                <td class="sticky-column">
                    <form action="../../datosfiscales/modificar/actualizar.php?n1=clientes&n2=datosfiscales&n3=consultardatosfiscales" method="post" target="_blank">
                		<input type="hidden" name="id" value="<?php echo $filas['iddatofiscal'] ?>"/>
                        <input type="hidden" name="nombre" value="<?php echo $nombre ?>"/>
                        <input type="hidden" name="nic" value="<?php echo $nic ?>"/>
                        <button type="submit" class="btn btn-success btn-xs" value="" title="Editar datos fiscales"><li class="fa fa-edit"></li></button>
                	</form>
                </td>
      		</tr>
    <?php
	}//Fin de while si es tabla ?>
		</table>
    <?php   
}




function llenarDomicilios($idcliente,$nombre,$nic){
	$Ocliente=new Cliente;
	$resultado=$Ocliente->consultaLibre(" SELECT
					domicilios.iddomicilio,
					domicilios.idcliente,
					domicilios.tipovialidad,
					domicilios.calle,
					domicilios.noexterior,
					domicilios.nointerior,
					domicilios.nombrecomercial,
					domicilios.colonia,
					domicilios.cp,
					domicilios.ciudad,
					domicilios.estado,
					domicilios.idzona,
					domicilios.coordenadas,
					domicilios.referencia,
					domicilios.observaciones,
					domicilios.idsucursal,
					domicilios.idgirocomercial,
					domicilios.validardosis,
					domicilios.idempleado,
					domicilios.estatus,
					zonas.nombre AS nombrezonas
					FROM domicilios 
					INNER JOIN zonas ON domicilios.idzona=zonas.idzona
					WHERE domicilios.estatus <> 'eliminado' AND domicilios.idcliente='$idcliente'");
	
	?>
    	<table class="table table-hover table-bordered">
        	<tr>
                <th class="columnaDecorada" style="background:#2ea737;"></th>
				<th class="Ctipovialidad">Tipo vialidad</th>
				<th class="Ccalle">Calle</th>
				<th class="Cnoexterior">No. exterior</th>
				<th class="Cnointerior">No. interior</th>
				<th class="Cnombrecomercial">Nombre comercial</th>
				<th class="Ccolonia">Colonia</th>
				<th class="Ccp">CP</th>
				<th class="Cciudad">Ciudad</th>
				<th class="Cestado">Estado</th>
				<th class="Cidzona">Zona</th>
				
                <th width="40" class="sticky-column"></th>
      		</tr>
    <?php
	while ($filas=mysqli_fetch_array($resultado)) { ?>
      		<tr id="iregistro<?php echo $filas['iddomicilio'] ?>">
                <td class="columnaDecorada" style="background:#2ea737;"></td>
				<td class="Ctipovialidad"><?php echo $filas['tipovialidad']; ?></td>
				<td class="Ccalle"><?php echo $filas['calle']; ?></td>
				<td class="Cnoexterior"><?php echo $filas['noexterior']; ?></td>
				<td class="Cnointerior"><?php echo $filas['nointerior']; ?></td>
				<td class="Cnombrecomercial"><?php echo $filas['nombrecomercial']; ?></td>
				<td class="Ccolonia"><?php echo $filas['colonia']; ?></td>
				<td class="Ccp"><?php echo $filas['cp']; ?></td>
				<td class="Cciudad"><?php echo $filas['ciudad']; ?></td>
				<td class="Cestado"><?php echo $filas['estado']; ?></td>
				<td class="Cestado"><?php echo $filas['nombrezonas']; ?></td>
                <td class="sticky-column">
                    <form action="../../domicilios/modificar/actualizar.php?n1=catalogos&n2=clientes&n3=domicilios&n4=modificardomicilios" method="post" target="_blank">
                		<input type="hidden" name="id" value="<?php echo $filas['iddomicilio'] ?>"/>
                        <input type="hidden" name="nombre" value="<?php echo $nombre ?>"/>
                        <input type="hidden" name="nic" value="<?php echo $nic ?>"/>
                        <button type="submit" class="btn btn-success btn-xs" value="" title="Editar domicilio de servicio"><li class="fa fa-edit"></li></button>
                	</form>
                </td>
      		</tr>
    <?php
	}//Fin de while si es tabla ?>
		</table>
    <?php   
}

function llenarAutorizarProductos($idcliente,$nombre,$nic){
	$Ocliente= new Cliente;
	$resultado=$Ocliente->consultaLibre("SELECT * FROM productos WHERE estatus <> 'eliminado' ORDER BY cuadrobasico DESC, nombre ASC");
	
	$con = 0;
	?>
    <input name="idcliente" value="<?php echo $idcliente?>" type="hidden"/>
    <table class="table table-hover table-bordered">
        	<tr>
                <th class="columnaDecorada" style="background:#2ea737;"></th>
				<th class="Cproducto">Producto</th>
                <th class="Cautorizar" width="70">Autorizar</th>
				<th class="Crotacionminima">Rotación Mínima</th>
				<th class="Crotacionmaxima">Rotación Máxima</th>
      		</tr>
    <?php
	while ($filas=mysqli_fetch_array($resultado)) {
		if($filas['cuadrobasico']=="si" or $filas['cuadrobasico']=="SI"){
			$cuadrobasico=" (Cuadro básico)";
		}else{
			$cuadrobasico="";
		}
		?>
        	
        	<tr id="iregistro<?php echo $filas['idproducto'] ?>">
                <td class="columnaDecorada" style="background:#2ea737;"></td>
                <td>
               	<?php 
			   	echo $filas['nombre'].$cuadrobasico;
			   	?>
           		</td>
                <td>
                <input name="productos[]" type="hidden" value="<?php echo $filas['idproducto']?>"/>
           		<select style="width:100%;" id="estado<?php echo $con?>" name="estados[]">
                	<?php echo $Ocliente->comprobarAutorizarProductos($idcliente,$filas['idproducto'])?>
                </select>
           		</td>
                <td>
           		<select style="width:100%;" id="rotacionminima<?php echo $con?>" name="rotacionminima[]">
                	<?php echo $Ocliente->comprobarRotacion($idcliente,$filas['idproducto'],"rotacionminima")?>
                </select>
           		</td>
                 <td>
           		<select style="width:100%;" id="rotacionmaxima<?php echo $con?>" name="rotacionmaxima[]">
                	<?php echo $Ocliente->comprobarRotacion($idcliente,$filas['idproducto'],"rotacionmaxima")?>
                </select>
           		</td>
            </tr>
	<?php
	 $con++;
    }
}

function llenarContactos($idcliente,$nombre,$nic){
	$Ocliente=new Cliente;
	$resultado=$Ocliente->consultaLibre(" SELECT
					*
					FROM contactos
					WHERE idcliente='$idcliente'");
	
	?>
    	<table class="table table-hover table-bordered">
        	<tr>
                <th class="columnaDecorada" style="background:#2ea737;"></th>
				<th class="Cnombrecontacto">Nombre del contacto</th>
				<th class="Ctelefono">Teléfono</th>
				<th class="Cemail">Email</th>
				<th class="Cdepartamento">Departamento</th>
				<th class="Ccomentarios">Comentarios</th>
                <th width="40" class="sticky-column"></th>
      		</tr>
    <?php
	while ($filas=mysqli_fetch_array($resultado)) { ?>
      		<tr id="iregistro<?php echo $filas['idcontacto'] ?>">
                <td class="columnaDecorada" style="background:#2ea737;"></td>
				<td class="Cnombrecontacto"><?php echo $filas['nombrecontacto']; ?></td>
				<td class="Ctelefono"><?php echo $filas['telefono']; ?></td>
				<td class="Cemail"><?php echo $filas['email']; ?></td>
				<td class="Cdepartamento"><?php echo $filas['departamento']; ?></td>
				<td class="Ccomentarios"><i><small><?php echo $filas['comentarios']; ?></small></i></td>
                <td class="sticky-column">
                    <form action="../../contactos/modificar/actualizar.php?n1=contactos&n2=contactos&n3=consultarcontactos" method="post" target="_blank">
                		<input type="hidden" name="id" value="<?php echo $filas['idcontacto'] ?>"/>
                        <input type="hidden" name="nombre" value="<?php echo $nombre ?>"/>
                        <input type="hidden" name="nic" value="<?php echo $nic ?>"/>
                        <button type="submit" class="btn btn-success btn-xs" value="" title="Editar datos fiscales"><li class="fa fa-edit"></li></button>
                	</form>
                </td>
      		</tr>
    <?php
	}//Fin de while si es tabla ?>
		</table>
    <?php   
}
?>