<?php 

ob_start();

$pagina= "Conectarse";

?>

	<?php MensajesFlash::imprimir_mensajes() ?>
	
	<form id="login" action="login" method="post">
		<input type="email" placeholder="Email" name="email">
        <input type="password" placeholder="Contraseña" name="password">
		<input style="background-color: #2ecc71;" type="submit" value="Conectarse">
		<input style="background-color: #e74c3c;" type="button" value="Volver" onclick="location.href = 'inicio'">
	</form>

<?php
$contenido = ob_get_clean();
require 'template.php';
?>
