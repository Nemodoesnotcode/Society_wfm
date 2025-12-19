<?php
// get_worker_status.php
header('Content-Type: application/json');
require_once 'config/database.php';

try {
    $stmt = $pdo->query("
        SELECT w.worker_id, u.name, w.category, w.status
        FROM workers w
        JOIN users u ON w.user_id = u.user_id
        ORDER BY u.name
    ");
    
    $workers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Optional: normalize status to match JS
    foreach ($workers as &$worker) {
        if ($worker['status'] === 'OnLeave') $worker['status'] = 'On Leave';
    }
    
    echo json_encode($workers);
} catch (PDOException $e) {
    echo json_encode([]);
}
?>
