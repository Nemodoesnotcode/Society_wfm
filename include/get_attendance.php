<?php
header('Content-Type: application/json');
require 'config/database.php';

$where = [];
$params = [];

// Safely retrieve inputs using null coalescing operator
$date = $_GET['date'] ?? null;
$category = $_GET['category'] ?? null;
$status = $_GET['status'] ?? null;

if (!empty($date)) {
  $where[] = "a.date = ?";
  $params[] = $date;
}
if (!empty($category)) {
  $where[] = "w.category = ?";
  $params[] = $category;
}
if (!empty($status)) {
  $where[] = "a.status = ?";
  $params[] = $status;
}

$sql = "
SELECT 
    a.attendance_id,
    a.worker_id,
    a.date,
    a.status,
    a.hours_worked,
    -- REMOVED a.recorded_at from selection based on last request
    u.name,
    w.category
FROM attendance a
JOIN workers w ON w.worker_id = a.worker_id
JOIN users u ON u.user_id = w.user_id
";

if ($where) {
    $sql .= " WHERE " . implode(" AND ", $where);
}
// NOTE: Kept ORDER BY a.recorded_at DESC for consistent ordering
$sql .= " ORDER BY a.date DESC, a.recorded_at DESC";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Standardized successful response
    echo json_encode([
        'success' => true,
        'records' => $result
    ]);
    
} catch (PDOException $e) {
    http_response_code(500); // Server Error
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
?>