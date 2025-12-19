<?php
header('Content-Type: application/json');
require 'config/database.php';

// Safely retrieve inputs using null coalescing operator
$worker = $_POST['worker_id'] ?? null;
$date   = $_POST['date'] ?? null;
$status = $_POST['status'] ?? null;
$hours  = ($status === 'Present') ? ($_POST['hours_worked'] ?? 0) : 0;

// CRITICAL BACK-END VALIDATION 1: Missing required fields
if (empty($worker) || empty($date) || empty($status)) {
    http_response_code(400); 
    echo json_encode(['success' => false, 'message' => 'Missing required fields (worker, date, or status).']);
    exit;
}

// CRITICAL BACK-END VALIDATION 2: Present status requires hours > 0
if ($status === 'Present' && (float)$hours <= 0) {
    http_response_code(400); 
    echo json_encode(['success' => false, 'message' => 'ERROR: Workers marked "Present" must have more than 0 hours worked.']);
    exit;
}

try {
    // prevent duplicate
    $check = $pdo->prepare("SELECT 1 FROM attendance WHERE worker_id=? AND date=?");
    $check->execute([$worker, $date]);

    if ($check->rowCount()) {
      echo json_encode(['success'=>false,'message'=>'Attendance already marked for this worker on this date.']);
      exit;
    }

    $stmt = $pdo->prepare("
    INSERT INTO attendance (worker_id,date,status,hours_worked)
    VALUES (?,?,?,?)
    ");
    $stmt->execute([$worker,$date,$status,$hours]);

    echo json_encode(['success'=>true,'message'=>'Attendance marked successfully.']);
    
} catch (PDOException $e) {
    http_response_code(500); // Server Error
    echo json_encode(['success'=>false,'message'=>'Database error: ' . $e->getMessage()]);
}
?>