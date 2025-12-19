<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "society_wfm";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $worker_id = trim($_POST['worker_id'] ?? '');
    
    // Check for missing worker_id
    if (empty($worker_id)) {
        echo json_encode(['success' => false, 'message' => 'Worker ID is required for deletion.']);
        exit;
    }

    try {
        // Check if worker exists
        $stmt = $conn->prepare("SELECT worker_id FROM workers WHERE worker_id = ?");
        $stmt->bind_param("i", $worker_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $worker = $result->fetch_assoc();
        
        if (!$worker) {
            throw new Exception("Worker not found");
        }
        
        // Soft delete: Set worker status to 'Inactive'
        $stmt = $conn->prepare("UPDATE workers SET status = 'Inactive' WHERE worker_id = ?");
        $stmt->bind_param("i", $worker_id);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Worker deactivated successfully']);
        } else {
            throw new Exception("Failed to deactivate worker");
        }
        
    } catch (Exception $e) {
        error_log("Worker deletion error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Deactivation failed: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

$conn->close();
?>