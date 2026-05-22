<?php
//inicias sesion
include("../include/inicio_sesion.php");

// si hay una peticion te redirige para mostrartela
if (isset($_POST['tipo'])) {
    $_SESSION['tipoPeticion'] = $_POST['tipo'];
    header("location: ../views/user/incidencias.php");
    exit();
}

$fecha = date('Ymd'); // fecha de peticion
$idUsuario = $_SESSION['usuario']; //usuario de la sesion
//comprueba si es una peticion para asignar equipo
if (isset($_POST['peticion'])) {
    // almacena la informacion de la peticion
    $descripcion = htmlspecialchars($_POST['peticion']);
    // guarda el alumno que hace la peticion
    $result = $conn->query("SELECT * FROM alumnos WHERE fk_idUsuario_alumno = '$idUsuario'");
    $alumno = $result->fetch_assoc();
    // contador para el numero de peticion del alumno
    $result = mysqli_query($conn, "SELECT COUNT(*) + 1 AS contador FROM mantenimiento WHERE fk_idAlumno = '{$alumno['idAlumno']}'");
    $contador = $result->fetch_assoc();
    // numero de ticket, contador-usuario-fecha
    $num_ticket = $contador['contador'] . "-" . $idUsuario . "-" . $fecha;
    // crea un registro en la tabla manteniiento
    $sql = "INSERT INTO mantenimiento (idMantenimiento, num_ticket, fecha, descripcion, estado, tipo, fk_idAlumno)
VALUES ('NULL', '$num_ticket', '$fecha', '$descripcion', 'pendiente', 'asignacion', '{$alumno['idAlumno']}')";
    // comprueba que se ejecute
    if ($result = $conn->query($sql)) {
        $_SESSION['exito'] = "Petición enviada correctamente";
        //redirige a ver tus inciadencas
        header("location: ../views/user/vista_incidencias.php");
    }
    //comprueba si es una peticion para reportar incidencias
} elseif (isset($_POST['equipo'])) {
    // guarda la imformación de la peticion
    $descripcion = htmlspecialchars($_POST['descripcion']);
    $idEquipo = htmlspecialchars($_POST['equipo']);
    // guarda informacion del alumno
    $result = $conn->query("SELECT * FROM alumnos WHERE fk_idUsuario_alumno = '$idUsuario'");
    $alumno = $result->fetch_assoc();
    // contador para el numero de peticion del alumno
    $result = mysqli_query($conn, "SELECT COUNT(*) + 1 AS contador FROM mantenimiento WHERE fk_idAlumno = '{$alumno['idAlumno']}'");
    $contador = $result->fetch_assoc();
    // numero de ticket, contador-usuario-fecha
    $num_ticket = $contador['contador'] . "-" . $idUsuario . "-" . $fecha;
    $result = mysqli_query($conn, "SELECT * FROM ordenadores WHERE idOrdenador = '$idEquipo'");
    // comprueba si el equipo a reportar es un ordenador
    if ($result->num_rows > 0) {
        // crea la incidencia
        $sql = "INSERT INTO mantenimiento (idMantenimiento, num_ticket, fecha, descripcion, estado, tipo, fk_idAlumno, fk_idOrdenador)
        VALUES ('NULL', '$num_ticket', '$fecha', '$descripcion', 'pendiente', 'incidencia', '{$alumno['idAlumno']}', '$idEquipo')";
       // comprueba que se ejecute
        if ($result = $conn->query($sql)) {
            $_SESSION['exito'] = "Incidencia enviada correctamente";
            //redirige a ver tus inciadencas
            header("location: ../views/user/vista_incidencias.php");
        }
        // si no es ordenador
    } else {
        // crea la incidencia de periferico
        $sql = "INSERT INTO mantenimiento (idMantenimiento, num_ticket, fecha, descripcion, estado, tipo, fk_idAlumno, fk_idPeriferico)
        VALUES ('NULL', '$num_ticket', '$fecha', '$descripcion', 'pendiente', 'incidencia', '{$alumno['idAlumno']}', '$idEquipo')";
        // Comprueba que se realize correctamente
        if ($result = $conn->query($sql)) {
            $_SESSION['exito'] = "Incidencia enviada correctamente";
            //redirige a ver tus inciadencas
            header("location: ../views/user/vista_incidencias.php");
        }
    }
}

