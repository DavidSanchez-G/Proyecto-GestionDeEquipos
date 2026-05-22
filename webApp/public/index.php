<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campus Digital FP</title>
    <link rel="stylesheet" href="assets/css/index.css">
</head>
<body>
    <aside class="left-section">
        <header class="logo-container">
            <a href="https://moodle.campusdigitalfp.com">
            <img src="assets/img/LOGOS-CAMPUS-DIGITAL-FP-VERSION-COLOR-DEFINITIVO.png" alt="Logo Campus Digital" class="logo">
            </a>
        </header>
    </aside>
    <main class="login-container">
        <form class="login-form" method="POST" action="../App/controllers/control_login.php">
            <section class="input-group">
                <input type="text" name="username" placeholder="Usuario" required>
            </section>
            <section class="input-group">
                <input type="password" name="password" placeholder="Contraseña" required>
            </section>
            <button type="submit" class="btn">Entrar</button>
            <nav class="links">
                <a href="../App/views/reset_password.php">¿Olvidaste tu contraseña?</a>
            </nav>
            <?php
            // en caso de error con usuario o contraseña
            if (isset($_SESSION['error'])) {
                echo "<p style='color:red'>" . htmlspecialchars($_SESSION['error']) . "</p>";
                unset($_SESSION['error']); // Limpiar después de mostrar
                // en caso de exito al cambiar tu contraseña
            } elseif (isset($_SESSION['exito'])) {
                echo "<p style='color:green'>" . htmlspecialchars($_SESSION['exito']) . "</p>";
                unset($_SESSION['exito']); // Limpiar después de mostrar
            }
            // eliminas la sesion
            session_unset();
            session_destroy();
            ?>
        </form>
    </main>
</body>
</html>