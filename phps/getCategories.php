<?php
include 'conexion.php';

// Preparar la consulta SQL para obtener todas las categorías
$sql = "SELECT * FROM categoria";

$result = $conn->query($sql);

$categorias = array();

if ($result->num_rows > 0) {
    // Recorrer los resultados y guardar cada categoría como un objeto en el arreglo
    while($row = $result->fetch_assoc()) {
        $categoria = new stdClass();
        $categoria->id = $row['PK_Categoria'];
        $categoria->nombre = $row['nombre'];
        $categorias[] = $categoria;
    }
}

// Convertir el arreglo de objetos a formato JSON y mostrarlo
echo json_encode($categorias);

// Cerrar conexión
$conn->close();
?>
