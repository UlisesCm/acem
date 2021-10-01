<?php
		function botonActivo($link){ 
				if (isset($_GET["link"])==true){
					if($_GET["link"]==$link){
						echo ' id="activo"';
					}
				}
	} 
	?>
    <nav style="padding-left:0; margin-left:0px;">
    	<div style="width:200px; height:80px;"></div>
		<ul>
			<li>
				<a href="../../inicio/inicio/inicio.php" <?php botonActivo("regresar");?>>
				<div id="iconoMenu"><img src="../../../css/imagenes/home.png"/></div>
				<div id="labelMenu">Regresar</div>
				</a>
			</li>
			
			<li>
				<div class="tituloMenu">
					<div id="labelMenu">retiros</div>
				</div>
			</li>
			<?php
			/////PERMISOS////////////////
			if (isset($_SESSION['permisos']['retiros']['guardar'])){
			?>
			<li>
				<a href="../nuevo/nuevo.php?link=nuevo" <?php botonActivo("nuevo");?>>
				<div id="iconoMenu"><img src="../../../css/imagenes/add.png"/></div>
				<div id="labelMenu">Nuevo retiro</div>
				</a>
			</li>
			<?php }?>
			
			<?php
			/////PERMISOS////////////////
			if (isset($_SESSION['permisos']['retiros']['consultar'])){
			?>
			<li>
				<a href="../consultar/vista.php?link=vista" <?php botonActivo("vista");?>>
				<div id="iconoMenu"><img src="../../../css/imagenes/consultar.png"/></div>
				<div id="labelMenu">Consultar retiros</div>
				</a>
			</li>
			<?php }?>
			<?php
			/////PERMISOS////////////////
			if (isset($_SESSION['permisos']['retiros']['papelera'])){
			?>
			<li>
				<a href="../consultar/vista.php?link=papelera&papelera" <?php botonActivo("papelera");?>>
				<div id="iconoMenu"><img src="../../../css/imagenes/papelera.png"/></div>
				<div id="labelMenu">Papelera de retiros</div>
				</a>
			</li>
			<?php }?>
			
		</ul>
	</nav>
	