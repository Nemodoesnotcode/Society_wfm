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
    $name = trim($_POST['name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $cnic = trim($_POST['cnic'] ?? '');
    $password = $_POST['password'] ?? '';
    $category = trim($_POST['category'] ?? '');
    $payment_type = trim($_POST['payment_type'] ?? '');
    $salary_per = floatval($_POST['salary_per'] ?? 0);
    $status = trim($_POST['status'] ?? 'Active');
    $hired_date = trim($_POST['hired_date'] ?? date('Y-m-d'));
    $notes = trim($_POST['notes'] ?? '');
    
    // Validation
    if (empty($name) || empty($phone) || empty($email) || empty($cnic) || empty($password) || empty($category) || $salary_per <= 0) {
        echo json_encode(['success' => false, 'message' => 'All required fields must be filled']);
        exit;
    }

    // CNIC validation
    if (!preg_match('/^\d{5}-\d{7}-\d{1}$/', $cnic)) {
        echo json_encode(['success' => false, 'message' => 'CNIC must be in format: XXXXX-XXXXXXX-X']);
        exit;
    }

    // Phone validation
    if (!preg_match('/^\d{11}$/', $phone)) {
        echo json_encode(['success' => false, 'message' => 'Phone must be exactly 11 digits']);
        exit;
    }

    // Password validation
    if (strlen($password) < 8) {
        echo json_encode(['success' => false, 'message' => 'Password must be at least 8 characters']);
        exit;
    }

    // Email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Invalid email format']);
        exit;
    }

    $conn->begin_transaction();

    try {
        // Check if email exists
        $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            throw new Exception("Email already exists");
        }

        // Check if CNIC exists
        $stmt = $conn->prepare("SELECT user_id FROM users WHERE cnic = ?");
        $stmt->bind_param("s", $cnic);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            throw new Exception("CNIC already exists");
        }

        // Create user
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (name, cnic, phone, email, role, password_hash) VALUES (?, ?, ?, ?, 'worker', ?)");
        $stmt->bind_param("sssss", $name, $cnic, $phone, $email, $password_hash);
        
        if (!$stmt->execute()) {
            throw new Exception("Failed to create user: " . $conn->error);
        }
        
        $user_id = $stmt->insert_id;

        // Create worker
        $stmt = $conn->prepare("INSERT INTO workers (user_id, category, payment_type, salary_per, status, hired_date, notes) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issdsss", $user_id, $category, $payment_type, $salary_per, $status, $hired_date, $notes);
        
        if (!$stmt->execute()) {
            throw new Exception("Failed to create worker: " . $conn->error);
        }
        
        $worker_id = $stmt->insert_id;
        $conn->commit();

        echo json_encode([
            'success' => true, 
            'message' => 'Worker added successfully',
            'worker_id' => $worker_id
        ]);

    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => 'Registration failed: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

$conn->close();
?>