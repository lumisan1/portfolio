<?php
/**
 * Fixed PHP Email Form Handler
 * Compatible with PHPMailer 5.2 (PHPMailerAutoload.php)
 */

// Correct path: If this file is in 'forms/', we go up one level to find 'mail/'
require 'mail/phpmailer/PHPMailerAutoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Initialize PHPMailer (No namespace needed for v5.2)
    $mail = new PHPMailer;

    try {
        // --- Server Settings (Using your basis credentials) ---
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'sampleforthesis1233@gmail.com';
        $mail->Password   = 'lkttdhtmmdhiisaj'; // Your App Password
        $mail->SMTPSecure = 'tls'; 
        $mail->Port       = 587;

        // --- Recipients ---
        $mail->setFrom('sampleforthesis1233@gmail.com', 'Portfolio Inquiry');
        $mail->addAddress('vincentivanbautista13@gmail.com'); 
        $mail->addReplyTo($_POST['email'], $_POST['name']);

        // --- Content ---
        $mail->isHTML(true);
        $mail->Subject = "Portfolio: " . $_POST['subject'];
        
        // Sanitize inputs
        $name    = htmlspecialchars($_POST['name']);
        $email   = htmlspecialchars($_POST['email']);
        $message = nl2br(htmlspecialchars($_POST['message']));

        $mail->Body = "
            <div style='font-family: Arial, sans-serif; padding: 20px; border: 1px solid #eee;'>
                <h2 style='color: #2c3e50;'>New Message Received</h2>
                <p><strong>From:</strong> {$name} ({$email})</p>
                <p><strong>Subject:</strong> {$_POST['subject']}</p>
                <hr>
                <p><strong>Message:</strong></p>
                <div style='background: #fdfdfd; padding: 15px; border-left: 5px solid #007bff;'>
                    {$message}
                </div>
            </div>";

        // --- Execution ---
        if ($mail->send()) {
            // Echo 'OK' so the template's AJAX script triggers the success message
            echo "OK";
        } else {
            echo "Mailer Error: " . $mail->ErrorInfo;
        }

    } catch (Exception $e) {
        echo "System Error: " . $e->getMessage();
    }
} else {
    echo "Invalid access.";
}