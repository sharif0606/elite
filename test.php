<?php 
$to = 'tawhid102@gmail.com'; // Replace with the recipient's email address
$subject = 'Test Email'; // Replace with the email subject
$message = 'This is a test email.'; // Replace with the email content
$headers = 'From: tawhid8995@gmail.com'; // Replace with the sender's email address

// Send the email
$mailSent = mail($to, $subject, $message, $headers);

if ($mailSent) {
    echo 'Email sent successfully.';
} else {
    echo 'Failed to send email.';
}
?>
