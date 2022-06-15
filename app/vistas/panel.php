<?php

ob_start();

$pagina = "Panel";

?>

	<?php MensajesFlash::imprimir_mensajes(); ?>

	<div class="wrapper" id="wrapper" style="grid-template-columns: 1fr 0fr !important;">
		<a href="/listado_usuarios">
			<div class="col" style="width: 100%;">
				<p style="float: left;margin-top: 20px;margin-right: 40px;"><i class="fa-solid fa-users fa-3x"></i></p>
				<h2 class="titulo">Administración de Usuarios</h2>	
				<p>Podrás editar y eliminar usuarios.</p>
			</div>
		</a>			
	</div>

<?php
$contenido = ob_get_clean();

require 'template.php';
?>