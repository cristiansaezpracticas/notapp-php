<?php

/**
 * Description of Usuario
 *
 * @author Cristian
 */
 
class Usuario {
	
    private $id;
    private $nombre;
    private $email;
	private $rol;
    private $password;
    private $foto;
    private $cookie_id;
	
	//Array que contendrá las notas del usuario
    private $notas;
    

    function getCookie_id() {
        return $this->cookie_id;
    }

    function setCookie_id($cookie_id): void {
        $this->cookie_id = $cookie_id;
    }

    function getId() {
        return $this->id;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getEmail() {
        return $this->email;
    }
	
	public function getRol() {
        return $this->rol;
    }

    public function setRol($rol): void {
        $this->rol = $rol;
    }

    function getPassword() {
        return $this->password;
    }

    function getFoto() {
        return $this->foto;
    }

    function getNotas() {
        return $this->notas;
    }

    function setId($id): void {
        $this->id = $id;
    }

    function setNombre($nombre): void {
        $this->nombre = $nombre;
    }

    function setEmail($email): void {
        $this->email = $email;
    }

    function setPassword($password): void {
        $this->password = $password;
    }

    function setFoto($foto): void {
        $this->foto = $foto;
    }

    function setNotas($notas): void {
        $this->notas = $notas;
    }

}