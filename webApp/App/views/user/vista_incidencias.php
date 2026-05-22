<?php
//inicias sesion
include("../../include/inicio_sesion.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RATON</title>
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
        <h1>GESTIÓN DE INCIDENCIAS</h1>

    </header>

    <section class="area-trabajo">
        <section class="tabla-contenedor">
            <table class="tabla-portatil tabla-incidencias" aria-label="Listado de incidencias">
                <thead>
                    <tr>
                        <th colspan="7">INCIDENCIAS</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                // buscas el alumno
                $result = mysqli_query($conn,"SELECT * FROM alumnos WHERE fk_idUsuario_alumno = '$idUsuario'");
                $row = mysqli_fetch_array($result);
                // buscas sus incidencias, reportes, peticiones
                $result = mysqli_query($conn,"SELECT * FROM mantenimiento WHERE fk_idAlumno = '{$row['idAlumno']}'");
                // imprime las filas de la tabla de incidencias
                while ($row = mysqli_fetch_array($result)) {
                    // filtra por solicitud no atendida
                    if ($row['estado'] == 'pendiente') {
                        // imprime numero de ticket, fecha y estado
                        echo "<tr>";
                        echo "<td class='indice'>" . htmlspecialchars($row['num_ticket']) . "</td>";
                        echo "<td id='inc-1' data-key='incidencia-1'>" . htmlspecialchars($row['fecha']) . "</td>";
                        echo "<td id='inc-1' data-key='incidencia-1'>" . htmlspecialchars($row['estado']) . "</td>";
                        echo "<td id='inc-1' colspan='3' data-key='incidencia-1'>" . htmlspecialchars($row['descripcion']) . "</td>";
                        // si es un reporte de un ordenador
                        if (isset($row['fk_idOrdenador'])) {
                            $sql_pc = mysqli_query($conn,"SELECT * FROM ordenadores WHERE idOrdenador = '{$row['fk_idOrdenador']}'");
                            $row_pc = mysqli_fetch_array($sql_pc);
                            echo "<td class='inc-1'>Ordenador - ". htmlspecialchars($row_pc['modelo']). "</td>";
                            //si es un reporte de un periferico
                        } elseif (isset($row['fk_idPeriferico'])) {
                            $sql_per = mysqli_query($conn,"SELECT * FROM perifericos WHERE idPerifericos = '{$row['fk_idPeriferico']}'");
                            $row_per = mysqli_fetch_array($sql_per);
                            $sql_tipoPer = mysqli_query($conn,"SELECT * FROM tipo_periferico WHERE id_tipo_periferico = '{$row_per['fk_id_tipo_periferico']}'");
                            $row_tipoPer = mysqli_fetch_array($sql_tipoPer);
                            echo "<td class='inc-1'>". htmlspecialchars($row_tipoPer['tipo']). " - ". htmlspecialchars($row_per['modelo']). "</td>";
                            //si es una solicitud de equipo no muestra equipos
                        } else {
                            echo "<td class='inc-1'></td>";
                        }
                        echo "</tr>";
                    }
                }
                ?>
                </tbody>
            </table>
        </section>
    </section>
</main>
</body>
</html>