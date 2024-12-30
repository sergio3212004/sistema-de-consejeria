<?php include("template/cabecera.php")?>

<?php
session_start();
include 'data.php'; // Archivo para los datos de usuarios, citas y horarios

if ($_SESSION['userType'] !== 'docente') {
    header('Location: login.php');
    exit();
}

$docente_id = $_SESSION['userId'];

// Obtener las citas pendientes
$citas_pendientes = array_filter($citas, function($cita) use ($docente_id) {
    return $cita['docente_id'] == $docente_id && $cita['estado'] == 'pendiente';
});

// Procesar la confirmación de citas
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cita_id = $_POST['cita_id'];
    foreach ($citas as &$cita) {
        if ($cita['id'] == $cita_id) {
            $cita['estado'] = 'confirmada';
            break;
        }
    }
    echo "<p class='alert alert-success'>Cita confirmada con éxito.</p>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar Citas - Consejería UNT</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Confirmar Citas</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Alumno</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($citas_pendientes as $cita): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($usuarios['alumnos'][$cita['alumno_id']]['nombre'] . ' ' . $usuarios['alumnos'][$cita['alumno_id']]['apellido']); ?></td>
                        <td><?php echo htmlspecialchars($cita['fecha']); ?></td>
                        <td><?php echo htmlspecialchars($cita['hora']); ?></td>
                        <td>
                            <form action="" method="POST">
                                <input type="hidden" name="cita_id" value="<?php echo htmlspecialchars($cita['id']); ?>">
                                <button type="submit" class="btn btn-success">Confirmar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php include("template/pie.php")?>

<!--...............................................-->