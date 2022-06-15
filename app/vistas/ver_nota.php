<?php ob_start();
$pagina = $nota->getTitulo();
?>
<?php MensajesFlash::imprimir_mensajes(); ?>
				<article>
				<h2 class="titulo"><?= $nota->getTitulo() ?></h2>
				<p><?= $nota->getDescripcion() ?></p>	    
			
				<?php if (Sesion::existe() && $nota->getUsuario()->getId() == (Sesion::obtener())->getId()): ?>
				
						<div class="fecha_articulo">
							<p class="fecha" style="float:left;"><?= $nota->getFecha() ?></p>
						</div>
						
						<div class="editar_articulo" style="float:right;">
							<a href="/editar_nota/<?= $nota->getId() ?>">
								<i class="fa-solid fa-pen" style="margin-right: 10px;color: black;"></i>
							</a>
							<a href="/borrar_nota/<?= $nota->getId() ?>/<?= $_SESSION['token'] ?>">
								<i class="fa-solid fa-trash" style="margin-right: 10px;color: black;"></i>
							</a>
						</div>
                <?php endif; ?>
			</article>

<?php
$contenido = ob_get_clean();
require 'template.php';
?>


