<?php
require_once 'config/database.php';

try {
    $sql = "SELECT r.*, u.name as resident_name, res.block, res.apartment_no 
            FROM requests r 
            LEFT JOIN residents res ON r.resident_id = res.resident_id 
            LEFT JOIN users u ON res.user_id = u.user_id 
            ORDER BY r.request_id DESC";

    $stmt = $pdo->query($sql);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $row) {
        $id = $row['request_id'];
        $status = $row['status'] ?? 'Pending';
        $badge = ($status == 'Pending') ? 'bg-warning text-dark' : 'bg-success';
        
        echo "<tr>
                <td>#$id</td>
                <td><strong>" . htmlspecialchars($row['resident_name']) . "</strong></td>
                <td>" . htmlspecialchars($row['worker_category']) . "</td>
                <td>" . htmlspecialchars($row['description'] ?: '---') . "</td>
                <td>" . date('d M, h:i A', strtotime($row['preferred_time'])) . "</td>
                <td><span class='badge $badge'>$status</span></td>
                <td>
                    <div class='btn-group'>";
        
        // --- EDGE CASE: Only show Complete button if status is Pending ---
        if ($status !== 'Completed') {
            echo "<button class='btn btn-sm btn-outline-success' title='Mark Complete' onclick='updateStatus($id, \"Completed\")'>
                    <i class='bi bi-check-lg'></i>
                  </button>";
        } else {
            // Optional: Show a checkmark icon without a button to indicate it's done
            echo "<span class='btn btn-sm btn-light disabled text-success'><i class='bi bi-check-circle-fill'></i></span>";
        }

        echo "      <button class='btn btn-sm btn-outline-danger' title='Delete' onclick='deleteRequest($id)'>
                        <i class='bi bi-trash'></i>
                    </button>
                    </div>
                </td>
              </tr>";
    }
} catch (PDOException $e) {
    echo "<tr><td colspan='7' class='text-center'>Error loading requests.</td></tr>";
}