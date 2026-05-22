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

$aula = $_POST['aula'];
$planta = $_POST['planta'];
$sql = mysqli_query($conn, "INSERT INTO aulas (nombre_aula, planta, centro) VALUES ('$aula', '$planta', 'CAMPUS DIGITAL')");
if ($sql) {
    header("Location: ../views/admin/centros_admin.php");
    exit();
} else {
    $_SESSION['error'] = "No se pudo crear la aula";
    header("Location: ../views/admin/centros_admin.php");
    exit();
}
