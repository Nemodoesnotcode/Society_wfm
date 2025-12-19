<?php
// include/worker_login.php
session_start();
header('Content-Type: application/json');

// 1. Database Connection
$conn = new mysqli("localhost", "root", "", "society_wfm");

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 2. Get data from the fetch() call
    $worker_id = trim($_POST['worker_id'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // 3. The Query (Joining users to get the password_hash)
    $stmt = $conn->prepare("
        SELECT w.worker_id, u.name, u.password_hash 
        FROM workers w 
        JOIN users u ON w.user_id = u.user_id 
        WHERE w.worker_id = ?
    ");
    $stmt->bind_param("s", $worker_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $worker = $result->fetch_assoc();

    if ($worker) {
        // 4. THE FIX: Compare plain text directly.
        // If DB has 'hash1201' and you type 'hash1201', this WILL pass.
        if ($password === $worker['password_hash']) {
    // THIS LINE IS REQUIRED FOR THE GATEKEEPER
    $_SESSION['worker_logged_in'] = true; 
    
    $_SESSION['worker_id'] = $worker['worker_id'];
    $_SESSION['name'] = $worker['name'];
    echo json_encode(['success' => true]);
} else {
            // This triggers if the typing is wrong (e.g., 'Hash1201' vs 'hash1201')
            echo json_encode(['success' => false, 'message' => 'Invalid password']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Worker ID not found']);
    }
}
?>