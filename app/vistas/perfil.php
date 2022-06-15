<?php
ob_start();

$pagina= "Perfil";
?>
    
	<?php MensajesFlash::imprimir_mensajes(); ?>
       
	<div class="texto">
	
		<center><div id="foto_usuario_perfil"	style="background-image: url(/web/images/perfil/<?= Sesion::obtener()->getFoto() ?>)"></div></center><br><br>
		
		<h2>Hola, <?= Sesion::obtener()->getNombre() ?></h2><br><br>
			
		<h2>Correo: <?= Sesion::obtener()->getEmail() ?></h2><br><br>
		
		<a href="/logout"><div class="salir">DESCONECTARME</div></a>
	
	</div>
	
 <?php
 $contenido = ob_get_clean();
 
 require 'template.php';
 ?>