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
<nav class="menu">
    <header class="menu-titulo">
        <button class="boton-menu" onclick="location.href='perfil_profesor.php'">PERFIL</button>
    </header>

    <button class="boton-menu" onclick="location.href='ver_equipos.php'">VER EQUIPOS</button>
    <button class="boton-menu" onclick="location.href='ver_incidencias.php'">VER INCIDENCIAS</button>
    <button class="boton-menu" onclick="location.href='ver_usuarios.php'">VER ALUMNOS</button>
    <button class="boton-cerrar" onclick="location.href='../../controllers/cerrar_sesion.php'">CERRAR SESIÓN</button>
</nav>

<main class="contenido">
    <header class="cabecera">
        <h1>VER ALUMNOS</h1>

    </header>

    <section class="area-trabajo">
        <form class="buscador" action="ver_usuarios.php" method="GET" role="search" aria-label="Buscar por correo">
            <table>
                <tr>
                    <td>Nombre</td>
                    <td>Email</td>
                    <td>Aula</td>
                </tr>
                <tr>
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
                            echo "<option value='" . $fila['idAula'] . "'>" . $fila['nombre_aula'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No hay aulas registradas</option>";
                    }
                    ?>
                    <td><button class="btn-buscar" type="submit" name="rol" value="alumno">APLICAR</button></td>
                </tr>
            </table>
        </form>

        <section class="listado-contenedor" aria-labelledby="titulo-listado">
            <h2 id="titulo-listado" class="sr-only">Listado de usuarios</h2>

            <section class="listado-wrap">
                <?php
                if (isset($_GET['rol'])) {
                    include("../../controllers/mostrar_usuarios.php");
                }
                ?>
            </section>
        </section>

    </section>
</main>
</body>
</html>