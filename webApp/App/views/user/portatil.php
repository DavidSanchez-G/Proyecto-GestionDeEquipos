<?php
//inicias sesion
include("../../include/inicio_sesion.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PORTATIL</title>
    <link rel="stylesheet" href="../../../public/assets/css/styles.css">
</head>
<body>
<nav class="menu">
    <header class="menu-titulo">
        <button class="boton-menu" onclick="location.href='perfil.php'">PERFIL</button>
    </header>

    <button class="boton-menu" onclick="location.href='portatil.php'">PORTÁTILES</button>
    <button class="boton-menu" onclick="location.href='perifericos.php'">PERIFÉRICOS</button>
    <button class="boton-menu" onclick="location.href='incidencias.php'">CREAR TICKET</button>
    <button class="boton-menu" onclick="location.href='vista_incidencias.php'">VER TICKETS</button>
    <button class="boton-cerrar" onclick="location.href='../../controllers/cerrar_sesion.php'">CERRAR SESIÓN</button>
</nav>

<main class="contenido">
    <header class="cabecera">
        <h1>GESTIÓN DE PORTÁTILES</h1>

    </header>

    <section class="area-trabajo">
        <section class="tabla-contenedor">
            <?php
            // buscas en alumno su ordenador asociado
            $sql = "SELECT * FROM alumnos WHERE fk_idUsuario_alumno = '$idUsuario'";
            $result = mysqli_query($conn, $sql);
            $alumno = $result->fetch_assoc();
            // buscas el ordenador del alumno
            $result = mysqli_query($conn, "SELECT * FROM ordenadores WHERE idOrdenador = '{$alumno['fk_idOrdenador_alumno']}'");
            // muestra la tabla con infromacion del ordenador
            while ($row = $result->fetch_assoc()) {
                echo "<table class='tabla-portatil' aria-label='Datos del portátil'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th colspan='2'>PORTATIL</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                echo "<tr>";
                echo "<td class='campo'>Nº Serie</td>";
                echo "<td id='dato-serie'>". htmlspecialchars($row['num_serie']). "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td class='campo'>Marca</td>";
                echo "<td id='dato-marca'>". htmlspecialchars($row['marca']). "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td class='campo'>Modelo</td>";
                echo "<td id='dato-modelo'>". htmlspecialchars($row['modelo']). "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td class='campo'>Sistema Operativo</td>";
                echo "<td id='dato-so'>". htmlspecialchars($row['so']). "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td class='campo'>Estado</td>";
                echo "<td id='dato-estado'>". htmlspecialchars($row['estado']). "</td>";
                echo "</tr>";
                echo "<tr>";
                // muestra el aula y numero
                echo "<td class='campo'>Aula</td>";
                $aula = mysqli_query($conn, "SELECT * FROM aulas WHERE idAula = '{$alumno['fk_idAula_alumno']}'");
                $nombre_aula = mysqli_fetch_assoc($aula);
                echo "<td id='dato-aula'>". htmlspecialchars($nombre_aula['nombre_aula']). " ". htmlspecialchars($row['numero']). "</td>";
                echo "</tr>";
                echo "</tbody>";
                echo "</table>";
            }
            ?>
        </section>
    </section>
</main>
</body>
</html>