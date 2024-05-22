<?php
require_once 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Connecting mail config
$host_mail = 'smtp.gmail.com';
$user_mail = 'szyplakowski.a@gmail.com';
$pass_mail = 'gmquimxjmtjgcbwt';
$port_mail = 465;
$SMTP_auth = true;
$SMTP_secure = 'ssl';

// Template mail
$mail_from = 'rejestracja@soi.pl';
$mail_author = 'Administrator';
$mail_head = 'Witamy w grze! Rejestracja udana';

function sendActiveMail($email, $name, $token) {
    global $host_mail, $user_mail, $pass_mail, $port_mail, $SMTP_auth, $SMTP_secure, $mail_author, $mail_head, $mail_from, $mail_body;
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->SMTPAuth = $SMTP_auth;
    $mail->Host = $host_mail;
    $mail->Username = $user_mail;   //email
    $mail->Password = $pass_mail;   //16 character obtained from app password created
    $mail->Port = $port_mail;
    $mail->SMTPSecure = $SMTP_secure;
    $mail->Subject = $mail_head;
    $mail->setFrom($mail_from, $mail_author);
    $mail->addAddress($email, $name); 
    $mail->isHTML(true);
    $mail->Body = '<h4>Dziękuje za rejestracje!! </h4>
    <b>Aby aktywowac konto. KLIKNIJ LINK PONIŻEJ </b>
    <p><a href="https://inz.aszyplakowski.pl/rejestracja.php?token='.$token.'">KLINIJ W LINK<a></p>
    <p>Lub skopiuj i wklej link poniżej</p>
    <p>https://inz.aszyplakowski.pl/rejestracja.php?token='.$token.'</p>';

    if (!$mail->send()) {
        $errors[] = array("status" => "error", "message" => "Błąd wysyłania e-maila: " . $mail->ErrorInfo);
        echo json_encode($errors);
        return;
    } else {
        return true;
    }

}