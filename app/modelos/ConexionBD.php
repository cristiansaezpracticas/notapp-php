<?php

/**
 * Description of ConexionBD
 *
 * @author Cristian
 */
 
class ConexionBD {
	
    public static function conectar(): mysqli{
		
        $conn = new mysqli('localhost','root','','notas');

        if($conn->connect_error){
            die("Error al conectar con MySQL: " . $conn->error);
        }
		
        return $conn;
		
    }
	
}