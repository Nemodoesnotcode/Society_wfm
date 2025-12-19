<?php
header('Content-Type: application/json');
require 'config/database.php';

try {
    // SELECT salary_per (matching your database)
    $sql = "
        SELECT w.worker_id, u.name, w.category, w.salary_per
        FROM workers w
        JOIN users u ON u.user_id = w.user_id
        WHERE w.status = 'Active'
        ORDER BY u.name ASC
    ";
    
    $stmt = $pdo->query($sql);
    $workers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Return the array directly
    echo json_encode($workers);
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}

$stmt = $pdo->query($sql);
$workers = $stmt->fetchAll(PDO::FETCH_ASSOC);

// DEBUGGING BLOCK
if (count($workers) === 0) {
    // Check if the tables even have data
    $checkWorkers = $pdo->query("SELECT COUNT(*) FROM workers")->fetchColumn();
    $checkUsers = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
    
    echo json_encode([
        "debug_message" => "Query successful but 0 rows returned",
        "total_workers_in_db" => $checkWorkers,
        "total_users_in_db" => $checkUsers,
        "query_attempted" => $sql
    ]);
    exit;
}
?>