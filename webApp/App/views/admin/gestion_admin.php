<?php
//inicias sesion
include("../../include/inicio_sesion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index de Admin</title>
    <link rel="stylesheet" href="../../../public/assets/css/styles.css">
</head>
<body>
    <main class="contenido">
        <header class="cabecera">
            <h1>ADMINISTRADOR</h1>
            <a href="../../controllers/cerrar_sesion.php" class="boton-soporte">CERRAR SESIÓN</a>
        </header>

        <section class="area-trabajo">
            <section class="filtros" aria-label="Filtros">
                <h2 class="titulo-filtros">FILTROS</h2>
                <section class="filtros-grid">
                    <article class="filtro-card">
                        <header class="filtro-top">
                            <span class="filtro-titulo" ><button class="filtro-icono" aria-hidden="true" onclick="location.href='centros_admin.php'">CENTROS</button></span>

                        </header>
                    </article>

                    <article class="filtro-card">
                        <header class="filtro-top">
                            <span class="filtro-titulo"><button class="filtro-icono" aria-hidden="true" onclick="location.href='usuarios_admin.php'">USUARIOS</button></span>

                        </header>
                    </article>

                    <article class="filtro-card">
                        <header class="filtro-top">
                            <span class="filtro-titulo"><button class="filtro-icono" aria-hidden="true" onclick="location.href='portatiles_admin.php'">EQUIPOS</button></span>

                        </header>
                    </article>

                    <article class="filtro-card">
                        <header class="filtro-top">
                            <span class="filtro-titulo"><button class="filtro-icono" aria-hidden="true" onclick="location.href='incidencias_admin.php'">INCIDENCIAS</button></span>

                        </header>
                    </article>
                </section>
            </section>
            <article class="filtro-card">
                <header class="filtro-top">
                    <span class="filtro-titulo"><button class="filtro-icono" aria-hidden="true" onclick="location.href='../reset_password.php'">CAMBIAR CONTRASEÑA</button></span>

                </header>
            </article>
        </section>
    </main>

</body>
</html>