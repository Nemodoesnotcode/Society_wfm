<?php
session_start();

// Database Configuration
$host = "localhost";
$db_user = "root";
$db_pass = ""; 
$db_name = "society_wfm";

// 1. Establish Secure Connection
$conn = new mysqli($host, $db_user, $db_pass, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 2. Sanitize and Get Form Data
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$admin_type = $_POST['admin_type'] ?? '';

if (empty($email) || empty($password)) {
    header("Location: ../pages/admin_login.html?login=empty");
    exit();
}

// 3. Prepared Statement to prevent SQL Injection
// We fetch by email and ensure the role is 'admin'
$sql = "SELECT user_id, name, password_hash FROM users WHERE email = ? AND role = 'admin' LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
    /**
     * 4. Secure Password Verification
     * Note: In your SQL file, passwords like 'admin123' are stored as plain text 'hash1011'.
     * In a real system, you must use password_verify($password, $user['password_hash']).
     * For your current specific data breach fix, we compare the stored value.
     */
    if ($password === $user['password_hash'] || password_verify($password, $user['password_hash'])) {
        
        // 5. Regenerate session ID to prevent Session Fixation
        session_regenerate_id(true);

        // Set Session Variables
        $_SESSION['admin_id'] = $user['user_id'];
        $_SESSION['admin_name'] = $user['name'];
        $_SESSION['admin_type'] = $admin_type;
        $_SESSION['admin_logged_in'] = true;
        
        // Redirect to Dashboard
        header("Location: ../index.html");
        exit();
    } else {
        // Password mismatch
        header("Location: ../pages/admin_login.html?login=failed");
        exit();
    }
} else {
    // User not found or not an admin
    header("Location: ../pages/admin_login.html?login=failed");
    exit();
}

$stmt->close();
$conn->close();
?>