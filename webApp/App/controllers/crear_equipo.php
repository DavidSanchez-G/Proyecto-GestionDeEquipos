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
$tipo = $_POST['tipo'];
$marca = $_POST['marca'];
$modelo = $_POST['modelo'];
$num_serie = $_POST['num_serie'];
if (isset($_POST['so'])) {
    $so = $_POST['so'];
} else {
    $so = '';
}
$aula = $_POST['aula'];
$estado = $_POST['estado'];

if ($tipo == "ordenador") {
    $sql = mysqli_query($conn, "SELECT numero FROM ordenadores WHERE fk_idAula='$aula' ORDER BY numero DESC LIMIT 1");
    $contador = mysqli_fetch_array($sql);
    $contador['numero'] = $contador['numero'] + 1;
    // insertamos datos en ordenador
    $stmt = $conn->prepare("INSERT INTO ordenadores (idOrdenador, marca, so, modelo, num_serie, numero, estado, fk_idAula) 
    VALUES ('NULL', ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssi", $marca, $so, $modelo, $num_serie, $contador['numero'], $estado, $aula);
    // comprueba si se ha insertado datos con exito
    if (!$stmt->execute()){
        $_SESSION['error'] = "No se ha podido crear el ordenador";
        header("location: ../views/admin/crear_equipo_admin.php");
        exit();
    } else {
        $stmt->close();
        header("Location: ../views/admin/crear_equipo_admin.php");
        exit();
    }

} else {
    $sql = mysqli_query($conn, "SELECT numero FROM perifericos WHERE fk_idAula='$aula' AND fk_id_tipo_periferico='$tipo' ORDER BY numero DESC LIMIT 1");
    $contador = mysqli_fetch_array($sql);
    $contador['numero'] = $contador['numero'] + 1;
    // insertamos datos en ordenador
    $stmt = $conn->prepare("INSERT INTO perifericos (idPeriferico, marca, modelo, num_serie, estado, numero, fk_id_tipo_periferico, fk_idAula) 
    VALUES ('NULL', ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssii", $marca, $modelo, $num_serie, $estado, $contador['numero'], $tipo, $aula);
    // comprueba si se ha insertado datos con exito
    if (!$stmt->execute()){
        $_SESSION['error'] = "No se ha podido crear el periferico";
        header("location: ../views/admin/crear_equipo_admin.php");
        exit();
    } else {
        $stmt->close();
        header("Location: ../views/admin/crear_equipo_admin.php");
        exit();
    }
}
