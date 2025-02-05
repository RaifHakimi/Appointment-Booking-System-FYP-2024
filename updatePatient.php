/**
 * File created by Isaac
 */
<?php
// Database connection
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "sinnamdb";

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$user_id = intval($_POST['user_id']);
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$phoneNumber = $_POST['phoneNumber'];
$email = $_POST['email'];

// Update database
$sql = "UPDATE users SET first_name=?, last_name=?, phone_number=?, email=? WHERE user_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssi", $firstName, $lastName, $phoneNumber, $email, $user_id);

if ($stmt->execute()) {
    echo "Success";
} else {
    echo "Error";
}

// Close connection
$stmt->close();
$conn->close();
?>
