<?php
include 'conexion.php';

$data = json_decode(file_get_contents('php://input'), true);

// Definir el ID de usuario
 $PK_Usuario = $data['PK_Usuario'];
 $userType = $data['userType'];

/*$PK_Usuario = 5;
$userType = "normal";*/

if ($userType == 'normal') {
  $sql = "SELECT *, producto.nombre as product FROM compra INNER JOIN producto ON FK_Producto = PK_Producto INNER JOIN pedido ON FK_Pedido = PK_Pedido INNER JOIN categoria ON PK_Categoria = FK_Categoria WHERE FK_Usuario = $PK_Usuario";
} else if ($userType == 'administrador') {
  $sql = "SELECT *, producto.nombre as product FROM compra INNER JOIN producto ON FK_Producto = PK_Producto INNER JOIN pedido ON FK_Pedido = PK_Pedido INNER JOIN categoria ON PK_Categoria = FK_Categoria";
}

$result = $conn->query($sql);

$pedidos = array();

if ($result->num_rows > 0) {
    // Recorrer los resultados y guardar cada pedido como un objeto en el arreglo
    while($row = $result->fetch_assoc()) {
        $pedido = new stdClass();
        $pedido->id = $row['PK_Compra'];
        $pedido->product = $row['product'];
        $pedido->descripcion = $row['descripcion'];
        $pedido->precio = $row['precio'];
        $pedido->imagen = $row['imagen'];
        $pedido->id_categoria = $row['PK_Categoria'];
        $pedido->nombre = $row['nombre'];
        $pedido->pdf = $row['pdf'];
        $pedidos[] = $pedido;
    }
}

// Convertir el arreglo de objetos a formato JSON y mostrarlo
echo json_encode($pedidos);

// Cerrar conexión
$conn->close();
?>
