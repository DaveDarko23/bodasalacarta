<?php
include 'conexion.php';
include 'crearPDF.php';

$data = json_decode(file_get_contents('php://input'), true);

// Definir el ID de usuario
$PK_Usuario = $data['PK_Usuario'];
$address = $data['address'];
$phone = $data['phone'];
$costo = $data['costo'];

// Consulta para obtener la lista de productos en el carrito
$sql_select = "SELECT *, producto.nombre AS product_name, categoria.nombre AS category_name FROM usuario 
        INNER JOIN carrito ON carrito.FK_Usuario = usuario.PK_Usuario 
        INNER JOIN producto ON carrito.FK_Producto = producto.PK_Producto 
        INNER JOIN categoria ON categoria.PK_Categoria = producto.FK_Categoria 
        WHERE PK_Usuario = $PK_Usuario";

$resultado = $conn->query($sql_select);

// Verificar si hay resultados
if ($resultado->num_rows > 0) {
    $productos = array();
    // Construir el arreglo con la respuesta
    while($row = $resultado->fetch_assoc()) {
        $producto = array(
            'id_producto' => $row['PK_Producto'],
            'descripcion' => $row['descripcion'],
            'precio' => $row['precio'],
            'imagen' => $row['imagen'],
            'nombre_producto' => $row['product_name'],
            'cantidad' => $row['cantidad'],
            'categoria' => $row['category_name']
        );
        $productos[] = $producto;
    }


    $id_pedido = substr(md5(uniqid()), 0, 16);

    generateContentPdf($productos, $costo, $address, $phone, $id_pedido);
    $pdf = "http://10.0.0.3/bodas/pdf/" . $id_pedido . ".pdf";
    $sql_insert_pedido = "INSERT INTO pedido (id, domicilio, telefono, cantidad, costo, pdf, FK_Usuario) 
    VALUES ('$id_pedido', '$address', '$phone'," . count($productos) . ", $costo, '$pdf', $PK_Usuario)";

    if ($conn->query($sql_insert_pedido) === TRUE) {
      $last_id = $conn->insert_id;
      // Insertar los productos en la tabla "compra"
      foreach ($productos as $producto) {
        $id_producto = $producto['id_producto'];
        $sql_insert_compra = "INSERT INTO compra (FK_Producto, FK_Pedido) VALUES ($id_producto, $last_id)";
        if ($conn->query($sql_insert_compra) !== TRUE) {
            echo "Error al registrar la compra: " . $conn->error;
        }
      }
      $response = array('pdf' => $id_pedido);
      echo json_encode($response);
    } else {
      echo "Error al registrar el pedido: " . $conn->error;
    }
} else {
    echo "No se encontraron productos en el carrito";
}

// Cerrar conexión
$conn->close();
?>
