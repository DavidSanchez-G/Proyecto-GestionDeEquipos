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

// Guardas los datos del nuevo usuario
$nombre_usuario = htmlspecialchars($_POST['nombre_usuario']);
$apellido_usuario = htmlspecialchars($_POST['apellido_usuario']);
$correo_usuario = htmlspecialchars($_POST['correo_usuario']);
$password_usuario = htmlspecialchars($_POST['password_usuario']);
$hash = password_hash($password_usuario, PASSWORD_DEFAULT);
$rol_usuario = htmlspecialchars($_POST['rol_usuario']);
$usuario = htmlspecialchars($_POST['clave_usuario']);


// Compruebas el rol del usuario, profesor o alumno
if ($rol_usuario == "alumno") {
    // Consultas la tabla alumno
    $sql= $conn->query("SELECT * FROM alumnos");
    while($alumno = $sql->fetch_assoc()){
        // comprueba que el correo no exista
        if ($alumno['email'] == $correo_usuario) {
            $_SESSION['error'] = "El correo ya se encuentra registrado";
            header("location: ../views/admin/crear_usuario_admin.php");
            exit();
        }
    }

    // Consultas la tabla usuario
    $sql = $conn->query("SELECT * FROM usuario");
    while ($usuarios = $sql->fetch_assoc()) {
        if ($usuarios['usuario'] == $usuario) {
            $_SESSION['error'] = "Nombre de usuario ya registrado";
            header("location: ../views/admin/crear_usuario_admin.php");
            exit();
        }
    }

    // insertamos datos en usuario
    $stmt = $conn->prepare("INSERT INTO usuario (idUsuario, usuario, password, rol) 
    VALUES ('NULL', ?, ?, ?)");
    $stmt->bind_param("sss", $usuario, $hash, $rol_usuario);
    // comprueba si se ha insertado datos con exito
    if (!$stmt->execute()){
        $_SESSION['error'] = "No se ha podido registrar el usuario";
        header("location: ../views/admin/crear_usuario_admin.php");
        exit();
    } else {
        // si tiene exito buscas el id generado para referenciarlo despues en alumno
        $stmt->close();
        $stmt = $conn->prepare("SELECT * FROM usuario WHERE usuario = ?");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        $usuario = $result->fetch_assoc();
        $stmt->close();
    }

    // Para insertar datos en alumno comprobamos si el aula ha sido asignada
    if (!isset($_POST['aula'])) {
        // insetamos datos en el alumno
        $stmt = $conn->prepare("INSERT INTO alumnos (idAlumno, nombre, apellidos, email, fk_idUsuario_alumno)
        VALUES('NULL', ?, ?, ?, ?)");
        $stmt->bind_param('sssi', $nombre_usuario, $apellido_usuario, $correo_usuario, $usuario['idUsuario']);
        // comprobamos éxito
        if (!$stmt->execute()) {
            $_SESSION['error'] = "No se ha podido registrar el alumno";
            header("location:  ../views/admin/crear_usuario_admin.php");
            exit();
        } else {
            $_SESSION['error'] = "Registrado con éxito";
            header("location: ../views/admin/crear_usuario_admin.php");
            exit();
        }
    // si el aula esta asignada
    } else {
        // buscamos el aula asignada
        $aula = htmlspecialchars($_POST['aula']);
        // insertamos datos con aula
        $stmt = $conn->prepare("INSERT INTO alumnos (idAlumno, nombre, apellidos, email, fk_idAula_alumno, fk_idUsuario_alumno)
        VALUES('NULL', ?, ?, ?, ?, ?)");
        $stmt->bind_param('sssii', $nombre_usuario, $apellido_usuario, $correo_usuario, $aula, $usuario['idUsuario']);
        // comprobamos si tiene exito
        if (!$stmt->execute()){
            $_SESSION['error'] = "No se ha podido registrar el alumno";
            header("location:  ../views/admin/crear_usuario_admin.php");
            exit();
        } else {
            $_SESSION['error'] = "Registrado con éxito";
            header("location: ../views/admin/crear_usuario_admin.php");
            exit();
        }


    }
// si el usuario va a ser profesor
} elseif ($rol_usuario == "profesor") {
    // Consultas la tabla profesor para comprobar si existe ya
    $sql= $conn->query("SELECT * FROM profesor");
    while($profesor = $sql->fetch_assoc()){ // recorre la tabla
        // comprueba que el correo no exista ya
        if ($profesor['email'] == $correo_usuario) {
            $_SESSION['error'] = "El correo ya se encuentra registrado";
            header("location:  ../views/admin/crear_usuario_admin.php");
            exit();
        }
    }

    // Consultas la tabla usuario para comprobar si existe ya
    $sql = $conn->query("SELECT * FROM usuario");
    while ($usuarios = $sql->fetch_assoc()) {
        if ($usuarios['usuario'] == $usuario) {
            $_SESSION['error'] = "Nombre de usuario ya registrado";
            header("location:  ../views/admin/crear_usuario_admin.php");
            exit();
        }
    }

    // insertamos datos en usuario
    $stmt = $conn->prepare("INSERT INTO usuario (idUsuario, usuario, password, rol) 
    VALUES ('NULL', ?, ?, ? )");
    $stmt->bind_param("sss", $usuario, $hash, $rol_usuario);
    // comprueba si se ha insertado datos con exito
    if (!$stmt->execute()){
        $_SESSION['error'] = "No se ha podido registrar el usuario";
        header("location:  ../views/admin/crear_usuario_admin.php");
        exit();
    } else {
        // si tiene exito buscas el id generado para referenciarlo despues en alumno
        $stmt->close();
        $stmt = $conn->prepare("SELECT * FROM usuario WHERE usuario = ?");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        $usuario = $result->fetch_assoc();
        $stmt->close();
    }

    // insetamos datos en tabla profesor
    $stmt = $conn->prepare("INSERT INTO profesor (idProfesor, nombre, apellidos, email, fk_idUsuario_alumno)
    VALUES('NULL', ?, ?, ?, ?)");
    $stmt->bind_param('sssi', $nombre_usuario, $apellido_usuario, $correo_usuario, $usuario['idUsuario']);
    // comprobamos éxito
    if (!$stmt->execute()) {
        $_SESSION['error'] = "No se ha podido registrar el ". $rol_usuario;
        header("location:  ../views/admin/crear_usuario_admin.php");
        exit();
    } else {
        $_SESSION['error'] = "Registrado con éxito";
        header("location: ../views/admin/crear_usuario_admin.php");
        exit();
    }


}