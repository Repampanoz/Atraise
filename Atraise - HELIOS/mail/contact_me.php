<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load PHPMailer
require 'phpmailer/PHPMailer.php';
require 'phpmailer/Exception.php';
require 'phpmailer/SMTP.php';

// Check for empty fields
if(empty($_POST['name']) || empty($_POST['email']) || empty($_POST['message']) || !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) {
    echo "No arguments provided!";
    return false;
}

$name = $_POST['name'];
$email_address = $_POST['email'];
$message = $_POST['message'];
$category = $_POST['category'];

// Create a new PHPMailer instance
$mail = new PHPMailer(true);

try {
    // SMTP settings
    $mail->SMTPDebug = 0;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    $mail->Username = '@gmail.com';
    $mail->Password = 'your_gmail_password';

    // Sender and recipient
    $mail->setFrom('noreply@yourdomain.com', 'Your Name');
    $mail->addAddress('recipient@example.com');
    $mail->addReplyTo($email_address, $name);

    // Email content
    $mail->isHTML(false);
    $mail->Subject = 'Website Contact Form: ' . $name;
    $mail->Body    = "You have received a new message from your website contact form.\n\nHere are the details:\n\nName: $name\n\nEmail: $email_address\n\nCategory: $category\n\nMessage:\n$message";

    // Send the email
    $mail->send();
    echo "Message sent!";
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
