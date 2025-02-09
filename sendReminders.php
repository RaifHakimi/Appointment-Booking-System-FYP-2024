<!DOCTYPE html>
<?php

// Protect script with a secret key
$secret_key = "mySuperSecretKey123"; // Change this to a secure key
if (!isset($_GET['key']) || $_GET['key'] !== $secret_key) {
    die("Unauthorized access.");
}

//"https://yourwebsite.com/sendReminders.php?key=mySuperSecretKey123"

// Include PHPMailer's autoload file
require 'vendor/autoload.php';  // Ensure this is the correct path to your Composer autoload.php

// Use PHPMailer's classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include database connection
include("dbFunctions.php");

// Set time zone (adjust as needed)
date_default_timezone_set('Asia/Singapore');

// used for testing
$reminderDate = date('Y-m-d');

// Get appointments happening in the next 24 hours
$query = "SELECT a.appt_id, a.appt_date, a.appt_time, u.email, u.username 
          FROM appointment a
          INNER JOIN users u ON a.user_id = u.user_id
          WHERE appt_date = '$reminderDate'
          AND a.visible = 1";

// WHERE a.appt_date = CURDATE() + INTERVAL 1 DAY

$result = mysqli_query($link, $query);

// Create a new PHPMailer instance
$mail = new PHPMailer(true);

while ($row = mysqli_fetch_assoc($result)) {
    $email = $row['email'];
    $username = $row['username'];
    $appt_date = date("d M Y", strtotime($row['appt_date']));
    $appt_time = date("h:i A", strtotime($row['appt_time']));

    // Set up PHPMailer to send emails
    try {
        // SMTP configuration (adjust for your mail server)
        $mail->isSMTP();  // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Use Gmail's SMTP server
        $mail->SMTPAuth = true;  // Enable SMTP authentication
        $mail->Username = '';  // Your Gmail address
        $mail->Password = '';  // Your Gmail App password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Enable TLS encryption
        $mail->Port = 587;  // TCP port for TLS

        // Sender's email and name
        $mail->setFrom('', 'Your Clinic');

        // Recipient's email
        $mail->addAddress($email, $username);  // Add recipient

        // Set email format to HTML (optional for plain text)
        $mail->isHTML(false);  // Set to false for plain text email

        // Email subject and body
        $subject = "Appointment Reminder - $appt_date at $appt_time";
        $message = "
        Dear $username,

        This is a friendly reminder of your upcoming appointment.

        📅 Date: $appt_date  
        ⏰ Time: $appt_time  

        Please arrive on time. If you need to reschedule, contact us in advance.

        Regards,  
        Your Clinic Team 
        ";

        $mail->Subject = $subject;
        $mail->Body = $message;

        // Send the email
        $mail->send();  // Attempt to send the email

    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

echo "Appointment reminders sent successfully!";
?>
