<?php
header('Content-Type: application/json');
require_once 'config/database.php';

$task_id    = !empty($_POST['task_id']) ? $_POST['task_id'] : null;
$request_id = !empty($_POST['request_id']) ? $_POST['request_id'] : null;
$worker_id  = !empty($_POST['worker_id']) ? $_POST['worker_id'] : null;
$raw_date   = !empty($_POST['scheduled_date']) ? $_POST['scheduled_date'] : null;
$amount     = isset($_POST['amount']) ? (float)$_POST['amount'] : 0;

$task_date = ($raw_date) ? str_replace('T', ' ', $raw_date) : null;

if (!$request_id || !$worker_id || !$task_date) {
    echo json_encode(['success' => false, 'message' => 'Required fields missing.']);
    exit;
}

try {
    if ($task_id) {
        $stmt = $pdo->prepare("UPDATE tasks SET worker_id = ?, task_date = ?, amount = ? WHERE task_id = ?");
        $stmt->execute([$worker_id, $task_date, $amount, $task_id]);
        $message = "Task successfully updated!";
    } else {
        $pdo->beginTransaction();
        $stmt = $pdo->prepare("INSERT INTO tasks (request_id, worker_id, task_date, amount, status) VALUES (?, ?, ?, ?, 'Pending')");
        $stmt->execute([$request_id, $worker_id, $task_date, $amount]);
        $pdo->prepare("UPDATE requests SET status = 'Assigned' WHERE request_id = ?")->execute([$request_id]);
        $pdo->commit();
        $message = "Task successfully assigned!";
    }
    echo json_encode(['success' => true, 'message' => $message]);
} catch (Exception $e) {
    if (!$task_id && $pdo->inTransaction()) $pdo->rollBack();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>