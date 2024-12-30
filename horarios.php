<?php include("template/cabecera.php")?>

<?php
include 'data.php'; // Asegúrate de que este archivo contiene la lista de docentes

$horarios_file = 'horarios.json';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $docente_id = $_POST['docente_id'];
    $dia = $_POST['dia'];
    $hora_inicio = $_POST['hora_inicio'];
    $hora_fin = $_POST['hora_fin'];

    $horarios = file_exists($horarios_file) ? json_decode(file_get_contents($horarios_file), true) : [];

    $horarios[$docente_id][] = [
        'dia' => $dia,
        'hora_inicio' => $hora_inicio,
        'hora_fin' => $hora_fin
    ];

    file_put_contents($horarios_file, json_encode($horarios, JSON_PRETTY_PRINT));
    echo "<p class='alert alert-success'>Horario guardado con éxito.</p>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horarios</title>
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
        .container {
            background-color: rgba(255, 255, 255, 0.8); /* Fondo blanco con transparencia */
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }
        .title-box-container {
            text-align: center;
            margin-top: 50px;
        }
        .title-box {
            background-color: rgba(255, 255, 255, 0.8); /* Fondo blanco con transparencia */
            color: #000; /* Texto negro */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Sombra */
            width: 250px; /* Permite ajustar la anchura */
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="title-box-container">
        <div class="title-box">
            <h2>HORARIOS</h2>
        </div>
    </div>
    <div class="container mt-5">
        <form method="POST">
            <div class="form-group">
                <label for="docente_id">Seleccione un docente:</label>
                <select name="docente_id" id="docente_id" class="form-control" required>
                    <option value="" disabled selected>Seleccione un docente</option>
                    <?php foreach ($usuarios['docentes'] as $docente): ?>
                        <option value="<?php echo $docente['id']; ?>">
                            <?php echo $docente['nombre'] . ' ' . $docente['apellido']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="dia">Día:</label>
                <select name="dia" id="dia" class="form-control" required>
                    <option value="" disabled selected>Seleccione un día</option>
                    <option value="Lunes">Lunes</option>
                    <option value="Martes">Martes</option>
                    <option value="Miércoles">Miércoles</option>
                    <option value="Jueves">Jueves</option>
                    <option value="Viernes">Viernes</option>
                </select>
            </div>
            <div class="form-group">
                <label for="hora_inicio">Hora inicio:</label>
                <input type="time" name="hora_inicio" id="hora_inicio" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="hora_fin">Hora fin:</label>
                <input type="time" name="hora_fin" id="hora_fin" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar horario</button>
        </form>
    </div>
</body>
</html>

<?php include("template/pie.php")?>

<!--...............................................-->