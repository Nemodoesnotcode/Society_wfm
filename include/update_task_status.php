<?php
session_start();
require_once 'config/database.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['worker_id'])) {
    $task_id = trim($_POST['task_id']);
    $status = trim($_POST['status']);
    $worker_id = $_SESSION['worker_id'];
    $notes = isset($_POST['notes']) ? trim($_POST['notes']) : '';
    
    try {
        // Verify worker owns this task
        $stmt = $pdo->prepare("SELECT worker_id FROM tasks WHERE task_id = ?");
        $stmt->execute([$task_id]);
        $task = $stmt->fetch();
        
        if (!$task || $task['worker_id'] != $worker_id) {
            throw new Exception("Unauthorized access to task");
        }
        
        $completion_date = ($status === 'Completed') ? date('Y-m-d H:i:s') : null;
        
        $stmt = $pdo->prepare("
            UPDATE tasks 
            SET status = ?, completion_date = ?, notes = CONCAT(COALESCE(notes, ''), ?) 
            WHERE task_id = ?
        ");
        $stmt->execute([$status, $completion_date, "\n" . $notes, $task_id]);
        
        // Update request status
        if ($status === 'Completed') {
            $stmt = $pdo->prepare("
                UPDATE requests r
                JOIN tasks t ON r.request_id = t.request_id
                SET r.status = 'Completed'
                WHERE t.task_id = ?
            ");
            $stmt->execute([$task_id]);
        }
        
        echo json_encode(['success' => true, 'message' => 'Task status updated successfully']);
        
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request or not logged in']);
}
?>