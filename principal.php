<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<?php include("template/cabecera.php")?>

</br></br></br>

<style>
    body {
        background-image: url('img/UNT1.jpg'); /* Ruta de la imagen de fondo */
        background-size: cover; /* Ajusta la imagen para que cubra toda la pantalla */
        background-position: center; /* Centra la imagen de fondo */
        background-repeat: no-repeat; /* Evita que la imagen se repita */
        height: 100vh; /* Asegura que la imagen cubra toda la altura de la ventana */
        margin: 0; /* Elimina margen por defecto del body */
    }
    .lead {
        font-size: 1.8rem; /* Ajustar valor para agrandar el texto */
        text-align: justify; /* Alinea el texto */
        font-weight: bold; /* Texto en negrita */
    }
    .jumbotron {
        margin: auto; /* Centra contenido horizontalmente */
        width: 90%; /* Ajusta ancho según necesidades */
        padding: 65px; /* Ajusta relleno según necesidades */
        background-color: rgba(255, 255, 255, 0.7); /* Fondo blanco con transparencia */
        border-radius: 10px; /* Bordes redondeados */
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Sombra */
    }
    .user-profile {
        text-align: center;
        margin-top: 20px;
    }
    .user-profile img {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
    }
    .user-profile h3, .user-profile p {
        margin: 10px 0;
    }
</style>

<div class="jumbotron">
    <h1 class="display-1">Página de Consejería</h1>
    <p class="lead">En esta página podrás realizar la reservación de una consejería para preguntar sobre temas 
                    de tu interés y/o datos que no se lograron entender completamente en la hora de clase.
    </p>
    <hr class="my-4">
    <h2>Reglas de Uso:</h2>
    <ol>
        <li>Los profesores, con sus usuarios, van a subir los horarios en los que estarán disponibles para la consejería.</li>
        <li>Los alumnos verifican si necesitan una consejería con ese docente y la solicitan en base al horario que el docente ha puesto en el sistema.</li>
        <li>El docente valida si el estudiante pertenece a su curso; si es así, aprueba la solicitud, de lo contrario, la rechaza.</li>
    </ol>
</div>

<?php include("template/pie.php")?>