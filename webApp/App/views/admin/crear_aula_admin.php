<?php
//inicias sesion
include("../../include/inicio_sesion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Aulas</title>
    <link rel="stylesheet" href="../../../public/assets/css/styles.css">
</head>
<body>
<main class="contenido">
    <header class="cabecera">
        <h1>GESTIÓN DE EQUIPOS</h1>
        <a class="boton-soporte" href="gestion_admin.php">INICIO</a>
        <a class="boton-soporte" href="centros_admin.php">VER AULAS</a>
        <a class="boton-soporte" href="../../controllers/cerrar_sesion.php">CERRAR SESIÓN</a>
    </header>

    <section class="area-trabajo">
        <form action="../../controllers/crear_aula.php" method="POST" class="form-incidencia" aria-label="Formulario de ticket de incidencia">
            <table class="tabla-portatil" aria-label="Ticket de incidencia">
                <thead>
                <tr>
                    <th colspan="2">AÑADIR AULA</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="campo">AULA</td>
                    <td class="campo"><input type="text" placeholder="aula" name="aula" required></td>
                </tr>
                <tr>
                    <td class="campo">PLANTA</td>
                    <td class="campo">
                        <select name="planta" required>
                            <option value="">Seleccione una planta existente</option>
                            <?php
                            $aulas = mysqli_query($conn, "SELECT DISTINCT planta FROM aulas ORDER BY planta ASC");
                            if (mysqli_num_rows($aulas) > 0) {
                                while ($aula = mysqli_fetch_assoc($aulas)) {
                                    echo "<option value='" . $aula['planta'] . "'>" . $aula['planta'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td colspan="2" style="text-align:center;"><button class="btn-buscar" type="submit">AÑADIR AULA</button></td>
                </tr>
                </tbody>
            </table>
        </form>


    </section>
</main>
</body>
</html>
