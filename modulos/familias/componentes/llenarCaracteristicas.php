<?php
if (isset($_POST['caracteristica'])){
	$caracteristica=htmlentities(trim($_POST['caracteristica']));
	if(isset($_POST['caracteristicas'])){
		$caracteristicas=htmlentities(trim($_POST['caracteristicas']));
	}else{
		$caracteristicas="";
	}
?>
            <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Datos del registro</a></li>
              <!--li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Otros datos</a></li-->
              <div class="col-sm-3 pull-right">
                <div class="input-group">
                    <input type="text" class="form-control" id="filtrador" placeholder="Filtrar valores">
                    <span class="input-group-addon"><i class="fa fa-search" id="botonFiltro"></i></span>
                </div>
              </div>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                <blockquote style="font-size:14px;">
					<p><b>Caracteristica:</b> <?php echo strtoupper(html_entity_decode($caracteristica))?></p>
                    
                    
                
    			</blockquote>
                
                
                <div class="row">
                	<div class="col-sm-6">
                    	<b>Selecciones las características que contendrá la familia: </b>
                    </div>
                    
                    
                    
                </div>
                </br>
                </br>
                <div class="row">
                	<div id="panelCaracteristicas">
                	<?php llenarCaracteristicas($caracteristica, $caracteristicas);?>
                    </div>
                    </br>
                    </br>
                    <div class="form-group pull-right">
                            <label for="cvalor" class="col-sm-1 control-label">Otro:</label>
                            <div class="col-sm-3">
                                <div class="input-group input-group-sm">
                                	<input value="<?php echo $caracteristica?>" id="ccaracteristica" type="hidden"/>
                                    <input value="" name="valor" type="text" class="form-control" id="cvalor" autocomplete="off"><span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
                                    <span class="input-group-btn">
                                        <button id="botonValor" type="button" class="btn btn-warning btn-flat" onclick="guardarCaracteristica();">Agregar</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                
              </div>
              
            </div>
            <!-- /.tab-content -->
          </div>
<?php
}
function llenarCaracteristicas($caracteristica, $caracteristicas){
	include("../../caracteristicas/Caracteristica.class.php");
	$Ocaracteristica = new Caracteristica;
	$resultado=$Ocaracteristica->consultaGeneral(" WHERE caracteristica = '$caracteristica' ORDER BY valor");
	if (isset($_POST['seleccionado'])) {
		$idselect=$_POST['seleccionado'];
		
	}else{
		$idselect=1;
	}
	$con = 0;
	$caracteristicas=explode(",",$caracteristicas);
	while ($filas=mysqli_fetch_array($resultado)) { 
		$checked="";
		if (in_array($filas['idcaracteristica'], $caracteristicas)) {
			$checked="checked=\"checked\"";
		}
	?>
        
	    <div class="col-sm-12 col-md-4 col-lg-3" id="seccionCaracteristicas">
           <label><input id="caracteristica<?php echo $con?>" type="checkbox" name="caracteristica[]" value="<?php echo $filas['idcaracteristica']?>" <?php echo $checked?>>
               <span><?php 
			   echo $filas['valor'];
			   ?>
               </span>
           </label>
        </div>
	<?php
	 $con++;
    }
}
?>
<script>

		var busqueda = $('#filtrador');
		titulo = $('#seccionCaracteristicas label span');
		$(titulo).each(function(){
			var li = $(this);
			//si presionamos la tecla
			$(busqueda).keyup(function(){
				//cambiamos a minusculas
				this.value = this.value.toLowerCase();
				
				var clase = $('#botonFiltro');
				if($(busqueda).val() != ''){
					$(clase).attr('class', 'fa fa-times');
				}else{
					$(clase).attr('class', 'fa fa-search');
				}
				if($(clase).hasClass('fa fa-times')){
					$(clase).click(function(){
						//borramos el contenido del input
						$(busqueda).val('');
						//mostramos todas las listas
						$(li).parent().parent().show();
						//volvemos a añadir la clase para mostrar la lupa
						$(clase).attr('class', 'fa fa-search');
					});
				}
				
				$(li).parent().parent().hide();
				//valor del h3
				var txt = busqueda.val();
				//si hay coincidencias en la búsqueda cambiando a minusculas
				if($(li).text().toLowerCase().indexOf(txt) > -1){
					//mostramos las listas que coincidan
					$(li).parent().parent().show();
				}
			});
		});

</script>