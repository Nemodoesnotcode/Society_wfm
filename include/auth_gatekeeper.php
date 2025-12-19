<?php
// include/auth_gatekeeper.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check for the session variable set during your login process
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // Redirect to the login page if not authenticated
    header("Location: pages/admin_login.html"); 
    exit;
}
?>