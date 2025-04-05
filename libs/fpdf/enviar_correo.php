<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

function enviarCorreo($destinatario, $factura_path) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'rick6683rick@gmail.com';
        $mail->Password = 'Rick0066';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('rick6683rick@gmail.com', 'Papelería JR');
        $mail->addAddress($destinatario);

        $mail->Subject = "Confirmación de Compra";
        $mail->Body = "Gracias por tu compra. Adjuntamos tu factura.";
        $mail->addAttachment($factura_path);

        $mail->send();
    } catch (Exception $e) {
        die("Error al enviar el correo: {$mail->ErrorInfo}");
    }
}
