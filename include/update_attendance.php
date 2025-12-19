<?php
header('Content-Type: application/json');
require 'config/database.php';

// Safely retrieve inputs
$id     = $_POST['attendance_id'] ?? null;
$status = $_POST['status'] ?? null;
$hours  = ($status === 'Present') ? ($_POST['hours_worked'] ?? 0) : 0;

// CRITICAL BACK-END VALIDATION 1: Missing required fields
if (empty($id) || empty($status)) {
    http_response_code(400);
    echo json_encode(['success'=>false,'message'=>'Missing required fields for update.']);
    exit;
}

// CRITICAL BACK-END VALIDATION 2: Present status requires hours > 0
if ($status === 'Present' && (float)$hours <= 0) {
    http_response_code(400); 
    echo json_encode(['success' => false, 'message' => 'ERROR: Workers marked "Present" must have more than 0 hours worked.']);
    exit;
}

try {
    $stmt = $pdo->prepare("
    UPDATE attendance SET status=?, hours_worked=? WHERE attendance_id=?
    ");
    $stmt->execute([$status, $hours, $id]);
    
    if ($stmt->rowCount() > 0) {
        echo json_encode(['success'=>true,'message'=>'Attendance updated successfully.']);
    } else {
        echo json_encode(['success'=>false,'message'=>'Record not found or no changes made.']);
    }

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success'=>false,'message'=>'Database error: ' . $e->getMessage()]);
}
?>