<?php

require_once __DIR__.'/includes/config.php';
unset($_SESSION['username']);
unset($_SESSION['login']);
unset($_SESSION['usuario_email']);
unset($_SESSION['usuario_admin']);
session_destroy();

$tituloPagina = 'Logout';
$contenidoPrincipal = <<<EOS
<h1>Has cerrado sesión</h1>
<p>Gracias por visitar nuestra web. Hasta pronto.</p>
<p><a href="index.php">Volver a la página principal</a></p>
EOS;
require __DIR__.'/includes/vistas/plantillas/plantilla.php';
?>