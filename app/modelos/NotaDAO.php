<?php

/**
 * Description of NotaDAO
 *
 * @author Cristian
 */

class NotaDAO {
	
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function insert($nota) {
        //Comprobamos que el parámetro sea de la clase Usuario
        if (!$nota instanceof Nota) {
            return false;
        }
        $titulo = $nota->getTitulo();
        $descripcion = $nota->getDescripcion();
        $id_usuario = $nota->getId_usuario();
        $sql = "INSERT INTO notas (titulo, descripcion, id_usuario) VALUES "
                . "(?,?,?)";
        if(!$stmt = $this->conn->prepare($sql)){
            die("Error al preparar la consulta: " . $this->conn->error);
        }
        
        $stmt->bind_param('ssi',$titulo, $descripcion, $id_usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        
        //Guardo el id que le ha asignado la base de datos en la propiedad id del objeto
        $nota->setId($this->conn->insert_id);
        return true;
    }

    public function update($nota) {
        //Comprobamos que el parámetro es de la clase Usuario
        if (!$nota instanceof Nota) {
            return false;
        }
        $titulo = $nota->getTitulo();
        $descripcion = $nota->getDescripcion();
        $id = $nota->getId();
        $sql = "UPDATE notas SET"
                . " titulo = ?, descripcion = ?"
                . " WHERE id = ?";
        if(!$stmt = $this->conn->prepare($sql))
        {
            die("Error al preparar la consulta: ". $this->conn->error);
        }
        $stmt->bind_param("ssi",$titulo, $descripcion, $id);
        $stmt->execute();
        $result = $stmt->get_result();
                
        if ($stmt->affected_rows == 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Borra un registro de la tabla Usuarios
     * @param type $usuario Objeto de la clase usuario
     * @return bool Devuelve true si se ha borrado un usuario y false en caso contrario
     */
    public function delete($nota) {
        //Comprobamos que el parámetro no es nulo y es de la clase Usuario
        if ($nota == null || get_class($nota) != 'Nota') {
            return false;
        }
        $sql = "DELETE FROM notas WHERE id = " . $nota->getId();
        if (!$result = $this->conn->query($sql)) {
            die("Error en la SQL: " . $this->conn->error);
        }
        if ($this->conn->affected_rows == 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Devuelve el nota de la BD 
     * @param  $id id del usuario
     * @return \ Nota de la BD o null si no existe
     */
    public function find($id) { //: Usuario especifica el tipo de datos que va a devolver pero no es obligatorio ponerlo
        $sql = "SELECT * FROM notas WHERE id=$id";
        if (!$result = $this->conn->query($sql)) {
            die("Error en la SQL: " . $this->conn->error);
        }
        return $result->fetch_object('Nota');
    }

    /**
     * Devuelve todos los usuarios de la BD
     * @param type $orden Tipo de orden (ASC o DESC)
     * @param type $campo Campo de la BD por el que se van a ordenar
     * @return array Array de objetos de la clase Usuario
     */
    public function findAll($orden = 'ASC', $campo = 'id') {
        $sql = "SELECT *,date_format(fecha,'%e/%c/%Y') as fecha FROM notas ORDER BY $campo $orden";
        if (!$result = $this->conn->query($sql)) {
            die("Error en la SQL: " . $this->conn->error);
        }
        $array_obj_notas = array();
        while ($nota = $result->fetch_object('Nota')) {
            $array_obj_notas[] = $nota;
        }
        return $array_obj_notas;
    }
    
    public function findByUser($id_usuario) {
        $sql = "SELECT *,date_format(fecha,'%e/%c/%Y') as fecha FROM notas WHERE id_usuario=? ORDER BY id DESC";
        if(!$stmt = $this->conn->prepare($sql)){
            die("Error en la consulta $sql:" . $this->conn->error);
        }
        
        $stmt instanceof mysqli_stmt;
        
        $stmt->bind_param('i', $id_usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        
        
        $array_obj_notas = array();
        while ($nota = $result->fetch_object('Nota')) {
            $array_obj_notas[] = $nota;
        }
        return $array_obj_notas;
    }
	
	/**
     * Devuelve todos los usuarios de la BD
     * @param type $orden Tipo de orden (ASC o DESC)
     * @param type $campo Campo de la BD por el que se van a ordenar
     * @return array Array de objetos de la clase Usuario
     */
    public function findByTituloDescripcion($texto_busqueda, $idUsuario, $orden = 'DESC', $campo = 'id') {

		$sql = "SELECT *, date_format(fecha,'%e/%c/%Y') as fecha FROM notas WHERE (titulo LIKE '%$texto_busqueda%' or descripcion like '%$texto_busqueda%') AND id_usuario = $idUsuario ORDER BY $campo $orden";
		
        if (!$result = $this->conn->query($sql)) {
            die("Error en la SQL: " . $this->conn->error);
        }
		
        $array_obj_notas = array();
		
        while ($nota = $result->fetch_object('Nota')) {
            $array_obj_notas[] = $nota;
        }
        return $array_obj_notas;
		
    }

}
