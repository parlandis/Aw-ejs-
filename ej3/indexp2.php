<?php
//Inicio del procesamiento
session_start();

$tituloPagina = 'Portada';



$contenidoPrincipal = <<<EOS
<h1>Página principal</h1>
<p> Aquí está el contenido público, visible para todos los usuarios. </p>
EOS;

if(isset($_SESSION["login"]) && $_SESSION["login"] === true){
    //Usuario autenticado
    $contenidoPrincipal = <<<EOS
    <h1>Bienvenido, {$_SESSION["username"]}</h
    EOS;
}

require __DIR__.'/includes/vistas/plantillas/plantilla.php';

