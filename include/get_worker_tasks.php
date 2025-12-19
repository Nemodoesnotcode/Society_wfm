<?php
session_start();
header('Content-Type: application/json');
require_once 'config/database.php';

// Get the worker ID from the session (logged-in user)
$worker_id = $_SESSION['worker_id'] ?? null;

if (!$worker_id) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

try {
    // Join with service_requests and residents to show the location and service type
    $stmt = $pdo->prepare("
        SELECT 
            t.task_id, 
            t.scheduled_date, 
            t.amount, 
            t.status,
            sr.category_needed as description,
            res.block,
            res.apartment_no
        FROM tasks t
        JOIN service_requests sr ON t.request_id = sr.request_id
        JOIN residents res ON sr.resident_id = res.resident_id
        WHERE t.worker_id = ?
        ORDER BY t.scheduled_date DESC
    ");
    $stmt->execute([$worker_id]);
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($tasks); // Returns array of tasks directly as expected by worker_dashboard.html

} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>