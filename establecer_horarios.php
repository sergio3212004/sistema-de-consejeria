<?php include("template/cabecera.php")?>

<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'data.php'; // Archivo para los datos de usuarios

if ($_SESSION['userType'] !== 'docente') {
    header('Location: index.php');
    exit();
}

$docente_id = $_SESSION['userId'];

// Cargar los horarios desde el archivo JSON
$horarios = json_decode(file_get_contents('horarios.json'), true);

// Procesar el formulario de establecimiento de horarios
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dia = $_POST['dia'];
    $hora_inicio = $_POST['hora_inicio'];
    $hora_fin = $_POST['hora_fin'];

    $horarios[$docente_id][] = ['dia' => $dia, 'hora_inicio' => $hora_inicio, 'hora_fin' => $hora_fin];

    // Ordenar los horarios por día y hora de inicio
    usort($horarios[$docente_id], function($a, $b) {
        $dias = ['Lunes' => 1, 'Martes' => 2, 'Miércoles' => 3, 'Jueves' => 4, 'Viernes' => 5];
        if ($dias[$a['dia']] == $dias[$b['dia']]) {
            return strtotime($a['hora_inicio']) - strtotime($b['hora_inicio']);
        }
        return $dias[$a['dia']] - $dias[$b['dia']];
    });

    // Guardar los horarios en el archivo JSON en un formato más legible
    file_put_contents('horarios.json', json_encode($horarios, JSON_PRETTY_PRINT));

    echo "<p class='alert alert-success'>Horario establecido con éxito.</p>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Establecer Horarios - Consejería UNT</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Establecer Horarios de Consejería</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="dia">Día:</label>
                <select class="form-control" id="dia" name="dia" required>
                    <option value="" disabled selected>Seleccione un día</option>
                    <option value="Lunes">Lunes</option>
                    <option value="Martes">Martes</option>
                    <option value="Miércoles">Miércoles</option>
                    <option value="Jueves">Jueves</option>
                    <option value="Viernes">Viernes</option>
                </select>
            </div>
            <div class="form-group">
                <label for="hora_inicio">Hora de Inicio:</label>
                <input type="time" class="form-control" id="hora_inicio" name="hora_inicio" required>
            </div>
            <div class="form-group">
                <label for="hora_fin">Hora de Fin:</label>
                <input type="time" class="form-control" id="hora_fin" name="hora_fin" required>
            </div>
            <button type="submit" class="btn btn-primary">Establecer Horario</button>
        </form>
    </div>
</body>
</html>

<?php include("template/pie.php")?>

<!--...............................................-->