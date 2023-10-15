<?php

require 'vendor/autoload.php';
include 'db_config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['send_emails'])) {
    $selectedEmails = $_POST['selected_emails'];

    // Initialize PHPMailer
    $mail = new PHPMailer(true);

    // Mail configuration (SMTP, sender, etc.)
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Your SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = ''; // Enter the sender email
    $mail->Password = ''; // Enter the gmail app password
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->setFrom('harsh.prakashdps@gmail.com', 'Harsh');

    // Loop through selected emails and send emails
    foreach ($selectedEmails as $email) {
        // Retrieve the QR code path from the database
        $selectPathSql = "SELECT qr_path FROM voter_list WHERE email = ?";
        $stmt = $conn->prepare($selectPathSql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->bind_result($qrPath);
        $stmt->fetch();
        $stmt->close();

        // Compose email content
        $mail->addAddress($email);
        $mail->Subject = 'Your QR Code';
        $mail->Body = 'Please find your QR code attached below.';
        $mail->addAttachment(__DIR__ . "/images/$email.png", "$email.png");

        // Send the email
        $mail->send();

        $updateSql = "UPDATE voter_list SET qr_generated = '_' WHERE email = ?";
        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->close();
    }


    header("Location: qr_generated.php");
    exit();
}
