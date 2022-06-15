<?php
	ob_start();

    $pagina= "Inicio";
?>
    <?php MensajesFlash::imprimir_mensajes(); ?>



    <div class="display-1 urbanist-extrabold responsive-display-1">
		<span>nuevo</span><br>
		<span>post?</span><br>
	</div>

    <img src="../web/images/keep.png" style="float: right;width: 30%;margin-top: 250px;">

 <?php
 $contenido = ob_get_clean();
 
 require 'template.php';
 ?>