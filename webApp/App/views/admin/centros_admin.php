<?php
//inicias sesion
include("../../include/inicio_sesion.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GESTION CENTROS</title>
    <link rel="stylesheet" href="../../../public/assets/css/styles.css">
</head>
<body>
<main class="contenido">
    <header class="cabecera">
        <h1>GESTIÓN DEL CENTRO</h1>
        <a class="boton-soporte" href="gestion_admin.php">INICIO</a>
        <a class="boton-soporte" href="crear_aula_admin.php">AÑADIR AULAS</a>
        <a class="boton-soporte" href="../../controllers/cerrar_sesion.php">CERRAR SESIÓN</a>
    </header>

    <section class="area-trabajo">
        <section class='tabla-contenedor'>
        <?php
        if (isset($_SESSION['error'])) {
            echo "<p>".$_SESSION['error']."</p>";
            unset($_SESSION['error']);
        }
        echo "<table class='tabla-portatil' aria-label='Aulas del centro'>";
        // en el encabezado de la tabla se indicara el tipo de periferico, raton, teclado, cargador, pantalla
        echo "<thead>";
        echo "<tr>";
        echo "<th colspan='3'>AULAS</th>";
        echo "</tr>";
        echo "</thead>";
        // se muestran los datos del periferico
        echo "<tbody>";
        $aulas = mysqli_query($conn,"SELECT * FROM aulas ORDER BY planta ASC, nombre_aula ASC");
        if (mysqli_num_rows($aulas) > 0) {
            while ($aula = mysqli_fetch_assoc($aulas)) {
                if (!empty($aula['nombre_aula'])) {
                    echo "<tr>";
                    echo "<td class='campo'>" . htmlspecialchars($aula['planta']) . "</td>";
                    echo "<td id='dato-serie'>" . htmlspecialchars($aula['nombre_aula']) . "</td>";
                    echo "<td class='campo' style='text-align:center;'><form action='../../controllers/control_eliminar.php' method='POST' style='text-align:center;'><button class='btn-eliminar' type='submit' name='aula' value='" . $aula['idAula'] . "'>ELIMINAR</button></form></td>";
                    echo "</tr>";
                }

            }
        }
        echo "</tbody>";
        echo "</table>";
        ?>
        </section>
    </section>

</main>


</body>
</html> 