<?php
header('Content-Type: application/json');
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';


$task_id = !empty($_POST['task_id']) ? (int)$_POST['task_id'] : null;

if (!$task_id) {
    echo json_encode(['success' => false, 'message' => 'Task ID required.']);
    exit;
}

try {
    // Get request_id before deleting to update status
    $stmt = $pdo->prepare("SELECT request_id FROM tasks WHERE task_id = ?");
    $stmt->execute([$task_id]);
    $task = $stmt->fetch();
    
    if (!$task) {
        echo json_encode(['success' => false, 'message' => 'Task not found.']);
        exit;
    }
    
    $pdo->beginTransaction();
    
    // Delete the task
    $stmt = $pdo->prepare("DELETE FROM tasks WHERE task_id = ?");
    $stmt->execute([$task_id]);
    
    // Update request status back to Pending
    $stmt = $pdo->prepare("UPDATE requests SET status = 'Pending' WHERE request_id = ?");
    $stmt->execute([$task['request_id']]);
    
    $pdo->commit();
    
    echo json_encode(['success' => true, 'message' => 'Task deleted successfully!']);
    
} catch (Exception $e) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>