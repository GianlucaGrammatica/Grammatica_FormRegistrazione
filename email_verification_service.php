<?php

require __DIR__ . '/vendor/autoload.php'; // importa tutte le librerie dentro la cartella delle dipendenze

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


// nomero bytes (di base 32 e titme to live (di base 24)
// ritorna un array
function generateEmailVerificationToken(int $bytes = 32, string $ttlSpec = '+24 hours'): array
{
    $rew = random_bytes($bytes); //dato crudo e genera byte a caso
    $token = bin2hex($rew); //converte in esadecimale
    $expiresAt = new DateTimeImmutable($ttlSpec); //
    return [$token, $expiresAt];
}

function sendVerificationEmail(string $email, string $username, string $url) {
    $mail = new PHPMailer(true);
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/config');
    $dotenv->load();
    $dotenv->required(['USERNAME', 'PASSWORD'])->notEmpty();

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io'; // o live.smtp.mailtrap.io per stream reali
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV["USERNAME"]; // username fornito da Mailtrap
        $mail->Password = $_ENV["PASSWORD"]; // password fornita da Mailtrap
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // o 'ssl' su porta 465
        $mail->Port = 587; // 25, 465, 587 o 2525 sono possibili

        // Mittente e destinatario
        $mail->setFrom('veridicazione@noreply.com', 'Login Website');
        $mail->addAddress($email, $username);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'New account verification';
        $mail->Body = "<h1>Hello $username</h1><p>Please activate your accout<br>press here to activate: <a href='$url'>activation code</a><br><br>if you didn't request to activate your accout, please ignore this email</p>";
        $mail->send();
    } catch (Exception $e) {
        echo "Mailer Error: {$mail->ErrorInfo}";
    }
}