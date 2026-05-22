<?php
//inicias sesion
session_start();
include("../include/conexion.php"); // conexion

// compruebas si se ha iniciado sesion con el usuario
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../public/index.php");
    exit();
} else {
    $idUsuario = $_SESSION['usuario'];
    $rolUsuario = $_SESSION['rol'];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña</title>
    <link rel="stylesheet" href="../../public/assets/css/reset_password_nuevo.css">
</head>
<body>
    <header class="titulo">
        <img src="../../public/assets/img/logo.png" alt="Logo" class="logo">
        <h1>Restablecer Contraseña</h1>
    </header>

    <main class="formulario">
        <form method="POST" action="../controllers/control_password.php">
            <section class="campo">
                <label for="clave">Contraseña actual</label>
                <input type="password" id="clave" name="clave" placeholder="Escribe tu contraseña" required>
            </section>
            <section class="campo">
                <label for="nueva-password">Nueva Contraseña:</label>
                <input type="password" id="nueva-password" name="nueva_password" placeholder="Escribe tu nueva contraseña" required>
            </section>

            <section class="campo">
                <label for="repetir-password">Repetir Contraseña:</label>
                <input type="password" id="repetir-password" name="repetir_password" placeholder="Repite tu contraseña" required>
            </section>

            <button type="submit" class="boton">Restablecer Contraseña</button>

            <nav class="enlace">
                <?php
                if ($rolUsuario == "alumno") {
                    echo "<a href='user/perfil.php'>Volver a perfil</a>";
                } else if ($rolUsuario == "profesor") {
                    echo "<a href='profesor/perfil_profesor.php'>Volver a perfil</a>";
                } else {
                    echo "<a href='admin/gestion_admin.php'>Volver a inicio</a>";
                }

                ?>
                <br><br>
                <a href="../controllers/cerrar_sesion.php" class="boton-soporte">Cerrar Sesión</a>
            </nav>
        </form>
        <?php
        // en caso de error con contraseña
        if (isset($_SESSION['error'])) {
            echo "<p style='color:red'>" . htmlspecialchars($_SESSION['error']) . "</p>";
            unset($_SESSION['error']); // Limpiar después de mostrar
            // en caso de exito al cambiar tu contraseña
        } elseif (isset($_SESSION['exito'])) {
            echo "<p style='color:green'>" . htmlspecialchars($_SESSION['exito']) . "</p>";
            unset($_SESSION['exito']); // Limpiar después de mostrar
        }
        ?>
    </main>
</body>
</html>