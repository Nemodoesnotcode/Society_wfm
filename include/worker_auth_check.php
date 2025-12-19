<?php
// include/worker_auth_check.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the WORKER is logged in
// Ensure your worker_login script sets $_SESSION['worker_logged_in'] = true
if (!isset($_SESSION['worker_logged_in']) || $_SESSION['worker_logged_in'] !== true) {
    // Redirect to worker login page if not authenticated
    header("Location: ../pages/worker_login.html"); 
    exit;
}
?>