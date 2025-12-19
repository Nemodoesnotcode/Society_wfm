<?php
header('Content-Type: text/html; charset=utf-8');
require_once 'config/database.php'; // Using your existing database config

try {
    $sql = "SELECT p.*, u.name as worker_name, w.category 
            FROM payments p 
            JOIN workers w ON p.worker_id = w.worker_id 
            JOIN users u ON w.user_id = u.user_id 
            ORDER BY p.payment_date DESC";

    $stmt = $pdo->query($sql);
    $payments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($payments) > 0) {
        foreach ($payments as $row) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['worker_name']) . "</td>
                    <td>" . htmlspecialchars($row['category']) . "</td>
                    <td>Rs. " . number_format($row['amount'], 2) . "</td>
                    <td>" . htmlspecialchars($row['payment_method']) . "</td>
                    <td>" . htmlspecialchars($row['payment_date']) . "</td>
                  </tr>";
        }
    }
} catch (PDOException $e) {
    echo "<tr><td colspan='5'>Error: " . $e->getMessage() . "</td></tr>";
}
?>