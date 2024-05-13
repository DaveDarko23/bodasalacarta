<?php
include 'conexion.php';

$data = json_decode(file_get_contents('php://input'), true);

// Definir el ID de usuario
$PK_Usuario = $data['PK_Usuario'];
$userType = $data['userType'];

if ($userType == 'normal') {
  $sql = "SELECT * FROM pedido WHERE FK_Usuario = $PK_Usuario";
} else if ($userType == 'administrador') {
  $sql = "SELECT * FROM pedido";
}

$result = $conn->query($sql);

$pedidos = array();

if ($result->num_rows > 0) {
    // Recorrer los resultados y guardar cada pedido como un objeto en el arreglo
    while($row = $result->fetch_assoc()) {
        $pedido = new stdClass();
        $pedido->id = $row['PK_Pedido'];
        $pedido->fecha = $row['fecha'];
        $pedido->id_pedido = $row['id'];
        $pedido->domicilio = $row['domicilio'];
        $pedido->telefono = $row['telefono'];
        $pedido->cantidad = $row['cantidad'];
        $pedido->costo = $row['costo'];
        $pedido->pdf = $row['pdf'];
        $pedido->FK_Usuario = $row['FK_Usuario'];
        $pedidos[] = $pedido;
    }
}

// Convertir el arreglo de objetos a formato JSON y mostrarlo
echo json_encode($pedidos);

// Cerrar conexión
$conn->close();
?>
