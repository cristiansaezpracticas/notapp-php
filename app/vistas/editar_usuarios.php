<?php 

ob_start();

$pagina= "Editar Usuario";

?>
<style>
    select {
        background-color: rgb(255, 255, 255, 0.3);
    color: white;
    font-size: 20px;
    padding: 10px 20px;
    border: 2px solid rgb(255, 255, 255, 0.7);
    border-radius: 10px;
    width: 100%;
    margin-top: 10px;
    }

    select option {
        
    color: black;

    }
</style>
    <form action="/editar_usuario/<?= $usuario->getId(); ?>" method="post">
        <input value="<?= $usuario->getNombre(); ?>" type="text" name="nombre" placeholder="Nombre...">
        <input value="<?= $usuario->getEmail(); ?>" type="email" name="email" placeholder="Email...">


        <select>
        <option value="0">Seleccione:</option>
        <option value="valoresid">valorespaises</option>
        </select>


        <input style="background-color: #2ecc71;" type="submit" value="Editar Usuario">
    </form>

<?php
$contenido = ob_get_clean();
require 'template.php';
?>
