<?php 
	include("../../proveedores/Proveedor.class.php");
	$Oproveedor = new Proveedor;
	$resultado=$Oproveedor->consultaGeneral(" WHERE estatus <> 'eliminado'");
	if (isset($_POST['seleccionado'])) {
		$idselect=$_POST['seleccionado'];
		
	}else{
		$idselect=1;
	}
	$con = 0;
	?>
    <div class="row" style="padding-left:30px;">
        <div class="form-group ">
            <div class="col-sm-3">
                <div class="input-group">
                    <input type="text" class="form-control" id="filtrador" placeholder="Filtrar proveedor">
                    <span class="input-group-addon"><i class="fa fa-search" id="botonFiltro"></i></span>
                </div>
            </div> 
        </div>
    </div>
    <div id="seccionProveedores">
	<?php
	while ($filas=mysqli_fetch_array($resultado)) {
		$clave=$Oproveedor->comprobarProductoProveedor($idselect,$filas['idproveedor']);
		$checked="";
		$visible="style='display:none' disabled='disabled'";
		if ($clave!="null"){
			$checked="checked=\"checked\"";
			$visible="";
		}else{
			$clave="";
		}
	?>
        
	    <div id="caja<?php echo $con?>" class="col-sm-12 col-md-4 col-lg-3">
           <label>
           	<input id="proveedor<?php echo $con?>" type="checkbox" name="proveedores[]" value="<?php echo $filas['idproveedor']?>" onclick="activarCaja(<?php echo $con?>);" <?php echo $checked?>>
           	<span>
               <?php 
			   echo $filas['nombre'];
			   ?>
           	</span>
           </label>
           <input type="text" class="cajaClave" id="clave<?php echo $con?>" name="claves[]" <?php echo $visible?> placeholder="Clave del producto" value="<?php echo $clave?>"/>
        </div>
	<?php
	 $con++;
    }
?>
	</div>

<script>

		var busqueda = $('#filtrador');
		titulo = $('#seccionProveedores label span');
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