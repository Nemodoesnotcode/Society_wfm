<?php
header('Content-Type: application/json');
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Edge Case: Handling missing keys
    $resident_id = $_POST['resident_id'] ?? null;
    $category    = $_POST['worker_category'] ?? null; // Updated name
    $description = $_POST['description'] ?? '';
    $time        = $_POST['preferred_time'] ?? null;

    // Edge Case: Server-side validation
    if (!$resident_id || !$category) {
        echo json_encode(['success' => false, 'message' => 'Missing Resident or Category']);
        exit;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO requests (resident_id, worker_category, description, preferred_time, status) VALUES (?, ?, ?, ?, 'Pending')");
        $stmt->execute([$resident_id, $category, $description, $time]);
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}
?>