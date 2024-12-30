<?php include("template/cabecera.php")?>

<?php
session_start();
include 'data.php'; // Archivo para los datos de usuarios y horarios

if ($_SESSION['userType'] !== 'alumno') {
    header('Location: index.php');
    exit();
}

// Obtener la lista de docentes y sus horarios
$docentes = $usuarios['docentes'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Horarios - Consejería UNT</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Horarios de Consejería</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Docente</th>
                    <th>Día</th>
                    <th>Hora de Inicio</th>
                    <th>Hora de Fin</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($docentes as $docente): ?>
                    <?php if (isset($horarios[$docente['id']])): ?>
                        <?php foreach ($horarios[$docente['id']] as $horario): ?>
                            <tr>
                                <td><?php echo $docente['nombre'] . ' ' . $docente['apellido']; ?></td>
                                <td><?php echo $horario['dia']; ?></td>
                                <td><?php echo $horario['hora_inicio']; ?></td>
                                <td><?php echo $horario['hora_fin']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php include("template/pie.php")?>

<!--...............................................-->