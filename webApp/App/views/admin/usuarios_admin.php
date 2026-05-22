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
    <main class="contenido">
        <header class="cabecera">
            <h1>GESTIÓN DE USUARIOS</h1>
            <a class="boton-soporte" href="gestion_admin.php">INICIO</a>
            <a class="boton-soporte" href="crear_usuario_admin.php">CREAR USUARIO</a>
            <a class="boton-soporte" href="../../controllers/cerrar_sesion.php">CERRAR SESIÓN</a>
        </header>

        <section class="area-trabajo">
            <form class="buscador" action="usuarios_admin.php" method="GET" role="search" aria-label="Buscar por correo">
                <table>
                    <tr>
                        <td>Rol de usuario</td>
                        <td>Nombre</td>
                        <td>Email</td>
                        <td>Aula</td>
                    </tr>
                    <tr>
                        <td><select name="rol" required>
                                <option value="alumno">Alumno</option>
                                <option value="profesor">Profesor</option>

                            </select></td>
                        <td><input class="buscar-correo" name="nombre" class="input-buscar" type="text" placeholder="Nombre"><br>
                            <input class="buscar-correo" type="text" name="apellidos" placeholder="Apellidos"><br>
                        </td>

                        <td><input type="email" class="buscar-correo" name="email" placeholder="correo@campusdigitalfp.com"></td>
                        <?php
                        echo "<td><select name='aula'>";
                        echo "<option value=''>Seleccione aula</option>";
                        $sql = mysqli_query($conn, "SELECT DISTINCT nombre_aula FROM aulas ORDER BY nombre_aula ASC");
                        if (mysqli_num_rows($sql) > 0) {
                            while ($fila = mysqli_fetch_array($sql)) {
                                if (!empty($fila['nombre_aula'])) {
                                    echo "<option value='" . $fila['idAula'] . "'>" . $fila['nombre_aula'] . "</option>";
                                }
                            }
                        } else {
                            echo "<option value=''>No hay aulas registradas</option>";
                        }
                        ?>
                        <td><button class="btn-buscar" type="submit" name="filtro" value="filtrar">APLICAR</button></td>
                    </tr>
                </table>
            </form>

            <section class="listado-contenedor" aria-labelledby="titulo-listado">
                <h2 id="titulo-listado" class="sr-only">Listado de usuarios</h2>

                <section class="listado-wrap">
                    <?php
                    if (isset($_GET['filtro'])) {
                        include("../../controllers/mostrar_usuarios.php");
                    }
                    ?>

                </section>
            </section>

        </section>
    </main>
</body>
</html>