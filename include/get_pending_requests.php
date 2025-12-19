<?php
header('Content-Type: application/json');
require_once 'config/database.php';

try {
    // We explicitly rename worker_category to category_needed to fix the 'undefined' issue
    $sql = "SELECT r.*, 
                   r.worker_category AS category_needed, 
                   res.block, 
                   res.apartment_no 
            FROM requests r 
            JOIN residents res ON r.resident_id = res.resident_id 
            WHERE r.status = 'Pending' 
            ORDER BY r.request_id DESC";
            
    $stmt = $pdo->query($sql);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
} catch (PDOException $e) {
    echo json_encode([]);
}
?>