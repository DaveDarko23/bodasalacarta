<?php
include 'conexion.php';

$data = json_decode(file_get_contents('php://input'), true);

// Recibir datos del formulario POST
$PK_Usuario = $data['PK_Usuario'];
$PK_Producto = $data['PK_Producto'];
$cantidad = $data['quantity'];

// Preparar la consulta SQL para insertar en la tabla "carrito"
$sql = "UPDATE carrito SET cantidad = $cantidad WHERE FK_Usuario = $PK_Usuario AND FK_Producto = $PK_Producto";

if ($conn->query($sql) === TRUE) {
    echo 200;
} else {
  echo -1;
}

// Cerrar conexión
$conn->close();
?>
