<?php
session_start();
require_once 'config/database.php';

header('Content-Type: application/json');

try {
    $stmt = $pdo->query("
        SELECT 
            r.resident_id,
            r.block,
            r.apartment_no,
            u.name,
            u.phone,
            u.cnic,
            u.email
        FROM residents r
        JOIN users u ON r.user_id = u.user_id
        ORDER BY r.block, r.apartment_no
    ");
    $houses = $stmt->fetchAll();
    
    echo json_encode($houses);
    
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>