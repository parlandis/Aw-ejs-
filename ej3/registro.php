<?php
// Inicio del procesamiento
require_once __DIR__.'/includes/config.php';
$tituloPagina = 'Registro';

// Si hay un error de registro, lo mostramos
if (isset($_SESSION['error_registro'])) {
    $errorRegistro = $_SESSION['error_registro'];
    unset($_SESSION['error_registro']); // Limpiamos el mensaje de error después de mostrarlo
} else {
    $errorRegistro = '';
}

$contenidoPrincipal = <<<EOS
<h1>Registro de usuario</h1>
<p style="color: red;">{$errorRegistro}</p>
<form action="procesarRegistro.php" method="POST">
<fieldset>
    <legend>Datos para el registro</legend>
    <div>
        <label for="username">Nombre de usuario:</label>
        <input id="username" type="text" name="username" required />
    </div>
    <div>
        <label for="email">Correo electrónico:</label>
        <input id="email" type="email" name="email" required />
    </div>
    <div>
        <label for="password">Contraseña:</label>
        <input id="password" type="password" name="password" required />
    </div>
    <div>
        <label for="password2">Reintroduce la contraseña:</label>
        <input id="password2" type="password" name="password2" required />
    </div>
    <div>
        <button type="submit" name="registro">Registrar</button>
    </div>
</fieldset>
</form>
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';