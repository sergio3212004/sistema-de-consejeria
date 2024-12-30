<?php include("template/cabecera.php")?>

<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'data.php'; // Archivo para los datos de usuarios, citas y horarios

if ($_SESSION['userType'] !== 'alumno') {
    header('Location: index.php');
    exit();
}

// Leer el archivo JSON de usuarios
$json_data = file_get_contents('usuarios.json');
$usuarios = json_decode($json_data, true);

// Obtener la lista de docentes
$docentes = $usuarios['docentes'];

// Cargar los horarios y citas desde los archivos JSON
$horarios = json_decode(file_get_contents('horarios.json'), true);
$citas = json_decode(file_get_contents('citas.json'), true);

// Verificar que $citas sea un array
if (!is_array($citas)) {
    $citas = [];
}

// Procesar el formulario de agendamiento
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $alumno_id = $_SESSION['userId'];
    $docente_id = $_POST['docente_id'];
    $dia = $_POST['dia'];
    $hora = $_POST['hora'];
    $nombre = $_POST['nombre'];
    $curso = $_POST['curso'];
    $motivo = $_POST['motivo'];

    $citas[] = [
        'alumno_id' => $alumno_id,
        'docente_id' => $docente_id,
        'dia' => $dia,
        'hora' => $hora,
        'nombre' => $nombre,
        'curso' => $curso,
        'motivo' => $motivo,
        'estado' => 'pendiente'
    ];

    // Guardar las citas en el archivo JSON en un formato más legible
    file_put_contents('citas.json', json_encode($citas, JSON_PRETTY_PRINT));

    echo "<p class='alert alert-success'>Cita agendada con éxito.</p>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar Cita - Consejería UNT</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <style>
        body {
            background-image: url('img/UNT1.jpg'); /* Ruta de la imagen de fondo */
            background-size: cover; /* Ajusta la imagen para que cubra toda la pantalla */
            background-position: center; /* Centra la imagen de fondo */
            background-repeat: no-repeat; /* Evita que la imagen se repita */
            overflow-x: hidden; /* Oculta la barra de desplazamiento horizontal */
        }
        .form-container {
            max-width: 600px;
            margin: auto;
            padding: 13px;
            background-color: rgba(255, 255, 255, 0.8); /* Fondo blanco con transparencia */
            border-radius: 13px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 95px; /* Añadir margen inferior para evitar conflicto con el pie de página */
        }
        .form-header {
            text-align: center;
            margin-bottom: 10px;
        }
        .form-header h2 {
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
        <div class="form-container">
            <div class="form-header">
                <h2>AGENDAR CITA</h2>
            </div>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="docente_id">Docente:</label>
                    <select class="form-control" id="docente_id" name="docente_id" required onchange="mostrarHorarios(this.value)">
                        <option value="" disabled selected>Seleccione un docente</option>
                        <?php foreach ($docentes as $docente): ?>
                            <option value="<?php echo $docente['id']; ?>"><?php echo $docente['nombre'] . ' ' . $docente['apellidos']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="dia">Fecha:</label>
                    <select class="form-control" id="dia" name="dia" required onchange="mostrarHorariosPorDia()">
                        <option value="" disabled selected>Seleccione un día</option>
                        <option value="Lunes">Lunes</option>
                        <option value="Martes">Martes</option>
                        <option value="Miércoles">Miércoles</option>
                        <option value="Jueves">Jueves</option>
                        <option value="Viernes">Viernes</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="hora">Hora:</label>
                    <select class="form-control" id="hora" name="hora" required>
                        <option value="" disabled selected>Seleccione una hora</option>
                        <!-- Las opciones de hora se llenarán dinámicamente con JavaScript -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="nombre">Nombres y Apellidos:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required placeholder="Ingrese sus nombres y apellidos">
                </div>
                <div class="form-group">
                    <label for="curso">Curso/Tema:</label>
                    <input type="text" class="form-control" id="curso" name="curso" required placeholder="Ingrese el curso o tema">
                </div>
                <div class="form-group">
                    <label for="motivo">Motivo por el cual se solicita consejería:</label>
                    <textarea class="form-control" id="motivo" name="motivo" rows="3" maxlength="600" required placeholder="Ingrese el motivo (máximo 600 palabras)"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Agendar Cita</button>
            </form>
        </div>
    </div>

    <script>
        const horarios = <?php echo json_encode($horarios); ?>;
        let citas = <?php echo json_encode($citas); ?>;

        // Asegurarse de que citas sea un array
        if (!Array.isArray(citas)) {
            citas = [];
        }

        function mostrarHorarios(docenteId) {
            const selectHora = document.getElementById('hora');
            selectHora.innerHTML = '<option value="" disabled selected>Seleccione una hora</option>';

            const dia = document.getElementById('dia').value;
            console.log('Docente ID:', docenteId);
            console.log('Día:', dia);

            if (horarios[docenteId]) {
                horarios[docenteId].forEach(horario => {
                    console.log('Horario:', horario);
                    if (horario.dia.toLowerCase() === dia.toLowerCase()) {
                        const horaInicio = horario.hora_inicio;
                        const horaFin = horario.hora_fin;
                        console.log('Hora Inicio:', horaInicio);
                        console.log('Hora Fin:', horaFin);
                        // Comprobar si la hora ya ha sido reservada
                        const citaExistente = citas.find(cita => cita.docente_id == docenteId && cita.dia.toLowerCase() == dia.toLowerCase() && cita.hora == horaInicio + '-' + horaFin);
                        if (!citaExistente) {
                            const option = document.createElement('option');
                            option.value = horaInicio + '-' + horaFin;
                            option.textContent = horaInicio + ' - ' + horaFin;
                            selectHora.appendChild(option);
                        }
                    }
                });
            }
        }

        function mostrarHorariosPorDia() {
            const docenteId = document.getElementById('docente_id').value;
            if (docenteId) {
                mostrarHorarios(docenteId);
            }
        }
    </script>
</body>
</html>

<?php include("template/pie.php")?>