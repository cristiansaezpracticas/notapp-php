<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title><?= $pagina ?> · notapp</title>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
		<link rel="stylesheet" href="../web/css/estilos.css">
		<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css'><link rel="stylesheet" href="../web/css/vista.css">
		<script src="https://kit.fontawesome.com/80561d826d.js" crossorigin="anonymous"></script>
		<link rel="shortcut icon" href="../web/images/notapp-favicon.png" type="image/x-icon" />
		<meta name="theme-color" content="#3F51B5">
		<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.js" integrity="sha512-K3MtzSFJk6kgiFxCXXQKH6BbyBrTkTDf7E6kFh3xBZ2QNMtb6cU/RstENgQkdSLkAZeH/zAtzkxJOTTd8BqpHQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	</head>
	<body>
		<header>
			<div class="menu">
				<div class="contenedor">
				<?php if (Sesion::existe()): ?>
					<a href="/mis_notas"><div class="logo">Notapp</div></a>
					<nav>
						<ul>
							<li><a href="/insertar_nota"><div class="add"><i class="fa-solid fa-plus"></i></div></a></li>
							<?php if (Sesion::existe()) {
								if (Sesion::obtener()->getRol() == 'Administrador') { ?>
							<li><a href="/panel"><div class="add"><i class="fa-solid fa-screwdriver-wrench"></i></div></a></li>

								<?php }
							} ?>
							<li><a href="/perfil"><div id="foto_usuario" style="background-image: url(/web/images/perfil/<?= Sesion::obtener()->getFoto() ?>)"></div></a></li>
							<!--<li><a href="/logout"><div class="add"><i class="fa-solid fa-right-to-bracket"></i></div></a></li>-->
						</ul>
					</nav>
					
					<?php else: ?>
				
					<a href="/"><div class="logo">Notapp</div></a>
					<nav>
						<ul>
							<li><a href="/conectarse">Conectar</a></li>
							<li><a href="/registrar">Registrar</i></a></li>
						</ul>
					</nav>				
					
					<?php endif; ?>
				</div>
			</div>
		</header>
		
		<div class="principal contenedor">
		
			<?= $contenido ?>
			
		</div>
		
		<footer>
			notapp &copy; Todos los derechos reservados a sus respectivos dueños.
		</footer>
			<script src="../web/js/vista.js"></script>
			<script src="../web/js/buscador.js"></script>
	</body>
</html>