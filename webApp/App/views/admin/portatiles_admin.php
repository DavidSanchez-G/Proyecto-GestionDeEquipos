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
            <a class="boton-soporte" href="crear_equipo_admin.php">AÑADIR EQUIPO</a>
            <a class="boton-soporte" href="../../controllers/cerrar_sesion.php">CERRAR SESIÓN</a>
        </header>

        <section class="area-trabajo">
            <form method="GET" role="filtrar" aria-label="Filtros de equipo" action="portatiles_admin.php">
                <table>
                    <tr>
                        <td>Aula</td>
                        <td>Equipos</td>
                        <td>Estado</td>
                        <td>Nº de equipo</td>
                        <td>Nº de serie</td>
                        <td>Marca</td>
                        <td>Modelo</td>
                        <td>Sistema Operativo</td>
                        <td>Alumnos</td>
                        <td></td>
                    </tr>
                    <tr>
                <td><select name="aula">
                    <?php
                    echo "<option value=''>Selecciona aula</option>";
                    $sql = "SELECT * FROM aulas ORDER BY nombre_aula ASC";
                    $aulas = mysqli_query($conn, $sql);
                    // opciones del select con aulas
                    if (mysqli_num_rows($aulas) > 0) {
                        while ($row = mysqli_fetch_assoc($aulas)) {
                            if (!empty($row['nombre_aula'])) {
                                echo "<option value='" . $row['idAula'] . "'>" . $row['nombre_aula'] . "</option>";
                            }
                        }
                    } else {
                        echo "<option value=''>No se encontraron aulas</option>";
                    }
                    ?>
                    </select></td>

                <td><select name="tipo">
                    <?php
                    echo "<option value=''>Seleccionar Tipo</option>";
                    echo "<option value ='ordenador'>Ordenador</option>";
                    $sql = "SELECT * FROM tipo_periferico ORDER BY tipo ASC";
                    $tipo_periferico = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($tipo_periferico) > 0) {
                        while ($row = mysqli_fetch_assoc($tipo_periferico)) {
                            echo "<option value='" . $row['id_tipo_periferico'] . "'>" . $row['tipo'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No se encontraron perifericos</option>";
                    }
                    ?>
                </select></td>
                <td><select name="estado">
                        <?php
                        echo "<option value=''>Seleccionar estado</option>";
                        echo "<option value ='operativo'>Operativo</option>";
                        echo "<option value ='averiado'>Averiado</option>";
                        ?>
                </td>
                <td>
                    <input type='text' name ='numero_equipo' placeholder='numero'>
                </td>
                <td>
                    <input type='text' name ='numero_serie' placeholder='nº serie'>
                </td>
                <td>

                    <input type='text' name ='marca' placeholder='marca'>
                </td>
                <td>
                    <input type='text' name ='modelo' placeholder='modelo'>
                </td>
                <td>
                    <input type='text' name ='so' placeholder='sistema operativo'>
                </td>
                <td>
                    <input type='text' name ='nombre' placeholder='nombre'><br>
                    <input type='text' name ='apellido' placeholder='apellidos'>
                </td>
                <td><button class="btn-buscar" type="submit" name="filtro" value="filtrar">APLICAR</button></td>
                </tr>
                </table>
            </form>

            <section class="listado-contenedor" aria-labelledby="titulo-listado">
                <h2 id="titulo-listado" class="sr-only">Listado de equipos</h2>

                <section class="listado-wrap">
                    <?php
                    if (isset($_SESSION['exito'])) {
                        echo "<p>". $_SESSION['exito']. "</p>";
                        unset($_SESSION['exito']);
                    }
                    if (isset($_GET['filtro'])) {
                        include("../../controllers/mostrar_equipos.php");
                    }
                    ?>
                </section>
            </section>

        </section>
    </main>
</body>
</html>