<?php
require_once 'config/database.php';

$id = $_POST['request_id'];
$status = $_POST['status'];

try {
    $pdo->beginTransaction();

    // 1. Update the Request
    $stmt1 = $pdo->prepare("UPDATE requests SET status = ? WHERE request_id = ?");
    $stmt1->execute([$status, $id]);

    // 2. Update any associated Task
    $stmt2 = $pdo->prepare("UPDATE tasks SET status = ? WHERE request_id = ?");
    $stmt2->execute([$status, $id]);

    $pdo->commit();
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    $pdo->rollBack();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}