<?php

/*
 * Controlador Frontal
 */

session_start();

//Requires Modelos
require '../app/modelos/ConexionBD.php';
require '../app/modelos/Nota.php';
require '../app/modelos/NotaDAO.php';
require '../app/modelos/MensajesFlash.php';
require '../app/modelos/Sesion.php';
require '../app/modelos/Usuario.php';
require '../app/modelos/UsuarioDAO.php';

//Requires Controladores
require '../app/controladores/ControladorNota.php';
require '../app/controladores/ControladorUsuario.php';

//Enrutamiento
$mapa = array(
    'inicio' => array('controlador' => 'ControladorNota', 'metodo' => 'listar', 'publica' => true),
    'borrar_nota' => array('controlador' => 'ControladorNota', 'metodo' => 'borrar', 'publica' => false),
    'insertar_nota' => array('controlador' => 'ControladorNota', 'metodo' => 'insertar', 'publica' => false),
	'editar_nota' => array('controlador' => 'ControladorNota', 'metodo' => 'editar', 'publica' => false),
    'ver_nota' => array('controlador' => 'ControladorNota', 'metodo' => 'ver', 'publica' => true),
    'registrar' => array('controlador' => 'ControladorUsuario', 'metodo' => 'registrar', 'publica' => true),
	'conectarse' => array('controlador' => 'ControladorUsuario', 'metodo' => 'conectarse', 'publica' => true),
    'subir_foto' => array('controlador' => 'ControladorUsuario', 'metodo' => 'subir_foto', 'publica' => false),
    'login' => array('controlador' => 'ControladorUsuario', 'metodo' => 'login', 'publica' => true),
    'logout' => array('controlador' => 'ControladorUsuario', 'metodo' => 'logout', 'publica' => false),
    'existe_email' => array('controlador' => 'ControladorUsuario', 'metodo' => 'existe_email', 'publica' => true),
    'mis_notas' => array('controlador' => 'ControladorNota', 'metodo' => 'mis_notas', 'publica' => false),
	'perfil' => array('controlador' => 'ControladorNota', 'metodo' => 'perfil', 'publica' => false),
);

//Parseo de la ruta
if (!empty($_GET['accion'])) {
    if (isset($mapa[$_GET['accion']])) {  //Si existe en el mapa
        $accion = $_GET['accion'];
    } else { //Si no existe en el mapa
        MensajesFlash::anadir_mensaje("La página que buscas no existe.");
        header("Location: inicio");
        die();
    }
} else {    //Si no me pasan parámetro acción, cargo la acción por defecto
    $accion = "inicio";
}

//Si tiene cookie y no ha iniciado sesión, iniciamos sesión automáticamente
if (isset($_COOKIE['uid']) && Sesion::existe() == false) { //Si existe la cookie lo identificamos
    $uid = filter_var($_COOKIE['uid'], FILTER_SANITIZE_SPECIAL_CHARS);
    $usuarioDAO = new UsuarioDAO(ConexionBD::conectar());
    $usuario = $usuarioDAO->findByCookie_id($uid);
    if ($usuario != false) {   //Si existe un usuario con la cookie iniciamos sesión
        Sesion::iniciar($usuario);
    }
}

//Si va a acceder a una página que no es pública y no está identificado lo echamos a index
if ($mapa[$accion]['publica'] == false) { //Debe tener la sesión iniciada
    if (!Sesion::existe()) {
        MensajesFlash::anadir_mensaje("Debes iniciar sesión para acceder a esta página");
        header('Location: inicio');
        die();
    }
}

//Ejecución del controlador
$controlador = $mapa[$accion]['controlador'];
$metodo = $mapa[$accion]['metodo'];

$controlador = new $controlador();
$controlador->$metodo();