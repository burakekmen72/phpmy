<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // PHPMailer kurulumu gerekli

function send_verification_mail($to, $code) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // kendi SMTP bilgini gir
        $mail->SMTPAuth = true;
        $mail->Username = 'burakekmen722134@gmail.com';
        $mail->Password = 'xepr kbgc emlz wxse';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('burakekmen722134@gmail.com', 'Affiliate VIP');
        $mail->addAddress($to);
        $mail->Subject = 'Mail Dogrulama Kodu';
        $mail->Body = "Kodu: $code";
        $mail->send();
    } catch (Exception $e) {
        // Hata logla
    }
}
?>