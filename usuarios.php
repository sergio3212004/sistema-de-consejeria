<?php include("template/cabecera.php")?>

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
$correo_usuario = $_SESSION['email']; // Cambiado a 'email' para que coincida con login.php

// Obtener los datos del usuario
$usuario = $usuarios['docentes'][$correo_usuario] ?? $usuarios['alumnos'][$correo_usuario] ?? null;

if (!$usuario) {
    echo "Usuario no encontrado.";
    exit();
}

// Establecer la imagen de perfil predeterminada si no hay una personalizada
if (empty($usuario['foto_url'])) {
    $usuario['foto_url'] = 'img/usuarios/default.jpg';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil de Usuario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .perfil {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin-top: -105px; /* Ajusta este valor según sea necesario */
        }

        .perfil-izquierda {
            text-align: center;
            margin-right: 20px;
        }

        .perfil-izquierda img {
            border-radius: 50%;
            width: 150px;
            height: 150px;
        }

        .perfil-derecha {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .perfil-derecha h3 {
            margin-top: 0;
        }

        .perfil-derecha form {
            display: flex;
            flex-direction: column;
        }

        .perfil-derecha label {
            margin-top: 10px;
        }

        .perfil-derecha input,
        .perfil-derecha button {
            margin-top: 5px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .perfil-derecha button {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        .perfil-derecha button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="perfil">
        <div class="perfil-izquierda">
            <img src="<?php echo $usuario['foto_url']; ?>" alt="Foto de perfil">
        </div>
        <div class="perfil-derecha">
            <h3>Detalles Personales</h3>
            <form action="guardar_perfil.php" method="post" enctype="multipart/form-data">
                <label for="usuario">Usuario</label>
                <input type="text" id="usuario" name="usuario" value="<?php echo $usuario['nombre']; ?>" readonly>
                
                <label for="apellidos">Apellidos</label>
                <input type="text" id="apellidos" name="apellidos" value="<?php echo $usuario['apellidos']; ?>" readonly>
                
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo $correo_usuario; ?>" readonly>
                
                <label for="imagen">Imagen</label>
                <input type="file" id="imagen" name="imagen">
                
                <button type="submit">Guardar</button>
            </form>
        </div>
    </div>
</body>
</html>

<?php include("template/pie.php")?>
