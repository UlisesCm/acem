<?php
function checarLink($nivel,$base){
	if (isset($_GET[$nivel])){
		if ($base==$_GET[$nivel]){
			return 'active';
		}
	}else{
		return "";
	}
}
?>	
    <!-- Left side column. contains the sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="../../../empresas/<?php echo $_SESSION["empresa"];?>/archivosSubidos/usuarios/<?php echo $_SESSION["foto"];?>" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info-box-text info">
              <p><?php echo $_SESSION["nombreusuario"];?></p>
              <a href="#"><i class="fa fa-circle text-success"></i> Conectado</a>
            </div>
          </div>
          
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
          
             
            <li class="header">
            	<i class="fa fa-map-marker" style="color:#E80946"></i> &nbsp; <?php echo $_SESSION["nombresucursal"]; ?>
				<?php
                /////PERMISOS////////////////
                    if (isset($_SESSION['permisos']['sucursales']['cambiar'])){
                    ?>
                <small class="label pull-right bg-green">
                <a href="../../sucursales/cambiarsucursal/vista.php" style="color:#FFF"><i class="fa fa-pencil"></i></a>
                </small>
                <?php } ?>
            </li>
          	
          	<li class="header">OPERACIONES</li>
            
            
            
            <!-- Inicio de Bloque Facturacion-->
            <?php 
			/////PERMISOS////////////////
			if (isset($_SESSION['permisos']['facturacion']['acceso'])){
			?>
            <li class="treeview <?php echo checarLink("n1","facturacion"); ?>">
              <a href="#">
                <i class="fa fa-clipboard" style="color:#DC1F40"></i> <span>Facturación</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
              	<?php 
				/////PERMISOS////////////////
				if (isset($_SESSION['permisos']['facturacion']['guardar'])){
				?>
                <li class="<?php echo checarLink("n2","nuevofacturacion"); ?>">
                <a href="../../../modulos/facturacion/nuevo/nuevo.php?n1=facturacion&n2=nuevofacturacion"><i class="fa fa-circle-o text-green"></i> Nueva factura</a></li>
                <?php }?>
                
                
                <?php 
				/////PERMISOS////////////////
				if (isset($_SESSION['permisos']['notario']['acceso'])){
				?>
                <li class="<?php echo checarLink("n2","nuevofacturacion"); ?>">
                <a href="../../../modulos/facturacion/nuevoNotarios/nuevo.php?n1=facturacion&n2=nuevofacturacion"><i class="fa fa-puzzle-piece  text-green"></i> Nuevo complemento</a></li>
                <?php }?>
                
                
                <?php 
			  	/////PERMISOS////////////////
			  	if (isset($_SESSION['permisos']['facturacion']['consultar'])){
			  	?>
                <li class="<?php echo checarLink("n2","consultarfacturacion"); ?>">
                  <a href="../../../modulos/facturacion/consultar/vista.php?n1=facturacion&n2=consultarfacturacion"><i class="fa fa-circle-o text-red"></i> Consultar facturas</i></a>
                </li>
                 <?php }?>
                 
                 <?php 
			  	/////PERMISOS////////////////
			  	if (isset($_SESSION['permisos']['facturacion']['consultar'])){
			  	?>
                <li class="<?php echo checarLink("n2","consultargraficas"); ?>">
                  <a href="../../../modulos/facturacion/reportes/vista.php?n1=facturacion&n2=consultargraficas"><i class="fa fa-line-chart text-blue"></i> Consulta gráfica</i></a>
                </li>
                 <?php }?>
                 
                 
                  <?php 
			  	/////PERMISOS////////////////
			  	if (isset($_SESSION['permisos']['facturacion']['papelera'])){
			  	?>
                <li class="<?php echo checarLink("n2","papelerafacturacion"); ?>">
                  <a href="../../../modulos/facturacion/consultar/vista.php?n1=facturacion&n2=papelerafacturacion&papelera"><i class="fa fa-circle-o text-yellow"></i> Papelera de facturas</i></a>
                </li>
                 <?php }?>
                 
                 <?php 
			  	/////PERMISOS////////////////
			  	if (isset($_SESSION['permisos']['facturacion']['consultar'])){
			  	?>
                <li class="<?php echo checarLink("n2","consultarfacturacion32"); ?>">
                  <a href="../../../modulos/facturas/consultar/vista.php?n1=facturacion&n2=consultarfacturacion32"><i class="fa fa-circle-o text-yellow"></i> Ver facturas 3.2</i></a>
                </li>
                 <?php }?>
              </ul>
            </li>
            <?php }?>
            
            
             <!-- Inicio de Bloque Facturacion Pagos -->
            <?php 
			/////PERMISOS////////////////
			if (isset($_SESSION['permisos']['facturacion']['acceso'])){
			?>
            <li class="treeview <?php echo checarLink("n1","pagos"); ?>">
              <a href="#">
                <i class="fa fa-credit-card" style="color:#F90"></i> <span>Pagos</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
              	<?php 
				/////PERMISOS////////////////
				if (isset($_SESSION['permisos']['facturacion']['guardar'])){
				?>
                <li class="<?php echo checarLink("n2","nuevopago"); ?>">

                <a href="../../../modulos/facturacion/nuevo/nuevoPago.php?n1=pagos&n2=nuevopago"><i class="fa fa-circle-o text-green"></i> Nuevo pago</a></li>
                <?php }?>
                
                
               
                
                <?php 
			  	/////PERMISOS////////////////
			  	if (isset($_SESSION['permisos']['facturacion']['consultar'])){
			  	?>
                <li class="<?php echo checarLink("n2","consultarpagos"); ?>">
                  <a href="../../../modulos/facturacion/consultarpagos/vista.php?n1=pagos&n2=consultarpagos"><i class="fa fa-circle-o text-red"></i> Consultar pagos</i></a>
                </li>
                 <?php }?>
                 
                 
                  <?php 
			  	/////PERMISOS////////////////
			  	if (isset($_SESSION['permisos']['facturacion']['papelera'])){
			  	?>
                <li class="<?php echo checarLink("n2","papelerapagos"); ?>">
                  <a href="../../../modulos/facturacion/consultarpagos/vista.php?n1=pagos&n2=papelerapagos&papelera"><i class="fa fa-circle-o text-yellow"></i> Papelera de pagos</i></a>
                </li>
                 <?php }?>
                
              </ul>
            </li>
            <?php }?>
            
             <li class="header">MENU PRINCIPAL</li>
             
        <!-- Inicio de Bloque de Auditorias -->
		<?php 
        /////PERMISOS////////////////
        if (isset($_SESSION['permisos']['auditorias']['acceso'])){
        ?>
            <li class="treeview <?php echo checarLink("n1","auditorias"); ?>">
                <a href="#">
                    <i class="fa fa-sliders" style="color:#8bb189"></i> <span>Auditorias</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                <?php 
                /////PERMISOS////////////////
                if (isset($_SESSION['permisos']['auditorias']['guardar'])){
                ?>
                    <li class="<?php echo checarLink("n2","nuevoauditorias"); ?>">
                        <a href="../../../modulos/auditorias/nuevo/nuevo.php?n1=auditorias&n2=nuevoauditorias"><i class="fa fa-circle-o text-green"></i> Nueva Nueva auditoria</a>
                    </li>
                <?php }?>
                <?php 
                /////PERMISOS////////////////
                if (isset($_SESSION['permisos']['auditorias']['consultar'])){
                ?>
                    <li class="<?php echo checarLink("n2","consultarauditorias"); ?>">
                        <a href="../../../modulos/auditorias/consultar/vista.php?n1=auditorias&n2=consultarauditorias"><i class="fa fa-circle-o text-red"></i> Consultar auditorias</i></a>
                    </li>
                <?php }?>
                </ul>
            </li>
            <?php }?>
            <!-- Fin de Bloque de Auditorias -->


             
             <!-- Inicio de Bloque de Traspasos -->
			<?php 
            /////PERMISOS////////////////
            if (isset($_SESSION['permisos']['traspasos']['acceso'])){
            ?>
            <li class="treeview <?php echo checarLink("n1","traspasos"); ?>">
                <a href="#">
                    <i class="fa fa-exchange" style="color:#d70207"></i> <span>Traspasos</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                <?php 
                /////PERMISOS////////////////
                if (isset($_SESSION['permisos']['traspasos']['guardar'])){
                ?>
                    <li class="<?php echo checarLink("n2","nuevotraspasos"); ?>">
                        <a href="../../../modulos/traspasos/nuevo/nuevo.php?n1=traspasos&n2=nuevotraspasos"><i class="fa fa-circle-o text-green"></i> Nueva Nueva traspaso</a>
                    </li>
                <?php }?>
                <?php 
                /////PERMISOS////////////////
                if (isset($_SESSION['permisos']['traspasos']['consultar'])){
                ?>
                    <li class="<?php echo checarLink("n2","consultartraspasos"); ?>">
                        <a href="../../../modulos/traspasos/consultar/vista.php?n1=traspasos&n2=consultartraspasos"><i class="fa fa-circle-o text-red"></i> Consultar traspasos</i></a>
                    </li>
                <?php }?>
                </ul>
            </li>
            <?php }?>
            <!-- Fin de Bloque de Traspasos -->

             
             
             <!-- Inicio de Bloque de Caracteristicas -->
			<?php 
            /////PERMISOS////////////////
            if (isset($_SESSION['permisos']['caracteristicas']['acceso'])){
            ?>
                <li class="treeview <?php echo checarLink("n1","caracteristicas"); ?>">
                    <a href="#">
                        <i class="fa fa-code-fork" style="color:#e41d36"></i> <span>Caracteristicas</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                    <?php 
                    /////PERMISOS////////////////
                    if (isset($_SESSION['permisos']['caracteristicas']['guardar'])){
                    ?>
                        <li class="<?php echo checarLink("n2","nuevocaracteristicas"); ?>">
                            <a href="../../../modulos/caracteristicas/nuevo/nuevo.php?n1=caracteristicas&n2=nuevocaracteristicas"><i class="fa fa-circle-o text-green"></i> Nueva caracteristica</a>
                        </li>
                    <?php }?>
                    <?php 
                    /////PERMISOS////////////////
                    if (isset($_SESSION['permisos']['caracteristicas']['consultar'])){
                    ?>
                        <li class="<?php echo checarLink("n2","consultarcaracteristicas"); ?>">
                            <a href="../../../modulos/caracteristicas/consultar/vista.php?n1=caracteristicas&n2=consultarcaracteristicas"><i class="fa fa-circle-o text-red"></i> Consultar caracteristicas</i></a>
                        </li>
                    <?php }?>
                    </ul>
                </li>
            <?php }?>
            <!-- Fin de Bloque de Caracteristicas -->


             
            <?php 
			/////PERMISOS////////////////
			if (isset($_SESSION['permisos']['movimientos']['acceso']) or isset($_SESSION['permisos']['inventario']['acceso'])){
			?>
            <li class="treeview <?php echo checarLink("n1","movimientos"); ?>">
              <a href="#">
                <i class="fa fa-server"></i> <span>Inventario</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              
              <ul class="treeview-menu">
              	<?php 
				/////PERMISOS////////////////
				if (isset($_SESSION['permisos']['movimientos']['acceso'])){
				?>
                <li class="<?php echo checarLink("n2","movimientos"); ?>">
                  <a href="#"><i class="fa fa-exchange"></i> Movimientos <i class="fa fa-angle-left pull-right"></i></a>
                  <ul class="treeview-menu">
                  	<?php 
					/////PERMISOS////////////////
					if (isset($_SESSION['permisos']['movimientos']['nuevaentrada'])){
					?>
                    <li class="<?php echo checarLink("n3","nuevaentrada"); ?>"><a href="../../../modulos/movimientos/nuevo/nuevo.php?n1=movimientos&n2=movimientos&n3=nuevaentrada"><i class="fa fa-circle-o text-green"></i> Nueva entrada</a></li>
                    <?php }?>
                    <?php 
					/////PERMISOS////////////////
					if (isset($_SESSION['permisos']['movimientos']['nuevoinventario'])){
					?>
                    <li class="<?php echo checarLink("n3","nuevoinventario"); ?>"><a href="../../../modulos/movimientos/nuevoinventario/nuevo.php?n1=movimientos&n2=movimientos&n3=nuevoinventario"><i class="fa fa-circle-o text-green"></i> Nuevo inventario</a></li>
                    <?php }?>
                    <?php 
					/////PERMISOS////////////////
					if (isset($_SESSION['permisos']['movimientos']['nuevasalida'])){
					?>
                    <li class="<?php echo checarLink("n3","nuevasalida"); ?>"><a href="../../../modulos/movimientos/nuevosalida/nuevo.php?n1=movimientos&n2=movimientos&n3=nuevasalida"><i class="fa fa-circle-o text-red"></i> Nueva salida</a></li>
                  	<?php }?>
					<?php 
					/////PERMISOS////////////////
					if (isset($_SESSION['permisos']['movimientos']['consultar'])){
					?>
                    <li class="<?php echo checarLink("n3","consultarmovimientos"); ?>"><a href="../../../modulos/movimientos/consultar/vista.php?n1=movimientos&n2=movimientos&n3=consultarmovimientos"><i class="fa fa-circle-o text-red"></i> Consultar movimientos</a></li>
                  	<?php }?>
                    
                   
                    
                  </ul>
                </li>
                <?php }?>
                <?php 
				/////PERMISOS////////////////
				if (isset($_SESSION['permisos']['inventario']['acceso'])){
				?>
                <li class="<?php echo checarLink("n2","inventario"); ?>">
                  <a href="#"><i class="fa fa-list"></i> Inventario <i class="fa fa-angle-left pull-right"></i></a>
                  <ul class="treeview-menu">
                    <?php 
					/////PERMISOS////////////////
					if (isset($_SESSION['permisos']['inventario']['consultar'])){
					?>
                    <li class="<?php echo checarLink("n3","consultarinventario"); ?>"><a href="../../../modulos/inventario/consultar/vista.php?n1=movimientos&n2=inventario&n3=consultarinventario"><i class="fa fa-file-text-o text-red"></i> Consultar inventario</a></li>
                    <?php }?>
                    <?php 
					/////PERMISOS////////////////
					if (isset($_SESSION['permisos']['inventario']['consultarkardex'])){
					?>
                    <li class="<?php echo checarLink("n3","consultarkardex"); ?>" style="display:none"><a href="../../../modulos/kardex/consultardetalles/vista.php?n1=movimientos&n2=inventario&n3=consultarkardex&idproducto=0&idalmacen=<?php echo $_SESSION["idsucursal"]?>"><i class="fa fa-file-text-o text-green"></i> Consultar Kárdex</a></li>
                    <?php }?>
                    <?php 
					/////PERMISOS////////////////
					if (isset($_SESSION['permisos']['inventario']['consultarrastreador'])){
					?>
                    <li class="<?php echo checarLink("n3","consultarrastreo"); ?>" style="display:none"><a href="../../../modulos/kardex/consultarrastreo/vista.php?n1=movimientos&n2=inventario&n3=consultarrastreo&idproducto=0&idalmacen=<?php echo $_SESSION["idsucursal"]?>"><i class="fa fa-crosshairs text-green"></i> Rastreador</a></li>
                    <?php }?>
                    
                     <?php 
					/////PERMISOS////////////////
					if (isset($_SESSION['permisos']['inventario']['resetear'])){
					?>
                    <li class="<?php echo checarLink("n3","resetear"); ?>" style="display:none"><a href="../../../modulos/inventario/resetear/actualizar.php?n1=movimientos&n2=inventario&n3=resetear"><i class="fa fa-circle-o text-red"></i> Resetear Inventarios</a></li>
                  	<?php }?>
                    
                    <?php 
					/////PERMISOS////////////////
					if (isset($_SESSION['permisos']['inventario']['reparar'])){
					?>
                    <li class="<?php echo checarLink("n3","reparar"); ?>" style="display:none"><a href="../../../modulos/inventario/reparar/actualizar.php?n1=movimientos&n2=inventario&n3=reparar"><i class="fa fa-circle-o text-red"></i> Reparar Inventarios</a></li>
                  	<?php }?>
                  </ul>
                </li>
                <?php }?>
                
                <?php 
				/////PERMISOS////////////////
				if (isset($_SESSION['permisos']['requisiciones']['acceso'])){
				?>
                <li class="<?php echo checarLink("n2","requisiciones"); ?>">
                  <a href="#"><i class="fa fa-list"></i> Requisiones <i class="fa fa-angle-left pull-right"></i></a>
                  <ul class="treeview-menu">
                    <?php 
					/////PERMISOS////////////////
					if (isset($_SESSION['permisos']['requisiciones']['consultar'])){
					?>
                    <li class="<?php echo checarLink("n3","nuevarequisicion"); ?>"><a href="../../../modulos/requisiciones/nuevo/nuevo.php?n1=movimientos&n2=requisiciones&n3=nuevarequisicion"><i class="fa fa-file-text-o text-red"></i> Nueva requisición</a></li>
                    <?php }?>
                    <?php 
					/////PERMISOS////////////////
					if (isset($_SESSION['permisos']['requisiciones']['consultar'])){
					?>
                    <li class="<?php echo checarLink("n3","consultarrequisiciones"); ?>"><a href="../../../modulos/requisiciones/consultar/vista.php?n1=movimientos&n2=requisiciones&n3=consultarrequisiciones"><i class="fa fa-file-text-o text-green"></i> Consultar requisiciones</a></li>
                    <?php }?>
                    
                  </ul>
                </li>
                <?php }?>
                
                 <?php 
				/////PERMISOS////////////////
				if (isset($_SESSION['permisos']['ordenescompras']['acceso'])){
				?>
                <li class="<?php echo checarLink("n2","ordenescompras"); ?>">
                  <a href="#"><i class="fa fa-list"></i> Ordenes de compra <i class="fa fa-angle-left pull-right"></i></a>
                  <ul class="treeview-menu">
                    <?php 
					/////PERMISOS////////////////
					if (isset($_SESSION['permisos']['ordenescompras']['consultar'])){
					?>
                    <li class="<?php echo checarLink("n3","nuevaordencompra"); ?>"><a href="../../../modulos/ordenescompras/nuevo/nuevo.php?n1=movimientos&n2=ordenescompras&n3=nuevaordencompra"><i class="fa fa-file-text-o text-red"></i> Nueva orden de compra</a></li>
                    <?php }?>
                    <?php 
					/////PERMISOS////////////////
					if (isset($_SESSION['permisos']['requisiciones']['consultar'])){
					?>
                    <li class="<?php echo checarLink("n3","consultarordencompra"); ?>"><a href="../../../modulos/ordenescompras/consultar/vista.php?n1=movimientos&n2=ordenescompras&n3=consultarordencompra"><i class="fa fa-file-text-o text-green"></i> Consultar ordenes</a></li>
                    <?php }?>
                    
                  </ul>
                </li>
                <?php }?>
                
                
              </ul>
            </li>
            <?php }?>
             
              <!-- Inicio de Bloque Preventa -->
					<?php 
                    /////PERMISOS////////////////
                    if (isset($_SESSION['permisos']['prospectos']['acceso']) or isset($_SESSION['permisos']['cotizador']['acceso'])){
                    ?>
                     <li class="treeview <?php echo checarLink("n1","preventa"); ?>">
                      <a href="#">
                        <i class="fa fa-phone"></i> <span>Preventa</span>
                        <i class="fa fa-angle-left pull-right"></i>
                      </a>
                      <ul class="treeview-menu">
                      			<!-- Inicio de Bloque de Prospectos -->
								<?php 
                                /////PERMISOS////////////////
                                if (isset($_SESSION['permisos']['prospectos']['acceso'])){
                                ?>
                                <li class="treeview <?php echo checarLink("n2","prospectos"); ?>">
                                  <a href="#">
                                    <i class="fa fa-user" style="color:#e70707"></i> <span>Prospectos</span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                  </a>
                                  <ul class="treeview-menu">
                                    <?php 
                                    /////PERMISOS////////////////
                                    if (isset($_SESSION['permisos']['prospectos']['guardar'])){
                                    ?>
                                    <li class="<?php echo checarLink("n3","nuevoprospectos"); ?>">
                                    <a href="../../../modulos/prospectos/nuevo/nuevo.php?n1=preventa&n2=prospectos&n3=nuevoprospectos"><i class="fa fa-circle-o text-green"></i> Nuevo prospecto</a></li>
                                    <?php }?>
                                    
                                    <?php 
                                    /////PERMISOS////////////////
                                    if (isset($_SESSION['permisos']['prospectos']['consultar'])){
                                    ?>
                                    <li class="<?php echo checarLink("n3","consultarprospectos"); ?>">
                                      <a href="../../../modulos/prospectos/consultar/vista.php?n1=preventa&n2=prospectos&n3=consultarprospectos"><i class="fa fa-circle-o text-red"></i> Consultar prospectos</i></a>
                                    </li>
                                     <?php }?>
                                      <?php 
                                    /////PERMISOS////////////////
                                    if (isset($_SESSION['permisos']['prospectos']['papelera'])){
                                    ?>
                                    <li class="<?php echo checarLink("n3","papeleraprospectos"); ?>">
                                      <a href="../../../modulos/prospectos/consultar/vista.php?n1=preventa&n2=prospectos&n3=papeleraprospectos"><i class="fa fa-circle-o text-yellow"></i> Papelera de prospectos</i></a>
                                    </li>
                                     <?php }?>
                                  </ul>
                                </li>
                                <?php }?>
                                <!-- Fin de Bloque de Prospectos -->
                                
                               
                      
                     </ul><!-- fin de ul Preventa -->
                     
                    </li> <!-- fin de li Preventa -->
                    <?php }?>
                    
                  
                    <!-- Inicio de Bloque Ventas -->
					<?php 
                    /////PERMISOS////////////////
                    if (isset($_SESSION['permisos']['clientes']['acceso']) or isset($_SESSION['permisos']['domicilios']['acceso']) or isset($_SESSION['permisos']['datosfiscales']['acceso'])){
                    ?>
                     <li class="treeview <?php echo checarLink("n1","ventas"); ?>">
                      <a href="#">
                        <i class="fa fa-calculator"></i> <span>Ventas</span>
                        <i class="fa fa-angle-left pull-right"></i>
                      </a>
                      <ul class="treeview-menu">
                      
                           
                           <li class="treeview <?php echo checarLink("n2","cotizacionesproductos"); ?>">
                          <a href="#">
                            <i class="fa fa-calculator"></i> <span>Productos</span>
                            <i class="fa fa-angle-left pull-right"></i>
                          </a>
                          <ul class="treeview-menu">
                          
                          <!-- Inicio de Bloque de Cotizacionesproductos -->
                                <?php 
                                /////PERMISOS////////////////
                                if (isset($_SESSION['permisos']['cotizacionesproductos']['guardar'])){
                                ?>
                                <li class="<?php echo checarLink("n3","nuevocotizacionesproductos"); ?>">
                                <a href="../../../modulos/cotizacionesproductos/nuevo/nuevo.php?n1=ventas&n2=cotizacionesproductos&n3=nuevocotizacionesproductos"><i class="fa fa-circle-o text-green"></i> Nueva venta</a></li>
                                <?php }?>
                                
                                <?php 
                                /////PERMISOS////////////////
                                if (isset($_SESSION['permisos']['cotizacionesproductos']['consultar'])){
                                ?>
                                <li class="<?php echo checarLink("n3","consultarcotizacionesproductos"); ?>">
                                  <a href="../../../modulos/cotizacionesproductos/consultar/vista.php?n1=ventas&n2=cotizacionesproductos&n3=consultarcotizacionesproductos"><i class="fa fa-circle-o text-red"></i> Consultar ventas</i></a>
                                </li>
                                 <?php }?>
                                  <?php 
                                /////PERMISOS////////////////
                                if (isset($_SESSION['permisos']['cotizacionesproductos']['papelera'])){
                                ?>
                                <li class="<?php echo checarLink("n3","papeleracotizacionesproductos"); ?>">
                                  <a href="../../../modulos/cotizacionesproductos/consultar/vista.php?n1=ventas&n2=cotizacionesproductos&n3=papeleracotizacionesproductos&papelera"><i class="fa fa-circle-o text-yellow"></i> Papelera de ventas</i></a>
                                </li>
                                 <?php }?>
                                 
                                 
                                

                            
                            <!-- Fin de Bloque de Cotizacionesproductos -->

                          
                             </ul><!-- fin de ul productos -->
                           </li><!-- fin de li productos -->
                           
                             <!-- Inicio de Bloque de Cotizacionesotros -->
							<?php 
                            /////PERMISOS////////////////
                            if (isset($_SESSION['permisos']['cotizacionesotros']['acceso'])){
                            ?>
                            <li class="treeview <?php echo checarLink("n2","cotizacionesotros"); ?>">
                              <a href="#">
                                <i class="fa fa-calculator"></i> <span>Otros</span>
                                <i class="fa fa-angle-left pull-right"></i>
                              </a>
                              <ul class="treeview-menu">
                                <?php 
                                /////PERMISOS////////////////
                                if (isset($_SESSION['permisos']['cotizacionesotros']['guardar'])){
                                ?>
                                <li class="<?php echo checarLink("n3","nuevocotizacionesotros"); ?>">
                                <a href="../../../modulos/cotizacionesotros/nuevo/nuevo.php?n1=ventas&n2=cotizacionesotros&n3=nuevocotizacionesotros"><i class="fa fa-circle-o text-green"></i> Nueva cotización</a></li>
                                <?php }?>
                                
                                <?php 
                                /////PERMISOS////////////////
                                if (isset($_SESSION['permisos']['cotizacionesotros']['consultar'])){
                                ?>
                                <li class="<?php echo checarLink("n3","consultarcotizacionesotros"); ?>">
                                  <a href="../../../modulos/cotizacionesotros/consultar/vista.php?n1=ventas&n2=cotizacionesotros&n3=consultarcotizacionesotros"><i class="fa fa-circle-o text-red"></i> Consultar cotizaciones</i></a>
                                </li>
                                 <?php }?>
                                  <?php 
                                /////PERMISOS////////////////
                                if (isset($_SESSION['permisos']['cotizacionesotros']['papelera'])){
                                ?>
                                <li class="<?php echo checarLink("n3","papeleracotizacionesotros"); ?>">
                                  <a href="../../../modulos/cotizacionesotros/consultar/vista.php?n1=ventas&n2=cotizacionesotros&n3=papeleracotizacionesotros&papelera"><i class="fa fa-circle-o text-yellow"></i> Papelera de cotizaciones</i></a>
                                </li>
                                 <?php }?>
                                 
                              <!--    <?php 
                                /////PERMISOS////////////////
                                if (isset($_SESSION['permisos']['detallecotizacionesotros']['consultar'])){
                                ?>
                                <li class="<?php echo checarLink("n3","consultardetallecotizacionesotros"); ?>">
                                  <a href="../../../modulos/detallecotizacionesotros/consultar/vista.php?n1=ventas&n2=cotizacionesotros&n3=consultardetallecotizacionesotros"><i class="fa fa-circle-o text-red"></i> Consultar por detalle</i></a>
                                </li>
                                 <?php }?>
                                  <?php 
                                /////PERMISOS////////////////
                                if (isset($_SESSION['permisos']['detallecotizacionesotros']['papelera'])){
                                ?>
                                <li class="<?php echo checarLink("n3","papeleradetallecotizacionesotros"); ?>">
                                  <a href="../../../modulos/detallecotizacionesotros/consultar/vista.php?n1=ventas&n2=cotizacionesotros&n3=papeleradetallecotizacionesotros&papelera"><i class="fa fa-circle-o text-yellow"></i> Papelera por detalle</i></a>
                                </li>
                                 <?php }?>
                                 -->
                              </ul>
                            </li>
                            <?php }?> 
                            <!-- Fin de Bloque de Cotizacionesotros -->
                            
                           
                      
                      
                     </ul><!-- fin de ul ventas -->
                    </li> <!-- fin de li ventas -->
                    <?php }?>
                    
                  
                      
                      <!-- Inicio de Bloque Facturación y cobranza -->
					<?php 
                    /////PERMISOS////////////////
                    if (isset($_SESSION['permisos']['clientes']['acceso']) or isset($_SESSION['permisos']['domicilios']['acceso']) or isset($_SESSION['permisos']['datosfiscales']['acceso'])){
                    ?>
                     <li class="treeview <?php echo checarLink("n1","facturacionycobranza"); ?>">
                      <a href="#">
                        <i class="fa fa-money"></i> <span>Facturación y cobranza</span>
                        <i class="fa fa-angle-left pull-right"></i>
                      </a>
                      <ul class="treeview-menu">
                           <!-- Inicio de Bloque de cuentas por cobrar -->
							<?php 
                            /////PERMISOS////////////////
                            if (isset($_SESSION['permisos']['cuentasporcobrar']['acceso'])){
                            ?>
                            <li class="treeview <?php echo checarLink("n2","cuentasporcobrar"); ?>">
                              <a href="#">
                                <i class="fa fa-credit-card"></i> <span>Cuentas por cobrar</span>
                                <i class="fa fa-angle-left pull-right"></i>
                              </a>
                              <ul class="treeview-menu">
                                <?php 
                                /////PERMISOS////////////////
                                if (isset($_SESSION['permisos']['cuentasporcobrar']['consultar'])){
                                ?>
                                <li class="<?php echo checarLink("n3","consultarcuentasporcobrar"); ?>">
                                  <a href="../../../modulos/cuentasporcobrar/consultar/vista.php?n1=facturacionycobranza&n2=cuentasporcobrar&n3=consultarcuentasporcobrar"><i class="fa fa-circle-o text-red"></i> Nuevo cobro</i></a>
                                </li>
                                 <?php }?>
                              </ul>
                            </li>
                            <?php }?>
                            <!-- Fin de Bloque de Cotizacionesotros -->
                            
                      
                     </ul><!-- fin de ul facturación y cobranza -->
                    </li> <!-- fin de li facturación y cobranza -->
                    <?php }?>
                    
                    
                    <!-- Inicio de Bloque Logistica -->
					<?php 
                    /////PERMISOS////////////////
                    if (isset($_SESSION['permisos']['clientes']['acceso']) or isset($_SESSION['permisos']['domicilios']['acceso']) or isset($_SESSION['permisos']['datosfiscales']['acceso'])){
                    ?>
                     <li class="treeview <?php echo checarLink("n1","logisticaysalidas"); ?>">
                      <a href="#">
                        <i class="fa fa-truck"></i> <span>Logistica y salidas</span>
                        <i class="fa fa-angle-left pull-right"></i>
                      </a>
                      <ul class="treeview-menu">
                      
                      
                     </ul><!-- fin de ul logistica -->
                    </li> <!-- fin de li logistica -->
                    <?php }?>
                    
                    
                    
                     <!-- Inicio de Bloque Compras -->
					<?php 
                    /////PERMISOS////////////////
                    if (isset($_SESSION['permisos']['clientes']['acceso']) or isset($_SESSION['permisos']['domicilios']['acceso']) or isset($_SESSION['permisos']['datosfiscales']['acceso'])){
                    ?>
                     <li class="treeview <?php echo checarLink("n1","compras"); ?>">
                      <a href="#">
                        <i class="fa fa-clone"></i> <span>Compras</span>
                        <i class="fa fa-angle-left pull-right"></i>
                      </a>
                      <ul class="treeview-menu">
                      
                      
                     </ul><!-- fin de ul compras -->
                    </li> <!-- fin de li compras -->
                    <?php }?>
                    
                    <!-- Inicio de Bloque Inventario -->
					<?php 
                    /////PERMISOS////////////////
                    if (isset($_SESSION['permisos']['clientes']['acceso']) or isset($_SESSION['permisos']['domicilios']['acceso']) or isset($_SESSION['permisos']['datosfiscales']['acceso'])){
                    ?>
                     <li class="treeview <?php echo checarLink("n1","inventario"); ?>">
                      <a href="#">
                        <i class="fa fa-cubes"></i> <span>Inventario</span>
                        <i class="fa fa-angle-left pull-right"></i>
                      </a>
                      <ul class="treeview-menu">
                      
                      
                     </ul><!-- fin de ul inventario -->
                    </li> <!-- fin de li inventario -->
                    <?php }?>
                    
                   
                   <!-- Inicio de Bloque Bancos -->
					<?php 
                    /////PERMISOS////////////////
                    if (isset($_SESSION['permisos']['clientes']['acceso']) or isset($_SESSION['permisos']['domicilios']['acceso']) or isset($_SESSION['permisos']['datosfiscales']['acceso'])){
                    ?>
                     <li class="treeview <?php echo checarLink("n1","bancos"); ?>">
                      <a href="#">
                        <i class="fa fa-bank "></i> <span>Bancos</span>
                        <i class="fa fa-angle-left pull-right"></i>
                      </a>
                      <ul class="treeview-menu">
                      
                      
                     </ul><!-- fin de ul bancos -->
                    </li> <!-- fin de li bancos -->
                    <?php }?>
                   
                   
                   <!-- Inicio de Bloque Utilerias -->
					<?php 
                    /////PERMISOS////////////////
                    if (isset($_SESSION['permisos']['clientes']['acceso']) or isset($_SESSION['permisos']['domicilios']['acceso']) or isset($_SESSION['permisos']['datosfiscales']['acceso'])){
                    ?>
                     <li class="treeview <?php echo checarLink("n1","utilerias"); ?>">
                      <a href="#">
                        <i class="fa fa-thumbs-up"></i> <span>Utilerias</span>
                        <i class="fa fa-angle-left pull-right"></i>
                      </a>
                      <ul class="treeview-menu">
                      
                        <!-- Inicio de Bloque de Folios -->
						<?php 
                        /////PERMISOS////////////////
                        if (isset($_SESSION['permisos']['folios']['acceso'])){
                        ?>
                        <li class="treeview <?php echo checarLink("n2","folios"); ?>">
                          <a href="#">
                            <i class="fa fa-sort-numeric-asc" style="color:#8c778c"></i> <span>Folios</span>
                            <i class="fa fa-angle-left pull-right"></i>
                          </a>
                          <ul class="treeview-menu">
                            <?php 
                            /////PERMISOS////////////////
                            if (isset($_SESSION['permisos']['folios']['guardar'])){
                            ?>
                            <li class="<?php echo checarLink("n3","nuevofolios"); ?>">
                            <a href="../../../modulos/folios/nuevo/nuevo.php?n1=utilerias&n2=folios&n3=nuevofolios"><i class="fa fa-circle-o text-green"></i> Nueva folio</a></li>
                            <?php }?>
                            
                            <?php 
                            /////PERMISOS////////////////
                            if (isset($_SESSION['permisos']['folios']['consultar'])){
                            ?>
                            <li class="<?php echo checarLink("n3","consultarfolios"); ?>">
                              <a href="../../../modulos/folios/consultar/vista.php?n1=utilerias&n2=folios&n3=consultarfolios"><i class="fa fa-circle-o text-red"></i> Consultar folios</i></a>
                            </li>
                             <?php }?>
                              <?php 
                            /////PERMISOS////////////////
                            if (isset($_SESSION['permisos']['folios']['papelera'])){
                            ?>
                            <li class="<?php echo checarLink("n3","papelerafolios"); ?>">
                              <a href="../../../modulos/folios/consultar/vista.php?n1=utilerias&n2=folios&n3=papelerafolios&papelera"><i class="fa fa-circle-o text-yellow"></i> Papelera de folios</i></a>
                            </li>
                             <?php }?>
                          </ul>
                        </li>
                        <?php }?>
                        <!-- Fin de Bloque de Folios -->
                        
                        
                        
                        
                         <!-- Inicio de Bloque Control vehicular -->
                        <?php 
                        /////PERMISOS////////////////
                        if (isset($_SESSION['permisos']['clientes']['acceso']) or isset($_SESSION['permisos']['domicilios']['acceso']) or isset($_SESSION['permisos']['datosfiscales']['acceso'])){
                        ?>
                         <li class="treeview <?php echo checarLink("n2","controlvehicular"); ?>">
                          <a href="#">
                            <i class="fa fa-bus"></i> <span>Control vehicular</span>
                            <i class="fa fa-angle-left pull-right"></i>
                          </a>
                          <ul class="treeview-menu">
                          
                          
                         </ul><!-- fin de ul Control vehigular -->
                        </li> <!-- fin de li Control vehicular -->
                        <?php }?>
                    
                    
                     </ul><!-- fin de ul utilerías -->
                    </li> <!-- fin de li utilerias -->
                    <?php }?>
                    
                    
                       <!-- Inicio de Bloque Reportes -->
					<?php 
                    /////PERMISOS////////////////
                    if (isset($_SESSION['permisos']['clientes']['acceso']) or isset($_SESSION['permisos']['domicilios']['acceso']) or isset($_SESSION['permisos']['datosfiscales']['acceso'])){
                    ?>
                     <li class="treeview <?php echo checarLink("n1","reporte"); ?>">
                      <a href="#">
                        <i class="fa fa-bar-chart"></i> <span>Reportes</span>
                        <i class="fa fa-angle-left pull-right"></i>
                      </a>
                      <ul class="treeview-menu">
                      
                      
                     </ul><!-- fin de ul reportes -->
                    </li> <!-- fin de li resportes -->
                    <?php }?>
                   
                    <!-- Inicio de Bloque catálogos -->
					<?php 
                    /////PERMISOS////////////////
                    if (isset($_SESSION['permisos']['clientes']['acceso']) or isset($_SESSION['permisos']['domicilios']['acceso']) or isset($_SESSION['permisos']['datosfiscales']['acceso'])){
                    ?>
                     <li class="treeview <?php echo checarLink("n1","catalogos"); ?>">
                      <a href="#">
                        <i class="fa fa-book"></i> <span>Catálogos</span>
                        <i class="fa fa-angle-left pull-right"></i>
                      </a>
                      <ul class="treeview-menu">
                      
                      
                    <li class="treeview <?php echo checarLink("n2","clientes"); ?>">
                      <a href="#">
                        <i class="fa fa-users"></i> <span>Clientes</span>
                        <i class="fa fa-angle-left pull-right"></i>
                      </a>
                      <ul class="treeview-menu">
                      
                      
                        <?php 
                        /////PERMISOS////////////////
                        if (isset($_SESSION['permisos']['clientes']['acceso'])){
                        ?>
                        <li class="<?php echo checarLink("n3","clientes"); ?>">
                          <a href="#"><i class="fa fa-child"></i> Clientes <i class="fa fa-angle-left pull-right"></i></a>
                          <ul class="treeview-menu">
                            <?php 
                            /////PERMISOS////////////////
                            if (isset($_SESSION['permisos']['clientes']['guardar'])){
                            ?>
                            <li class="<?php echo checarLink("n4","nuevoclientes"); ?>"><a href="../../../modulos/clientes/nuevo/nuevo.php?n1=catalogos&n2=clientes&n3=clientes&n4=nuevoclientes"><i class="fa fa-circle-o text-green"></i> Nuevo cliente </a></li>
                            <?php }?>
                            <?php 
                            /////PERMISOS////////////////
                            if (isset($_SESSION['permisos']['clientes']['consultar'])){
                            ?>
                            <li class="<?php echo checarLink("n4","consultarclientes"); ?>"><a href="../../../modulos/clientes/consultar/vista.php?n1=catalogos&n2=clientes&n3=clientes&n4=consultarclientes"><i class="fa fa-circle-o text-red"></i> Consultar clientes </a></li>
                            <?php }?>
                            <?php 
                            /////PERMISOS////////////////
                            if (isset($_SESSION['permisos']['clientes']['papelera'])){
                            ?>
                            <li class="<?php echo checarLink("n4","papeleraclientes"); ?>"><a href="../../../modulos/clientes/consultar/vista.php?n1=catalogos&n2=clientes&n3=clientes&n4=papeleraclientes&papelera"><i class="fa fa-circle-o text-yellow"></i> Papelera </a></li>
                            <?php }?>
                          </ul>
                        </li>
                        <?php }?>
                        
                         <!-- Inicio de Bloque Contactos-->
                        <?php 
                        /////PERMISOS////////////////
                        if (isset($_SESSION['permisos']['contactos']['acceso'])){
                        ?>
                        <li class="<?php echo checarLink("n3","contactos"); ?>">
                          <a href="#"><i class="fa fa-phone-square"></i> Contactos <i class="fa fa-angle-left pull-right"></i></a>
                          <ul class="treeview-menu">
                           
                            <?php 
                            /////PERMISOS////////////////
                            if (isset($_SESSION['permisos']['contactos']['guardar'])){
                            ?>
                            <li class="<?php echo checarLink("n4","nuevocontactos"); ?>"><a href="../../../modulos/contactos/nuevo/nuevo.php?n1=catalogos&n2=clientes&n3=contactos&n4=nuevocontactos"><i class="fa fa-circle-o text-green"></i> Nuevo contacto </a></li>
                            <?php }?>
                            
                            <?php 
                            /////PERMISOS////////////////
                            if (isset($_SESSION['permisos']['contactos']['consultar'])){
                            ?>
                            <li class="<?php echo checarLink("n4","consultarcontactos"); ?>"><a href="../../../modulos/contactos/consultar/vista.php?n1=catalogos&n2=clientes&n3=contactos&n4=consultarcontactos"><i class="fa fa-circle-o text-red"></i> Consultar contactos</a></li>
                            <?php }?>
                             
                          </ul>
                        </li>
                        <?php }?>
                        
                        <!-- Inicio de Bloque Domicilios-->
                        <?php 
                        /////PERMISOS////////////////
                        if (isset($_SESSION['permisos']['domicilios']['acceso'])){
                        ?>
                        <li class="<?php echo checarLink("n3","domicilios"); ?>">
                          <a href="#"><i class="fa fa-key"></i> Domiclios <i class="fa fa-angle-left pull-right"></i></a>
                          <ul class="treeview-menu">
                            <?php 
                            /////PERMISOS////////////////
                            if (isset($_SESSION['permisos']['domicilios']['guardar'])){
                            ?>
                            <li class="<?php echo checarLink("n4","nuevodomicilios"); ?>"><a href="../../../modulos/domicilios/nuevo/nuevo.php?n1=catalogos&n2=clientes&n3=domicilios&n4=nuevodomicilios"><i class="fa fa-circle-o text-green"></i> Nuevo domicilio</a></li>
                            <?php }?>
                            <?php 
                            /////PERMISOS////////////////
                            if (isset($_SESSION['permisos']['domicilios']['consultar'])){
                            ?>
                            <li class="<?php echo checarLink("n4","consultardomicilios"); ?>"><a href="../../../modulos/domicilios/consultar/vista.php?n1=catalogos&n2=clientes&n3=domicilios&n4=consultardomicilios"><i class="fa fa-circle-o text-red"></i> Consultar domicilios</a></li>
                            <?php }?>
                             <?php 
                            /////PERMISOS////////////////
                            if (isset($_SESSION['permisos']['domicilios']['papelera'])){
                            ?>
                            <li class="<?php echo checarLink("n4","papeleradomicilios"); ?>"><a href="../../../modulos/domicilios/consultar/vista.php?n1=catalogos&n2=clientes&n3=domicilios&n4=papeleradomicilios&papelera"><i class="fa fa-circle-o text-yellow"></i> Papelera</a></li>
                            <?php }?>
                          </ul>
                        </li>
                        <?php }?>
                        
                          <!-- Inicio de Bloque de Datosfiscales -->
                        <?php 
                        /////PERMISOS////////////////
                        if (isset($_SESSION['permisos']['datosfiscales']['acceso'])){
                        ?>
                        <li class="<?php echo checarLink("n3","datosfiscales"); ?>">
                          <a href="#"><i class="fa fa-key"></i> Domiclios fiscales <i class="fa fa-angle-left pull-right"></i></a>
                          <ul class="treeview-menu">
                             <?php 
                            /////PERMISOS////////////////
                            if (isset($_SESSION['permisos']['datosfiscales']['guardar'])){
                            ?>
                            <li class="<?php echo checarLink("n4","nuevodatosfiscales"); ?>"><a href="../../../modulos/datosfiscales/nuevo/nuevo.php?n1=catalogos&n2=clientes&n3=datosfiscales&n4=nuevodatosfiscales"><i class="fa fa-circle-o text-green"></i> Nuevo domicilio</a></li>
                            <?php }?>
                            <?php 
                            /////PERMISOS////////////////
                            if (isset($_SESSION['permisos']['datosfiscales']['consultar'])){
                            ?>
                            <li class="<?php echo checarLink("n4","consultardatosfiscales"); ?>"><a href="../../../modulos/datosfiscales/consultar/vista.php?n1=catalogos&n2=clientes&n3=datosfiscales&n4=consultardatosfiscales"><i class="fa fa-circle-o text-red"></i> Consultar domicilios</a></li>
                            <?php }?>
                            
                             <?php 
                            /////PERMISOS////////////////
                            if (isset($_SESSION['permisos']['datosfiscales']['papelera'])){
                            ?>
                            <li class="<?php echo checarLink("n3","papeleradatosfiscales"); ?>"><a href="../../../modulos/datosfiscales/consultar/vista.php?n1=catalogos&n2=clientes&n3=datosfiscales&n4=papeleradatosfiscales&papelera"><i class="fa fa-circle-o text-yellow"></i> Papelera</a></li>
                            <?php }?>
                          </ul>
                        </li>
                        <?php }?>
                         </ul><!-- fin de ul clientes -->
                           </li><!-- fin de li clientes -->
                      
                    
                    <li class="treeview <?php echo checarLink("n2","productos"); ?>">
                      <a href="#">
                        <i class="fa fa-cubes"></i> <span>Productos</span>
                        <i class="fa fa-angle-left pull-right"></i>
                      </a>
                      <ul class="treeview-menu">
                      
                      <!-- Inicio de Bloque de Productos -->
                    <?php 
                    /////PERMISOS////////////////
                    if (isset($_SESSION['permisos']['productos']['acceso'])){
                    ?>
                    <li class="treeview <?php echo checarLink("n3","productos"); ?>">
                      <a href="#">
                        <i class="fa fa-cubes" style="color:#3dabc2"></i> <span>Productos</span>
                        <i class="fa fa-angle-left pull-right"></i>
                      </a>
                      <ul class="treeview-menu">
                      
                        <?php 
                        /////PERMISOS////////////////
                        if (isset($_SESSION['permisos']['productos']['guardar'])){
                        ?>
                        <li class="<?php echo checarLink("n4","nuevoproductos"); ?>">
                        <a href="../../../modulos/productos/nuevo/nuevo.php?n1=catalogos&n2=productos&n3=productos&n4=nuevoproductos"><i class="fa fa-circle-o text-green"></i> Nuevo producto</a></li>
                        <?php }?>
                        
                        <?php 
                        /////PERMISOS////////////////
                        if (isset($_SESSION['permisos']['productos']['consultar'])){
                        ?>
                        <li class="<?php echo checarLink("n4","consultarproductos"); ?>">
                          <a href="../../../modulos/productos/consultar/vista.php?n1=catalogos&n2=productos&n3=productos&n4=consultarproductos"><i class="fa fa-circle-o text-red"></i> Consultar productos</i></a>
                        </li>
                         <?php }?>
                          <?php 
                        /////PERMISOS////////////////
                        if (isset($_SESSION['permisos']['productos']['papelera'])){
                        ?>
                        <li class="<?php echo checarLink("n4","papeleraproductos"); ?>">
                          <a href="../../../modulos/productos/consultar/vista.php?n1=catalogos&n2=productos&n3=productos&n4=papeleraproductos&papelera"><i class="fa fa-circle-o text-yellow"></i> Papelera de productos</i></a>
                        </li>
                         <?php }?>
                      </ul>
                    </li>
                    <?php }?>
                    <!-- Fin de Bloque de Productos -->
                    
                    <!-- Inicio de Bloque -->
					<?php 
                    /////PERMISOS////////////////
                    if (isset($_SESSION['permisos']['familias']['acceso'])){
                    ?>
                    <li class="treeview <?php echo checarLink("n3","familias"); ?>">
                      <a href="#">
                        <i class="fa fa-list-ol" style="color:#345FAD"></i> <span>Familias</span>
                        <i class="fa fa-angle-left pull-right"></i>
                      </a>
                      <ul class="treeview-menu">
                        <?php 
                        /////PERMISOS////////////////
                        if (isset($_SESSION['permisos']['familias']['guardar'])){
                        ?>
                        <li class="<?php echo checarLink("n4","nuevofamilias"); ?>">
                        <a href="../../../modulos/familias/nuevo/nuevo.php?n1=catalogos&n2=productos&n3=familias&n3=nuevofamilias"><i class="fa fa-circle-o text-green"></i> Nueva familia</a></li>
                        <?php }?>
                        
                        <?php 
                        /////PERMISOS////////////////
                        if (isset($_SESSION['permisos']['familias']['consultar'])){
                        ?>
                        <li class="<?php echo checarLink("n4","consultarfamilias"); ?>">
                          <a href="../../../modulos/familias/consultar/vista.php?n1=catalogos&n2=productos&n3=familias&n4=consultarfamilias"><i class="fa fa-circle-o text-red"></i> Consultar familias</i></a>
                        </li>
                         <?php }?>
                          <?php 
                        /////PERMISOS////////////////
                        if (isset($_SESSION['permisos']['familias']['papelera'])){
                        ?>
                        <li class="<?php echo checarLink("n4","papelerafamilias"); ?>">
                          <a href="../../../modulos/familias/consultar/vista.php?n1=catalogos&n2=productos&n3=familias&n4=papelerafamilias&papelera"><i class="fa fa-circle-o text-yellow"></i> Papelera de familias</i></a>
                        </li>
                         <?php }?>
                      </ul>
                    </li>
                    <?php }?>
			       <!-- Fin de Bloque de Listasprecios -->

                    
                    
                     <!-- Inicio de Bloque -->
					<?php 
                    /////PERMISOS////////////////
                    if (isset($_SESSION['permisos']['listasprecios']['acceso'])){
                    ?>
                    <li class="treeview <?php echo checarLink("n3","listasprecios"); ?>">
                      <a href="#">
                        <i class="fa fa-list-ol" style="color:#345FAD"></i> <span>Listas de precios</span>
                        <i class="fa fa-angle-left pull-right"></i>
                      </a>
                      <ul class="treeview-menu">
                        <?php 
                        /////PERMISOS////////////////
                        if (isset($_SESSION['permisos']['listasprecios']['guardar'])){
                        ?>
                        <li class="<?php echo checarLink("n4","nuevolistasprecios"); ?>">
                        <a href="../../../modulos/listasprecios/nuevo/nuevo.php?n1=catalogos&n2=productos&n3=listasprecios&n3=nuevolistasprecios"><i class="fa fa-circle-o text-green"></i> Nueva lista</a></li>
                        <?php }?>
                        
                        <?php 
                        /////PERMISOS////////////////
                        if (isset($_SESSION['permisos']['listasprecios']['consultar'])){
                        ?>
                        <li class="<?php echo checarLink("n4","consultarlistasprecios"); ?>">
                          <a href="../../../modulos/listasprecios/consultar/vista.php?n1=catalogos&n2=productos&n3=listasprecios&n4=consultarlistasprecios"><i class="fa fa-circle-o text-red"></i> Consultar listas</i></a>
                        </li>
                         <?php }?>
                          <?php 
                        /////PERMISOS////////////////
                        if (isset($_SESSION['permisos']['listasprecios']['papelera'])){
                        ?>
                        <li class="<?php echo checarLink("n4","papeleralistasprecios"); ?>">
                          <a href="../../../modulos/listasprecios/consultar/vista.php?n1=catalogos&n2=productos&n3=listasprecios&n4=papeleralistasprecios&papelera"><i class="fa fa-circle-o text-yellow"></i> Papelera de listas</i></a>
                        </li>
                         <?php }?>
                      </ul>
                    </li>
                    <?php }?>
			<!-- Fin de Bloque de Listasprecios -->
                      
                    
                      
                       </ul><!-- fin de ul productos -->
                       </li> <!-- fin de li productos -->
                      
                       <!-- Inicio de Bloque -->
						<?php 
                        /////PERMISOS////////////////
                        if (isset($_SESSION['permisos']['empleados']['acceso'])){
                        ?>
                        <li class="treeview <?php echo checarLink("n2","empleados"); ?>">
                          <a href="#">
                            <i class="fa fa-male"></i> <span>Empleados</span>
                            <i class="fa fa-angle-left pull-right"></i>
                          </a>
                          <ul class="treeview-menu">
                            <?php 
                            /////PERMISOS////////////////
                            if (isset($_SESSION['permisos']['empleados']['guardar'])){
                            ?>
                            <li class="<?php echo checarLink("n3","nuevoempleados"); ?>">
                            <a href="../../../modulos/empleados/nuevo/nuevo.php?n1=catalogos&n2=empleados&n3=nuevoempleados"><i class="fa fa-circle-o text-green"></i> Nuevo empleado</a></li>
                            <?php }?>
                            <?php 
                            /////PERMISOS////////////////
                            if (isset($_SESSION['permisos']['empleados']['consultar'])){
                            ?>
                            <li class="<?php echo checarLink("n3","consultarempleados"); ?>">
                              <a href="../../../modulos/empleados/consultar/vista.php?n1=catalogos&n2=empleados&n3=consultarempleados"><i class="fa fa-circle-o text-red"></i> Consultar empleados</i></a>
                            </li>
                            <?php }?>
                            <?php 
                            /////PERMISOS////////////////
                            if (isset($_SESSION['permisos']['empleados']['papelera'])){
                            ?>
                            <li class="<?php echo checarLink("n3","papeleraempleados"); ?>">
                              <a href="../../../modulos/empleados/consultar/vista.php?n1=catalogos&n2=empleados&n3=papeleraempleados&papelera"><i class="fa fa-circle-o text-yellow"></i> Papelera de empleados</i></a>
                            </li>
                             <?php }?>
                          </ul>
                        </li>
                        <?php }?>
                        <!-- fin de empleados -->
                        
                      
                      <!-- Inicio de Bloque de Sucursales -->
						<?php 
                        /////PERMISOS////////////////
                        if (isset($_SESSION['permisos']['sucursales']['acceso'])){
                        ?>
                        <li class="treeview <?php echo checarLink("n2","sucursales"); ?>">
                          <a href="#">
                            <i class="fa fa-home" style="color:#cf2341"></i> <span>Sucursales</span>
                            <i class="fa fa-angle-left pull-right"></i>
                          </a>
                          <ul class="treeview-menu">
                            <?php 
                            /////PERMISOS////////////////
                            if (isset($_SESSION['permisos']['sucursales']['guardar'])){
                            ?>
                            <li class="<?php echo checarLink("n3","nuevosucursales"); ?>">
                            <a href="../../../modulos/sucursales/nuevo/nuevo.php?n1=catalogos&n2=sucursales&n3=nuevosucursales"><i class="fa fa-circle-o text-green"></i> Nueva sucursal</a></li>
                            <?php }?>
                            
                            <?php 
                            /////PERMISOS////////////////
                            if (isset($_SESSION['permisos']['sucursales']['consultar'])){
                            ?>
                            <li class="<?php echo checarLink("n3","consultarsucursales"); ?>">
                              <a href="../../../modulos/sucursales/consultar/vista.php?n1=catalogos&n2=sucursales&n3=consultarsucursales"><i class="fa fa-circle-o text-red"></i> Consultar sucursales</i></a>
                            </li>
                             <?php }?>
                              <?php 
                            /////PERMISOS////////////////
                            if (isset($_SESSION['permisos']['sucursales']['papelera'])){
                            ?>
                            <li class="<?php echo checarLink("n3","papelerasucursales"); ?>">
                              <a href="../../../modulos/sucursales/consultar/vista.php?n1=catalogos&n2=sucursales&n3=papelerasucursales&papelera"><i class="fa fa-circle-o text-yellow"></i> Papelera de sucursales</i></a>
                            </li>
                             <?php }?>
                          </ul>
                        </li>
                        <?php }?>
                        <!-- Fin de Bloque de Sucursales -->
                      
                      
                       
                        <!-- Inicio de Bloque de Estados -->
                        <?php 
                        /////PERMISOS////////////////
                        if (isset($_SESSION['permisos']['estados']['acceso'])){
                        ?>
                        <li class="treeview <?php echo checarLink("n2","estados"); ?>">
                          <a href="#">
                            <i class="fa fa-ellipsis-h" style="color:#66534a"></i> <span>Estados</span>
                            <i class="fa fa-angle-left pull-right"></i>
                          </a>
                          <ul class="treeview-menu">
                            <?php 
                            /////PERMISOS////////////////
                            if (isset($_SESSION['permisos']['estados']['guardar'])){
                            ?>
                            <li class="<?php echo checarLink("n3","nuevoestados"); ?>">
                            <a href="../../../modulos/estados/nuevo/nuevo.php?n1=catalogos&n2=estados&n3=nuevoestados"><i class="fa fa-circle-o text-green"></i> Nuevo estado</a></li>
                            <?php }?>
                            
                            <?php 
                            /////PERMISOS////////////////
                            if (isset($_SESSION['permisos']['estados']['consultar'])){
                            ?>
                            <li class="<?php echo checarLink("n3","consultarestados"); ?>">
                              <a href="../../../modulos/estados/consultar/vista.php?n1=catalogos&n2=estados&n3=consultarestados"><i class="fa fa-circle-o text-red"></i> Consultar estados</i></a>
                            </li>
                             <?php }?>
                          </ul>
                        </li>
                        <?php }?>
                        <!-- Fin de Bloque de Estados -->
                        
                        
                        
                        <!-- Inicio de Bloque de Ciudades -->
                        <?php 
                        /////PERMISOS////////////////
                        if (isset($_SESSION['permisos']['ciudades']['acceso'])){
                        ?>
                        <li class="treeview <?php echo checarLink("n2","ciudades"); ?>">
                          <a href="#">
                            <i class="fa fa-ellipsis-h" style="color:#4598af"></i> <span>Ciudades</span>
                            <i class="fa fa-angle-left pull-right"></i>
                          </a>
                          <ul class="treeview-menu">
                            <?php 
                            /////PERMISOS////////////////
                            if (isset($_SESSION['permisos']['ciudades']['guardar'])){
                            ?>
                            <li class="<?php echo checarLink("n3","nuevociudades"); ?>">
                            <a href="../../../modulos/ciudades/nuevo/nuevo.php?n1=catalogos&n2=ciudades&n3=nuevociudades"><i class="fa fa-circle-o text-green"></i> Nueva ciudad</a></li>
                            <?php }?>
                            
                            <?php 
                            /////PERMISOS////////////////
                            if (isset($_SESSION['permisos']['ciudades']['consultar'])){
                            ?>
                            <li class="<?php echo checarLink("n3","consultarciudades"); ?>">
                              <a href="../../../modulos/ciudades/consultar/vista.php?n1=catalogos&n2=ciudades&n3=consultarciudades"><i class="fa fa-circle-o text-red"></i> Consultar ciudades</i></a>
                            </li>
                             <?php }?>
                          </ul>
                        </li>
                        <?php }?>
                        <!-- Fin de Bloque de Ciudades -->
                      
                      
                        <!-- Inicio de Bloque Zonas -->
                        <?php 
                        /////PERMISOS////////////////
                        if (isset($_SESSION['permisos']['zonas']['acceso'])){
                        ?>
                        <li class="treeview <?php echo checarLink("n2","zonas"); ?>">
                          <a href="#">
                            <i class="fa fa-map-o" style="color:#DC1F40"></i> <span>Zonas</span>
                            <i class="fa fa-angle-left pull-right"></i>
                          </a>
                          <ul class="treeview-menu">
                            <?php 
                            /////PERMISOS////////////////
                            if (isset($_SESSION['permisos']['zonas']['guardar'])){
                            ?>
                            <li class="<?php echo checarLink("n3","nuevozonas"); ?>">
                            <a href="../../../modulos/zonas/nuevo/nuevo.php?n1=catalogos&n2=zonas&n3=nuevozonas"><i class="fa fa-circle-o text-green"></i> Nueva zona</a></li>
                            <?php }?>
                            
                            <?php 
                            /////PERMISOS////////////////
                            if (isset($_SESSION['permisos']['zonas']['consultar'])){
                            ?>
                            <li class="<?php echo checarLink("n3","consultarzonas"); ?>">
                              <a href="../../../modulos/zonas/consultar/vista.php?n1=catalogos&n2=zonas&n3=consultarzonas"><i class="fa fa-circle-o text-red"></i> Consultar zonas</i></a>
                            </li>
                             <?php }?>
                              <?php 
                            /////PERMISOS////////////////
                            if (isset($_SESSION['permisos']['zonas']['papelera'])){
                            ?>
                            <li class="<?php echo checarLink("n3","papelerazonas"); ?>">
                              <a href="../../../modulos/zonas/consultar/vista.php?n1=catalogos&n2=zonas&n3=papelerazonas&papelera"><i class="fa fa-circle-o text-yellow"></i> Papelera de zonas</i></a>
                            </li>
                             <?php }?>
                          </ul>
                        </li>
                        <?php }?>
                        <!-- Fin de Bloque de Zonas -->
                        
                        <!-- Inicio de Bloque de Giroscomerciales -->
						<?php 
                        /////PERMISOS////////////////
                        if (isset($_SESSION['permisos']['giroscomerciales']['acceso'])){
                        ?>
                        <li class="treeview <?php echo checarLink("n2","giroscomerciales"); ?>">
                          <a href="#">
                            <i class="fa fa-book" style="color:#dad763"></i> <span>Giros comerciales</span>
                            <i class="fa fa-angle-left pull-right"></i>
                          </a>
                          <ul class="treeview-menu">
                            <?php 
                            /////PERMISOS////////////////
                            if (isset($_SESSION['permisos']['giroscomerciales']['guardar'])){
                            ?>
                            <li class="<?php echo checarLink("n3","nuevogiroscomerciales"); ?>">
                            <a href="../../../modulos/giroscomerciales/nuevo/nuevo.php?n1=catalogos&n2=giroscomerciales&n3=nuevogiroscomerciales"><i class="fa fa-circle-o text-green"></i> Nuevo</a></li>
                            <?php }?>
                            
                            <?php 
                            /////PERMISOS////////////////
                            if (isset($_SESSION['permisos']['giroscomerciales']['consultar'])){
                            ?>
                            <li class="<?php echo checarLink("n3","consultargiroscomerciales"); ?>">
                              <a href="../../../modulos/giroscomerciales/consultar/vista.php?n1=catalogos&n2=giroscomerciales&n3=consultargiroscomerciales"><i class="fa fa-circle-o text-red"></i> Consultar</i></a>
                            </li>
                             <?php }?>
                              <?php 
                            /////PERMISOS////////////////
                            if (isset($_SESSION['permisos']['giroscomerciales']['papelera'])){
                            ?>
                            <li class="<?php echo checarLink("n3","papeleragiroscomerciales"); ?>">
                              <a href="../../../modulos/giroscomerciales/consultar/vista.php?n1=catalogos&n2=giroscomerciales&n3=papeleragiroscomerciales&papelera"><i class="fa fa-circle-o text-yellow"></i> Papelera</i></a>
                            </li>
                             <?php }?>
                          </ul>
                        </li>
                        <?php }?>
                        <!-- Fin de Bloque de Giroscomerciales -->
                      
                        <!-- Inicio de Bloque de Mediospublicitarios -->
						<?php 
                        /////PERMISOS////////////////
                        if (isset($_SESSION['permisos']['mediospublicitarios']['acceso'])){
                        ?>
                        <li class="treeview <?php echo checarLink("n2","mediospublicitarios"); ?>">
                          <a href="#">
                            <i class="fa fa-newspaper-o" style="color:#faec6d"></i> <span>Medios publicitarios</span>
                            <i class="fa fa-angle-left pull-right"></i>
                          </a>
                          <ul class="treeview-menu">
                            <?php 
                            /////PERMISOS////////////////
                            if (isset($_SESSION['permisos']['mediospublicitarios']['guardar'])){
                            ?>
                            <li class="<?php echo checarLink("n3","nuevomediospublicitarios"); ?>">
                            <a href="../../../modulos/mediospublicitarios/nuevo/nuevo.php?n1=catalogos&n2=mediospublicitarios&n3=nuevomediospublicitarios"><i class="fa fa-circle-o text-green"></i> Nuevo</a></li>
                            <?php }?>
                            
                            <?php 
                            /////PERMISOS////////////////
                            if (isset($_SESSION['permisos']['mediospublicitarios']['consultar'])){
                            ?>
                            <li class="<?php echo checarLink("n3","consultarmediospublicitarios"); ?>">
                              <a href="../../../modulos/mediospublicitarios/consultar/vista.php?n1=catalogos&n2=mediospublicitarios&n3=consultarmediospublicitarios"><i class="fa fa-circle-o text-red"></i> Consultar</i></a>
                            </li>
                             <?php }?>
                              <?php 
                            /////PERMISOS////////////////
                            if (isset($_SESSION['permisos']['mediospublicitarios']['papelera'])){
                            ?>
                            <li class="<?php echo checarLink("n3","papeleramediospublicitarios"); ?>">
                              <a href="../../../modulos/mediospublicitarios/consultar/vista.php?n1=catalogos&n2=mediospublicitarios&n3=papeleramediospublicitarios&papelera"><i class="fa fa-circle-o text-yellow"></i> Papelera</i></a>
                            </li>
                             <?php }?>
                          </ul>
                        </li>
                        <?php }?>
                        <!-- Fin de Bloque de Mediospublicitarios -->

                      
                        <!-- Inicio de Bloque de Proveedores -->
						<?php 
                        /////PERMISOS////////////////
                        if (isset($_SESSION['permisos']['proveedores']['acceso'])){
                        ?>
                        <li class="treeview <?php echo checarLink("n2","proveedores"); ?>">
                          <a href="#">
                            <i class="fa fa-industry" style="color:#4e8b7d"></i> <span>Proveedores</span>
                            <i class="fa fa-angle-left pull-right"></i>
                          </a>
                          <ul class="treeview-menu">
                            <?php 
                            /////PERMISOS////////////////
                            if (isset($_SESSION['permisos']['proveedores']['guardar'])){
                            ?>
                            <li class="<?php echo checarLink("n3","nuevoproveedores"); ?>">
                            <a href="../../../modulos/proveedores/nuevo/nuevo.php?n1=catalogos&n2=proveedores&n3=nuevoproveedores"><i class="fa fa-circle-o text-green"></i> Nuevo proveedor</a></li>
                            <?php }?>
                            
                            <?php 
                            /////PERMISOS////////////////
                            if (isset($_SESSION['permisos']['proveedores']['consultar'])){
                            ?>
                            <li class="<?php echo checarLink("n3","consultarproveedores"); ?>">
                              <a href="../../../modulos/proveedores/consultar/vista.php?n1=catalogos&n2=proveedores&n3=consultarproveedores"><i class="fa fa-circle-o text-red"></i> Consultar proveedores</i></a>
                            </li>
                             <?php }?>
                              <?php 
                            /////PERMISOS////////////////
                            if (isset($_SESSION['permisos']['proveedores']['papelera'])){
                            ?>
                            <li class="<?php echo checarLink("n3","papeleraproveedores"); ?>">
                              <a href="../../../modulos/proveedores/consultar/vista.php?n1=catalogos&n2=proveedores&n3=papeleraproveedores&papelera"><i class="fa fa-circle-o text-yellow"></i> Papelera de proveedores</i></a>
                            </li>
                             <?php }?>
                          </ul>
                        </li>
                        <?php }?>
                        <!-- Fin de Bloque de Proveedores -->
                      
                       <!-- Inicio de Bloque de Cuentasbancarias -->
						<?php 
                        /////PERMISOS////////////////
                        if (isset($_SESSION['permisos']['cuentasbancarias']['acceso'])){
                        ?>
                        <li class="treeview <?php echo checarLink("n2","cuentasbancarias"); ?>">
                          <a href="#">
                            <i class="fa fa-credit-card" style="color:#474486"></i> <span>Cuentas bancarias</span>
                            <i class="fa fa-angle-left pull-right"></i>
                          </a>
                          <ul class="treeview-menu">
                            <?php 
                            /////PERMISOS////////////////
                            if (isset($_SESSION['permisos']['cuentasbancarias']['guardar'])){
                            ?>
                            <li class="<?php echo checarLink("n3","nuevocuentasbancarias"); ?>">
                            <a href="../../../modulos/cuentasbancarias/nuevo/nuevo.php?n1=catalogos&n2=cuentasbancarias&n3=nuevocuentasbancarias"><i class="fa fa-circle-o text-green"></i> Nueva cuenta</a></li>
                            <?php }?>
                            
                            <?php 
                            /////PERMISOS////////////////
                            if (isset($_SESSION['permisos']['cuentasbancarias']['consultar'])){
                            ?>
                            <li class="<?php echo checarLink("n3","consultarcuentasbancarias"); ?>">
                              <a href="../../../modulos/cuentasbancarias/consultar/vista.php?n1=catalogos&n2=cuentasbancarias&n3=consultarcuentasbancarias"><i class="fa fa-circle-o text-red"></i> Consultar cuentas</i></a>
                            </li>
                             <?php }?>
                              <?php 
                            /////PERMISOS////////////////
                            if (isset($_SESSION['permisos']['cuentasbancarias']['papelera'])){
                            ?>
                            <li class="<?php echo checarLink("n3","papeleracuentasbancarias"); ?>">
                              <a href="../../../modulos/cuentasbancarias/consultar/vista.php?n1=catalogos&n2=cuentasbancarias&n3=papeleracuentasbancarias&papelera"><i class="fa fa-circle-o text-yellow"></i> Papelera de cuentas</i></a>
                            </li>
                             <?php }?>
                          </ul>
                        </li>
                        <?php }?>
                        <!-- Fin de Bloque de Cuentasbancarias -->
            
                        <!-- Inicio de Bloque de Cuentasprincipales -->
                        <?php 
                        /////PERMISOS////////////////
                        if (isset($_SESSION['permisos']['cuentasprincipales']['acceso'])){
                        ?>
                        <li class="treeview <?php echo checarLink("n2","cuentasprincipales"); ?>">
                          <a href="#">
                            <i class="fa fa-book" style="color:#713878"></i> <span>Cuentas principales</span>
                            <i class="fa fa-angle-left pull-right"></i>
                          </a>
                          <ul class="treeview-menu">
                            <?php 
                            /////PERMISOS////////////////
                            if (isset($_SESSION['permisos']['cuentasprincipales']['guardar'])){
                            ?>
                            <li class="<?php echo checarLink("n3","nuevocuentasprincipales"); ?>">
                            <a href="../../../modulos/cuentasprincipales/nuevo/nuevo.php?n1=catalogos&n2=cuentasprincipales&n3=nuevocuentasprincipales"><i class="fa fa-circle-o text-green"></i> Nueva cuenta</a></li>
                            <?php }?>
                            
                            <?php 
                            /////PERMISOS////////////////
                            if (isset($_SESSION['permisos']['cuentasprincipales']['consultar'])){
                            ?>
                            <li class="<?php echo checarLink("n3","consultarcuentasprincipales"); ?>">
                              <a href="../../../modulos/cuentasprincipales/consultar/vista.php?n1=catalogos&n2=cuentasprincipales&n3=consultarcuentasprincipales"><i class="fa fa-circle-o text-red"></i> Consultar cuentas</i></a>
                            </li>
                             <?php }?>
                              <?php 
                            /////PERMISOS////////////////
                            if (isset($_SESSION['permisos']['cuentasprincipales']['papelera'])){
                            ?>
                            <li class="<?php echo checarLink("n3","papeleracuentasprincipales"); ?>">
                              <a href="../../../modulos/cuentasprincipales/consultar/vista.php?n1=catalogos&n2=cuentasprincipales&n3=papeleracuentasprincipales&papelera"><i class="fa fa-circle-o text-yellow"></i> Papelera de cuentas</i></a>
                            </li>
                             <?php }?>
                          </ul>
                        </li>
                        <?php }?>
                        <!-- Fin de Bloque de Cuentasprincipales -->
            
            
                        <!-- Inicio de Bloque de Cuentassecundarias -->
                        <?php 
                        /////PERMISOS////////////////
                        if (isset($_SESSION['permisos']['cuentassecundarias']['acceso'])){
                        ?>
                        <li class="treeview <?php echo checarLink("n2","cuentassecundarias"); ?>">
                          <a href="#">
                            <i class="fa fa-clipboard" style="color:#af644e"></i> <span>Cuentas secundarias</span>
                            <i class="fa fa-angle-left pull-right"></i>
                          </a>
                          <ul class="treeview-menu">
                            <?php 
                            /////PERMISOS////////////////
                            if (isset($_SESSION['permisos']['cuentassecundarias']['guardar'])){
                            ?>
                            <li class="<?php echo checarLink("n3","nuevocuentassecundarias"); ?>">
                            <a href="../../../modulos/cuentassecundarias/nuevo/nuevo.php?n1=catalogos&n2=cuentassecundarias&n3=nuevocuentassecundarias"><i class="fa fa-circle-o text-green"></i> Nueva cuenta</a></li>
                            <?php }?>
                            
                            <?php 
                            /////PERMISOS////////////////
                            if (isset($_SESSION['permisos']['cuentassecundarias']['consultar'])){
                            ?>
                            <li class="<?php echo checarLink("n3","consultarcuentassecundarias"); ?>">
                              <a href="../../../modulos/cuentassecundarias/consultar/vista.php?n1=catalogos&n2=cuentassecundarias&n3=consultarcuentassecundarias"><i class="fa fa-circle-o text-red"></i> Consultar cuentas</i></a>
                            </li>
                             <?php }?>
                              <?php 
                            /////PERMISOS////////////////
                            if (isset($_SESSION['permisos']['cuentassecundarias']['papelera'])){
                            ?>
                            <li class="<?php echo checarLink("n3","papeleracuentassecundarias"); ?>">
                              <a href="../../../modulos/cuentassecundarias/consultar/vista.php?n1=catalogos&n2=cuentassecundarias&n3=papeleracuentassecundarias&papelera"><i class="fa fa-circle-o text-yellow"></i> Papelera de cuentas</i></a>
                            </li>
                             <?php }?>
                          </ul>
                        </li>
                        <?php }?>
                        <!-- Fin de Bloque de Cuentassecundarias -->
                      
                     
                      
                      <!-- Inicio de Bloque -->
                    <?php 
                    /////PERMISOS////////////////
                    if (isset($_SESSION['permisos']['categorias']['acceso'])){
                    ?>
                    <li class="treeview <?php echo checarLink("n2","categorias"); ?>">
                      <a href="#">
                        <i class="fa fa-tags"></i> <span>Categorías</span>
                        <i class="fa fa-angle-left pull-right"></i>
                      </a>
                      <ul class="treeview-menu">
                        <?php 
                        /////PERMISOS////////////////
                        if (isset($_SESSION['permisos']['categorias']['guardar'])){
                        ?>
                        <li class="<?php echo checarLink("n3","nuevocategoria"); ?>">
                        <a href="../../../modulos/categorias/nuevo/nuevo.php?n1=catalogos&n2=categorias&n3=nuevocategoria"><i class="fa fa-circle-o text-green"></i> Nueva categoría</a></li>
                        <?php }?>
                        <?php 
                        /////PERMISOS////////////////
                        if (isset($_SESSION['permisos']['categorias']['consultar'])){
                        ?>
                        <li class="<?php echo checarLink("n3","consultarcategorias"); ?>">
                          <a href="../../../modulos/categorias/consultar/vista.php?n1=catalogos&n2=categorias&n3=consultarcategorias"><i class="fa fa-circle-o text-red"></i> Consultar categorías</i></a>
                        </li>
                        <?php }?>
                        <?php 
                        /////PERMISOS////////////////
                        if (isset($_SESSION['permisos']['categorias']['papelera'])){
                        ?>
                        <li class="<?php echo checarLink("n3","papeleracategorias"); ?>">
                          <a href="../../../modulos/categorias/consultar/vista.php?n1=catalogos&n2=categorias&n3=papeleracategorias&papelera"><i class="fa fa-circle-o text-yellow"></i> Papelera de categorías</i></a>
                        </li>
                         <?php }?>
                      </ul>
                    </li>
                    <?php }?>
                    
                    
                    <!-- Inicio de Bloque -->
                    <?php 
                    /////PERMISOS////////////////
                    if (isset($_SESSION['permisos']['unidades']['acceso'])){
                    ?>
                    <li class="treeview <?php echo checarLink("n2","unidades"); ?>">
                      <a href="#">
                        <i class="fa fa-tachometer"></i> <span>Unidades de medida</span>
                        <i class="fa fa-angle-left pull-right"></i>
                      </a>
                      <ul class="treeview-menu">
                        <?php 
                        /////PERMISOS////////////////
                        if (isset($_SESSION['permisos']['unidades']['guardar'])){
                        ?>
                        <li class="<?php echo checarLink("n3","nuevounidades"); ?>">
                        <a href="../../../modulos/unidades/nuevo/nuevo.php?n1=catalogos&n2=unidades&n3=nuevounidades"><i class="fa fa-circle-o text-green"></i> Nueva unidad</a></li>
                        <?php }?>
                        <?php 
                        /////PERMISOS////////////////
                        if (isset($_SESSION['permisos']['unidades']['consultar'])){
                        ?>
                        <li class="<?php echo checarLink("n3","consultarunidades"); ?>">
                          <a href="../../../modulos/unidades/consultar/vista.php?n1=catalogos&n2=unidades&n3=consultarunidades"><i class="fa fa-circle-o text-red"></i> Consultar unidades</i></a>
                        </li>
                        <?php }?>
                        <?php 
                        /////PERMISOS////////////////
                        if (isset($_SESSION['permisos']['unidades']['papelera'])){
                        ?>
                        <li class="<?php echo checarLink("n3","papeleraunidades"); ?>">
                          <a href="../../../modulos/unidades/consultar/vista.php?n1=catalogos&n2=unidades&n3=papeleraunidades&papelera"><i class="fa fa-circle-o text-yellow"></i> Papelera de unidades</i></a>
                        </li>
                         <?php }?>
                      </ul>
                    </li>
                    <?php }?>
                    
                    <!-- Inicio de Bloque -->
                    <?php 
                        /////PERMISOS////////////////
                        if (isset($_SESSION['permisos']['modelosimpuestos']['acceso'])){
                        ?>
                        <li class="<?php echo checarLink("n2","modelosimpuestos"); ?>">
                          <a href="#"><i class="fa fa-dollar"></i> Impuestos <i class="fa fa-angle-left pull-right"></i></a>
                          <ul class="treeview-menu">
                            <?php 
                            /////PERMISOS////////////////
                            if (isset($_SESSION['permisos']['modelosimpuestos']['guardar'])){
                            ?>
                            <li class="<?php echo checarLink("n3","nuevomodelosimpuestos"); ?>">
                            <a href="../../../modulos/modelosimpuestos/nuevo/nuevo.php?n1=catalogos&n2=modelosimpuestos&n3=nuevomodelosimpuestos"><i class="fa fa-circle-o text-green"></i> Agregar Impuestos</a></li>
                            </li>
                            <?php }?>
                            <?php 
                            /////PERMISOS////////////////
                            if (isset($_SESSION['permisos']['modelosimpuestos']['consultar'])){
                            ?>
                            <li class="<?php echo checarLink("n3","consultarmodelosimpuestos"); ?>">
                            <a href="../../../modulos/modelosimpuestos/consultar/vista.php?n1=catalogos&n2=modelosimpuestos&n3=consultarmodelosimpuestos"><i class="fa fa-circle-o text-red"></i> Consultar impuestos</i></a>
                            </li>
                            <?php }?>
                            <?php 
                            /////PERMISOS////////////////
                            if (isset($_SESSION['permisos']['modelosimpuestos']['papelera'])){
                            ?>
                            <li class="<?php echo checarLink("n3","papeleramodelosimpuestos"); ?>">
                            <a href="../../../modulos/modelosimpuestos/consultar/vista.php?n1=catalogos&n2=modelosimpuestos&n3=papeleramodelosimpuestos&papelera"><i class="fa fa-circle-o text-yellow"></i> Papelera de impuestos</i></a>
                            </li>
                            <?php }?>
                          </ul>
                        </li>
                        <?php }?>
                        
                        <!-- Inicio de Bloque de Archivos -->
                            <?php 
                            /////PERMISOS////////////////
                            if (isset($_SESSION['permisos']['archivos']['acceso'])){
                            ?>
                            <li class="treeview <?php echo checarLink("n2","archivos"); ?>">
                              <a href="#">
                                <i class="fa fa-folder-open" style="color:#f3d66d"></i> <span>Archivos</span>
                                <i class="fa fa-angle-left pull-right"></i>
                              </a>
                              <ul class="treeview-menu">
                                <?php 
                                /////PERMISOS////////////////
                                if (isset($_SESSION['permisos']['archivos']['guardar'])){
                                ?>
                                <li class="<?php echo checarLink("n3","nuevoarchivos"); ?>">
                                <a href="../../../modulos/archivos/nuevo/nuevo.php?n1=catalogos&n2=archivos&n3=nuevoarchivos"><i class="fa fa-circle-o text-green"></i> Nuevo archivo</a></li>
                                <?php }?>
                                
                                <?php 
                                /////PERMISOS////////////////
                                if (isset($_SESSION['permisos']['archivos']['consultar'])){
                                ?>
                                <li class="<?php echo checarLink("n3","consultararchivos"); ?>">
                                  <a href="../../../modulos/archivos/consultar/vista.php?n1=catalogos&n2=archivos&n3=consultararchivos"><i class="fa fa-circle-o text-red"></i> Consultar archivos</i></a>
                                </li>
                                 <?php }?>
                              </ul>
                            </li>
                            <?php }?>
                            <!-- Fin de Bloque de Archivos -->
                        
                    
                      
                      
                      
                       </ul><!-- fin de ul catálogos -->
                    </li> <!-- fin de li catálogos -->
                    <?php }?>
                    
                    
                    
                    
                     
                    
                    
                    
                    
                    

                    <li class="treeview <?php echo checarLink("n1","configuracion"); ?>">
                      <a href="#">
                        <i class="fa fa-cog"></i> <span>Configuración</span>
                        <i class="fa fa-angle-left pull-right"></i>
                      </a>
                      <ul class="treeview-menu">
                      
                            <!-- Inicio de Bloque de Empresa -->
							<?php 
                            /////PERMISOS////////////////
                            if (isset($_SESSION['permisos']['empresa']['acceso'])){
                            ?>
                            <li class="treeview <?php echo checarLink("n2","empresa"); ?>">
                              <a href="#">
                                <i class="fa fa-building" style="color:#414141"></i> <span>Empresa</span>
                                <i class="fa fa-angle-left pull-right"></i>
                              </a>
                              <ul class="treeview-menu">
                                <?php 
                                /////PERMISOS////////////////
                                if (isset($_SESSION['permisos']['empresa']['guardar'])){
                                ?>
                                <li class="<?php echo checarLink("n3","nuevoempresa"); ?>">
                                <a href="../../../modulos/empresa/nuevo/nuevo.php?n1=configuracion&n2=empresa&n3=nuevoempresa"><i class="fa fa-circle-o text-green"></i> Nueva empresa</a></li>
                                <?php }?>
                                
                                <?php 
                                /////PERMISOS////////////////
                                if (isset($_SESSION['permisos']['empresa']['consultar'])){
                                ?>
                                <li class="<?php echo checarLink("n3","consultarempresa"); ?>">
                                  <a href="../../../modulos/empresa/consultar/vista.php?n1=configuracion&n2=empresa&n3=consultarempresa"><i class="fa fa-circle-o text-red"></i> Consultar empresa</i></a>
                                </li>
                                 <?php }?>
                                  <?php 
                                /////PERMISOS////////////////
                                if (isset($_SESSION['permisos']['empresa']['papelera'])){
                                ?>
                                <li class="<?php echo checarLink("n3","papeleraempresa"); ?>">
                                  <a href="../../../modulos/empresa/consultar/vista.php?n1=configuracion&n2=empresa&n3=papeleraempresa&papelera"><i class="fa fa-circle-o text-yellow"></i> Papelera de empresa</i></a>
                                </li>
                                 <?php }?>
                              </ul>
                            </li>
                            <?php }?>
                            <!-- Fin de Bloque de Empresa -->
                            
                            <!-- Inicio de Bloque cuentas de usuarios-->
						<?php 
                        /////PERMISOS////////////////
                        if (isset($_SESSION['permisos']['usuarios']['acceso']) or isset($_SESSION['permisos']['perfiles']['acceso'])){
                        ?>
                        <li class="treeview <?php echo checarLink("n2","usuarios"); ?>">
                          <a href="#">
                            <i class="fa fa-users"></i> <span>Cuentas de usuarios</span>
                            <i class="fa fa-angle-left pull-right"></i>
                          </a>
                          
                          <ul class="treeview-menu">
                            <?php 
                            /////PERMISOS////////////////
                            if (isset($_SESSION['permisos']['usuarios']['acceso'])){
                            ?>
                            <li class="<?php echo checarLink("n3","usuarios"); ?>">
                              <a href="#"><i class="fa fa-child"></i> Usuarios <i class="fa fa-angle-left pull-right"></i></a>
                              <ul class="treeview-menu">
                                <?php 
                                /////PERMISOS////////////////
                                if (isset($_SESSION['permisos']['usuarios']['guardar'])){
                                ?>
                                <li class="<?php echo checarLink("n4","nuevousuario"); ?>"><a href="../../../modulos/usuarios/nuevo/nuevo.php?n1=configuracion&n2=usuarios&n3=usuarios&n4=nuevousuario"><i class="fa fa-circle-o text-green"></i> Nuevo usuario</a></li>
                                <?php }?>
                                <?php 
                                /////PERMISOS////////////////
                                if (isset($_SESSION['permisos']['usuarios']['consultar'])){
                                ?>
                                <li class="<?php echo checarLink("n4","consultarusuarios"); ?>"><a href="../../../modulos/usuarios/consultar/vista.php?n1=configuracion&n2=usuarios&n3=usuarios&n4=consultarusuarios"><i class="fa fa-circle-o text-red"></i> Consultar usuarios</a></li>
                                <?php }?>
                              </ul>
                            </li>
                            <?php }?>
                            <?php 
                            /////PERMISOS////////////////
                            if (isset($_SESSION['permisos']['perfiles']['acceso'])){
                            ?>
                            <li class="<?php echo checarLink("n3","perfiles"); ?>">
                              <a href="#"><i class="fa fa-key"></i> Perfiles <i class="fa fa-angle-left pull-right"></i></a>
                              <ul class="treeview-menu">
                                <?php 
                                /////PERMISOS////////////////
                                if (isset($_SESSION['permisos']['perfiles']['guardar'])){
                                ?>
                                <li class="<?php echo checarLink("n4","nuevoperfil"); ?>"><a href="../../../modulos/perfiles/nuevo/nuevo.php?n1=configuracion&n2=usuarios&n3=perfiles&n4=nuevoperfil"><i class="fa fa-circle-o text-green"></i> Nuevo perfil</a></li>
                                <?php }?>
                                <?php 
                                /////PERMISOS////////////////
                                if (isset($_SESSION['permisos']['perfiles']['consultar'])){
                                ?>
                                <li class="<?php echo checarLink("n4","consultarperfiles"); ?>"><a href="../../../modulos/perfiles/consultar/vista.php?n1=configuracion&n2=usuarios&n3=perfiles&n4=consultarperfiles"><i class="fa fa-circle-o text-red"></i> Consultar perfiles</a></li>
                                <?php }?>
                              </ul>
                            </li>
                            <?php }?>
                          </ul>
                        </li>
                        <?php }?>
                      <!-- fin de cuentas de usuario -->
                            
                             <!-- Inicio de Bloque de Cuentascorreo -->
							<?php 
                            /////PERMISOS////////////////
                            if (isset($_SESSION['permisos']['cuentascorreo']['acceso'])){
                            ?>
                            <li class="treeview <?php echo checarLink("n2","cuentascorreo"); ?>">
                              <a href="#">
                                <i class="fa fa-envelope-square" style="color:#243aa4"></i> <span>Cuentas de correo</span>
                                <i class="fa fa-angle-left pull-right"></i>
                              </a>
                              <ul class="treeview-menu">
                                <?php 
                                /////PERMISOS////////////////
                                if (isset($_SESSION['permisos']['cuentascorreo']['guardar'])){
                                ?>
                                <li class="<?php echo checarLink("n3","nuevocuentascorreo"); ?>">
                                <a href="../../../modulos/cuentascorreo/nuevo/nuevo.php?n1=configuracion&n2=cuentascorreo&n3=nuevocuentascorreo"><i class="fa fa-circle-o text-green"></i> Nueva cuenta</a></li>
                                <?php }?>
                                
                                <?php 
                                /////PERMISOS////////////////
                                if (isset($_SESSION['permisos']['cuentascorreo']['consultar'])){
                                ?>
                                <li class="<?php echo checarLink("n3","consultarcuentascorreo"); ?>">
                                  <a href="../../../modulos/cuentascorreo/consultar/vista.php?n1=configuracion&n2=cuentascorreo&n3=consultarcuentascorreo"><i class="fa fa-circle-o text-red"></i> Consultar cuentas</i></a>
                                </li>
                                 <?php }?>
                                  <?php 
                                /////PERMISOS////////////////
                                if (isset($_SESSION['permisos']['cuentascorreo']['papelera'])){
                                ?>
                                <li class="<?php echo checarLink("n3","papeleracuentascorreo"); ?>">
                                  <a href="../../../modulos/cuentascorreo/consultar/vista.php?n1=configuracion&n2=cuentascorreo&n3=papeleracuentascorreo&papelera"><i class="fa fa-circle-o text-yellow"></i> Papelera de cuentas</i></a>
                                </li>
                                 <?php }?>
                              </ul>
                            </li>
                            <?php }?>
                            <!-- Fin de Bloque de Cuentascorreo -->
                
                           
                                <!-- Inicio de Bloque -->
                                <?php 
                                /////PERMISOS////////////////
                                if (isset($_SESSION['permisos']['plantillasmensajes']['acceso'])){
                                ?>
                                <li class="<?php echo checarLink("n2","plantillasmensajes"); ?>">
                                  <a href="#"><i class="fa fa-newspaper-o"></i> Plantillas de correo <i class="fa fa-angle-left pull-right"></i></a>
                                  <ul class="treeview-menu">
                                    <?php 
                                    /////PERMISOS////////////////
                                    if (isset($_SESSION['permisos']['plantillasmensajes']['guardar'])){
                                    ?>
                                    <li class="<?php echo checarLink("n3","nuevoplantillasmensajes"); ?>">
                                    <a href="../../../modulos/plantillasmensajes/nuevo/nuevo.php?n1=configuracion&n2=plantillasmensajes&n3=nuevoplantillasmensajes"><i class="fa fa-circle-o text-green"></i> Nueva plantilla</a></li>
                                    </li>
                                    <?php }?>
                                    <?php 
                                    /////PERMISOS////////////////
                                    if (isset($_SESSION['permisos']['plantillasmensajes']['consultar'])){
                                    ?>
                                    <li class="<?php echo checarLink("n3","consultarplantillasmensajes"); ?>">
                                    <a href="../../../modulos/plantillasmensajes/consultar/vista.php?n1=configuracion&n2=plantillasmensajes&n3=consultarplantillasmensajes"><i class="fa fa-circle-o text-red"></i> Ver plantillas</i></a>
                                    </li>
                                    <?php }?>
                                    
                                  </ul>
                                </li>
                                <?php }?>
                    
                    
                    <!-- Inicio de Bloque -->
                    <?php 
                    /////PERMISOS////////////////
                    if (isset($_SESSION['permisos']['reportes']['acceso'])){
                    ?>
                    <li class="treeview <?php echo checarLink("n1","reportes"); ?>">
                      <a href="#">
                        <i class="fa fa-files-o" style="color:#5095AB"></i> <span>Reportes</span>
                        <i class="fa fa-angle-left pull-right"></i>
                      </a>
                      <ul class="treeview-menu">
                        
                        <?php 
                        /////PERMISOS////////////////
                        if (isset($_SESSION['permisos']['bitacoracontrol']['acceso'])){
                        ?>
                        <li class="<?php echo checarLink("n2","bitacoras"); ?>">
                        <a href="../../../modulos/reportes/bitacoras/vista.php?n1=reportes&n2=bitacoras"><i class="fa fa-history text-red"></i> Bitácora</a></li>
                        </i>
                        <?php }?>
                      </ul>
                    </li>
                    <?php }?>
                    
                    
                    
                    <!-- Inicio de Bloque -->
                    <?php 
                    /////PERMISOS////////////////
                    if (isset($_SESSION['permisos']['configuracion']['acceso'])){
                    ?>
                    <li class="treeview <?php echo checarLink("n1","configuracion"); ?>">
                      <a href="#">
                        <i class="fa fa-gear"></i> <span>Ajustes</span>
                        <i class="fa fa-angle-left pull-right"></i>
                      </a>
                      <ul class="treeview-menu">
                        <?php 
                        /////PERMISOS////////////////
                        if (isset($_SESSION['permisos']['configuracion']['modificar'])){
                        ?>
                        <li class="<?php echo checarLink("n2","configuracion"); ?>">
                            <a href="../../../modulos/configuracion/modificar/actualizar.php?n1=configuracion&n2=configuracion"><i class="fa fa-wrench text-yellow"></i> <span>Configuración</span></a>
                        </i>
                        <?php 
                        }?>
                        
                        <?php 
                        /////PERMISOS////////////////
                        if (isset($_SESSION['permisos']['configuracion']['sincronizar'])){
                        ?>
                        <li class="<?php echo checarLink("n2","sincronizar"); ?>">
                            <a href="../../../modulos/configuracion/copiaseguridad/sincronizar.php?n1=configuracion&n2=sincronizar"><i class="fa fa-refresh text-green"></i> <span>Respaldar</span></a>
                        </i>
                        <?php 
                        }?>
                        
                      </ul>
                    </li>
                    <?php }?>
                        
                      </ul><!-- fin de ul Configuración -->
                    </li> <!-- fin de li Configuración-->
                    
                    
                      <!-- Inicio de Bloque Ayuda -->
					<?php 
                    /////PERMISOS////////////////
                    if (isset($_SESSION['permisos']['clientes']['acceso']) or isset($_SESSION['permisos']['domicilios']['acceso']) or isset($_SESSION['permisos']['datosfiscales']['acceso'])){
                    ?>
                     <li class="treeview <?php echo checarLink("n1","ayuda"); ?>">
                      <a href="#">
                        <i class="fa fa-life-ring"></i> <span>Ayuda</span>
                        <i class="fa fa-angle-left pull-right"></i>
                      </a>
                      <ul class="treeview-menu">
                      
                      
                     </ul><!-- fin de ul ayuda -->
                    </li> <!-- fin de li ayua -->
                    <?php }?>
            
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- =============================================== -->