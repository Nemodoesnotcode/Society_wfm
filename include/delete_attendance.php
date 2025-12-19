<?php
header('Content-Type: application/json');
require 'config/database.php';

// Safely retrieve input
$id = $_POST['attendance_id'] ?? null;

// CRITICAL FIX: Validation for required ID
if (empty($id)) {
    http_response_code(400);
    echo json_encode(['success'=>false,'message'=>'Missing attendance ID for deletion.']);
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM attendance WHERE attendance_id=?");
    $stmt->execute([$id]);

    // FIX: Check if a deletion actually occurred
    if ($stmt->rowCount() > 0) {
        echo json_encode(['success'=>true,'message'=>'Attendance deleted successfully.']);
    } else {
        echo json_encode(['success'=>false,'message'=>'Attendance record not found.']);
    }

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success'=>false,'message'=>'Database error: ' . $e->getMessage()]);
}
?>