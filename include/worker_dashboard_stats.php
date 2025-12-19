<?php
session_start();
header('Content-Type: application/json');
require_once 'config/database.php'; 

// 1. Security Check
if (!isset($_SESSION['worker_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$worker_id = $_SESSION['worker_id'];
$worker_name = $_SESSION['name'];

try {
    // 2. The Optimized Query
    // Joins 'tasks' with 'requests' for service info 
    // and 'residents' for the Block/Apartment location
    $query = "
        SELECT 
            t.task_id, 
            t.status, 
            t.task_date, 
            t.amount,
            r.worker_category AS description,
            res.block, 
            res.apartment_no
        FROM tasks t
        JOIN requests r ON t.request_id = r.request_id
        JOIN residents res ON r.resident_id = res.resident_id
        WHERE t.worker_id = ? 
        ORDER BY 
            CASE WHEN t.status = 'Pending' THEN 1 ELSE 2 END, 
            t.task_date ASC
    ";

    $stmt = $pdo->prepare($query);
    $stmt->execute([$worker_id]);
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 3. Personalized Response
    echo json_encode([
        'success' => true,
        'worker_name' => $worker_name,
        'tasks' => $tasks
    ]);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>