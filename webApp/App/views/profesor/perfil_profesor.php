<?php
//inicias sesion
include("../../include/inicio_sesion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Portátiles</title>
    <link rel="stylesheet" href="../../../public/assets/css/styles.css">
</head>
<body>
<nav class="menu">
    <header class="menu-titulo">
        <button class="boton-menu" onclick="location.href='perfil_profesor.php'">PERFIL</button>
    </header>

    <button class="boton-menu" onclick="location.href='ver_equipos.php'">VER EQUIPOS</button>
    <button class="boton-menu" onclick="location.href='ver_incidencias.php'">VER INCIDENCIAS</button>
    <button class="boton-menu" onclick="location.href='ver_usuarios.php'">VER ALUMNOS</button>
    <button class="boton-cerrar" onclick="location.href='../../controllers/cerrar_sesion.php'">CERRAR SESIÓN</button>
</nav>

<main class="contenido">
    <header class="cabecera">
        <h1>GESTIÓN DE PERFIL PROFESOR</h1>

    </header>

    <section class="area-trabajo">
        <?php
        //informacion de usuario
        $sql = "SELECT * FROM usuario WHERE idUsuario = '$idUsuario'";
        $result = mysqli_query($conn, $sql);
        $user = $result->fetch_assoc();
        // informacion de alumno
        $sql = "SELECT * FROM profesor WHERE fk_idUsuario = '$idUsuario'";
        $result = mysqli_query($conn, $sql);
        $profesor = $result->fetch_assoc();
        // imprimes tabla con la informacion del alumno y su usuario
        echo "<table class='tabla-portatil'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th class='campo' colspan='3'>{$user['usuario']}</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<th class='campo'>{$profesor['nombre']} {$profesor['apellidos']}</th>";
        echo "<th class='campo'>{$profesor['email']}</th>";
        echo "</tr>";
        echo "<tr>";
        //boton para cambiar de contraseña en reset_password.php
        echo "<th colspan='3'>";
        echo "<button class='boton-password' onclick=\"location.href='../reset_password.php'\">Cambiar contraseña</button>";
        echo "</th>";
        echo "</table>";
        ?>
        <img class="logo-area" src="../../../public/assets/img/LOGOS-CAMPUS-DIGITAL-FP-VERSION-COLOR-DEFINITIVO.png" alt="logo">
    </section>
</main>
</body>
</html>