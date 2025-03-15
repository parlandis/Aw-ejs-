<?php
// Inicio del procesamiento

require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Login';

// Construir el contenido principal
$contenidoPrincipal = <<<EOS
<div class="login-page">
    <main>
        <form action="procesarLoginp2.php" method="post">
            <fieldset>
                <legend>Acceso al sistema</legend>
                <div>
                    <label for="usuario">Nombre de usuario:</label>
                    <input type="text" name="usuario" id="usuario" required>
                </div>
                <div>
                    <label for="password">Contraseña:</label>
                    <input type="password" name="password" id="password" required>
                </div>
                <div>
                    <button type="submit">Entrar</button>
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
            <a href="registrop2.php">¿No tienes cuenta? Regístrate aquí</a>
        </div>
    </main>
</div>
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';