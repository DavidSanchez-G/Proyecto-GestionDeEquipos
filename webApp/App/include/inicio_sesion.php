<?php
//inicias sesion
session_start();
include("../../include/conexion.php"); // conexion

// compruebas si se ha iniciado sesion con el usuario
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../../public/index.php");
    exit();
} else {
    $idUsuario = $_SESSION['usuario'];
    $rolUsuario = $_SESSION['rol'];
}


?>