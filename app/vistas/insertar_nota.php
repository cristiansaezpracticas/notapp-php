<?php 

ob_start();

$pagina= "Añadir nota";


?>
<style>
.area {
    background-color: rgb(255, 255, 255, 0.3);
    color: white;
    font-size: 20px;
    padding: 10px 20px;
    border: 2px solid rgb(255, 255, 255, 0.7);
    border-radius: 10px;
    margin-top: 10px;
}

.jqte {
    border: #000 0px solid !important;
    border-radius: 0px !important;
    -webkit-border-radius: 0px !important;
    -moz-border-radius: 0px !important;
    box-shadow: 0 0 0px #999 !important;
    -webkit-box-shadow: 0 0 0px #999 !important;
    -moz-box-shadow: 0 0 0px #999 !important;
    overflow: hidden;
    transition: box-shadow 0.4s, border 0.4s !important;
    -webkit-transition: -webkit-box-shadow 0.4s, border 0.4s !important;
    -moz-transition: -moz-box-shadow 0.4s, border 0.4s !important;
    -o-transition: -o-box-shadow 0.4s, border 0.4s !important;
	
	margin-top: 10px !important;
	margin: 0 !important;
}

.jqte_editor, .jqte_source {
	background-color: rgb(255, 255, 255, 0.3) !important;
	border: 2px solid rgb(255, 255, 255, 0.7) !important;
	border-radius: 0px 0px 10px 10px  !important;
}

.jqte_toolbar {
    margin-top: 10px !important;
	border: 2px solid rgb(255, 255, 255, 0.7) !important;
	border-radius: 10px 10px 0px 0px !important;
}
</style>

        <link href="../web/js/jQuery-TE_v.1.4.0/jquery-te-1.4.0.css" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="../web/js/jQuery-TE_v.1.4.0/jquery-te-1.4.0.min.js"></script>
        

        <script type="text/javascript">
            $(function () {
                $("#descripcion").jqte();
            });
        </script>
		
        <form action="" method="post" enctype="multipart/form-data">
            <input type="text" name="titulo" placeholder="Titulo">
            <textarea class="area" name="descripcion" id="descripcion" placeholder="Descripcion"></textarea>
            <input style="background-color: #2ecc71;" type="submit" value="Añadir Nota">
        </form>

<?php
$contenido = ob_get_clean();
require 'template.php';
?>
