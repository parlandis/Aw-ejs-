<?php
session_start();

// Parámetros de BD
define('BD_HOST', 'localhost');
define('BD_NAME', 'ejercicio3_db');
define('BD_USER', 'usuario_cliente');
define('BD_PASS', 'clientepass');

// ... (definiciones de rutas)

// Inicialización de la aplicación
require_once __DIR__.'/includes/clases/Aplicacion.php';
$app = Aplicacion::getInstance();
$app->init([
    'host' => BD_HOST,
    'bd' => BD_NAME,
    'user' => BD_USER,
    'pass' => BD_PASS
]);