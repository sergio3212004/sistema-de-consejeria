<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];

    // Leer las citas desde el archivo JSON
    $citas = json_decode(file_get_contents('citas.json'), true);

    // Buscar la cita y actualizar su estado a "negada"
    foreach ($citas as &$cita) {
        if ($cita['nombre'] == $nombre) {
            $cita['estado'] = 'negada';
            break;
        }
    }

    // Guardar las citas actualizadas en el archivo JSON
    file_put_contents('citas.json', json_encode($citas, JSON_PRETTY_PRINT));

    echo 'Cita negada';
}
?>

<!--...............................................-->