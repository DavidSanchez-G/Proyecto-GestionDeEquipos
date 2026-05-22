<?php
//inicias sesion
include("../../include/inicio_sesion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Equipos</title>
    <link rel="stylesheet" href="../../../public/assets/css/styles.css">
</head>
<body>
<main class="contenido">
    <header class="cabecera">
        <h1>ASIGNAR EQUIPOS</h1>
        <a class="boton-soporte" href="gestion_admin.php">INICIO</a>
        <a class="boton-soporte" href="portatiles_admin.php">VER EQUIPOS</a>
        <a class="boton-soporte" href="../../controllers/cerrar_sesion.php">CERRAR SESIÓN</a>
    </header>

    <section class="area-trabajo">
        <?php
        echo "<table class='tabla-listado' aria-describedby='titulo-listado'>";
        echo "<thead>
        <tr>
        <th scope='col'>Nombre y apellidos</th>
        <th scope='col'>Email</th>";
        echo "<th scope='col'>Aula</th>";
        echo "<th scope='col'></th>";
        echo "</tr></thead>";
        echo "<tbody>";
        if (isset($_POST['ordenador'])) {
            $ordenador = $_POST['ordenador'];
            $ordenadores = mysqli_query($conn, "SELECT * FROM ordenadores WHERE idOrdenador ='". $ordenador ."'");
            while ($ordenador = mysqli_fetch_array($ordenadores)) {
                $idAula = $ordenador['fk_idAula'];
                $idOrdenador = $ordenador['idOrdenador'];
            }
        }
        if (isset($_POST['periferico'])) {
            $periferico = $_POST['periferico'];
            $perifericos = mysqli_query($conn, "SELECT * FROM perifericos WHERE idPeriferico ='". $periferico ."'");
            while ($periferico = mysqli_fetch_array($perifericos)) {
                $idAula = $periferico['fk_idAula'];
                $idPeriferico = $periferico['idPeriferico'];
            }
        }
        $sql = mysqli_query($conn, "SELECT * FROM alumnos WHERE fk_idAula_alumno= '$idAula'");
        if (mysqli_num_rows($sql) > 0) {
            while ($alumno = mysqli_fetch_array($sql)) {
                echo "<tr>";
                echo "<td>" . $alumno['nombre'] . " ". $alumno['apellidos']. "</td>";
                echo "<td>" . $alumno['email'] . "</td>";
                $sql_aulas = mysqli_query($conn, "SELECT * FROM aulas WHERE idAula ='". $alumno['fk_idAula_alumno']. "'");
                if (mysqli_num_rows($sql_aulas) > 0) {
                    while ($aula = mysqli_fetch_assoc($sql_aulas)) {
                        echo "<td class='campo'>". $aula['nombre_aula']. "</td>";
                    }
                }
                echo "<form action='../../controllers/control_asignar.php' method='POST'>";
                if (isset($_POST['ordenador'])) {
                    echo "<input type='hidden' name='ordenador' value='$idOrdenador'>";
                } else {
                    echo "<input type='hidden' name='periferico' value='$idPeriferico'>";
                }

                echo "<td class='campo'><button class='btn-eliminar' name='alumno' value='". $alumno['idAlumno']. "'>ASIGNAR</button></form></td>";
                echo "</tr>";
            }
        }
        echo "</tbody></table>";
        ?>

    </section>
</main>
</body>
</html>
