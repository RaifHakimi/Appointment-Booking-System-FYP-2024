<?php
session_start(); // Start the session

// Database connection
include 'dbFunctions.php';
echo "<pre>";
    print_r($_SESSION); // Outputs session data
    echo "</pre>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'] ?? null; // Get user_id from session
    $date = $_POST['date'];
    $time = $_POST['time'];
    $reason = $_POST['reason'];
    $details = $_POST['details'];
    $status = "Booked";
    
    echo "<pre>";
    print_r($_POST); // Outputs session data
    echo "</pre>";
    

    // Check if user_id exists in the session
    if (!$userId) {
        echo json_encode(["success" => false, "message" => "User is not logged in."]);
        exit;
    }

    // Check if the slot is already booked
    $query = "SELECT * FROM appointment WHERE appt_date = ? AND appt_time = ?";
    $stmt = $link->prepare($query);
    $stmt->bind_param("ss", $date, $time);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(["success" => false, "message" => "This slot is already booked."]);
    } else {
        // Insert the new appointment with user_id
        $insertQuery = "INSERT INTO appointment (user_id, appt_type, appt_detail, appt_time , appt_date, status ) VALUES (?, ?, ?, ?, ?, ?)";
        $insertStmt = $link->prepare($insertQuery);
        $insertStmt->bind_param("isssss", $userId, $reason, $details, $time, $date, $status);
        printf("Query: %s\n", $insertStmt->error);
        var_dump($userId, $date, $time, $reason, $details);
        error_reporting(E_ALL);
        ini_set('display_errors', 1);


        if ($insertStmt->execute()) {
            echo json_encode(["success" => true, "message" => "Appointment booked successfully."]);
            
        } else {
            echo json_encode(["success" => false, "message" => "Failed to book appointment."]);
        }
    }
}
