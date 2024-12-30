<?php include("template/cabecera.php")?>

<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verificar si el usuario es un alumno o un docente
$isAlumno = isset($_SESSION['userType']) && $_SESSION['userType'] === 'alumno';
$isDocente = isset($_SESSION['userType']) && $_SESSION['userType'] === 'docente';

// Leer las citas desde un archivo JSON
$citas = json_decode(file_get_contents('citas.json'), true);

if (!is_array($citas)) {
    $citas = [];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Citas - Consejería UNT</title>
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
        .actions {
            text-align: right;
            white-space: nowrap; /* Evita que los botones se envuelvan a la siguiente línea */
        }
        .confirm-btn {
            background-color: #28a745;
            border-color: #28a745;
        }
        .confirm-btn:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
        .deny-btn {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .deny-btn:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
    </style>
</head>
<body>
    <div class="container mt-5 text-center">
        <div class="title-box" style="width: 25%;"> <!-- Puedes ajustar la anchura cambiando este valor -->
            <h2>VER CITAS</h2>
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
                        <?php if ($isDocente): ?>
                            <th>Acciones</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($citas as $cita): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($cita['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($cita['curso']); ?></td>
                            <td><?php echo htmlspecialchars($cita['dia']); ?></td>
                            <td><?php echo htmlspecialchars($cita['hora']); ?></td>
                            <td><?php echo htmlspecialchars($cita['motivo']); ?></td>
                            <td id="estado-<?php echo $cita['nombre']; ?>"><?php echo htmlspecialchars($cita['estado']); ?></td>
                            <?php if ($isDocente && isset($cita['nombre'])): ?>
                                <td class="actions">
                                    <button onclick="actualizarEstadoCita('<?php echo $cita['nombre']; ?>', 'confirmada')" class="btn btn-success confirm-btn">✅</button>
                                    <button onclick="actualizarEstadoCita('<?php echo $cita['nombre']; ?>', 'negada')" class="btn btn-danger deny-btn">❌</button>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        function actualizarEstadoCita(nombre, estado) {
            $.ajax({
                url: estado === 'confirmada' ? 'confirmar_cita.php' : 'negar_cita.php',
                type: 'POST',
                data: { nombre: nombre },
                success: function(response) {
                    // Actualiza el estado de la cita en la tabla
                    $('#estado-' + nombre).text(estado);
                },
                error: function(error) {
                    console.error('Error al actualizar el estado de la cita:', error);
                }
            });
        }
    </script>
</body>
</html>

<?php include("template/pie.php")?>

<!--...............................................-->