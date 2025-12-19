<?php
header('Content-Type: application/json');
require_once 'config/database.php';

try {
    $sql = "
        SELECT 
            t.task_id, 
            t.request_id,
            u.name as worker_name, 
            r.worker_category as category_needed, 
            t.task_date, 
            t.amount, 
            t.status
        FROM tasks t
        JOIN workers w ON t.worker_id = w.worker_id
        JOIN users u ON w.user_id = u.user_id
        JOIN requests r ON t.request_id = r.request_id
        ORDER BY t.task_id DESC
    ";
    
    $stmt = $pdo->query($sql);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
} catch (PDOException $e) {
    echo json_encode([]);
}
?>