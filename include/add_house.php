<?php
session_start();
require_once 'config/database.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $block = trim($_POST['block']);
    $apartment_no = trim($_POST['apartment_no']);
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $cnic = trim($_POST['cnic']); // <-- Add CNIC here
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    
    try {
        $pdo->beginTransaction();
        
        // Check if email already exists
        $stmt = $pdo->prepare("SELECT user_id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            throw new Exception("Email already exists");
        }
        
        // Check if CNIC already exists (Good practice)
        $stmt = $pdo->prepare("SELECT user_id FROM users WHERE cnic = ?");
        $stmt->execute([$cnic]);
        if ($stmt->fetch()) {
            throw new Exception("CNIC already exists");
        }
        
        // Create user account - Updated to include cnic
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("
            INSERT INTO users (name, phone, cnic, email, role, password_hash) 
            VALUES (?, ?, ?, ?, 'resident', ?)
        ");
        $stmt->execute([$name, $phone, $cnic, $email, $password_hash]); // <-- Add $cnic here
        $user_id = $pdo->lastInsertId();
        
        // Create resident record
        $stmt = $pdo->prepare("
            INSERT INTO residents (user_id, address, block, apartment_no) 
            VALUES (?, ?, ?, ?)
        ");
        $address = "Block {$block}, Apartment {$apartment_no}";
        $stmt->execute([$user_id, $address, $block, $apartment_no]);
        
        $pdo->commit();
        
        echo json_encode([
            'success' => true, 
            'message' => 'House added successfully',
            'resident_id' => $pdo->lastInsertId()
        ]);
        
    } catch (Exception $e) {
        $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>