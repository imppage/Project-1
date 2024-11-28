<?php
composer require phpmailer/phpmailer;

// Include PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// require 'vendor/autoload.php'; // Use this if you installed PHPMailer with Composer

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    
    // Validation (you can add more checks)
    if (empty($name) || empty($email) || empty($message)) {
        echo "All fields are required.";
        exit();
    }

    // Send email using PHPMailer
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->isSMTP();                                           // Set mailer to use SMTP
        $mail->Host       = 'smtp.gmail.com';                         // Set the SMTP server to Gmail
        $mail->SMTPAuth   = true;                                    // Enable SMTP authentication
        $mail->Username   = 'your-email@gmail.com';                  // Your Gmail address
        $mail->Password   = 'your-email-password';                   // Your Gmail password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;          // Enable TLS encryption
        $mail->Port       = 587;                                     // TCP port for TLS

        //Recipients
        $mail->setFrom($email, $name);
        $mail->addAddress('support@ecommerce.com');                  // Support email

        // Content
        $mail->isHTML(true);                                          // Set email format to HTML
        $mail->Subject = 'New Contact Message from ' . $name;
        $mail->Body    = "You have received a new message from $name.<br><br>".
                         "<strong>Email:</strong> $email<br><br>".
                         "<strong>Message:</strong><br>$message";

        $mail->send();
        echo "Your message has been sent successfully!";
    } catch (Exception $e) {
        echo "Failed to send message. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Invalid request method.";
}
?>
