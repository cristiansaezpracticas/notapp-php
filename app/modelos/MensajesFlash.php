<?php

/**
 * Description of MensajesFlash
 *
 * @author Cristian
 */
 
class MensajesFlash {

    static public function anadir_mensaje($mensaje) {
		
        $_SESSION['mensajes_flash'][] = $mensaje;
		
    }

    static public function imprimir_mensajes() {
		
        if(isset($_SESSION['mensajes_flash'])) {
			
            foreach($_SESSION['mensajes_flash'] as $mensaje_flash){
                print '<div class="mensaje">' . $mensaje_flash . '</div>';
            }
			
            unset($_SESSION['mensajes_flash']);
        }
		
    }

}