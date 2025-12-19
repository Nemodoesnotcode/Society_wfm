<?php
// Set headers for JSON output FIRST
header('Content-Type: application/json; charset=utf-8');

// Enable error reporting but don't display them
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection details
$host = 'sql103.infinityfree.com';
$dbname = 'if0_40709922_society_wfm';
$username = 'if0_40709922';
$password = 'Nimrabutt787898';

try {
    // Create connection
    $conn = new mysqli($host, $user, $pass, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Database connection failed: " . $conn->connect_error);
    }
    
    // Set charset to UTF-8
    $conn->set_charset("utf8");
    
    // Fetch workers with all necessary fields
    $sql = "SELECT 
                w.worker_id,
                w.user_id,
                u.name,
                u.cnic,
                u.phone,
                u.email,
                w.category,
                w.payment_type,
                w.salary_per,
                w.status,
                w.hired_date,
                w.notes,
                u.password_hash as plain_password
            FROM workers w
            INNER JOIN users u ON w.user_id = u.user_id
            ORDER BY w.worker_id ASC";
    
    $result = $conn->query($sql);
    
    if (!$result) {
        throw new Exception("Query failed: " . $conn->error);
    }
    
    $workers = [];
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            // Ensure all fields have proper values
            $row['salary_per'] = floatval($row['salary_per'] ?? 0);
            $row['plain_password'] = $row['plain_password'] ?? '';
            $workers[] = $row;
        }
    }
    
    // Close connection
    $conn->close();
    
    // Output JSON
    echo json_encode($workers, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    
} catch (Exception $e) {
    // Output error as JSON
    http_response_code(500);
    echo json_encode([
        'error' => true,
        'message' => 'Failed to load workers',
        'detail' => $e->getMessage()
    ], JSON_PRETTY_PRINT);
}
?>