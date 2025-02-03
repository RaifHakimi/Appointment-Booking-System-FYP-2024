<?php
include 'dbFunctions.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die(json_encode(['success' => false, 'message' => 'Method not allowed']));
}

$data = json_decode(file_get_contents('php://input'), true);
$appt_id = $data['appt_id'] ?? null;

if (!$appt_id) {
    echo json_encode(['success' => false, 'message' => 'Invalid appointment ID']);
    exit;
}

try {
    // Delete appointment
    $stmt = $link->prepare("DELETE FROM appointment WHERE appt_id = ?");
    $stmt->bind_param("i", $appt_id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete appointment']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}

$stmt->close();
$link->close();
?>