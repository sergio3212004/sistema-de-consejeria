<?php
$usuarios = [
    'docentes' => [
        ['id' => 1, 'nombre' => 'Juan', 'apellido' => 'Perez', 'correo' => 'docente1@unitru.edu.pe', 'contrasena' => 'docente123'],
        ['id' => 2, 'nombre' => 'Ana', 'apellido' => 'Lopez', 'correo' => 'docente2@unitru.edu.pe', 'contrasena' => 'docente456']
    ],
    'alumnos' => [
        ['id' => 1, 'nombre' => 'Maria', 'apellido' => 'Gomez', 'correo' => 'alumno1@unitru.edu.pe', 'contrasena' => 'alumno123'],
        ['id' => 2, 'nombre' => 'Carlos', 'apellido' => 'Diaz', 'correo' => 'alumno2@unitru.edu.pe', 'contrasena' => 'alumno456']
    ]
];

$citas = [];

$horarios = [
    1 => [], // Horarios del docente con id 1
    2 => []  // Horarios del docente con id 2
];
?>

<!--...............................................-->