<?php
header('Content-Type: application/json');
require_once 'config/database.php';

// Check if data is coming via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $worker_id = $_POST['worker_id'] ?? null;
    $amount = $_POST['amount'] ?? null;
    $method = $_POST['payment_method'] ?? 'Cash';

    // Basic Validation
    if (!$worker_id || !$amount || $amount <= 0) {
        echo json_encode(['success' => false, 'message' => 'Please select a worker and enter a valid amount.']);
        exit;
    }

    try {
        // Insert payment record
        // Note: Assumes your table 'payments' has columns: worker_id, amount, payment_method, payment_date
        $sql = "INSERT INTO payments (worker_id, amount, payment_method, payment_date) 
                VALUES (?, ?, ?, NOW())";
        
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([$worker_id, $amount, $method]);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Payment recorded successfully!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to save payment to database.']);
        }

    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>