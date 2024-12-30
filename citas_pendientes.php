<?php include("template/cabecera.php")?>

<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verificar si el usuario es un alumno
$isAlumno = isset($_SESSION['userType']) && $_SESSION['userType'] === 'alumno';

// Leer las citas desde un archivo JSON
$citas = json_decode(file_get_contents('citas.json'), true);

if (!is_array($citas)) {
    $citas = [];
}

// Obtener el ID del alumno de la sesión
$alumnoId = isset($_SESSION['userId']) ? $_SESSION['userId'] : '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Citas Pendientes - Consejería UNT</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            background-image: url('img/UNT1.jpg'); /* Ruta de la imagen de fondo */
            background-size: cover; /* Ajusta la imagen para que cubra toda la pantalla */
            background-position: center; /* Centra la imagen de fondo */
            background-repeat: no-repeat; /* Evita que la imagen se repita */
        }
        .table-container {
            margin-top: 50px;
            background-color: rgba(255, 255, 255, 0.9); /* Fondo blanco con transparencia */
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .title-box {
            background-color: rgba(255, 255, 255, 0.9); /* Fondo blanco con transparencia */
            color: #000; /* Texto negro */
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Sombra */
            margin-bottom: 20px; /* Espacio debajo del título */
            width: auto; /* Permite ajustar la anchura */
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="container mt-5 text-center">
        <div class="title-box" style="width: 30%;"> <!-- Puedes ajustar la anchura cambiando este valor -->
            <h2>CITAS PENDIENTES</h2>
        </div>
        <div class="table-container">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nombre del Alumno</th>
                        <th>Curso/Tema</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Motivo</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $citasMostradas = false;
                    foreach ($citas as $cita): 
                        // Verificar si la cita corresponde al alumno logueado
                        if ($isAlumno && $alumnoId == $cita['alumno_id']): 
                            $citasMostradas = true;
                    ?>
                            <tr>
                                <td><?php echo htmlspecialchars($cita['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($cita['curso']); ?></td>
                                <td><?php echo htmlspecialchars($cita['dia']); ?></td>
                                <td><?php echo htmlspecialchars($cita['hora']); ?></td>
                                <td><?php echo htmlspecialchars($cita['motivo']); ?></td>
                                <td><?php echo htmlspecialchars($cita['estado']); ?></td>
                            </tr>
                    <?php 
                        endif; 
                    endforeach; 
                    if (!$citasMostradas): 
                    ?>
                        <tr>
                            <td colspan="6" class="text-center">No hay citas pendientes.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

<?php include("template/pie.php")?>

<!--...............................................-->