<?php
include 'dbFunctions.php';


// header('Content-Type: application/json');
// header('Access-Control-Allow-Origin: your-domain.com'); 
// header('Access-Control-Allow-Methods: POST');


// Only handle POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die(json_encode(['success' => false, 'message' => 'Method not allowed']));
}
$data = json_decode(file_get_contents('php://input'), true);

$appt_id = $data['appt_id'] ?? null;
$new_date = $data['new_date'] ?? null;
$new_time = $data['new_time'] ?? null;

if (!$appt_id || !$new_date || !$new_time) {
    echo json_encode(['success' => false, 'message' => 'Invalid input.']);
    exit;
}

// Check slot availability (excluding current appointment)
$checkSql = "SELECT appt_id FROM appointment 
             WHERE appt_date = ? AND appt_time = ? AND appt_id != ?";
$stmt = $link->prepare($checkSql);
$stmt->bind_param("ssi", $new_date, $new_time, $appt_id);
$stmt->execute();
if ($stmt->get_result()->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'Time slot is taken.']);
    exit;
}

// Update appointment
$updateSql = "UPDATE appointment 
              SET appt_date = ?, appt_time = ? 
              WHERE appt_id = ?";
$stmt = $link->prepare($updateSql);
$stmt->bind_param("ssi", $new_date, $new_time, $appt_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Database error.']);
}

$stmt->close();
$link->close();
?>