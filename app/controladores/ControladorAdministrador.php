<?php

/**
 * Description of ControladorAdministrador
 *
 * @author Cristian
 */

class ControladorAdministrador {

    public function panel() {
		
        $usuario = Sesion::obtener();
        $conn = ConexionBD::conectar();

        //Generamos Token para seguridad del borrado
        $_SESSION['token'] = md5(time() + rand(0, 999));
        $token = $_SESSION['token'];

        if ($usuario->getRol() == 'Administrador') {

            $usuarioDAO = new UsuarioDAO($conn);
            $usuarios = $usuarioDAO->findAll();

            require '../app/vistas/panel.php';
			
        } else {

            MensajesFlash::anadir_mensaje("Debes de iniciar sesión como Administrador.");
            require '../app/vistas/mis_notas.php';
            die();
        }
		
    }

    public function listado_usuarios() {
		
        $usuario = Sesion::obtener();
        $conn = ConexionBD::conectar();

        //Generamos Token para seguridad del borrado
        $_SESSION['token'] = md5(time() + rand(0, 999));
        $token = $_SESSION['token'];

        if ($usuario->getRol() == 'Administrador') {

            $usuarioDAO = new UsuarioDAO($conn);
            $usuarios = $usuarioDAO->findAll();

            require '../app/vistas/listado_usuarios.php';
        } else {

            MensajesFlash::anadir_mensaje("Debes de iniciar sesión como Administrador.");

            require '../app/vistas/mis_notas.php';

            die();
        }
    }
	
	public function editar_usuario() {
		
       if (Sesion::existe() == false || Sesion::obtener()->getRol() != "Administrador") {
        header("Location: /");
            MensajesFlash::anadir_mensaje("Debes de iniciar sesión como Administrador.");
            die();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            /*             * ******************************************* */
            /*             * ***   EDITAMOS EL USUARIO EN LA BBDD   **** */
            /*             * ******************************************* */
            $conn = ConexionBD::conectar();
            //Editamos el usuario en la BBDD
			$id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
            $usuarioDAO = new UsuarioDAO($conn);
			$usuario = $usuarioDAO->find($id);

            //Filtramos datos de entrada
            $nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_var($_POST['email'], FILTER_SANITIZE_SPECIAL_CHARS);

            $usuario->setNombre($nombre);
            $usuario->setEmail($email);

            $usuarioDAO->update($usuario);

            MensajesFlash::anadir_mensaje("Se ha editado el usuario");
			header("Location: /listado_usuarios");
			
            die();
        } else {
			$id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
			
			$conn = ConexionBD::conectar();
			
			$usuarioDAO = new UsuarioDAO($conn);
			$usuario = $usuarioDAO->find($id);
		}
        
        require '../app/vistas/editar_usuarios.php';
    }

    public function borrar_usuario() {

        if ($_GET['t'] != $_SESSION['token']) {
            header("Location: " . RUTA . "listado_usuarios");
            MensajesFlash::anadir_mensaje("El token no es correcto");
            die();
        }

        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        $usuarioDAO = new UsuarioDAO(ConexionBD::conectar());
        $usuario = $usuarioDAO->find($id);

        if ($usuarioDAO->delete($usuario)) {
            MensajesFlash::anadir_mensaje("Usuario borrado");
        } else {
            MensajesFlash::anadir_mensaje("Usuario no encontrado");
        }

        header("Location: /listado_usuarios");
		
    }

}