<?php
ob_start();
$pagina = "Mis Notas";
?>
    <?php MensajesFlash::imprimir_mensajes(); ?>
           	
	<div class="container">
	
		<div class="buttons">
			<div id="search" style="float: left;"><i class="fa-solid fa-magnifying-glass"></i></div>
			<div class="list" style="float: right;"><i class="fa fa-list"></i></div>
			<div class="grid" style="float: right;"><i class="fa fa-th-large"></i></div>
		</div>
 
		<input type="text" name="buscador" id="buscador" placeholder="Buscar...">
		
		<div class="wrapper" id="wrapper">
				
			<?php foreach ($mis_notas as $n): ?>
			
				<a href="/ver_nota/<?= $n->getId() ?>">
					<div class="col">
						<h2 class="titulo"><?= $n->getTitulo() ?></h2>	
						<p><?= substr($n->getDescripcion(), 0, 20) . "..." ?></p>
					</div>
				</a>
			
			<?php endforeach; ?>
				
		</div>
		
	</div>

 <?php
 $contenido = ob_get_clean();
 
 require 'template.php';
 ?>