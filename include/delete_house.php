<?php
session_start();
require_once 'config/database.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $resident_id = trim($_POST['resident_id']);
    
    try {
        // Get user_id first
        $stmt = $pdo->prepare("SELECT user_id FROM residents WHERE resident_id = ?");
        $stmt->execute([$resident_id]);
        $resident = $stmt->fetch();
        
        if (!$resident) {
            throw new Exception("Resident not found");
        }
        
        $user_id = $resident['user_id'];
        
        // Delete resident (this will cascade to other tables due to foreign key constraints)
        $stmt = $pdo->prepare("DELETE FROM residents WHERE resident_id = ?");
        $stmt->execute([$resident_id]);
        
        // Also delete user account
        $stmt = $pdo->prepare("DELETE FROM users WHERE user_id = ?");
        $stmt->execute([$user_id]);
        
        echo json_encode(['success' => true, 'message' => 'House deleted successfully']);
        
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>