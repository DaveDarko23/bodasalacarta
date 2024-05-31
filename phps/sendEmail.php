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

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require '../vendor/autoload.php';

    // Content for the email body
    $emailContent = '<h1>Bienvenido a Nuestro Sitio Web</h1><p>Gracias por su compra.</p>';

    // Use PHPMailer to send the email
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'a22110055@ceti.mx'; // Replace with your Gmail email address
        $mail->Password = ''; // Replace with your Gmail password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('a22110098@ceti.com', 'Bodas a la Carta'); // Replace with your Gmail email address and your name
        $mail->addAddress($email); // Use the actual field names

        $mail->isHTML(true);
        $mail->Subject = 'Welcome to Our Website';
        $mail->Body = $emailContent;
        $mail->addAttachment('../pdf/' . $id . '.pdf');

        $mail->send();
        echo "Email sent successfully!";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Usuario no encontrado";
}

?>
