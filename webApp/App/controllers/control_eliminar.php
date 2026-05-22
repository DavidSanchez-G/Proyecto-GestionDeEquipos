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
    $idAlumno = $_POST['alumno'];
    $sql = mysqli_query($conn, "SELECT * FROM alumnos WHERE idAlumno='$idAlumno'");
    if (mysqli_num_rows($sql) > 0) {
        while ($row = mysqli_fetch_assoc($sql)) {
            $idUsuario = $row['fk_idUsuario_alumno'];
            $sql = mysqli_query($conn, "DELETE FROM alumnos WHERE idAlumno = '$idAlumno'");
            if ($sql) {
                $sql = mysqli_query($conn, "DELETE FROM usuario WHERE idUsuario = '$idUsuario'");
                if ($sql) {
                    header("Location: ../views/admin/usuarios_admin.php");
                    exit();
                }
                header("Location: ../views/admin/usuarios_admin.php");
                exit();

            }
        }

    }
} elseif (isset($_POST['profesor'])) {
    $idProfesor = $_POST['profesor'];
    $sql = mysqli_query($conn, "SELECT * FROM profesor WHERE idProfesor='$idProfesor'");
    if (mysqli_num_rows($sql) > 0) {
        $row = mysqli_fetch_assoc($sql);
        $sql = mysqli_query($conn, "DELETE FROM profesor WHERE idProfesor = '$idProfesor'");
        if ($sql) {
            $idUsuario = $row['fk_idUsuario'];
            $sql = mysqli_query($conn, "DELETE FROM usuario WHERE idUsuario = '$idUsuario'");
            header("Location: ../views/admin/usuarios_admin.php");
            exit();

        }
    }
} elseif (isset($_POST['ordenador'])) {
    $idOrdenador = $_POST['ordenador'];
    $sql = mysqli_query($conn, "SELECT * FROM ordenadores WHERE idOrdenador='$idOrdenador'");
    if (mysqli_num_rows($sql) > 0) {
        $row = mysqli_fetch_assoc($sql);
        $sql = mysqli_query($conn, "DELETE FROM ordenadores WHERE idOrdenador = '$idOrdenador'");
        header("Location: ../views/admin/portatiles_admin.php");
        exit();

    }
} elseif (isset($_POST['periferico'])) {
    $idPeriferico = $_POST['periferico'];
    $sql = mysqli_query($conn, "SELECT * FROM perifericos WHERE idPeriferico='$idPeriferico'");
    if (mysqli_num_rows($sql) > 0) {
        $row = mysqli_fetch_assoc($sql);
        $sql = mysqli_query($conn, "DELETE FROM perifericos WHERE idPeriferico = '$idPeriferico'");
        header("Location: ../views/admin/portatiles_admin.php");
        exit();

    }
} elseif (isset($_POST['aula'])) {
    $idAula = $_POST['aula'];
    $sql = mysqli_query($conn, "SELECT * FROM aulas WHERE idAula='$idAula'");
    if (mysqli_num_rows($sql) > 0) {
        $row = mysqli_fetch_assoc($sql);
        $sql = mysqli_query($conn, "DELETE FROM aulas WHERE idAula = '$idAula'");
        header("Location: ../views/admin/centros_admin.php");
        exit();

    }
} elseif (isset($_POST['solucionar'])) {
    $idMantenimiento = $_POST['solucionar'];
    $sql = mysqli_query($conn,"UPDATE mantenimiento SET estado='solucionada' WHERE idMantenimiento='$idMantenimiento'");
    header("Location: ../views/admin/incidencias_admin.php");
    exit();

} elseif (isset($_POST['pendiente'])) {
    $idMantenimiento = $_POST['pendiente'];
    $sql = mysqli_query($conn,"UPDATE mantenimiento SET estado='pendiente' WHERE idMantenimiento='$idMantenimiento'");
    header("Location: ../views/admin/incidencias_admin.php");
    exit();

} elseif (isset($_POST['estado_ordenador'])) {
    $idOrdenador = $_POST['estado_ordenador'];
    $sql = mysqli_query($conn, "SELECT * FROM ordenadores WHERE idOrdenador='$idOrdenador'");
    if (mysqli_num_rows($sql) > 0) {
        $row = mysqli_fetch_assoc($sql);
        if ($row['estado'] == 'averiado') {
            $sql = mysqli_query($conn, "UPDATE ordenadores SET estado='operativo' WHERE idOrdenador='$idOrdenador'");
            header("Location: ../views/admin/portatiles_admin.php");
            exit();
        } else {
            $sql = mysqli_query($conn, "UPDATE ordenadores SET estado='averiado' WHERE idOrdenador='$idOrdenador'");
            header("Location: ../views/admin/portatiles_admin.php");
            exit();
        }
    }

} else {
    header("location: ../../public/index.php");
    exit();
}