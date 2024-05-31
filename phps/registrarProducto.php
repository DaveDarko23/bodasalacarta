<?php
include 'conexion.php';

// Recibir datos del formulario POST
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$categoria = $_POST['categoria'];

// Obtener la cantidad de imágenes en la carpeta de carga
$files = glob("images/*");
$num_files = count($files);

// Generar un nombre único para la imagen
$new_filename = "imagen_" . ($num_files + 1) . "." . pathinfo($_FILES["imagen"]["name"], PATHINFO_EXTENSION);
$target_file = "http://10.0.0.3/phps/images/" . $new_filename;
move_uploaded_file($_FILES["imagen"]["tmp_name"], "images/" . $new_filename);

// Preparar la consulta SQL para insertar el producto
$sql = "INSERT INTO producto (nombre, descripcion, precio, imagen, FK_Categoria) VALUES ('$nombre', '$descripcion', $precio, '$target_file', $categoria)";

if ($conn->query($sql) === TRUE) {
    echo "Producto registrado exitosamente";
} else {
    echo -1;
}

// Cerrar conexión
$conn->close();
?>
