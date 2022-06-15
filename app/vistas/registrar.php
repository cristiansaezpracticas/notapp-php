<?php 

ob_start();

$pagina= "Registrate";

?>

	<?php MensajesFlash::imprimir_mensajes() ?>

	<form action="" method="post" enctype="multipart/form-data">
		<input type="hidden" name="token" value="<?= $token ?>">
		<input type="text" name="nombre" placeholder="Nombre">
		<input type="email" name="email" placeholder="Email" id="email"><img src="../web/images/iconos/preloader.gif" id="preloader">
		<input type="password" name="password" placeholder="Contraseña">
		<input type="file" name="foto" accept="image/*">
		<input style="background-color: #2ecc71;" type="submit" value="Registrarse" id="boton_registrar">
		<input style="background-color: #e74c3c;" type="button" value="Volver" onclick="location.href = 'inicio'">
	</form>
<style>
#email {
	display: block:
}
</style>
	<script>
	$(document).ready(function () {
		$('#email').blur(function () {
			if ($('#email').val() != "") {
				$.ajax({
					url: "existe_email",
					method: "POST",
					data: {email: $('#email').val()},
					success: function (data) {
						if (data.respuesta) {
							$('#boton_registrar').attr("disabled", "disabled");
							$("#preloader").css('display', 'none');
							bootbox.alert("Ya estás registrado con ese email. Inicia sesión.");
						} else {
							$('#boton_registrar').removeAttr("disabled");
						}
					},
					dataType: "json",
					beforeSend: function () {
						$("#preloader").css('display', 'inline');
					},
					complete: function () {
						$("#preloader").css('display', 'none');
					}
				}); //$.ajax
			}   //If
		}); //blur
	});
	</script>
			
<?php
$contenido = ob_get_clean();
require 'template.php';
?>
