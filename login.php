<?php
session_start();
include 'usuarios_permitidos.php';

// Comprobar envío de formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userType = $_POST['userType'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validación de correo
    if (strpos($email, '@unitru.edu.pe') === false) {
        echo "<p class='alert alert-danger'>Error: Solo se permiten correos @unitru.edu.pe</p>";
    } else {
        // Validación de usuarios permitidos
        if ($userType == 'docente') {
            if (!array_key_exists($email, $usuariosPermitidos['docentes']) || $usuariosPermitidos['docentes'][$email]['contrasena'] != $password) {
                echo "<p class='alert alert-danger'>Error: Usuario o contraseña incorrectos</p>";
            } else {
                // Guardar datos en la sesión y redirigir a principal.php
                $_SESSION['userType'] = $userType;
                $_SESSION['userId'] = $usuariosPermitidos['docentes'][$email]['id'];
                $_SESSION['name'] = $usuariosPermitidos['docentes'][$email]['nombre'];
                $_SESSION['email'] = $email;
                header("Location: principal.php");
                exit();
            }    
        } elseif ($userType == 'alumno') {
            if (!array_key_exists($email, $usuariosPermitidos['alumnos']) || $usuariosPermitidos['alumnos'][$email]['contrasena'] != $password) {
                echo "<p class='alert alert-danger'>Error: Usuario o contraseña incorrectos</p>";
            } else {
                // Guardar datos en la sesión y redirigir a principal.php
                $_SESSION['userType'] = $userType;
                $_SESSION['userId'] = $usuariosPermitidos['alumnos'][$email]['id'];
                $_SESSION['name'] = $usuariosPermitidos['alumnos'][$email]['nombre'];
                $_SESSION['email'] = $email;
                header("Location: principal.php");
                exit();
            }
        } else {
            echo "<p class='alert alert-danger'>Error: Tipo de usuario no válido</p>";
        }
    }
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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="styles.css"> <!-- Asegúrate de tener un archivo CSS para estilos -->
</head>
<body>
    <div class="perfil">
        <div class="perfil-izquierda">
            <img src="<?php echo $usuario['foto_url']; ?>" alt="Foto de perfil">
            <h2><?php echo $usuario['nombre']; ?></h2>
            <p><?php echo $correo_usuario; ?></p>
        </div>
        <div class="perfil-derecha">
            <h3>Detalles Personales</h3>
            <form action="guardar_perfil.php" method="post" enctype="multipart/form-data">
                <label for="usuario">Usuario</label>
                <input type="text" id="usuario" name="usuario" value="<?php echo $usuario['nombre']; ?>" readonly>
                
                <label for="password">Password</label>
                <input type="password" id="password" name="password" value="<?php echo $usuario['contrasena']; ?>">
                
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo $correo_usuario; ?>" readonly>
                
                <label for="imagen">Imagen</label>
                <input type="file" id="imagen" name="imagen">
                
                <button type="submit">Guardar</button>
                <button type="button" onclick="window.location.href='perfil.php'">Volver a Mi Perfil</button>
            </form>
        </div>
    </div>
</body>
</html>
