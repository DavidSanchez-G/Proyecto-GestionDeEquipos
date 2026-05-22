<?php
$servername = "localhost";
$username = "root";
$password = "";
$bdname = "equiposbd";

// Create connection

$conn = mysqli_connect($servername, $username, $password, $bdname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Evita que el navegador cachee esta página
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: 0"); // Proxies


