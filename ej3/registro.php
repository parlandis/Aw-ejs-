<?php
//Inicio del procesamiento

$tituloPagina = 'Registro';

$contenidoPrincipal = <<<EOS
<h1>Registro de usuario</h1>
<form action="procesarRegistrop2.php" method="POST">
<fieldset>
	<legend>Datos para el registro</legend>
	<div>
		<label for="nombreUsuario">Nombre de usuario:</label>
		<input id="usuario" type="text" name="usuario" />
	</div>
	<div>
		<label for="nombre">Nombre:</label>
		<input id="nombre" type="text" name="nombre" />
	</div>
	<div>
		<label for="password">Contraseña:</label>
		<input id="password" type="password" name="password" />
	</div>
	<div>
		<label for="password2">Reintroduce el password:</label>
		<input id="password2" type="password" name="password2" />
	</div>
    <div>
        <label for="email">Correo electrónico:</label>
        <input id="email" type="email" name="email" />
	<div>
		<button type="submit" name="registro">Registrar</button>
	</div>
</fieldset>
</form>
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
