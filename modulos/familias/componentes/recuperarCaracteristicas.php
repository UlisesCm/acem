<?php 
include("../../familias/Familia.class.php");
$idfamilia=htmlentities($_POST['idfamilia']);
$Ofamilia = new Familia;
$lista=$Ofamilia->obtenerCampo("camposrequeridos",$idfamilia);
$camposDisponibles = array("pesoteorico", "espesor", "ancho", "color", "diametro", "lado", "tipo", "marca", "alto", "aplicacion", "modelo", "modelo2", "largo", "clave");
$lista= substr($lista, 0, -3);
$lista=explode(":::",$lista);
$arregloCampo=$Ofamilia->descomponerArreglo(3,0,$lista);
$arregloOrden=$Ofamilia->descomponerArreglo(3,1,$lista);
$arregloDatos=$Ofamilia->descomponerArreglo(3,2,$lista);

$arrayCampos=$arregloCampo;
$con=0;
while ($con < count($camposDisponibles)){
	$campo=$camposDisponibles[$con];
	if (!in_array($campo,$arrayCampos)){
		array_push($arrayCampos, $campo);
	}
	$con++;
}

$con=0;
while ($con < count($arrayCampos)){
	$orden="";
	$datos="";
	$campo="";
	$requerido="";
	$mostrar="";
		
	$campo=$arrayCampos[$con];
	$posicion=array_search($campo, $arregloCampo);
	$camporeq=$arregloCampo[$posicion];
	if ($campo==$camporeq){
		$orden=$arregloOrden[$posicion];
		$datos=$arregloDatos[$posicion];
		
		if ($posicion!==false){
			$requerido="checked=\"checked\"";
		}
		if ($orden!=""){
			$mostrar="checked=\"checked\"";
		}
	}
	
	
?>
							<?php if ($campo=="pesoteorico"){?>
                            <li class="" style="">
                                <span class="handle ui-sortable-handle">
                                    <i class="fa fa-ellipsis-v"></i>
                                    <i class="fa fa-ellipsis-v"></i>
                                </span>
                                
                                <span class="text">
                                	<input <?php echo $requerido?> type="checkbox" value="pesoteorico" id="propiedad0" class="activeCampos prop" onClick="recorrerTablaOrden('tablaOrden','ccamposrequeridos')">
                                    <label for="propiedad0" class="control-label"> Peso teórico</label>
                                </span>
                                
                                  
                                <div class="tools" style="display:inline-block">
                                	<input type="hidden" id="orden0" value="" class="activeCampos orden">
                                	<input <?php echo $mostrar?> type="checkbox" value="tipo" id="mostrar0" class="activeCampos corden" onClick="recorrerTablaOrden('tablaOrden','ccamposrequeridos')">
                                    <label for="mostrar0" class="control-label"> Mostrar</label>
                                    <small class="label" style="background-color:#C00"></small>
                                    <input type="hidden" id="caracteristicaspesoteorico" value="<?php echo $datos?>" class="caracteristicas">
                                </div>
                            </li>
                            <?php }?>
                            <?php if ($campo=="espesor"){?>
                            <li class="" style="">
                                <span class="handle ui-sortable-handle">
                                    <i class="fa fa-ellipsis-v"></i>
                                    <i class="fa fa-ellipsis-v"></i>
                                </span>
                                
                                <span class="text">
                                	<input <?php echo $requerido?> type="checkbox" value="espesor" id="propiedad1" class="activeCampos prop" onClick="recorrerTablaOrden('tablaOrden','ccamposrequeridos')">
                                    <label for="propiedad1" class="control-label"> Calibre / Grosor / Espesor</label>
                                    
                                </span>
                                
                                  
                                <div class="tools" style="display:inline-block">
                                	<input type="hidden" id="orden1" value="" class="activeCampos orden">
                                    
                                	<input <?php echo $mostrar?> type="checkbox" value="tipo" id="mostrar1" class="activeCampos corden" onClick="recorrerTablaOrden('tablaOrden','ccamposrequeridos')">
                                    <label for="mostrar1" class="control-label"> Mostrar</label>
                                    <small class="label" style="background-color:#C00"></small>
                                    <input type="hidden" id="caracteristicasespesor" value="<?php echo $datos?>" class="caracteristicas">
                                    <a style="display:none" class="btn btn-warning btn-xs label2" id="Bespesor" onClick="abrirModal('espesor');"><i class="fa fa-gear"></i> Configurar</a>
                                </div>
                            </li>
                            <?php }?>
                            <?php if ($campo=="ancho"){?>
                            <li class="" style="">
                                <span class="handle ui-sortable-handle">
                                    <i class="fa fa-ellipsis-v"></i>
                                    <i class="fa fa-ellipsis-v"></i>
                                </span>
                                
                                <span class="text">
                                	<input <?php echo $requerido?> type="checkbox" value="ancho" id="propiedad2"  class="activeCampos prop" onClick="recorrerTablaOrden('tablaOrden','ccamposrequeridos')">
                                    <label for="propiedad2" class="control-label"> Ancho</label>
                                    
                                </span>
                                
                                  
                                <div class="tools" style="display:inline-block">
                                	<input type="hidden" id="orden2" value="" class="activeCampos orden">
                                	<input <?php echo $mostrar?> type="checkbox" value="tipo" id="mostrar2" class="activeCampos corden" onClick="recorrerTablaOrden('tablaOrden','ccamposrequeridos')">
                                    <label for="mostrar2" class="control-label"> Mostrar</label>
                                    <small class="label" style="background-color:#C00"></small>
                                    <input type="hidden" id="caracteristicasancho" value="<?php echo $datos?>" class="caracteristicas">
                                    <a style="display:none" class="btn btn-warning btn-xs label2" id="Bancho" onClick="abrirModal('ancho');"><i class="fa fa-gear"></i>Configurar</a>
                                </div>
                            </li>
                            <?php }?>
                            <?php if ($campo=="color"){?>
                            <li class="" style="">
                                <span class="handle ui-sortable-handle">
                                    <i class="fa fa-ellipsis-v"></i>
                                    <i class="fa fa-ellipsis-v"></i>
                                </span>
                                
                                <span class="text">
                                	<input <?php echo $requerido?> type="checkbox" value="color" id="propiedad3" class="activeCampos prop" onClick="recorrerTablaOrden('tablaOrden','ccamposrequeridos')">
                                    <label for="propiedad3" class="control-label"> Color</label>
                                    
                                </span>
                                
                                  
                                <div class="tools" style="display:inline-block">
                                	<input type="hidden" id="orden3" value="" class="activeCampos orden">
                                	<input <?php echo $mostrar?> type="checkbox" value="tipo" id="mostrar3" class="activeCampos corden" onClick="recorrerTablaOrden('tablaOrden','ccamposrequeridos')">
                                    <label for="mostrar3" class="control-label"> Mostrar</label>
                                    <small class="label" style="background-color:#C00"></small>
                                    <input type="hidden" id="caracteristicascolor" value="<?php echo $datos?>" class="caracteristicas">
                                    <a style="display:none" class="btn btn-warning btn-xs label2" id="Bcolor" onClick="abrirModal('color');"><i class="fa fa-gear"></i>Configurar</a>
                                </div>
                            </li>
                            <?php }?>
                            <?php if ($campo=="diametro"){?>
                            <li class="" style="">
                                <span class="handle ui-sortable-handle">
                                    <i class="fa fa-ellipsis-v"></i>
                                    <i class="fa fa-ellipsis-v"></i>
                                </span>
                                
                                <span class="text">
                                	<input <?php echo $requerido?> type="checkbox" value="diametro" id="propiedad4"  class="activeCampos prop" onClick="recorrerTablaOrden('tablaOrden','ccamposrequeridos')">
                                    <label for="propiedad4" class="control-label"> Diámetro</label>
                                    
                                </span>
                                
                                  
                                <div class="tools" style="display:inline-block">
                                	<input type="hidden" id="orden4" value="" class="activeCampos orden">
                                	<input <?php echo $mostrar?> type="checkbox" value="tipo" id="mostrar4" class="activeCampos corden" onClick="recorrerTablaOrden('tablaOrden','ccamposrequeridos')">
                                    <label for="mostrar4" class="control-label"> Mostrar</label>
                                    <small class="label" style="background-color:#C00"></small>
                                    <input type="hidden" id="caracteristicasdiametro" value="<?php echo $datos?>" class="caracteristicas">
                                    <a style="display:none" class="btn btn-warning btn-xs label2" id="Bdiametro" onClick="abrirModal('diametro');"><i class="fa fa-gear"></i>Configurar</a>
                                </div>
                            </li>
                            <?php }?>
                            <?php if ($campo=="lado"){?>
                            <li class="" style="">
                                <span class="handle ui-sortable-handle">
                                    <i class="fa fa-ellipsis-v"></i>
                                    <i class="fa fa-ellipsis-v"></i>
                                </span>
                                
                                <span class="text">
                                	<input <?php echo $requerido?> type="checkbox" value="lado" id="propiedad5" class="activeCampos prop" onClick="recorrerTablaOrden('tablaOrden','ccamposrequeridos')">
                                    <label for="propiedad5" class="control-label"> Lado</label>
                                    
                                </span>
                                
                                  
                                <div class="tools" style="display:inline-block">
                                	<input type="hidden" id="orden5" value="" class="activeCampos orden">
                                	<input <?php echo $mostrar?> type="checkbox" value="tipo" id="mostrar5" class="activeCampos corden" onClick="recorrerTablaOrden('tablaOrden','ccamposrequeridos')">
                                    <label for="mostrar5" class="control-label"> Mostrar</label>
                                    <small class="label" style="background-color:#C00"></small>
                                    <input type="hidden" id="caracteristicaslado" value="<?php echo $datos?>" class="caracteristicas">
                                    <a style="display:none" class="btn btn-warning btn-xs label2" id="Blado" onClick="abrirModal('lado');"><i class="fa fa-gear"></i>Configurar</a>
                                </div>
                            </li>
                            <?php }?>
                            <?php if ($campo=="tipo"){?>
                            <li class="" style="">
                                <span class="handle ui-sortable-handle">
                                    <i class="fa fa-ellipsis-v"></i>
                                    <i class="fa fa-ellipsis-v"></i>
                                </span>
                                
                                <span class="text">
                                	<input <?php echo $requerido?> type="checkbox" value="tipo" id="propiedad6" class="activeCampos prop" onClick="recorrerTablaOrden('tablaOrden','ccamposrequeridos')">
                                    <label for="propiedad6" class="control-label"> Tipo</label>
                                    
                                </span>
                                
                                  
                                <div class="tools" style="display:inline-block">
                                	<input type="hidden" id="orden6" value="" class="activeCampos orden">
                                	<input <?php echo $mostrar?> type="checkbox" value="tipo" id="mostrar6" class="activeCampos corden" onClick="recorrerTablaOrden('tablaOrden','ccamposrequeridos')">
                                    <label for="mostrar6" class="control-label"> Mostrar</label>
                                    <small class="label" style="background-color:#C00"></small>
                                    <input type="hidden" id="caracteristicastipo" value="<?php echo $datos?>" class="caracteristicas">
                                    <a style="display:none" class="btn btn-warning btn-xs label2" id="Btipo" onClick="abrirModal('tipo');"><i class="fa fa-gear"></i>Configurar</a>
                                </div>
                            </li>
                            <?php }?>
                            <?php if ($campo=="marca"){?>
                            <li class="" style="">
                                <span class="handle ui-sortable-handle">
                                    <i class="fa fa-ellipsis-v"></i>
                                    <i class="fa fa-ellipsis-v"></i>
                                </span>
                                
                                <span class="text">
                                	<input <?php echo $requerido?> type="checkbox" value="marca" id="propiedad7" class="activeCampos prop" onClick="recorrerTablaOrden('tablaOrden','ccamposrequeridos')">
                                    <label for="propiedad7" class="control-label"> Marca</label>
                                    
                                </span>
                                
                                  
                                <div class="tools" style="display:inline-block">
                                	<input type="hidden" id="orden7" value="" class="activeCampos orden">
                                	<input <?php echo $mostrar?> type="checkbox" value="tipo" id="mostrar7" class="activeCampos corden" onClick="recorrerTablaOrden('tablaOrden','ccamposrequeridos')">
                                    <label for="mostrar7" class="control-label"> Mostrar</label>
                                    <small class="label" style="background-color:#C00"></small>
                                    <input type="hidden" id="caracteristicasmarca" value="<?php echo $datos?>" class="caracteristicas">
                                    <a style="display:none" class="btn btn-warning btn-xs label2" id="Bmarca" onClick="abrirModal('marca');"><i class="fa fa-gear"></i>Configurar</a>
                                </div>
                            </li>
                            <?php }?>
                            <?php if ($campo=="alto"){?>
                            <li class="" style="">
                                <span class="handle ui-sortable-handle">
                                    <i class="fa fa-ellipsis-v"></i>
                                    <i class="fa fa-ellipsis-v"></i>
                                </span>
                                
                                <span class="text">
                                	<input <?php echo $requerido?> type="checkbox" value="alto" id="propiedad8" class="activeCampos prop" onClick="recorrerTablaOrden('tablaOrden','ccamposrequeridos')">
                                    <label for="propiedad8" class="control-label"> Alto</label>
                                </span>
                                
                                  
                                <div class="tools" style="display:inline-block">
                                	<input type="hidden" id="orden8" value="" class="activeCampos orden">
                                	<input <?php echo $mostrar?> type="checkbox" value="alto" id="mostrar8" class="activeCampos corden" onClick="recorrerTablaOrden('tablaOrden','ccamposrequeridos')">
                                    <label for="mostrar8" class="control-label"> Mostrar</label>
                                    <small class="label" style="background-color:#C00"></small>
                                    <input type="hidden" id="caracteristicasalto" value="<?php echo $datos?>" class="caracteristicas">
                                    <a style="display:none" class="btn btn-warning btn-xs label2" id="Balto" onClick="abrirModal('alto');"><i class="fa fa-gear"></i>Configurar</a>
                                </div>
                            </li>
                            <?php }?>
                            <?php if ($campo=="aplicacion"){?>
                            <li class="" style="">
                                <span class="handle ui-sortable-handle">
                                    <i class="fa fa-ellipsis-v"></i>
                                    <i class="fa fa-ellipsis-v"></i>
                                </span>
                                
                                <span class="text">
                                	<input <?php echo $requerido?> type="checkbox" value="aplicacion" id="propiedad9" class="activeCampos prop" onClick="recorrerTablaOrden('tablaOrden','ccamposrequeridos')">
                                    <label for="propiedad9" class="control-label"> Aplicación</label>
                                    
                                </span>
                                
                                  
                                <div class="tools" style="display:inline-block">
                                	<input type="hidden" id="orden9" value="" class="activeCampos orden">
                                	<input <?php echo $mostrar?> type="checkbox" value="aplicacion" id="mostrar9" class="activeCampos corden" onClick="recorrerTablaOrden('tablaOrden','ccamposrequeridos')">
                                    <label for="mostrar9" class="control-label"> Mostrar</label>
                                    <small class="label" style="background-color:#C00"></small>
                                    <input type="hidden" id="caracteristicasaplicacion" value="<?php echo $datos?>" class="caracteristicas">
                                    <a style="display:none" class="btn btn-warning btn-xs label2" id="Baplicacion" onClick="abrirModal('aplicacion');"><i class="fa fa-gear"></i>Configurar</a>
                                </div>
                            </li>
                            <?php }?>
                            <?php if ($campo=="modelo"){?>
                            <li class="" style="">
                                <span class="handle ui-sortable-handle">
                                    <i class="fa fa-ellipsis-v"></i>
                                    <i class="fa fa-ellipsis-v"></i>
                                </span>
                                
                                <span class="text">
                                	<input <?php echo $requerido?> type="checkbox" value="modelo" id="propiedad10" class="activeCampos prop" onClick="recorrerTablaOrden('tablaOrden','ccamposrequeridos')">
                                    <label for="propiedad10" class="control-label"> Modelo A</label>
                                    
                                </span>
                                
                                  
                                <div class="tools" style="display:inline-block">
                                	<input type="hidden" id="orden10" value="" class="activeCampos orden">
                                	<input <?php echo $mostrar?> type="checkbox" value="modelo2" id="mostrar10" class="activeCampos corden" onClick="recorrerTablaOrden('tablaOrden','ccamposrequeridos')">
                                    <label for="mostrar10" class="control-label"> Mostrar</label>
                                    <small class="label" style="background-color:#C00"></small>
                                    <input type="hidden" id="caracteristicasmodelo2" value="<?php echo $datos?>" class="caracteristicas">
                                </div>
                            </li>
                            <?php }?>
                            <?php if ($campo=="modelo2"){?>
                            <li class="" style="">
                                <span class="handle ui-sortable-handle">
                                    <i class="fa fa-ellipsis-v"></i>
                                    <i class="fa fa-ellipsis-v"></i>
                                </span>
                                
                                <span class="text">
                                	<input <?php echo $requerido?> type="checkbox" value="modelo2" id="propiedad13" class="activeCampos prop" onClick="recorrerTablaOrden('tablaOrden','ccamposrequeridos')">
                                    <label for="propiedad13" class="control-label"> Modelo B</label>
                                    
                                </span>
                                
                                  
                                <div class="tools" style="display:inline-block">
                                	<input type="hidden" id="orden13" value="" class="activeCampos orden">
                                	<input <?php echo $mostrar?> type="checkbox" value="modelo" id="mostrar13" class="activeCampos corden" onClick="recorrerTablaOrden('tablaOrden','ccamposrequeridos')">
                                    <label for="mostrar13" class="control-label"> Mostrar</label>
                                    <small class="label" style="background-color:#C00"></small>
                                    <input type="hidden" id="caracteristicasmodelo" value="<?php echo $datos?>" class="caracteristicas">
                                </div>
                            </li>
                            <?php }?>
                            <?php if ($campo=="largo"){?>
                            <li class="" style="">
                                <span class="handle ui-sortable-handle">
                                    <i class="fa fa-ellipsis-v"></i>
                                    <i class="fa fa-ellipsis-v"></i>
                                </span>
                                
                                <span class="text">
                                	<input <?php echo $requerido?> type="checkbox" value="largo" id="propiedad11" class="activeCampos prop" onClick="recorrerTablaOrden('tablaOrden','ccamposrequeridos')">
                                    <label for="propiedad11" class="control-label"> Largo</label>
                                    
                                </span>
                                
                                  
                                <div class="tools" style="display:inline-block">
                                	<input type="hidden" id="orden11" value="" class="activeCampos orden">
                                	<input <?php echo $mostrar?> type="checkbox" value="largo" id="mostrar11" class="activeCampos corden" onClick="recorrerTablaOrden('tablaOrden','ccamposrequeridos')">
                                    <label for="mostrar11" class="control-label"> Mostrar</label>
                                    <small class="label" style="background-color:#C00"></small>
                                    <input type="hidden" id="caracteristicaslargo" value="<?php echo $datos?>" class="caracteristicas">
                                    <a style="display:none" class="btn btn-warning btn-xs label2" id="Blargo" onClick="abrirModal('largo');"><i class="fa fa-gear"></i>Configurar</a>
                                </div>
                            </li>
                            <?php }?>
                            <?php if ($campo=="clave"){?>
                            <li class="" style="">
                                <span class="handle ui-sortable-handle">
                                    <i class="fa fa-ellipsis-v"></i>
                                    <i class="fa fa-ellipsis-v"></i>
                                </span>
                                
                                <span class="text">
                                	<input <?php echo $requerido?> type="checkbox" value="clave" id="propiedad12" class="activeCampos prop" onClick="recorrerTablaOrden('tablaOrden','ccamposrequeridos')">
                                    <label for="propiedad12" class="control-label"> Código</label>
                                    
                                </span>
                                
                                  
                                <div class="tools" style="display:inline-block">
                                	<input type="hidden" id="orden12" value="" class="activeCampos orden">
                                	<input <?php echo $mostrar?> type="checkbox" value="clave" id="mostrar12" class="activeCampos corden" onClick="recorrerTablaOrden('tablaOrden','ccamposrequeridos')">
                                    <label for="mostrar12" class="control-label"> Mostrar</label>
                                    <small class="label" style="background-color:#C00"></small>
                                    <input type="hidden" id="caracteristicasclave" value="<?php echo $datos?>" class="caracteristicas">
                                </div>
                            </li>
                            <?php }?>
<?php 
	$con++;
}
?>