<?php
require_once __DIR__.'/includes/config.php'; // Ruta corregida

$tituloPagina = 'Login';

// Construir el contenido principal
$contenidoPrincipal = <<<EOS
<div class="login-page">
    <main>
        <form action="procesarLogin.php" method="post">
            <fieldset>
                <legend>Acceso al sistema</legend>
                <div>
                    <label for="username">Nombre de usuario:</label>
                    <input type="text" name="username" id="username" required>
                </div>
                <div>
                    <label for="password">Contraseña:</label>
                    <input type="password" name="password" id="password" required>
                </div>
                <div>
                    <button type="submit" name="login">Entrar</button>
                </div>
EOS;

// Añadir mensaje de error si existe
if (isset($_SESSION['error_login'])) {
    $contenidoPrincipal .= <<<EOS
                <div class='error'>{$_SESSION['error_login']}</div>
EOS;
    unset($_SESSION['error_login']);
}

$contenidoPrincipal .= <<<EOS
            </fieldset>
        </form>
        <div class="enlace-registro">
            <a href="registro.php">¿No tienes cuenta? Regístrate aquí</a>
        </div>
    </main>
</div>
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
?>