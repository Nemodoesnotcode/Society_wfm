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
    $name = trim($_POST['name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $cnic = trim($_POST['cnic'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $payment_type = trim($_POST['payment_type'] ?? '');
    $salary_per = floatval($_POST['salary_per'] ?? 0);
    $status = trim($_POST['status'] ?? '');
    $hired_date = trim($_POST['hired_date'] ?? '');
    $notes = trim($_POST['notes'] ?? '');
    $password = trim($_POST['password'] ?? '');
    
    // Validation
    if (empty($worker_id) || empty($name) || empty($phone) || empty($email) || empty($cnic) || empty($category) || $salary_per <= 0 || empty($status) || empty($hired_date)) {
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

    // Email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Invalid email format']);
        exit;
    }

    $conn->begin_transaction();

    try {
        // Get user_id from worker
        $stmt = $conn->prepare("SELECT user_id FROM workers WHERE worker_id = ?");
        $stmt->bind_param("i", $worker_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $worker = $result->fetch_assoc();
        
        if (!$worker) {
            throw new Exception("Worker not found");
        }
        
        $user_id = $worker['user_id'];

        // Check if email exists for another user
        $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ? AND user_id != ?");
        $stmt->bind_param("si", $email, $user_id);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            throw new Exception("Email already exists for another user");
        }

        // Check if CNIC exists for another user
        $stmt = $conn->prepare("SELECT user_id FROM users WHERE cnic = ? AND user_id != ?");
        $stmt->bind_param("si", $cnic, $user_id);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            throw new Exception("CNIC already exists for another user");
        }

        // Update user with optional password
        if (!empty($password)) {
            if (strlen($password) < 8) {
                throw new Exception("Password must be at least 8 characters");
            }
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE users SET name = ?, cnic = ?, phone = ?, email = ?, password_hash = ? WHERE user_id = ?");
            $stmt->bind_param("sssssi", $name, $cnic, $phone, $email, $password_hash, $user_id);
        } else {
            $stmt = $conn->prepare("UPDATE users SET name = ?, cnic = ?, phone = ?, email = ? WHERE user_id = ?");
            $stmt->bind_param("ssssi", $name, $cnic, $phone, $email, $user_id);
        }
        
        if (!$stmt->execute()) {
            throw new Exception("Failed to update user: " . $conn->error);
        }

        // Update worker
        $stmt = $conn->prepare("UPDATE workers SET category = ?, payment_type = ?, salary_per = ?, status = ?, notes = ?, hired_date = ? WHERE worker_id = ?");
        $stmt->bind_param("ssdsssi", $category, $payment_type, $salary_per, $status, $notes, $hired_date, $worker_id);
        
        if (!$stmt->execute()) {
            throw new Exception("Failed to update worker: " . $conn->error);
        }
        
        $conn->commit();
        echo json_encode(['success' => true, 'message' => 'Worker updated successfully']);

    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => 'Update failed: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

$conn->close();
?>