<?php
session_start();
require_once 'config/database.php';

header('Content-Type: application/json');

if (!isset($_SESSION['worker_id'])) {
    echo json_encode(['error' => 'Not logged in as worker']);
    exit;
}

$worker_id = $_SESSION['worker_id'];
$month = isset($_GET['month']) ? $_GET['month'] : date('Y-m');

try {
    $stmt = $pdo->prepare("
        SELECT 
            date,
            status,
            hours_worked,
            recorded_at
        FROM attendance 
        WHERE worker_id = ? AND DATE_FORMAT(date, '%Y-%m') = ?
        ORDER BY date DESC
    ");
    $stmt->execute([$worker_id, $month]);
    $attendance = $stmt->fetchAll();
    
    echo json_encode($attendance);
    
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>