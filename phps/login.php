<?php
include 'conexion.php';

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT PK_Usuario, userType FROM usuario WHERE email = '$email' AND password = '$password'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $user_data = array(
        'PK_Usuario' => $row['PK_Usuario'],
        'userType' => $row['userType']
    );
    echo json_encode($user_data);
} else {
    echo -1;
}

$conn->close();
?>
