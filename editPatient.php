/**
 * File created by Isaac
 */

<div class="navbar">
        <div class="logo">LOGO</div>
        <div class="nav-links">
            <a href="dashboard.php">Home</a>
            <div class="separator"></div>
            <a href="appointment.php">Appointments</a>
            <div class="separator"></div>
            <a href="medication.php">Medication</a>
        </div>
        <a href="bookAppt.php" class="button">
            <i class="icon">📅</i> Book Appointment
        </a>
        <a href="settings.php">
            <i class="settings">⚙️</i>
        </a>
    </div>
<?php
// Database connection
$servername = "localhost";  // Default for XAMPP
$dbUsername = "root";       // Default username in XAMPP
$dbPassword = "";           // Default password is empty in XAMPP
$dbName = "sinnamdb";       // Ensure this matches your database name in phpMyAdmin

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("<p style='color:red;'>Connection failed: " . $conn->connect_error . "</p>");
}

// Get form data
$user_id = intval($_POST['user_id']);
$name = $_POST['name'];
$phoneNumber = $_POST['phoneNumber'];
$email = $_POST['email'];
$conn = new mysqli($name, $user_id, $phoneNumber, $email);

// Update database
$sql = "UPDATE users SET first_name=?, last_name=?, phone_number=?, email=? WHERE user_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssi", $name, $phoneNumber, $email, $user_id);

if ($stmt->execute()) {
    echo "<script>alert('Patient details updated successfully!'); window.location.href='viewAllPatients.php';</script>";
} else {
    echo "<script>alert('Error updating patient details.'); history.back();</script>";
}

// Close statement
$stmt->close();
$conn->close();
?>
