<?php
/*$servername = "10.0.0.5";
$username = "gali";
$password = "123";
$database = "bodasalacarta";*/

$servername = "localhost";
$username = "root";
$password = "";
$database = "bodasalacarta";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
