<?php
// Database connection
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "sinnamdb";

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed"]));
}

// Get user ID from request
$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

// Fetch patient details
$sql = "SELECT first_name, last_name, gender, phone_number, email FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$patient = $result->fetch_assoc();

// Close connection
$stmt->close();
$conn->close();

// Return JSON data
header("Content-Type: application/json");
echo json_encode($patient);
?>
