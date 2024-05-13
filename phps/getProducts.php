<?php
include 'conexion.php';

// Preparar la consulta SQL para obtener todas las categorías
$sql = "SELECT *, producto.nombre as product FROM producto INNER JOIN categoria ON FK_Categoria = PK_Categoria";

$result = $conn->query($sql);

$categorias = array();

if ($result->num_rows > 0) {
    // Recorrer los resultados y guardar cada categoría como un objeto en el arreglo
    while($row = $result->fetch_assoc()) {
        $categoria = new stdClass();
        $categoria->id_producto = $row['PK_Producto'];
        $categoria->product = $row['product'];
        $categoria->descripcion = $row['descripcion'];
        $categoria->precio = $row['precio'];
        $categoria->imagen = $row['imagen'];
        $categoria->id_categoria = $row['PK_Categoria'];
        $categoria->nombre = $row['nombre'];
        $categorias[] = $categoria;
    }
}

// Convertir el arreglo de objetos a formato JSON y mostrarlo
echo json_encode($categorias);

// Cerrar conexión
$conn->close();
?>
