<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/FormularioRegistro.php';

$form = new FormularioRegistro();
$htmlFormRegistro = $form->gestiona();

$tituloPagina = 'Registro';

$contenidoPrincipal = <<<EOS
<h1>Registro de usuario</h1>
$htmlFormRegistro
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
