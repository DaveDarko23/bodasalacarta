<?php
include 'conexion.php';

$data = json_decode(file_get_contents('php://input'), true);

$userId = $data["PK_Usuario"];

// Preparar la consulta SQL para obtener todas las categorías
$sql = "SELECT *, producto.nombre AS product_name, categoria.nombre AS category_name FROM usuario 
        INNER JOIN carrito ON carrito.FK_Usuario = usuario.PK_Usuario 
        INNER JOIN producto ON carrito.FK_Producto = producto.PK_Producto 
        INNER JOIN categoria ON categoria.PK_Categoria = producto.FK_Categoria 
        WHERE PK_Usuario = $userId";


$result = $conn->query($sql);

$categorias = array();

if ($result->num_rows > 0) {
    // Recorrer los resultados y guardar cada categoría como un objeto en el arreglo
    while($row = $result->fetch_assoc()) {
        $categoria = new stdClass();
        $categoria->id_producto = $row['PK_Producto'];
        $categoria->descripcion = $row['descripcion'];
        $categoria->precio = $row['precio'];
        $categoria->imagen = $row['imagen'];
        $categoria->nombre = $row['product_name'];
        $categoria->cantidad = $row['cantidad'];
        $categoria->categoria = $row['category_name'];
        $categorias[] = $categoria;
    }
}

// Convertir el arreglo de objetos a formato JSON y mostrarlo
echo json_encode($categorias);

// Cerrar conexión
$conn->close();
?>
