<?php
// include/auth_check.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the admin is NOT logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // Redirect to the login page
    // Using an absolute-like path or ensuring the path is correct relative to the calling file
    header("Location: /pages/admin_login.html"); 
    exit;
}
?>