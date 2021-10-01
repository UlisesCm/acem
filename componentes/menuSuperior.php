	  <header class="main-header">
        <!-- Logo -->
        <a href="#" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><img src="../../../dist/img/logominicompac.png"/></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg">
          <img src="../../../dist/img/logomini.png"/>
          </span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Navegación</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="../../../empresas/<?php echo $_SESSION["empresa"];?>/archivosSubidos/usuarios/<?php echo $_SESSION["foto"];?>" class="user-image" alt="User Image"/>
                  <span class="hidden-xs"><?php echo $_SESSION["nombreusuario"];?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="../../../empresas/<?php echo $_SESSION["empresa"];?>/archivosSubidos/usuarios/<?php echo $_SESSION["foto"];?>" class="img-circle" alt="User Image" />
                    <p>
                      <?php echo "Bienvenido ". $_SESSION["usuario"];?>
                      <small>Miembro del perf&iacute;l de <?php echo $_SESSION["nombreperfil"];?></small>
                    </p>
                  </li>
                  <!-- Menu Body -->
                  
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                    	<form action="../../usuarios/modificarindividual/actualizar.php?n1=usuarios&n2=consultarusuarios" method="post">
                			<input type="hidden" name="id" value="<?php echo $_SESSION['idusuario'] ?>"/>
                            <button type="submit" class="btn btn-default btn-flat" value="" title="Perfil"><i class="fa fa-pencil"></i> &nbsp;Editar perfil</button>
                		</form>
                    </div>
                    <div class="pull-right">
                      <a href="../../seguridad/cerrarSesion.php" class="btn btn-default btn-flat"><i class="fa fa-sign-out"></i> &nbsp;Cerrar Sesi&oacute;n</a>
                    </div>
                  </li>
                </ul>
              </li>
              
            </ul>
          </div>
        </nav>
      </header>
