<?php
require_once __DIR__.'/includes/config.php'; // Ruta corregida

$formEnviado = isset($_POST['login']);
if (!$formEnviado) {
    header('Location: login.php');
    exit();
}

require_once __DIR__.'/includes/utils.php'; // Ruta corregida

$erroresFormulario = [];

// Sanitizar y validar entrada
$nombreUsuario = filter_input(INPUT_POST, 'nombreUsuario', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$nombreUsuario = trim($nombreUsuario ?? '');
if (empty($nombreUsuario)) {
    $erroresFormulario['nombreUsuario'] = 'El nombre de usuario no puede estar vacío';
}

$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$password = trim($password ?? '');
if (empty($password)) {
    $erroresFormulario['password'] = 'La contraseña no puede estar vacía';
}

if (count($erroresFormulario) === 0) {
    $conn = conexionBD();
    
    // Consulta preparada para evitar SQLi
    $sql = "SELECT username, password, rol FROM usuarios WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nombreUsuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 0) {
        // Error genérico para no revelar información
        $erroresFormulario[] = "Credenciales inválidas";
    } else {
        $fila = $resultado->fetch_assoc();
        if (password_verify($password, $fila['password'])) {
            // Configurar sesión
            $_SESSION['login'] = true;
            $_SESSION['nombre'] = $fila['username'];
            $_SESSION['esAdmin'] = ($fila['rol'] === 'administrador');
            
            header('Location: index.php');
            exit();
        } else {
            $erroresFormulario[] = "Credenciales inválidas";
        }
    }
    $stmt->close();
    $conn->close();
}

// Generar vista con errores
$tituloPagina = 'Login';
$erroresGlobales = generaErroresGlobalesFormulario($erroresFormulario);
$erroresCampos = generaErroresCampos(['nombreUsuario', 'password'], $erroresFormulario);

$contenidoPrincipal = <<<EOS
<h1>Acceso al sistema</h1>
{$erroresGlobales}
<form action="procesarLoginp2.php" method="POST">
    <fieldset>
        <legend>Usuario y contraseña</legend>
        <div>
            <label for="nombreUsuario">Nombre de usuario:</label>
            <input type="text" id="nombreUsuario" name="nombreUsuario" value="{$nombreUsuario}">
            {$erroresCampos['nombreUsuario']}
        </div>
        <div>
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password">
            {$erroresCampos['password']}
        </div>
        <div>
            <button type="submit" name="login">Entrar</button>
        </div>
    </fieldset>
</form>
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php'; // Ruta corregida
?>