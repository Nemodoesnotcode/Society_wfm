<?php
header('Content-Type: application/json');
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['request_id'] ?? null;

    try {
        // Edge Case: Check if request is linked to an active task first
        // If your tasks table uses request_id as a foreign key:
        $check = $pdo->prepare("SELECT COUNT(*) FROM tasks WHERE request_id = ?");
        $check->execute([$id]);
        
        if ($check->fetchColumn() > 0) {
            echo json_encode(['success' => false, 'message' => 'Cannot delete. This request is already assigned to a worker.']);
            exit;
        }

        $stmt = $pdo->prepare("DELETE FROM requests WHERE request_id = ?");
        $stmt->execute([$id]);
        echo json_encode(['success' => true]);

    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database Error.']);
    }
}