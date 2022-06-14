<?php

/**
 * Description of ControladorUsuario
 *
 * @author Cristian
 */
 
class ControladorUsuario {

    public function existe_email() {
        $email=filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
        $usuDAO = new UsuarioDAO(ConexionBD::conectar());
        if($usuDAO->findByEmail($email)){
            header('Content-type: application/json');
            print json_encode(array("respuesta"=>true));
        }else{
            header('Content-type: application/json');
            print json_encode(array("respuesta"=>false));
        }
    }

    public function registrar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //Comprobamos el token
            if ($_POST['token'] != $_SESSION['token']) {
                header("Location: /");
                MensajesFlash::anadir_mensaje("Token incorrecto");
                die();
            }

            $usuario = new Usuario();
            $error = false;
            if (empty($_POST['email'])) {
                MensajesFlash::anadir_mensaje("El email es obligatorio.");
                $error = true;
            }
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                MensajesFlash::anadir_mensaje("El email no es correcto.");
                $error = true;
            }
            if (empty($_POST['password'])) {
                MensajesFlash::anadir_mensaje("El password es obligatorio.");
                $error = true;
            }
            //Validación foto
            if ($_FILES['foto']['type'] != 'image/png' &&
                    $_FILES['foto']['type'] != 'image/gif' &&
                    $_FILES['foto']['type'] != 'image/jpg' &&
                    $_FILES['foto']['type'] != 'image/jpeg') {
                MensajesFlash::anadir_mensaje("El archivo seleccionado no es una foto.");
                $error = true;
            }
            if ($_FILES['foto']['size'] > 1000000) {
                MensajesFlash::anadir_mensaje("El archivo seleccionado es demasiado grande. Debe tener un tamaño inferior a 1MB");
                $error = true;
            }

            if (!$error) {
                //Copiar foto
                //Generamos un nombre para la foto
                $nombre_foto = md5(time() + rand(0, 999999));
                $extension_foto = substr($_FILES['foto']['name'], strrpos($_FILES['foto']['name'], '.') + 1);
                $extension_foto = filter_var($extension_foto, FILTER_SANITIZE_SPECIAL_CHARS);
                //Comprobamos que no exista ya una foto con el mismo nombre, si existe calculamos uno nuevo
                while (file_exists("images/perfil/$nombre_foto.$extension_foto")) {
                    $nombre_foto = md5(time() + rand(0, 999999));
                }
                //movemos la foto a la carpeta que queramos guardarla y con el nombre original
                move_uploaded_file($_FILES['foto']['tmp_name'], "images/perfil/$nombre_foto.$extension_foto");

                //Limpiamos los datos de entrada 
                $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
                $nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_SPECIAL_CHARS);
                //Insertamos el usuario en la BBDD
                $usuario->setEmail($email);
                $usuario->setNombre($nombre);
                $usuario->setPassword(password_hash($_POST['password'], PASSWORD_DEFAULT));
                $usuario->setFoto("$nombre_foto.$extension_foto");

                $usuDAO = new UsuarioDAO(ConexionBD::conectar());
                $usuDAO->insert($usuario);
                MensajesFlash::anadir_mensaje("Usuario creado.");
                header("Location: /conectarse");
                die();
            }
        }

        //Calculamos un token
        $token = md5(time() + rand(0, 999));
        $_SESSION['token'] = $token;

        require '../app/vistas/registrar.php';
    }
	
	public function conectarse() {

        require '../app/vistas/conectarse.php';

    }

    public function subir_foto() {
        if (($_FILES['foto']['type'] != 'image/png' &&
                $_FILES['foto']['type'] != 'image/gif' &&
                $_FILES['foto']['type'] != 'image/jpg' &&
                $_FILES['foto']['type'] != 'image/jpeg')) {
            MensajesFlash::anadir_mensaje('La imagen no tiene el formato adecuado');
            header("Location: /perfil");
            die();
        }
        //Generamos un nombre para la foto
        $nombre_foto = md5(time() + rand(0, 999999));
        $extension_foto = substr($_FILES['foto']['name'], strrpos($_FILES['foto']['name'], '.') + 1);
        //Comprobamos que no exista ya una foto con el mismo nombre, si existe calculamos uno nuevo
        while (file_exists("images/$nombre_foto.$extension_foto")) {
            $nombre_foto = md5(time() + rand(0, 999999));
        }
        //movemos la foto a la carpeta que queramos guardarla y con el nombre original
        move_uploaded_file($_FILES['foto']['tmp_name'], "images/$nombre_foto.$extension_foto");
        //Actualizamos en la BD
        $conn = ConexionBD::conectar();
        $usuarioDAO = new UsuarioDAO($conn);
        $usuario = $usuarioDAO->find(Sesion::obtener()->getId());
        $usuario->setFoto("$nombre_foto.$extension_foto");
        $usuarioDAO->update($usuario);

        //Para que recarge en la sesión la nueva foto
        Sesion::iniciar($usuario);

        header("Location: /");
    }

    public function login() {
        //Obtendo el usuario, si no existe vuelvo a index con un parámetro de error
        $usuDAO = new UsuarioDAO(ConexionBD::conectar());
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        if (!$usuario = $usuDAO->findByEmail($email)) {
            //Usuario no encontrado
            MensajesFlash::anadir_mensaje("Usuario o password incorrectos.");
            header("Location: /conectarse");
            die();
        }
        //Compruebo la contraseña, si no existe vuelvo a index con un parámetro de error
        if (!password_verify($_POST['password'], $usuario->getPassword())) {
            //password incorrecto
            MensajesFlash::anadir_mensaje("Usuario o password incorrectos.");
            header("Location: /conectarse");
            die();
        }
        //Usuario y password correctos, redirijo al listado de anuncios
        Sesion::iniciar($usuario);

        //Generamos un código aleatorio sha1 y lo guardamos en la BD
        $usuario->setCookie_id(sha1(time() + rand()));
        $usuDAO->update($usuario);
        //Creamos la cookie en el navegador del cliente con el mismo código generado
        setcookie('uid', $usuario->getCookie_id(), time() + 60 * 60 * 24 * 7);

        header("Location: /mis_notas");
        die();
    }

    public function logout() {
        Sesion::cerrar();
        //Borramos la cookie diciendole al navegador que está caducada
        setcookie('uid', '', time() - 5);
        header("Location: /");
    }

}
