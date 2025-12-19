<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // For local testing

require 'config/database.php';

try {
    // Get active workers
    $sql = "
        SELECT w.worker_id, u.name, w.category
        FROM workers w
        JOIN users u ON u.user_id = w.user_id
        WHERE w.status = 'Active'
        ORDER BY u.name ASC
    ";
    
    $stmt = $pdo->query($sql);
    $workers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Standardized response format (Object containing workers array)
    echo json_encode([
        'success' => true,
        'workers' => $workers, // Contains the list of workers (may be empty array)
        'count' => count($workers)
    ]);
    
} catch (PDOException $e) {
    // Ensure error responses are valid JSON
    http_response_code(500); // Set HTTP status code for server error
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
?>