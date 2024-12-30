<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login de Consejería UNT</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('img/UNT.jpeg'); /* Ruta de la imagen de fondo */
            background-size: cover; /* Ajusta la imagen para que cubra toda la pantalla */
            background-position: center; /* Centra la imagen de fondo */
            background-repeat: no-repeat; /* Evita que la imagen se repita */
            overflow-x: hidden; /* Oculta la barra de desplazamiento horizontal */
        }
        .login-container {
            max-width: 555px;
            margin: auto;
            padding: 25px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transform: scale(1.2); /* Ajusta el valor para hacer zoom */
            transform-origin: top center; /* Mantiene el contenido centrado */
        }
        .login-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .login-header h2 {
            font-size: 2rem;
            font-weight: bold;
        }
        .form-group label {
            font-weight: bold;
        }
        .input-group-text {
            background-color: #6a1b9a;
            color: white;
        }
        .btn-primary {
            background-color: #6a1b9a;
            border-color: #6a1b9a;
        }
        .btn-primary:hover {
            background-color: #5a1480;
            border-color: #5a1480;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="login-container">
            <div class="login-header">
                <h2>Login de Consejería UNT</h2>
            </div>
            
            <?php
            // Verificar si la sesión ya está iniciada
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            $usuariosJson = file_get_contents('usuarios.json');
            $usuariosPermitidos = json_decode($usuariosJson, true);

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
                            $_SESSION['apellidos'] = $usuariosPermitidos['docentes'][$email]['apellidos'];
                            $_SESSION['email'] = $email;
                            $_SESSION['foto_url'] = $usuariosPermitidos['docentes'][$email]['foto_url'];
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
                            $_SESSION['apellidos'] = $usuariosPermitidos['alumnos'][$email]['apellidos'];
                            $_SESSION['email'] = $email;
                            $_SESSION['foto_url'] = $usuariosPermitidos['alumnos'][$email]['foto_url'];
                            header("Location: principal.php");
                            exit();
                        }
                    } else {
                        echo "<p class='alert alert-danger'>Error: Tipo de usuario no válido</p>";
                    }
                }
            }
            ?>

            <!-- Formulario Login -->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="p-4 border rounded shadow-sm">
                <!-- Tipo de Usuario -->
                <div class="form-group">
                    <label for="userType">Usuario:</label>
                    <select class="form-control" id="userType" name="userType" required>
                        <option value="" disabled selected>Seleccione una opción</option>
                        <option value="docente">Docente</option>
                        <option value="alumno">Alumno</option>
                    </select>
                </div>

                <!-- Correo -->
                <div class="form-group">
                    <label for="email">Correo Electrónico:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">✉️</span>
                        </div>
                        <input type="email" class="form-control" id="email" name="email" required placeholder="Ingrese su correo electrónico (@unitru.edu.pe)">
                    </div>
                </div>

                <!-- Contraseña -->
                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">🔐</span>
                        </div>
                        <input type="password" class="form-control" id="password" name="password" required placeholder="Ingrese su contraseña">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">🙈</button>
                        </div>
                    </div>
                </div>

                <!-- Botón de Enviar -->
                <button type="submit" class="btn btn-primary btn-block">Iniciar sesión</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            var passwordField = document.getElementById('password');
            var type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            this.textContent = this.textContent === '🙈' ? '🙉' : '🙈';
        });
    </script>
</body>
</html>