<?php
header('Content-Type: application/json');
require_once 'config/database.php';

try {
    $stmt = $pdo->query("SELECT * FROM requests ORDER BY created_at DESC");
    $requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($requests);
} catch (PDOException $e) {
    echo json_encode([]);
}
?>
