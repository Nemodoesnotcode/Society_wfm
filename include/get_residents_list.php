<?php
header('Content-Type: application/json');
require_once 'config/database.php';

try {
    // Joining with users to get the name if residents info is in users table
    $stmt = $pdo->query("SELECT r.resident_id, u.name, r.block, r.apartment_no 
                         FROM residents r 
                         JOIN users u ON r.user_id = u.user_id 
                         ORDER BY u.name ASC");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
} catch (PDOException $e) {
    echo json_encode([]);
}
?>