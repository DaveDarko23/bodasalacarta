<?php
include 'conexion.php';

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

$sql = "INSERT INTO usuario (name, email, password, userType) VALUES ('$name', '$email', '$password', 'normal')";

if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
    echo $last_id;
} else {
    echo -1;
}

$conn->close();
?>
