<?php

/**
 * Description of ControladorNota
 *
 * @author Cristian
 */

class ControladorNota {

    public function listar() {

		if (Sesion::existe() == false) {
            //Generamos Token para seguridad del borrado
			$_SESSION['token'] = md5(time() + rand(0, 999));
			$token = $_SESSION['token'];

			require '../app/vistas/inicio.php';
        } else {
			header("Location: /mis_notas");
		}

    }

    function borrar() {
		
        //Comprobamos que el token recibido es igual al que tenemos en la variable de sesión para evitar ataques CSRF
        if ($_GET['t'] != $_SESSION['token']) {
            header("Location: /");
            MensajesFlash::anadir_mensaje("El token no es correcto");
            die();
        }

        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        $notaDAO = new NotaDAO(ConexionBD::conectar());
        $nota = $notaDAO->find($id);
        //Comprobamos el el usuario es propietario del artículo
        if ($nota->getId_usuario() == Sesion::obtener()->getId()) {
            if ($notaDAO->delete($nota)) {
                MensajesFlash::anadir_mensaje("Nota borrada");
            } else {
                MensajesFlash::anadir_mensaje("Nota no encontrada");
            }
        } else {
            MensajesFlash::anadir_mensaje("¡La nota no es tuya!");
        }
        header("Location: /mis_notas");
		
    }

    function insertar() {
		
        if (Sesion::existe() == false) {
            header("Location: /mis_notas");
            MensajesFlash::anadir_mensaje("No puedes añadir mensajes si no inicias sesión");
            die();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            /*             * ***************************************** */
            /*             * *** GUARDAMOS EL ARTÍCULO EN LA BBDD **** */
            /*             * ***************************************** */
            $conn = ConexionBD::conectar();
            //Insertamos el artículo en la BBDD
            $notaDAO = new NotaDAO($conn);
            $nota = new Nota();

            //Filtramos datos de entrada
			$descripcion = $_POST['descripcion'];
            $titulo = filter_var($_POST['titulo'], FILTER_SANITIZE_SPECIAL_CHARS);

            $nota->setDescripcion($descripcion);
            $nota->setTitulo($titulo);
            $nota->setId_usuario(Sesion::obtener()->getId());

            $notaDAO->insert($nota);

            MensajesFlash::anadir_mensaje("Se ha insertado la nota");
            header("Location: /mis_notas");
            die();
        }

        require '../app/vistas/insertar_nota.php';
		
    }

    public function ver() {
		
        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        $conn = ConexionBD::conectar();
		
        $notaDAO = new NotaDAO($conn);
        $nota = $notaDAO->find($id);
		
		if ($nota->getId_usuario() != Sesion::obtener()->getId()) {
            MensajesFlash::anadir_mensaje("¡La nota no es tuya!");
			
			header("Location: /mis_notas");
        }
        
        require '../app/vistas/ver_nota.php';
		
    }

    public function editar() {
		
       if (Sesion::existe() == false) {
        header("Location: /");
            MensajesFlash::anadir_mensaje("No puedes editar mensajes si no inicias sesión");
            die();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            /*             * ******************************************** */
            /*             * *** ACTUALIZAMOS EL ARTÍCULO EN LA BBDD **** */
            /*             * ******************************************** */
            $conn = ConexionBD::conectar();
            //Insertamos el artículo en la BBDD
			$id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
            $notaDAO = new NotaDAO($conn);
			$nota = $notaDAO->find($id);

            //Filtramos datos de entrada
            $descripcion = filter_var($_POST['descripcion'], FILTER_SANITIZE_SPECIAL_CHARS);
            $titulo = filter_var($_POST['titulo'], FILTER_SANITIZE_SPECIAL_CHARS);

            $nota->setDescripcion($descripcion);
            $nota->setTitulo($titulo);
            //$nota->setId_usuario(Sesion::obtener()->getId());

            $notaDAO->update($nota);

            MensajesFlash::anadir_mensaje("Se ha editado la nota");
			header("Location: /ver_nota/" . $nota->getId());
			
            die();
        } else {
			$id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
			$conn = ConexionBD::conectar();
			
			$notaDAO = new NotaDAO($conn);
			$nota = $notaDAO->find($id);
		}
        
        require '../app/vistas/editar_nota.php';
		
    }

    public function mis_notas() {
		
        $conn = ConexionBD::conectar();
        $notaDAO = new NotaDAO($conn);
        $mis_notas = $notaDAO->findByUser(Sesion::obtener()->getId());

        //Generamos Token para seguridad del borrado
        $_SESSION['token'] = md5(time() + rand(0, 999));
        $token = $_SESSION['token'];

        require '../app/vistas/mis_notas.php';
		
    }
	
	public function perfil() {
		
        $conn = ConexionBD::conectar();
        $notaDAO = new NotaDAO($conn);
        $mis_notas = $notaDAO->findByUser(Sesion::obtener()->getId());

        //Generamos Token para seguridad del borrado
        $_SESSION['token'] = md5(time() + rand(0, 999));
        $token = $_SESSION['token'];

        require '../app/vistas/perfil.php';
		
    }
	
	public function encuentra_notas() {
		
		// 1. Crear formulario en Ajax en el js
		$texto_busqueda = filter_var($_GET['texto_busqueda'], FILTER_SANITIZE_SPECIAL_CHARS);
		
		// 2. Crear funcion en el DAO que encuentre notas
		$conn = ConexionBD::conectar();
        $notaDAO = new NotaDAO($conn);
		$idUsuario = Sesion::obtener()->getId();
        $notas_encontradas = $notaDAO->findByTituloDescripcion($texto_busqueda, $idUsuario);
		
		// 3. Serializar notas en json
		
		$notas_json = array();
		
		foreach ($notas_encontradas as $nota) {
			$notas_json[] = array (
				'id' => $nota->getId(),
				'titulo' => $nota->getTitulo(),
				'descripcion' => substr($nota->getDescripcion(), 0, 20) . "..."
			);
		}
		
		// 4. Devoler notas serializadas
		print(json_encode($notas_json));
	}	
	
}