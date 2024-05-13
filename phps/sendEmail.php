<?php
$data = json_decode(file_get_contents('php://input'), true);
include 'conexion.php';

// Obtener el ID de usuario y el ID del PDF
$PK_Usuario = $data['PK_Usuario'];
$id = $data['pdf'];

// Consulta para obtener el correo del usuario
$sql = "SELECT email FROM usuario WHERE PK_Usuario = $PK_Usuario";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Si se encontró el usuario, obtener su correo
    $row = $result->fetch_assoc();
    $email = $row['email'];

    // Cerrar conexión
    $conn->close();

    require("C:/xampp/vendor/phpmailer/phpmailer/src/PHPMailer.php");
    require("C:/xampp/vendor/phpmailer/phpmailer/src/SMTP.php");

    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->CharSet = 'utf-8';
    $mail->Host = "smtp.googlemail.com";
    $mail->From = "a22110098@ceti.mx"; // Correo Enviador
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->Username = "a22110098@ceti.mx"; // Correo Enviador
    $mail->Password = ""; // Contraseña
    $mail->SMTPSecure = "tls";
    $mail->Port = 587;
    $mail->AddAddress($email);
    $mail->SMTPDebug = 0;   //Muestra las trazas del mail, 0 para ocultarla
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Gracias por tu compra!';
    $mail->Body = 'Muchas gracias por tu compra! <b> Te mandamos el resumen de tu compra</b>';
    $mail->AltBody = 'Muchas gracias por tu compra! Te mandamos el resumen de tu compra';

    $inMailFileName = "Compra-ComercioGlobal.pdf";
    $filePath = "../pdf/" . $id . ".pdf";
    $mail->AddAttachment($filePath, $inMailFileName);

    if (!$mail->send()) {
        echo "Error al enviar el correo: " . $mail->ErrorInfo;
    } else {
        echo "Correo enviado correctamente";
    }
} else {
    echo "Usuario no encontrado";
}

?>
