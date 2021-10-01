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
					<div id="labelMenu">archivos</div>
				</div>
			</li>
			<?php
			/////PERMISOS////////////////
			if (isset($_SESSION['permisos']['archivos']['guardar'])){
			?>
			<li>
				<a href="../nuevo/nuevo.php?link=nuevo" <?php botonActivo("nuevo");?>>
				<div id="iconoMenu"><img src="../../../css/imagenes/add.png"/></div>
				<div id="labelMenu">Nuevo archivo</div>
				</a>
			</li>
			<?php }?>
			
			<?php
			/////PERMISOS////////////////
			if (isset($_SESSION['permisos']['archivos']['consultar'])){
			?>
			<li>
				<a href="../consultar/vista.php?link=vista" <?php botonActivo("vista");?>>
				<div id="iconoMenu"><img src="../../../css/imagenes/consultar.png"/></div>
				<div id="labelMenu">Consultar archivos</div>
				</a>
			</li>
			<?php }?>
			
		</ul>
	</nav>
	