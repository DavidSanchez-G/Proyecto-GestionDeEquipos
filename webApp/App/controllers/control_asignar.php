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

if (isset($_POST['alumno'])) {
    $idAlumno = htmlspecialchars($_POST['alumno']);
    if(isset($_POST['ordenador'])){
        $ordenador = htmlspecialchars($_POST['ordenador']);
        $sql = mysqli_query($conn, "UPDATE alumnos SET fk_idOrdenador_alumno='$ordenador' WHERE idAlumno = '$idAlumno'");
        if ($sql) {
            $_SESSION['exito'] = "Asignado exitosamente";
            header("Location: ../views/admin/portatiles_admin.php");
            exit();
        }
    } else {
        $periferico = htmlspecialchars($_POST['periferico']);
        $sql = mysqli_query($conn, "UPDATE perifericos SET fk_idAlumno='$idAlumno' WHERE idPeriferico = '$periferico'");
        if ($sql) {
            $_SESSION['exito'] = "Asignado exitosamente";
            header("Location: ../views/admin/portatiles_admin.php");
            exit();
        }
    }
} elseif (isset($_POST['ordenador_quitar'])) {
    $idAlumno = htmlspecialchars($_POST['ordenador_quitar']);
    $sql = mysqli_query($conn, "UPDATE alumnos SET fk_idOrdenador_alumno= NULL WHERE idAlumno = '$idAlumno'");
    if ($sql) {
        $_SESSION['exito'] = "Des-asignado exitosamente";
        header("Location: ../views/admin/portatiles_admin.php");
        exit();
    }
} elseif (isset($_POST['periferico_quitar'])) {
    $idPeriferico = htmlspecialchars($_POST['periferico_quitar']);
    $sql = mysqli_query($conn, "UPDATE perifericos SET fk_idAlumno= NULL WHERE idPeriferico = '$idPeriferico'");
    if ($sql) {
        $_SESSION['exito'] = "Des-asignado exitosamente";
        header("Location: ../views/admin/portatiles_admin.php");
        exit();
    }
}

