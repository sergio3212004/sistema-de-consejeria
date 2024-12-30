<?php include("template/cabecera.php")?>

<?php
session_start();
if ($_SESSION['userType'] !== 'alumno') {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vista de Alumno</title>
</head>
<body>
    <h1>Bienvenido, Alumno</h1>
    <p>Contenido exclusivo para alumnos.</p>
</body>
</html>

<?php include("template/pie.php")?>

<!--...............................................-->