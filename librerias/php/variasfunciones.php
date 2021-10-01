<?php 
//Funcion que genera una clave aleatoria
	function generarClave($numero,$prefijo="",$sufijo=""){
		if ($sufijo==""){
			$sufijo=date("jwynGis");
		}
		$rand="";
		$caracter= "ABCDEFGHIJKLMNPQRSTUVWXYZ123456789";
		srand((double)microtime()*1000000);
		for($i=0; $i<$numero; $i++) {
			$rand.= $caracter[rand()%strlen($caracter)];
		}
		return $prefijo.$rand.$sufijo;
	}

//Funcion para calcular días trancurridos entre dos fechas
function dias_transcurridos($fechaInicial,$fechaFinal){
	$dias=(strtotime($fechaInicial)-strtotime($fechaFinal))/86400;
	$dias=abs($dias); 
	$dias=floor($dias);
	return $dias;
}
function obtenerMes($mes){
	if ($mes==1){
		$mes="Enero";
	}
	if ($mes==2){
		$mes="Febrero";
	}
	if ($mes==3){
		$mes="Marzo";
	}
	if ($mes==4){
		$mes="Abril";
	}
	if ($mes==5){
		$mes="Mayo";
	}
	if ($mes==6){
		$mes="Junio";
	}
	if ($mes==7){
		$mes="Julio";
	}
	if ($mes==8){
		$mes="Agosto";
	}
	if ($mes==9){
		$mes="Septiembre";
	}
	if ($mes==10){
		$mes="Octubre";
	}
	if ($mes==11){
		$mes="Noviembre";
	}
	if ($mes==12){
		$mes="Diciembre";
	}
	return $mes;
}
//Funcion de paginación
function paginar($pg, $cantidadamostrar, $filasTotales, $campoOrden, $orden, $busqueda, $tipoVista){
	$separaciones = ceil($filasTotales/$cantidadamostrar);
	if ($filasTotales>$cantidadamostrar) { ?>
	<div class="box-footer clearfix">
		<ul class="pagination pagination-sm no-margin pull-right">
			<?php 
					$paginasVisibles=2;
					$paginasTemp=0;
					$paginaInicio=$pg-$paginasVisibles;
					
					if ($paginaInicio<0){
						$paginaInicio=0;
						$paginasTemp=$paginasVisibles - $pg;
						
					}else{
						$paginasTemp=0;
					}
					
					$paginaFin=$pg+$paginasVisibles;
					if(($pg+$paginasTemp)<=$paginasVisibles){
						$paginaFin=$paginaFin+$paginasTemp;
					}
					if($paginaFin>=$separaciones){
						$paginaFin=$separaciones;
					}
					if(($pg)==($separaciones-1)){
						if($pg>$paginasVisibles){
							$paginaInicio=$paginaInicio-$paginasTemp-1;
						}
					}
			
	
			
		   // Página anterior.
			if ($paginaInicio > 0) { ?>
					<li <?php if ($paginaInicio == $pg) { ?> class="lista_numero_marcado" <?php } ?> >
					<a onclick="load_tablas('<?php echo $campoOrden; ?>','<?php echo $orden; ?>',<?php echo $cantidadamostrar; ?>,<?php echo $pg-1; ?>,'<?php echo $busqueda; ?>','<?php echo $tipoVista; ?>')"><</a>
					</li>
			<?php } ?>
					
			<?php while($paginaInicio<$paginaFin) { ?>  
				
					<li <?php if ($paginaInicio == $pg) { ?> class="lista_numero_marcado" <?php } ?> >
					<a onclick="load_tablas('<?php echo $campoOrden; ?>','<?php echo $orden; ?>',<?php echo $cantidadamostrar; ?>,<?php echo $paginaInicio; ?>,'<?php echo $busqueda; ?>','<?php echo $tipoVista; ?>')">
					<?php echo $paginaInicio+1; ?>
					</a></li>
			<?php 
					$paginaInicio++;
				} // cierra el for 
			
			
			// Siguiente página
			if ($paginaInicio < $separaciones) {?>
					<li <?php if ($paginaInicio == $pg) { ?> class="lista_numero_marcado" <?php } ?> >
						<a onclick="load_tablas('<?php echo $campoOrden; ?>','<?php echo $orden; ?>',<?php echo $cantidadamostrar; ?>,<?php echo $pg+1; ?>,'<?php echo $busqueda; ?>','<?php echo $tipoVista; ?>')">></a>
					</li>
			<?php } ?>
			
		</ul>
        
        <div class="row">
        
        	<div style="position: relative; min-height: 1px; padding-right: 15px; padding-left: 15px; float:left;">
            	<span class="h6" style="display:inline-block">&nbsp;&nbsp;P&aacute;gina <?php echo $pg+1; ?> de <?php echo $separaciones; ?></span>
            </div>
            
        	<div style="position: relative; min-height: 1px; padding-right: 15px; padding-left: 15px; float:left;">
            	<div class="input-group input-group-sm" style="width:100px;">
                	<input type="text" class="form-control" id="paginaSelP" value="<?php echo $pg+1; ?>">
                    <span class="input-group-btn">
                    	<button type="button" class="btn btn-primary btn-flat" onclick="load_tablas('<?php echo $campoOrden; ?>','<?php echo $orden; ?>',<?php echo $cantidadamostrar; ?>,document.getElementById('paginaSelP').value-1,'<?php echo $busqueda; ?>','<?php echo $tipoVista; ?>')">ir</button>
                    </span>
              	</div>
            </div>
            
        </div>
       
        
	   </div>
	<?php } // cierra el if inicial 
}// Fin de la funcion paginar
?>


                  
                    