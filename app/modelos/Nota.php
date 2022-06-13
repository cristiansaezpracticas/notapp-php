<?php

/**
 * Description of Nota
 *
 * @author Cristian
 */
 
class Nota {

    private $id;
    private $titulo;
    private $descripcion;
    private $fecha;
    private $id_usuario;
	
	//Array que contendrá los datos del usuario al que pertenece la nota
    private $usuario;
	

	function getId() {
        return $this->id;
    }
	
	function setId($id): void {
        $this->id = $id;
    }
	
	function getTitulo() {
        return $this->titulo;
    }
	
	function setTitulo($titulo): void {
        $this->titulo = $titulo;
    }
	
	function getDescripcion() {
        return $this->descripcion;
    }
	
	function setDescripcion($descripcion): void {
        $this->descripcion = $descripcion;
    }
	 
    function getFecha() {
        return $this->fecha;
    }

    function setFecha($fecha): void {
        $this->fecha = $fecha;
    }

    function getId_usuario() {
        return $this->id_usuario;
    }
	
	function setId_usuario($id_usuario): void {
        $this->id_usuario = $id_usuario;
    }
	
    function getUsuario() {
        if (!isset($this->usuario)) {
            $usuarioDAO = new UsuarioDAO(ConexionBD::conectar());
            $this->usuario = $usuarioDAO->find($this->getId_usuario());
        }
        return $this->usuario;
    }

}