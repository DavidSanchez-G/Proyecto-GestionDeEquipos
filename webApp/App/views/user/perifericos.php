<?php
//inicias sesion
include("../../include/inicio_sesion.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PERIFERICOS</title>
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
            <h1>GESTIÓN DE PERIFERICOS</h1>

        </header>

        <section class="area-trabajo">

                <?php
                // guardas datos del alumno
                $sql = "SELECT * FROM alumnos WHERE fk_idUsuario_alumno = '$idUsuario'";
                $result = mysqli_query($conn, $sql);
                $alumno = $result->fetch_assoc();
                //buscas en perifericos
                $result = mysqli_query($conn, "SELECT * FROM perifericos WHERE fk_idAlumno = '{$alumno['idAlumno']}'");
                // este bucle crea una tabla para cada periferico que tenga el alumno
                while ($row = $result->fetch_assoc()) {
                    echo "<section class='tabla-contenedor'>";
                    echo "<table class='tabla-portatil' aria-label='Datos del portátil'>";
                    // en el encabezado de la tabla se indicara el tipo de periferico, raton, teclado, cargador, pantalla
                    echo "<thead>";
                    echo "<tr>";
                    $verPeriferico = mysqli_query($conn,"SELECT * FROM tipo_periferico WHERE id_tipo_periferico = '{$row['fk_id_tipo_periferico']}'");
                    $tipoPeriferico = $verPeriferico->fetch_assoc();
                    echo "<th colspan='2'>". htmlspecialchars($tipoPeriferico['tipo']). "</th>";
                    echo "</tr>";
                    echo "</thead>";
                    // se muestran los datos del periferico
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
                    echo "<td class='campo'>Estado</td>";
                    echo "<td id='dato-estado'>". htmlspecialchars($row['estado']). "</td>";
                    echo "</tr>";
                    echo "<tr>";
                    // se muestra el aula del periferico
                    echo "<td class='campo'>Aula</td>";
                    $aula = mysqli_query($conn, "SELECT * FROM aulas WHERE idAula = '{$alumno['fk_idAula_alumno']}'");
                    $nombre_aula = mysqli_fetch_assoc($aula);
                    echo "<td id='dato-aula'>". htmlspecialchars($nombre_aula['nombre_aula']). " ". htmlspecialchars($row['numero']). "</td>";
                    echo "</tr>";
                    echo "</tbody>";
                    echo "</table>";
                    echo "</section>";
                }

                ?>

        </section>
    </main>
</body>
</html>