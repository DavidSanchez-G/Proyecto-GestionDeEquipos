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
        <h1>GESTIÓN DE EQUIPOS</h1>
        <a class="boton-soporte" href="gestion_admin.php">INICIO</a>
        <a class="boton-soporte" href="portatiles_admin.php">VER EQUIPOS</a>
        <a class="boton-soporte" href="../../controllers/cerrar_sesion.php">CERRAR SESIÓN</a>
    </header>

    <section class="area-trabajo">
        <?php
        if (isset($_SESSION['error'])) {
            echo "<p>". $_SESSION['error']. "</p>";
            unset($_SESSION['error']);
        }
        ?>
        <form action="../../controllers/crear_equipo.php" method="POST" class="form-incidencia" aria-label="Formulario de ticket de incidencia">
            <table class="tabla-portatil" aria-label="Ticket de incidencia">
                <thead>
                <tr>
                    <th colspan="2">AÑADIR EQUIPO</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class='campo'>TIPO</td>
                    <td class='campo'>
                        <select name="tipo" required>
                            <option value="">Seleccione...</option>
                            <option value="ordenador">Ordenador</option>
                            <?php
                            $sql = mysqli_query($conn, "SELECT * FROM tipo_periferico");
                            if (mysqli_num_rows($sql) > 0) {
                                while ($row = mysqli_fetch_assoc($sql)) {
                                    echo "<option value='" . $row['id_tipo_periferico'] . "'>" . $row['tipo'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class='campo'>MARCA</td>
                    <td><input type="text" placeholder="marca" name="marca" required></td>
                </tr>
                <tr>
                    <td class='campo'>MODELO</td>
                    <td><input type="text" placeholder="modelo" name="modelo" required></td>
                </tr>
                <tr>
                    <td class='campo'>Nº de SERIE</td>
                    <td><input type="text" placeholder="nº de serie" name="num_serie" required></td>
                </tr>
                <tr>
                    <td class='campo'>SISTEMA OPERATIVO</td>
                    <td><input type="text" placeholder="sistema operativo" name="so"></td>
                </tr>
                <tr>
                    <td class='campo'>AULA</td>
                    <td>
                        <select name="aula" required>
                            <option value="">Seleccione un aula</option>
                        <?php
                        $aulas = mysqli_query($conn, "SELECT * FROM aulas ORDER BY nombre_aula ASC");
                        if (mysqli_num_rows($aulas) > 0) {
                            while ($aula = mysqli_fetch_assoc($aulas)) {
                                if (isset($aula['nombre_aula'])) {
                                    echo "<option value='" . $aula['idAula'] . "'>" . $aula['nombre_aula'] . "</option>";
                                }

                            }
                        }
                        ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class='campo'>ESTADO</td>
                    <td><select name="estado">
                            <option value="">Seleccione el estado</option>
                            <option value="operativo">Operativo</option>
                            <option value="averiado">Averiado</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class='campo' colspan="2" style="text-align: center;"><button class="btn-buscar" type="submit">AÑADIR EQUIPO</button></td>
                </tr>
                </tbody>
            </table>
        </form>
    </section>
</main>
</body>
</html>