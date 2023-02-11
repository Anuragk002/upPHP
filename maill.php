<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require 'vendor/autoload.php';
$mail = new PHPMailer();
$mail->isSMTP();

//Enable SMTP debugging
//SMTP::DEBUG_OFF = off (for production use)
//SMTP::DEBUG_CLIENT = client messages
//SMTP::DEBUG_SERVER = client and server messages

$mail->SMTPDebug = SMTP::DEBUG_OFF;


$mail->Host = 'unitpharma.com';
$mail->Port = 465;
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
$mail->SMTPAuth = true;
$mail->Username = 'support@unitpharma.com';
$mail->Password = 'un!tph@rm@2022';

$mail->setFrom('support@unitpharma.com', 'unitpharma');
$mail->addReplyTo('support@unitpharma.com', 'Reply Unitpharma');
    // $mail->addAddress('pankaj143giri@gmail.com', 'Anurag K');//user mail customer
    // $mail->Subject = 'UP test';//subject

//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
    // $mail->msgHTML(file_get_contents('contents.html'), __DIR__);

//Replace the plain text body with one created manually
// $mail->AltBody = 'This is a plain-text message body';

//Attach an image file
    // $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
// $mail->addAttachment('images/phpmailer_mini.png');

    // if (!$mail->send()) {
    //     // echo 'Mailer Error: ' . $mail->ErrorInfo;
    // } else {
    //     echo 'Message sent!';
    // }
