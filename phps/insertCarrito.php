<?php
include 'conexion.php';

$data = json_decode(file_get_contents('php://input'), true);

// Recibir datos del formulario POST
$productId = $data['productId'];
$userId = $data['PK_Usuario'];

// Preparar la consulta SQL para insertar en la tabla "carrito"
$sql = "INSERT INTO carrito (FK_Usuario, FK_Producto, cantidad) VALUES ($userId, $productId, 1)";

if ($conn->query($sql) === TRUE) {
    echo 200;
} else {
  echo -1;
}

// Cerrar conexión
$conn->close();
?>
