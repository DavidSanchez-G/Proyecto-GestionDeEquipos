<?php
session_start();
include("../include/conexion.php"); // archivo que contiene la conexión a la base de datos
if (!isset($_SESSION['usuario'])) { //redirige al login si sesion no tiene usuario
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header("Location: ../../public/index.php");
    exit();
}
$idUsuario = $_SESSION['usuario'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // guardas las contraseñas
    $clave = $_POST['clave'];
    $nueva_password = $_POST['nueva_password'];
    $repetir_password = $_POST['repetir_password'];

    //buscas tabla usuario
    $result = mysqli_query($conn, "SELECT * FROM usuario WHERE idUsuario = '$idUsuario'");
    $row = mysqli_fetch_assoc($result);

    // en caso de que la contraseña es incorrecta
    if ($clave != $row['password']) {
        $_SESSION['error'] = "La contraseña es incorrecta"; // variable global
        header("Location: ../views/reset_password.php");
        exit;
        // si contraseñas nuevas no coinciden
    } elseif ($nueva_password != $repetir_password) {
        $_SESSION['error'] = "Las contraseñas no coinciden"; //variable global
        header("Location: ../views/reset_password.php");
        exit;
    }
    // Hashear la contraseña, encriptacion
    $hash = password_hash($nueva_password, PASSWORD_DEFAULT);

    // Cambia en la base de datos la contraseña encriptada
    $result = $conn->prepare("UPDATE usuario SET password = ? WHERE idUsuario = ?");
    $result->bind_param("si",$hash, $idUsuario);

    // si tiene exito en cambiarla
    if ($result->execute()) {
        $_SESSION['exito'] = "Contraseña cambiada correctamente";
        header("Location: ../../public/index.php");
        // si falla vuelve  aintentarlo
    } else {
        $_SESSION['exito'] = "Vuelva a intentarlo";
        header("Location: ../views/reset_password.php");
    }
    exit;
}