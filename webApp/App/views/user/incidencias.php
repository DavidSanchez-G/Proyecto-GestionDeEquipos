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
            <form action="../../controllers/crear_mantenimiento.php" method="POST" class="form-incidencia" aria-label="Formulario de ticket de incidencia">
                <table class="tabla-portatil" aria-label="Ticket de incidencia">
                    <thead>
                        <tr>
                            <th colspan="2">TICKET</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    // si no se ha seleccionado que quieres enviar
                    if (!isset($_SESSION['tipoPeticion'])) {
                        echo "<tr>";
                        echo "<td class='campo'>Tipo</td>";
                        echo "<td><select name='tipo' required >"; // selector
                        echo "<option value=''>Selecciona tipo</option>";
                        echo "<option value='asignacion'>Pedir equipo</option>"; // pedir un equipo
                        echo "<option value='reporte'>Reportar incidencia</option>"; // hacer un reporte
                        echo "</select>";
                        echo "</td>";
                        echo "</tr>";
                        // si has pedido un equipo
                    } elseif ($_SESSION['tipoPeticion'] == 'asignacion') {
                        unset($_SESSION['tipoPeticion']); // limpias la peticion
                        echo "<tr>";
                        echo "<td class='campo'>Descripcion</td>";
                        // una descripcion de la peticion
                        echo "<td><textarea name='peticion' required placeholder='Describe tu petición'></textarea></td>";
                        echo "</tr>";
                        // si vas ha hacer un reporte de un equipo
                    } elseif ($_SESSION['tipoPeticion'] == 'reporte') {
                        unset($_SESSION['tipoPeticion']); //limpias la peticion
                        echo "<tr>";
                        echo "<td class='campo'>Equipo</td>";
                        echo "<td ><select name = 'equipo' required>";
                        // para seleccionar tu equipo
                        echo "<option value=''>Selecciona tu equipo</option>";
                        // buscas el alumno
                        $result = mysqli_query($conn, "SELECT * FROM alumnos WHERE fk_idUsuario_alumno = '$idUsuario'");
                        $alumno = mysqli_fetch_array($result);
                        // buscas los ordenadores del alumno
                        $result = mysqli_query($conn, "SELECT * FROM ordenadores WHERE idOrdenador = '{$alumno['fk_idOrdenador_alumno']}'");
                        // te muestra tus ordenadores
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='{$row['idOrdenador']}'>Ordenador-" . htmlspecialchars($row['modelo']) . "</option>";
                        }
                        // buscas los perifericos del alumno
                        $result = mysqli_query($conn, "SELECT * FROM perifericos WHERE fk_idAlumno = '{$alumno['idAlumno']}'");
                        // te muestra tus perfiericos
                        while ($row = $result->fetch_assoc()) {
                            $tipo_periferico = mysqli_query($conn, "SELECT * FROM tipo_periferico WHERE id_tipo_periferico = '{$row['fk_id_tipo_periferico']}'");
                            $tipoPeriferico = mysqli_fetch_array($tipo_periferico);
                            echo "<option value='{$row['idPerifericos']}'>" . htmlspecialchars($tipoPeriferico['tipo']) . "-" . htmlspecialchars($row['modelo']). "</option>";
                        }
                        echo "</select>";
                        echo "</td>";
                        echo "</tr>";
                        echo "<tr>";
                            echo "<td class='campo'>Incidencia</td>"; // texto para descripcion
                            echo "<td><textarea name = 'descripcion' rows = '3' required placeholder = 'Describe la incidencia'></textarea ></td>";
                        echo "</tr>";
                    }
                    ?>
                    </tbody>
                </table>
                <section class="acciones-form">
                    <button type="submit" class="boton-enviar">ENVIAR</button>
                </section>
                <?php
                // comprueba sI has enviado una solicitud y te indica el exito
                if (isset($_SESSION['exito'])) {
                    echo "<p>";
                    echo $_SESSION['exito'];
                    echo "</p>";
                    unset($_SESSION['exito']);
                }
                ?>
            </form>
        </section>
    </section>
</main>

<section id="ok" class="aviso-exito" aria-live="polite" aria-label="Incidencia enviada correctamente">
    <section class="aviso-contenido">
        <p>Incidencia reportada correctamente</p>
        <a href="#" class="cerrar-aviso" role="button" aria-label="Cerrar aviso">Cerrar</a>
    </section>
</section>

</body>
</html>