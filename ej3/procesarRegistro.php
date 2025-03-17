<?php
require_once __DIR__.'/includes/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $email = trim($_POST["email"]);

    // Hashear la contraseña
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    if (!empty($usuario) && !empty($password) && !empty($email)) {
        // Obtener la conexión a la base de datos
        $conn = Aplicacion::getInstance()->getConexionBd();

        // Verificar si el usuario ya existe
        $sql = "SELECT username FROM usuarios WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows == 0) {
            // Preparar la consulta para evitar SQL Injection
            $sql = "INSERT INTO usuarios (username, password, email, rol) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $rol = 'cliente'; // Definir rol por defecto
            $stmt->bind_param("ssss", $usuario, $hashed_password, $email, $rol);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                // INICIO DE SESIÓN AUTOMÁTICO
                $_SESSION["username"] = $usuario;
                $_SESSION["login"] = true;
                $_SESSION["usuario_email"] = $email;
                $_SESSION["usuario_rol"] = 'cliente';
                $_SESSION['puntos'] = 0; // Inicializar puntos a 0
                header("Location: index.php"); // Redirigir a la página de usuario
                exit();
            } else {
                $_SESSION['error_registro'] = "Error al crear la cuenta. Por favor, inténtelo de nuevo.";
            }
        } else {
            $_SESSION['error_registro'] = "Ya existe un usuario con ese nombre. Por favor, elige otro nombre de usuario.";
        }
    } else {
        $_SESSION['error_registro'] = "Por favor, completa todos los campos.";
    }

    // Si llegamos aquí, hubo un error
    header("Location: registro.php");
    exit();
}
?>