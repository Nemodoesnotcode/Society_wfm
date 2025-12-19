<?php
session_start();
require_once 'config/database.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $resident_id = trim($_POST['resident_id']);
    $block = trim($_POST['block']);
    $apartment_no = trim($_POST['apartment_no']);
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    
    try {
        $pdo->beginTransaction();
        
        // Get user_id from resident
        $stmt = $pdo->prepare("SELECT user_id FROM residents WHERE resident_id = ?");
        $stmt->execute([$resident_id]);
        $resident = $stmt->fetch();
        
        if (!$resident) {
            throw new Exception("Resident not found");
        }
        
        $user_id = $resident['user_id'];
        
        // Update user
        $stmt = $pdo->prepare("
            UPDATE users 
            SET name = ?, phone = ?, email = ? 
            WHERE user_id = ?
        ");
        $stmt->execute([$name, $phone, $email, $user_id]);
        
        // Update resident
        $stmt = $pdo->prepare("
            UPDATE residents 
            SET block = ?, apartment_no = ?, address = ? 
            WHERE resident_id = ?
        ");
        $address = "Block {$block}, Apartment {$apartment_no}";
        $stmt->execute([$block, $apartment_no, $address, $resident_id]);
        
        $pdo->commit();
        
        echo json_encode(['success' => true, 'message' => 'House updated successfully']);
        
    } catch (Exception $e) {
        $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>