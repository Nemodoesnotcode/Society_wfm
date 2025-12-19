<?php
require_once 'config.php';

// Get attendance statistics for a specific date
function getAttendanceStats($date = null) {
    if (!$date) {
        $date = date('Y-m-d');
    }
    
    $conn = getDBConnection();
    
    $query = "SELECT 
                SUM(CASE WHEN status = 'Present' THEN 1 ELSE 0 END) as present,
                SUM(CASE WHEN status = 'Absent' THEN 1 ELSE 0 END) as absent,
                SUM(CASE WHEN status = 'OnLeave' THEN 1 ELSE 0 END) as onleave,
                SUM(CASE WHEN status = 'Present' THEN hours_worked ELSE 0 END) as total_hours
              FROM attendance 
              WHERE date = ?";
              
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $date);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $stats = $result->fetch_assoc();
    
    $stmt->close();
    $conn->close();
    
    return $stats;
}

// Get worker's attendance history
function getWorkerAttendanceHistory($worker_id, $limit = 30) {
    $conn = getDBConnection();
    
    $query = "SELECT * FROM attendance 
              WHERE worker_id = ? 
              ORDER BY date DESC 
              LIMIT ?";
              
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $worker_id, $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $history = [];
    while ($row = $result->fetch_assoc()) {
        $history[] = $row;
    }
    
    $stmt->close();
    $conn->close();
    
    return $history;
}

// Check if worker is available on a specific date
function isWorkerAvailable($worker_id, $date) {
    $conn = getDBConnection();
    
    $query = "SELECT status FROM attendance 
              WHERE worker_id = ? AND date = ?";
              
    $stmt = $conn->prepare($query);
    $stmt->bind_param("is", $worker_id, $date);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $available = ($row['status'] === 'Present');
    } else {
        // If no attendance marked, assume available
        $available = true;
    }
    
    $stmt->close();
    $conn->close();
    
    return $available;
}
?>