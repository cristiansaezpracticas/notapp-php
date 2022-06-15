<?php

ob_start();

$pagina = "Listado de Usuarios";

?>

    <?php MensajesFlash::imprimir_mensajes(); ?> 

	<article>
		<table class="table">
			<thead>
				<tr>
					<th scope="col">Id</th>
					<th scope="col">Nombre</th>
					<th scope="col">Email</th>
					<th scope="col">Rol</th>
					<th scope="col">Editar</th>
					<th scope="col">Borrar</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($usuarios as $usuario) { ?>
					<tr>
						<th scope="row"><?= $usuario->getId() ?></th>
						<td><?= $usuario->getNombre() ?></td>
						<td><?= $usuario->getEmail() ?></td>
						<td><?= $usuario->getRol() ?></td>
						<td>
							<a href="/editar_usuario/<?= $usuario->getId() ?>"><i class="fa-solid fa-pen"></i></a>
						</td>
						<td>
							<a href="/borrar_usuario/<?= $usuario->getId() ?>/<?= $_SESSION['token'] ?>"><i class="fa-solid fa-trash"></i></a>
						</td>
					</tr>
				<?php } ?>

			</tbody>
		</table>
	</article>
	
<?php
$contenido = ob_get_clean();

require 'template.php';
?>