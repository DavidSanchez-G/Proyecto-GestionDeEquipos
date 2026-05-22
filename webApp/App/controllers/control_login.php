<?php
session_start();
include("../include/conexion.php"); // archivo que contiene la conexión a la base de datos

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Preparar la consulta para evitar inyecciones SQL
    $result = $conn->query("SELECT * FROM usuario WHERE usuario = '$username'");

    // Verificar si el usuario existe
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        // Verificar la contraseña
        if (password_verify($password, $row['password'])) {
            $_SESSION['usuario'] = $row["idUsuario"]; //variable global, id del usuario
            $_SESSION['rol'] = $row["rol"];
            // en caso de admin
            if (htmlspecialchars($row["rol"]) == "admin") {
                header("Location: ../views/admin/gestion_admin.php"); // redirigir al panel principal
                exit();
                // en caso de alumno
            } elseif (htmlspecialchars($row["rol"]) == "alumno") {
                //seleccionamos el alumno de la tabla alumnos
                $sql = $conn->prepare("SELECT * FROM alumnos WHERE fk_idUsuario_alumno = ?");
                $sql->bind_param("i", $row["idUsuario"]);
                $sql->execute();
                $result = $sql->get_result();
                $row_alumno = $result->fetch_assoc();
                //variable global, guardamos el id del alumno
                $_SESSION['alumno'] = $row_alumno["idAlumno"];
                header("Location: ../views/user/perfil.php");
                exit();
            } elseif (htmlspecialchars($row["rol"]) == "profesor") {
                //seleccionamos el alumno de la tabla profesor
                $sql = $conn->prepare("SELECT * FROM profesor WHERE fk_idUsuario = ?");
                $sql->bind_param("i", $row["idUsuario"]);
                $sql->execute();
                $result = $sql->get_result();
                $row_profesor = $result->fetch_assoc();
                //variable global, guardamos el id del alumno
                $_SESSION['alumno'] = $row_profesor["idProfesor"];
                header("Location: ../views/profesor/perfil_profesor.php");
                exit();
            } else {
                header("Location: cerrar_sesion.php");
                exit();
            }
            //si la contraseña es incorrecta
        } else {
            // guardamos error en variable global para mostrarla en login
            $_SESSION['error'] = "Contraseña incorrecta.";
            header ("Location: ../../public/index.php");
            exit();
        }
        //si el usuario es incorrecto
    } else {
        //guardamos error en variable global para mostrarla en login
        $_SESSION['error'] = "Usuario incorrecto.";
        header ("Location: ../../public/index.php");
        exit();
    }
}