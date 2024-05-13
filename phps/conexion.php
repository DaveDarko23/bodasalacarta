<?php
$servername = "10.0.0.5";
$username = "galilea";
$password = "1234";
$database = "bodasalacarta";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
