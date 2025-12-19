<?php
session_start();
require_once 'config/database.php';

header('Content-Type: application/json');

if (!isset($_SESSION['worker_id'])) {
    echo json_encode(['error' => 'Not logged in as worker']);
    exit;
}

$worker_id = $_SESSION['worker_id'];

try {
    $stmt = $pdo->prepare("
        SELECT 
            p.payment_id,
            p.task_id,
            t.description,
            p.amount_paid,
            p.payment_date,
            p.payment_method,
            p.notes,
            p.salary_month
        FROM payments p
        LEFT JOIN tasks t ON p.task_id = t.task_id
        WHERE p.worker_id = ?
        ORDER BY p.payment_date DESC
    ");
    $stmt->execute([$worker_id]);
    $payments = $stmt->fetchAll();
    
    echo json_encode($payments);
    
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>