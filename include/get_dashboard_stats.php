<?php
// get_dashboard_stats.php
header('Content-Type: application/json');

// Set timezone to ensure date is accurate for your region (optional, but recommended)
// date_default_timezone_set('Asia/Karachi'); // Uncomment and change to your server timezone if needed
require_once 'config/database.php'; 

// Fetch the current date in YYYY-MM-DD format based on server time
$today = date('Y-m-d');

try {
    // 1. Total workers (Static)
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM workers");
    $totalWorkers = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    // --- Dynamic Attendance Stats for TODAY ---
    
    // NOTE: Using DATE(date) assumes the 'date' column in attendance might be DATETIME.
    
    // 2. Working Today (Status = 'Present')
    $sql_working = "SELECT COUNT(attendance_id) as count FROM attendance WHERE DATE(date) = :today AND status = 'Present'";
    $stmt = $pdo->prepare($sql_working);
    $stmt->execute([':today' => $today]);
    $workingToday = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

    // 3. On Leave Today (Status = 'OnLeave')
    $sql_onleave = "SELECT COUNT(attendance_id) as count FROM attendance WHERE DATE(date) = :today AND status = 'OnLeave'";
    $stmt = $pdo->prepare($sql_onleave);
    $stmt->execute([':today' => $today]);
    $onLeave = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    
    // 4. Total Absent Today (Status = 'Absent')
    $sql_absent = "SELECT COUNT(attendance_id) as count FROM attendance WHERE DATE(date) = :today AND status = 'Absent'";
    $stmt = $pdo->prepare($sql_absent);
    $stmt->execute([':today' => $today]);
    $absentToday = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

    // 5. Total Houses (Static)
    $stmt = $pdo->query("SELECT COUNT(*) as totalHouses FROM residents");
    $totalHouses = $stmt->fetch(PDO::FETCH_ASSOC)['totalHouses'];

    // Total marked: Useful for comparison against totalWorkers
    $totalMarked = $workingToday + $onLeave + $absentToday;

    echo json_encode([
        'totalWorkers' => $totalWorkers,
        'workingToday' => $workingToday,
        'onLeave' => $onLeave,
        'totalHouses' => $totalHouses,
        'absentToday' => $absentToday, 
        'dateChecked' => $today, // Debugging helper
        'totalMarked' => $totalMarked // Added for context
    ]);
    
} catch (Exception $e) {
    error_log('Dashboard stats error: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'totalWorkers' => '0',
        'workingToday' => '0',
        'onLeave' => '0',
        'totalHouses' => '0',
        'error' => 'Could not fetch data.'
    ]);
}
?>