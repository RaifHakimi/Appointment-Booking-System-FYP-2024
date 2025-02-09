<?php
session_start();
include 'dbFunctions.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

try {
    $stmt = $link->prepare("
        INSERT INTO closed_dates 
        (date, closed_type, message, user_id, created_at, visible) 
        VALUES (?, ?, ?, ?, NOW(), 1)
    ");

    foreach ($data['dates'] as $date) {
        $stmt->bind_param('sssi', 
            $date,
            $data['reason'],
            $data['message'],
            $_SESSION['user_id']
        );
        $stmt->execute();
    }

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}