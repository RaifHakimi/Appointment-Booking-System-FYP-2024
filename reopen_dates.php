<?php
session_start();
include 'dbFunctions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $dates = $data['dates'];

    $response = ['success' => false, 'message' => ''];

    try {
        $link->begin_transaction();

        foreach ($dates as $date) {
            $sql = "UPDATE closed_dates SET visible = 0 WHERE date = ?";
            $stmt = $link->prepare($sql);
            $stmt->bind_param('s', $date);
            $stmt->execute();
        }

        $link->commit();
        $response['success'] = true;
    } catch (Exception $e) {
        $link->rollback();
        $response['message'] = 'Error: ' . $e->getMessage();
    }

    echo json_encode($response);
}
?>