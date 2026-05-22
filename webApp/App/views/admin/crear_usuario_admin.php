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
        <a class="boton-soporte" href="usuarios_admin.php">VER USUARIOS</a>
        <a class="boton-soporte" href="../../controllers/cerrar_sesion.php">CERRAR SESIÓN</a>
    </header>

    <section class="area-trabajo">
        <?php
        if (isset($_SESSION['error'])) {
            echo "<p>" . $_SESSION['error'] . "</p>";
            unset($_SESSION['error']);
        }
        ?>
        <form action="../../controllers/crear_usuario.php" method="POST" class="form-incidencia" aria-label="Formulario de ticket de incidencia">
            <table class="tabla-portatil" aria-label="Ticket de incidencia">
                <thead>
                <tr>
                    <th colspan="2">CREAR USUARIO</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class='campo'>ROL DE USUARIO</td>
                    <td class='campo'>
                        <select name="rol_usuario" required>
                            <option value="">Seleccione rol</option>
                            <option value="alumno">Alumno</option>
                            <option value="profesor">Profesor</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class='campo'>NOMBRE</td>
                    <td><input type="text" placeholder="nombre" name="nombre_usuario" required></td>
                </tr>
                <tr>
                    <td class='campo'>APELLIDOS</td>
                    <td><input type="text" placeholder="apellidos" name="apellido_usuario" required></td>
                </tr>
                <tr>
                    <td class='campo'>CORREO</td>
                    <td><input type="text" placeholder="correo" name="correo_usuario" required></td>
                </tr>
                <tr>
                    <td class='campo'>USUARIO</td>
                    <td><input type="text" placeholder="nombre de usuario" name="clave_usuario"></td>
                </tr>
                <tr>
                    <td class='campo'>CONTRASEÑA</td>
                    <td><input type="password" placeholder="contraseña" name="password_usuario" required></td>
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
                                    if (!empty($aula["nombre_aula"])) {
                                        echo "<option value='" . $aula['idAula'] . "'>" . $aula['nombre_aula'] . "</option>";
                                    }

                                }
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class='campo' colspan="2" style="text-align: center;"><button class="btn-buscar" type="submit">CREAR USUARIO</button></td>
                </tr>
                </tbody>
            </table>
        </form>
    </section>
</main>
</body>
</html>