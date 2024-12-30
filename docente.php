<?php include("template/cabecera.php")?>

<?php
session_start();
if ($_SESSION['userType'] !== 'docente') {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vista de Docente</title>
</head>
<body>
    <h1>Bienvenido, Docente</h1>
    <p>Contenido exclusivo para docentes.</p>
</body>
</html>

<?php include("template/pie.php")?>

<!--...............................................-->