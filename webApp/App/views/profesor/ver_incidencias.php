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
        <h1>VER INCIDENCIAS</h1>

    </header>

    <section class="area-trabajo">
        <form class="buscador" action="ver_incidencias.php" method="GET" role="search" aria-label="Filtrar tickets">
            <table>
                <tr>
                    <td>Numero de ticket</td>
                    <td>Fecha</td>
                    <td>Tipo</td>
                    <td>Estado</td>
                </tr>
                <tr>
                    <td><input class="buscar-correo" type="text" name="num_ticket" placeholder="numero de ticket"></td>
                    <td><input class="buscar-correo" name="fecha" class="input-buscar" type="date"></td>
                    <td><select name="tipo">
                            <option value="">Seleccione una opción</option>
                            <option value="asignacion">Asignación de equipo</option>
                            <option value="incidencia">Reporte de incidencia</option>
                        </select></td>
                    <td><select name="estado">
                            <option value="">Seleccione una opción</option>
                            <option value="solucionada">Solucionada</option>
                            <option value="pendiente">Pendiente</option>
                        </select></td>
                    <td><button class="btn-buscar" type="submit" name="filtro" value="filtrar">APLICAR</button></td>
                </tr>
            </table>
        </form>

        <section class="listado-contenedor" aria-labelledby="titulo-listado">
            <h2 id="titulo-listado" class="sr-only">Listado de incidencias</h2>

            <section class="listado-wrap">
                <?php
                if (isset($_GET["filtro"])) {
                    include("../../controllers/mostrar_incidencias.php");
                }
                ?>

            </section>
        </section>

    </section>
</main>
</body>
</html>