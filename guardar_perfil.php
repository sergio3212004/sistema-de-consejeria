<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
    exit();
}

// Leer el archivo JSON
$json_data = file_get_contents('usuarios.json');
$usuarios = json_decode($json_data, true);

// Obtener el correo del usuario desde la sesión
$correo_usuario = $_SESSION['email'];

// Obtener los datos del usuario
$usuario = $usuarios['docentes'][$correo_usuario] ?? $usuarios['alumnos'][$correo_usuario] ?? null;

if (!$usuario) {
    echo "Usuario no encontrado.";
    exit();
}

// Procesar los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Actualizar la contraseña si se ha cambiado
    if (!empty($_POST['password'])) {
        $usuario['contrasena'] = $_POST['password'];
    }

    // Procesar la nueva imagen de perfil si se ha subido
    if (!empty($_FILES['imagen']['name'])) {
        $target_dir = "img/usuarios/";
        $target_file = $target_dir . basename($_FILES["imagen"]["name"]);
        move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file);
        $usuario['foto_url'] = $target_file;
    }

    // Guardar los cambios en el archivo JSON
    if (isset($usuarios['docentes'][$correo_usuario])) {
        $usuarios['docentes'][$correo_usuario] = $usuario;
    } else {
        $usuarios['alumnos'][$correo_usuario] = $usuario;
    }
    file_put_contents('usuarios.json', json_encode($usuarios, JSON_PRETTY_PRINT));

    // Redirigir de vuelta al perfil del usuario
    header("Location: usuarios.php");
    exit();
}
?>